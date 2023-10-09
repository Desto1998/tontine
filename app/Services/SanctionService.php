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
        return Sanctions::where('deleted_by')->orderBy('id')->get();
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
     * @return Sanctions
     */

    public function update($id,$data): Sanctions
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
     * @return bool
     */
    public function delete($id) : bool
    {
        $find = Sanctions::find($id);
        $find->deleted_at = date('Y-m-d H:i:s');
//        $driver->deleted_by = \auth()->id();
        return $find->save();

    }
}
