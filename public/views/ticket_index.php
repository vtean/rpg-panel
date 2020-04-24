<h3 class="dv-page-title"><?php echo $data['lang']['tickets_view_txt']; ?></h3>
<div class="dv-row">
    <?php if (isLoggedIn()): ?>
        <div class="dv-secret-actions">
            <a href="<?php echo BASE_URL . '/tickets/create'; ?>" class="dv-btn btn btn-success"><i
                        class="fas fa-plus"></i> <?php echo $data['lang']['create_ticket_txt']; ?></a>
        </div>
    <?php endif; ?>
</div>
<div class="dv-row">
    <div class="dvTable">
        <table id="dvTicketsTable">
            <thead>
            <tr>
                <th><?php echo $data['lang']['ticket_id_txt']; ?></th>
                <th><?php echo $data['lang']['ticket_category_txt']; ?></th>
                <th><?php echo $data['lang']['ticket_author_txt']; ?></th>
                <th><?php echo $data['lang']['ticket_date_txt']; ?></th>
                <th><?php echo $data['lang']['ticket_status_txt']; ?></th>
                <th><?php echo $data['lang']['actions_txt']; ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($data['tickets'] as $ticket): ?>
                <tr>
                    <td><?php echo $ticket['id']; ?></td>
                    <td>
                        <a href="<?php echo BASE_URL . '/tickets/view/' . $ticket['id']; ?>"><?php echo $ticket['category_name']['name']; ?></a>
                    </td>
                    <td>
                        <a href="<?php echo BASE_URL . '/users/profile/' . $ticket['author_name']; ?>"><?php echo $ticket['author_name']; ?></a>
                    </td>
                    <td><?php echo $ticket['created_at']; ?></td>
                    <td>
                        <span class="dv-topic-badge badge<?php if ($ticket['status'] == 'Open'): ?> badge-success<?php elseif ($ticket['status'] == 'Closed'): ?> badge-secondary<?php elseif ($ticket['status'] == 'Author Reply' || $ticket['status'] == 'Admin Reply'): ?> badge-warning<?php elseif ($ticket['status'] == 'Needs Owner Involvement'): ?> badge-danger<?php endif; ?>"><?php echo $ticket['status']; ?></span>
                    </td>
                    <td>
                        <?php
                        if ($ticket['author_id'] == $_SESSION['user_id'] && $ticket['status'] == 'Open' || $data['privileges']['canEditTickets']) {
                            ?>
                            <a href="<?php echo BASE_URL . '/tickets/edit/' . $ticket['id']; ?>"
                               class="dv-action-btn"><i class="fas fa-edit"></i></a>
                            <?php
                        }
                        ?>
                        <?php
                        if ($data['privileges']['canViewTickets'] || $ticket['author_id'] == $_SESSION['user_id']) {
                            ?>
                            <a href="<?php echo BASE_URL . '/tickets/view/' . $ticket['id']; ?>"
                               class="dv-action-btn"><i class="fas fa-eye"></i></a>
                            <?php
                        }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>