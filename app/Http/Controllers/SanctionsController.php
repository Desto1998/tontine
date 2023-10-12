<?php

namespace App\Http\Controllers;

use App\Models\Sanctions;
use App\Services\LogService;
use App\Services\SanctionService;
use DataTables;
use Illuminate\Console\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\Factory;
use Validator;

class SanctionsController extends Controller
{
    //
    /**
     * Create a new controller instance.
     * @param LogService $logService
     * @param SanctionService $sanctionService
     */
    public function __construct(private LogService $logService,  private SanctionService $sanctionService)
    {
    }

    /**
     * Return user list view
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('sanction.sanction-list');
    }


    /**
     * View user detail.
     * @param $id
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function show($id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $fund = $this->sanctionService->show($id);
        return view('sanction.sanction-show',compact('fund'));
    }

    /**
     * store user.
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required','string','min:0'],
            'description' => ['string','max:255'],
            'amount' => ['required', 'numeric', 'exists:members,id'],

        ]);

        if ($validator->fails())
        {
            return response()->json(['error'=>$validator->errors()]);
        }
        $request->all()['association_id'] = \Auth::user()->association_id;
        $request->all()['user_id'] = \Auth::user()->id;


        $member = $this->sanctionService->store($request->all());
        if ($member) {
            $this->logService->save("Enregistrement", 'Fund', "Enregistrement d'une santion ID: $member->id le" . now()." Donne: $member", $member->id);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Fond enregistrée avec succès.',
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

            $data = Sanctions::where('sanctions.deleted_by', null)
                ->join('users','funds.user_id','users.id')
                ->orderBy('funds.id', 'desc')
                ->select('funds.*','users.first_name as user');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('actionbtn', function($value){

                    $action = view('sanction.sanction-action',compact('value'));
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
                ->rawColumns(['actionbtn','checkbox','created'])
                ->make(true);

        }
        return false;
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required','string','min:0'],
            'description' => ['string','max:255'],
            'amount' => ['required', 'numeric', 'exists:members,id'],
            'id' => ['required','numeric', 'exists:sanctions'],
        ]);

        if ($validator->fails())
        {
            return response()->json(['error'=>$validator->errors()]);
        }

        $save = $this->sanctionService->update($request->all()['id'],$request->all());
        $id = $request->all()['id'];
        $this->logService->save("Modification", 'Sanction', "Modification de la sanction membre ID: $id le" . now()." Donne: ", $request->all()['id']);

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
            $deleted = $this->sanctionService->delete($id);
            $this->logService->save("Suppression", 'Sanction', "Suppression de la sanction avec l'id: $id le" . now()." Donne: $deleted", $id);

            return response()->json([
                'status' => 'success',
                'message' => 'Fond supprimé avec succéss!',
                'data' => $deleted,
            ]);
        }
        return false;
    }
}
