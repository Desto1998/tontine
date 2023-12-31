<?php

namespace App\Http\Controllers;

use App\Models\Sessions;
use App\Services\ContributionService;
use App\Services\LogService;
use App\Services\MemberService;
use App\Services\SanctionService;
use App\Services\SessionsService;
use DataTables;
use Illuminate\Console\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\Factory;
use Validator;

class SessionsController extends Controller
{
    //
    /**
     * Create a new controller instance.
     * @param LogService $logService
     * @param SessionsService $sessionsService
     * @param ContributionService $contributionService
     * @param MemberService $memberService
     */
    public function __construct(private LogService $logService, private SessionsService $sessionsService, private ContributionService $contributionService, private MemberService $memberService)
    {
    }

    /**
     * Return user list view
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $contributions = $this->contributionService->getAll();
        $members = $this->memberService->getAll();
        return view('session.session-list', compact('contributions','members'));
    }

    /**
     * View user detail.
     * @param $id
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function edit($id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $contributions = $this->contributionService->getAll();
        $members = $this->memberService->getAll();
        $session = $this->sessionsService->show($id);
        return view('session.session-edit',compact('session','members','contributions'));
    }

    /**
     * View user detail.
     * @param $id
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function show($id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $session = $this->sessionsService->show($id);
        return view('session.session-edit',compact('session'));
    }

    /**
     * store user.
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required','required','string','min:5'],
            'type' => ['required','string','max:255'],
            'frequency' => ['required'],
            'meeting_day' => ['required'],
            'start_date' => ['required','date'],
//            'contribution_id' => ['required','exists:contributions,id'],
            'member_ids' => ['required','array'],
            'contribution_ids' => ['required','array'],
            'member_ids.*' => ['integer','exists:members,id'],
            'contribution_ids.*' => ['integer','exists:contributions,id'],

        ]);

        if ($validator->fails())
        {
            return response()->json(['error'=>$validator->errors()]);
        }
//        $request->all()['association_id'] = \Auth::user()->association_id;
//        $request->all()['user_id'] = \Auth::user()->id;

        $session = $this->sessionsService->store($request->all());
        if ($session) {
            $this->sessionsService->saveSessionMembers($request->all()['member_ids'],$session->id );
            $this->sessionsService->saveSessionContribution($request->all()['contribution_ids'],$session->id );
            $this->logService->save("Enregistrement", 'Sessions', "Enregistrement d'une Sessions ID: $session->id le" . now()." Donne: $session", $session->id);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Session enregistré avec succès.',
            'data' => $session,
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

            $data = Sessions::join('users','sessions.user_id','users.id')
                ->where('sessions.deleted_by', null)
                ->where('users.association_id', \Auth::user()->association_id)
                ->orderBy('sessions.id', 'desc')
                ->select('sessions.*','users.first_name as user');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('actionbtn', function($value){

                    $action = view('session.session-action',compact('value'));
                    return (string)$action;
                })
                ->addColumn('checkbox', function ($value) {
                    $id = $value->id;
                    $check = view( 'layouts.partials._checkbox', compact('id'));
                    return (string)$check;
                })
                ->addColumn('created', function($value){
                    return $this->logService->formatCreatedAt($value->created_at);
                })
                ->addColumn('statute', function($value){
                    return $value->status ? "<span class=\"badge badge-info right\">Actif</span>" : "<span class=\"badge badge-danger right\">Cloturé</span>";
                })
                ->rawColumns(['actionbtn','checkbox','created','statute'])
                ->make(true);

        }
        return false;
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
//            'amount' => ['required','numeric','string','min:5'],
//            'take_order' => ['required','string','max:255'],
            'frequency' => ['required'],
            'meeting_day' => ['required'],
            'start_date' => ['required','date'],
            'member_ids' => ['required','array'],
            'contribution_ids' => ['required','array'],
            'member_ids.*' => ['integer','exists:members,id'],
            'contribution_ids.*' => ['integer','exists:contributions,id'],
            'id' => ['required','numeric', 'exists:sessions'],
        ]);

        if ($validator->fails())
        {
            return response()->json(['error'=>$validator->errors()]);
        }

        $data = array();
        $data['frequency'] = $request->input('frequency');
        $data['meeting_day'] = $request->input('meeting_day');
        $data['start_date'] = $request->input('start_date');
        $save = $this->sessionsService->update($request->all()['id'],$data);
        if ($save) {
            if ($this->sessionsService->canEditSessionContribution($request->input('id'))) {
                $this->sessionsService->saveSessionMembers($request->all()['member_ids'],$request->input('id') );
                $this->sessionsService->saveSessionContribution($request->all()['contribution_ids'],$save->id );
            }
            $id = $request->all()['id'];
            $this->logService->save("Modification", 'Session', "Modification de la Sessions  ID: $id le" . now()." Donne: ", $request->all()['id']);

        }

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
            $deleted = $this->sessionsService->delete($id);
            $this->logService->save("Suppression", 'Sessions', "Suppression de la session avec l'id: $id le" . now()." Donne: $deleted", $id);

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
    public function deleteSessionMember(Request $request): bool|JsonResponse
    {
        if (request()->ajax()) {
            $id = $request->input('id');
            $deleted = $this->sessionsService->deleteSessionMember($id);
            $this->logService->save("Suppression", 'SessionMember', "Suppression du membre de la session avec l'id: $id le" . now()." Donne: $deleted", $id);

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
    public function markAsTaken(Request $request): bool|JsonResponse
    {
        if (request()->ajax()) {
            $id = $request->input('id');
            $amount = $request->input('amount');
            $deleted = $this->sessionsService->setSMasTaken($id,$amount);
            $this->logService->save("Modification", 'SessionMember', "Marquer le participand de la session comme avoir beneficier avec l'id: $id le" . now()." Donne: $deleted", $id);

            return response()->json([
                'status' => 'success',
                'message' => 'Effectué avec succéss!',
                'data' => $deleted,
            ]);
        }
        return false;
    }

    /**
     * Update session member.
     * @param Request $request
     * @return bool|JsonResponse
     */
    public function updateSessionMember(Request $request): bool|JsonResponse
    {

        if (request()->ajax()) {
            $validator = Validator::make($request->all(), [
                'amount' => ['required','numeric','min:5'],
                'take_order' => ['required','max:255'],
                'id' => ['required','numeric', 'exists:session_members'],
            ]);

            if ($validator->fails())
            {
                return response()->json(['error'=>$validator->errors()]);
            }
            $id = $request->input('id');
            $deleted = $this->sessionsService->updateSessionMember($id,$request->input('amount'), $request->input('take_order'));
            $this->logService->save("MODIFICATION", 'SessionMember', "edition du membre de la session avec l'id: $id le" . now()." Donne: $deleted", $id);

            return response()->json([
                'status' => 'success',
                'message' => 'Session supprimé avec succéss!',
                'data' => $deleted,
            ]);
        }
        return false;
    }

    /**
     * Update sesj
     * sion member.
     * @param $id
     * @return bool|JsonResponse
     */
    public function print($id)
    {

        return false;
    }
}
