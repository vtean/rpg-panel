<!doctype html>
<html lang="<?php echo $_COOKIE['user_lang']; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $data['pageTitle']; ?></title>
    <link rel="shortcut icon" href="<?php echo BASE_URL . '/public/resources/img/favicon.ico'; ?>" type="image/x-icon"/>
    <script src="https://kit.fontawesome.com/e6f74534ae.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?php echo BASE_URL . '/public/resources/css/general.css'; ?>"/>
</head>
<body>
<div class="dv-maintenance">
    <div class="dv-block">
        <h2><i class="far fa-pause-circle"></i> Panel Maintenance</h2>
        <p class="dv-first">We are currently working on the website. Be right back.</p>
        <div class="dv-second"><?php echo $data['maintenanceMessage']; ?></div>
        <a href="<?php echo BASE_URL . '/login'; ?>" class="login-btn"><i class="fa fa-sign-in-alt"></i> Login</a>
    </div>
</div>
</body>
</html>