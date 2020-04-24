<?php getHeader($data); ?>
<?php flashMessage(); ?>
    <div class="dv-row">
        <h3 class="dv-page-title">Leader Panel</h3>
        <div class="row">
            <div class="col-lg-8 col-sm-12 col-12">
                <div class="dv-page-block">
                    <h5 class="dv-block-title"><i class="fas fa-chart-pie"></i> Faction Statistics</h5>
                    <div class="dv-statistics">
                        <div class="row">
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="dv-statistic">
                                    <i class="fas fa-users"></i>
                                    <div class="dv-block">
                                        <span class="dv-first"><a href="<?php echo BASE_URL . '/factions/view/' . $data['isLeader']; ?>">Members</a></span>
                                        <span class="dv-second"><?php echo $data['faction']['Members'] . '/' . $data['faction']['Max_Members']; ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="dv-statistic">
                                    <i class="fas fa-graduation-cap"></i>
                                    <div class="dv-block">
                                        <span class="dv-first"><a href="<?php echo BASE_URL . '/factions/applications/' . $data['isLeader']; ?>">Applications</a></span>
                                        <span class="dv-second"><?php echo $data['openApplications']; ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="dv-statistic">
                                    <i class="fas fa-user-times"></i>
                                    <div class="dv-block">
                                        <span class="dv-first"><a href="<?php echo BASE_URL . '/factions/complaints/' . $data['isLeader']; ?>">Complaints</a></span>
                                        <span class="dv-second"><?php echo $data['openComplaints']; ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="dv-statistic">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <div class="dv-block">
                                        <span class="dv-first"><a href="<?php echo BASE_URL . '/factions/resignations/' . $data['isLeader']; ?>">Resignations</a></span>
                                        <span class="dv-second"><?php echo $data['openResignations']; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12 col-12">
                <div class="dv-widget">
                    <h5 class="dv-widget-title"><i class="fas fa-tools"></i> Leader Tools</h5>
                    <div class="dv-widget-content">
                        <form method="post" class="mb-2">
                            <input type="hidden" name="csrfToken" value="<?php echo $_SESSION['csrfToken']; ?>"/>
                            <?php if ($data['faction']['Apps_Status'] == 0): ?>
                                <button type="submit" name="open_applications" class="dv-btn btn btn-success btn-block"><i class="fas fa-unlock"></i> Open Applications</button>
                            <?php else: ?>
                                <button type="submit" name="close_applications" class="dv-btn btn btn-danger btn-block"><i class="fas fa-lock"></i> Close Applications</button>
                            <?php endif; ?>
                        </form>
                        <a href="<?php echo BASE_URL . '/factions/applications/' . $data['isLeader'] . '/questions'; ?>" class="dv-btn btn btn-info btn-block"><i class="fas fa-question"></i> Application Questions</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php getFooter(); ?>