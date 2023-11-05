<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="style.css">
    <title>Projet serpents</title>
</head>
<body class="container-fluid">
<?php include "components/header.php" ?>
    <?php
    if (($_SERVER['REQUEST_METHOD'] == "GET" || $_SERVER['REQUEST_METHOD'] == "POST") && !empty($_GET["page"]))
        $fileimport = "pages/" . $_GET["page"] . ".php";
    else
        $fileimport = "pages/home.php";

    if (file_exists($fileimport))
        include "$fileimport";
    else
        echo "Cette page n'existe pas";
    ?>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>
<script src="/script.js"></script>
<?php include "components/footer.php" ?>
</body>
</html>
