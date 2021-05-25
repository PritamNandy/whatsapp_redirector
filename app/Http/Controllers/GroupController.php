<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class GroupController extends Controller
{
    public function index($id) {
        $campaign = Campaign::find($id);
        return view('Backend.AddGroup', [
            'campaign' => $campaign
        ]);
    }

    public function createGroup(Request $request) {
        $validate = $request->validate([
           'name' => 'required',
           'whatsapp_link' => 'required',
           'access_limit' => 'required',
        ]);

        $result = Group::create([
           'name' => $request->input('name'),
           'whatsapp_link' => $request->input('whatsapp_link'),
           'access_limit' => $request->input('access_limit'),
           'campaign_id' => $request->input('campaign_id'),
            'total_redirects' => 0
        ]);

        if($result) {
            session()->flash('message', 'group_success');
            return Redirect::to('/campaign/'.$request->input('campaign_id'));
        } else {
            session()->flash('message', 'failed');
            return Redirect::to('/addGroup/'.$request->input('campaign_id'));
        }
    }

    public function editGroup($id) {
        $group = Group::find($id);
        return view('Backend.EditGroup', [
            'group' => $group
        ]);
    }

    public function deleteGroup($id) {
        $group = Group::find($id);
        $result = Group::where('id', $id)->delete();
        if($result) {
            session()->flash('message', 'delete_success');
            return Redirect::to('/campaign/'.$group->campaign_id);
        } else {
            session()->flash('message', 'failed');
            return Redirect::to('/campaign/'.$group->campaign_id);
        }
    }
}
