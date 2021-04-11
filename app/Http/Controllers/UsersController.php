<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\UserModel;
use App\Models\QRModel;

class UsersController extends Controller
{
    function __construct(){
        session_start();
    }
    public function login(Request $req)
    {
        $req->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);
        $email = $req->email;
        $password = $req->password;
        $confirm_email = UserModel::where('email', '=', $email)->count();
        if($confirm_email > 0)
        {
            $check_status = UserModel::where('email', '=', $email)->where('status', '=', 1)->count();
            if($check_status > 0)
            {
                $hashedPassword = UserModel::where('email', '=', $email)->get('password');
                if(Hash::check($password, $hashedPassword[0]->password))
                {
                    $get_user_data = UserModel::where('email', '=', $email)->get(['id','name','role']);
                    $req->session()->put('ROLE', $get_user_data[0]->role);
                    $req->session()->put('USER_ID', $get_user_data[0]->id);
                    $req->session()->put('USER_NAME', $get_user_data[0]->name);
                    $req->session()->put('EMAIL', $email);
                    return redirect('dashboard');
                }
                else
                {
                    $req->session()->flash('login_status', 'Failed to Login');
                    return redirect('/');
                }
            }
            else
            {
                $req->session()->flash('login_status', 'Account is Deactivated');
                return redirect('/');
            }
        }
        else
        {
            $req->session()->flash('login_status', 'Failed to Login');
            return redirect('/');
        }
    }
    public function dashboard(Request $req){
        if(empty($req->session()->has('USER_NAME')))
        {
            return redirect('/');
        }
        $getqr = QRModel::orderBy('id', 'desc')->get();
        $getqrbyuser = QRModel::where('added_by', '=', $req->session()->get('USER_ID'))->orderBy('id', 'desc')->get();
        if(session()->get('ROLE') == '1')
        {
            $allocated_qr = UserModel::where('id','=',$req->session()->get('USER_ID'))->get('total_qr');
            $used_qr = QRModel::where('added_by','=',$req->session()->get('USER_ID'))->count();
            return view('dashboard', ['getqr'=>$getqr, 'getqrbyuser'=>$getqrbyuser, 'allocated_qr'=>$allocated_qr[0]->total_qr,'used_qr'=>$used_qr]);
        }
        else
        {
            return view('dashboard', ['getqr'=>$getqr, 'getqrbyuser'=>$getqrbyuser]);
        }
        
    }
    public function logout(Request $req)
    {
        if(empty($req->session()->has('USER_NAME')))
        {
            return redirect('/');
        }
        $req->session()->flush();
        return redirect('/');
    }
    public function users(Request $req){
        if(empty($req->session()->has('USER_NAME')))
        {
            return redirect('/');
        }
        if(session()->get('ROLE') == '1')
        {
            return redirect('dashboard');
        }
        $getusers = UserModel::where('role', '1')->orderBy('id', 'desc')->get();
        return view('users', ['getusers'=>$getusers]);
    }
    public function add_user(Request $req)
    {
        if(empty($req->session()->has('USER_NAME')))
        {
            return redirect('/');
        }
        if(session()->get('ROLE') == '1')
        {
            return redirect('dashboard');
        }
        $add_user = new UserModel();
        $add_user->name = $req->name;
        $add_user->email = $req->email;
        $add_user->mobile = $req->mobile;
        $add_user->password = Hash::make($req->password);
        $add_user->total_qr = $req->total_qr;
        $add_user->total_hit = $req->total_hit;
        $add_user->role = '1';
        $add_user->status = 1;
        $confirm_add = $add_user->save();
        if($confirm_add)
        {
            $req->session()->flash('db_change_status', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>User Added Successfully</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect('users');
        }
        else
        {
            $req->session()->flash('db_change_status', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Failed to Add User</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect('users');
        }
    }
    public function changeStatus(Request $req)
    {
        if(empty($req->session()->has('USER_NAME')))
        {
            return redirect('/');
        }
        if(session()->get('ROLE') == '1')
        {
            return redirect('dashboard');
        }
        $getstatus = UserModel::where('id', $req->id)->get('status');
        if($getstatus[0]->status == 0)
        {
            // return 'was 0 now 1';
            $changestatus = UserModel::find($req->id);
            $changestatus->status = 1;
            $confirm_change_status = $changestatus->save();
            if($confirm_change_status)
            {
                $msg = array();
                $msg['output'] = 'success';
                $msg['status'] = 1;
                return response()->json($msg);
            }
            else
            {
                $msg = array();
                $msg['output'] = 'failed';
                $msg['status'] = 0;
                return response()->json($msg);
            }
        }
        else
        {
            // return 'was 1 now 0';
            $changestatus = UserModel::find($req->id);
            $changestatus->status = 0;
            $confirm_change_status = $changestatus->save();
            if($confirm_change_status)
            {
                $msg = array();
                $msg['output'] = 'success';
                $msg['status'] = 0;
                return response()->json($msg);
            }
            else
            {
                $msg = array();
                $msg['output'] = 'failed';
                $msg['status'] = 1;
                return response()->json($msg);
            }
        }
    }
    public function editUsers(Request $req)
    {
        if(empty($req->session()->has('USER_NAME')))
        {
            return redirect('/');
        }
        if(session()->get('ROLE') == '1')
        {
            return redirect('dashboard');
        }
        if($req->edit_password == null)
        {
            // echo 'blank';
            $updateUser = UserModel::find($req->id);
            $updateUser->name = $req->edit_name;
            $updateUser->email = $req->edit_email;
            $updateUser->mobile = $req->edit_mobile;
            $updateUser->total_qr = $req->edit_total_qr;
            $updateUser->total_hit = $req->edit_total_hit;
            $confirm_user_save = $updateUser->save();
            if($confirm_user_save)
            {
                $req->session()->flash('db_change_status', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>User Updated Successfully</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                return redirect('users');
            }
            else
            {
                $req->session()->flash('db_change_status', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Failed to Update User</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                return redirect('users');
            }
        }
        else
        {
            $updateUser = UserModel::find($req->id);
            $updateUser->name = $req->edit_name;
            $updateUser->email = $req->edit_email;
            $updateUser->mobile = $req->edit_mobile;
            $updateUser->password = Hash::make($req->edit_password);
            $updateUser->total_qr = $req->edit_total_qr;
            $updateUser->total_hit = $req->edit_total_hit;
            $confirm_user_save = $updateUser->save();
            if($confirm_user_save)
            {
                $req->session()->flash('db_change_status', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>User Updated Successfully</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                return redirect('users');
            }
            else
            {
                $req->session()->flash('db_change_status', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Failed to Update User</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                return redirect('users');
            }
        }
    }
    public function delete_user(Request $req)
    {
        if(empty($req->session()->has('USER_NAME')))
        {
            return redirect('/');
        }
        if(session()->get('ROLE') == '1')
        {
            return redirect('dashboard');
        }
        $data = UserModel::find($req->id);
        $confirm_delete = $data->delete();
        if($confirm_delete)
        {
            $req->session()->flash('db_change_status', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>User Deleted successfully</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect('users');
        }
        else
        {
            $req->session()->flash('db_change_status', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Failed to Delete User</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect('users');
        }
    }
}
