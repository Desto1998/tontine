<?php


namespace App\Services;


use App\Models\Sanctions;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SanctionService
{
    /**
     * Get all orders
     * @return Collection
     */
    public function getAll() : Collection
    {
        return Sanctions::where('deleted_by')->where('association_id', \Auth::user()->association_id)->orderBy('id')->get();
    }

    /**
     * store an Sanctions
     *
     * @param $data
     * @return Sanctions
     */
    public function store($data): Sanctions
    {
        return Sanctions::create($data);
    }

    /**
     * Update Sanctions
     *
     * @param $id
     * @param $data
     * @return bool
     */

    public function update($id,$data): bool
    {
        return Sanctions::where('id',$id)->update($data);
    }

    /**
     * Get a partner
     *
     * @param $id
     * @return Sanctions|BelongsTo
     */

    public function show($id): Sanctions|BelongsTo
    {
        //        $data['user'] = Orders::find($id)->user;
//        $data['partner'] = Orders::find($id)->partner;
//        $data['driver'] = Orders::find($id)->driver;
        return Sanctions::find($id)->with('association');
    }

    /**
     * Delete association
     * @param $id
     * @return bool|Sanctions
     */
    public function delete($id) : bool|Sanctions
    {
        $find = Sanctions::find($id);
        $find->deleted_by = \Auth::id();
//        $driver->deleted_by = \auth()->id();
        return $find->save();

    }
}
