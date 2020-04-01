<?php getHeader($data); ?>
    <?php flashMessage(); ?>
    <h3 class="dv-page-title">Unban Requests</h3>
    <?php if (isLoggedIn()): ?>
        <div class="dv-secret-actions">
            <a href="<?php echo BASE_URL . '/unbans/create'; ?>" class="dv-btn btn btn-success"><i class="fas fa-plus-circle"></i> New Unban Request</a>
        </div>
    <?php endif; ?>
    <div class="dv-row">
        <div class="dvTable">
            <table id="dvUnbansTable">
                <thead>
                <tr>
                    <th>Banned User</th>
                    <th>Banned By</th>
                    <th>Ban Reason</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data['unbans'] as $unban): ?>
                    <tr>
                        <td><a href="<?php echo BASE_URL . '/users/profile/' . $unban['author_name']; ?>"><?php echo $unban['author_name']; ?></a></td>
                        <td><a href="<?php echo BASE_URL . '/users/profile/' . $unban['admin_name']; ?>"><?php echo $unban['admin_name']; ?></a></td>
                        <td><?php echo $unban['ban_reason']; ?></td>
                        <td><?php echo $unban['status']; ?></td>
                        <td><a href="<?php echo BASE_URL . '/unbans/view/' . $unban['id']; ?>"><i class="fas fa-eye"></i></a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php getFooter(); ?>
