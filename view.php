<?php
$id = $_GET["id"];
$apiUrl = "https://evaluation-technique.lundimatin.biz/api/clients/$id";

$token = isset($_COOKIE['token']) ? $_COOKIE['token'] : '';

if (empty($token)) {
    echo 'Token not found. Please authenticate first.';
    exit;
}
$options = array(
    CURLOPT_URL => $apiUrl,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => array(
        'Authorization: Basic ' . base64_encode(':' . $token),
    ),
);
$ch = curl_init();
curl_setopt_array($ch, $options);

$response = curl_exec($ch);

$responseData = json_decode($response, true);

$client = $responseData['datas'];

curl_close($ch);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIEWS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.2/font/bootstrap-icons.min.css" integrity="sha512-D1liES3uvDpPrgk7vXR/hR/sukGn7EtDWEyvpdLsyalQYq6v6YUsTUJmku7B4rcuQ21rf0UTksw2i/2Pdjbd3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./styles/style.css">
</head>

<body>
    <?php
    include("templates/header.php");
    ?>
    <div class="user-views pt-5">

        <div class="container">
            <div class="container-title d-flex justify-content-between align-items-center p-4">
                <h1 style="font-weight: bold; font-size: 20px">
                    <?php echo $client["nom"] ?>
                </h1><a class="btn btn-info" href="edit.php?id=<?php echo $client["id"] ?>">
                    <i style="color: #fff; margin-right: 5px" class="bi bi-gear-fill"></i>
                    Editer</a>
            </div>
            <div class="container-views">
                <h2>INFOMATIONS</h2>
                <div class="container-content">
                    <div class="container-views-item">
                        <span>Prenom & NOM</span>
                        <h3>
                            <?php echo $client['nom']; ?>
                        </h3>
                    </div>
                    <div class="container-views-item">
                        <span>Telephone</span>
                        <h3>
                            <?php echo $client['tel']; ?>
                        </h3>
                    </div>
                    <div class="container-views-item">
                        <span>Email</span>
                        <h3>
                            <?php echo $client['email']; ?>
                        </h3>
                    </div>
                    <div class="container-views-item">
                        <span>Adresse</span>
                        <h3>
                            <?php echo $client['adresse']; ?>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>