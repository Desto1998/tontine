<?php


namespace App\Services;


use App\Models\Withdrawal;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class WithdrawalService
{
    /**
     * Get all Withdrawal
     * @return Collection
     */
    public function getAll() : Collection
    {
        return Withdrawal::orderBy('id')->get();
    }

    /**
     * store an Withdrawal
     *
     * @param $data
     * @return Withdrawal
     */
    public function store($data): Withdrawal
    {
        return Withdrawal::Withdrawal($data);
    }

    /**
     * Update Withdrawal
     *
     * @param $id
     * @param $data
     * @return Withdrawal
     */

    public function update($id,$data): Withdrawal
    {
        return Withdrawal::where('id',$id)->update($data);
    }

    /**
     * Get a partner
     *
     * @param $id
     * @return Withdrawal|BelongsTo
     */

    public function show($id): Withdrawal|BelongsTo
    {
        return Withdrawal::find($id)->with('loan');
    }

    /**
     * Delete Withdrawal
     * @param $id
     * @return bool
     */
    public function delete($id) : bool
    {
        $find = Withdrawal::find($id);
        $find->deleted_by = Auth::id();
        return $find->save();

    }
}
