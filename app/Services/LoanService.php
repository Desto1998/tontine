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
        return Loan::where('deleted_by')->orderBy('id')->get();
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
     * @return Loan
     */

    public function update($id,$data): Loan
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
        $find->deleted_at = date('Y-m-d H:i:s');
//        $driver->deleted_by = \auth()->id();
        return $find->save();

    }
}
