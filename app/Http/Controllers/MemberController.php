<?php

namespace App\Http\Controllers;

use App\Models\Association;
use App\Models\Member;
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

class MemberController extends Controller
{
    //
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
        return view('member.member-list');
    }


    /**
     * View user detail.
     * @param $id
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function show($id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('member.member-show');
    }

    /**
     * store user.
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required','string','min:3','max:255'],
            'last_name' => ['required','string','min:3','max:255'],
            'phone' => ['required', 'string', 'min:9','max:14'],
            'address' => ['required'],
            'city' => ['required'],
            'fund_amount' => ['required','numeric'],
//            'has_fund' => ['required'],
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
        $data['city'] = $request->input('city');
        $data['address'] = $request->input('address');
        $data['association_id'] = \Auth::user()->association_id;
//        $data['has_fund'] = $request->input('has_fund');
        $data['fund_amount'] = $request->input('fund_amount');
        $member = $this->memberService->store($data);
        if ($member) {
            $this->logService->save("Enregistrement", 'Member', "Enregistrement d'un membre ID: $member->id le" . now()." Donne: $member", $member->id);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Membre enregistrée avec succès.',
            'data' => $member,
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

            $data = Member::where('association_id',\Auth::user()->association_id)
                ->where('members.deleted_at', null)
//                ->join('users','members.user_id','users.id')
                ->orderBy('members.id', 'desc')
                ->select('members.*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('actionbtn', function($value){

                    $action = view('member.member-action',compact('value'));
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
            'first_name' => ['required','string','min:5','max:255'],
            'last_name' => ['required','string','min:5','max:255'],
            'phone' => ['required', 'string', 'min:9','max:14'],
            'address' => ['required'],
            'city' => ['required'],
            'fund_amount' => ['required','numeric'],
//            'has_fund' => ['required'],
            'id' => ['required','numeric', 'exists:members'],
        ]);

        if ($validator->fails())
        {
            return response()->json(['error'=>$validator->errors()]);
        }
        $data = array();
        $data['first_name'] = $request->input('first_name');
        $data['last_name'] = $request->input('last_name');
        $data['phone'] = $request->input('phone');
        $data['city'] = $request->input('city');
        $data['address'] = $request->input('address');
        $data['fund_amount'] = $request->input('fund_amount');
        $save = $this->memberService->update($request->all()['id'],$data);
        $id = $request->all()['id'];
        $this->logService->save("Modification", 'Member', "Modification des informations du membre ID: $id le" . now()." Donne: ", $request->all()['id']);

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
            $deleted = $this->memberService->delete($id);
            $this->logService->save("Suppression", 'Membre', "Suppression de l'association avec l'id: $id le" . now()." Donne: $deleted", $id);

            return response()->json([
                'status' => 'success',
                'message' => 'Membre supprimé avec succéss!',
                'data' => $deleted,
            ]);
        }
        return false;
    }
}
