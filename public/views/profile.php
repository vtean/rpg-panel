<?php getHeader($data['pageTitle']); ?>
    <h3 class="dv-page-title"><?php echo $data['user']['NickName']; ?></h3>
    <pre>
        <?php print_r($data['user']); ?>
    </pre>
<?php getFooter(); ?>
