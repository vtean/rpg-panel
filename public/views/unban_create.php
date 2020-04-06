<?php $bannedUser = $data['bannedUser']; ?>
<?php getHeader($data); ?>
<?php flashMessage(); ?>
    <h3 class="dv-page-title">New Unban Request</h3>
    <span class="dv-hidden-text"><i
                class="fas fa-ban"></i> Your account has been banned by <?php echo $bannedUser['admin_name']; ?> for <?php echo $bannedUser['BanSeconds'] / 3600; ?> hours. Reason: <?php echo $bannedUser['BanReason']; ?></span>
    <div class="dv-row">
        <div class="row">
            <div class="col-lg-8 col-sm-12 col-12">
                <form action="" method="post" class="dv-form">
                    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION['csrfToken']; ?>"/>
                    <h5 class="dv-row-title">Unban details</h5>
                    <div class="form-group">
                        <textarea type="text" name="unban_comment" id="unban_comment"
                                  class="form-control<?php if (!empty($errors['message_error'])): ?> is-invalid<?php endif; ?>"
                                  rows="5" placeholder="Type here some information about your request"></textarea>
                        <?php if (!empty($errors['message_error'])): ?>
                            <div class="invalid-feedback"><?php echo $errors['message_error']; ?></div>
                        <?php endif; ?>
                    </div>
                    <button type="submit" name="unban_create" class="dv-btn btn btn-primary"><i
                                class="fas fa-paper-plane"></i> Post Request
                    </button>
                </form>
            </div>
        </div>
    </div>
<?php getFooter(); ?>