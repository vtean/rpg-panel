<div class="dv-row">
    <h3 class="dv-page-title">Panel Logs</h3>
    <div class="row">
        <div class="col-lg-2 col-sm-12 col-12">
            <div class="nav flex-column nav-pills" role="tablist" aria-orientation="vertical">
                <a class="nav-link<?php if ($data['activePage'] == 'admin'): ?> active<?php endif; ?>"
                   href="<?php echo BASE_URL . '/logs/panel/admin'; ?>"><i class="fas fa-user-shield"></i> Admin Logs</a>
                <a class="nav-link<?php if ($data['activePage'] == 'leader'): ?> active<?php endif; ?>"
                   href="<?php echo BASE_URL . '/logs/panel/leader'; ?>"><i class="fas fa-user-tie"></i> Leader Logs</a>
                <a class="nav-link<?php if ($data['activePage'] == 'player'): ?> active<?php endif; ?>"
                   href="<?php echo BASE_URL . '/logs/panel/player'; ?>"><i class="fas fa-user"></i> Player Logs</a>
                <a class="nav-link<?php if ($data['activePage'] == 'login'): ?> active<?php endif; ?>"
                   href="<?php echo BASE_URL . '/logs/panel/login'; ?>"><i class="fas fa-sign-in-alt"></i> Login Logs</a>
            </div>
        </div>
        <div class="col-lg-10 col-sm-12 col-12">
            <div class="tab-content" id="dv-pills-tabContent">
                <?php if ($data['activePage'] != 'login'): ?>
                    <div class="tab-pane fade show active" role="tabpanel">
                        <div class="dvTable">
                            <table id="dvPanelLogsTable">
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
                                <?php if (!empty($data['logs'])): ?>
                                    <?php foreach ($data['logs'] as $log): ?>
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
                <?php else: ?>
                    <div class="tab-pane fade show active" role="tabpanel">
                        <div class="dvTable">
                            <table id="dvLogsTable">
                                <thead>
                                <tr>
                                    <th>User</th>
                                    <th>IP Address</th>
                                    <th>Date</th>
                                    <th>Location</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($data['logs'])): ?>
                                    <?php foreach ($data['logs'] as $log): ?>
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
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>