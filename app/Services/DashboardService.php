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
        return Member::where('deleted_at',null)->count();
    }

    public function countContribution():int
    {
        return Contribution::where('deleted_by',null)->count();
    }
    public function countFund():int
    {
        return Fund::where('deleted_by',null)->count();
    }

    public function countLoan():int
    {
        return Loan::where('deleted_by',null)->count();
    }

    public function countMemberNoFund():int
    {
        return Member::join('funds')->where('members.deleted_at',null)->count();
    }
    public function countSanction():int
    {
        return Sanctions::where('deleted_by',null)->count();
    }
    public function countAssociation():int
    {
        return Association::where('deleted_at',null)->count();
    }

    public function countSession():int
    {
        return Sessions::where('deleted_by',null)->count();
    }

    public function countMeeting():int
    {
        return Meeting::where('deleted_by',null)->count();
    }
}
