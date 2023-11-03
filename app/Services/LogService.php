<?php


namespace App\Services;


use App\Models\Log;
use DateInterval;
use DateTime;
use Illuminate\Support\Facades\Auth;

class LogService
{
    /**
     * Create a new log instance. call this method after each action
     *
     * @param $action
     * @param $model
     * @param $description
     * @param $id
     * @return Log
     */

    public function save($action, $model,$description,$id, $user_id=""): Log
    {
        return Log::create([
            'action' => $action,
            'model' => $model,
            'description' => $description,
            'model_id' => $id,
            'user_id' => $user_id ?? Auth::user()->id,
        ]);
    }

    public function delete($id): \Illuminate\Http\JsonResponse
    {
        $save = Log::find($id);

        $save->deleted_at = date('Y-m-d H:i:s');
        return $save->save();
    }

    /**
     *
     * Reformat created at date before display to tables
     * @param $created_at
     * @return string
     * @throws \Exception
     */
    public function formatCreatedAt($created_at) : string
    {
        $date = new DateTime($created_at);
         return date("Y-m-d H:i:s", strtotime($date->format('Y-m-d H:i:s')));
    }

    /**
     * @throws \Exception
     */
    public function itDeletable($created_at) : bool
    {
        $date = new DateTime($created_at);
        $nbjour = 1;
        $date->add(new DateInterval("P{$nbjour}D"));
        $date = date("Y-m-d H:i:s", strtotime($date->format('Y-m-d H:i:s')));
        return  date('Y-m-d H:i:s') <= $date;
    }

    public function allYears(){
        $deploy_year = config('app.deploy_year',2023);
        $actual_year = date('Y');
        $number_years = [];
        $deploy_year = (int)$deploy_year;
        $j = 0;
        for($i =$deploy_year; $i<=(int)$actual_year; $i++){
            $number_years[$j] = $deploy_year++;
            $j++;
        }
        return $number_years;
    }
}
