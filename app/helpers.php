<?php

use App\Models\Category;
use App\Models\Subject;
use App\Models\InstituteAssignedClass;

function getCategoryById($id)
{
    $category = Category::findOrFail($id);
    return $category;
}

function getSubjectById($id)
{
    $subject = Subject::findOrFail($id);
    return $subject;
}

function getSubjectsByClass($id)
{
    $get_institute_assigned_class = InstituteAssignedClass::where('id', $id)->first();
    return $get_institute_assigned_class->institute_assigned_class_subjects;
}



//encrypt

function pm_encrypt_decrypt($action, $string)
{

    $output = false;

    $encrypt_method = "AES-256-CBC";

    $secret_key     = 'DPEN_X3!3#23121';

    $secret_iv      = '1231232133213221';



    // hash

    $key = hash('sha256', $secret_key);



    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning

    $iv = substr(hash('sha256', $secret_iv), 0, 16);



    if ($action == 'encrypt') {

        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);

        $output = base64_encode($output);
    } else if ($action == 'decrypt') {

        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }



    return $output;
}


function get_browser_join_links($meeting_id, $password = false, $get = null, $second_get = null)
{
    $encrypt_pwd        = pm_encrypt_decrypt('encrypt', $password);

    $encrypt_meeting_id = pm_encrypt_decrypt('encrypt', $meeting_id);

    if (!empty($password)) {
        // dd("fksgjh");

        return route('institute.joinMeeting', ['join' => $encrypt_meeting_id, 'pwd' => $encrypt_pwd, 'type' => 'meeting', 'get' => $get, 'second_get' => $second_get]);
    } else {
        // dd("jhm");

        return route('institute.joinMeeting', ['join' => $encrypt_meeting_id, 'type' => 'meeting']);
    }
}

//join meeting for student

function get_browser_join_links_student($meeting_id, $password = false, $get = null)
{
    $encrypt_pwd        = pm_encrypt_decrypt('encrypt', $password);

    $encrypt_meeting_id = pm_encrypt_decrypt('encrypt', $meeting_id);

    if (!empty($password)) {
        // dd("fksgjh");

        return route('student.joinmeeting', ['join' => $encrypt_meeting_id, 'pwd' => $encrypt_pwd, 'type' => 'meeting', 'get' => $get]);
    } else {
        // dd("jhm");

        return route('student.joinmeeting', ['join' => $encrypt_meeting_id, 'type' => 'meeting']);
    }
}

function createAccessToken()
{
    $clientId = env('CLIENT_ID', '');
    $clientSecret = env('CLIENT_SECRET', '');
    $tenantId = env('TENANT_ID', '');
    $scope = env('SCOPE', '');
    $base_url = env('LOGIN_BASE_URL', '');
    $url = $tenantId . "/oauth2/v2.0/token";
    $fullurl = $base_url . $url; // full Url for create access Token

    $headers = array(
        "Host: " . $base_url,
        "Content-type: application/x-www-form-urlencoded",
    );

    $post_params = array(
        "client_id" => $clientId,
        "client_secret" => $clientSecret,
        'scope' => $scope,
        'grant_type' => 'client_credentials',
    );
    //curl start
    $curl = curl_init($fullurl);

    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_params);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("application/x-www-form-urlencoded"));
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($curl);
    $token = $response;
    $data = json_decode($token);
    $err = curl_error($curl);

    curl_close($curl);

    return $data->access_token;
}

/* create folder   if not existe */
function createFolder($folderName)
{

    $base_url = env('BASE_URL_USER', '');
    $userId = env('USER_ID', '');
    $drive = '/drive/root/';
    $endPoint = 'children';
    $request_url = $base_url . $userId . $drive . $endPoint;

    $headers = array(
        "authorization: Bearer " . createAccessToken(),
        "content-type: application/json"
    );
    $ch = curl_init($request_url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_HTTPHEADER,  $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    $dataGet =  json_decode($result);

    if (!empty($dataGet)) {
        foreach ($dataGet->value as $data) {
            if ($folderName == $data->name) {

                return $folderName;
            } else {
                $postdata = ([
                    "name" => $folderName,
                    "folder" => new \stdClass(),
                ]);


                $headers = array(
                    "authorization: Bearer " . createAccessToken(),
                    "content-type: application/json"
                );

                $ch = curl_init($request_url);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postdata));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $result = curl_exec($ch);
                $folderCreated =  json_decode($result);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if ($httpCode == 201) {

                    return $folderCreated->name;
                } else {

                    return $folderName;
                }
            }
        }
    }
}

/*   Upload large files with an upload session */
function createUrlsession($fileName, $folder)
{
    @ini_set("max_execution_time", 0);
    @ini_set("memory_limit", '500M');
    $origainalName = $fileName->getClientOriginalName();
    $origainalNameDate = date('m-d-Y-h-i-s') . $origainalName;
    $name = str_replace(" ", "_", $origainalNameDate);
    $base_url = env('BASE_URL_USER', '');
    $userId = env('USER_ID', '');
    $drive = '/drive/root:/' . $folder . '/';
    $endPoint = ":/createUploadSession";
    $request_url = $base_url . $userId . $drive . $name . $endPoint;
    $postData = [
        "@microsoft.graph.conflictBehavior" => "rename | fail | replace",
        "description" => "description",
        "fileSystemInfo" => [
            "@odata.type" => "microsoft.graph.fileSystemInfo"
        ],
        "name" => $name
    ];

    $headers = array(
        "authorization: Bearer " . createAccessToken(),
        "content-type: application/json",
        "Cache-Control: no-cache",
        "Pragma: no-cache"

    );

    $datapost = json_encode($postData);
    $curl_img_url = curl_init($request_url);
    curl_setopt($curl_img_url, CURLOPT_POST, true);
    curl_setopt($curl_img_url, CURLOPT_HTTPHEADER,  $headers);
    curl_setopt($curl_img_url, CURLOPT_CONNECTTIMEOUT, 0);
    curl_setopt($curl_img_url, CURLOPT_POSTFIELDS, $datapost);
    curl_setopt($curl_img_url, CURLOPT_RETURNTRANSFER, true);
    // execute!
    $response = curl_exec($curl_img_url);
    $data = json_decode($response);
    $httpCode = curl_getinfo($curl_img_url, CURLINFO_HTTP_CODE);
    curl_close($curl_img_url);

    if ($httpCode == 200) {
        $graph_url = $data->uploadUrl;
        $fragSize = 390 * 1024;
        $file = file_get_contents($fileName);
        $fileSize = strlen($file);
        $numFragments = ceil($fileSize / $fragSize);
        $bytesRemaining = $fileSize;
        $i = 0;
        $ch = curl_init($graph_url);
        while ($i < $numFragments) {
            $chunkSize = $numBytes = $fragSize;
            $start = $i * $fragSize;
            $end = $i * $fragSize + $chunkSize - 1;
            $offset = $i * $fragSize;
            if ($bytesRemaining < $chunkSize) {
                $chunkSize = $numBytes = $bytesRemaining;
                $end = $fileSize - 1;
            }
            if ($stream = fopen($fileName, 'r')) {
                // get contents using offset
                $data = stream_get_contents($stream, $chunkSize, $offset);
                fclose($stream);
            }

            $content_range = " bytes " . $start . "-" . $end . "/" . $fileSize;
            $headers = array(
                "Content-Length: $numBytes",
                "Content-Range:$content_range"
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $graph_url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec($ch);
            $info = curl_getinfo($ch);
            $bytesRemaining = $bytesRemaining - $chunkSize;
            $i++;
        }
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpCode == 201) {
            $fileData  = (json_decode($server_output));
            if (!empty($fileData->id)) {
                $itemId = $fileData->id;
                return creteShareLink($itemId);
            }
        } elseif ($httpCode == 200) {
            return 400;
        }
        /* if(curl_errno($ch))
                {
                    echo 'Curl error: ' . curl_error($ch);
                }
            curl_close($ch);  */
    } else {
        return response()->json([
            'status' => 400,
            'msg' => 'Bad Request'
        ]);
    }
}



function creteShareLink($itemId)
{
    $base_url = env('BASE_URL_USER', '');
    $userId = env('USER_ID', '');
    $itemPath = '/drive/items/';
    $urlEndPoinr = '/createLink';
    $urlpath = $base_url . $userId .  $itemPath .  $itemId . $urlEndPoinr;
    $post = [
        'type' => 'view',
        'scope' => 'anonymous',
    ];

    $headers = array(
        "authorization: Bearer " . createAccessToken(),
        "content-type: application/json"
    );

    $curl_img_url = curl_init($urlpath);
    curl_setopt($curl_img_url, CURLOPT_POST, true);
    curl_setopt($curl_img_url, CURLOPT_HTTPHEADER,  $headers);
    curl_setopt($curl_img_url, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_img_url, CURLOPT_POSTFIELDS, json_encode($post));

    // execute!
    $response = curl_exec($curl_img_url);
    $data = json_decode($response);
    $httpCode = curl_getinfo($curl_img_url, CURLINFO_HTTP_CODE);
    if ($httpCode == 201) {
        $responseData = ([
            $data->link->webUrl,
            $itemId
        ]);
        return $responseData;
    } else {
        return response()->json([
            'status' => 400,
            'msg' => 'Bad Request'
        ]);
    }
}


/* deleted file */
function deleteFiles($id)
{
    $fId =  $id;
    $base_url = env('BASE_URL_USER', '');
    $userId = env('USER_ID', '');
    $endPoint = '/drive/items/';
    $request_url = $base_url . $userId . $endPoint . $fId;

    $headers = array(
        "authorization: Bearer " . createAccessToken(),
        "content-type: application/json"
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $request_url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_HTTPHEADER,  $headers);
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    return response()->json([
        'status' => 200,
        'msg' => $httpCode
    ]);
}

/*  updateFile  */
function updateFile($fileName, $fileId, $folder)
{
    $fId =  $fileId;
    $base_url = env('BASE_URL_USER', '');
    $userId = env('USER_ID', '');
    $endPoint = '/drive/items/';
    $request_url = $base_url . $userId . $endPoint . $fId;

    $headers = array(
        "authorization: Bearer " . createAccessToken(),
        "content-type: application/json"
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $request_url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_HTTPHEADER,  $headers);
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($httpCode == 204) {

        @ini_set("max_execution_time", 0);
        @ini_set("memory_limit", '500M');
        $origainalName = $fileName->getClientOriginalName();
        $origainalNameDate = date('d y m h i') . $origainalName;
        $name = str_replace(" ", "_", $origainalNameDate);
        $base_url = env('BASE_URL_USER', '');
        $userId = env('USER_ID', '');
        $drive = '/drive/root:/' . $folder . '/';
        $endPoint = ":/createUploadSession";
        $request_url = $base_url . $userId . $drive . $name . $endPoint;

        $postData = [
            "@microsoft.graph.conflictBehavior" => "rename | fail | replace",
            "description" => "description",
            "fileSystemInfo" => [
                "@odata.type" => "microsoft.graph.fileSystemInfo"
            ],
            "name" => $name
        ];

        $headers = array(
            "authorization: Bearer " . createAccessToken(),
            "content-type: application/json",
            "Cache-Control: no-cache",
            "Pragma: no-cache"

        );

        $datapost = json_encode($postData);
        $curl_img_url = curl_init($request_url);
        curl_setopt($curl_img_url, CURLOPT_POST, true);
        curl_setopt($curl_img_url, CURLOPT_HTTPHEADER,  $headers);
        curl_setopt($curl_img_url, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($curl_img_url, CURLOPT_POSTFIELDS, $datapost);
        curl_setopt($curl_img_url, CURLOPT_RETURNTRANSFER, true);
        // execute!
        $response = curl_exec($curl_img_url);
        $data = json_decode($response);
        $httpCode = curl_getinfo($curl_img_url, CURLINFO_HTTP_CODE);
        curl_close($curl_img_url);

        if ($httpCode == 200) {
            $graph_url = $data->uploadUrl;
            $fragSize = 390 * 1024;
            $file = file_get_contents($fileName);
            $fileSize = strlen($file);
            $numFragments = ceil($fileSize / $fragSize);
            $bytesRemaining = $fileSize;
            $i = 0;
            $ch = curl_init($graph_url);
            while ($i < $numFragments) {
                $chunkSize = $numBytes = $fragSize;
                $start = $i * $fragSize;
                $end = $i * $fragSize + $chunkSize - 1;
                $offset = $i * $fragSize;
                if ($bytesRemaining < $chunkSize) {
                    $chunkSize = $numBytes = $bytesRemaining;
                    $end = $fileSize - 1;
                }
                if ($stream = fopen($fileName, 'r')) {
                    // get contents using offset
                    $data = stream_get_contents($stream, $chunkSize, $offset);
                    fclose($stream);
                }

                $content_range = " bytes " . $start . "-" . $end . "/" . $fileSize;
                $headers = array(
                    "Content-Length: $numBytes",
                    "Content-Range:$content_range"
                );

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $graph_url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $server_output = curl_exec($ch);
                $info = curl_getinfo($ch);
                $bytesRemaining = $bytesRemaining - $chunkSize;
                $i++;
            }
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($httpCode == 201) {
                $fileData  = (json_decode($server_output));
                if (!empty($fileData->id)) {

                    $itemId = $fileData->id;
                }
                return creteShareLink($itemId);
            } else {
                return response()->json([
                    'status' => 404,
                    'msg' => 'File exist.'
                ]);
            }
            if (curl_errno($ch)) {
                echo 'Curl error: ' . curl_error($ch);
            }
            curl_close($ch);
        } else {
            return response()->json([
                'status' => 400,
                'msg' => 'Bad Request'
            ]);
        }
    }
}