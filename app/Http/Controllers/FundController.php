<?php

namespace App\Http\Controllers;

use App\Models\Fund;
use App\Models\Member;
use App\Services\AssociationService;
use App\Services\FundService;
use App\Services\LogService;
use App\Services\MemberService;
use App\Services\UserService;
use DataTables;
use Illuminate\Console\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\Factory;
use Validator;

class FundController extends Controller
{
    //
    /**
     * Create a new controller instance.
     * @param LogService $logService
     * @param FundService $fundService
     */
    public function __construct(private LogService $logService,  private FundService $fundService)
    {
    }

    /**
     * Return user list view
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('fund.fund-list');
    }


    /**
     * View user detail.
     * @param $id
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function show($id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $fund = $this->fundService->show($id);
        return view('fund.fund-show',compact('fund'));
    }

    /**
     * store user.
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => ['required','numeric','min:0'],
            'description' => ['string'],
            'member_id' => ['required', 'integer', 'exists:members,id'],

        ]);

        if ($validator->fails())
        {
            return response()->json(['error'=>$validator->errors()]);
        }
        $request->all()['association_id'] = \Auth::user()->association_id;
        $request->all()['user_id'] = \Auth::user()->id;


        $member = $this->fundService->store($request->all());
        if ($member) {
            $this->logService->save("Enregistrement", 'Fund', "Enregistrement d'un fond ID: $member->id le" . now()." Donne: $member", $member->id);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Fond enregistrée avec succès.',
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

            $data = Fund::where('funds.deleted_by', null)
                ->join('members','funds.member_id','users.id')
                ->join('users','funds.user_id','users.id')
                ->orderBy('funds.id', 'desc')
                ->select('funds.*','members.first_name as member','users.first_name as user');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('actionbtn', function($value){

                    $action = view('fund.fund-action',compact('value'));
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
            'amount' => ['required','numeric','min:0'],
            'description' => ['string'],
            'member_id' => ['required', 'integer', 'exists:members,id'],
            'id' => ['required','numeric', 'exists:funds'],
        ]);

        if ($validator->fails())
        {
            return response()->json(['error'=>$validator->errors()]);
        }

        $save = $this->fundService->update($request->all()['id'],$request->all());
        $id = $request->all()['id'];
        $this->logService->save("Modification", 'Fund', "Modification des informations du fond ID: $id le" . now()." Donne: ", $request->all()['id']);

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
            $deleted = $this->fundService->delete($id);
            $this->logService->save("Suppression", 'Fund', "Suppression de fond avec l'id: $id le" . now()." Donne: $deleted", $id);

            return response()->json([
                'status' => 'success',
                'message' => 'Fond supprimé avec succéss!',
                'data' => $deleted,
            ]);
        }
        return false;
    }
}
