<?php $user = $data['userInfo']; ?>
<div class="dv-row">
    <h3 class="dv-page-title">Profile Settings</h3>
    <div class="dv-row">
        <div class="row">
            <div class="col-lg-2 col-sm-12 col-12">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link<?php if ($data['urlParam'] == 'overview'): ?> active<?php endif; ?>"
                       href="<?php echo BASE_URL . '/users/settings'; ?>"><i class="fas fa-tachometer-alt"></i>
                        Overview</a>
                    <a class="nav-link<?php if ($data['urlParam'] == 'change-email'): ?> active<?php endif; ?>"
                       href="<?php echo BASE_URL . '/users/settings/change-email'; ?>"><i
                                class="fas fa-envelope"></i> Email</a>
                    <a class="nav-link<?php if ($data['urlParam'] == 'change-password'): ?> active<?php endif; ?>"
                       href="<?php echo BASE_URL . '/users/settings/change-password'; ?>"><i class="fas fa-key"></i>
                        Password</a>
                    <a class="nav-link<?php if ($data['urlParam'] == 'forum-name'): ?> active<?php endif; ?>"
                       href="<?php echo BASE_URL . '/users/settings/forum-name'; ?>"><i class="fas fa-font"></i>
                        Forum Name</a>
                    <a class="nav-link<?php if ($data['urlParam'] == 'email-login'): ?> active<?php endif; ?>"
                       href="<?php echo BASE_URL . '/users/settings/email-login'; ?>"><i class="fas fa-lock"></i>
                        Email Login</a>
                    <a class="nav-link<?php if ($data['urlParam'] == 'authenticator'): ?> active<?php endif; ?>"
                       href="<?php echo BASE_URL . '/users/settings/authenticator'; ?>"><i
                                class="fas fa-qrcode"></i> Google Authenticator</a>
                </div>
            </div>
            <div class="col-lg-10 col-sm-12 col-12">
                <div class="tab-content" id="settingsTabContent">
                    <?php if ($data['urlParam'] == 'overview'): ?>
                        <div class="tab-pane fade show active">
                            <div class="dv-page-block">
                                <h4 class="dv-block-title"><i class="fas fa-tachometer-alt"></i> Overview</h4>
                                <ul class="dv-account-overview list-style-none">
                                    <li class="dv-single">
                                        <span class="dv-first">Nickname</span>
                                        <span class="dv-second"><?php echo $user['NickName']; ?></span>
                                    </li>
                                    <li class="dv-single">
                                        <span class="dv-first">Email</span>
                                        <span class="dv-second"><?php echo $user['Mail']; ?></span>
                                        <a href="<?php echo BASE_URL . '/users/settings/change-email'; ?>"
                                           class="dv-btn btn dv-btn-secondary">Change</a>
                                    </li>
                                    <li class="dv-single">
                                        <span class="dv-first">Password</span>
                                        <span class="dv-second">******</span>
                                        <a href="<?php echo BASE_URL . '/users/settings/change-password'; ?>"
                                           class="dv-btn btn dv-btn-secondary">Change</a>
                                    </li>
                                    <li class="dv-single">
                                        <span class="dv-first">Forum Name</span>
                                        <span class="dv-second"><?php echo $user['ForumName']; ?></span>
                                        <a href="<?php echo BASE_URL . '/users/settings/forum-name'; ?>"
                                           class="dv-btn btn dv-btn-secondary">Change</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    <?php elseif ($data['urlParam'] == 'change-email'): ?>
                        <div class="tab-pane fade show active">
                            <div class="dv-page-block">
                                <h4 class="dv-block-title"><i class="fas fa-envelope"></i> Change Email</h4>
                                <form action="" method="post" class="dv-form">
                                    <input type="hidden" name="csrfToken"
                                           value="<?php echo $_SESSION['csrfToken']; ?>">
                                    <div class="form-group">
                                        <label for="newEmail">New email</label>
                                        <input type="email" name="new_email" id="newEmail"
                                               class="form-control<?php if (!empty($errors['email_error'])): ?> is-invalid<?php endif; ?>">
                                        <?php if (!empty($errors['email_error'])): ?>
                                            <div class="invalid-feedback"><?php echo $errors['email_error']; ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirmPassword">Confirm password</label>
                                        <input type="password" name="confirm_password" id="confirmPassword"
                                               class="form-control<?php if (!empty($errors['confirm_pass_error'])): ?> is-invalid<?php endif; ?>">
                                        <?php if (!empty($errors['confirm_pass_error'])): ?>
                                            <div class="invalid-feedback"><?php echo $errors['confirm_pass_error']; ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="clearfix">
                                        <button type="submit" class="dv-btn btn btn-primary float-right"
                                                name="change_email"><i class="fas fa-check"></i> Update
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php elseif ($data['urlParam'] == 'change-password'): ?>
                        <div class="tab-pane fade show active">
                            <div class="dv-page-block">
                                <h4 class="dv-block-title"><i class="fas fa-key"></i> Change Password</h4>
                                <form method="post" class="dv-form">
                                    <input type="hidden" name="csrfToken"
                                           value="<?php echo $_SESSION['csrfToken']; ?>">
                                    <div class="form-group">
                                        <label for="currentPassword">Current Password</label>
                                        <input type="password" name="current_password" id="currentPassword"
                                               class="form-control<?php if (!empty($errors['current_pass_error'])): ?> is-invalid<?php endif; ?>">
                                        <?php if (!empty($errors['current_pass_error'])): ?>
                                            <div class="invalid-feedback"><?php echo $errors['current_pass_error']; ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="newPassword">New Password</label>
                                        <input type="password" name="new_password" id="newPassword"
                                               class="form-control<?php if (!empty($errors['new_pass_error'])): ?> is-invalid<?php endif; ?>">
                                        <?php if (!empty($errors['new_pass_error'])): ?>
                                            <div class="invalid-feedback"><?php echo $errors['new_pass_error']; ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirmNewPassword">Confirm New Password</label>
                                        <input type="password" name="confirm_new_password" id="confirmNewPassword"
                                               class="form-control<?php if (!empty($errors['new_pass_conf_error'])): ?> is-invalid<?php endif; ?>">
                                        <?php if (!empty($errors['new_pass_conf_error'])): ?>
                                            <div class="invalid-feedback"><?php echo $errors['new_pass_conf_error']; ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="clearfix">
                                        <button type="submit" class="dv-btn btn btn-primary float-right"
                                                name="change_password"><i class="fas fa-check"></i> Update
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php elseif ($data['urlParam'] == 'forum-name'): ?>
                        <div class="tab-pane fade show active">
                            <div class="dv-page-block">
                                <h4 class="dv-block-title"><i class="fas fa-font"></i> Forum Nickname</h4>
                                <form action="" method="post" class="dv-form">
                                    <input type="hidden" name="csrfToken"
                                           value="<?php echo $_SESSION['csrfToken']; ?>">
                                    <div class="form-group">
                                        <label for="forumNickname">Your forum nickname (exactly as is)</label>
                                        <input type="text" name="forum_nickname" id="forumNickname"
                                               class="form-control<?php if (!empty($errors['forum_name_error'])): ?> is-invalid<?php endif; ?>">
                                        <?php if (!empty($errors['forum_name_error'])): ?>
                                            <div class="invalid-feedback"><?php echo $errors['forum_name_error']; ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="clearfix">
                                        <button type="submit" class="dv-btn btn btn-primary float-right"
                                                name="change_forum_nick"><i class="fas fa-check"></i> Update
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php elseif ($data['urlParam'] == 'email-login'): ?>
                        <div class="tab-pane fade show active">
                            <div class="dv-page-block">
                                <h4 class="dv-block-title"><i class="fas fa-lock"></i> Configure Email Login</h4>
                                <?php if ($user['Mail'] == 'No Mail Address'): ?>
                                    <div class="dv-message danger">
                                        <i class="fas fa-times"></i>
                                        <span>Looks like you have don't have an email address linked to your account. Add one and try again.</span>
                                    </div>
                                <?php elseif ($user['GoogleStatus'] == 1): ?>
                                    <div class="dv-message danger">
                                        <i class="fas fa-times"></i>
                                        <span>Looks like you have Google Authenticator linked to your account. Deactivate it first to activate Email login. Although, this is not recommended.</span>
                                    </div>
                                <?php elseif ($user['MailLogin'] == 0): ?>
                                    <p>Email login helps to protect your account. Each time we detect a new login
                                        from an unknown IP Address, we will send a code to your email to ensure that
                                        it is you.</p>
                                    <?php if (isset($_POST['activate_email_start'])): ?>
                                        <p>We sent a code to your email. Please check and write it in the field
                                            below.</p>
                                        <form method="post" class="dv-form mb-3">
                                            <input type="hidden" name="csrfToken"
                                                   value="<?php echo $_SESSION['csrfToken']; ?>"/>
                                            <div class="form-group">
                                                <label for="secretCode">Secret Code</label>
                                                <input type="number" name="secret_code" id="secretCode"
                                                       class="form-control<?php if (!empty($errors['secret_code_error'])): ?> is-invalid<?php endif; ?>">
                                                <?php if (!empty($errors['secret_code_error'])): ?>
                                                    <div class="invalid-feedback"><?php echo $errors['secret_code_error']; ?></div>
                                                <?php endif; ?>
                                            </div>
                                            <button type="submit" name="activate_email_end" class="btn btn-success">
                                                <i
                                                        class="fas fa-check"></i> Confirm
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <form method="post" class="mb-3">
                                            <input type="hidden" name="csrfToken"
                                                   value="<?php echo $_SESSION['csrfToken']; ?>"/>
                                            <button type="submit" name="activate_email_start"
                                                    class="btn btn-success"><i
                                                        class="fas fa-check"></i> Enable
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                <?php elseif ($user['MailLogin'] == 1): ?>
                                    <?php if (isset($_POST['deactivate_email_start'])): ?>
                                        <p>Email login helps to protect your account. Each time we detect a new
                                            login
                                            from an unknown IP Address, we will send a code to your email to ensure
                                            that
                                            it is you.</p>
                                        <p>We sent a code to your email. Please check and write it in the field
                                            below to
                                            continue.</p>
                                        <form method="post" class="dv-form mb-3">
                                            <input type="hidden" name="csrfToken"
                                                   value="<?php echo $_SESSION['csrfToken']; ?>"/>
                                            <div class="form-group">
                                                <label for="secretCodeCheck">Secret Code</label>
                                                <input type="number" name="secret_code_check" id="secretCodeCheck"
                                                       class="form-control<?php if (!empty($errors['secret_code_check_error'])): ?> is-invalid<?php endif; ?>">
                                                <?php if (!empty($errors['secret_code_check_error'])): ?>
                                                    <div class="invalid-feedback"><?php echo $errors['secret_code_check_error']; ?></div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="form-group">
                                                <label for="confirmUserPass">Confirm Password</label>
                                                <input type="password" name="confirm_user_pass" id="confirmUserPass"
                                                       class="form-control<?php if (!empty($errors['confirm_user_pass_error'])): ?> is-invalid<?php endif; ?>">
                                                <?php if (!empty($errors['confirm_user_pass_error'])): ?>
                                                    <div class="invalid-feedback"><?php echo $errors['confirm_user_pass_error']; ?></div>
                                                <?php endif; ?>
                                            </div>
                                            <button type="submit" name="deactivate_email_end"
                                                    class="btn btn-danger"><i
                                                        class="fas fa-times"></i> Disable
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <div class="dv-alert success">
                                            <i class="fas fa-check"></i>
                                            <span>Congratulations! Your account is secured by Email login.</span>
                                        </div>
                                        <p>Email login helps to protect your account. Each time we detect a new
                                            login
                                            from an unknown IP Address, we will send a code to your email to ensure
                                            that
                                            it is you.</p>
                                        <form method="post">
                                            <input type="hidden" name="csrfToken"
                                                   value="<?php echo $_SESSION['csrfToken']; ?>"/>
                                            <p>If you do not want to use this method anymore, you can
                                                <button type="submit" name="deactivate_email_start"
                                                        class="btn btn-sm btn-danger">
                                                    Deactivate it
                                                </button>
                                            </p>
                                        </form>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <p>* Follow <a href="">this link</a> to read more information about account
                                    security.
                                </p>
                            </div>
                        </div>
                    <?php elseif ($data['urlParam'] == 'authenticator'): ?>
                        <div class="tab-pane fade show active">
                            <div class="dv-page-block">
                                <h4 class="dv-block-title"><i class="fas fa-qrcode"></i> Google Authenticator</h4>
                                <?php if ($user['Mail'] == 'No Mail Address'): ?>
                                    <div class="dv-message danger">
                                        <i class="fas fa-times"></i>
                                        <span>Looks like you have don't have an email address linked to your account. Add one and try again.</span>
                                    </div>
                                <?php elseif ($user['MailLogin'] == 1): ?>
                                    <div class="dv-message danger">
                                        <i class="fas fa-times"></i>
                                        <span>Looks like you have Email Login linked to your account. Deactivate it first to activate Google Authenticator.</span>
                                    </div>
                                <?php elseif ($user['GoogleStatus'] == 0): ?>
                                    <p>Google Authenticator is the best solution to protect your account. This app
                                        will
                                        generate an unique code every 30 seconds and you will have to enter it each
                                        time
                                        we detect a new login from an unknown IP Address. We strongly recommend you
                                        to
                                        activate this option.</p>
                                    <?php if (isset($_POST['activate_auth_start'])): ?>
                                        <p>Open the <strong>Google Authenticator</strong> app on your smartphone and
                                            scan the QR Code below or type manually the secret code.</p>
                                        <p class="text-danger">Remember or write somewhere the secret code. You will
                                            need it if you lose access to your phone.</p>
                                        <img src="<?php echo $_SESSION['dv_qr_code']; ?>" alt="QR Code">
                                        <p class="mt-3"><strong>Secret
                                                Code:</strong> <?php echo $_SESSION['dv_secret_code']; ?></p>
                                        <form method="post" class="dv-form mb-3">
                                            <input type="hidden" name="csrfToken"
                                                   value="<?php echo $_SESSION['csrfToken']; ?>"/>
                                            <div class="form-group">
                                                <label for="gAuthCode">App Code</label>
                                                <input type="number" name="g_auth_code" id="gAuthCode"
                                                       class="form-control<?php if (!empty($errors['g_auth_code_error'])): ?> is-invalid<?php endif; ?>">
                                                <?php if (!empty($errors['g_auth_code_error'])): ?>
                                                    <div class="invalid-feedback"><?php echo $errors['g_auth_code_error']; ?></div>
                                                <?php endif; ?>
                                            </div>
                                            <button type="submit" name="activate_auth_end" class="btn btn-success">
                                                <i
                                                        class="fas fa-check"></i> Confirm
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <form method="post" class="mb-3">
                                            <input type="hidden" name="csrfToken"
                                                   value="<?php echo $_SESSION['csrfToken']; ?>"/>
                                            <button type="submit" name="activate_auth_start"
                                                    class="btn btn-success"><i
                                                        class="fas fa-check"></i> Enable
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                <?php elseif ($user['GoogleStatus'] == 1): ?>
                                    <?php if (isset($_POST['deactivate_auth_start'])): ?>
                                        <p>Google Authenticator is the best solution to protect your account. This
                                            app will
                                            generate an unique code every 30 seconds and you will have to enter it
                                            each time
                                            we detect a new login from an unknown IP Address.</p>
                                        <p>We sent a code to your email. Please check and write it in the field
                                            below to
                                            continue.</p>
                                        <form method="post" class="dv-form mb-3">
                                            <input type="hidden" name="csrfToken"
                                                   value="<?php echo $_SESSION['csrfToken']; ?>"/>
                                            <div class="form-group">
                                                <label for="secretCodeCheck">Email Code</label>
                                                <input type="number" name="g_auth_code_check" id="gAuthCodeCheck"
                                                       class="form-control<?php if (!empty($errors['g_auth_code_check_error'])): ?> is-invalid<?php endif; ?>">
                                                <?php if (!empty($errors['g_auth_code_check_error'])): ?>
                                                    <div class="invalid-feedback"><?php echo $errors['g_auth_code_check_error']; ?></div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="form-group">
                                                <label for="confirmAuthPass">Confirm Password</label>
                                                <input type="password" name="confirm_auth_pass" id="confirmAuthPass"
                                                       class="form-control<?php if (!empty($errors['confirm_auth_pass_error'])): ?> is-invalid<?php endif; ?>">
                                                <?php if (!empty($errors['confirm_auth_pass_error'])): ?>
                                                    <div class="invalid-feedback"><?php echo $errors['confirm_auth_pass_error']; ?></div>
                                                <?php endif; ?>
                                            </div>
                                            <button type="submit" name="deactivate_auth_end" class="btn btn-danger">
                                                <i
                                                        class="fas fa-times"></i> Disable
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <div class="dv-alert success">
                                            <i class="fas fa-check"></i>
                                            <span>Congratulations! Your account is secured by Google Authenticator.</span>
                                        </div>
                                        <p>Google Authenticator is the best solution to protect your account. This
                                            app will
                                            generate an unique code every 30 seconds and you will have to enter it
                                            each time
                                            we detect a new login from an unknown IP Address.</p>
                                        <form method="post">
                                            <input type="hidden" name="csrfToken"
                                                   value="<?php echo $_SESSION['csrfToken']; ?>"/>
                                            <p>If you do not want to use this method anymore, you can
                                                <button type="submit" name="deactivate_auth_start"
                                                        class="btn btn-sm btn-danger">
                                                    Deactivate it
                                                </button>
                                            </p>
                                        </form>
                                        <p class="text-danger">We do not recommend you to disable this option. Your
                                            account security is very important.</p>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <p>* Follow <a href="">this link</a> to read more
                                    information about account security.</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="alert success dv-fit px-4 mx-auto" role="alert">
                    <i class="fas fa-lock"></i> This area is secure.
                </div>
            </div>
        </div>
    </div>
</div>