<div class="dv-row">
    <h3 class="dv-page-title">Server Logs</h3>
    <div class="row">
        <div class="col-lg-2 col-sm-12 col-12">
            <div class="nav flex-column nav-pills" id="dv-pills-tab">
                <a class="nav-link<?php if ($data['activePage'] == 'all'): ?> active<?php endif; ?>"
                   href="<?php echo BASE_URL . '/logs/server/all'; ?>"><i class="fas fa-history"></i> All Logs</a>
                <a class="nav-link<?php if ($data['activePage'] == 'admin'): ?> active<?php endif; ?>"
                   href="<?php echo BASE_URL . '/logs/server/admin'; ?>"><i class="fas fa-user-shield"></i> Admin Logs</a>
                <a class="nav-link<?php if ($data['activePage'] == 'anticheat'): ?> active<?php endif; ?>"
                   href="<?php echo BASE_URL . '/logs/server/anticheat'; ?>"><i class="fas fa-shield-alt"></i> Anticheat Logs</a>
                <a class="nav-link<?php if ($data['activePage'] == 'chat'): ?> active<?php endif; ?>"
                   href="<?php echo BASE_URL . '/logs/server/chat'; ?>"><i class="fas fa-comment-alt"></i> Chat Logs</a>
                <a class="nav-link<?php if ($data['activePage'] == 'business'): ?> active<?php endif; ?>"
                   href="<?php echo BASE_URL . '/logs/server/business'; ?>"><i class="fas fa-building"></i> Business Logs</a>
                <a class="nav-link<?php if ($data['activePage'] == 'house'): ?> active<?php endif; ?>"
                   href="#<?php echo BASE_URL . '/logs/server/house'; ?>"><i class="fas fa-home"></i> House Logs</a>
                <a class="nav-link<?php if ($data['activePage'] == 'car'): ?> active<?php endif; ?>"
                   href="<?php echo BASE_URL . '/logs/server/car'; ?>"><i class="fas fa-car"></i> Car Logs</a>
                <a class="nav-link<?php if ($data['activePage'] == 'money'): ?> active<?php endif; ?>"
                   href="<?php echo BASE_URL . '/logs/server/money'; ?>"><i class="fas fa-dollar-sign"></i> Money Logs</a>
            </div>
        </div>
        <div class="col-lg-10 col-sm-12 col-12">
            <div class="tab-content" id="dv-pills-tabContent">
                <div class="tab-pane fade show active">
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
            </div>
        </div>
    </div>
</div>