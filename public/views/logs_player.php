<div class="dv-row">
    <h3 class="dv-page-title"><?php echo $data['player_name']; ?>'s Logs</h3>
    <div class="row">
        <div class="col-lg-2 col-sm-12 col-12">
            <div class="nav flex-column nav-pills" id="dv-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link active" id="all-logs-tab" data-toggle="pill" role="tab" href="#all-logs"
                   aria-controls="all-logs"
                   aria-selected="true"><i class="fas fa-history"></i> All Logs</a>
                <a class="nav-link" id="admin-logs-tab" data-toggle="pill" role="tab" href="#admin-logs"
                   aria-controls="admin-logs"
                   aria-selected="false"><i class="fas fa-user-shield"></i> Admin Logs</a>
                <a class="nav-link" id="anticheat-logs-tab" data-toggle="pill" role="tab" href="#anticheat-logs"
                   aria-controls="anticheat-logs" aria-selected="false"><i class="fas fa-shield-alt"></i> Anticheat Logs</a>
                <a class="nav-link" id="chat-logs-tab" data-toggle="pill" role="tab" href="#chat-logs"
                   aria-controls="chat-logs"
                   aria-selected="false"><i class="fas fa-comment-alt"></i> Chat Logs</a>
                <a class="nav-link" id="biz-logs-tab" data-toggle="pill" role="tab" href="#biz-logs"
                   aria-controls="biz-logs"
                   aria-selected="false"><i class="fas fa-building"></i> Business Logs</a>
                <a class="nav-link" id="house-logs-tab" data-toggle="pill" role="tab" href="#house-logs"
                   aria-controls="house-logs"
                   aria-selected="false"><i class="fas fa-home"></i> House Logs</a>
                <a class="nav-link" id="car-logs-tab" data-toggle="pill" role="tab" href="#car-logs"
                   aria-controls="car-logs"
                   aria-selected="false"><i class="fas fa-car"></i> Car Logs</a>
                <a class="nav-link" id="money-logs-tab" data-toggle="pill" role="tab" href="#money-logs"
                   aria-controls="money-logs"
                   aria-selected="false"><i class="fas fa-dollar-sign"></i> Money Logs</a>
                <a class="nav-link" id="panel-adm-logs-tab" data-toggle="pill" role="tab" href="#panel-adm-logs"
                   aria-controls="panel-adm-logs" aria-selected="false"><i class="fas fa-user-shield"></i> Panel Admin
                    Logs</a>
                <a class="nav-link" id="panel-lead-logs-tab" data-toggle="pill" role="tab" href="#panel-lead-logs"
                   aria-controls="panel-lead-logs" aria-selected="false"><i class="fas fa-user-tie"></i> Panel Leader
                    Logs</a>
                <a class="nav-link" id="panel-player-logs-tab" data-toggle="pill" role="tab"
                   href="#panel-player-logs"
                   aria-controls="panel-player-logs" aria-selected="false"><i class="fas fa-user"></i> Panel Player Logs</a>
                <a class="nav-link" id="panel-login-logs-tab" data-toggle="pill" role="tab" href="#panel-login-logs"
                   aria-controls="panel-login-logs" aria-selected="false"><i class="fas fa-sign-in-alt"></i> Login Logs</a>
            </div>
        </div>
        <div class="col-lg-10 col-sm-12 col-12">
            <div class="tab-content" id="dv-pills-tabContent">
                <div class="tab-pane fade show active" id="all-logs" role="tabpanel" aria-labelledby="all-logs-tab">
                    <div class="dvTable">
                        <table id="dvAllLogsTable">
                            <thead>
                            <tr>
                                <th>User</th>
                                <th>Action</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($data['playerAllLogs'])): ?>
                                <?php foreach ($data['playerAllLogs'] as $log): ?>
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
                <div class="tab-pane fade" id="admin-logs" role="tabpanel" aria-labelledby="admin-logs-tab">
                    <div class="dvTable">
                        <table id="dvAdminLogsTable">
                            <thead>
                            <tr>
                                <th>User</th>
                                <th>Action</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($data['playerAdminLogs'])): ?>
                                <?php foreach ($data['playerAdminLogs'] as $log): ?>
                                    <tr>
                                        <td>
                                            <a href="<?php echo BASE_URL . '/users/profile/' . $log['admin']; ?>"><?php echo $log['admin']; ?></a>
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
                <div class="tab-pane fade" id="anticheat-logs" role="tabpanel" aria-labelledby="anticheat-logs-tab">
                    <div class="dvTable">
                        <table id="dvAnticheatLogsTable">
                            <thead>
                            <tr>
                                <th>User</th>
                                <th>Action</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($data['playerAnticheatLogs'])): ?>
                                <?php foreach ($data['playerAnticheatLogs'] as $log): ?>
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
                <div class="tab-pane fade" id="chat-logs" role="tabpanel" aria-labelledby="chat-logs-tab">
                    <div class="dvTable">
                        <table id="dvChatLogsTable">
                            <thead>
                            <tr>
                                <th>User</th>
                                <th>Log</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($data['playerChatLogs'])): ?>
                                <?php foreach ($data['playerChatLogs'] as $log): ?>
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
                <div class="tab-pane fade" id="biz-logs" role="tabpanel" aria-labelledby="biz-logs-tab">
                    <div class="dvTable">
                        <table id="dvBusinessLogsTable">
                            <thead>
                            <tr>
                                <th>User</th>
                                <th>Action</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($data['playerBusinessLogs'])): ?>
                                <?php foreach ($data['playerBusinessLogs'] as $log): ?>
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
                <div class="tab-pane fade" id="house-logs" role="tabpanel" aria-labelledby="house-logs-tab">
                    <div class="dvTable">
                        <table id="dvHouseLogsTable">
                            <thead>
                            <tr>
                                <th>User</th>
                                <th>Action</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($data['playerHouseLogs'])): ?>
                                <?php foreach ($data['playerHouseLogs'] as $log): ?>
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
                <div class="tab-pane fade" id="car-logs" role="tabpanel" aria-labelledby="car-logs-tab">
                    <div class="dvTable">
                        <table id="dvCarLogsTable">
                            <thead>
                            <tr>
                                <th>User</th>
                                <th>Action</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($data['playerCarLogs'])): ?>
                                <?php foreach ($data['playerCarLogs'] as $log): ?>
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
                <div class="tab-pane fade" id="money-logs" role="tabpanel" aria-labelledby="money-logs-tab">
                    <div class="dvTable">
                        <table id="dvMoneyLogsTable">
                            <thead>
                            <tr>
                                <th>User</th>
                                <th>Action</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($data['playerMoneyLogs'])): ?>
                                <?php foreach ($data['playerMoneyLogs'] as $log): ?>
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
                <div class="tab-pane fade" id="panel-adm-logs" role="tabpanel" aria-labelledby="panel-adm-logs-tab">
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
                            <?php if (!empty($data['pAdminLogs'])): ?>
                                <?php foreach ($data['pAdminLogs'] as $log): ?>
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
                <div class="tab-pane fade" id="panel-lead-logs" role="tabpanel" aria-labelledby="panel-lead-logs-tab">
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
                            <?php if (!empty($data['pLeaderLogs'])): ?>
                                <?php foreach ($data['pLeaderLogs'] as $log): ?>
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
                <div class="tab-pane fade" id="panel-player-logs" role="tabpanel"
                     aria-labelledby="panel-player-logs-tab">
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
                            <?php if (!empty($data['pPlayerLogs'])): ?>
                                <?php foreach ($data['pPlayerLogs'] as $log): ?>
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
                <div class="tab-pane fade" id="panel-login-logs" role="tabpanel" aria-labelledby="panel-login-logs-tab">
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
                            <?php if (!empty($data['pLoginLogs'])): ?>
                                <?php foreach ($data['pLoginLogs'] as $log): ?>
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