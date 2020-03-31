<!doctype html>
<html lang="<?php echo $_COOKIE["user_lang"]; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $data['pageTitle'] . ' - ' . SITE_NAME; ?></title>
    <link rel="shortcut icon" href="<?php echo BASE_URL . '/public/resources/img/favicon.ico'; ?>" type="image/x-icon" />
    <script src="https://kit.fontawesome.com/e6f74534ae.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?php echo BASE_URL . '/public/resources/3rd_party/bootstrap/bootstrap.min.css'; ?>" />
    <link rel="stylesheet" href="<?php echo BASE_URL . '/public/resources/3rd_party/datatables/datatables.min.css'; ?>" />
    <link rel="stylesheet" href="<?php echo BASE_URL . '/public/resources/css/dreamvibe.css'; ?>" />
</head>
<body>
    <main class="dv-main">
        <?php getMenu($data); ?>
        <div class="dv-main-content">
            <h1 class="dv-visually-hidden">DreamVibe Panel</h1>