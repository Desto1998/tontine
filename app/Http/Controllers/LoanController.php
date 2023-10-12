<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Services\LoanService;
use App\Services\LogService;
use DataTables;
use Illuminate\Console\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\Factory;
use Validator;

class LoanController extends Controller
{
    /**
     * Create a new controller instance.
     * @param LogService $logService
     * @param loanService $loanService
     */
    public function __construct(private LogService $logService, private LoanService $loanService)
    {
    }

    /**
     * Return user list view
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('loan.loan-list');
    }

    /**
     * create.
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
//        $session = $this->loanService->show($id);
        return view('loan.loan-create');
    }

    /**
     * View user detail.
     * @param $id
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function show($id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $session = $this->loanService->show($id);
        return view('session.session-edit',compact('session'));
    }

    /**
     * store user.
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => ['required','numeric'],
            'reason' => ['required','string','max:255'],
            'type' => ['required'],
            'interest' => ['required','numeric'],
            'interest_type' => ['required'],
            'total_amount' => ['required','numeric'],
            'return_date' => ['required'],
            'contribution_id' => ['required','exists:contributions,id'],
            'member_id' => ['required','exists:members,id'],
            'meeting_id' => ['required','exists:meetings,id'],

        ]);

        if ($validator->fails())
        {
            return response()->json(['error'=>$validator->errors()]);
        }
//        $request->all()['association_id'] = \Auth::user()->association_id;
        $request->all()['user_id'] = \Auth::user()->id;

        $session = $this->loanService->store($request->all());
        if ($session) {
//            $this->loanService->saveSessionMembers($request->all()['member_ids'],$session->id );
            $this->logService->save("Enregistrement", 'Loan', "Enregistrement d'un pret ID: $session->id le" . now()." Donne: $session", $session->id);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Prét enregistrée avec succès.',
            'data' => $session,
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

            $data = Loan::join('users','loans.user_id','loans.id')
                ->join('contributions','loans.contribution_id','contributions.id')
                ->where('loans.deleted_by', null)
//                ->where('contributions.association_id', \Auth::user()->association_id)
                ->orderBy('loans.id', 'desc')
                ->select('loans.*','users.first_name as user','contributions.name as contribution');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('actionbtn', function($value){

                    $action = view('loan.loan-action',compact('value'));
                    return (string)$action;
                })
                ->addColumn('checkbox', function ($value) {
                    $id = $value->id;
                    $check = view( 'layouts.partials._checkbox', compact('id'));
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
            'amount' => ['required','numeric'],
            'reason' => ['required','string','max:255'],
            'type' => ['required'],
            'interest' => ['required','numeric'],
            'interest_type' => ['required'],
            'total_amount' => ['required','numeric'],
            'return_date' => ['required'],
            'contribution_id' => ['required','exists:contributions,id'],
            'member_id' => ['required','exists:members,id'],
            'meeting_id' => ['required','exists:meetings,id'],
            'id' => ['required','numeric', 'exists:sessions'],
        ]);

        if ($validator->fails())
        {
            return response()->json(['error'=>$validator->errors()]);
        }

        $save = $this->loanService->update($request->all()['id'],$request->all());
        $id = $request->all()['id'];
        $this->logService->save("Modification", 'Loan', "Modification du pret  ID: $id le" . now()." Donne: ", $request->all()['id']);

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
            $deleted = $this->loanService->delete($id);
            $this->logService->save("Suppression", 'Loan', "Suppression du pret avec l'id: $id le" . now()." Donne: $deleted", $id);

            return response()->json([
                'status' => 'success',
                'message' => 'Prét supprimé avec succéss!',
                'data' => $deleted,
            ]);
        }
        return false;
    }


}
