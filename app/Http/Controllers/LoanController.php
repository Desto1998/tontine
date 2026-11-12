<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Services\ContributionService;
use App\Services\LoanService;
use App\Services\LogService;
use App\Services\MemberService;
use App\Services\StatusService;
use Illuminate\Console\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\Factory;
use Yajra\DataTables\Facades\DataTables;

class LoanController extends Controller
{
    /**
     * Create a new controller instance.
     * @param LogService $logService
     * @param loanService $loanService
     * @param MemberService $memberService
     */
    public function __construct(private LogService $logService, private LoanService $loanService, private MemberService $memberService,
      private ContributionService $contributionService,  private StatusService $statusService,
    )
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
     * @param Loan $loan
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function edit(Loan $loan): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $members = $this->memberService->getAll();
        $contributions = $this->contributionService->getAll();
        return view('loan.loan-edit', compact('loan', 'contributions', 'members'));
    }

    /**
     * View user detail.
     * @param $id
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function show($id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $loan = $this->loanService->show($id);
        return view('loan.loan-show', compact('loan'));
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
//            'interest_type' => ['required'],
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

        $request->merge([
            'user_id' => Auth::id(),
            'status_id' => 2,
            'interest_type' => 'Pourcentage',
        ]);
//        'user_id'=>Auth::id(), 'status_id'=> 2, 'interest_type' => 'Pourcentage'
        $loan = $this->loanService->store($request->all());
        if ($loan) {
            $this->statusService->storeStatusHistory(2, 0, 'Creation', loan_id:  $loan->id);

//            $this->loanService->saveSessionMembers($request->all()['member_ids'],$session->id );
            $this->logService->save("Enregistrement", 'Loan', json_encode($loan), $loan->id);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Prét enregistrée avec succès.',
            'data' => $loan,
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

            $data = Loan::with('status')->join('users', 'loans.user_id', 'users.id')
                ->join('contributions', 'loans.contribution_id', 'contributions.id')
                ->join('members', 'members.id', 'loans.member_id')
                ->join('statuses', 'statuses.id', 'loans.status_id')
                ->where('loans.deleted_by', null)
                ->where('contributions.association_id', Auth::user()->association_id)
                ->orderBy('loans.id', 'desc');

            if (\App\Models\UserRole::checkRole('Member')){
                $data->where('loans.member_id', Auth::user()->member_id);
            }
            $data->select('loans.*', 'users.first_name as user', 'contributions.name as contribution', 'members.first_name', 'members.last_name');

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
                    $status = $this->statusService
                        ->statusBadge($value->status);

                    return $status .
                        " <br> <span class='text-dark'></span>";
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
        $request->validate([
            'amount' => ['required', 'numeric'],
            'reason' => ['required', 'string', 'max:255'],
            'type' => ['required'],
            'interest' => ['required', 'numeric'],
            'interest_amount' => ['required','numeric:'],
            'total_amount' => ['required', 'numeric'],
            'return_date' => ['required'],
            'contribution_id' => ['required', 'exists:contributions,id'],
            'member_id' => ['required', 'exists:members,id'],
//            'meeting_id' => ['required','exists:meetings,id'],
            'id' => ['required', 'numeric', 'exists:loans'],
        ]);

//        if ($validator->fails()) {
//            return response()->json(['error' => $validator->errors()]);
//        }
        $data['amount'] = $request->input('amount');
        $data['reason'] = $request->input('reason');
        $data['type'] = $request->input('type');
        $data['interest'] = $request->input('interest');
        $data['interest_amount'] = $request->input('interest_amount');
        $data['interest_type'] = 'Pourcentage';
        $data['total_amount'] = $request->input('total_amount');
        $data['return_date'] = $request->input('return_date');
        $data['contribution_id'] = $request->input('contribution_id');
        $data['member_id'] = $request->input('member_id');
        $save = $this->loanService->update($request->all()['id'], $data);
        $id = $request->all()['id'];
        $this->logService->save("Modification", 'Loan', "Modification du pret  ID: $id le" . now() . " Donne: ", $request->all()['id']);

        return redirect(route('loan.index'))->with(
            'success',
            'Demande approuvée'
        );
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


    public function approve(Loan $loan)
    {
        if ($loan->status_id > 2) {
            return back()->with(
                'danger',
                'Le statut ne permet pas de valider'
            );
        }
        $old_status = $loan->status_id;
        $loan->update([
            'status_id' => 9,
        ]);
        $this->statusService->storeStatusHistory(9, $old_status, 'Validation Pret', loan_id: $loan->id);

        $this->logService->save('VALIDATION', 'Loan', json_encode([$loan]),$loan->id );

        return back()->with(
            'success',
            'Demande approuvée'
        );
    }

    public function reject(Request $request) {
        $loan = Loan::find($request->input('id'));

        $request->validate([
            'admincomment' => 'required|string'
        ]);
        $old_status = $loan->status_id;
        $loan->update([
            'status_id' => 18
        ]);
        $this->statusService->storeStatusHistory(18, $old_status, $request->admincomment, loan_id: $loan->id);
        $this->logService->save('REJET', 'Loan', json_encode([$loan]),$loan->id );

        return response()->json([
            'status' => 'success',
            'message' => 'Demande rejetée avec succéss!',
            'data' => $loan,
        ]);
    }
}
