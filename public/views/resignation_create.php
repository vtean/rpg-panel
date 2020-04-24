<div class="dv-row">
    <h3 class="dv-page-title">Post Resignation</h3>
    <div class="row">
        <div class="col-lg-8 col-sm-12 col-12">
            <form action="" method="post" class="dv-form">
                <input type="hidden" name="csrfToken" value="<?php echo $_SESSION['csrfToken']; ?>"/>
                <h5 class="dv-row-title">Resignation details</h5>
                <div class="form-group">
                    <label for="resignationBody">Description</label>
                    <textarea name="resignation_body" id="resignationBody" rows="5"
                              class="form-control<?php if (!empty($errors['body_error'])): ?> is-invalid<?php endif; ?>"></textarea>
                    <?php if (!empty($errors['body_error'])): ?>
                        <div class="invalid-feedback"><?php echo $errors['body_error']; ?></div>
                    <?php endif; ?>
                </div>
                <button type="submit" name="post_resignation" class="dv-btn btn btn-primary"><i
                            class="fas fa-paper-plane"></i> Post Resignation
                </button>
            </form>
        </div>
    </div>
</div>