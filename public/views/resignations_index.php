<?php $faction = $data['faction']; ?>
<?php getHeader($data); ?>
<?php flashMessage(); ?>
    <div class="dv-row">
        <h3 class="dv-page-title"><?php echo $faction['Name']; ?> Resignations</h3>
        <?php if ($data['isFactionMember']): ?>
            <div class="dv-secret-actions">
                <a href="<?php echo BASE_URL . '/factions/resignations/' . $faction['ID'] . '/create'; ?>"
                   class="dv-btn btn btn-success"><i class="fas fa-plus-circle"></i> Post New Resignation</a>
            </div>
        <?php endif; ?>
        <div class="dvTable">
            <table id="dvResignationsTable">
                <thead>
                <tr>
                    <th>Username</th>
                    <th>Posted on</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($data['resignations'])): ?>
                    <?php foreach ($data['resignations'] as $resignation): ?>
                        <tr>
                            <td>
                                <a href="<?php echo BASE_URL . '/users/profile/' . $resignation['author_name']; ?>"><?php echo $resignation['author_name']; ?></a>
                            </td>
                            <td><?php echo $resignation['created_at']; ?></td>
                            <td><?php echo $resignation['status']; ?></td>
                            <td>
                                <a href="<?php echo BASE_URL. '/factions/resignations/' . $resignation['faction_id'] . '/view/' . $resignation['id']; ?>"><i class="fas fa-eye"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php getFooter(); ?>