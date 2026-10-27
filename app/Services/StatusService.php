<?php

namespace App\Services;

use App\Models\Status;
use App\Models\StatusHistory;
use Illuminate\Support\Facades\Auth;

class StatusService
{
    public function changeIncidentStatus()
    {

    }

    public function storeStatusHistory($statusId, $oldStatusId, $comment, $incident_id = null, $devis_id = null, $facture_id = null, $commande_id = null, $avoir_id = null,
                                       $bon_livraison_id = null, $demande_achat_id = null, $projet_id = null, $task_id = null)
    {
        return StatusHistory::create([
            'status_id' => $statusId,
            'old_status_id' => $oldStatusId,
            'incident_id' => $incident_id,
            'devis_id' => $devis_id,
            'facture_id' => $facture_id,
            'commande_id' => $commande_id,
            'avoir_id' => $avoir_id,
            'bon_livraison_id' => $bon_livraison_id,
            'demande_achat_id' => $demande_achat_id,
            'projet_id' => $projet_id,
            'task_id' => $task_id,
            'comment' => $comment,
            'user_id' => Auth::id(),
        ]);
    }

    public static function getStatusHistory($doc_id, $doc_id_name): \Illuminate\Database\Eloquent\Collection|array
    {
        return StatusHistory::with('status','user')->where($doc_id_name, $doc_id)->get();
    }

    public function getStatus(){
        return Status::all();
    }

    /**
     * return order status badge
     *
     * @param $status
     * @return string
     */
    public static function statusBadge($status): string
    {
        return match ($status->code) {
            0 => "<span class=\"badge badge-primary\">$status->title </span>",
            10 => "<span class=\"badge badge-warning\">$status->title </span>",
            30,40 => "<span class=\"badge badge-outline-success\">$status->title</span>",
            50 => "<span class=\"badge badge-dark\">$status->title</span>",
            20 => "<span class=\"badge badge-secondary\">$status->title</span>",
            70 => "<span class=\"badge badge-outline-dark\">$status->title</span>",
            80,90 => "<span class=\"badge badge-danger\">$status->title</span>",
            default => "<span class=\"badge badge-success\">$status->title</span>"
        };
    }

    public static function DisplayHistory($statusHistories)
    {
        $statusConfig = [
            0  => ['style' => 'text-info',      'icon' => 'fa-file'],
            10 => ['style' => 'text-primary',   'icon' => 'fa-check'],
            20 => ['style' => 'text-warning',   'icon' => 'fa-shield'],
            30 => ['style' => 'text-success',   'icon' => 'fa-flag-checkered'],
            60 => ['style' => 'text-secondary', 'icon' => 'fa-money'],
            80 => ['style' => 'text-danger',    'icon' => 'fa-ban'],
        ];

        $histories = [];

        foreach ($statusHistories as $history) {

            $config = $statusConfig[$history->status->code] ?? [
                    'style' => 'text-secondary',
                    'icon'  => 'fa-circle'
                ];

            $histories[] = [
                'style'       => $config['style'],
                'icon'        => $config['icon'],
                'status_name' => $history->status->title,
                'comment'     => $history->comment,
                'user_name'   => $history->user?->firstname ?? '-',
                'created_at'  => $history->created_at,
            ];
        }
        return view('_partial._status-histories',['statusHistories' => $histories]);
    }
}
