<?php


namespace App\Services;


use App\Models\Contribution;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContributionService
{
    /**
     * Get all orders
     * @return Collection
     */
    public function getAll() : Collection
    {
        return Contribution::where('deleted_by')->where('association_id',\Auth::user()->association_id)->orderBy('id')->get();
    }

    /**
     * store an Contribution
     *
     * @param $data
     * @return Contribution
     */
    public function store($data): Contribution
    {
        return Contribution::create($data);
    }

    /**
     * Update Contribution
     *
     * @param $id
     * @param $data
     * @return bool
     */

    public function update($id,$data): bool
    {
        return Contribution::where('id',$id)->update($data);
    }

    /**
     * Get a partner
     *
     * @param $id
     * @return Contribution|BelongsTo
     */

    public function show($id): Contribution|BelongsTo
    {
//        $data = Contribution::find($id)->with('user');
        $data = Contribution::find($id)->with('user');
//        $data['driver'] = Orders::find($id)->driver;
        return $data;
    }

    /**
     * Delete association
     * @param $id
     * @return bool
     */
    public function delete($id) : bool
    {
        $find = Contribution::find($id);
        $find->deleted_by = \Auth::id();
//        $driver->deleted_by = \auth()->id();
        return $find->save();

    }
}
