<?php


namespace App\Services;


use App\Models\Meeting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MeetingService
{
    /**
     * Get all orders
     * @return Collection
     */
    public function getAll() : Collection
    {
        return Meeting::where('deleted_by')->orderBy('id')->get();
    }

    /**
     * store an Meeting
     *
     * @param $data
     * @return Meeting
     */
    public function store($data): Meeting
    {
        return Meeting::create($data);
    }

    /**
     * Update Meeting
     *
     * @param $id
     * @param $data
     * @return Meeting
     */

    public function update($id,$data): Meeting
    {
        return Meeting::where('id',$id)->update($data);
    }

    /**
     * Get a partner
     *
     * @param $id
     * @return Meeting|BelongsTo
     */

    public function show($id): Meeting|BelongsTo
    {
        //        $data['user'] = Orders::find($id)->user;
//        $data['partner'] = Orders::find($id)->partner;
//        $data['driver'] = Orders::find($id)->driver;
        return Meeting::find($id)->with('association');
    }

    /**
     * Delete association
     * @param $id
     * @return bool
     */
    public function delete($id) : bool
    {
        $find = Meeting::find($id);
        $find->deleted_at = date('Y-m-d H:i:s');
//        $driver->deleted_by = \auth()->id();
        return $find->save();

    }
}
