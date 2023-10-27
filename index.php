<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet"/>

    <title>Projet serpents</title>
</head>
<?php include "components/header.php" ?>
<body class="container-fluid">
<div class="content">
    <?php

    if ($_SERVER['REQUEST_METHOD'] == "GET" && !empty($_GET["page"]))
        $fileimport = "pages/" . $_GET["page"] . ".php";
    else
        $fileimport = "pages/home.php";

    if (file_exists($fileimport))
        include "$fileimport";
    else
        echo "Page n'existe pas";


    ?>

</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>
</body>
<?php include "components/footer.php" ?>
</html>