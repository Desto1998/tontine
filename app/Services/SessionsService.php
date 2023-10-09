<?php


namespace App\Services;


use App\Models\Sessions;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SessionsService
{
    /**
     * Get all orders
     * @return Collection
     */
    public function getAll() : Collection
    {
        return Sessions::where('deleted_by')->orderBy('id')->get();
    }

    /**
     * store an Sessions
     *
     * @param $data
     * @return Sessions
     */
    public function store($data): Sessions
    {
        return Sessions::create($data);
    }

    /**
     * Update Sessions
     *
     * @param $id
     * @param $data
     * @return Sessions
     */

    public function update($id,$data): Sessions
    {
        return Sessions::where('id',$id)->update($data);
    }

    /**
     * Get a partner
     *
     * @param $id
     * @return Sessions|BelongsTo
     */

    public function show($id): Sessions|BelongsTo
    {
        //        $data['user'] = Orders::find($id)->user;
//        $data['partner'] = Orders::find($id)->partner;
//        $data['driver'] = Orders::find($id)->driver;
        return Sessions::find($id)->with('association');
    }

    /**
     * Delete association
     * @param $id
     * @return bool
     */
    public function delete($id) : bool
    {
        $find = Sessions::find($id);
        $find->deleted_at = date('Y-m-d H:i:s');
//        $driver->deleted_by = \auth()->id();
        return $find->save();

    }
}
