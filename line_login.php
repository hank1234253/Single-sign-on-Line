<?php
require_once("./vendor/autoload.php");
include_once "./env.php";
if (isset($_GET['code']) && isset($_GET['state'])) {
    $code = $_GET['code'];
    $state = $_GET['state'];

    

    // 取得 access token id_token
    $tokenUrl = 'https://api.line.me/oauth2/v2.1/token';
    $postData = [
        'grant_type' => 'authorization_code',
        'code' => $code,
        'redirect_uri' => $redirectUri,
        'client_id' => $channelId,
        'client_secret' => $channelSecret,
    ];
   

    $client = new \GuzzleHttp\Client();
    $response = $client->post($tokenUrl, [
        'form_params' => $postData,
    ]);

    $tokenData = json_decode($response->getBody(), true);
    $accessToken = $tokenData['access_token'];
    $id_token=$tokenData['id_token'];

    
    // 取得用户资料
    $profileUrl = 'https://api.line.me/v2/profile';
    $profileResponse = $client->get($profileUrl, [
        'headers' => ['Authorization' => "Bearer {$accessToken}"]
    ]);
    
    $profileData = json_decode($profileResponse->getBody(), true);
    
    //取得用戶email
    $emailUrl = 'https://api.line.me/oauth2/v2.1/verify';
    $emailPostData = [
        'id_token' => $id_token,
        'client_id' => $channelId
    ];
    $response = $client->post($emailUrl, [
        'form_params' => $emailPostData,
    ]);

    $emailData = json_decode($response->getBody(), true);

    
    echo "<pre>";
    print_r($profileData);
    print_r($emailData);
    echo "</pre>";
}
