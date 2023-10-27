<?php


namespace App\Services;


use App\Models\Loan;
use App\Models\Meeting;
use App\Models\MeetingMemberSantion;
use App\Models\Sanctions;
use App\Models\SessionMember;
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
        return Meeting::find($id);
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

    public function meetingLoans($meeting_id): Collection
    {

        return Loan::join('members','members.id','loans.meeting_id')->where('meeting_id',$meeting_id)->where('loans.deleted_by',null)->get();
    }

    public function meetingSanctions($meeting_id): Collection
    {
        return SessionMember::join('meeting_member_sanctions','meeting_member_sanctions.session_member_id','session_members.id')
            ->join('members','members.id', 'session_members.member_id')
            ->join('sanctions','sanctions.id','meeting_member_sanctions.sanction_id')
            ->where('meeting_member_sanctions.meeting_id',$meeting_id)
            ->where('deleted_by',null)
            ->select('meeting_member_sanctions.*','sanctions.title','session_members.member_id','members.first_name','members.last_name','members.has_fund')
            ->get();
    }

    public function meetingFunds($meeting_id): Collection
    {
        return Loan::join('members','members.id','funds.meeting_id')
            ->where('meeting_id',$meeting_id)
            ->where('funds.deleted_by',null)
            ->select('loans.*','members.first_name','members.last_name','members.has_fund' )
            ->get();
    }

    public function meetingSessionMembers($meeting_id): Collection
    {

        return SessionMember::join('meeting_member_sanctions','meeting_member_sanctions.session_member_id','session_members.id')
            ->join('members','members.id','session_members.member_id')
            ->where('meeting_member_sanctions.meeting_id',$meeting_id)
            ->select('meeting_member_sanctions.*','members.first_name','members.last_name','members.has_fund')
            ->get()
        ;
    }


}
