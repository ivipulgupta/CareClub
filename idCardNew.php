<?php
$previous = "javascript:history.go(-1)";
if (isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}
?>
<?php
session_start();
$firstname = $_SESSION['first_name'];
$lastname = $_SESSION['last_name'];
$email = $_SESSION['email'];
$address = $_SESSION['address'];
$country = $_SESSION['country'];
$state = $_SESSION['state'];
$zip = $_SESSION['zip'];
$interest = $_SESSION['interest'];
$photo = $_SESSION['photo'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/idCard.css">
<link href="https://fonts.googleapis.com/css2?family=Titillium+Web&display=swap" rel="stylesheet">

    <!-- <link rel="stylesheet" href="pdf.css" /> -->
    <script src="pdf.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
    <title>ID Card</title>
</head>

<body>
    <div class="container" id="idCard">
        <div class="padding">
            <div class="font">
                <div class="top">
                    <img src="uploads/<?= $firstname ?>/<?= $photo ?>">
                </div>
                <div class="bottom">
                    <p><?= $firstname ?> <?= $lastname ?></p>
                    <p class="desi">Volunteer</p>
                    <div class="barcode">
                        <img src="images/qr sample.png">
                    </div>
                    <br>
                    <p class="no"><strong>Email:</strong> <?= $email ?></p>
                    <p class="no"><strong>Address:</strong> <?= $address ?></p>
                    <p class="no"><?= $state ?>, <?= $zip ?>, <?= $country ?></p>
                    <p class="no"><strong>Area of Interest:</strong> <?= $interest ?></p>

                </div>
            </div>
        </div>
    </div>
    <!-- <button class="button" style="vertical-align:middle"><span>Back</span></button> -->
    <div class="button-container">
        <button class="button-3 margin-back" role="button" onclick="history.back()"><a href="<?= $previous ?>">Back</a></button>
        <button class="button-3 margin-download" id="download" role="button">Download</button>
    </div>

</body>

</html>