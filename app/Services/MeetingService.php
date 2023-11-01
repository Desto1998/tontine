<?php


namespace App\Services;


use App\Models\Fund;
use App\Models\Loan;
use App\Models\Meeting;
use App\Models\MeetingMemberSanction;
use App\Models\MeetingSessionMember;
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
        return Meeting::with('coordinate')->find($id);
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

        return Loan::join('contributions','contributions.id','loans.contribution_id')
            ->join('members','members.id','loans.member_id')
            ->where('meeting_id',$meeting_id)->where('loans.deleted_by',null)
            ->select('loans.*','members.first_name','members.last_name','contributions.name')
            ->get();
    }

    public function meetingSanctions($meeting_id): Collection
    {
        return SessionMember::join('meeting_member_sanctions','meeting_member_sanctions.session_member_id','session_members.id')
            ->join('members','members.id', 'session_members.member_id')
            ->join('sanctions','sanctions.id','meeting_member_sanctions.sanction_id')
            ->where('meeting_member_sanctions.meeting_id',$meeting_id)
            ->where('meeting_member_sanctions.deleted_by',null)
            ->select('meeting_member_sanctions.*','sanctions.title','session_members.member_id','members.first_name','members.last_name','members.has_fund')
            ->get();
    }

    public function meetingFunds($meeting_id): Collection
    {
        return Fund::join('members','members.id','funds.member_id')
            ->where('meeting_id',$meeting_id)
            ->where('funds.deleted_by',null)
            ->select('funds.*','members.first_name','members.last_name','members.has_fund' )
            ->get();
    }

    public function meetingSessionMembers($meeting_id): Collection
    {

        return SessionMember::Join('meeting_session_members','meeting_session_members.session_member_id','session_members.id')
            ->join('members','members.id','session_members.member_id')
            ->where('meeting_session_members.meeting_id',$meeting_id)
            ->where('meeting_session_members.deleted_by',null)
            ->select('meeting_session_members.*','session_members.member_id','session_members.id as session_member_id','session_members.amount as initial_amount','members.first_name','members.last_name','members.has_fund')
            ->get()
        ;
    }

    /**
     * Delete meeting sanction
     * @param $id
     * @return bool
     */
    public function deleteMeetingSanction($id) : bool
    {
        $find = MeetingMemberSanction::find($id);
        $find->deleted_by = \auth()->id();
        return $find->save();

    }

    /**
     * Delete meeting loan
     * @param $id
     * @return bool
     */
    public function deleteMeetingLoan($id) : bool
    {
        $find = Loan::find($id);
        $find->deleted_by = \auth()->id();
        return $find->save();

    }

    /**
     * Delete meeting fund
     * @param $id
     * @return bool
     */
    public function deleteMeetingFund($id) : bool
    {
        $find = Fund::find($id);
        $find->deleted_by = \auth()->id();
        return $find->save();

    }

    /**
     * Store meeting member contribution
     * @param $id
     * @param $amount
     * @param $present
     * @param $took
     * @param $session_member_id
     * @param $meeting_id
     * @param $session_contribution_id
     * @param $user_id
     * @return MeetingSessionMember
     */
    public function storeMeetingSessionMember($id, $amount, $present,$took,
                                              $session_member_id,$meeting_id,$session_contribution_id,$user_id) : MeetingSessionMember
    {
        return MeetingSessionMember::updateOrCreate(
            ['id'=>$id],
            [
                'amount'=>$amount,
                'present'=>$present,
                'took'=>$took,
                'session_member_id'=>$session_member_id,
                'session_contribution_id'=>$session_contribution_id,
                'meeting_id'=>$meeting_id,
                'user_id'=>$user_id,
            ]
        );

    }

    /**
     * Store meeting member sanction
     * @param $amount
     * @param $comment
     * @param $pay_status
     * @param $session_member_id
     * @param $meeting_id
     * @param $sanction_id
     * @param $user_id
     * @return MeetingMemberSanction
     */
    public function storeMeetingMemberSanction($amount, $comment, $pay_status, $session_member_id, $meeting_id, $sanction_id, $user_id) : MeetingMemberSanction
    {
        return MeetingMemberSanction::updateOrCreate(
            ['id'=>0],
            [
                'amount'=>$amount,
                'comment'=>$comment,
                'pay_status'=>$pay_status,
                'session_member_id'=>$session_member_id,
                'sanction_id'=>$sanction_id,
                'meeting_id'=>$meeting_id,
                'user_id'=>$user_id,
            ]
        );

    }

    /**
     * set meeting winners
     * @param $meeting_id
     * @param $session_member_id
     * @param $session_contribution_id
     * @param $amount
     * @return bool
     */
    public function setMeetingWinner($meeting_id,$session_member_id, $session_contribution_id, $amount):bool
    {
//
        $session_member = SessionMember::where('id',$session_member_id)->update([
            'taken' => 1,
        ] );

        return MeetingSessionMember::where('session_contribution_id', $session_contribution_id)
            ->where('meeting_id',$meeting_id)
            ->where('session_member_id',$session_member_id)
            ->update([
                'took'=>1,
                'take_amount'=>$amount,
            ]);

    }
    public function meetingWinnerMembers($meeting_id): Collection
    {

        return SessionMember::Join('meeting_session_members','meeting_session_members.session_member_id','session_members.id')
            ->join('members','members.id','session_members.member_id')
            ->where('meeting_session_members.meeting_id',$meeting_id)
            ->where('meeting_session_members.deleted_by',null)
            ->where('meeting_session_members.took',1)
            ->where('meeting_session_members.take_amount','!=',0)
            ->select('meeting_session_members.*','session_members.member_id','session_members.id as session_member_id','session_members.amount as initial_amount','members.first_name','members.last_name','members.has_fund')
            ->get()
            ;
    }

    /**
     * set meeting winners
     * @param $meeting_session_member_id
     * @return bool
     */
    public function deleteMeetingWinner($meeting_session_member_id):bool
    {
//
        return MeetingSessionMember::where('id', $meeting_session_member_id)
            ->update([
                'took'=>0,
                'take_amount'=>0,
            ]);

    }

}
