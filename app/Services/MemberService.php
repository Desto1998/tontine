<?php


namespace App\Services;


use App\Models\Association;
use App\Models\Member;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MemberService
{
    /**
     * Get all orders
     * @return Collection
     */
    public function getAll() : Collection
    {
        return Member::where('deleted_at')->orderBy('id')->get();
    }

    /**
     * store an member
     *
     * @param $data
     * @return Member
     */
    public function store($data): Member
    {
        return Member::create($data);
    }

    /**
     * Update member
     *
     * @param $id
     * @param $data
     * @return Member
     */

    public function update($id,$data): Member
    {
        return Member::where('id',$id)->update($data);
    }

    /**
     * Get a partner
     *
     * @param $id
     * @return Member|BelongsTo
     */

    public function show($id): Member|BelongsTo
    {
        //        $data['user'] = Orders::find($id)->user;
//        $data['partner'] = Orders::find($id)->partner;
//        $data['driver'] = Orders::find($id)->driver;
        return Member::find($id)->with('association');
    }

    /**
     * Delete association
     * @param $id
     * @return bool
     */
    public function delete($id) : bool
    {
        $find = Member::find($id);
        $find->deleted_at = date('Y-m-d H:i:s');
//        $driver->deleted_by = \auth()->id();
        return $find->save();

    }
}
