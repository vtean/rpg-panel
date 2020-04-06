<?php
    $userApp = $data['userApp'];
?>
<?php getHeader($data); ?>
<?php flashMessage(); ?>
<h3 class="dv-page-title">Edit <?php echo $userApp['type']; ?> application #<?php echo $userApp['id']; ?></h3>
<div class="dv-row">
    <div class="row">
        <div class="col-lg-6 col-sm-12 col-12">
            <form action="" method="post" class="dv-form">
                <input type="hidden" name="csrfToken" value="<?php echo $_SESSION['csrfToken']; ?>"/>
                <h5 class="dv-row-title">Application Details</h5>
                <div class="form-group">
                    <textarea type="text" name="app_body" id="app_body" rows="5" class="form-control<?php if (!empty($errors['body_error'])): ?> is-invalid<?php endif;?>"><?php echo html_entity_decode($userApp['body']); ?></textarea>
                    <?php if (!empty($errors['body_error'])): ?>
                        <div class="invalid-feedback"><?php echo $errors['body_error']; ?></div>
                    <?php endif; ?>
                </div>
                <button type="submit" name="edit_application" class="dv-btn btn btn-primary"><i class="fas fa-pencil-alt"></i> Edit Application</button>
            </form>
        </div>
    </div>
</div>
<?php getFooter(); ?>
