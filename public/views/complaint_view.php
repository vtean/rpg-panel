<?php
$complaint = $data['complaint'];
$author = $complaint['author'];
$against_user = $complaint['against_user'];
$replies = $complaint['replies'];
?>
<?php getHeader($data); ?>
<?php flashMessage(); ?>
<h3 class="dv-page-title">Complaint #<?php echo $complaint['id']; ?></h3>
<div class="dv-row">
    <div class="row">
        <div class="col-lg-4 col-sm-2 col-12">
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
                            <span class="dv-second"><?php echo $author['Member']; ?></span>
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
                            <span class="dv-second"><?php echo $against_user['Member']; ?></span>
                        </li>
                        <li class="dv-single">
                            <span class="dv-first">Warns:</span>
                            <span class="dv-second"><?php echo $against_user['Warns']; ?>/3</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-sm-12 col-12">
            <div class="dv-topic-message">
                <h4 class="dv-row-title">Complaint details</h4>
                <ul class="list-style-none">
                    <li class="dv-single">
                        <span class="dv-first">Category:</span>
                        <span class="dv-second"><?php echo $complaint['category_name']; ?></span>
                    </li>
                    <li class="dv-single">
                        <span class="dv-first">Created on:</span>
                        <span class="dv-second"><?php echo $complaint['created_at']; ?></span>
                    </li>
                    <li class="dv-single">
                        <span class="dv-first">Description:</span>
                        <span class="dv-second"><?php echo $complaint['description']; ?></span>
                    </li>
                    <li class="dv-single">
                        <span class="dv-first">Proof:</span>
                        <span class="dv-second"><?php echo $complaint['proof']; ?></span>
                    </li>
                    <?php if (!empty($complaint['other_info'])): ?>
                        <li class="dv-single">
                            <span class="dv-first">Other information:</span>
                            <span class="dv-second"><?php echo $complaint['other_info']; ?></span>
                        </li>
                    <?php endif; ?>
                </ul>
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
                                        <?php if ($data['isAdmin']): ?>
                                            <span class="badge badge-danger"><i
                                                        class="fas fa-shield-alt"></i> Admin</span>
                                        <?php endif; ?>
                                        <span class="badge <?php if ($reply['user_status'] == 'Complaint Creator'): ?>badge-primary<?php elseif ($reply['user_status'] == 'Reported Player'): ?>badge-warning<?php endif; ?>"><?php echo $reply['user_status']; ?></span>
                                    </div>
                                    <div class="dv-reply-date">
                                        <span><i class="far fa-clock"></i> <?php echo $reply['created_at']; ?></span>
                                    </div>
                                </div>
                                <div class="dv-reply-body">
                                    <span><?php echo html_entity_decode($reply['body']); ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <?php if ($complaint['status'] != 'Closed'): ?>
                <?php if (($_SESSION['user_id'] == $complaint['author_id']) || ($_SESSION['user_id'] == $complaint['against_id']) || ($data['isAdmin'] > 0) || ($data['isLeader'] > 0)): ?>
                    <form action="" method="post" class="dv-form">
                        <input type="hidden" name="csrfToken" value="<?php echo $_SESSION['csrfToken']; ?>"/>
                        <h4 class="dv-row-title">Leave a reply</h4>
                        <div class="form-group">
                            <textarea type="text" name="complaint_reply" id="complaint_reply" rows="5"
                                      class="form-control<?php if (!empty($errors['reply_error'])): ?> is-invalid<?php endif; ?>" placeholder="Only complaint creator, reporter player, admins and leaders can post replies"></textarea>
                            <?php if (!empty($errors['reply_error'])): ?>
                                <div class="invalid-feedback"><?php echo $errors['reply_error']; ?></div>
                            <?php endif; ?>
                        </div>
                        <button type="submit" name="post_reply" class="dv-btn btn btn-primary">Submit</button>
                    </form>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php getFooter(); ?>
