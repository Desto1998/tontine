<?php

namespace App\Http\Controllers;

use App\Models\Association;
use App\Services\AssociationService;
use App\Services\LogService;
use App\Services\MemberService;
use App\Services\UserService;
use DataTables;
use Illuminate\Console\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\Factory;
use Validator;
use Illuminate\Contracts\View\View;

class AssociationController extends Controller
{
    //
    /**
     * Create a new controller instance.
     * @param LogService $logService
     * @param AssociationService $associationService
     * @param UserService $userService
     * @param MemberService $memberService
     */
    public function __construct(private LogService $logService, private AssociationService $associationService, private UserService $userService, private MemberService $memberService)
    {
    }

    /**
     * Return user list view
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('association.association-list');
    }


    /**
     * View user detail.
     * @param $id
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function show($id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('association.association-show');
    }

    /**
     * store user.
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['string','min:5','max:255'],
            'phone' => ['required', 'string', 'min:9','max:14'],
            'email' => ['required', 'email','unique:users,email'],
            'country' => ['required'],
            'town' => ['required'],
//            'description' => ['required'],
            'first_name' => ['required','min:3','max:255'],
            'last_name' => ['required','string', 'min:5','max:255'],
            'password' => ['required','string', 'min:8','max:255'],
        ]);

        if ($validator->fails())
        {
            return response()->json(['error'=>$validator->errors()]);
        }
        $data = array();
        $data['first_name'] = $request->input('first_name');
        $data['last_name'] = $request->input('last_name');
        $data['password'] = Hash::make($request->input('password'));
        $data['phone'] = $request->input('phone');
        $data['email'] = $request->input('email');
        $data['city'] = $request->input('town');
        $data['address'] = $request->input('address');
//        $data['address'] = $request->input('address');


        $save = $this->associationService->store($request->all());
        if ($save) {
            $this->logService->save("Enregistrement", 'Association', "Enregistrement d'une association ID: $save->id le" . now()." Donne: $save", $save->id);
            $data['association_id'] = $save->id;
            $data['has_fund'] = 1;
            $data['fund_amount'] = 0;

            $member = $this->memberService->store($data);

            $data['member_id'] = $member->id;
            $user = $this->userService->store($data);
            $this->logService->save("Enregistrement", 'Member', "Enregistrement d'un membre ID: $member->id le" . now()." Donne: $member", $member->id);
            $this->logService->save("Enregistrement", 'User', "Enregistrement d'un utilisateur ID: $user->id le" . now()." Donne: $user", $user->id);

            $role = $this->userService->getRoleByTitle('President');
            $this->userService->addRole($user->id,[$role->id]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Association enregistrée avec succès.',
            'data' => $save,
        ]);

    }

    /**
     * Load user data on datatable.
     * @return bool|JsonResponse
     * @throws \Exception
     */
    public function load(): bool|JsonResponse
    {
        if (request()->ajax()) {

            $data = Association::where('deleted_at', null);
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('actionbtn', function($value){

                    $action = view('association.association-action',compact('value'));
                    return (string)$action;
                })
                ->addColumn('checkbox', function ($value) {
                    $id = $value->id;
                    $check = view('layouts.partials._checkbox', compact('id'));
                    return (string)$check;
                })
                ->addColumn('created', function($value){
                    return $this->logService->formatCreatedAt($value->created_at);
                })
                ->rawColumns(['actionbtn','checkbox','created'])
                ->make(true);

        }
        return false;
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['string','min:5','max:255'],
            'phone' => ['required', 'string', 'min:9','max:14'],
            'email' => ['required', 'email'],
            'country' => ['required'],
            'town' => ['required'],
//            'description' => ['required'],
//            'fist_name' => ['required'],
//            'last_name' => ['required','string', 'min:5','max:255'],
            'id' => ['required','int','exists:associations'],
        ]);

        if ($validator->fails())
        {
            return response()->json(['error'=>$validator->errors()]);
        }
        $save = $this->associationService->update($request->all()['id'],$request->all());
        $id = $request->all()['id'];
        $this->logService->save("Modification", 'Association', "Modification des informations l'association ID: $id le" . now()." Donne: ", $request->all()['id']);

        return response()->json([
            'status' => 'success',
            'message' => 'Modifié avec succès.',
            'data' => $save,
        ]);
    }

    /**
     * Delete a user.
     * @param Request $request
     * @return bool|JsonResponse
     */
    public function destroy(Request $request): bool|JsonResponse
    {
        if (request()->ajax()) {
            $id = $request->input('id');
            $deleted = $this->associationService->delete($id);
            $this->logService->save("Suppression", 'Association', "Suppression de l'association avec l'id: $id le" . now()." Donne: $deleted", $id);

            return response()->json([
                'status' => 'success',
                'message' => 'Association supprimé avec succéss!',
                'data' => $deleted,
            ]);
        }
        return false;
    }

    /**
     * Return user list view
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function editForm(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('association.association-list');
    }

    public function updateMy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['string','min:5','max:255'],
            'phone' => ['required', 'string', 'min:9','max:14'],
            'email' => ['required', 'email'],
            'country' => ['required'],
            'town' => ['required'],
            'description' => ['required'],
            'fist_name' => ['required'],
            'last_name' => ['required','string', 'min:5','max:255'],
            'id' => ['required','int','exists:associations'],
        ]);

        if ($validator->fails())
        {
            return response()->json(['error'=>$validator->errors()]);
        }
        $save = $this->associationService->update($request->all()['id'],$request->all());
        $id = $request->all()['id'];
        $this->logService->save("Modification", 'Association', "Modification des informations l'association ID: $id le" . now()." Donne: ", $request->all()['id']);

        return response()->json([
            'status' => 'success',
            'message' => 'Modifié avec succès.',
            'data' => $save,
        ]);
    }
}
