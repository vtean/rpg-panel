<?php
    $ticket = $data['ticket'];
    $author = $data['author'];
?>
<?php getHeader($data); ?>
    <?php flashMessage(); ?>
    <h3 class="dv-page-title">Ticket #<?= $ticket['id'] ?></h3>
    <div class="dv-row">
        <div class="row">
            <div class="col-lg-4 col-sm-12 col-12">
                <div class="dv-topic-info">
                    <div class="dv-topic-widget">
                        <h4 class="dv-row-title">Ticket details</h4>
                        <ul class="dv-details list-style-none">
                            <li class="dv-single">
                                <span class="dv-first">Category:</span>
                                <span class="dv-second"><?php echo $ticket['category_name']; ?></span>
                            </li>
                            <li class="dv-single">
                                <span class="dv-first">Created on:</span>
                                <span class="dv-second"><?php echo $ticket['created_at']; ?></span>
                            </li>
                            <?php if ($ticket['is_edited']): ?>
                                <li class="dv-single">
                                    <span class="dv-first">Edited on:</span>
                                    <span class="dv-second"><?php echo $ticket['edited_at']; ?></span>
                                </li>
                            <?php endif; ?>
                            <li class="dv-single">
                                <span class="dv-first">Status:</span>
                                <span class="dv-second"><?php echo $ticket['status']; ?></span>
                            </li>
                        </ul>
                    </div>
                    <div class="dv-topic-widget">
                        <h4 class="dv-row-title">Author details</h4>
                        <ul class="dv-details list-style-none">
                            <li class="dv-single">
                                <span class="dv-first">Author name:</span>
                                <span class="dv-second"><a href="<?php echo BASE_URL . '/users/profile/' . $author['NickName']; ?>"><?php echo $author['NickName']; ?></a></span>
                            </li>
                            <li class="dv-single">
                                <span class="dv-first">Level:</span>
                                <span class="dv-second"><?php echo $author['Level']; ?></span>
                            </li>
                            <li class="dv-single">
                                <span class="dv-first">Played time:</span>
                                <span class="dv-second"><?php echo convertMinutes($author['PlayedTime']); ?></span>
                            </li>
                        </ul>
                    </div>
                    <div class="dv-topic-widget dv-actions">
                        <h4 class="dv-row-title">Ticket actions</h4>
                        <div class="dv-action-buttons">
                            <div class="row">
                                <?php if ((isLoggedIn() && ($_SESSION['user_id'] == $author['ID']) && ($ticket['status'] == 'Open')) || ((in_array(1, $data['canEditTickets']) && ($ticket['status'] == 'Open')))): ?>
                                    <div class="col">
                                        <button class="dv-btn btn btn-warning"><i class="fas fa-lock"></i> Close ticket</button>
                                    </div>
                                <?php elseif (in_array(1, $data['canEditTickets']) && ($ticket['status'] == 'Closed')): ?>
                                    <div class="col">
                                        <button class="dv-btn btn btn-success"><i class="fas fa-unlock"></i> Open ticket</button>
                                    </div>
                                <?php endif; ?>
                                <?php if (in_array(1, $data['canEditTickets'])): ?>
                                    <div class="col">
                                        <button class="dv-btn btn btn-primary"><i class="fas fa-tag"></i> Change category</button>
                                    </div>
                                    <div class="w-100"></div>
                                    <div class="col">
                                        <button class="dv-btn btn btn-info"><i class="fas fa-pencil-alt"></i> Edit ticket</button>
                                    </div>
                                <?php endif; ?>
                                <?php if (in_array(1, $data['canDeleteTickets'])): ?>
                                    <div class="col">
                                        <button class="dv-btn btn btn-danger"><i class="fas fa-trash"></i> Delete ticket</button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-sm-12 col-12">
                <div class="dv-topic-message">
                    <h4 class="dv-row-title">User message</h4>
                    <p><?php echo html_entity_decode($ticket['body']); ?></p>
                </div>
                <div class="dv-topic-replies">
                    <h4 class="dv-row-title">Ticket replies</h4>
                    <?php if (empty($data['replies'])): ?>
                        <span>There are currently no replies.</span>
                    <?php else: ?>
                        <?php foreach ($data['replies'] as $reply): ?>
                            <div class="dv-reply">
                                <div class="dv-reply-avatar">
                                    <img src="<?php echo BASE_URL . '/public/resources/img/skins/id-' . $reply['author_avatar'] . '.png'; ?>" alt="<?php echo $reply['author_name'] . "'s avatar"; ?>">
                                </div>
                                <div class="dv-reply-content">
                                    <div class="dv-reply-head clearfix">
                                        <div class="dv-reply-author">
                                            <a class="author-name" href="<?php echo BASE_URL . '/users/profile/' . $reply['author_name']; ?>"><?php echo $reply['author_name']; ?></a>
                                            <span class="badge <?php if ($reply['user_status'] == 'Author'): ?>badge-secondary<?php else: ?>badge-danger<?php endif;?>"><?php echo $reply['user_status']; ?></span>
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
                <?php if ($ticket['status'] != 'Closed'): ?>
                    <form action="" method="post" class="dv-form">
                        <input type="hidden" name="csrfToken" value="<?php echo $_SESSION['csrfToken']; ?>"/>
                        <!-- Ticket Details -->
                        <h4 class="dv-row-title">Leave a reply</h4>
                        <div class="form-group">
                        <textarea type="text" rows="5" name="ticket_reply"
                                  class="d-block form-control<?php if (!empty($errors['ticket_reply_error'])): ?> is-invalid<?php endif; ?>"
                                  id="ticket_reply"></textarea>
                            <?php if (!empty($errors['ticket_reply_error'])): ?>
                                <div class="invalid-feedback"><?php echo $errors['ticket_reply_error']; ?></div>
                            <?php endif; ?>
                        </div>
                        <button type="submit" name="reply_ticket" class="dv-btn btn btn-primary m-auto">Submit</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php getFooter();