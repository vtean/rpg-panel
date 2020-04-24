<?php getHeader($data); ?>
<?php flashMessage(); ?>
    <div class="dv-row">
        <h3 class="dv-page-title">Admin Panel</h3>
        <div class="row">
            <div class="col-lg-8 col-sm-12 col-12">
                <div class="dv-page-block">
                    <h5 class="dv-block-title"><i class="fas fa-chart-pie"></i> Topics Overview</h5>
                    <div class="dv-statistics">
                        <div class="row">
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="dv-statistic">
                                    <i class="fas fa-ticket-alt"></i>
                                    <div class="dv-block">
                                        <span class="dv-first"><a href="<?php echo BASE_URL . '/tickets'; ?>">New Tickets</a></span>
                                        <span class="dv-second"><?php echo $data['openTickets']; ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="dv-statistic">
                                    <i class="fas fa-user-times"></i>
                                    <div class="dv-block">
                                        <span class="dv-first"><a href="<?php echo BASE_URL . '/complaints'; ?>">Open Complaints</a></span>
                                        <span class="dv-second"><?php echo $data['openComplaints']; ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="dv-statistic">
                                    <i class="fas fa-ban"></i>
                                    <div class="dv-block">
                                        <span class="dv-first"><a href="<?php echo BASE_URL . '/unbans'; ?>">Unban Requests</a></span>
                                        <span class="dv-second"><?php echo $data['openUnbans']; ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="dv-statistic">
                                    <i class="fas fa-question"></i>
                                    <div class="dv-block">
                                        <span class="dv-first"><a href="<?php echo BASE_URL . '/apps'; ?>">Helper Applications</a></span>
                                        <span class="dv-second"><?php echo $data['openHelperApps']; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dv-page-block">
                    <h5 class="dv-block-title"><i class="fas fa-user-friends"></i> Factions</h5>
                    <div class="dvTable">
                        <table id="dvStaffFactionsTable">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Leader</th>
                                <th>Members</th>
                                <th>Leader Apps</th>
                                <?php if ($data['isAdmin'] > 4): ?>
                                    <th>Actions</th>
                                <?php endif; ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($data['factions'])): ?>
                                <?php foreach ($data['factions'] as $faction): ?>
                                    <tr>
                                        <td><?php echo $faction['ID']; ?></td>
                                        <td>
                                            <a href="<?php echo BASE_URL . '/factions/view/' . $faction['ID']; ?>"><?php echo $faction['Name']; ?></a>
                                        </td>
                                        <td>
                                            <?php if ($faction['Leader'] == 'None'): ?>
                                                <?php echo $faction['Leader']; ?>
                                            <?php else: ?>
                                                <a href="<?php echo BASE_URL . '/users/profile/' . $faction['Leader']; ?>"><?php echo $faction['Leader']; ?></a>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo $faction['Members'] . '/' . $faction['Max_Members']; ?></td>
                                        <td><?php echo $faction['leaderApps']; ?></td>
                                        <?php if ($data['isAdmin'] > 4): ?>
                                            <td>
                                                <form method="post">
                                                    <input type="hidden" name="csrfToken"
                                                           value="<?php echo $_SESSION['csrfToken']; ?>">
                                                    <input type="hidden" name="faction_id" value="<?php echo $faction['ID']; ?>">
                                                    <?php if ($faction['Apps_Status'] == 0): ?>
                                                        <button class="btn btn-link" name="open_applications"
                                                                data-toggle="tooltip" data-placement="left"
                                                                title="Open Applications"><i class="fas fa-lock-open"></i>
                                                        </button>
                                                    <?php else: ?>
                                                        <button class="btn btn-link" name="close_applications"
                                                                data-toggle="tooltip" data-placement="left"
                                                                title="Close Applications"><i class="fas fa-lock"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                </form>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12 col-12">
                <div class="dv-widget">
                    <h5 class="dv-widget-title"><i class="fas fa-tools"></i> Admin Tools</h5>
                    <div class="dv-widget-content">
                        <button class="dv-btn btn btn-danger btn-block"><i class="fas fa-ban"></i> Ban Player</button>
                        <button class="dv-btn btn btn-warning btn-block"><i class="fas fa-exclamation-triangle"></i>
                            Warn Player
                        </button>
                        <button class="dv-btn btn btn-info btn-block"><i class="fas fa-align-justify"></i> Jail Player
                        </button>
                        <button class="dv-btn btn btn-secondary btn-block"><i class="fas fa-microphone-slash"></i> Mute
                            Player
                        </button>
                        <button class="dv-btn btn btn-danger btn-block"><i class="fas fa-user-lock"></i> Suspend Player
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php getFooter(); ?>