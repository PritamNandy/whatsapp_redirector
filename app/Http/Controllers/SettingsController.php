<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class SettingsController extends Controller
{
    public function index() {
        $settings = Setting::find(1);
        return view('Backend.Settings',['settings' => $settings]);
    }

    public function updateSettings(Request $request) {
        $validate = $request->validate([
            'title' => 'required|max:100',
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $oldSettings = Setting::find(1);
        $dashboard_images = [];
        if ($request->hasFile('dashboard_images')) {
            $allowedExtension = ['svg','jpg','png','gif','jpeg'];
            $files = $request->file('dashboard_images');
            foreach ($files as $file) {
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension, $allowedExtension);
                if ($check) {
                    $photoName =  $file->store('public/uploads/');
                    //$photoName =  $request->image->store('public/uploads');
                    $photoName = str_replace('public/uploads/', '', $photoName);
                    array_push($dashboard_images, $photoName);
                } else {
                    array_push($dashboard_images, 'no_image');
                }
            }
            if($oldSettings->dashboard_images != null || $oldSettings->dashboard_images != "") {
                $dimages = explode(',',$oldSettings->dashboard_images);
                foreach ($dimages as $di) {
                    Storage::delete('public/system/'.$di);
                }
                //unlink(storage_path('public/system/'.$oldSettings->logo));
            }
            $dashboard_image = implode(',',$dashboard_images);
        } else {
            $dashboard_image = $oldSettings->dashbaord_images;
        }


        if ($request->hasFile('logo')) {
            $photoName = $request->logo->store('public/system');
            $photoName = str_replace('public/system/', '', $photoName);
            if($oldSettings->logo != null || $oldSettings->logo != "") {
                //unlink(storage_path('public/system/'.$oldSettings->logo));
                Storage::delete('public/system/'.$oldSettings->logo);
            }
            //$photoName =  $request->image->store('public/uploads');
        } else {
            $photoName = $oldSettings->logo;
        }

        if ($request->hasFile('favicon')) {
            $faviconName = $request->favicon->store('public/system');
            $faviconName = str_replace('public/system/', '', $faviconName);
            if($oldSettings->favicon != null || $oldSettings->favicon != "") {
                //unlink(storage_path('public/system/'.$oldSettings->logo));
                Storage::delete('public/system/'.$oldSettings->favicon);
            }
            //$photoName =  $request->image->store('public/uploads');
        } else {
            $faviconName = $oldSettings->favicon;
        }

        $result = Setting::where('id', $request->input('id'))->update([
            'title' => $request->input('title'),
            'logo' => $photoName,
            'favicon' => $faviconName
        ]);

        if(Auth::user()->role_id == "2") {
            return Redirect::to('/admin/settings');
        }
    }

    public function callQueue() {
        $result = DB::table('jobs')->get();
        if(count($result) > 0) {
            $exitCode = Artisan::call('queue:work --once');
            echo json_encode($exitCode);
        } else {
            echo json_encode('No Queue Pending!');
        }
    }
}
