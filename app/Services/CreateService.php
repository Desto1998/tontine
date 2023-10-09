<?php


namespace App\Services;


use App\Models\Create;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CreateService
{
    /**
     * Get all orders
     * @return Collection
     */
    public function getAll() : Collection
    {
        return Create::where('deleted_by')->orderBy('id')->get();
    }

    /**
     * store an Create
     *
     * @param $data
     * @return Create
     */
    public function store($data): Create
    {
        return Create::create($data);
    }

    /**
     * Update Create
     *
     * @param $id
     * @param $data
     * @return Create
     */

    public function update($id,$data): Create
    {
        return Create::where('id',$id)->update($data);
    }

    /**
     * Get a partner
     *
     * @param $id
     * @return Create|BelongsTo
     */

    public function show($id): Create|BelongsTo
    {
        //        $data['user'] = Orders::find($id)->user;
//        $data['partner'] = Orders::find($id)->partner;
//        $data['driver'] = Orders::find($id)->driver;
        return Create::find($id)->with('association');
    }

    /**
     * Delete association
     * @param $id
     * @return bool
     */
    public function delete($id) : bool
    {
        $find = Create::find($id);
        $find->deleted_at = date('Y-m-d H:i:s');
//        $driver->deleted_by = \auth()->id();
        return $find->save();

    }
}
