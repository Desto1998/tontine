<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use App\Models\Role;
use App\Models\User;
use App\Services\AgenceService;
use App\Services\LogService;
use App\Services\PermissionService;
use App\Services\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    //

    /**
     * Create a new controller instance.
     * @param LogService $logService
     * @param UserService $userService
     * @param PermissionService $permissionService
     */
    public function __construct(private LogService $logService, private UserService $userService, private PermissionService $permissionService)
    {

    }

    /**
     * Return user list view
     * @return View|Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(): View|Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('user.user-list');
    }


    /**
     * View user detail.
     * @param User $user
     * @return View|Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function show($id): View|Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $user = User::find($id);
        $PermissionIds = $this->permissionService->getUserPermissionsIds($user->id);
        $role = $this->userService->getUserRoles($user->id);
        $roles = $this->userService->getAll();
        $permissions = $this->permissionService->getAll();

        return view('user.user-show', compact('user','PermissionIds','role','roles','permissions'));
    }

    /**
     * create user .
     * @return View|Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function create()
    {
        $roles = $this->userService->getAll();
        $permissions = $this->permissionService->getAll();
        return view('user.user-create', compact('roles','permissions'));
    }

    /**
     * store user.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'numeric'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'permission_ids' => ['required'],
            'role_ids' => ['required'],
        ]);
        $data = array();
        $data['first_name'] = $request->all()['first_name'];
        $data['last_name'] = $request->all()['last_name'];
        $data['email'] = $request->all()['email'];
        $data['password'] = Hash::make($request->all()['password']) ;
        $data['phone'] = $request->all()['phone'];
        $user = $this->userService->store($data);
        if ($user) {
            $this->userService->addRole($user->id,$request->all()['role_ids']);
            $this->permissionService->storeUserPermission($user->id,$request->all()['permission_ids']);
        }
        return redirect()->route('admin.user.all')->with('success', 'Utilisateur enregistré avec succès!');;
    }

    //    region update user
    /**
     * Update user.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'numeric'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'permission_ids' => ['required'],
            'role_ids' => ['required'],
            'id' => ['required','numeric'],
        ]);
        $data = array();
        $data['first_name'] = $request->all()['first_name'];
        $data['last_name'] = $request->all()['last_name'];
        $data['email'] = $request->all()['email'];
        $data['phone'] = $request->all()['phone'];
        $id = $request->all()['id'];
        if ($this->userService->update($request->all()['id'], $data)) {
            $this->userService->addRole($id,$request->all()['role_ids']);
            $this->permissionService->storeUserPermission($id,$request->all()['permission_ids']);
            $this->logService->save("Modification", 'User', "Modification du mot de passe de l'utilisateur avec l'id: $id", $id);
            return redirect()->route('admin.user.all')->with('success','Utilisateur mise  à jour avec succès');
        }
        return redirect()->back()->with('danger','Erreur lors de la mise  à jour!');

    }

    public function updateUserPassword(Request $request): bool|\Illuminate\Http\JsonResponse
    {
        if (request()->ajax()) {
            $request->validate([
               'password' => ['required'],
               'id' => ['required','numeric'],
            ]);
            $id = $request->id;
            $user = $this->userService->updatePassword($id, Hash::make($request->all()['password']));
            $this->logService->save("Modification", 'User', "Modification du mot de passe de l'utilisateur avec l'id: $id", $id);
            return response()->json([
                'status' => 'success',
                'message' => 'Mot de passe mise à jour avec succéss!',
                'data' => $user,
            ]);
        }
        return false;
    }
//    endregion


    /**
     * Load user data on datatable.
     * @return bool|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function load(): bool|\Illuminate\Http\JsonResponse
    {
        if (request()->ajax()) {

            $data = User::where('users.deleted_at', null)
                ->orderBy('id', 'desc')
                ->select('users.*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('actionbtn', function($value){
                    $action = view('user.user-action',compact('value'));
                    return (string)$action;
                })
                ->addColumn('checkbox', function ($value) {
                    $check = view('user.user-check', compact('value'));
                    return (string)$check;
                })
                ->addColumn('online', function ($value) {
                    if ($this->userService->checkOnLineStatus($value->last_seen)) {
                        $is_online= "<span class='text-success fs-6'><i class='fa fa-circle'> Connecté</i></span>";
                    }else{
                        $is_online= "<span class='text-danger fs-6'><i class='fas fa-circle'> Hors Ligne</i></span>";
                    }
                    return $is_online;
                })
                ->addColumn('status', function ($value) {
                    if ($value->is_active) {
                        $status= "<span class='text-info'>Actif</span>";
                    }else{
                        $status= "<span class='text-danger'>Bloqué</span>";
                    }
                    return $status;
                })
                ->addColumn('role', function ($value) {

                    return $this->userService->getUserRoles($value->id);
                })
                ->rawColumns(['actionbtn','checkbox','online','status','role'])
                ->make(true);

        }
        return false;
    }

    /**
     * Delete a user.
     * @param Request $request
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request): bool|\Illuminate\Http\JsonResponse
    {
        if (request()->ajax()) {
            $id = $request->id;
            $user = $this->userService->delete($id);
            $this->logService->save("Suppression", 'User', "Suppression de l'utilisateur avec l'id: $id le" . now()." Donne: $user", $id);
            return response()->json([
                'status' => 'success',
                'message' => 'Utilisateur supprimé avec succéss!',
                'data' => $user,
            ]);
        }
        return false;
    }

//    region user profile

    public function profile($id): View|Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $user = User::find($id);
        $PermissionIds = $this->permissionService->getUserPermissionsIds($id);
        $role = $this->userService->getUserRoles($id);
        $roles = $this->userService->getAll();
        $permissions = $this->permissionService->getAll();
        return view('user.profil.profile', compact('user','PermissionIds','role','roles','permissions'));
    }


    public function updateProfile(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'numeric'],
            'email' => ['required', 'string', 'email', 'max:255',],
            'id' => ['required','numeric'],
        ]);
        $checkemail = User::where('email', $request->all()['email'])->where('id', '!=', $request->all()['id'])->get();
        if (count($checkemail) > 0) {
            return redirect()->back()->with('warning', 'Cette adresse E-mail est déja utilisé par un autre.');
        }
        $data = array();
        $data['first_name'] = $request->all()['first_name'];
        $data['last_name'] = $request->all()['last_name'];
        $data['email'] = $request->all()['email'];
        $data['phone'] = $request->all()['phone'];
        if ($this->userService->update($request->all()['id'], $data)) {
            $this->logService->save("Modification", 'User', "Modification du profil par l'utilisateur avec l'id: ", $request->all()['id']);
            return redirect()->back()->with('success','Profil mise  à jour avec succès');
        }
        return redirect()->back()->with('danger','Une erreur s\'est produite');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'oldpassword' => ['string', 'min:6'],
            'id' => ['required','numeric'],
        ]);
        $current_user_password = Auth::user()->password;
        if (empty($request->oldpassword) || Hash::check($request->oldpassword, $current_user_password) == true) {
//            $user = User::where('id', $request->userid)->update([
//                'password' => Hash::make($request->password),
//            ]);
            $id = $request->id;
            $user = $this->userService->updatePassword($id, Hash::make($request->all()['password']));
            $this->logService->save("Modification", 'User', "Modification de son mot de passe, utilisateur avec ID: $id le" . now()." Donne: $user", $id);

        } else {
            session()->flash('message', 'Ancien mot de passe incorrect!');
            return redirect()->back()->with('error', 'Ancien mot de passe incorrect!');
        }
        if ($user) {
            return redirect()->back()->with('success', 'Modifications enregistrées avec succès!');
        }

        return redirect()->back()->with('danger', "Désolé une erreur s'est produite. Veillez recommencer!");

//
    }

    public function updateImage(Request $request): \Illuminate\Http\RedirectResponse
    {
        $file = $request->file('logo');

        $request->validate([
            'logo.*' => 'mimes:jpeg,png,jpg,gif,svg',
            'id' => ['required','numeric']
        ]);
        $destinationPath = 'images/profil';
        $originalFile = $file->getClientOriginalName();
        $file->move($destinationPath, $originalFile);
        $id = $request->id;

        $user = $this->userService->updateImage($id, $originalFile);
        $this->logService->save("Modification", 'User', "Modification de l'image de profil, utilisateur avec ID: $id le" . now()." Donne: $originalFile", $id);

        if ($user) {
            return redirect()->back()->with('success','Enregistré avec succès!');
        }else{
            return redirect()->back()->with('danger',"Désolé une erreur s'est produit! Veillez reéssayer.");
        }

    }

    public function activate($id): \Illuminate\Http\RedirectResponse
    {
        $data = "";
        $data = User::where('id', $id)->update(['is_active' => 1]);
//        return Response()->json($data);
        return redirect()->back()->with('success','Le compte a été activé avec succès!');

    }


    public function block($id): \Illuminate\Http\RedirectResponse
    {
        $data = "";
        $data = User::where('id', $id)->update(['is_active' => 0]);
//        return Response()->json($data);
        return redirect()->back()->with('success','Le compte a été bloqué avec succès!');

    }

//     endregion

    public function setEnvironmentValue($envKey, $envValue)
    {
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);

        $oldValue = strtok($str, "{$envKey}=");

        $str = str_replace("{$envKey}={$oldValue}", "{$envKey}={$envValue}\n", $str);

        $fp = fopen($envFile, 'w');
        fwrite($fp, $str);
        fclose($fp);
    }

    public function setDeployDate($date)
    {
        $this->setEnvironmentValue('DEPLOY_DATE',  $date);

    }
    public function setDeployYear($year)
    {
        $this->setEnvironmentValue('DEPLOY_YEAR',  $year);

    }

    public function setLicenceDays($number)
    {
        $this->setEnvironmentValue('LICENCE_DURATION',  $number);

    }
}
