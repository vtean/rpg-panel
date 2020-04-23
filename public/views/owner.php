<?php getHeader($data); ?>
<?php flashMessage(); ?>
    <h4 class="dv-page-title">Welcome, dear Owner</h4>
    <div class="dv-row">
        <div class="row">
            <div class="col-lg-8 col-sm-12 col-12">
                <div class="dv-page-block">
                    <h5 class="dv-block-title"><i class="fas fa-chart-pie"></i> Topics Overview</h5>
                    <div class="dv-block-content dv-topics-block">
                        <div class="row">
                            <div class="col-lg-4 col-sm-6 col-12">
                                <ul class="list-style-none">
                                    <li>
                                        <span class="dv-first">Total Tickets:</span>
                                        <span class="dv-second"><?php echo $data['allTickets']; ?></span>
                                    </li>
                                    <li>
                                        <span class="dv-first">Open Tickets:</span>
                                        <span class="dv-second"><?php echo $data['openTickets']; ?></span>
                                    </li>
                                    <li>
                                        <span class="dv-first">Closed Tickets:</span>
                                        <span class="dv-second"><?php echo $data['closedTickets']; ?></span>
                                    </li>
                                    <li>
                                        <span class="dv-first">Need an Owner:</span>
                                        <span class="dv-second"><?php echo $data['ownerTickets']; ?></span>
                                    </li>
                                </ul>
                                <span class="dv-remark">* Go to <a
                                            href="<?php echo BASE_URL . '/tickets'; ?>">Tickets</a> page.</span>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <ul class="list-style-none">
                                    <li>
                                        <span class="dv-first">Total Complaints:</span>
                                        <span class="dv-second"><?php echo $data['allComplaints']; ?></span>
                                    </li>
                                    <li>
                                        <span class="dv-first">Open Complaints:</span>
                                        <span class="dv-second"><?php echo $data['openComplaints']; ?></span>
                                    </li>
                                    <li>
                                        <span class="dv-first">Closed Complaints:</span>
                                        <span class="dv-second"><?php echo $data['closedComplaints']; ?></span>
                                    </li>
                                    <li>
                                        <span class="dv-first">Need an Owner:</span>
                                        <span class="dv-second"><?php echo $data['ownerComplaints']; ?></span>
                                    </li>
                                </ul>
                                <span class="dv-remark">* Go to <a href="<?php echo BASE_URL . '/complaints'; ?>">Complaints</a> page.</span>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <ul class="list-style-none">
                                    <li>
                                        <span class="dv-first">Total Unban Requests:</span>
                                        <span class="dv-second"><?php echo $data['allUnbans']; ?></span>
                                    </li>
                                    <li>
                                        <span class="dv-first">Open Unban Requests:</span>
                                        <span class="dv-second"><?php echo $data['openUnbans']; ?></span>
                                    </li>
                                    <li>
                                        <span class="dv-first">Closed Unban Requests:</span>
                                        <span class="dv-second"><?php echo $data['closedUnbans']; ?></span>
                                    </li>
                                    <li>
                                        <span class="dv-first">Need an Owner:</span>
                                        <span class="dv-second"><?php echo $data['ownerUnbans']; ?></span>
                                    </li>
                                </ul>
                                <span class="dv-remark">* Go to <a href="<?php echo BASE_URL . '/unbans'; ?>">Unban Requests</a> page.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dv-page-block">
                    <h5 class="dv-block-title"><i class="fas fa-cog"></i> Panel Settings</h5>
                    <form action="" method="post" class="dv-form">
                        <div class="form-group">
                            <input type="hidden" name="csrfToken" value="<?php echo $_SESSION['csrfToken']; ?>">
                            <label for="panelMaintenance" class="inline-label">Panel Maintenance</label>
                            <label class="dv-switch">
                                <input type="checkbox" name="panel_maintenance" id="panelMaintenance">
                                <span class="dv-switch-slider dv-round"></span>
                            </label>
                        </div>
                        <div class="clearfix">
                            <button type="submit" class="dv-btn btn btn-primary float-right"
                                    name="save_panel_settings"><i class="fas fa-check"></i> Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12 col-12">
                <div class="dv-widget">
                    <h5 class="dv-widget-title"><i class="fas fa-tools"></i> Quick Teleport</h5>
                    <div class="dv-widget-content">
                        <ul class="list-style-none">
                            <li><a href="<?php echo BASE_URL . '/groups'; ?>">Manage Groups</a></li>
                            <li><a href="">Manage Admins</a></li>
                            <li><a href="">Manage Leaders</a></li>
                            <li><a href="">Manage Users</a></li>
                            <li><a href="<?php echo BASE_URL . '/logs'; ?>">Logs</a></li>
                        </ul>
                    </div>
                </div>
                <div class="dv-widget dv-manage-sv">
                    <h5 class="dv-widget-title"><i class="fas fa-cogs"></i> Manage Server</h5>
                    <div class="dv-widget-content">
                        <ul class="list-style-none">
                            <li><a href="">Restart Server</a></li>
                            <li><a href="">Change Hostname</a></li>
                            <li><a href="">Quick Ban</a></li>
                            <li><a href="">Quick Warn</a></li>
                            <li><a href="">Quick Mute</a></li>
                            <li><a href="">Quick Jail</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php getFooter(); ?>