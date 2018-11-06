<?php
/**
 * Created by PhpStorm.
 * User: anuj
 * Date: 15/3/18
 * Time: 2:27 PM
 */

namespace Vega6;

use Exception;

/**
 * Class Syvid
 * @package Vega6
 */
class Syvid
{
    private $username;
    private $password;
    private $access_token;

    /**
     * Syvid constructor.
     * @internal param $username
     * @internal param $password
     */
    function __construct()
    {

    }

    /**
     * @param mixed $username
     * @param $password
     */
    public function setAuth($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @param mixed $access_token
     */
    public function setAccessToken($access_token)
    {
        $this->access_token = $access_token;
    }


    /**
     * check for syvid credentials validity
     * @throws Exception
     */
    public function check()
    {
        if (empty($this->username) || empty($this->password)) {
            throw new Exception('Either username or password or both is not provided');
        }

        $host = 'http//app.syvid.io/';
        $auth_url = $host.'api/auth/login';

        $data = [
            'username' => $this->username,
            'password' => $this->password
        ];

        $data = http_build_query($data);

        $ch = curl_init($auth_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($ch);
        curl_close($ch);

        debug($response);

        $response = json_decode($response);

        debug($response);
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function getCampaigns()
    {
        if (empty($this->access_token)) {
            throw new Exception('Access token is not set');
        }

        $url = 'https://app.syvid.io/api/campaigns/all?token='.$this->access_token;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($result);

        if ($result->status) {
            return $result->result->data;
        } else {
            return false;
        }
    }
    
    /**
     * Upload video to syvid campaign
     * @throws Exception
     */
    public function uploadVideo($campaign_id, $title, $description, $video_path, $initiate = true)
    {
          $url = 'https://app.syvid.io/api/post-videos/upload';

          $data = [
              'token' => $this->access_token,
              'campaign_id' => $campaign_id,
              'initiate' => true,
              'title' => $title,
              'description' => $description,
              'video_file' => new \CURLFile($video_path, 'video/mp4')
          ];

          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_POST, true);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
          $result = curl_exec($ch);
          curl_close($ch);

          $result = json_decode($result);

          if ($result->status) {
              /**
               * video posted
               */
              return $result->result->data;
          } else {
              throw new Exception($result->result->message);
          }
    }
}
