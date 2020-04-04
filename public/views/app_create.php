<?php getHeader($data); ?>
<?php flashMessage(); ?>
    <h3 class="dv-page-title">Apply for function</h3>
    <div class="dv-row">
        <div class="row">
            <div class="col-lg-6 col-sm-12 col-12">
                <div class="dv-desc">
                    <h5 class="dv-row-title">Posting Model:</h5>
                    <ul>
                        <li>Nume real:</li>
                        <li>Vârsta reală:</li>
                        <li>Hobby-uri:</li>
                        <li>Care sunt realizările tale cele mai mari pe server?:</li>
                        <li>Ce planuri de viitor ai?:</li>
                        <li>Ce alte jocuri mai joci? Car este preferatul tău?:</li>
                        <li>De ce crezi că meriti această funcție?:</li>
                        <li>Crezi că te vei descurca?:</li>
                        <li>etc.</li>
                    </ul>
                </div>
                <form action="" method="post" class="dv-form">
                    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION['csrfToken']; ?>"/>
                    <h5 class="dv-row-title">Application content</h5>
                    <div class="form-group">
                        <textarea name="body" id="body" rows="5" class="form-control<?php if (!empty($errors['body_error'])): ?> is-invalid<?php endif; ?>"></textarea>
                        <?php if (!empty($errors['body_error'])): ?>
                            <div class="invalid-feedback"><?php echo $errors['body_error']; ?></div>
                        <?php endif; ?>
                    </div>
                    <button type="submit" name="create_application" class="dv-btn btn btn-primary"><i class="fas fa-paper-plane"></i> Post Application</button>
                </form>
            </div>
        </div>
    </div>
<?php getFooter(); ?>
