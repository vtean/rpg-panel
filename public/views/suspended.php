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
<div class="dv-suspend">
    <div class="dv-block">
        <h2><i class="fas fa-user-slash"></i> Account Suspended</h2>
        <span>Your account has been suspended until <?php echo $data['unsuspendDate']; ?> by <?php echo $data['suspendedByName']; ?>. Reason: <?php echo $data['suspendedUser']['reason']; ?>.</span>
    </div>
</div>
</body>
</html>