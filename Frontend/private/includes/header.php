<?php
require_once __DIR__ . '/../../config/config.php';
?>

<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo APP_NAME; ?></title>

        <!-- favicon-->
        <link rel="shortcut icon" href="/ProjetoSIBDAS/Frontend/assets/img/Icon.png" type="image/png">

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,300;0,700;1,400&display=swap" rel="stylesheet">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="/ProjetoSIBDAS/Frontend/assets/fontawesome/all.min.css">

        <!-- Bootstrap -->
        <link rel="stylesheet" href="/ProjetoSIBDAS/Frontend/assets/bootstrap/bootstrap.min.css">

        <!-- Estilos da página -->
        <link rel="stylesheet" href="/ProjetoSIBDAS/Frontend/assets/css/1240811.css">

        <!-- jQuery -->
        <script src="/ProjetoSIBDAS/Frontend/assets/jQuery/jquery-3.6.0.min.js"></script>
        
        <!-- DataTables CSS + JS -->
        <link rel="stylesheet" href="/ProjetoSIBDAS/Frontend/assets/datatables/datatables.min.css">
        <script src="/ProjetoSIBDAS/Frontend/assets/datatables/datatables.min.js"></script>

    </head>

    <body class="<?= $bodyClass ?? '' ?>">