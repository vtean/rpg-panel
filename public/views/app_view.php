<?php $userApp = $data['userApp']; ?>
<div class="dv-row">
    <h3 class="dv-page-title"><?php echo ucfirst($userApp['type']); ?> application</h3>
    <?php if ($userApp['extra'] != 'staff'): ?>
        <h5><?php echo $userApp['applied_to']; ?></h5>
    <?php endif; ?>
    <?php if ($data['privileges']['canEditLApps'] && $userApp['type'] == 'leader' || $data['privileges']['canEditHApps'] && $userApp['type'] == 'helper' || $data['privileges']['canDeleteLApps'] && $userApp['type'] == 'leader' || $data['privileges']['canDeleteHApps'] && $userApp['type'] == 'helper' || $_SESSION['user_id'] == $userApp['author_id']): ?>
        <div class="dv-row dv-secret-actions">
            <form action="" method="post">
                <input type="hidden" name="csrfToken" value="<?php echo $_SESSION['csrfToken']; ?>"/>
                <?php if ($data['privileges']['canEditLApps'] && $userApp['type'] == 'leader' || $data['privileges']['canEditHApps'] && $userApp['type'] == 'helper' || $_SESSION['user_id'] == $userApp['author_id']): ?>
                    <a href="<?php echo BASE_URL . '/apps/edit/' . $userApp['id']; ?>" class="dv-btn btn btn-info mr-3"><i
                                class="fas fa-pencil-alt"></i> Edit Application</a>
                <?php endif; ?>
                <?php if ($data['privileges']['canDeleteLApps'] && $userApp['type'] == 'leader' || $data['privileges']['canDeleteHApps'] && $userApp['type'] == 'helper' || $_SESSION['user_id'] == $userApp['author_id']): ?>
                    <button name="delete_application" class="dv-btn btn btn-danger"><i class="fas fa-trash"></i> Delete
                        Application
                    </button>
                <?php endif; ?>
            </form>
        </div>
    <?php endif; ?>
    <div class="dv-topic-message dv-mb-30">
        <h4 class="dv-row-title">User account information</h4>
        <div>
            <ul class="list-style-none">
                <li class="dv-single">
                    <span class="dv-first">Username:</span>
                    <span class="dv-second"><a
                                href="<?php echo BASE_URL . '/users/profile/' . $userApp['account_details']['NickName']; ?>"><?php echo $userApp['account_details']['NickName']; ?></a></span>
                </li>
                <li class="dv-single">
                    <span class="dv-first">Level:</span>
                    <span class="dv-second"><?php echo $userApp['account_details']['Level']; ?></span>
                </li>
                <li class="dv-single">
                    <span class="dv-first">Played Time:</span>
                    <span class="dv-second"><?php echo convertMinutes($userApp['account_details']['PlayedTime']); ?></span>
                </li>
                <li class="dv-single">
                    <span class="dv-first">Faction:</span>
                    <span class="dv-second"><?php if ($userApp['account_details']['Member'] != 0): ?><?php echo $userApp['account_details']['faction_name']; ?>, rank <?php echo $userApp['account_details']['Rank']; ?><?php else: ?>None<?php endif; ?></span>
                </li>
                <li class="dv-single">
                    <span class="dv-first">Warns</span>
                    <span class="dv-second"><?php echo $userApp['account_details']['Warns'] . '/3'; ?></span>
                </li>
                <li class="dv-single">
                    <span class="dv-first">Blacklist:</span>
                    <span class="dv-second"><?php echo $userApp['account_details']['BlackList']; ?></span>
                </li>
                <li class="dv-single">
                    <span class="dv-first">Law Compliance:</span>
                    <span class="dv-second"><?php echo $userApp['account_details']['ZKP']; ?></span>
                </li>
            </ul>
        </div>
    </div>
    <div class="dv-topic-message dv-mb-30">
        <h4 class="dv-row-title">Application description</h4>
        <div><?php echo $userApp['body']; ?></div>
    </div>
    <div class="dv-topic-message dv-mb-30">
        <h4 class="dv-row-title">Last punish</h4>
        <div class="dv-user-fh">
            <div class="dv-user-fh-item">
                <div class="dv-user-fh-avatar">
                    <img src="<?php echo BASE_URL . '/public/resources/img/skins/id-' . $userApp['account_details']['Skin'] . '.png'; ?>"
                         alt="<?php echo $userApp['account_details']['NickName'] . "'s Avatar"; ?>">
                </div>
                <div class="dv-user-fh-text">
                    <p>Lust was banned by Indigo for 24 hours. Reason: Noob</p>
                    <span><i class="far fa-clock"></i> 05/04/2020 15:54</span>
                </div>
            </div>
        </div>
    </div>
    <div class="dv-topic-message dv-mb-30">
        <h4 class="dv-row-title">Faction history</h4>
        <div class="dv-user-fh">
            <?php if (!empty($data['userFH'])): ?>
                <?php foreach ($data['userFH'] as $fh): ?>
                    <div class="dv-user-fh-item">
                        <div class="dv-user-fh-avatar">
                            <img src="<?php echo BASE_URL . '/public/resources/img/skins/id-' . $userApp['account_details']['Skin'] . '.png'; ?>"
                                 alt="<?php echo $userApp['account_details']['NickName'] . "'s Skin"; ?>">
                        </div>
                        <div class="dv-user-fh-text">
                            <p><?php echo $fh['action']; ?></p>
                            <span><i class="far fa-clock"></i> <?php echo $fh['date']; ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <span>There are currently no actions.</span>
            <?php endif; ?>
        </div>
    </div>
</div>