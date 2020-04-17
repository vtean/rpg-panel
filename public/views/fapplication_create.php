<?php getHeader($data); ?>
<?php flashMessage(); ?>
<div class="dv-row">
    <h3 class="dv-page-title">Create Application</h3>
    <div class="row">
        <div class="col-lg-8 col-sm-12 col-12">
            <form action="" method="post" class="dv-form">
                <input type="hidden" name="csrfToken" value="<?php echo $_SESSION['csrfToken']; ?>"/>
                <?php $i = 0; ?>
                <?php foreach ($data['questions'] as $question): ?>
                    <?php $i++ ;?>
                    <div class="form-group">
                        <label for="answer<?php echo $i; ?>"><?php echo $question['body']; ?></label>
                        <input type="hidden" name="question<?php echo $i; ?>" value="<?php echo $question['body']; ?>">
                        <input type="text" name="answer<?php echo $i; ?>" id="answer<?php echo $i; ?>" class="form-control<?php if (!empty($errors['answer' . $i . '_error'])): ?> is-invalid<?php endif; ?>">
                        <?php if (!empty($errors['answer' . $i . '_error'])): ?>
                            <div class="invalid-feedback"><?php echo $errors['answer' . $i . '_error']; ?></div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
                <button type="submit" name="post_application" class="dv-btn btn btn-primary"><i class="fas fa-paper-plane"></i> Post Application</button>
            </form>
        </div>
    </div>
</div>
<?php getFooter(); ?>
