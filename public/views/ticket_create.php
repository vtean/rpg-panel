<?php $ticket = $data['ticket']; ?>
<h3 class="dv-page-title">Create New Ticket</h3>
<div class="dv-row">
    <div class="row">
        <div class="col-lg-8 col-sm-12 col-12">
            <form action="" method="post" class="dv-form">
                <input type="hidden" name="csrfToken" value="<?php echo $_SESSION['csrfToken']; ?>"/>
                <!-- Ticket Details -->
                <h5 class="dv-row-title">Ticket Details</h5>
                <div class="form-group">
                    <label for="ticket_category">Ticket Category</label>
                    <select type="text" name="ticket_category"
                            class="form-control<?php if (!empty($errors['ticket_category_error'])): ?> is-invalid<?php endif; ?>"
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
                    <textarea type="text" rows="7" name="ticket_body"
                              class="form-control<?php if (!empty($errors['ticket_body_error'])): ?> is-invalid<?php endif; ?>"
                              id="ticket_body"><?php echo $data['ticketBody']; ?></textarea>
                    <?php if (!empty($errors['ticket_body_error'])): ?>
                        <div class="invalid-feedback"><?php echo $errors['ticket_body_error']; ?></div>
                    <?php endif; ?>
                </div>
                <button type="submit" name="create_ticket" class="dv-btn btn btn-primary"><i
                            class="fas fa-paper-plane"></i> Submit
                </button>
            </form>
        </div>
    </div>
</div>