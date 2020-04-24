<h3 class="dv-page-title">Complaints</h3>
<?php if (isLoggedIn()): ?>
    <div class="dv-secret-actions">
        <a href="<?php echo BASE_URL . '/complaints/create'; ?>" class="dv-btn btn btn-success"><i
                    class="fas fa-plus-circle"></i> Post New Complaint</a>
    </div>
<?php endif; ?>
<div class="dv-row">
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
                    <tr<?php if ($complaint['is_hidden'] == 1): ?> class="dv-hidden"<?php endif; ?>>
                        <td>
                            <a href="<?php echo BASE_URL . '/complaints/view/' . $complaint['id']; ?>"><?php echo $complaint['against_name']; ?>
                                - <?php echo $complaint['category_name']; ?></a>
                        </td>
                        <td>
                            <a href="<?php echo BASE_URL . '/users/profile/' . $complaint['author_name']; ?>"><?php echo $complaint['author_name']; ?></a>
                        </td>
                        <td><?php echo $complaint['created_at']; ?></td>
                        <td>
                            <span class="dv-topic-badge badge<?php if ($complaint['status'] == 'Open'): ?> badge-success<?php elseif ($complaint['status'] == 'Closed'): ?> badge-secondary<?php elseif ($complaint['status'] == 'Author Reply' || $complaint['status'] == 'Admin Reply'): ?> badge-warning<?php elseif ($complaint['status'] == 'Needs Owner Involvement'): ?> badge-danger<?php endif; ?>"><?php echo $complaint['status']; ?></span>
                        </td>
                        <td>
                            <a href="<?php echo BASE_URL . '/complaints/view/' . $complaint['id']; ?>"
                               class="dv-action-btn"><i class="fas fa-eye"></i></a>
                            <?php if ((isLoggedIn() && $_SESSION['user_id'] == $complaint['author_id']) || $data['privileges']['canEditAComplaints'] && $complaint['category_id'] == 5 || $data['privileges']['canEditHComplaints'] && $complaint['category_id'] == 6 || $data['privileges']['canEditLComplaints'] && $complaint['category_id'] == 7 || $data['privileges']['canEditUComplaints'] && $complaint['category_id'] == 8): ?>
                                <a href="<?php echo BASE_URL . '/complaints/edit/' . $complaint['id']; ?>"><i
                                            class="fas fa-edit"></i></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>