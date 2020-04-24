<?php getHeader($data); ?>
<?php flashMessage(); ?>
    <div class="dv-row">
        <h3 class="dv-page-title">Panel Logs</h3>
        <div class="row">
            <div class="col-lg-2 col-sm-12 col-12">
                <div class="nav flex-column nav-pills" id="dv-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="admin-logs-tab" data-toggle="pill" href="#admin-logs" role="tab"
                       aria-controls="admin-logs" aria-selected="true"><i class="fas fa-user-shield"></i> Admin Logs</a>
                    <a class="nav-link" id="leader-logs-tab" data-toggle="pill" href="#leader-logs" role="tab"
                       aria-controls="leader-logs" aria-selected="false"><i class="fas fa-user-tie"></i> Leader Logs</a>
                    <a class="nav-link" id="player-logs-tab" data-toggle="pill" href="#player-logs" role="tab"
                       aria-controls="player-logs" aria-selected="false"><i class="fas fa-user"></i> Player Logs</a>
                    <a class="nav-link" id="login-logs-tab" data-toggle="pill" href="#login-logs" role="tab"
                       aria-controls="login-logs" aria-selected="false"><i class="fas fa-sign-in-alt"></i> Login
                        Logs</a>
                </div>
            </div>
            <div class="col-lg-10 col-sm-12 col-12">
                <div class="tab-content" id="dv-pills-tabContent">
                    <div class="tab-pane fade show active" id="admin-logs" role="tabpanel"
                         aria-labelledby="admin-logs-tab">
                        <div class="dvTable">
                            <table id="dvPanelAdminLogsTable">
                                <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                    <th>Date</th>
                                    <th>IP</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($data['adminLogs'])): ?>
                                    <?php foreach ($data['adminLogs'] as $log): ?>
                                        <tr>
                                            <td>
                                                <a href="<?php echo BASE_URL . '/users/profile/' . $log['user_name']; ?>"><?php echo $log['user_name']; ?></a>
                                            </td>
                                            <td><?php echo $log['type']; ?></td>
                                            <td><?php echo $log['action']; ?></td>
                                            <td><?php echo $log['date']; ?></td>
                                            <td>
                                                <a href="<?php echo BASE_URL . '/search/ip/' . $log['ip_address']; ?>"
                                                   target="_blank"><?php echo $log['ip_address']; ?></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="leader-logs" role="tabpanel" aria-labelledby="leader-logs-tab">
                        <div class="dvTable">
                            <table id="dvLeaderLogsTable">
                                <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                    <th>Date</th>
                                    <th>IP</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($data['leaderLogs'])): ?>
                                    <?php foreach ($data['leaderLogs'] as $log): ?>
                                        <tr>
                                            <td>
                                                <a href="<?php echo BASE_URL . '/users/profile/' . $log['user_name']; ?>"><?php echo $log['user_name']; ?></a>
                                            </td>
                                            <td><?php echo $log['type']; ?></td>
                                            <td><?php echo $log['action']; ?></td>
                                            <td><?php echo $log['date']; ?></td>
                                            <td>
                                                <a href="<?php echo BASE_URL . '/search/ip/' . $log['ip_address']; ?>"
                                                   target="_blank"><?php echo $log['ip_address']; ?></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="player-logs" role="tabpanel" aria-labelledby="player-logs-tab">
                        <div class="dvTable">
                            <table id="dvPlayerLogsTable">
                                <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                    <th>Date</th>
                                    <th>IP</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($data['playerLogs'])): ?>
                                    <?php foreach ($data['playerLogs'] as $log): ?>
                                        <tr>
                                            <td>
                                                <a href="<?php echo BASE_URL . '/users/profile/' . $log['user_name']; ?>"><?php echo $log['user_name']; ?></a>
                                            </td>
                                            <td><?php echo $log['type']; ?></td>
                                            <td><?php echo $log['action']; ?></td>
                                            <td><?php echo $log['date']; ?></td>
                                            <td>
                                                <a href="<?php echo BASE_URL . '/search/ip/' . $log['ip_address']; ?>"
                                                   target="_blank"><?php echo $log['ip_address']; ?></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="login-logs" role="tabpanel" aria-labelledby="login-logs-tab">
                        <div class="dvTable">
                            <table id="dvLoginLogsTable">
                                <thead>
                                <tr>
                                    <th>User</th>
                                    <th>IP Address</th>
                                    <th>Date</th>
                                    <th>Location</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($data['loginLogs'])): ?>
                                    <?php foreach ($data['loginLogs'] as $log): ?>
                                        <tr>
                                            <td>
                                                <a href="<?php echo BASE_URL . '/users/profile/' . $log['user_name']; ?>"><?php echo $log['user_name']; ?></a>
                                            </td>
                                            <td>
                                                <a href="<?php echo BASE_URL . '/search/ip/' . $log['login_ip']; ?>"><?php echo $log['login_ip']; ?></a>
                                            </td>
                                            <td><?php echo $log['date']; ?></td>
                                            <td><?php echo $log['location']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php getFooter(); ?>