<?php getHeader($data); ?>
<?php flashMessage(); ?>
<h3 class="dv-page-title">Factions</h3>
<div class="dv-row">
    <div class="dvTable">
        <table id="dvFactionsTable">
            <thead>
            <tr>
                <th>ID</th>
                <th>Faction Name</th>
                <th>Members</th>
                <th>Apps Status</th>
                <th>Requirements</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($data['factions'] as $faction): ?>
                <tr>
                    <td><?php echo $faction['ID']; ?></td>
                    <td><a href="<?php echo BASE_URL . '/factions/view/' . $faction['ID']; ?>"><?php echo $faction['Name']; ?></a></td>
                    <td><?php echo $faction['Members'] . '/' . $faction['Max_Members']; ?></td>
                    <td>
                        <?php if ($faction['Apps_Status'] == 1): ?>
                            <?php if (isLoggedIn()): ?>
                                <a href="<?php echo BASE_URL . '/factions/apply/' . $faction['ID']; ?>" class="dv-btn btn btn-success">Apply Now</a>
                            <?php else: ?>
                                Open
                            <?php endif; ?>
                        <?php else: ?>
                            Closed
                        <?php endif; ?>
                    </td>
                    <td>Level 5</td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php getFooter(); ?>
