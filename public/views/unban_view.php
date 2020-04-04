<?php $unban = $data['unban']; ?>
<?php getHeader($data); ?>
<?php flashMessage(); ?>
<h3 class="dv-page-title">Unban Request #<?php echo $unban['id']; ?></h3>
<div class="dv-row">
    <div class="row">
        <div class="col-lg-4 col-sm-12 col-12">
            <div class="dv-topic-info">
                <div class="dv-topic-widget">
                    <h4 class="dv-row-title">Request details</h4>
                    <ul class="dv-details list-style-none">
                        <li class="dv-single">
                            <span class="dv-first">Banned user:</span>
                            <span class="dv-second"><a
                                        href="<?php echo BASE_URL . '/users/profile/' . $unban['author_name']; ?>"><?php echo $unban['author_name']; ?></a></span>
                        </li>
                        <li class="dv-single">
                            <span class="dv-first">Banned by:</span>
                            <span class="dv-second"><a
                                        href="<?php echo BASE_URL . '/users/profile/' . $unban['admin_name']; ?>"><?php echo $unban['admin_name']; ?></a></span>
                        </li>
                        <li class="dv-single">
                            <span class="dv-first">Reason:</span>
                            <span class="dv-second"><?php echo $unban['ban_reason']; ?></span>
                        </li>
                        <li class="dv-single">
                            <span class="dv-first">Duration:</span>
                            <span class="dv-second"><?php echo $unban['ban_time']/3600 . ' hours'; ?></span>
                        </li>
                        <li class="dv-single">
                            <span class="dv-first">Status:</span>
                            <span class="dv-second"><?php echo $unban['status']; ?></span>
                        </li>
                    </ul>
                </div>
                <?php if ($data['isAdmin'] > 0 || isLoggedIn() && $_SESSION['user_id'] == $unban['author_id']): ?>
                    <div class="dv-topic-widget dv-actions">
                        <h4 class="dv-row-title">Request actions</h4>
                        <div class="dv-action-buttons">
                            <div class="row">
                                <?php if ($unban['status'] != 'Closed'): ?>
                                    <?php if (isLoggedIn() && $_SESSION['user_id'] == $unban['author_id'] || $data['canCloseUnbans']): ?>
                                        <div class="col">
                                            <form action="" method="post">
                                                <input type="hidden" name="csrfToken"
                                                       value="<?php echo $_SESSION['csrfToken']; ?>">
                                                <button name="close_unban" class="dv-btn btn btn-warning text-white"><i
                                                            class="fas fa-lock"></i> Close
                                                </button>
                                            </form>
                                        </div>
                                    <?php endif; ?>
                                <?php elseif ($unban['status'] == 'Closed'): ?>
                                    <?php if ($data['canCloseUnbans']): ?>
                                        <div class="col">
                                            <form action="" method="post">
                                                <input type="hidden" name="csrfToken"
                                                       value="<?php echo $_SESSION['csrfToken']; ?>">
                                                <button name="open_unban" class="dv-btn btn btn-success text-white"><i
                                                            class="fas fa-unlock"></i> Open
                                                </button>
                                            </form>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if ((isLoggedIn() && $_SESSION['user_id'] == $unban['author_id'] && $unban['status'] == 'Open') || $data['canEditUnbans']): ?>
                                    <div class="col">
                                        <form action="" method="post">
                                            <input type="hidden" name="csrfToken"
                                                   value="<?php echo $_SESSION['csrfToken']; ?>">
                                            <a href="<?php echo BASE_URL . '/unbans/edit/' . $unban['id']; ?>"
                                               class="dv-btn btn btn-primary"><i class="fas fa-edit"></i> Edit</a>
                                        </form>
                                    </div>
                                <?php endif; ?>
                                <?php if ($data['canCloseUnbans']): ?>
                                    <div class="w-100"></div>
                                    <div class="col">
                                        <form action="" method="post">
                                            <input type="hidden" name="csrfToken"
                                                   value="<?php echo $_SESSION['csrfToken']; ?>">
                                            <button name="needs_owner" class="dv-btn btn btn-danger"><i
                                                        class="fas fa-shield-alt"></i> Needs Owner
                                            </button>
                                        </form>
                                    </div>
                                <?php endif; ?>
                                <?php if ($data['canDeleteUnbans']): ?>
                                    <div class="col">
                                        <form action="" method="post">
                                            <input type="hidden" name="csrfToken"
                                                   value="<?php echo $_SESSION['csrfToken']; ?>">
                                            <button name="delete_unban" class="dv-btn btn btn-danger"><i
                                                        class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-lg-8 col-sm-12 col-12">
            <div class="dv-topic-message">
                <h4 class="dv-row-title">Request description</h4>
                <p><?php echo $unban['description']; ?></p>
            </div>
            <div class="dv-topic-replies">
                <h4 class="dv-row-title">Request replies</h4>
                <?php if (empty($data['uReplies'])): ?>
                    <span>There are currently no replies.</span>
                <?php else: ?>
                    <?php foreach ($data['uReplies'] as $reply): ?>
                        <div class="dv-reply">
                            <div class="dv-reply-avatar">
                                <img src="<?php echo BASE_URL . '/public/resources/img/skins/id-' . $reply['author_avatar'] . '.png'; ?>"
                                     alt="<?php echo $reply['author_name'] . "'s avatar"; ?>">
                            </div>
                            <div class="dv-reply-content">
                                <div class="dv-reply-head clearfix">
                                    <div class="dv-reply-author">
                                        <a href="<?php echo BASE_URL . '/users/profile/' . $reply['author_name']; ?>" class="author-name"><?php echo $reply['author_name']; ?></a>
                                        <?php if ($reply['admin_level'] > 0): ?>
                                            <span class="badge badge-danger"><i
                                                        class="fas fa-shield-alt"></i> Admin</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="dv-reply-date">
                                        <span><i class="far fa-clock"></i> <?php echo $reply['created_at']; ?></span>
                                        <?php if ($data['canDeleteUnbans']): ?>
                                            <div class="dv-reply-actions float-right">
                                                <form action="" method="post">
                                                    <input type="hidden" name="csrfToken"
                                                           value="<?php echo $_SESSION['csrfToken']; ?>"/>
                                                    <input type="hidden" name="reply_id" value="<?php echo $reply['id']; ?>">
                                                    <button name="delete_reply" class="btn btn-link p-0 mx-2"><i
                                                                class="fas fa-trash"></i></button>
                                                </form>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="dv-reply-body">
                                    <span><?php echo $reply['body']; ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php if ($unban['closed_by'] != 0): ?>
                    <div class="dv-closed-topic">
                        <span><i class="fas fa-lock"></i> This topic has been closed by <a
                                    href="<?php echo BASE_URL . '/users/profile/' . $unban['closed_by_name']; ?>"><?php echo $unban['closed_by_name']; ?></a>.</span>
                    </div>
                <?php endif; ?>
            </div>
            <?php if ($unban['status'] != 'Closed'): ?>
                <form action="" method="post" class="dv-form">
                    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION['csrfToken']; ?>"/>
                    <h4 class="dv-row-title">Leave a reply</h4>
                    <div class="form-group">
                            <textarea type="text" name="unban_reply" id="unban_reply" rows="5"
                                      class="form-control<?php if (!empty($errors['reply_error'])): ?> is-invalid<?php endif; ?>"
                                      placeholder="Only complaint creator, reporter player, admins and leaders can post replies"></textarea>
                        <?php if (!empty($errors['reply_error'])): ?>
                            <div class="invalid-feedback"><?php echo $errors['reply_error']; ?></div>
                        <?php endif; ?>
                    </div>
                    <button type="submit" name="post_reply" class="dv-btn btn btn-primary"><i
                                class="fas fa-paper-plane"></i> Submit
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php getFooter(); ?>
