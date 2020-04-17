<?php
$application = $data['application'];
$author = $data['application']['author'];
?>
<?php getHeader($data); ?>
<?php flashMessage(); ?>
    <div class="dv-row">
        <h3 class="dv-page-title">View Application #<?php echo $application['id']; ?></h3>
        <div class="row">
            <div class="col-lg-4 col-sm-12 col-12">
                <div class="dv-topic-info">
                    <div class="dv-topic-widget">
                        <h4 class="dv-row-title">Player Information</h4>
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
                                <span class="dv-second"><?php echo convertMinutes($author['TotalPlayed']); ?></span>
                            </li>
                            <li class="dv-single">
                                <span class="dv-first">Warns:</span>
                                <span class="dv-second"><?php echo $author['Warns'] . '/3'; ?></span>
                            </li>
                        </ul>
                    </div>
                    <?php if (($data['isLeader'] > 0 && $data['isLeader'] == $application['faction_id']) || $data['fullAccess']): ?>
                        <div class="dv-topic-widget dv-actions">
                            <h4 class="dv-row-title">Application Actions</h4>
                            <div class="dv-action-buttons">
                                <div class="row">
                                    <?php if ((strcasecmp($application['status'], 'Open') == 0 && $data['isLeader'] == $application['faction_id']) || $data['fullAccess']): ?>
                                        <div class="col">
                                            <form action="" method="post">
                                                <input type="hidden" name="csrfToken"
                                                       value="<?php echo $_SESSION['csrfToken']; ?>">
                                                <button name="accept_application" class="dv-btn btn btn-success"><i
                                                            class="fas fa-check"></i> Accept
                                                </button>
                                            </form>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (((strcasecmp($application['status'], 'Open') == 0 || strcasecmp($application['status'], 'Accepted for tests') == 0) && $data['isLeader'] == $application['faction_id']) || $data['fullAccess']): ?>
                                        <div class="col">
                                            <form action="" method="post">
                                                <input type="hidden" name="csrfToken"
                                                       value="<?php echo $_SESSION['csrfToken']; ?>">
                                                <button name="reject_application" class="dv-btn btn btn-danger"><i
                                                            class="fas fa-times"></i> Reject
                                                </button>
                                            </form>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($data['fullAccess']): ?>
                                        <div class="w-100"></div>
                                        <div class="col">
                                            <form action="" method="post">
                                                <input type="hidden" name="csrfToken"
                                                       value="<?php echo $_SESSION['csrfToken']; ?>">
                                                <button name="delete_application" class="dv-btn btn btn-danger"><i
                                                            class="fas fa-times"></i> Delete
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
                    <h4 class="dv-row-title">Application Details</h4>
                    <div><?php echo $application['body']; ?></div>
                </div>
            </div>
        </div>
    </div>
<?php getFooter(); ?>