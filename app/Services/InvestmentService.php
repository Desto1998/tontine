<?php


namespace App\Services;


use App\Models\Investment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class InvestmentService
{
    /**
     * Get all Investment
     * @return Collection
     */
    public function getAll() : Collection
    {
        return Investment::orderBy('id')->get();
    }

    /**
     * store an Investment
     *
     * @param $data
     * @return Investment
     */
    public function store($data): Investment
    {
        return Investment::create($data);
    }

    /**
     * Update Create
     *
     * @param $id
     * @param $data
     * @return Investment
     */

    public function update($id,$data): Investment
    {
        return Investment::where('id',$id)->update($data);
    }

    /**
     * Get a Investment
     *
     * @param $id
     * @return Investment|BelongsTo
     */

    public function show($id): Investment|BelongsTo
    {
        //        $data['user'] = Orders::find($id)->user;
//        $data['partner'] = Orders::find($id)->partner;
//        $data['driver'] = Orders::find($id)->driver;
        return Investment::find($id)->with('contribution');
    }

    /**
     * Delete Investment
     * @param $id
     * @return bool
     */
    public function delete($id) : bool
    {
        $find = Investment::find($id);
        $find->deleted_by = Auth::id();
//        $driver->deleted_by = \auth()->id();
        return $find->save();

    }
}
