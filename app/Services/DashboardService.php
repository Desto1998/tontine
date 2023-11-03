<?php


namespace App\Services;


use App\Models\Association;
use App\Models\Contribution;
use App\Models\Fund;
use App\Models\Loan;
use App\Models\Meeting;
use App\Models\Member;
use App\Models\Sanctions;
use App\Models\Sessions;

class DashboardService
{
    public function countMember():int
    {
        return Member::where('deleted_at',null)->where('association_id',\Auth::user()->association_id)->count();
    }

    public function countContribution():int
    {
        return Contribution::where('deleted_by',null)->where('association_id',\Auth::user()->association_id)->count();
    }
    public function countFund():int
    {
        return Fund::join('members','members.id','funds.member_id')->where('funds.deleted_by',null)->where('association_id',\Auth::user()->association_id)->count();
    }

    public function countLoan():int
    {
        return Loan::join('members','members.id','loans.member_id')->where('loans.deleted_by',null)->where('association_id',\Auth::user()->association_id)->count();
    }

    public function countMemberNoFund():int
    {
        return Member::join('funds')->where('members.deleted_at',null)->count();
    }
    public function countSanction():int
    {
        return Sanctions::where('deleted_by',null)->where('association_id',\Auth::user()->association_id)->count();
    }
    public function countAssociation():int
    {
        return Association::where('deleted_at',null)->count();
    }

    public function countSession():int
    {
        return Sessions::join('users','sessions.user_id','users.id')->where('deleted_by',null)->where('association_id',\Auth::user()->association_id)->count();
    }

    public function countMeeting():int
    {
        return Meeting::join('users','meetings.user_id','users.id')->where('meetings.deleted_by',null)->where('association_id',\Auth::user()->association_id)->count();
    }
}
