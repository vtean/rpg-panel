<?php getHeader($data); ?>
    <?php flashMessage(); ?>
    <h3 class="dv-page-title"><?php echo $data['lang']['groups_view_txt']; ?></h3>
    <div class="dv-row">
        <div class="dv-secret-actions">
            <a href="<?php echo BASE_URL . '/groups/create'; ?>" class="dv-btn btn btn-success"><i class="fas fa-user-plus"></i> <?php echo $data['lang']['create_group_txt']; ?></a>
        </div>
    </div>
    <div class="dv-row">
        <div class="dvTable">
            <table id="dreamTable">
                <thead>
                <tr>
                    <th><?php echo $data['lang']['group_id_txt']; ?></th>
                    <th><?php echo $data['lang']['group_name_txt']; ?></th>
                    <th><?php echo $data['lang']['actions_txt']; ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data['groups'] as $group): ?>
                    <tr>
                        <td><?php echo $group['group_id']; ?></td>
                        <td><?php echo $group['group_name']; ?></td>
                        <td>
                            <a href="<?php echo BASE_URL . '/groups/edit/' . $group['group_id']; ?>" class="dv-action-btn"><i class="fas fa-edit"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php getFooter();