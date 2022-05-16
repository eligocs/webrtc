<?php

namespace App\Http\Controllers\Web\Institute;


use App\Http\Controllers\Controller;
use App\Models\zoomuser;
use App\Models\Institute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Meeting;
use App\Models\Live_unit;
use \Firebase\JWT\JWT;
use GuzzleHttp\Client;
use Auth;
use App\Models\student_attendance;
// echo abcex();
class meettingController extends Controller
{

    public $client;
    public $jwt;
    public $headers;


    public function __construct()
    {
        $this->client = new Client();
        $this->jwt = $this->generateZoomToken();
        $this->headers = [
            'Authorization' => 'Bearer ' . $this->jwt,
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
        ];
    }
    //generatezoomToke
    public function generateZoomToken()
    {
        $key = env('ZOOM_API_KEY', '');
        $secret = env('ZOOM_API_SECRET', '');
        $mail = env('EMAIL_ID');
        $payload = [
            'iss' => $key,
            'exp' => strtotime('+1 minute'),
        ];

        return \Firebase\JWT\JWT::encode($payload, $secret, 'HS256');
    }

    //zoom url
    private function retrieveZoomUrl()
    {
        return env('ZOOM_API_URL', '');
    }

    //get meeting for edit
    public function getdata(Request $request)
    {
        $meetingId = $request->id;
        if ($meetingId) {
            $datameeting = Meeting::where('meeting_id', $meetingId)->first();
            if ($datameeting) {
                return response()->json([
                    'status' => true,
                    'data' => $datameeting,
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'data' => ''

                ]);
            }
            // dd($datameeting);
        }
    }


    public function listMeeting($i_class_id, $i_subject_id)
    {

        //get class
        $i_class_id_segment = $i_class_id;
        $i_subject_id_segment = $i_subject_id;

        $unitName = [];
        $groupByunitMeeting = [];
        $unitNames = Live_unit::all();
        // dd($unitNames);
        if (!empty($unitNames)) {
            foreach ($unitNames as $u_name) {
                $listMeeting = \DB::table('meetings')
                    ->where('i_a_c_s_id', $i_class_id_segment)
                    ->where('topic_name', $u_name->id)
                    ->orderBy('date', 'asc')
                    ->get();
                $unitName['unit'] = $u_name->id;
                $unitName['meeting'] = $listMeeting;
                $unitName['unitName'] = $u_name->unitName;
                $groupByunitMeeting[] = $unitName;
            }
        }
        // dd($groupByunitMeeting);
        // $i_class_id_segment = $i_class_id;
        // $i_subject_id_segment = $i_subject_id;

        // //get  all meeting
        // $listMeeting = \DB::table('meetings')
        // ->where('i_a_c_s_id', $i_class_id_segment)
        // ->get();
        // $key = 'topic_name';
        // $groupByunitMeeting = $this->group_by($listMeeting, $key);
        return view('institute.zoom.list_meetting', ["groupByunitMeeting" => $groupByunitMeeting, "i_class_id_segment" => $i_class_id_segment, "i_subject_id_segment" => $i_subject_id_segment]);
    }

    // group meeting by unit
    function group_by($listMeeting, $key)
    {
        $groupByunitMeeting = array();
        foreach ($listMeeting as $val) {
            $groupByunitMeeting[$val->$key][] = $val;
        }
        return $groupByunitMeeting;
    }



    public function createMeeting(Request $request)
    {
        $password = 123;
        $date = $request->date;
        $time = $request->time;
        $combined_date_and_time = $date . ' ' . $time; //combine date and time
        $create_date = date('Y-m-d H:i A', strtotime("$combined_date_and_time"));
        /*geting date from data if date is exist or not for validate date
            one date create only one meeting
            */
        $data = Meeting::where('i_a_c_s_id', $request->i_a_c_s_id)
            ->where('subject_id', $request->subject_id)
            ->first();
        if (!empty($data) && ($data->date == $request->date)) {
            return json_encode(array(
                "statusCode" => 102
            ));
        } else {
            $validatedData = Validator::make($request->all(), [
                'topic_name' => 'required',
                'date' => 'required',
                'lecture_number' => 'required',
                'lecture_name' => 'required',
                'duration' => 'required',
                // 'password' => 'required',
            ]);
            if ($validatedData->fails()) {
                return json_encode(array(
                    "statusCode" => 101
                ));
            } else {
                $arr['topic'] = $request->topic_name;
                $arr['start_date'] = $create_date;
                $arr['duration'] = $request->duration;
                $arr['password'] = $password;
                $arr['type'] = 2;
                $arr['timezone'] = 'Asia/Calcutta';
//$result = $this->createMeetingg($arr); //meeting create and get data from meting function to store data in dataabse
                if (isset($result->id)) {
                    if (isset($result->duration)) {
                        if (isset($result->id)) {
                            $meeting = new Meeting;
                            $meeting->topic_name = $request->topic_name;
                            $meeting->date = $request->date;
                            $meeting->time = $request->time;
                            $meeting->duration = $request->duration;
                            $meeting->schedule = 2;
                            $meeting->password = $password;
                            $meeting->join_url = $result->join_url;
                            $meeting->meeting_id = $result->id;
                            $meeting->host_id = $result->host_id;
                            $meeting->host_email = $result->host_email;
                            $meeting->i_a_c_s_id = $request->i_a_c_s_id;
                            $meeting->subject_id = $request->subject_id;
                            $meeting->lecture_number = $request->lecture_number;
                            $meeting->lecture_name = $request->lecture_name;
                            $meeting->save();
                            return json_encode(array(
                                "statusCode" => 201
                            ));
                        } else {
                            return json_encode(array(
                                "statusCode" => 300
                            ));
                        }
                    } else {
                        return json_encode(array(
                            "statusCode" => 400
                        ));
                    }
                } else {
                    return json_encode(array(
                        "statusCode" => 1001
                    ));
                }
            }
        }
    }

    // update meeting
    public function update(Request $request, $id)
    {
        $password = 123;
        $date = $request->date;
        $time = $request->time;
        $combined_date_and_time = $date . ' ' . $time;
        $update_date = date('Y-m-d H:i A', strtotime("$combined_date_and_time"));
        $path = 'meetings/' . $id;
        $url = $this->retrieveZoomUrl(); //zoom url
        /*geting date from data if date is exist or not for validate date
            one date create only one meeting
            */
        $selete_date_datbase = Meeting::where('i_a_c_s_id', $request->i_a_c_s_id)
            ->where('subject_id', $request->subject_id)
            ->where('meeting_id', '!=', $request->id)
            ->first();
        if (!empty($selete_date_datbase) && ($selete_date_datbase->date == $request->date)) {
            return json_encode(array(
                "statusCode" => 102
            ));
        } else {
            //update meeting in zoom
            $body = [
                'headers' => $this->headers,
                'body'    => json_encode([
                    'topic'      => $request->topic_name,
                    'type'       => 2,
                    'start_time' => $update_date,
                    'duration'   => $request->duration,
                    'agenda'     => (!empty($data['agenda'])) ? $data['agenda'] : null,
                    'timezone'     => 'Asia/Kolkata',
                    'settings'   => [
                        'host_video'        => ($request['host_video'] == "1") ? true : false,
                        'participant_video' => ($request['participant_video'] == "1") ? true : false,
                        'waiting_room'      => true,
                    ],
                ]),
            ];
            $response =  $this->client->patch($url . $path, $body);
            $status = $response->getStatusCode();
            /*if status code is 204 then  data store in database */
            if ($status == 204) {
                $validatedData = Validator::make($request->all(), [
                    'topic_name' => 'required',
                    'date'     => 'required',
                    'duration' => 'required',
                    'lecture_number' => 'required',
                    'lecture_name' => 'required',
                ]);
                if ($validatedData->fails()) {
                    return json_encode(array(
                        "statusCode" => 101
                    ));
                } else {
                    $meeting = Meeting::where('meeting_id', $id)->update([
                        'topic_name' => $request->topic_name,
                        'date' => $request->date,
                        'time' => $request->time,
                        'duration' => $request->duration,
                        'password' => $password,
                        'lecture_number' => $request->lecture_number,
                        'lecture_name' => $request->lecture_name
                    ]);
                    return json_encode(array(
                        "statusCode" => 200
                    ));
                }
            } else {

                return json_encode(array(
                    "statusCode" => 400
                ));
            }
        }
    }


    public function deletemeeting(Request $request)
    {
        $meeting_id = $request->id;
        $path = 'meetings/' . $meeting_id; //delete meeting path
        $url = $this->retrieveZoomUrl();
        $body = [
            'headers' => $this->headers,
            'body'    => json_encode([]),
        ];
        $response =  $this->client->delete($url . $path, $body);
        $delete = Meeting::where('meeting_id', $meeting_id)->delete();
    }



    function createMeetingg($data = array())
    {
        $key = env('ZOOM_API_KEY', '');
        $secret = env('ZOOM_API_SECRET', '');
        $mail = env('EMAIL_ID');

        $timeZone = $data['timezone'];
        $post_time = $data['start_date'];
        $start_time = gmdate("Y-m-d\TH:i:s", strtotime($post_time));

        /* create meeting array */
        $createMeetingArr = array();
        if (!empty($data['alternative_host_ids'])) {
            if (count($data['alternative_host_ids']) > 1) {
                $alternative_host_ids = implode(",", $data['alternative_host_ids']);
            } else {
                $alternative_host_ids = $data['alternative_host_ids'][0];
            }
        }

        $createMeetingArr['topic'] = $data['topic'];
        $createMeetingArr['agenda'] = !empty($data['agenda']) ? $data['agenda'] : "";
        $createMeetingArr['type'] = !empty($data['type']) ? $data['type'] : 2; //Scheduled
        $createMeetingArr['timezone'] = $timeZone;
        $createMeetingArr['start_time'] = isset($start_time) ? $start_time : "";
        $createMeetingArr['password'] = !empty($data['password']) ? $data['password'] : "";
        $createMeetingArr['duration'] = !empty($data['duration']) ? (int)$data['duration'] : 5;


        $createMeetingArr['settings'] = array(
            'join_before_host' => !empty($data['join_before_host']) ? true : false,
            'host_video' => !empty($data['option_host_video']) ? true : false,
            'participant_video' => !empty($data['option_participants_video']) ? true : false,
            'mute_upon_entry' => !empty($data['option_mute_participants']) ? true : false,
            'enforce_login' => !empty($data['option_enforce_login']) ? true : false,
            'auto_recording' => !empty($data['option_auto_recording']) ? $data['option_auto_recording'] : "none",
            'alternative_hosts' => isset($alternative_host_ids) ? $alternative_host_ids : ""
        );

        $request_url = "https://api.zoom.us/v2/users/" . $mail . "/meetings"; // zoom create meeting url
        //create token
        $token = array(
            "iss" => $key,
            "exp" => time() + 3600 //60 seconds as suggested

        );
        $getJWTKey = JWT::encode($token, $secret);
        $headers = array(
            "authorization: Bearer " . $getJWTKey,
            "content-type: application/json",
            "Accept: application/json",
        );

        $fieldsArr = json_encode($createMeetingArr);
        //curl start
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $request_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $fieldsArr,
            CURLOPT_HTTPHEADER => $headers,
        ));

        $result = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if (!$result) {
            return $err;
        }
        return json_decode($result);
    }



    //joinMeeting for institute
    public function joinMeeting(Request $request)
    {

        $user = Auth::user();
        $section_name = 'Join Meeting';
        if (!isset($_GET["join"]) || empty($_GET["join"])) {
            redirect(404);
        }
        if (isset($_GET['pwd']) && !empty($_GET['pwd'])) {
            $password = pm_encrypt_decrypt('decrypt', $_GET['pwd']);
        }
        if (isset($_GET["join"])) {
            $meeting_id    = $_GET["join"];

            if (isset($_GET["get"])) {
                if (isset($_GET["second_get"])) {
                    $get  = $_GET['get'];
                    $second_get  = $_GET['second_get'];
                    if (!empty($meeting_id) && $get && $second_get && $user) {
                        return view('institute.zoom.join_meeting', compact('section_name', 'user', 'meeting_id', 'password'));
                    }
                }
            }
        }
    }


    //joinMeeting for student
    public function joinMeetingstudent(Request $request)
    {

        $user = Auth::user();
        $section_name = 'Join Meeting';

        if (!isset($_GET["join"]) || empty($_GET["join"])) {
            redirect(404);
        }
        if (isset($_GET['pwd']) && !empty($_GET['pwd'])) {
            $password = pm_encrypt_decrypt('decrypt', $_GET['pwd']);
        }
        if (isset($_GET["join"])) {
            $meeting_id    = $_GET["join"];
            if (isset($_GET["get"])) {
                $c_i_d = $_GET['get'];
                if (!empty($meeting_id) && $c_i_d) {

                    return view('institute.zoom.student_join_meeting', compact('section_name', 'user', 'meeting_id', 'password', 'c_i_d'));
                }
            }
        }
    }


    /*
            create authentication for join meeting
    */
    public function meetingAuth(Request $request)
    {

        $key = env('ZOOM_API_KEY', '');
        $secret = env('ZOOM_API_SECRET', '');
        // $mail = env('EMAIL_ID');
        $user = Auth::user();
        // dd($user);
        $user_id = $user->id;
        $zoom_api_key    = $key;
        $zoom_api_secret = $secret;

        $meeting_id = $request->meeting_id;
        // $get = isset($request->prsnl) ? $request->prsnl : '';
        if (!$request->meeting_id) {
            return response()->json([
                "status" => false,
                "msg" => "Meeting id missing",
            ]);
        }
        $meeting_id    = pm_encrypt_decrypt('decrypt', $request->meeting_id);


        if (!empty($zoom_api_key) && !empty($zoom_api_secret)) {
            $signature = $this->generate_signature($zoom_api_key, $zoom_api_secret, $meeting_id, $user_id);
            return response()->json([
                "status" => true,
                "sig" => $signature,
                "meet_id" => $meeting_id,
                'key' => $zoom_api_key,
                'secret' => $zoom_api_secret,
                "msg" => "Success",
            ]);
        } else {
            return response()->json([
                "status" => false,
                "msg" => "Something went wrong",
            ]);
        }
    }

    /**
     * Generate Signature

     */
    private function generate_signature($api_key, $api_secret, $meeting_number, $user_id)
    {
        // date_default_timezone_set('Asia/Calcutta');
        $time = time() * 1000 - 30000; //time in milliseconds (or close enough)
        $data = base64_encode($api_key . $meeting_number . $time . $user_id);
        $hash = hash_hmac('sha256', $data, $api_secret, true);
        $_sig = $api_key . "." . $meeting_number . "." . $time . "." . $user_id . "." . base64_encode($hash);

        //return signature, url safe base64 encoded
        return rtrim(strtr(base64_encode($_sig), '+/', '-_'), '=');
    }

    // create unit for live lecture

    public function liveUnit()
    {
        //   dd(request()->all());
        request()->validate([
            'unitName' => 'required|unique:live_units',
        ]);

        $test_unit = Live_unit::where(['institute_assigned_class_subject_id' => request()->iacsId, 'unitName' =>
        request()->unitName]);
        // dd($test_unit->all);
        // dd

        if ($test_unit->count()) {
            return response()->json(['status' => true, 'data' => ['id' => $test_unit->first()->id, 'unitName' =>
            $test_unit->first()->unitName]]);
        } else {
            $unit_1 = Live_unit::create([
                'institute_assigned_class_subject_id' => request()->iacsId,
                'unitName' => request()->unitName,
            ]);
            return response()->json(['status' => true, 'data' => ['id' => $unit_1->id, 'unitName' => $unit_1->unitName]]);
        }
    }
    // create user
    // public function create_user(){
    //     $users_zoom  = zoomuser::all();
    //     if(!empty($users_zoom)){
    //          foreach($users_zoom as $user_zoom){
    //              if(isset($user_zoom)){
    //                  $institutes = Institute::where('email', '!=', $user_zoom->institute_email)->get();
    //                  return $institutes;
    //                 }else {
    //                     $institutes = Institute::all();
    //                     return $institutes;
    //                 }
    //             }
    //       }
    // }


    // public function create_user_ajax(Request $request){

    //     $arr=[
    //         'action' => "create",
    //         'user_info'=>[
    //             "first_name" =>$request->institute_Name,
    //             "email" =>$request->institute_email,
    //             'type' => 1, //required 1=basic
    //                 ]
    //     ];
    //     $json = json_encode($arr);
    //     $keys = env('ZOOM_API_KEY', '');
    //     $secret = env('ZOOM_API_SECRET', '');
    //     $url = "https://api.zoom.us/v2/users/";

    //     $token = array(
    //         "iss" => $keys,
    //         "exp" => time() + 3600 //60 seconds as suggested

    //     );
    //     $getJWTKey = JWT::encode($token, $secret);
    //     $headers = array(
    //         "authorization: Bearer " . $getJWTKey,
    //         "content-type: application/json",
    //         "Accept: application/json",
    //     );

    //     $curl_user = curl_init();

    //     curl_setopt_array($curl_user, array(
    //     CURLOPT_URL => $url,
    //     CURLOPT_RETURNTRANSFER => true,
    //     CURLOPT_ENCODING => "",
    //     CURLOPT_MAXREDIRS => 10,
    //     CURLOPT_TIMEOUT => 30,
    //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //     CURLOPT_CUSTOMREQUEST => "POST",
    //     CURLOPT_POSTFIELDS => $json,
    //     CURLOPT_HTTPHEADER => $headers,
    //     ));

    //     $response = curl_exec($curl_user);
    //     // $uservalue = json_decode($response);
    //     // dd($uservalue->id);
    //     $httpcode = curl_getinfo($curl_user, CURLINFO_HTTP_CODE);
    //     $err = curl_error($curl_user);
    //     curl_close($curl_user);

    //     if($httpcode == 201){

    //         $validatedData = Validator::make($request->all(), [
    //             'institute_id' => 'required',
    //             'institute_Name'     => 'required',
    //             'institute_email' => 'required|unique:zoomusers',

    //         ]);
    //         if ($validatedData->fails()) {
    //             return json_encode(array(
    //                 "statusCode" => 101
    //             ));
    //         } else {
    //             $userCreate =  new zoomuser;
    //             $userCreate->institute_id = $request->institute_id;
    //             $userCreate->institute_Name = $request->institute_Name;
    //             $userCreate->institute_email = $request->institute_email;
    //             $userCreate->save();
    //             return json_encode(array(
    //                 "statusCode" => 201
    //             ));
    //         }

    //     }else if($httpcode == 409){
    //         return json_encode(array(
    //             "statusCode" => 409
    //         ));

    //     }

    // }

    // public function listuser()
    // {

    //     $users_zoom  = zoomuser::all();
    //     if(!empty($users_zoom)){
    //          foreach($users_zoom as $user_zoom){
    //           }
    //     }
    //     if(isset($user_zoom)){
    //      $institutes = Institute::where('email', '!=', $user_zoom->institute_email)->get();
    //     //  return $institutes;
    //     }else {
    //         $institutes = Institute::all();
    //         // return $institutes;
    //     }

    //     $keys = env('ZOOM_API_KEY', '');
    //     $secret = env('ZOOM_API_SECRET', '');
    //     $path = 'users/';
    //     $url = $this->retrieveZoomUrl();
    //     // $url = "https://api.zoom.us/v2/users/$userEmail";

    //     $token = array(
    //         "iss" => $keys,
    //         "exp" => time() + 3600 //60 seconds as suggested

    //     );
    //     $getJWTKey = JWT::encode($token, $secret);
    //     $headers = array(
    //         "authorization: Bearer " . $getJWTKey,
    //         "content-type: application/json",
    //         "Accept: application/json",
    //     );

    //     $curl_pending = curl_init();

    //     curl_setopt_array($curl_pending, array(
    //         CURLOPT_URL => $url . $path,
    //       CURLOPT_RETURNTRANSFER => true,
    //       CURLOPT_ENCODING => "",
    //       CURLOPT_MAXREDIRS => 10,
    //       CURLOPT_TIMEOUT => 30,
    //       CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //       CURLOPT_CUSTOMREQUEST => "GET",
    //       CURLOPT_POSTFIELDS => "",
    //       CURLOPT_HTTPHEADER => $headers
    //     ));

    //     $response = curl_exec($curl_pending);
    //     $err = curl_error($curl_pending);
    //     curl_close($curl_pending);
    //     $zoomUsers = json_decode($response);
    //     return view('admin.manage-institutes.create_user', compact('zoomUsers', 'institutes', 'users_zoom'));
    // }

    // public function deleteUser(Request $request){
    //     $userId = $request->user_id;
    //     // dd($userId);


    //     $keys = env('ZOOM_API_KEY', '');
    //     $secret = env('ZOOM_API_SECRET', '');
    //     $path = 'users/' . $userId;
    //     $url = $this->retrieveZoomUrl();


    //     $token = array(
    //         "iss" => $keys,
    //         "exp" => time() + 3600 //60 seconds as suggested

    //     );
    //     $getJWTKey = JWT::encode($token, $secret);
    //     $headers = array(
    //         "authorization: Bearer " . $getJWTKey,
    //         "content-type: application/json",
    //         "Accept: application/json",
    //     );

    //     $curl_delete = curl_init();

    //         curl_setopt_array($curl_delete, array(
    //         CURLOPT_URL => $url . $path,
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => "",
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 30,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => "DELETE",
    //         CURLOPT_HTTPHEADER => $headers,
    //         ));

    //         $response = curl_exec($curl_delete);
    //         $status = curl_getinfo($curl_delete, CURLINFO_HTTP_CODE);
    //         // dd($status);
    //         $err = curl_error($curl_delete);
    //         curl_close($curl_delete);
    //                 if($status == 204){
    //                     $userEmail = $request->user_email;
    //                     $delete = zoomuser::where('institute_email', $userEmail)->delete();
    //                     return json_encode(array(
    //                         "statusCode" => 204
    //                     ));
    //                 }else{
    //                     return json_encode(array(
    //                         "statusCode" => 429
    //                     ));
    //                 }
    // }


    // public static function meetingId(Request $request){
    //     echo auth()->user();
    //     die;
    //     if(!empty($request->meeting_id)){
    //         $meeting_id    = pm_encrypt_decrypt('decrypt', $request->meeting_id);
    //         $response_participants = self::liveClassAttendance($meeting_id);
    //         if(!empty($response_participants)){

    //             $response_host =  self::liveclasshost($meeting_id);

    //         }

    //         if(!empty($response_participants) && ($response_host)){

    //             self::percentage($response_participants, $response_host);

    //         }

    //     }
    // }


    // public static function liveClassAttendance($meeting_id)
    // {

    //     // echo $meeting_id;
    //     // die;
    //     $url = "https://api.zoom.us/v2/report/meetings/" . $meeting_id . "/participants";
    //     $keys = env('ZOOM_API_KEY', '');
    //     $secret = env('ZOOM_API_SECRET', '');

    //     $token = array(
    //         "iss" => $keys,
    //         "exp" => time() + 3600 //60 seconds as suggested

    //     );
    //     $getJWTKey = JWT::encode($token, $secret);
    //     $headers = array(
    //         "authorization: Bearer " . $getJWTKey,
    //         "content-type: application/json",
    //         "Accept: application/json",
    //     );

    //     $curl = curl_init();
    //     curl_setopt_array($curl, array(
    //         CURLOPT_URL => $url,
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => "",
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 30,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => "GET",
    //         CURLOPT_HTTPHEADER => $headers,
    //     ));

    //     $resultData = curl_exec($curl);
    //     $err = curl_error($curl);
    //     curl_close($curl);
    //     if (!$resultData) {
    //         return $err;
    //     }

    //    return $resultData;

    // }




    // public static function liveclasshost($meeting_id)
    // {


    //     $url = "https://api.zoom.us/v2/report/meetings/" . $meeting_id ;
    //     $keys = env('ZOOM_API_KEY', '');
    //     $secret = env('ZOOM_API_SECRET', '');

    //     $token = array(
    //         "iss" => $keys,
    //         "exp" => time() + 3600 //60 seconds as suggested

    //     );
    //     $getJWTKey = JWT::encode($token, $secret);
    //     $headers = array(
    //         "authorization: Bearer " . $getJWTKey,
    //         "content-type: application/json",
    //         "Accept: application/json",
    //     );

    //     $curlid = curl_init();
    //     curl_setopt_array($curlid, array(
    //         CURLOPT_URL => $url,
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => "",
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 30,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => "GET",
    //         CURLOPT_HTTPHEADER => $headers,
    //     ));

    //     $resultDataid = curl_exec($curlid);
    //     $err = curl_error($curlid);
    //     curl_close($curlid);
    //     if (!$resultDataid) {
    //         return $err;
    //     }

    //    return $resultDataid;



    // }


    // public static function percentage($response_participants, $response_host){


    //     $studentData = json_decode($response_participants);
    //     $total_duration = 0;
    //     if(!empty($studentData)){
    //         foreach($studentData->participants as $resultUser){
    //             if(!empty($resultUser)){
    //                 // if($resultUser->name == auth()->user()->email){

    //                     $total_duration += !empty($resultUser->duration) ? $resultUser->duration : 0;

    //                 }

    //             }
    //         }

    //         //host data
    //         $hostData = json_decode($response_host);
    //         // dd($hostData);
    //         if(!empty($hostData)){
    //             $hostDateTime = $hostData->duration;
    //             $sec = ($hostDateTime * 60);   //convert host duration minutes to sec
    //             $percentage = ($total_duration / $sec) * 100;
    //             $percentageRound =  round($percentage, 2);
    //             // var_dump($percentageRound);die;
    //             //insert data in databas
    //             $studentCrearte = new student_attendance;
    //             $studentCrearte->meeting_id = $hostData->id;
    //             $studentCrearte->topic = $hostData->topic;
    //             $studentCrearte->name = $resultUser->name;
    //             $studentCrearte->join_time = $resultUser->join_time;
    //             $studentCrearte->leave_time = $resultUser->leave_time;
    //             $studentCrearte->leave_time = $resultUser->leave_time;
    //             $studentCrearte->attendence_in_percentage = $percentageRound;
    //             $studentCrearte->save();
    //         }
    //     // }

    // }

}