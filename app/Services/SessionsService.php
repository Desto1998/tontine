<?php


namespace App\Services;


use App\Models\Meeting;
use App\Models\SessionContribution;
use App\Models\SessionMember;
use App\Models\Sessions;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use function Symfony\Component\HttpKernel\Log\format;

class SessionsService
{
    /**
     * Get all orders
     * @return Collection
     */
    public function getAll() : Collection
    {
        return Sessions::where('deleted_by')->orderBy('id')->get();
    }

    /**
     * store an Sessions
     *
     * @param $data
     * @return Sessions
     */
    public function store($data): Sessions
    {
        return Sessions::create($data);
    }

    /**
     * Update Sessions
     *
     * @param $id
     * @param $data
     * @return Sessions
     */

    public function update($id,$data): Sessions
    {
        return Sessions::where('id',$id)->update($data);
    }

    /**
     * Get a partner
     *
     * @param $id
     * @return Sessions|BelongsTo
     */

    public function show($id): Sessions|BelongsTo
    {
        //        $data['user'] = Orders::find($id)->user;
//        $data['partner'] = Orders::find($id)->partner;
//        $data['driver'] = Orders::find($id)->driver;
        return Sessions::find($id)->with('association');
    }

    /**
     * Delete association
     * @param $id
     * @return bool
     */
    public function delete($id) : bool
    {
        $find = Sessions::find($id);
//        $find->deleted_at = date('Y-m-d H:i:s');
        $find->deleted_by = \auth()->id();
        return $find->save();

    }

    /**
     * Save session members
     * @param $memberIds
     * @param $session_id
     * @return array
     */
    public function saveSessionMembers($memberIds, $session_id) : array
    {
       $saved = [];
       foreach ($memberIds as $key=> $mid){
          $saved[$key] = SessionMember::create([
               'member_id' => $mid,
               'session_id' => $session_id,
               'user_id' => \Auth::id()
           ]);
       }
        return $saved;
    }

    /**
     * Save session members
     * @param $contributionIds
     * @param $session_id
     * @return array
     */
    public function saveSessionContribution($contributionIds, $session_id) : array
    {
        SessionContribution::where('session_id',$session_id)->delete();
       $saved = [];
       foreach ($contributionIds as $key=> $cid){
          $saved[$key] = SessionMember::create([
               'contribution_id' => $cid,
               'session_id' => $session_id,
           ]);
       }
        return $saved;
    }

    /**
     * Save session members
     * @param $session_id
     * @return bool
     */
    public function canEditSessionContribution($session_id) : bool
    {
        $meeting = Meeting::where('session_id',$session_id)->get();
        return count($meeting) ?? false;
    }

    /**
     * update session infos
     * @param $smId
     * @param $amount
     * @param $take_order
     * @return SessionMember|bool|null
     */
    public function updateSessionMember($smId, $amount,$take_order) : SessionMember | null|bool
    {
            return SessionMember::where('id',$smId)->update([
//                'member_id' => $smId,
                'amount' => $amount,
                'take_order' => $take_order
            ]);

    }

    /**
     * Save session members
     * @param $smId
     * @param $amount
     * @return SessionMember|bool|null
     */
    public function setSMasTaken($smId, $amount) : SessionMember | null|bool
    {
            return SessionMember::where('id',$smId)->update([
                'taken' => 1,
                'taken_date' => date('Y-m-d'),
                'taken_amount' => $amount
            ]);

    }

    /**
     * Save session members
     * @param $smId
     * @return SessionMember|bool|null
     */
    public function deleteSessionMember($smId) : SessionMember | null|bool
    {
            return SessionMember::where('id',$smId)->update([
                'deleted_by' => \Auth::id(),
            ]);

    }
}
