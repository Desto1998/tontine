<?php

namespace App\Http\Controllers;

use App\Services\ContributionService;
use App\Services\LogService;
use App\Services\MemberService;
use App\Services\ProjectService;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    /**
     * Create a new controller instance.
     * @param LogService $logService
     * @param ProjectService $projectService
     */
    public function __construct(private LogService $logService, private ProjectService $projectService, private ContributionService $contributionService,
       private MemberService $memberService)
    {
    }

    public function getMembers(): \Illuminate\Http\JsonResponse
    {
        return response()->json(
            $this->memberService->getAll()
        );
    }

    public function getContribution(): \Illuminate\Http\JsonResponse
    {
        return response()->json(
            $this->contributionService->getAll()
        );
    }
}
