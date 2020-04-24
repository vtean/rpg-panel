<div class="dv-row">
    <h3 class="dv-page-title">Manage Application Questions</h3>
    <div class="row">
        <div class="col-lg-8 col-sm-12 col-12">
            <form action="" method="post" class="dv-form">
                <input type="hidden" name="csrfToken" value="<?php echo $_SESSION['csrfToken']; ?>"/>
                <div class="form-group">
                    <label for="question">New Question</label>
                    <input type="text" name="question_body" id="question"
                           class="form-control<?php if (!empty($errors['question_error'])): ?> is-invalid<?php endif; ?>">
                    <?php if (!empty($errors['question_error'])): ?>
                        <div class="invalid-feedback"><?php echo $errors['question_error']; ?></div>
                    <?php endif; ?>
                </div>
                <div class="clearfix">
                    <button type="submit" name="add_question" class="dv-btn btn btn-sm btn-primary float-right"><i
                                class="fas fa-plus"></i> Add Question
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="dvTable">
                <table id="dvQuestionsTable">
                    <thead>
                    <tr>
                        <th>Nr.</th>
                        <th>Question</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($data['questions'])): ?>
                        <?php $i = 0; ?>
                        <?php foreach ($data['questions'] as $question): ?>
                            <?php $i++; ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $question['body']; ?></td>
                                <td>
                                    <form action="" method="post">
                                        <input type="hidden" name="csrfToken"
                                               value="<?php echo $_SESSION['csrfToken']; ?>"/>
                                        <input type="hidden" name="question_id" value="<?php echo $question['id']; ?>">
                                        <button type="submit" name="delete_question" class="btn btn-link"><i
                                                    class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>