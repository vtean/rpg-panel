<?php getHeader($data); ?>
    <div class="card col-md-5 login">
        <div class="card-body">
            <span class="login-icon">
                <i class="fas fa-shield-alt"></i>
            </span>
            <h2 class="login-title"><?php echo $data['lang']['login_txt']; ?></h2>
            <form action="" method="POST" class="dv-form">
                <div class="form-group login-group">
                    <input type="number" name="email" id="secret"
                           class="login-form<?php if (!empty($errors['secret_email_error'])): ?> is-invalid<?php endif; ?>" maxlength="6">
                    <span class="login-span secret"></span>
                    <?php if (!empty($errors['secret_email_error'])): ?>
                        <div class="invalid-feedback">
                            <span><?php echo $errors['secret_email_error']; ?></span>
                        </div>
                    <?php endif; ?>
                </div>
                <p class="text-align-center"><?php echo $data['lang']['lost_secret_txt']; ?> <a href=""><?php echo $data['lang']['here_txt']; ?></a></p>
                <button type="submit" class="login-btn" name="authCheck"><?php echo $data['lang']['login_txt']; ?></button>
            </form>
        </div>
    </div>
<?php getFooter(); ?>