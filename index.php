<?php
include("auth.php");

$apiUrl = "https://evaluation-technique.lundimatin.biz/api/clients?fields=nom,adresse,ville,tel";

$token = isset($_COOKIE['token']) ? $_COOKIE['token'] : '';

if (isset($_POST['search'])) {
    $keyword = $_POST["keyword"];
    $apiUrl .= "&nom=" . urlencode($keyword);
}
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

$datas = $responseData['datas'];

curl_close($ch);

function getFirstKeyword($string) {
    $keyword = explode(' ', $string);
    $chuCaiDauTien = '';

    foreach ($keyword as $keywordn) {
        $chuCaiDauTien .= strtoupper($keywordn[0]);
    }

    return $chuCaiDauTien;
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMB App</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.2/font/bootstrap-icons.min.css"
        integrity="sha512-D1liES3uvDpPrgk7vXR/hR/sukGn7EtDWEyvpdLsyalQYq6v6YUsTUJmku7B4rcuQ21rf0UTksw2i/2Pdjbd3g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./styles/style.css">
</head>

<body>
    <?php
    include("templates/header.php");
    ?>
    <div class="user-list pt-5">
        <div class="container">
            <div class="container-title d-flex align-items-center p-2">
                <h1>Rechercher d'une fiche de contact</h1>
            </div>
            <div class="container-search">
                <form action="index.php" method="post">
                    <lable>Renseiger un nom ou une denomination</lable>
                    <div class="form-field">
                        <input type="text" class="form-control" name="keyword" id="" placeholder="Nom ou denomination">
                    </div>
                    <div class="form-field d-flex justify-content-end">
                        <input type="submit" class="btn btn-primary" value="Rechercher" name="search">
                    </div>
                </form>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">Nom</th>
                        <th scope="col">Adresse</th>
                        <th scope="col">Ville</th>
                        <th scope="col">Telephone</th>
                        <th></th>
                    </tr>
                </thead>
                <?php foreach ($datas as $value) { ?>
                    <tr>
                        <td>
                            <div class="image-conainer">
                                <?php echo getFirstKeyword($value['nom']); ?>
                            </div>
                        </td>
                        <td>
                            <?php echo $value['nom'] ?>
                        </td>
                        <td>
                            <?php echo $value['adresse'] ?>
                        </td>
                        <td>
                            <?php echo $value['ville'] ?>
                        </td>
                        <td>
                            <?php echo $value['tel'] ?>
                        </td>
                        <td>
                            <a class="btn btn-info views-btn"
                                style="border-radius: 30px; color: #fff; background: #465dce; border: none"
                                href="view.php?id=<?php echo $value['id'] ?>"> <i class="bi bi-search"
                                    style="margin-right: 5px; color: #fff"></i>Voir</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>

</html>
