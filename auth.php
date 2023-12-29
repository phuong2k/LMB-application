<?php

$apiUrl = 'https://evaluation-technique.lundimatin.biz/api/auth';

$data = array(
    "username" => "test_api",
    "password" => "api123456",
    "password_type" => 0,
    "code_application" => "webservice_externe",
    "code_version" => "1"
);

$jsonData = json_encode($data);

$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
}

curl_close($ch);

if ($response) {
    $responseData = json_decode($response, true);

    if ($responseData['code'] === 200) {
        $token = $responseData['datas']['token'];

        setcookie('token', $token, time() + 3600, '/'); 

    } else {
        echo 'Yêu cầu không thành công. Code: ' . $responseData['code'] . ', Message: ' . $responseData['message'];
    }
} else {
    echo 'Không nhận được phản hồi từ API.';
}

?>
