<?php $faction = $data['faction']; ?>
<?php getHeader($data); ?>
<?php flashMessage(); ?>
<div class="dv-row">
    <h3 class="dv-page-title"><?php echo $faction['Name'] . ' Applications'; ?></h3>
    <?php if (isLoggedIn() && $data['appsStatus'] == 1): ?>
        <div class="dv-secret-actions">
            <a href="<?php echo BASE_URL . '/factions/applications/' . $faction['ID'] . '/create'; ?>"
               class="dv-btn btn btn-success"><i class="fas fa-plus-circle"></i> Post New Application</a>
        </div>
    <?php endif; ?>
    <div class="dvTable">
        <table id="dvApplicationsTable">
            <thead>
            <tr>
                <th>ID</th>
                <th>Player Name</th>
                <th>Created On</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($data['factionApps'])): ?>
                <?php foreach ($data['factionApps'] as $app): ?>
                    <tr>
                        <td><?php echo $app['id']; ?></td>
                        <td>
                            <a href="<?php echo BASE_URL . '/users/profile/' . $app['author_name']; ?>"><?php echo $app['author_name']; ?></a>
                        </td>
                        <td><?php echo $app['created_at']; ?></td>
                        <td><?php echo $app['status']; ?></td>
                        <td>
                            <a href="<?php echo BASE_URL . '/factions/applications/' . $app['faction_id'] . '/view/' . $app['id']; ?>"><i
                                        class="fas fa-eye"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php getFooter(); ?>
