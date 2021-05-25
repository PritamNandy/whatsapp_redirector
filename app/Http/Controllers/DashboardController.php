<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() {
        if(Auth::check()) {
            $id = Auth::user()->id;
            $campaigns = Campaign::where('user_id', $id)->get();
            $groups_total = [];
            $groups_limit = [];
            $groups_performed = [];
            foreach ($campaigns as $campaign) {
                $group = Group::where('campaign_id', $campaign->id)->get();
                $limit = Group::where('campaign_id', $campaign->id)->sum('access_limit');
                $performed = Group::where('campaign_id', $campaign->id)->sum('total_redirects');
                array_push($groups_total, count($group));
                array_push($groups_limit, $limit);
                array_push($groups_performed, $performed);
            }
            return view('Backend.Dashboard', [
                'campaigns' => $campaigns,
                'total' => $groups_total,
                'limit' => $groups_limit,
                'performed' => $groups_performed
            ]);
        } else {
            return view('auth.login');
        }
    }

    public function logout(Request $request){
        Auth::logout();
        return redirect('login');
    }

    public function checkUniqueEmail($email) {
        $result = User::where('email', $email)->get();
        if(count($result) == 0) {
            return "unique";
        } else {
            return "notunique";
        }
    }

    public function checkUniquePhone($phone) {
        $result = User::where('phone', $phone)->get();
        if(count($result) == 0) {
            return "unique";
        } else {
            return "notunique";
        }
    }

    public function checkProfileUniqueEmail($email) {
        $result = User::where('email', $email)->get();
        if(count($result) == 0) {
            return "unique";
        } else if($result[0]['id'] == Auth::user()->id) {
            return "unique";
        } else {
            return "notunique";
        }
    }

    public function checkProfileUniquePhone($phone) {
        $result = User::where('phone', $phone)->get();
        if(count($result) == 0) {
            return "unique";
        } else if($result[0]['id'] == Auth::user()->id) {
            return "unique";
        } else {
            return "notunique";
        }
    }
}
