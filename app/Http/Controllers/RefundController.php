<?php

namespace App\Http\Controllers;

use App\Http\Requests\RefundRequest;
use App\Models\Refund;
use App\Models\Loan;
use App\Services\LoanService;
use App\Services\LogService;
use App\Services\StatusService;
use Exception;
use FontLib\Table\Type\prep;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class RefundController extends Controller
{

    /**
     * Create a new controller instance.
     * @param LogService $logService
     * @param StatusService $statusService
     * @param LoanService $loanService
     */
    public function __construct(private LogService $logService, private StatusService $statusService, private LoanService $loanService)
    {
    }


    public function index()
    {
        $refunds = Refund::with('loan')
            ->latest()
            ->paginate(15);

        return view('refund.refund-list', compact('refunds'));
    }

    /**
     * Load user data on datatable.
     * @return bool|JsonResponse
     * @throws \Exception
     */
    public function load(): bool|JsonResponse
    {
        if (request()->ajax()) {

            $data = Refund::with('loan','status')->join('users', 'refunds.user_id', 'users.id')
                ->join('loans', 'refunds.loan_id', 'loans.id')
                ->join('contributions', 'contributions.id', 'loans.contribution_id')
                ->join('members', 'members.id', 'loans.member_id')
                ->where('refunds.deleted_by', null)
                ->where('users.association_id', Auth::user()->association_id);
//                ->orderBy('ref.id', 'desc');

            if (\App\Models\UserRole::checkRole('Member')){
                $data->where('loans.member_id', Auth::user()->member_id);
            }
            $data->select('refunds.*', 'users.first_name as user', 'members.first_name', 'members.last_name');

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('actionbtn', function ($value) {

                    $loans = Loan::where('status_id', '<', 5)->orderBy('id', 'desc')->get();
                    $action = view('refund.refund-action', compact('value', 'loans'));
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
                ->addColumn('statut', function ($value) {
                    $status = $this->statusService
                        ->statusBadge($value->status);

                    return $status .
                        " <br> <span class='text-dark'></span>";
                })
                ->addColumn('created', function ($value) {
                    return $this->logService->formatCreatedAt($value->created_at);
                })
                ->rawColumns(['actionbtn', 'checkbox', 'created', 'member','statut'])
                ->make(true);

        }
        return false;
    }


    public function create()
    {
        $loans = Loan::with('member')->where('status_id', '<', 5)->orderBy('id', 'desc')->get();
        $loans = $this->loanService->loanNotRefund();
        return view('refund.refund-create', compact('loans'));
    }

    public function store(RefundRequest $request)
    {

        try {

//            dd($request->validated());
            $refund = Refund::create($request->validated());
            $loan  = Loan::find($request->loan_id);
            $loan->real_return_date = date('Y-m-d');
            if ($request->amount == $loan->total_amount){
                $loan->status_id = 8;
            }
            $loan->save();

            $this->statusService->storeStatusHistory(2, 1, 'Creation', refund_id: $refund->id);
            $this->logService->save('CREATION', 'Refund', json_encode([$refund]),$refund->id );
            return redirect()
                ->route('refunds.index')
                ->with('success', 'Remboursement enregistré avec succès.');

        } catch (Exception $e) {

            return back()
                ->withInput()
                ->with('error', 'Erreur lors de l\'enregistrement : '.$e->getMessage());
        }
    }

    public function show(Refund $refund)
    {
        return view('refund.refund-show', compact('refund'));
    }

    public function edit(Refund $refund)
    {
        $loans = Loan::orderBy('id', 'desc')->get();

        return view('refund.refund-edit', compact('refund', 'loans'));
    }

    public function update(RefundRequest $request, Refund $refund)
    {
        try {

            $refund->update($request->validated());

            return redirect()
                ->route('refunds.index')
                ->with('success', 'Remboursement modifié avec succès.');

        } catch (Exception $e) {

            return back()
                ->withInput()
                ->with('error', 'Erreur lors de la modification : '.$e->getMessage());
        }
    }

    public function destroy(Refund $refund)
    {
        try {

            $refund->delete();

            return redirect()
                ->route('refunds.index')
                ->with('success', 'Remboursement supprimé avec succès.');

        } catch (Exception $e) {

            return redirect()
                ->route('refunds.index')
                ->with('error', 'Erreur lors de la suppression : '.$e->getMessage());
        }
    }

    public function approve(Refund $refund)
    {
        if ($refund->status_id > 2) {
            return back()->with(
                'danger',
                'Le statut ne permet pas de valider'
            );
        }
        $old_status = $refund->status_id;
        $refund->update([
            'status_id' => 9,
        ]);
        $this->statusService->storeStatusHistory(9, $old_status, 'Validation Remboursement', refund_id: $refund->id);

        $this->logService->save('VALIDATION', 'Refund', json_encode([$refund]),$refund->id );

        return back()->with(
            'success',
            'Demande approuvée'
        );
    }

    public function reject(Request $request) {
        $refund = Refund::find($request->input('id'));

        $request->validate([
            'admincomment' => 'required|string'
        ]);
        $old_status = $refund->status_id;
        $refund->update([
            'status_id' => 18
        ]);
        $this->statusService->storeStatusHistory(18, $old_status, $request->admincomment, refund_id: $refund->id);
        $this->logService->save('REJET', 'Refund', json_encode([$refund]),$refund->id );

        return response()->json([
            'status' => 'success',
            'message' => 'Demande rejetée avec succéss!',
            'data' => $refund,
        ]);
    }
}
