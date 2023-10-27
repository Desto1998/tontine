<?php


namespace App\Services;


use App\Models\Fund;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FundService
{
    /**
     * Get all orders
     * @return Collection
     */
    public function getAll() : Collection
    {
        return Fund::where('deleted_by')->orderBy('id')->get();
    }

    /**
     * store an Fund
     *
     * @param $data
     * @return Fund
     */
    public function store($data): Fund
    {
        return Fund::create($data);
    }

    /**
     * Update Fund
     *
     * @param $id
     * @param $data
     * @return bool
     */

    public function update($id,$data): bool
    {
        return Fund::where('id',$id)->update($data);
    }

    /**
     * Get a partner
     *
     * @param $id
     * @return Fund|BelongsTo
     */

    public function show($id): Fund|BelongsTo
    {
        //        $data['user'] = Orders::find($id)->user;
//        $data['partner'] = Orders::find($id)->partner;
//        $data['driver'] = Orders::find($id)->driver;
        return Fund::find($id)->with('association');
    }

    /**
     * Delete association
     * @param $id
     * @return bool
     */
    public function delete($id) : bool
    {
        $find = Fund::find($id);
        $find->deleted_by = \auth()->id();
//        $driver->deleted_by = \auth()->id();
        return $find->save();

    }
}
