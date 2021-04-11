<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QRModel;
use App\Models\UserModel;
use App\Models\QRTraffic;
use Mobile_Detect;
use Illuminate\Support\Facades\DB;

class QRController extends Controller
{
    public function add_qr_code(Request $req)
    {
        if(empty($req->session()->has('USER_NAME')))
        {
            return redirect('/');
        }
        $add_qr = new QRModel();
        $add_qr->name = $req->name;
        $add_qr->link = $req->link;
        $add_qr->color = $req->color;
        $add_qr->size = $req->size;
        $add_qr->status = 1;
        $add_qr->added_by = $req->session()->get('USER_ID');
        $add_qr_confirm = $add_qr->save();
        if($add_qr_confirm)
        {
            $req->session()->flash('db_change_status', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>QR Code Added Successfully</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect('dashboard');
        }
        else
        {
            $req->session()->flash('db_change_status', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Failed to Add QR Code</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect('dashboard');
        }
    }
    public function qrchangeStatus(Request $req)
    {
        if(empty($req->session()->has('USER_NAME')))
        {
            return redirect('/');
        }
        $getstatus = QRModel::where('id', $req->id)->get('status');
        if($getstatus[0]->status == 0)
        {
            // return 'was 0 now 1';
            $changestatus = QRModel::find($req->id);
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
            $changestatus = QRModel::find($req->id);
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
    public function edit_qr_code(Request $req)
    {
        if(empty($req->session()->has('USER_NAME')))
        {
            return redirect('/');
        }
        $updateqr = QRModel::find($req->id);
        $updateqr->name = $req->edit_name;
        $updateqr->link = $req->edit_link;
        $updateqr->color = $req->edit_color;
        $updateqr->size = $req->edit_size;
        $updateqr->added_by = $req->session()->get('USER_ID');
        $confirm_update_qr = $updateqr->save();
        if($confirm_update_qr)
        {
            $req->session()->flash('db_change_status', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>QR Code Updated Successfully</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect('dashboard');
        }
        else
        {
            $req->session()->flash('db_change_status', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Failed to Update QR Code</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect('dashboard');
        }
    }
    public function delete_qr(Request $req)
    {
        if(empty($req->session()->has('USER_NAME')))
        {
            return redirect('/');
        }
        $data = QRModel::find($req->id);
        $confirm_delete = $data->delete();
        if($confirm_delete)
        {
            $req->session()->flash('db_change_status', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>QR Code Deleted successfully</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect('dashboard');
        }
        else
        {
            $req->session()->flash('db_change_status', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Failed to Delete QR Code</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect('dashboard');
        }
    }
    public function detection($id)
    {
        $dataqr = QRModel::where('id','=',$id)->where('status','=','1')->get();
        $device="";
        $os="";
        $detect = new Mobile_Detect();
        if($detect->isMobile())
        {
            $device="Mobile";
        }
        else if($detect->isTablet())
        {
            $device="Tablet";
        }
        else
        {
            $device="PC";
        }
        if($detect->isiOS())
        {
            $os="iOS";
        }
        else if($detect->isAndroidOS())
        {
            $os="Android";
        }
        else
        {
            $os="Windows";
        }
        $arr_browsers = ["OPR", "Edg", "Chrome", "Safari", "Firefox", "MSIE", "Trident"];
        $agent = $_SERVER['HTTP_USER_AGENT'];
        $user_browser = '';
        foreach ($arr_browsers as $browser) {
            if (strpos($agent, $browser) !== false) {
                strpos($agent, $browser);
                $user_browser = $browser;
                break;
            }   
        }
        switch ($user_browser) {
            case 'MSIE':
                $user_browser = 'Internet Explorer';
                break;

            case 'Chrome':
                $user_browser = 'Chrome';
                break;

            case 'OPR':
                $user_browser = 'Opera';
                break;
        
            case 'Edg':
                $user_browser = 'Microsoft Edge';
                break;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://ip-api.com/json");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result,true);
        $city = $result['city'];
        $state = $result['regionName'];
        $country = $result['country'];
        $ip_address = $result['query'];

        $save_qr_traffic = new QRTraffic();
        $save_qr_traffic->qr_code_id = $id;
        $save_qr_traffic->device = $device;
        $save_qr_traffic->browser = $user_browser;
        $save_qr_traffic->os = $os;
        $save_qr_traffic->city = $city;
        $save_qr_traffic->state = $state;
        $save_qr_traffic->country = $country;
        $save_qr_traffic->ip_address = $ip_address;
        $save_qr_traffic->date_created = date('Y-m-d');
        $confirm_save_qr_traffic = $save_qr_traffic->save();
        if($confirm_save_qr_traffic)
        {
            echo '<script>window.location.href="'.$dataqr[0]->link.'";</script>';
        }
        else
        {
            die("Something went wrong :(");
        }
    }
    public function statistics(Request $req)
    {
        $dataqr_count = QRModel::where('id','=',$req->id)->where('status','=','1')->count();
        if($dataqr_count)
        {
            $user_id = QRModel::where('id','=',$req->id)->get('added_by');
            $get_hits = UserModel::where('id','=',$user_id[0]->added_by)->get('total_hit');
            $qr_count = QRTraffic::where('qr_code_id','=',$req->id)->count();
            if($get_hits[0]->total_hit == 0) 
            {
                $this->detection($req->id);
            }
            else
            {
                if($get_hits[0]->total_hit > $qr_count)
                {
                    $this->detection($req->id);
                }
                else
                {
                    die("Use of this QR Code Limit Exceeded");
                }
            }         
        }
        else
        {
            die("This QR Code is Deactivated");
        }
    }
    public function qrReport(Request $req)
    {
        if(empty($req->session()->has('USER_NAME')))
        {
            return redirect('/');
        }
        $condition="";
        if(session()->get('ROLE') == '1')
        {
            $user_id = session()->get('USER_ID');
            $condition = "AND qr_code.added_by='".$user_id."'";
        }
        $qr_code_data = DB::select("SELECT count(*) AS total_record, qr_traffic.*, qr_code.name FROM qr_traffic, qr_code WHERE qr_traffic.qr_code_id=qr_code.id AND qr_code.id=$req->id $condition GROUP BY qr_traffic.date_created ORDER BY qr_traffic.date_created DESC");
        $overall_qr_record = 0;
        foreach($qr_code_data as $row)
        {
            $overall_qr_record+=$row->total_record;
        }
        if(count($qr_code_data) > 0)
        {
            $device_data = DB::select("SELECT COUNT(*) AS total_record, device FROM qr_traffic WHERE qr_code_id=$req->id GROUP BY device");
            $os_data = DB::select("SELECT COUNT(*) AS total_record, os FROM qr_traffic WHERE qr_code_id=$req->id GROUP BY os");
            $browser_data = DB::select("SELECT COUNT(*) AS total_record, browser FROM qr_traffic WHERE qr_code_id=$req->id GROUP BY browser");

            return view('reports', ['qr_code_data'=>$qr_code_data, 'device_chart_info'=> $device_data, 'os_chart_info'=> $os_data, 'browser_chart_info'=> $browser_data, 'total_records'=>$overall_qr_record, 'id'=>$req->id]);
        }
        else
        {
            $req->session()->flash('db_change_status', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>No Reports.</strong> This QR Code has not been hit yet.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect('dashboard');
        }
    }
    public function detailed_report(Request $req)
    {
        if(empty($req->session()->has('USER_NAME')))
        {
            return redirect('/');
        }
        $condition="";
        if(session()->get('ROLE') == '1')
        {
            $user_id = session()->get('USER_ID');
            $condition = "AND qr_code.added_by='".$user_id."'";
        }
        $d_report = DB::select("SELECT qr_traffic.* FROM qr_traffic, qr_code WHERE qr_traffic.qr_code_id=qr_code.id AND qr_code.id=$req->id $condition ORDER BY id DESC");
        if(count($d_report)>0)
        {
            return view('detailed_report', ['d_report'=>$d_report, 'id'=>$req->id]);
        }
        else
        {
            $req->session()->flash('db_change_status', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>No Reports.</strong> This QR Code has not been hit yet.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect('dashboard');
        }
    }
}
