<?php getHeader($data['pageTitle']); ?>
    <h2 class="tnCentered">Login</h2>
    <div class="tnCentered"><?php flashMessage(); ?></div>
    <div class="tnAuth tnMarginAuto">
        <form action="" method="POST" class="tnForm">
            <div class="tnFormGroup">
                <label for="username">
                    <i class="fas fa-user"></i>
                    <span> Username</span>
                </label>
                <input type="text" name="username"
                       class="tnFormInput<?php if (!empty($errors['user_name_error'])): ?> tnInvalidInput<?php endif; ?>"
                       id="username" value="<?php echo $data['user_name']; ?>"
                       placeholder="Type here your username">
                <?php if (!empty($errors['user_name_error'])): ?>
                    <span class="tnInvalidInputInfo"><?php echo $errors['user_name_error']; ?></span>
                <?php endif; ?>
            </div>
            <div class="tnFormGroup">
                <label for="password">
                    <i class="fas fa-lock"></i>
                    <span> Password</span>
                </label>
                <input type="text" name="password"
                       class="tnFormInput<?php if (!empty($errors['user_password_error'])): ?> tnInvalidInput<?php endif; ?>"
                       id="password" placeholder="Your password goes here">
                <?php if (!empty($errors['user_password_error'])): ?>
                    <span class="tnInvalidInputInfo"><?php echo $errors['user_password_error']; ?></span>
                <?php endif; ?>
            </div>
            <div class="tnFormSubmit">
                <button type="submit" class="tnBtn tnSubmitBtn">Submit</button>
            </div>
            <p class="tnCentered tnLoginInfo">Don't have an account yet? <a
                        href="<?php echo BASE_URL . '/register/'; ?>">Register</a> now</p>
        </form>
    </div>
<?php getFooter(); ?>