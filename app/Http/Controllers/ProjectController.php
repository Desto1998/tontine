<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use App\Models\Member;
use App\Models\Project;
use App\Models\ProjectMember;
use App\Services\LogService;
use App\Services\ProjectService;
use Illuminate\Console\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\Factory;
use Yajra\DataTables\DataTables;

class ProjectController extends Controller
{
    /**
     * Create a new controller instance.
     * @param LogService $logService
     * @param ProjectService $projectService
     */
    public function __construct(private LogService $logService, private ProjectService $projectService )
    {
    }

    /**
     * Return user list view
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {

        return view('project.project-list',);
    }

    /**
     * View user detail.
     * @param $id
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function show($id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('contribution.contribution-show');
    }

    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $members = Member::where('status',1)->get();
        $contributions = Contribution::all();
        return view('project.project-create', compact('members','contributions'));
    }

    /**
     * View user detail.
     * @param $id
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function edit($id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $members = Member::where('status', 1)->get();
        $contributions = Contribution::all();
        $project = Project::find($id);
        $projectMembers = ProjectMember::where('project_id', $id)->get();
        return view('project.project-edit', compact('contributions', 'members','project', 'projectMembers'));
    }

    /**
     * store user.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
//        dd($request->input());
        $request->validate( [
            'title' => ['required','string','min:5','max:255'],
//            'fund_deadline' => ['date'],
            'amount' => ['numeric'],
            'amounts' => ['array'],
            'amounts.*' => ['numeric'],
            'members_id' => ['array'],
            'members_id.*' => ['numeric', 'exists:members,id'],
            'contribution_id' => ['int', 'exists:contributions,id'],
            'type' => ['required','string', 'min:4','max:50'],

        ]);

        $data = array();
        $data['title'] = $request->input('title');
        $data['description'] = $request->input('description');
        $data['type'] = $request->input('type');
        $data['contribution_id'] = $request->input('contribution_id');
        $data['user_id'] = Auth::id();
        $data['amount'] = $request->input('amount');
        $data['id'] = $request->input('id');
        $project = $this->projectService->store($data);

        $project_members = [];
        $amounts = $request->input('amounts');
        foreach ($request->input('members_id') as $key =>$value){
            $project_member = array();
            $project_member['project_id'] = $project->id;
            $project_member['amount'] = $amounts[$value];
            $project_member['member_id'] = $value;
            $project_member['status'] = 1;
            $project_member['id'] = 0;
            $project_member['user_id'] = Auth::id();
            if (isset($request->project_member_ids) && count($request->project_member_ids)){
                $project_member['id'] = $request->project_member_ids[$value];
            }
//            array_push($project_members, $project_member);
            $pm = $this->projectService->storeProjectMembers($project_member);
        }


        if ($project) {
            $this->logService->save("Enregistrement", 'Project', json_encode([$project, $pm]), $project->id);
        }

        return redirect()->route('project.index')->with('success','Projet enregistré avec succès!');

    }

    /**
     * Load user data on datatable.
     * @return bool|JsonResponse
     * @throws \Exception
     */
    public function load(): bool|JsonResponse
    {
        if (request()->ajax()) {

            $data = Project::join('contributions','contributions.id','projects.contribution_id')
                ->join('users','projects.user_id','users.id')
                ->where('contributions.association_id', Auth::user()->association_id)
//                ->orderBy('contributions.id', 'desc')
                ->select('projects.*', 'users.first_name as user', 'contributions.name');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('actionbtn', function($value){

                    $action = view('project.project-action',compact('value'));
                    return (string)$action;
                })
                ->addColumn('checkbox', function ($value) {
                    $id = $value->id;
                    $check = view('layouts.partials._checkbox', compact('id'));
                    return (string)$check;
                })
                ->addColumn('created', function($value){
                    return $this->logService->formatCreatedAt($value->created_at);
                })
//                ->addColumn('statute', function($value){
//                    return $value->status? "<span class=\"badge badge-info right\">Actif</span>" : "<span class=\"badge badge-danger right\">Cloturé</span>";
//                })
                ->rawColumns(['actionbtn','checkbox','created','statute'])
                ->make(true);

        }
        return false;
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
            $deleted = $this->projectService->delete($id);
            $this->logService->save("Suppression", 'Project', "Suppression du projet avec l'id: $id le" . now()." Donne: $deleted", $id);

            return response()->json([
                'status' => 'success',
                'message' => 'Contribution supprimé avec succéss!',
                'data' => $deleted,
            ]);
        }
        return false;
    }
}
