<div class="dv-row">
    <h3 class="dv-page-title">Factions</h3>
    <div class="dvTable">
        <table id="dvFactionsTable">
            <thead>
            <tr>
                <th>ID</th>
                <th>Faction Name</th>
                <th>Members</th>
                <th>Faction Pages</th>
                <th>Applications</th>
                <th>Requirements</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($data['factions'] as $faction): ?>
                <tr>
                    <td><?php echo $faction['ID']; ?></td>
                    <td>
                        <a href="<?php echo BASE_URL . '/factions/view/' . $faction['ID']; ?>"><?php echo $faction['Name']; ?></a>
                    </td>
                    <td><?php echo $faction['Members'] . '/' . $faction['Max_Members']; ?></td>
                    <td>
                        <a href="<?php echo BASE_URL . '/factions/applications/' . $faction['ID']; ?>"
                           data-toggle="tooltip" data-placement="top" title="Applications"><i
                                    class="fas fa-graduation-cap"></i></a>
                        <a href="<?php echo BASE_URL . '/factions/complaints/' . $faction['ID']; ?>"
                           data-toggle="tooltip" data-placement="top" title="Complaints"><i
                                    class="fas fa-user-times"></i></a>
                        <a href="<?php echo BASE_URL . '/factions/resignations/' . $faction['ID']; ?>"
                           data-toggle="tooltip" data-placement="top" title="Resignations"><i
                                    class="fas fa-sign-out-alt"></i></a>
                    </td>
                    <td>
                        <?php if ($faction['Apps_Status'] == 1): ?>
                            <?php if (isLoggedIn()): ?>
                                <a href="<?php echo BASE_URL . '/factions/applications/' . $faction['ID'] . '/create'; ?>"
                                   class="dv-btn btn btn-success">Apply Now</a>
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