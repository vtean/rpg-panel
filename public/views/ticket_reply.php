<?php $ticket = $data['ticket']; ?>
<?php getHeader($data); ?>
<?php flashMessage(); ?>
    <h3 class="dv-page-title">Edit Ticket</h3>
    <div class="dv-row dv-create-group">
        <form action="" method="post" class="dv-form">
            <input type="hidden" name="csrfToken" value="<?php echo $_SESSION['csrfToken']; ?>"/>
            <!-- Ticket Details -->
            <h5 class="dv-row-title">Ticket Details</h5>
            <div class="form-group">
                <label for="ticket_category">Ticket Category</label>
                <select type="text" name="ticket_category"
                        class="d-block form-control<?php if (!empty($errors['ticket_category_error'])): ?> is-invalid<?php endif; ?>"
                        id="ticket_category">
                    <?php
                    foreach ($data['categories'] as $category) {
                        ?>
                        <option value="<?= $category['id'] ?>"><?= $category['name']; ?></option>
                        <?php
                    }
                    ?>
                </select>
                <?php if (!empty($errors['ticket_category_error'])): ?>
                    <div class="invalid-feedback"><?php echo $errors['ticket_category_error']; ?></div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="ticket_body">Ticket Body</label>
                <textarea type="text" rows="5" name="ticket_body"
                          class="d-block form-control<?php if (!empty($errors['ticket_body_error'])): ?> is-invalid<?php endif; ?>"
                          id="ticket_body"><?php echo $data['ticketBody']; ?></textarea>
                <?php if (!empty($errors['ticket_body_error'])): ?>
                    <div class="invalid-feedback"><?php echo $errors['ticket_body_error']; ?></div>
                <?php endif; ?>
            </div>
            <button type="submit" name="create_edit" class="dv-btn btn btn-primary m-auto">Submit</button>
        </form>
    </div>
<?php getFooter();