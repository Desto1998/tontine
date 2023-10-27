<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Services\ContributionService;
use App\Services\LoanService;
use App\Services\LogService;
use App\Services\MemberService;
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
     * @param MemberService $memberService
     */
    public function __construct(private LogService $logService, private LoanService $loanService, private MemberService $memberService, private ContributionService $contributionService)
    {
    }

    /**
     * Return user list view
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $members = $this->memberService->getAll();
        $contributions = $this->contributionService->getAll();
        return view('loan.loan-list', compact('members', 'contributions'));
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
        return view('session.session-edit', compact('session'));
    }

    /**
     * store user.
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => ['required', 'numeric'],
            'reason' => ['required', 'string', 'max:255'],
            'type' => ['required'],
            'interest' => ['required', 'numeric'],
            'interest_type' => ['required'],
            'total_amount' => ['required', 'numeric'],
            'return_date' => ['required'],
            'contribution_id' => ['required', 'exists:contributions,id'],
            'member_id' => ['required', 'exists:members,id'],
//            'meeting_id' => ['required','exists:meetings,id'],

        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }
//        $request->all()['association_id'] = \Auth::user()->association_id;
        $request->all()['user_id'] = \Auth::user()->id;

        $session = $this->loanService->store($request->all());
        if ($session) {
//            $this->loanService->saveSessionMembers($request->all()['member_ids'],$session->id );
            $this->logService->save("Enregistrement", 'Loan', "Enregistrement d'un pret ID: $session->id le" . now() . " Donne: $session", $session->id);
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

            $data = Loan::join('users', 'loans.user_id', 'users.id')
                ->join('contributions', 'loans.contribution_id', 'contributions.id')
                ->join('members', 'members.id', 'loans.member_id')
                ->where('loans.deleted_by', null)
                ->where('contributions.association_id', \Auth::user()->association_id)
                ->orderBy('loans.id', 'desc')
                ->select('loans.*', 'users.first_name as user', 'contributions.name as contribution', 'members.first_name', 'members.last_name');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('actionbtn', function ($value) {
                    $members = $this->memberService->getAll();
                    $contributions = $this->contributionService->getAll();
                    $action = view('loan.loan-action', compact('value', 'members', 'contributions'));
                    return (string)$action;
                })
                ->addColumn('checkbox', function ($value) {
                    $id = $value->id;
                    $check = view('layouts.partials._checkbox', compact('id'));
                    return (string)$check;
                })
                ->addColumn('member', function ($value) {
                    return $value->first_name . ' ' . $value->last_name;
                })
                ->addColumn('statute', function ($value) {
                    return $value->status ? "<span class='text-warning'>En attente</span>" : "<span class='text-warning'>Remboursé</span>";
                })
                ->addColumn('created', function ($value) {
                    return $this->logService->formatCreatedAt($value->created_at);
                })
                ->rawColumns(['actionbtn', 'checkbox', 'created', 'member','statute'])
                ->make(true);

        }
        return false;
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => ['required', 'numeric'],
            'reason' => ['required', 'string', 'max:255'],
            'type' => ['required'],
            'interest' => ['required', 'numeric'],
            'interest_type' => ['required'],
            'total_amount' => ['required', 'numeric'],
            'return_date' => ['required'],
            'contribution_id' => ['required', 'exists:contributions,id'],
            'member_id' => ['required', 'exists:members,id'],
//            'meeting_id' => ['required','exists:meetings,id'],
            'id' => ['required', 'numeric', 'exists:loans'],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }
        $data['amount'] = $request->input('amount');
        $data['reason'] = $request->input('reason');
        $data['type'] = $request->input('type');
        $data['interest'] = $request->input('interest');
        $data['interest_type'] = $request->input('interest_type');
        $data['total_amount'] = $request->input('total_amount');
        $data['return_date'] = $request->input('return_date');
        $data['contribution_id'] = $request->input('contribution_id');
        $data['member_id'] = $request->input('member_id');
        $save = $this->loanService->update($request->all()['id'], $data);
        $id = $request->all()['id'];
        $this->logService->save("Modification", 'Loan', "Modification du pret  ID: $id le" . now() . " Donne: ", $request->all()['id']);

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
            $this->logService->save("Suppression", 'Loan', "Suppression du pret avec l'id: $id le" . now() . " Donne: $deleted", $id);

            return response()->json([
                'status' => 'success',
                'message' => 'Prét supprimé avec succéss!',
                'data' => $deleted,
            ]);
        }
        return false;
    }


}
