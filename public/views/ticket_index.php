<?php getHeader($data); ?>
    <?php flashMessage(); ?>
    <h3 class="dv-page-title"><?php echo $data['lang']['tickets_view_txt']; ?></h3>
    <div class="dv-row">
        <div class="dv-secret-actions">
            <a href="<?php echo BASE_URL . '/tickets/create'; ?>" class="dv-btn btn btn-success"><i class="fas fa-plus"></i> <?php echo $data['lang']['create_ticket_txt']; ?></a>
        </div>
    </div>
    <div class="dv-row">
        <table id="dvTable" class="display">
            <thead>
                <tr>
                    <th><?php echo $data['lang']['ticket_id_txt']; ?></th>
                    <th><?php echo $data['lang']['ticket_body_txt']; ?></th>
                    <th><?php echo $data['lang']['ticket_author_txt']; ?></th>
                    <th><?php echo $data['lang']['ticket_category_txt']; ?></th>
                    <th><?php echo $data['lang']['ticket_status_txt']; ?></th>
                    <th><?php echo $data['lang']['actions_txt']; ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['tickets'] as $ticket): ?>
                    <tr>
                        <td><?php echo $ticket['id']; ?></td>
                        <td><?php echo strLimit($ticket['body'], 30); ?></td>
                        <td><?php echo $ticket['author_name']; ?></td>
                        <td><?php echo $ticket['category_name']['name']; ?></td>
                        <td><?php echo $ticket['status']; ?></td>
                        <td>
                            <a href="<?php echo BASE_URL . '/tickets/edit/' . $ticket['ticket_id']; ?>" class="dv-action-btn"><i class="fas fa-edit"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php getFooter();