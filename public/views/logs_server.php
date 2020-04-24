<?php getHeader($data); ?>
<?php flashMessage(); ?>
    <div class="dv-row">
        <h3 class="dv-page-title">Server Logs</h3>
        <div class="row">
            <div class="col-lg-2 col-sm-12 col-12">
                <div class="nav flex-column nav-pills" id="dv-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="all-logs-tab" data-toggle="pill" href="#all-logs" role="tab"
                       aria-controls="all-logs" aria-selected="true"><i class="fas fa-history"></i> All Logs</a>
                    <a class="nav-link" id="admin-logs-tab" data-toggle="pill" href="#admin-logs" role="tab"
                       aria-controls="admin-logs" aria-selected="false"><i class="fas fa-user-shield"></i> Admin Logs</a>
                    <a class="nav-link" id="anticheat-logs-tab" data-toggle="pill" href="#anticheat-logs" role="tab"
                       aria-controls="anticheat-logs" aria-selected="false"><i class="fas fa-shield-alt"></i> Anticheat Logs</a>
                    <a class="nav-link" id="chat-logs-tab" data-toggle="pill" href="#chat-logs" role="tab"
                       aria-controls="chat-logs" aria-selected="false"><i class="fas fa-comment-alt"></i> Chat Logs</a>
                    <a class="nav-link" id="biz-logs-tab" data-toggle="pill" href="#biz-logs" role="tab"
                       aria-controls="biz-logs" aria-selected="false"><i class="fas fa-building"></i> Business Logs</a>
                    <a class="nav-link" id="house-logs-tab" data-toggle="pill" href="#house-logs" role="tab"
                       aria-controls="house-logs" aria-selected="false"><i class="fas fa-home"></i> House Logs</a>
                    <a class="nav-link" id="car-logs-tab" data-toggle="pill" href="#car-logs" role="tab"
                       aria-controls="car-logs" aria-selected="false"><i class="fas fa-car"></i> Car Logs</a>
                    <a class="nav-link" id="money-logs-tab" data-toggle="pill" href="#money-logs" role="tab"
                       aria-controls="money-logs" aria-selected="false"><i class="fas fa-dollar-sign"></i> Money Logs</a>
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
                                <?php if (!empty($data['allLogs'])): ?>
                                    <?php foreach ($data['allLogs'] as $log): ?>
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
                                <?php if (!empty($data['adminLogs'])): ?>
                                    <?php foreach ($data['adminLogs'] as $log): ?>
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
                                <?php if (!empty($data['anticheatLogs'])): ?>
                                    <?php foreach ($data['anticheatLogs'] as $log): ?>
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
                                <?php if (!empty($data['chatLogs'])): ?>
                                    <?php foreach ($data['chatLogs'] as $log): ?>
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
                                <?php if (!empty($data['businessLogs'])): ?>
                                    <?php foreach ($data['businessLogs'] as $log): ?>
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
                                <?php if (!empty($data['houseLogs'])): ?>
                                    <?php foreach ($data['houseLogs'] as $log): ?>
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
                                <?php if (!empty($data['carLogs'])): ?>
                                    <?php foreach ($data['carLogs'] as $log): ?>
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
                                <?php if (!empty($data['moneyLogs'])): ?>
                                    <?php foreach ($data['moneyLogs'] as $log): ?>
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
                </div>
            </div>
        </div>
    </div>
<?php getFooter(); ?>