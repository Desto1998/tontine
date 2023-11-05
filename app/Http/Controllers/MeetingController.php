<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\Sessions;
use App\Services\AssociationService;
use App\Services\LogService;
use App\Services\MeetingService;
use App\Services\MemberService;
use App\Services\SanctionService;
use App\Services\SessionsService;
use DataTables;
use Illuminate\Console\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\Factory;
use PDF;
use Validator;

class MeetingController extends Controller
{
    private $todayDate;

    /**
     * Create a new controller instance.
     * @param LogService $logService
     * @param SanctionService $sanctionService
     * @param SessionsService $sessionsService
     * @param MemberService $memberService
     * @param MeetingService $meetingService
     */
    public function __construct(private LogService $logService, private SanctionService $sanctionService, private SessionsService $sessionsService,
                                private MemberService $memberService, private MeetingService $meetingService, private AssociationService $associationService)
    {
        setlocale (LC_TIME, 'fr_FR.utf8','fra');
        $this->todayDate = strftime("%A le %d %B, %Y", strtotime( now() ));
    }

    /**
     * Return user list view
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('meeting.meeting-list');
    }

    /**
     * create.
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $sessions = $this->sessionsService->getAllActive();
        $members = $this->memberService->getAll();
        return view('meeting.meeting-create', compact('sessions', 'members'));
    }

    /**
     * Edit.
     * @param $id
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function edit($id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $meeting = $this->meetingService->show($id);
        $sessions = $this->sessionsService->getAllActive();
        $members = $this->memberService->getAll();
        $sanctions = $this->sanctionService->getAll();
        $sessionMembers = $this->sessionsService->sessionMembers($meeting->session_id);
        $sessionContributions = $this->sessionsService->sessionContributions($meeting->session_id);

        $meetingLoans = $this->meetingService->meetingLoans($meeting->id);
        $meetingSanctions = $this->meetingService->meetingSanctions($meeting->id);
        $meetingWinners = $this->meetingService->meetingWinnerMembers($meeting->id);
        $meetingFunds = $this->meetingService->meetingFunds($meeting->id);
        $meetingSessionMembers = $this->meetingService->meetingSessionMembers($meeting->id);
//        dd($sessionContributions);
        return view('meeting.meeting-edit', compact('sessions', 'members', 'meeting', 'sanctions', 'sessionMembers',
            'sessionContributions', 'meetingLoans', 'meetingSanctions', 'meetingFunds', 'meetingSessionMembers','meetingWinners'));
    }

    /**
     * View user detail.
     * @param $id
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function show($id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $session = $this->sessionsService->show($id);
        return view('meeting.meeting-show', compact('session'));
    }

    /**
     * store user.
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comment' => ['string'],
            'date' => ['required', 'date'],
            'start_time' => ['required'],
            'end_time' => ['required'],
            'agenda' => ['required', 'string'],
            'coordinator' => ['integer', 'exists:members,id'],
            'session_id' => ['integer', 'exists:sessions,id'],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }
//        $request->all()['association_id'] = \Auth::user()->association_id;
        $request->all()['user_id'] = \Auth::user()->id;

        $meeting = $this->meetingService->store($request->all());
        if ($meeting) {
//            $this->sessionsService->saveSessionMembers($request->all()['member_ids'],$session->id );
            $this->logService->save("Enregistrement", 'Sessions', "Enregistrement d'une Sessions ID: $meeting->id le" . now() . " Donne: $meeting", $meeting->id);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Reunion avec succès.',
            'data' => $meeting,
        ]);

    }

    /**
     * Load user data on datatable.
     * @return bool|JsonResponse
     * @throws \Exception
     */
    public function load(): bool|JsonResponse
    {
        if (request()->ajax()) {

            $data = Meeting::join('members', 'members.id', 'meetings.coordinator')
                ->join('users', 'meetings.user_id', 'users.id')
                ->join('sessions', 'sessions.id', 'meetings.session_id')
                ->where('meetings.deleted_by', null)
                ->where('members.association_id', \Auth::user()->association_id)
                ->orderBy('meetings.id', 'desc')
                ->select('meetings.*', 'users.first_name as user', 'sessions.name', 'members.first_name as member');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('actionbtn', function ($value) {

                    $action = view('meeting.meeting-action', compact('value'));
                    return (string)$action;
                })
                ->addColumn('checkbox', function ($value) {
                    $id = $value->id;
                    $check = view('layouts.partials._checkbox', compact('id'));
                    return (string)$check;
                })
                ->addColumn('created', function ($value) {
                    return $this->logService->formatCreatedAt($value->created_at);
                })
                ->rawColumns(['actionbtn', 'checkbox', 'created'])
                ->make(true);

        }
        return false;
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comment' => ['string'],
            'date' => ['required','date'],
            'start_time' => ['required'],
            'end_time' => ['required'],
            'agenda' => ['required','string'],
            'coordinator' => ['integer','exists:members,id'],
            'id' => ['integer','exists:meetings,id','required'],
            'session_id' => ['integer','exists:sessions,id'],
        ]);

        if ($validator->fails())
        {
            return response()->json(['error'=>$validator->errors()]);
        }

        $save = $this->meetingService->update($request->all()['id'],$request->except('_token'));
        $id = $request->all()['id'];
        $this->logService->save("Modification", 'Meeting', "Modification de la reunion  ID: $id le" . now()." Donne: ", $request->all()['id']);

        return response()->json([
            'status' => 'success',
            'message' => 'Modifié avec succès.',
            'data' => $save,
        ]);
    }

    /**
     * Delete a user.
     * @param Request $request
     * @return bool|JsonResponse
     */
    public function destroy(Request $request): bool|JsonResponse
    {
        if (request()->ajax()) {
            $id = $request->input('id');
            $deleted = $this->meetingService->delete($id);
            $this->logService->save("Suppression", 'Sessions', "Suppression de la session avec l'id: $id le" . now() . " Donne: $deleted", $id);

            return response()->json([
                'status' => 'success',
                'message' => 'Session supprimé avec succéss!',
                'data' => $deleted,
            ]);
        }
        return false;
    }


    /**
     * Delete a user.
     * @param Request $request
     * @return bool|JsonResponse
     */
    public function deleteMeetingSanction(Request $request): bool|JsonResponse
    {
        if (request()->ajax()) {
            $id = $request->input('id');
            $deleted = $this->meetingService->deleteMeetingSanction($id);
            $this->logService->save("Suppression", 'MeetingMemberSanction', "Suppression de la sanction de la reunion avec l'id: $id le" . now() . " Donne: $deleted", $id);

            return response()->json([
                'status' => 'success',
                'message' => 'Session supprimé avec succéss!',
                'data' => $deleted,
            ]);
        }
        return false;
    }

    /**
     * Delete meeting Winner.
     * @param Request $request
     * @return bool|JsonResponse
     */

    public function deleteMeetingMemberWinner(Request $request): bool|JsonResponse
    {
        if (request()->ajax()) {
            $id = $request->input('id');
            $deleted = $this->meetingService->deleteMeetingWinner($id);
            $this->logService->save("Suppression", 'MeetingSessionMember', "Suppression de la sanction de la reunion avec l'id: $id le" . now() . " Donne: $deleted", \Auth::id());

            return response()->json([
                'status' => 'success',
                'message' => 'Gagnant supprimé avec succéss!',
                'data' => $deleted,
            ]);
        }
        return false;
    }


    /**
     * Update session member.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeMeetingMemberContribution(Request $request): \Illuminate\Http\RedirectResponse
    {

        $request->validate([
            'contribution_id' => ['required', 'numeric', 'exists:contributions,id'],
            'meeting_id' => ['required', 'numeric', 'exists:meetings,id'],
//            'session_id' => ['required', 'numeric', 'exists:sessions,id'],
            'session_member_id' => ['required', 'array'],
            'session_member_id.*' => ['numeric', 'exists:session_members,id'],
            'amount' => ['required', 'array'],
            'amount.*' => ['numeric', 'min:0'],
        ]);

//        dd($request);
        $store = [];
        $amount = $request->input('amount');
        $ids = $request->input('id');
        foreach ($request->input('session_member_id') as $key => $value) {
            $id = $ids[$value] ?? 0;
            $store[$key] = $this->meetingService->storeMeetingSessionMember($id,$amount[$value],'Present',0,
                $value, $request->input('meeting_id'),$request->input('session_contribution_id'),\Auth::id());
            if ($store[$key]) {
                $this->logService->save("ENREGISTREMENT", 'MeetingSessionMember', "edition du membre de la session avec l'id: $id le" . now() . " Donne: $store[$key]", $id);
            }

        }

        return redirect()->back()->with('success', 'Enregistrer avec succéss');
//            return response()->json([
//                'status' => 'success',
//                'message' => 'Session supprimé avec succéss!',
//                'data' => $deleted,
//            ]);


    }

    public function storeMeetingMemberSanction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comment' => ['string'],
            'amount' => ['required', 'numeric','min:0'],
            'pay_status' => ['required'],
            'session_member_id' => ['required','numeric','exists:session_members,id'],
            'sanction_id' => ['required', 'numeric','exists:sanctions,id'],
            'meeting_id' => ['required','numeric', 'exists:meetings,id'],

        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $save = $this->meetingService->storeMeetingMemberSanction($request->input('amount'),$request->input('comment'),$request->input('pay_status'),$request->input('session_member_id'),$request->input('meeting_id'),$request->input('sanction_id'), \Auth::id());

        if ($save) {
            $id = $save->id;
        }
        $this->logService->save("ENREGISTREMENT", 'MeetingMemberSanction', "Enregistrement de la sanction pour compte d'une reunion  ID: $id le" . now() . " Donne: ", \Auth::id());

        return response()->json([
            'status' => 'success',
            'message' => 'Sanction enregistrés avec succès.',
            'data' => $save,
        ]);
    }

    public function storeMeetingMemberWinner(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => ['required', 'numeric','min:0'],
            'session_contribution_id' => ['required','numeric','exists:session_contributions,id'],
            'session_member_id' => ['required','numeric','exists:session_members,id'],
            'meeting_id' => ['required','numeric', 'exists:meetings,id'],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $save = $this->meetingService->setMeetingWinner($request->input('meeting_id'),$request->input('session_member_id'),$request->input('session_contribution_id'),$request->input('amount'));

        if ($save) {
            $this->logService->save("ENREGISTREMENT", 'MeetingMemberSanction', "Enregistrement de la sanction pour compte d'une reunion  ID:  le" . now() . " Donne: ", \Auth::id());

        }

        return response()->json([
            'status' => 'success',
            'message' => 'Gagnant enregistrés avec succès.',
            'data' => $save,
        ]);
    }

    /**
     * Update session member.
     * @param $id
     * @return \Illuminate\Http\Response|void
     */
    public function print($id)
    {
        $meeting= $this->meetingService->show($id);
//        dd($meeting);
        $data['association'] = $this->associationService->show(\Auth::user()->association_id);
        $data['meeting'] = $this->meetingService->show($id);
        $data['sessions'] = $this->sessionsService->getAllActive();
        $data['members'] = $this->memberService->getAll();
        $data['sanctions'] = $this->sanctionService->getAll();
        $data['sessionMembers'] = $this->sessionsService->sessionMembers($meeting->session_id);
        $data['sessionContributions'] = $this->sessionsService->sessionContributions($meeting->session_id);

        $data['meetingLoans'] = $this->meetingService->meetingLoans($meeting->id);
        $data['meetingSanctions'] = $this->meetingService->meetingSanctions($meeting->id);
        $data['meetingFunds'] = $this->meetingService->meetingFunds($meeting->id);
        $data['meetingSessionMembers'] = $this->meetingService->meetingSessionMembers($meeting->id);
        $data['meetingWinners'] = $this->meetingService->meetingWinnerMembers($meeting->id);
        $data['meeting_date']= strftime("%A le %d %B, %Y", strtotime( $meeting->date ));
        $data['today'] = $this->todayDate;
        $pdf = PDF::loadView('meeting.print-report',
            compact('data'))->setPaper('a4')->setWarnings(false);

        return $pdf->stream('Rapport_reunion_du_'.$data['meeting']->date.'_fait_le_'.now(). '.pdf');

    }
}
