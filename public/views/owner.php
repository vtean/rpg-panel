<?php getHeader($data); ?>
    <?php flashMessage(); ?>
    <h3 class="dv-page-title">Welcome, dear Owner</h3>
    Owner: <?php echo $data['fullAccess']; ?><br>
    Admin: <?php echo $data['isAdmin']; ?><br>
    Leader: <?php echo $data['isLeader']; ?>
<?php getFooter(); ?>