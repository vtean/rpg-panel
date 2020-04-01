<?php $complaint = $data['complaint']; ?>
<?php getHeader($data); ?>
<h3 class="dv-page-title">Create New Complaint</h3>
<div class="dv-row">
    <div class="row">
        <div class="col-lg-6 col-sm-12 col-12">
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
                    <label for="complaint_category">Complaint Category</label>
                    <select name="complaint_category" id="complaint_category" class="form-control">
                        <?php foreach ($data['categories'] as $category): ?>
                            <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
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
                <div class="form-group">
                    <label for="complaint_proof">Proof</label>
                    <textarea type="text" name="complaint_proof" class="form-control <?php if (!empty($errors['proof_error'])): ?> is-invalid<?php endif; ?>"
                              id="complaint_proof" rows="3"
                              placeholder="Here goes your proof (only links accepted)"><?php echo $complaint['complaint_proof']; ?></textarea>
                    <?php if (!empty($errors['proof_error'])): ?>
                        <div class="invalid-feedback"><?php echo $errors['proof_error']; ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="other_info">Additional Information</label>
                    <textarea type="text" name="other_info" class="form-control" id="other_info" rows="2"
                              placeholder="Leave this field empty if you don't have any other mentions"><?php echo $complaint['other_info']; ?></textarea>
                </div>
                <button type="submit" name="create_complaint" class="dv-btn btn btn-primary"><i class="fas fa-paper-plane"></i> Post Complaint</button>
            </form>
        </div>
    </div>
</div>
<?php getFooter(); ?>
