<?php $ticket = $data['ticket'];
?>
<?php getHeader($data); ?>
<?php flashMessage(); ?>
    <h3 class="dv-page-title">Edit Ticket</h3>
    <div class="dv-row">
         <div class="dv-secret-actions">
             <form action="" method="post">
                <input type="hidden" name="csrfToken" value="<?php echo $_SESSION['csrfToken']; ?>">
                <?php
                if ($data['canDeleteTickets']) {
                    ?>
                    <button type="submit" name="delete_ticket" class="dv-btn btn btn-danger"><i
                                class="fas fa-trash-alt"></i> Delete Ticket
                    </button>
                    <?php
                };
                ?>
                <button type="submit" name="close_ticket" class="dv-btn btn btn-warning"><i
                            class="fas fa-times-circle"></i></i> Close Ticket
                </button>
            </form>
        </div>
    </div>
    <div class="dv-row">
        <div class="row">
            <div class="col-lg-6 col-sm-12 col-12">
                <form action="" method="post" class="dv-form">
                    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION['csrfToken']; ?>"/>
                    <!-- Ticket Details -->
                    <h5 class="dv-row-title">Ticket Details</h5>
                    <div class="form-group">
                        <label for="ticket_category">Ticket Category</label>
                        <select type="text" name="ticket_category"
                                class="d-block form-control<?php if (!empty($errors['ticket_category_error'])): ?> is-invalid<?php endif; ?>"
                                id="ticket_category">
                            <option value="<?= $ticket['category_id'] ?>"><?= $data['category_name']['name']; ?></option>
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
                                  class="d-block form-control<?php if (!empty($errors['ticket_body_error'])): ?> is-invalid<?php endif; ?>"
                                  id="ticket_body"><?php echo $ticket['body']; ?></textarea>
                        <?php if (!empty($errors['ticket_body_error'])): ?>
                            <div class="invalid-feedback"><?php echo $errors['ticket_body_error']; ?></div>
                        <?php endif; ?>
                    </div>
                    <button type="submit" name="edit_ticket" class="dv-btn btn btn-primary m-auto">Submit</button>
                </form>
            </div>
        </div>
    </div>
<?php getFooter();