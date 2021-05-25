<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CampaignController extends Controller
{
    public function index() {
        return view('Backend.AddCampaign');
    }

    public function createCampaign(Request $request) {
        $validate = $request->validate([
           'name' => 'required',
            'slug' => 'required|unique:campaigns,slug',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $photoName =  $request->image->store('public/uploads/');
            //$photoName =  $request->image->store('public/uploads');

            $photoName = str_replace('public/uploads/', '', $photoName);
        }

        $checkSlug = Campaign::where('slug', $request->input('slug'))->get();
        if(count($checkSlug) > 0) {
            session()->flash('message', 'slug_duplicate');
            return Redirect::to('/addCampaign');
        } else {
            $result = Campaign::create([
                'icon' => $photoName,
                'name' => $request->input('name'),
                'slug' => $request->input('slug'),
                'user_id' => Auth::user()->id
            ]);

            if($result) {
                session()->flash('message', 'campaign_success');
                return Redirect::to('/');
            } else {
                session()->flash('message', 'failed');
                return Redirect::to('/');
            }
        }
    }

    public function updateCampaign(Request $request) {
        $validate = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:campaigns,slug',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'id' => 'required'
        ]);
        $campaign = Campaign::find($request->input('id'));

        if($campaign->slug == $request->input('slug')) {
            if ($request->hasFile('image')) {
                if(file_exists('public/storage/uploads'.$campaign->icon)) {
                    unlink('public/storage/uploads'.$campaign->icon);
                }
                $photoName =  $request->image->store('public/uploads/');
                //$photoName =  $request->image->store('public/uploads');

                $photoName = str_replace('public/uploads/', '', $photoName);
            } else {
                $photoName = $campaign->icon;
            }

            $result = Campaign::where('id', $campaign->id)->update([
                'icon' => $photoName,
                'name' => $request->input('name'),
                'slug' => $request->input('slug')
            ]);

            if($result) {
                session()->flash('message', 'update_success');
                $campaignNew = Campaign::find($campaign->id);
                return view('Backend.EditCampaign', [
                    'campaign' => $campaignNew
                ]);
            } else {
                session()->flash('message', 'failed');
                $campaignNew = Campaign::find($campaign->id);
                return view('Backend.EditCampaign', [
                    'campaign' => $campaignNew
                ]);
            }
        } else {
            $checkSlug = Campaign::where('slug', $request->input('slug'))->get();
            if(count($checkSlug) > 0) {
                session()->flash('message', 'slug_duplicate');
                return view('Backend.EditCampaign', [
                    'campaign' => $campaign
                ]);
            } else {
                if ($request->hasFile('image')) {
                    if(file_exists('public/storage/uploads'.$campaign->icon)) {
                        unlink('public/storage/uploads'.$campaign->icon);
                    }
                    $photoName =  $request->image->store('public/uploads/');
                    //$photoName =  $request->image->store('public/uploads');

                    $photoName = str_replace('public/uploads/', '', $photoName);
                } else {
                    $photoName = $campaign->icon;
                }

                $result = Campaign::where('id', $campaign->id)->update([
                    'icon' => $photoName,
                    'name' => $request->input('name'),
                    'slug' => $request->input('slug')
                ]);

                if($result) {
                    session()->flash('message', 'update_success');
                    $campaignNew = Campaign::find($campaign->id);
                    return view('Backend.EditCampaign', [
                        'campaign' => $campaignNew
                    ]);
                } else {
                    session()->flash('message', 'failed');
                    $campaignNew = Campaign::find($campaign->id);
                    return view('Backend.EditCampaign', [
                        'campaign' => $campaignNew
                    ]);
                }
            }
        }
    }

    public function checkCampaignSlug($slug) {
        $check = Campaign::where('slug', $slug)->get();

        if(count($check) > 0) {
            echo json_encode('not_unique');
        } else {
            echo json_encode('unique');
        }
    }

    public function checkEditCampaignSlug($slug, $id) {
        $campaign = Campaign::find($id);

        if($campaign->slug == $slug) {
            echo json_encode('unique');
        } else {
            $check = Campaign::where('slug', $slug)->get();
            if(count($check) > 0) {
                echo json_encode('not_unique');
            } else {
                echo json_encode('unique');
            }
        }
    }

    public function editCampaign($id) {
        $campaign = Campaign::find($id);
        return view('Backend.EditCampaign', [
            'campaign' => $campaign
        ]);
    }

    public function deleteCampaign($id) {
        $result = Campaign::where('id', $id)->delete();

        if($result) {
            session()->flash('message', 'delete_success');
            return Redirect::to('/');
        } else {
            session()->flash('message', 'failed');
            return Redirect::to('/');
        }
    }

    public function campaignById($id) {
        $campaign = Campaign::find($id);
        $groups = Group::where('campaign_id', $id)->orderBy('created_at', 'desc')->get();

        return view('Backend.Campaign', [
            'campaign' => $campaign,
            'groups' => $groups
        ]);
    }

    public function goCampaign($slug) {
        $campaign = Campaign::where('slug', $slug)->get();
        if(count($campaign) > 0) {
            $groups = Group::where('campaign_id', $campaign[0]['id'])->get();

            foreach ($groups as $group) {
                if($group->access_limit > $group->total_redirects) {
                    Group::where('id', $group->id)->update([
                        'total_redirects' => ($group->total_redirects + 1)
                    ]);

                    return redirect()->away($group->whatsapp_link);
                }
            }

            return view('Backend.Error1', [
                'text' => __('system.no_group_left')
            ]);
        } else {
            return view('Backend.Error1', [
                'text' => __('system.no_group_left')
            ]);
        }
    }
}
