<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = $_GET["id"]; 
    $apiUrl = "https://evaluation-technique.lundimatin.biz/api/clients/$id";

    $token = isset($_COOKIE['token']) ? $_COOKIE['token'] : '';

    if (empty($token)) {
        echo 'Token not found. Please authenticate first.';
        exit;
    }

    // Prepare the client data to be updated
    $updateData = array(
        "nom" => $_POST['nom'],
        "tel" => $_POST['tel'],
        "email" => $_POST['email'],
        "adresse" => $_POST['adresse'],
        "code_postal" => $_POST['code_postal'],
        "ville" => $_POST['ville'],
    );

    $jsonData = json_encode($updateData);

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Basic ' . base64_encode(':' . $token),
    ));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Error: ' . curl_error($ch);
    }

    curl_close($ch);

    $responseData = json_decode($response, true);
    if ($responseData['code'] === 200) {
        // Success, redirect to a success page or back to the view page
        header("Location: view.php?id=$id");
        exit;
    } else {
        echo 'Update failed. Code: ' . $responseData['code'] . ', Message: ' . $responseData['message'];
    }
}
?>
