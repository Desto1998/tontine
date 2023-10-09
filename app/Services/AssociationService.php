<?php


namespace App\Services;


use App\Models\Association;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class AssociationService
{
    /**
     * Get all orders
     * @return Collection
     */
    public function getAll() : Collection
    {
        return Association::where('deleted_at')->orderBy('id')->get();
    }

    /**
     * store an association
     *
     * @param $data
     * @return Association
     */
    public function store($data): Association
    {
        return Association::create($data);
    }

    /**
     * Update an association
     *
     * @param $id
     * @param $data
     * @return Association
     */
    public function update($id,$data): Association
    {
        return Association::where('id',$id)->update($data);
    }

    /**
     * Get a partner
     *
     * @param $id
     * @return BelongsTo
     */

    public function show($id): Association|BelongsTo
    {
        $data = Association::find($id);
//        $data['user'] = Orders::find($id)->user;
//        $data['partner'] = Orders::find($id)->partner;
//        $data['driver'] = Orders::find($id)->driver;
        return $data;
//        return Orders::find($id)->with('user')->with('partner')->with('driver');
    }

    /**
     * Get an association members
     *
     * @param $id
     * @return BelongsTo
     */

    public function getMembers($association_id): Association
    {
        return Association::find($association_id)->with('members');
    }

    /**
     * Delete association
     * @param $id
     * @return bool
     */
    public function delete($id) : bool
    {
        $driver = Association::find($id);
        $driver->deleted_at = date('Y-m-d H:i:s');
//        $driver->deleted_by = \auth()->id();

        return $driver->save();

    }
}
