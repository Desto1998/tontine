<?php


namespace App\Services;


use App\Models\Refund;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class RefundService
{
    /**
     * Get all Refund
     * @return Collection
     */
    public function getAll() : Collection
    {
        return Refund::orderBy('id')->get();
    }

    /**
     * store an Refund
     *
     * @param $data
     * @return Refund
     */
    public function store($data): Refund
    {
        return Refund::Refund($data);
    }

    /**
     * Update Refund
     *
     * @param $id
     * @param $data
     * @return Refund
     */

    public function update($id,$data): Refund
    {
        return Refund::where('id',$id)->update($data);
    }

    /**
     * Get a Refund
     *
     * @param $id
     * @return Refund|BelongsTo
     */

    public function show($id): Refund|BelongsTo
    {
        return Refund::find($id)->with('loan');
    }

    /**
     * Delete Refund
     * @param $id
     * @return bool
     */
    public function delete($id) : bool
    {
        $find = Refund::find($id);
        $find->deleted_by = Auth::id();
        return $find->save();

    }
}
