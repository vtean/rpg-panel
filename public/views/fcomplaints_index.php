<?php $faction = $data['faction']; ?>
<?php getHeader($data); ?>
<?php flashMessage(); ?>
<div class="dv-row">
    <h3 class="dv-page-title"><?php echo $faction['Name'] . ' Complaints'; ?></h3>
    <?php if (isLoggedIn()): ?>
        <div class="dv-secret-actions">
            <a href="<?php echo BASE_URL . '/factions/complaints/' . $faction['ID'] . '/create'; ?>"
               class="dv-btn btn btn-success"><i class="fas fa-plus-circle"></i> Post New Complaint</a>
        </div>
    <?php endif; ?>
    <div class="dvTable">
        <table id="dvComplaintsTable">
            <thead>
            <tr>
                <th>Complaint Details</th>
                <th>Complaint Creator</th>
                <th>Posted on</th>
                <th>Complaint Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($data['complaints'])): ?>
                <?php foreach ($data['complaints'] as $complaint): ?>
                    <tr>
                        <td>
                            <a href="<?php echo BASE_URL . '/factions/complaints/' . $faction['ID'] . '/view/' . $complaint['id']; ?>"><?php echo $complaint['against_name']; ?>
                                - Faction Complaint</a>
                        </td>
                        <td>
                            <a href="<?php echo BASE_URL . '/users/profile/' . $complaint['author_name']; ?>"><?php echo $complaint['author_name']; ?></a>
                        </td>
                        <td><?php echo $complaint['created_at']; ?></td>
                        <td><?php echo $complaint['status']; ?></td>
                        <td>
                            <a href="<?php echo BASE_URL . '/factions/complaints/' . $faction['ID'] . '/view/' . $complaint['id']; ?>"><i
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
