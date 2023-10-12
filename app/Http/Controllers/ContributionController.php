<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use App\Models\Member;
use App\Services\AssociationService;
use App\Services\ContributionService;
use App\Services\LogService;
use App\Services\MemberService;
use App\Services\UserService;
use DataTables;
use Illuminate\Console\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\Factory;
use Validator;

class ContributionController extends Controller
{

    /**
     * Create a new controller instance.
     * @param LogService $logService
     * @param ContributionService $contributionService
     */
    public function __construct(private LogService $logService,  private ContributionService $contributionService)
    {
    }

    /**
     * Return user list view
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('contribution.contribution-list');
    }


    /**
     * View user detail.
     * @param $id
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function show($id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('contribution.contribution-edit');
    }

    /**
     * store user.
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['string','min:5','max:255'],
            'description' => ['string','max:255'],
            'type' => ['string', 'min:5','max:50'],

        ]);

        if ($validator->fails())
        {
            return response()->json(['error'=>$validator->errors()]);
        }

        $member = $this->contributionService->store($request->all());
        if ($member) {
            $this->logService->save("Enregistrement", 'Contribution', "Enregistrement d'une cotisation ID: $member->id le" . now()." Donne: $member", $member->id);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Cotisation enregistrée avec succès.',
            'data' => $member,
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

            $data = Contribution::where('contributions.deleted_by', null)
                ->join('users','contributions.user_id','users.id')
//                ->orderBy('contributions.id', 'desc')
                ->select('contributions.*', 'users.first_name as user');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('actionbtn', function($value){

                    $action = view('contribution.contribution-action',compact('value'));
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
                ->addColumn('statute', function($value){
                    return $value->status? "<span class=\"badge badge-info right\">Actif</span>" : "<span class=\"badge badge-danger right\">Cloturé</span>";
                })
                ->rawColumns(['actionbtn','checkbox','created','statute'])
                ->make(true);

        }
        return false;
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['string','min:5','max:255'],
            'description' => ['string','max:255'],
            'type' => ['required', 'string', 'min:9','max:14'],
            'id' => ['required', 'integer', 'exists:contributions'],

        ]);

        if ($validator->fails())
        {
            return response()->json(['error'=>$validator->errors()]);
        }

        $save = $this->contributionService->update($request->all()['id'],$request->all());
        $id = $request->all()['id'];
        $this->logService->save("Modification", 'Contribution', "Modification des informations de la cotisation ID: $id le" . now()." Donne: ", $request->all()['id']);

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
            $deleted = $this->contributionService->delete($id);
            $this->logService->save("Suppression", 'Contribution', "Suppression de la cotisation avec l'id: $id le" . now()." Donne: $deleted", $id);

            return response()->json([
                'status' => 'success',
                'message' => 'Contribution supprimé avec succéss!',
                'data' => $deleted,
            ]);
        }
        return false;
    }
}
