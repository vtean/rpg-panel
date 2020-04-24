<?php
$complaint = $data['complaint'];
$author = $complaint['author'];
$against_user = $complaint['against_user'];
$replies = $data['cReplies'];
?>
<h3 class="dv-page-title">Faction Complaint #<?php echo $complaint['id']; ?></h3>
<div class="dv-row">
    <div class="row">
        <div class="col-lg-4 col-sm-12 col-12">
            <div class="dv-topic-info">
                <div class="dv-topic-widget">
                    <h4 class="dv-row-title">Complaint creator</h4>
                    <ul class="dv-details list-style-none">
                        <li class="dv-single">
                            <span class="dv-first">Username:</span>
                            <span class="dv-second"><a
                                        href="<?php echo BASE_URL . '/users/profile/' . $author['NickName']; ?>"><?php echo $author['NickName']; ?></a></span>
                        </li>
                        <li class="dv-single">
                            <span class="dv-first">Level:</span>
                            <span class="dv-second"><?php echo $author['Level']; ?></span>
                        </li>
                        <li class="dv-single">
                            <span class="dv-first">Played Time:</span>
                            <span class="dv-second"><?php echo convertMinutes($author['PlayedTime']); ?></span>
                        </li>
                        <li class="dv-single">
                            <span class="dv-first">Faction:</span>
                            <span class="dv-second"><?php echo $author['faction_name']; ?></span>
                        </li>
                    </ul>
                </div>
                <div class="dv-topic-widget">
                    <h4 class="dv-row-title">Complaint against</h4>
                    <ul class="dv-details list-style-none">
                        <li class="dv-single">
                            <span class="dv-first">Username:</span>
                            <span class="dv-second"><a
                                        href="<?php echo BASE_URL . '/users/profile/' . $against_user['NickName']; ?>"><?php echo $against_user['NickName']; ?></a></span>
                        </li>
                        <li class="dv-single">
                            <span class="dv-first">Level:</span>
                            <span class="dv-second"><?php echo $against_user['Level']; ?></span>
                        </li>
                        <li class="dv-single">
                            <span class="dv-first">Played Time:</span>
                            <span class="dv-second"><?php echo convertMinutes($against_user['PlayedTime']); ?></span>
                        </li>
                        <li class="dv-single">
                            <span class="dv-first">Faction:</span>
                            <span class="dv-second"><?php echo $against_user['faction_name']; ?></span>
                        </li>
                        <li class="dv-single">
                            <span class="dv-first">Faction Warns:</span>
                            <span class="dv-second"><?php echo $against_user['FWarns']; ?>/3</span>
                        </li>
                    </ul>
                </div>
                <?php if ($data['privileges']['isAdmin'] > 0 || isLoggedIn() && $_SESSION['user_id'] == $complaint['author_id']): ?>
                    <div class="dv-topic-widget dv-actions">
                        <h4 class="dv-row-title">Complaint actions</h4>
                        <div class="dv-action-buttons">
                            <div class="row">
                                <?php if ($complaint['status'] != 'Closed'): ?>
                                    <?php if ((isLoggedIn() && $_SESSION['user_id'] == $complaint['author_id']) || $data['privileges']['canCloseFComplaints'] && $complaint['category_id'] == 9): ?>
                                        <div class="col">
                                            <form action="" method="post">
                                                <input type="hidden" name="csrfToken"
                                                       value="<?php echo $_SESSION['csrfToken']; ?>">
                                                <button name="close_complaint"
                                                        class="dv-btn btn btn-warning text-white"><i
                                                            class="fas fa-lock"></i> Close
                                                </button>
                                            </form>
                                        </div>
                                    <?php endif; ?>
                                <?php elseif ($complaint['status'] == 'Closed'): ?>
                                    <?php if ($data['privileges']['canCloseFComplaints'] && $complaint['category_id'] == 9): ?>
                                        <div class="col">
                                            <form action="" method="post">
                                                <input type="hidden" name="csrfToken"
                                                       value="<?php echo $_SESSION['csrfToken']; ?>">
                                                <button name="open_complaint" class="dv-btn btn btn-success"><i
                                                            class="fas fa-lock"></i> Open
                                                </button>
                                            </form>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if ((isLoggedIn() && $_SESSION['user_id'] == $complaint['author_id'] && $complaint['status'] != 'Closed') || $data['privileges']['canEditFComplaints'] && $complaint['category_id'] == 9): ?>
                                    <div class="col">
                                        <form action="" method="post">
                                            <input type="hidden" name="csrfToken"
                                                   value="<?php echo $_SESSION['csrfToken']; ?>">
                                            <a href="<?php echo BASE_URL . '/factions/complaints/' . $complaint['faction_id'] . '/edit/' . $complaint['id']; ?>"
                                               class="dv-btn btn btn-primary"><i class="fas fa-edit"></i> Edit</a>
                                        </form>
                                    </div>
                                <?php endif; ?>
                                <?php if ($data['privileges']['canDeleteFComplaints'] && $complaint['category_id'] == 9): ?>
                                    <div class="col">
                                        <form action="" method="post">
                                            <input type="hidden" name="csrfToken"
                                                   value="<?php echo $_SESSION['csrfToken']; ?>">
                                            <button name="delete_complaint" class="dv-btn btn btn-danger"><i
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
                <h4 class="dv-row-title">Complaint details</h4>
                <div class="dv-single">
                    <span class="dv-first">Category</span>
                    <span class="dv-second"><?php echo $complaint['category_name']; ?></span>
                </div>
                <div class="dv-single">
                    <span class="dv-first">Created on:</span>
                    <span class="dv-second"><?php echo $complaint['created_at']; ?></span>
                </div>
                <div class="dv-single">
                    <div class="dv-first">Description:</div>
                    <div class="dv-second"><?php echo $complaint['description']; ?></div>
                </div>
            </div>
            <div class="dv-topic-replies">
                <h4 class="dv-row-title">Complaint replies</h4>
                <?php if (empty($replies)): ?>
                    <span>There are currently no replies.</span>
                <?php else: ?>
                    <?php foreach ($replies as $reply): ?>
                        <div class="dv-reply">
                            <div class="dv-reply-avatar">
                                <img src="<?php echo BASE_URL . '/public/resources/img/skins/id-' . $reply['author_skin'] . '.png'; ?>"
                                     alt="<?php echo $reply['author_name'] . "'s avatar"; ?>">
                            </div>
                            <div class="dv-reply-content">
                                <div class="dv-reply-head clearfix">
                                    <div class="dv-reply-author">
                                        <a href="<?php echo BASE_URL . '/users/profile/' . $reply['author_name']; ?>"
                                           class="author-name"><?php echo $reply['author_name']; ?></a>
                                        <?php if ($reply['admin_level'] > 0): ?>
                                            <span class="badge badge-danger"><i
                                                        class="fas fa-shield-alt"></i> Admin</span>
                                        <?php endif; ?>
                                        <?php if (isset($reply['user_status']) && !empty(isset($reply['user_status']))): ?>
                                            <span class="badge <?php if ($reply['user_status'] == 'Complaint Creator'): ?>badge-primary<?php elseif ($reply['user_status'] == 'Reported Player'): ?>badge-warning<?php endif; ?>"><?php echo $reply['user_status']; ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="dv-reply-date">
                                        <span><i class="far fa-clock"></i> <?php echo $reply['created_at']; ?></span>
                                        <?php if ($data['privileges']['canDeleteFCReplies'] && $complaint['category_id'] == 9): ?>
                                            <div class="dv-reply-actions float-right">
                                                <form action="" method="post">
                                                    <input type="hidden" name="csrfToken"
                                                           value="<?php echo $_SESSION['csrfToken']; ?>"/>
                                                    <input type="hidden" name="reply_id"
                                                           value="<?php echo $reply['id']; ?>">
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
                <?php if ($complaint['closed_by'] != 0): ?>
                    <div class="dv-closed-topic">
                        <span><i class="fas fa-lock"></i> This topic has been closed by <a
                                    href="<?php echo BASE_URL . '/users/profile/' . $complaint['closed_by_name']; ?>"><?php echo $complaint['closed_by_name']; ?></a>.</span>
                    </div>
                <?php endif; ?>
            </div>
            <?php if ($complaint['status'] != 'Closed'): ?>
                <?php if ((isLoggedIn() && $_SESSION['user_id'] == $complaint['author_id']) || (isLoggedIn() && $_SESSION['user_id'] == $complaint['against_id']) || ($data['privileges']['isAdmin'] > 0)): ?>
                    <form action="" method="post" class="dv-form">
                        <input type="hidden" name="csrfToken" value="<?php echo $_SESSION['csrfToken']; ?>"/>
                        <h4 class="dv-row-title">Leave a reply</h4>
                        <div class="form-group">
                            <textarea type="text" name="complaint_reply" id="complaint_reply" rows="5"
                                      class="form-control<?php if (!empty($errors['reply_error'])): ?> is-invalid<?php endif; ?>"
                                      placeholder="Only complaint creator, reported player and admins can post replies"></textarea>
                            <?php if (!empty($errors['reply_error'])): ?>
                                <div class="invalid-feedback"><?php echo $errors['reply_error']; ?></div>
                            <?php endif; ?>
                        </div>
                        <button type="submit" name="post_reply" class="dv-btn btn btn-primary"><i
                                    class="fas fa-paper-plane"></i> Submit
                        </button>
                    </form>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
