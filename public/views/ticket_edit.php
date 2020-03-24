<?php $group = $data['ticket']; ?>
<?php getHeader($data); ?>
    <?php flashMessage(); ?>
    <h3 class="dv-page-title">Edit Group: <?php echo $group['group_name']; ?></h3>
    <div class="dv-row">
        <div class="dv-secret-actions">
            <form action="" method="post">
                <button type="submit" name="delete_group" class="dv-btn btn btn-danger"><i class="fas fa-trash-alt"></i> Delete Group</button>
            </form>
        </div>
    </div>
    <div class="dv-row dv-create-group">
        <form action="" method="post" class="dv-form">
            <!-- Group Details -->
            <h5 class="dv-row-title">Group Details</h5>
            <div class="form-group">
                <label for="group_name">Group Name</label>
                <input type="text" name="group_name" class="form-control<?php if (!empty($errors['group_name_error'])): ?> is-invalid<?php endif;?>" id="group_name" value="<?php echo $group['group_name']; ?>">
                <?php if (!empty($errors['group_name_error'])): ?>
                    <div class="invalid-feedback"><?php echo $errors['group_name_error']; ?></div>
                <?php endif; ?>
            </div>
            <div class="text-align-center">
                <button type="submit" name="edit_group" class="dv-btn btn btn-primary m-auto">Submit</button>
            </div>
        </form>
    </div>
<?php getFooter();