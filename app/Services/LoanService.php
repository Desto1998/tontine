<?php


namespace App\Services;


use App\Models\Loan;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoanService
{
    /**
     * Get all orders
     * @return Collection
     */
    public function getAll() : Collection
    {
        return Loan::orderBy('id')->get();
    }

    /**
     * store an Loan
     *
     * @param $data
     * @return Loan
     */
    public function store($data): Loan
    {
        return Loan::create($data);
    }

    /**
     * Update Loan
     *
     * @param $id
     * @param $data
     * @return bool
     */

    public function update($id,$data): bool
    {
        return Loan::where('id',$id)->update($data);
    }

    /**
     * Get a partner
     *
     * @param $id
     * @return Loan|BelongsTo
     */

    public function show($id): Loan|BelongsTo
    {
        //        $data['user'] = Orders::find($id)->user;
//        $data['partner'] = Orders::find($id)->partner;
//        $data['driver'] = Orders::find($id)->driver;
        return Loan::find($id)->with('association');
    }

    /**
     * Delete association
     * @param $id
     * @return bool
     */
    public function delete($id) : bool
    {
        $find = Loan::find($id);
//        $find->deleted_at = date('Y-m-d H:i:s');
        $find->deleted_by = \auth()->id();
        return $find->save();

    }

    /**
     * Avoir les prèts non remboursés
     * @return \Illuminate\Support\Collection|Collection
     */
    public function loanNotRefund() : Collection|\Illuminate\Support\Collection
    {
//        $loans = Loan::leftJoin('refunds', 'loans.id', '=', 'refunds.loan_id')
//            ->selectRaw('loans.*, COALESCE(SUM(refunds.amount), 0) as total_refunded')
//            ->groupBy('loans.id')
//            ->havingRaw('total_refunded < loans.amount')
//            ->get();
        return Loan::with('member')->withSum('refunds', 'amount')
            ->where('status_id', '<', 5)->orderBy('id', 'desc')
            ->get()
            ->filter(function ($loan) {
                return ($loan->refunds_sum_amount ?? 0) < $loan->total_amount;
            });

    }
}
