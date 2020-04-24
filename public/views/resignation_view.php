<?php
$resignation = $data['resignation'];
$author = $data['resignation']['author'];
$replies = $data['replies'];
?>
<div class="dv-row">
    <h3 class="dv-page-title">View Resignation #<?php echo $resignation['id']; ?></h3>
    <div class="row">
        <div class="col-lg-4 col-sm-12 col-12">
            <div class="dv-topic-info">
                <div class="dv-topic-widget">
                    <h4 class="dv-row-title">Member Information</h4>
                    <ul class="dv-details list-style-none">
                        <li class="dv-single">
                            <span class="dv-first">Username:</span>
                            <span class="dv-second"><a
                                        href="<?php echo BASE_URL . '/users/profile/' . $author['NickName']; ?>"><?php echo $author['NickName']; ?></a></span>
                        </li>
                        <li class="dv-single">
                            <span class="dv-first">Faction Rank:</span>
                            <span class="dv-second"><?php echo $author['Rank']; ?></span>
                        </li>
                        <li class="dv-single">
                            <span class="dv-first">Faction Warns:</span>
                            <span class="dv-second"><?php echo $author['FWarns']; ?>/3</span>
                        </li>
                        <li class="dv-single">
                            <span class="dv-first">Faction Days:</span>
                            <span class="dv-second">69</span>
                        </li>
                        <?php if ($data['userBanned'] != false): ?>
                            <li class="dv-single">
                                <span class="text-danger"><strong>This user has been banned for <?php echo $data['userBanned']['BanSeconds'] / 86400; ?> days. Reason: <?php echo $data['userBanned']['BanReason']; ?></strong></span>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <?php if ($_SESSION['user_id'] == $resignation['author_id'] || $data['privileges']['isLeader'] == $resignation['faction_id'] || $data['privileges']['fullAccess']): ?>
                    <div class="dv-topic-widget dv-actions">
                        <h4 class="dv-row-title">Resignation Actions</h4>
                        <div class="dv-action-buttons">
                            <div class="row">
                                <?php if (strcasecmp($resignation['status'], 'Open') == 0 && ($data['privileges']['isLeader'] == $resignation['faction_id'] || $data['privileges']['fullAccess'])): ?>
                                    <div class="col">
                                        <form action="" method="post">
                                            <input type="hidden" name="csrfToken"
                                                   value="<?php echo $_SESSION['csrfToken']; ?>">
                                            <button name="close_resignation" class="dv-btn btn btn-warning"><i
                                                        class="fas fa-lock"></i> Close
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
                <h4 class="dv-row-title">Resignation Details</h4>
                <div><?php echo $resignation['body']; ?></div>
            </div>
            <div class="dv-topic-replies">
                <h4 class="dv-row-title">Resignation Replies</h4>
                <?php if (empty($replies)): ?>
                    <span>There are currently no replies.</span>
                <?php else: ?>
                    <?php foreach ($replies as $reply): ?>
                        <div class="dv-reply">
                            <div class="dv-reply-avatar">
                                <img src="<?php echo BASE_URL . '/public/resources/img/skins/id-' . $reply['author']['Skin'] . '.png'; ?>"
                                     alt="<?php echo $reply['author']['NickName'] . "'s avatar"; ?>">
                            </div>
                            <div class="dv-reply-content">
                                <div class="dv-reply-head clearfix">
                                    <div class="dv-reply-author">
                                        <a href="<?php echo BASE_URL . '/users/profile' . $reply['author']['NickName']; ?>"
                                           class="author-name"><?php echo $reply['author']['NickName']; ?></a>
                                        <?php if ($reply['author']['Admin'] > 0): ?>
                                            <span class="badge badge-danger"><i
                                                        class="fas fa-shield-alt"></i> Admin</span>
                                        <?php endif; ?>
                                        <?php if ($reply['author']['Leader'] > 0): ?>
                                            <span class="badge badge-info"><i class="fas fa-user-tie"></i> Faction Leader</span>
                                        <?php endif; ?>
                                        <?php if (isset($reply['user_status']) && strcasecmp($reply['user_status'], 'Resignation Creator') == 0): ?>
                                            <span class="badge badge-primary"><?php echo $reply['user_status']; ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="dv-reply-date">
                                    <span><i class="far fa-clock"></i> <?php echo $reply['created_at']; ?></span>
                                    <?php if ($data['privileges']['fullAccess']): ?>
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
                                <div class="dv-reply-body">
                                    <span><?php echo $reply['body']; ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php if ($resignation['closed_by'] != 0): ?>
                    <div class="dv-closed-topic">
                        <span><i class="fas fa-lock"></i> This resignation has been closed by <a
                                    href="<?php echo BASE_URL . '/users/profile/' . $resignation['closed_by_name']; ?>"><?php echo $resignation['closed_by_name']; ?></a>.</span>
                    </div>
                <?php endif; ?>
            </div>
            <?php if ($resignation['status'] != 'Closed'): ?>
                <?php if ((isLoggedIn() && $_SESSION['user_id'] == $resignation['author_id']) || ($data['privileges']['isLeader'] == $resignation['faction_id']) || $data['privileges']['fullAccess']): ?>
                    <form action="" method="post" class="dv-form">
                        <input type="hidden" name="csrfToken" value="<?php echo $_SESSION['csrfToken']; ?>"/>
                        <h4 class="dv-row-title">Leave a reply</h4>
                        <div class="form-group">
                            <textarea type="text" name="resignation_reply" rows="5"
                                      class="form-control<?php if (!empty($errors['reply_error'])): ?> is-invalid<?php endif; ?>"
                                      placeholder="Only resignation creator and leader can post replies"></textarea>
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