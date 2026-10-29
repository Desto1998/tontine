<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Services\LogService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class LogController extends Controller
{
    //
    //
    /**
     * Create a new controller instance.
     * @param LogService $logService
     */
    public function __construct(private LogService $logService)
    {

    }

    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('log.log-list');
    }

    public function show($id)
    {
        $log = Log::with('user')->find($id);
        return view('log.log-show', compact('log'));
    }
    public function loadLogs(): bool|\Illuminate\Http\JsonResponse
    {
        if (request()->ajax()) {

            $data = Log::join('users','users.id','logs.user_id')
                ->where('logs.deleted_at', null)
                ->select('logs.*','users.email');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('actionbtn', function($value){
                    $action = view('log.log-action',compact('value'));
                    return (string)$action;
                })
                ->addColumn('checkbox', function ($value) {
                    $check = view('log.log-check', compact('value'));
                    return (string)$check;
                })
                ->addColumn('created', function($value){
                    return $this->logService->formatCreatedAt($value->created_at);
                })->addColumn('objet_limit', function ($value) {
                    return Str::limit($value->description, 60);
                })->with('objet_limit')
                ->rawColumns(['actionbtn','checkbox','created'])
                ->make(true);

        }
        return false;
    }

    public function destroy(Request $request): bool|\Illuminate\Http\JsonResponse
    {
        if (request()->ajax()) {
            $id = $request->id;
            $log = $this->logService->delete($id);
            $this->logService->save("Delete", 'Logs', "Deleting Log whit id: $id on " . now(), $id);
            return response()->json([
                'status' => 'success',
                'message' => 'Journal supprimé avec succéss!',
                'data' => $log,
            ]);
        }
        return false;
    }
}
