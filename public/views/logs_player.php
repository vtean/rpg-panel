<div class="dv-row">
    <h3 class="dv-page-title"><?php echo $data['player_name']; ?>'s Logs</h3>
    <div class="row">
        <div class="col-lg-2 col-sm-12 col-12">
            <div class="nav flex-column nav-pills" id="dv-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link<?php if ($data['activePage'] == 'all'): ?> active<?php endif; ?>"
                   href="<?php echo BASE_URL . '/logs/player/' . $data['player_id'] . '/all'; ?>">
                    <i class="fas fa-history"></i> All Logs</a>
                <a class="nav-link<?php if ($data['activePage'] == 'admin'): ?> active<?php endif; ?>"
                   href="<?php echo BASE_URL . '/logs/player/' . $data['player_id'] . '/admin'; ?>">
                    <i class="fas fa-user-shield"></i> Admin Logs</a>
                <a class="nav-link<?php if ($data['activePage'] == 'anticheat'): ?> active<?php endif; ?>"
                   href="<?php echo BASE_URL . '/logs/player/' . $data['player_id'] . '/anticheat'; ?>">
                    <i class="fas fa-shield-alt"></i> Anticheat Logs</a>
                <a class="nav-link<?php if ($data['activePage'] == 'chat'): ?> active<?php endif; ?>"
                   href="<?php echo BASE_URL . '/logs/player/' . $data['player_id'] . '/chat'; ?>">
                    <i class="fas fa-comment-alt"></i> Chat Logs</a>
                <a class="nav-link<?php if ($data['activePage'] == 'business'): ?> active<?php endif; ?>"
                   href="<?php echo BASE_URL . '/logs/player/' . $data['player_id'] . '/business'; ?>">
                    <i class="fas fa-building"></i> Business Logs</a>
                <a class="nav-link<?php if ($data['activePage'] == 'house'): ?> active<?php endif; ?>"
                   href="<?php echo BASE_URL . '/logs/player/' . $data['player_id'] . '/house'; ?>">
                    <i class="fas fa-home"></i> House Logs</a>
                <a class="nav-link<?php if ($data['activePage'] == 'car'): ?> active<?php endif; ?>"
                   href="<?php echo BASE_URL . '/logs/player/' . $data['player_id'] . '/car'; ?>">
                    <i class="fas fa-car"></i> Car Logs</a>
                <a class="nav-link<?php if ($data['activePage'] == 'money'): ?> active<?php endif; ?>"
                   href="<?php echo BASE_URL . '/logs/player/' . $data['player_id'] . '/money'; ?>">
                    <i class="fas fa-dollar-sign"></i> Money Logs</a>
                <a class="nav-link<?php if ($data['activePage'] == 'adm'): ?> active<?php endif; ?>"
                   href="<?php echo BASE_URL . '/logs/player/' . $data['player_id'] . '/adm'; ?>">
                    <i class="fas fa-user-shield"></i> Panel Admin Logs</a>
                <a class="nav-link<?php if ($data['activePage'] == 'leader'): ?> active<?php endif; ?>"
                   href="<?php echo BASE_URL . '/logs/player/' . $data['player_id'] . '/leader'; ?>">
                    <i class="fas fa-user-tie"></i> Panel Leader Logs</a>
                <a class="nav-link<?php if ($data['activePage'] == 'player'): ?> active<?php endif; ?>"
                   href="<?php echo BASE_URL . '/logs/player/' . $data['player_id'] . '/player'; ?>">
                    <i class="fas fa-user"></i> Panel Player Logs</a>
                <a class="nav-link<?php if ($data['activePage'] == 'login'): ?> active<?php endif; ?>"
                   href="<?php echo BASE_URL . '/logs/player/' . $data['player_id'] . '/login'; ?>">
                    <i class="fas fa-sign-in-alt"></i> Login Logs</a>
            </div>
        </div>
        <div class="col-lg-10 col-sm-12 col-12">
            <div class="tab-content" id="dv-pills-tabContent">
                <?php if (in_array($data['activePage'], $data['serverPages'])): ?>
                    <div class="tab-pane fade show active">
                        <div class="dvTable">
                            <table id="dvLogsTable">
                                <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Action</th>
                                    <th>Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($data['logs'])): ?>
                                    <?php foreach ($data['logs'] as $log): ?>
                                        <tr>
                                            <td>
                                                <a href="<?php echo BASE_URL . '/users/profile/' . $log['player']; ?>"><?php echo $log['player']; ?></a>
                                            </td>
                                            <td><?php echo $log['action']; ?></td>
                                            <td><?php echo $log['date']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php elseif (in_array($data['activePage'], $data['panelPages']) && $data['activePage'] != 'login'): ?>
                    <div class="tab-pane fade show active">
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
                                            <td><?php echo $log['date'] ?></td>
                                            <td>
                                                <a href="<?php echo BASE_URL . '/search/ip' . $log['ip_address']; ?>"><?php echo $log['ip_address']; ?></a>
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