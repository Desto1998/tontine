<?php


namespace App\Services;


use App\Models\Project;
use App\Models\ProjectMember;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class ProjectService
{
    /**
     * Get all Project
     * @return Collection
     */
    public function getAll() : Collection
    {
        return Project::orderBy('id')->get();
    }

    /**
     * store a Project
     *
     * @param $data
     * @return Project
     */
    public function store($data): Project
    {
        return Project::updateOrCreate(['id' => $data['id']],$data);
    }

    /**
     * store Project Members
     *
     * @param $data
     * @return mixed
     */
    public function storeProjectMembers($data): mixed
    {
        return ProjectMember::updateOrCreate(['id' => $data['id']],$data);
    }

    /**
     * Update Project
     *
     * @param $id
     * @param $data
     * @return Project
     */

    public function update($id,$data): Project
    {
        return Project::where('id',$id)->update($data);
    }

    /**
     * Get a Project
     *
     * @param $id
     * @return Project|BelongsTo
     */

    public function show($id): Project|BelongsTo
    {
        //        $data['user'] = Orders::find($id)->user;
//        $data['partner'] = Orders::find($id)->partner;
//        $data['driver'] = Orders::find($id)->driver;
        return Project::find($id)->with('contribution');
    }

    /**
     * Delete Project
     * @param $id
     * @return bool
     */
    public function delete($id) : bool
    {
        $find = Project::find($id);
        $find->deleted_by = Auth::id();
        return $find->save();

    }


    /**
     * Delete Project Members
     * @param $id
     * @return bool
     */
    public function deleteProjectMembers($id) : bool
    {
        ProjectMember::where('project_id',$id)->update([
            'deleted_by' => Auth::id()
        ]);

        return ProjectMember::where('project_id',$id)->delete();
    }
}
