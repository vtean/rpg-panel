<?php getHeader($data['pageTitle']); ?>
    <h1><?php echo($data['pageTitle']); ?></h1>
    <form action="" method="POST">
        <label for="username">
            <span> Username</span>
        </label>
        <input type="text" name="username" id="username" value="<?php echo $data['user_name']; ?>"
               placeholder="Type here your username">
        <label for="password">
            <span> Password</span>
        </label>
        <input type="password" name="password" id="password" placeholder="Your password goes here">
        <div>
            <button type="submit">Submit</button>
        </div>
    </form>
<?php getFooter(); ?>