<?php

namespace App\Library\Facades;

use App\Models\Log as LogModel;
use App\Models\Pages;
use DateTime;
use Illuminate\Support\Facades\Log as Log;
use App\Models\General\{
    ReviewLogs as Review,
};


class Utility 
{
    public function echo()
    {
        print("Utility test");
    }

    public function notif($pages, $req, $data, $status)

    {
        $client = new \GuzzleHttp\Client();
        $form = [
            'subject' => "New ".$pages." Notification",
            'email' => $data->email,
            'name' => $data->name,
            "message" => '"' . htmlentities("New ". $pages ." has been ".$status." to check the current ".$pages." click here "). $req->url().'"'
        ];

        try {

            $url= (env('APP_ENV') == 'Production') ? env('') : env('');

            $email_notification_url = (env('APP_ENV') == 'Production') ? env('PROD_EMAIL_NOTIFICATION') : 'https://pantau.aturtoko.id/api/v1/mail/message/send';

            $res = $client->post($email_notification_url, [
                'headers' => [
                    'X-Authorization' => 'U6a5i08q4q3DAUnhlVn7AFsu8uOn2xheu0fOOLP5gjbuCydt2Mc4Zbt98b4UgNTt',
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ],
                'form_params' => $form,
                'verify' => false
            ]);

            return ['return' => 'berhasil'];
        } catch(\Exception $e) {
            Log::error($e->getMessage());

            return ['result' => 'gagal'];
        }
    }


    public function log($pages, $user, $id, $actor, $action)
    {
        // string('page')
        // integer('page_id')
        // integer('doc_id')
        // string('action')
        // integer('actor')
        // integer('created_by')
        // string('notes')

        $pages_id = Pages::where('page', $pages)->select('id')->first();

        if($action == 'APPROVED'){
            $notes = $pages." has been ".$action." by ".$user->name;
        } else{
            $actorName = isset($actor[0]->name) ? $actor[0]->name : "No Name";
            $notes = $pages." ".$action." by ".$user->name." to be approved by ".$actorName;
        }

        $log = [
            "page" => $pages,
            "page_id" => isset($pages_id->id) ? $pages_id->id : $pages_id,
            "doc_id" => $id,
            "action" => $action,
            "actor" => isset($actor[0]->id) ? $actor[0]->id : 0,
            "created_by" => $user->id,
            "notes" => $notes,
            "created_at" => date('Y-m-d H:i:s'),
        ];

        try {
            LogModel::insert($log);
            return ['return' => 'berhasil'];

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function whatsapp($data)
    {

        try {

            $curl = curl_init();
            $sent_to = $data['sent_to'];
            $message = $data['message'];

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://wanode.aturtoko.id:8081/send_message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "send_to":"'.$sent_to.'",
                "message":"'.$message.'"
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            echo $response;
        } catch (\Exception $e) {
            print_r($e->getMassage);
        }
    }

    public function reviewLog($pages, $id, $user, $notes, $status)
    {
        $data = [
            "page" => $pages,
            "module_id" => $id,
            "reviewer" => $user->id,
            "created_by" => $user->group_id,
            "notes" => $notes == "" ? null : $notes,
            "status" => $status,
            "role_id" => $user->role_id,
            "created_at" => date("Y-m-d H:i:s"),
        ];

        $makeReview = Review::create($data);

        if (isset($makeReview->id)) {
            return $makeReview;
        }
    }
}
