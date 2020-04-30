<div class="dv-row">
    <h3 class="dv-page-title">Welcome, dear Owner</h3>
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
                                        <span class="dv-first"><a
                                                    href="<?php echo BASE_URL . '/tickets'; ?>">Tickets</a></span>
                                    <p class="dv-second">
                                            <span class="text-warning" data-tooltip="tooltip" data-placement="top"
                                                  title="Total Tickets"><?php echo $data['allTickets']; ?></span>
                                        <span> / </span>
                                        <span class="text-success" data-tooltip="tooltip" data-placement="top"
                                              title="Open Tickets"><?php echo $data['openTickets']; ?></span>
                                        <span> / </span>
                                        <span data-tooltip="tooltip" data-placement="top"
                                              title="Closed Tickets"><?php echo $data['closedTickets']; ?></span>
                                        <span> / </span>
                                        <span class="text-danger" data-tooltip="tooltip" data-placement="top"
                                              title="Need Owner Involvement"><?php echo $data['ownerTickets']; ?></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="dv-statistic">
                                <i class="fas fa-user-times"></i>
                                <div class="dv-block">
                                    <span class="dv-first"><a
                                                href="<?php echo BASE_URL . '/complaints'; ?>">Complaints</a></span>
                                    <p class="dv-second">
                                            <span class="text-warning" data-tooltip="tooltip" data-placement="top"
                                                  title="Total Complaints"><?php echo $data['allComplaints']; ?></span>
                                        <span> / </span>
                                        <span class="text-success" data-tooltip="tooltip" data-placement="top"
                                              title="Open Complaints"><?php echo $data['openComplaints']; ?></span>
                                        <span> / </span>
                                        <span data-tooltip="tooltip" data-placement="top"
                                              title="Closed Complaints"><?php echo $data['closedComplaints']; ?></span>
                                        <span> / </span>
                                        <span class="text-danger" data-tooltip="tooltip" data-placement="top"
                                              title="Need Owner Involvement"><?php echo $data['ownerComplaints']; ?></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="dv-statistic">
                                <i class="fas fa-ban"></i>
                                <div class="dv-block">
                                    <span class="dv-first"><a
                                                href="<?php echo BASE_URL . '/unbans'; ?>">Unban Requests</a></span>
                                    <p class="dv-second">
                                            <span class="text-warning" data-tooltip="tooltip" data-placement="top"
                                                  title="Total Unban Requests"><?php echo $data['allUnbans']; ?></span>
                                        <span> / </span>
                                        <span class="text-success" data-tooltip="tooltip" data-placement="top"
                                              title="Open Unban Requests"><?php echo $data['openUnbans']; ?></span>
                                        <span> / </span>
                                        <span data-tooltip="tooltip" data-placement="top"
                                              title="Closed Unban Requests"><?php echo $data['closedUnbans']; ?></span>
                                        <span> / </span>
                                        <span class="text-danger" data-tooltip="tooltip" data-placement="top"
                                              title="Need Owner Involvement"><?php echo $data['ownerUnbans']; ?></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="dv-statistic">
                                <i class="fas fa-question"></i>
                                <div class="dv-block">
                                    <span class="dv-first"><a href="<?php echo BASE_URL . '/applications'; ?>">Helper Applications</a></span>
                                    <span class="dv-second"><?php echo $data['helperApps']; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h3 class="dv-page-title">Panel Settings</h3>
            <div class="dv-page-block">
                <h5 class="dv-block-title"><i class="far fa-pause-circle"></i> Maintenance</h5>
                <form action="" method="post" class="dv-form">
                    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION['csrfToken']; ?>">
                    <div class="form-group">
                        <label for="panelMaintenance" class="inline-label">Maintenance Status</label>
                        <label class="dv-switch">
                            <input type="checkbox" name="maintenance_status" id="panelMaintenance"
                                   value="<?php echo $data['maintenanceStatus']; ?>"<?php if ($data['maintenanceStatus'] == 1): ?> checked="checked"<?php endif; ?>>
                            <span class="dv-switch-slider dv-round"></span>
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="maintenanceMessage">Maintenance Message</label>
                        <textarea name="maintenance_message" id="maintenanceMessage" rows="5"
                                  class="form-control<?php if (!empty($errors['message_error'])): ?> is-invalid<?php endif; ?>"><?php echo $data['maintenanceMessage']; ?></textarea>
                        <?php if (!empty($errors['message_error'])): ?>
                            <div class="invalid-feedback"><?php echo $errors['message_error']; ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="clearfix">
                        <button type="submit" class="dv-btn btn btn-primary float-right"
                                name="panel_maintenance"><i class="fas fa-check"></i> Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-4 col-sm-12 col-12">
            <div class="dv-widget">
                <h5 class="dv-widget-title"><i class="fas fa-tools"></i> Quick Teleport</h5>
                <div class="dv-widget-content">
                    <div class="row">
                        <div class="col">
                            <a href="<?php echo BASE_URL . '/groups'; ?>" class="dv-btn btn btn-primary btn-block"
                               data-tooltip="tooltip" data-placement="top" title="Manage Groups">
                                <i class="fas fa-users"></i></a>
                        </div>
                        <div class="col">
                            <a href="<?php echo BASE_URL . '/logs/panel'; ?>" class="dv-btn btn btn-info btn-block"
                               data-tooltip="tooltip" data-placement="top" title="Panel Logs">
                                <i class="fas fa-history"></i></a>
                        </div>
                        <div class="col">
                            <a href="<?php echo BASE_URL . '/logs/server'; ?>" class="dv-btn btn btn-success btn-block"
                               data-tooltip="tooltip" data-placement="top" title="Server Logs">
                                <i class="fas fa-history"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dv-widget dv-manage-sv">
                <h5 class="dv-widget-title"><i class="fas fa-cogs"></i> Manage Server</h5>
                <div class="dv-widget-content">
                    <div class="row">
                        <div class="col">
                            <button class="dv-btn btn btn-info btn-block"><i class="fas fa-redo-alt"></i> Restart Server</button>
                        </div>
                        <div class="col">
                            <button class="dv-btn btn btn-success btn-block"><i class="fas fa-font"></i> Change Hostname</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>