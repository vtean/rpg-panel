<?php getHeader($data); ?>
<?php flashMessage(); ?>
    <div class="dv-row">
        <h3 class="dv-page-title">Families</h3>
        <div class="dvTable">
            <table id="dvFamiliesTable">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Members</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($data['families'])): ?>
                    <?php foreach ($data['families'] as $family): ?>
                        <tr>
                            <td><?php echo $family['ID']; ?></td>
                            <td>
                                <a href="<?php echo BASE_URL . '/families/view/' . $family['ID']; ?>"><?php echo $family['name']; ?></a>
                            </td>
                            <td><?php echo $family['memberscount']; ?></td>
                            <td>
                                <a href="<?php echo BASE_URL . '/families/view/' . $family['ID']; ?>"><i class="fas fa-eye"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php getFooter(); ?>