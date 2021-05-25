<?php

namespace App\Http\Controllers;

use App\Models\role;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index() {
        $id = Auth::user()->role_id;
        $role = role::find($id);
        return view('Backend.Users', ['role' => $role->role_name]);
    }

    public function getUser(){
        $userArray =  [];
        $user = User::orderBy('created_at')->get();

        foreach ($user as $value){
            $badge = '';
            if($value->role_id == 1) {
                $badge = '<span class="badge badge-info">'.__('system.user').'</span>';
            } else if($value->role_id == 2) {
                $badge = '<span class="badge badge-info">'.__('system.admin').'</span>';
            }

            if($value->status == 1) {
                $statusBadge = '<span class="badge badge-success">'.__('system.active').'</span>';
            } else {
                $statusBadge = '<span class="badge badge-danger">'.__('system.deactive').'</span>';
            }

            $userData  = [
                'id' => $value->id,
                'name' =>  $value->name,
                'email' => $value->email,
                'role_id' => $value->role_id,
                'badge' => $badge,
                'status' => $value->status,
                'statusBadge' => $statusBadge,
                'status_text' => $value->status,
                'created_time' => $value->created_at
            ];
            array_push($userArray,$userData);

        }

        return Datatables::of($userArray)
            ->addColumn('action', function($userArray) {
                if(Auth::user()->role_id == 2 || Auth::user()->role_id == 5) {
                    $role = role::find(Auth::user()->role_id);
                    if(($userArray['role_id'] != 2 && $userArray['role_id'] != 5) && Auth::user()->role_id == 5) {
                        if($userArray['status'] == 1) {
                            return '<a href="'.url($role->role_name.'/editUser/'.$userArray['id']).'" type="button" class="hd-table-btn userEdit btn btn-primary btn-sm mb-2" data-id="'.$userArray['id'].'" id="getDeleteId">'.__('system.edit').'</a>
                                    <button type="button" class="hd-table-btn userDeactivate btn btn-danger btn-sm mb-2" data-id="'.$userArray['id'].'" id="getDeleteId">'.__('system.deactivate').'</button>
                                    <button type="button" class="userDelete btn btn-warning btn-sm mb-2" data-id="'.$userArray['id'].'"><i class="fas fa-trash-alt p-0"></i></button>';
                        } else {
                            return '<a href="'.url($role->role_name.'/editUser/'.$userArray['id']).'" type="button" class="hd-table-btn userEdit btn btn-primary btn-sm mb-2" data-id="'.$userArray['id'].'" id="getDeleteId">'.__('system.edit').'</a>
                                    <button type="button" class="hd-table-btn userActivate btn btn-success btn-sm mb-2" data-id="'.$userArray['id'].'" id="getDeleteId">'.__('system.activate').'</button>
                                    <button type="button" class="userDelete btn btn-warning btn-sm mb-2" data-id="'.$userArray['id'].'"><i class="fas fa-trash-alt p-0"></i></button>';
                        }
                    } else if(Auth::user()->role_id == 2) {
                        if($userArray['status'] == 1) {
                            return '<a href="'.url($role->role_name.'/editUser/'.$userArray['id']).'" type="button" class="hd-table-btn userEdit btn btn-primary btn-sm mb-2" data-id="'.$userArray['id'].'" id="getDeleteId">'.__('system.edit').'</a>
                                    <button type="button" class="hd-table-btn userDeactivate btn btn-danger btn-sm mb-2" data-id="'.$userArray['id'].'" id="getDeleteId">'.__('system.deactivate').'</button>
                                    <button type="button" class="userDelete btn btn-warning btn-sm mb-2" data-id="'.$userArray['id'].'"><i class="fas fa-trash-alt p-0"></i></button>';
                        } else {
                            return '<a href="'.url($role->role_name.'/editUser/'.$userArray['id']).'" type="button" class="hd-table-btn userEdit btn btn-primary btn-sm mb-2" data-id="'.$userArray['id'].'" id="getDeleteId">'.__('system.edit').'</a>
                                    <button type="button" class="hd-table-btn userActivate btn btn-success btn-sm mb-2" data-id="'.$userArray['id'].'" id="getDeleteId">'.__('system.activate').'</button>
                                    <button type="button" class="userDelete btn btn-warning btn-sm mb-2" data-id="'.$userArray['id'].'"><i class="fas fa-trash-alt p-0"></i></button>';
                        }
                    }

                }
            })
            ->addColumn('badge', function($userArray) {
                return $userArray['badge'];
            })
            ->addColumn('statusBtn', function($userArray) {
                return $userArray['statusBadge'];
            })
            ->rawColumns(['action', 'badge', 'statusBtn'])
            ->make(true);
    }

    public function addUser() {
        $types = role::orderBy('role_name')->get();
        return view('Backend.AddNewUser', ['types' => $types]);
    }

    public function registerUser(Request $request) {

        $validate = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => 'required',
        ]);

        $result = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'role_id' => 1
        ]);

        if($result) {
            session()->flash('message', 'success');
            return Redirect::to('/login');
        } else {
            session()->flash('message', 'failed');
            return Redirect::to('/login');
        }
    }

    public function createUser(Request $request) {
        $request->validate(
            [
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'type' => 'required',
                'password' => 'required'
            ]
        );

        $user = new User;
        //generate a password for the new users

        //add new user to database
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->role_id = $request->input('type');
        $user->password = bcrypt($request->input('password'));

        $user->save();

        //User::sendWelcomeEmail($user);
        if(Auth::user()->role_id == 2) {
            return Redirect::to('/admin/user');
        }
    }

    public function updateUser(Request $request) {
        $request->validate(
            [
                'id' => 'required',
                'name' => 'required|string',
                'type' => 'required',
            ]
        );

        $user = User::find($request->input('id'));

        $email = $request->input('email');

        if($email != $user->email) {
            $request->validate(
                [
                    'email' => 'required|email|unique:users,email'
                ]
            );
        }

        $result = User::where('id', $request->input('id'))->update([
            'name' => $request->input('name'),
            'email' => $email,
            'role_id' => $request->input('type')
        ]);


        if(Auth::user()->role_id == 2) {
            return Redirect::to('/admin/editUser/'.$request->input('id'));
        }
    }

    public function userDeactivate($id) {
        $result = User::where('id', $id)->update([
            'status' => 0
        ]);

        if($result) {
            echo json_encode('success');
        }
    }

    public function userActivate($id) {
        $result = User::where('id', $id)->update([
            'status' => 1
        ]);

        if($result) {
            echo json_encode('success');
        }
    }

    public function editUser($id) {
        $user = User::find($id);
        $types = role::orderBy('role_name')->get();
        return view('Backend.EditUser', ['user' => $user, 'types' => $types]);
    }

    public function getUserById($id) {
        $user = User::find($id);
        echo json_encode($user);
    }

    public function checkUserUniqueEmail($email, $id) {
        $result = User::where('email', $email)->get();
        if(count($result) == 0) {
            return "unique";
        } else if($result[0]['id'] == $id) {
            return "unique";
        } else {
            return "notunique";
        }
    }

    public function deleteUser($id) {
        $result = User::where('id', $id)->delete();
        if($result) {
            echo json_encode('success');
        } else {
            echo json_encode('failed');
        }
    }
}
