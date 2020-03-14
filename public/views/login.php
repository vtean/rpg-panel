<?php getHeader($data['pageTitle']); ?>
    <h1><?php echo($data['pageTitle']); ?></h1>
    <form action="" method="POST" class="dv-form">
        <div class="form-group">
            <label for="username">
                <i class="fas fa-user"></i>
                <span>Username</span>
            </label>
            <input type="text" name="username" id="username" class="form-control<?php if (!empty($errors['user_name_error'])): ?> is-invalid<?php endif; ?>">
            <?php if (!empty($errors['user_name_error'])): ?>
                <div class="invalid-feedback">
                    <span><?php echo $errors['user_name_error']; ?></span>
                </div>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <label for="password">
                <i class="fas fa-lock"></i>
                <span>Password</span>
            </label>
            <input type="password" name="password" id="password" class="form-control<?php if (!empty($errors['user_password_error'])): ?> is-invalid<?php endif; ?>">
            <?php if (!empty($errors['user_password_error'])): ?>
                <div class="invalid-feedback">
                    <span><?php echo $errors['user_password_error']; ?></span>
                </div>
            <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <p class="tnCentered tnLoginInfo">Don't have an account yet? <a
                    href="<?php echo BASE_URL . '/register/'; ?>">Register</a> now</p>
    </form>
<?php getFooter(); ?>