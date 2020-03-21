<?php getHeader($data); ?>
<?php flashMessage(); ?>

    <form action="" method="POST">
        <div class="form-group login-group">
            <input type="text" name="code" id="code"value="">
        </div>
        <button type="submit" class="login-btn">Submit</button>
    </form>
<?php
echo "Secret code: ".$data['secret']. "</br>";
echo "QR-Code: <img src='".$data['qrCode']."'>";
$secret = $data['secret'];
$oneCode = $data['oneCode'];
echo "Checking Code '$oneCode' and Secret '$secret':\n";
if ($data['verify']) {
    echo 'OK';
} else {
    echo 'FAILED';
}

?>
<?php getFooter(); ?>