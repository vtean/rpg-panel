<?php $ticket = $data['ticket']; ?>
<?php getHeader($data); ?>
<?php flashMessage(); ?>
    <h3 class="dv-page-title">Ticket #<?= $ticket['id'] ?></h3>
    <div class="dv-row">
        <div class="row">
            <div class="col-lg-6 col-sm-12 col-12">
                <ul>
                    <?php
                    foreach ($data['replies'] as $reply) {
                        ?>
                        <li>
                            <?php
                            echo $reply['body'] . '</br>';
                            echo $reply['author_name']['NickName'] . '</br>';
                            echo $reply['user_status'] . '</br>';
                            echo $reply['created_at'] . '</br>';
                            ?>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
                <form action="" method="post" class="dv-form">
                    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION['csrfToken']; ?>"/>
                    <!-- Ticket Details -->
                    <h5 class="dv-row-title">Let a reply</h5>
                    <div class="form-group">
                        <label for="ticket_reply">Reply</label>
                        <textarea type="text" rows="5" name="ticket_reply"
                                  class="d-block form-control<?php if (!empty($errors['ticket_reply_error'])): ?> is-invalid<?php endif; ?>"
                                  id="ticket_reply"></textarea>
                        <?php if (!empty($errors['ticket_reply_error'])): ?>
                            <div class="invalid-feedback"><?php echo $errors['ticket_reply_error']; ?></div>
                        <?php endif; ?>
                    </div>
                    <button type="submit" name="reply_ticket" class="dv-btn btn btn-primary m-auto">Submit</button>
                </form>
            </div>
        </div>
    </div>
<?php getFooter();