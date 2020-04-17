<?php $complaint = $data['complaint']; ?>
<?php getHeader($data); ?>
    <div class="dv-row">
        <h3 class="dv-page-title">Create Faction Complaint</h3>
        <div class="row">
            <div class="col-lg-8 col-sm-12 col-12">
                <form action="" method="post" class="dv-form">
                    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION['csrfToken']; ?>"/>
                    <h5 class="dv-row-title">Complaint Details</h5>
                    <div class="form-group">
                        <label for="against_name">Complaint Against</label>
                        <input type="text" name="against_name" value="<?php echo $complaint['against_name']; ?>"
                               class="form-control<?php if (!empty($errors['username_error'])): ?> is-invalid<?php endif; ?>"
                               id="against_name" placeholder="Type here player's username">
                        <?php if (!empty($errors['username_error'])): ?>
                            <div class="invalid-feedback"><?php echo $errors['username_error']; ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="complaint_desc">Complaint Description</label>
                        <textarea type="text" name="complaint_desc"
                                  class="form-control <?php if (!empty($errors['description_error'])): ?> is-invalid<?php endif; ?>"
                                  id="complaint_desc" rows="5"
                                  placeholder="Tell us more about your complaint"><?php echo $complaint['complaint_desc']; ?></textarea>
                        <?php if (!empty($errors['description_error'])): ?>
                            <div class="invalid-feedback"><?php echo $errors['description_error']; ?></div>
                        <?php endif; ?>
                    </div>
                    <button type="submit" name="create_complaint" class="dv-btn btn btn-primary"><i class="fas fa-paper-plane"></i> Post Complaint</button>
                </form>
            </div>
        </div>
    </div>
<?php getFooter(); ?>