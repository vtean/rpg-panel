<?php getHeader($data); ?>
    <div class="card col-md-5 login shadow">
        <div class="card-body">
            <span class="login-icon">
                <i class="fas fa-sign-in-alt"></i>
            </span>
            <h2 class="login-title">Log In</h2>
            <form action="" method="POST" class="dv-form">
                <div class="form-group login-group">
                    <input type="text" name="username" id="username"
                           class="login-form<?php if (!empty($errors['user_name_error'])): ?> is-invalid<?php endif; ?>">
                    <span class="login-span username"></span>
                    <?php if (!empty($errors['user_name_error'])): ?>
                        <div class="invalid-feedback">
                            <span><?php echo $errors['user_name_error']; ?></span>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form-group login-group">
                    <input type="password" name="password" id="password"
                           class="login-form<?php if (!empty($errors['user_password_error'])): ?> is-invalid<?php endif; ?>">
                    <span class="login-span password"></span>
                    <?php if (!empty($errors['user_password_error'])): ?>
                        <div class="invalid-feedback">
                            <span><?php echo $errors['user_password_error']; ?></span>
                        </div>
                    <?php endif; ?>
                </div>
                <button type="submit" class="login-btn">Login</button>
            </form>
        </div>
    </div>
<?php getFooter(); ?>