<?php getHeader($data); ?>
    <?php flashMessage(); ?>
    <h3 class="dv-page-title">Complaints</h3>
    <?php if (isLoggedIn()): ?>
        <div class="dv-secret-actions">
            <a href="<?php echo BASE_URL . '/complaints/create'; ?>" class="dv-btn btn btn-success"><i class="fas fa-plus-circle"></i> Post New Complaint</a>
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
                    <?php foreach($data['complaints'] as $complaint): ?>
                        <tr<?php if ($complaint['is_hidden'] == 1): ?> class="dv-hidden"<?php endif; ?>>
                            <td>
                                <a href="<?php echo BASE_URL . '/complaints/view/' . $complaint['id']; ?>"><?php echo $complaint['against_name']; ?> - <?php echo $complaint['category_name']; ?></a>
                            </td>
                            <td><a href="<?php echo BASE_URL . '/users/profile/' . $complaint['author_name']; ?>"><?php echo $complaint['author_name']; ?></a></td>
                            <td><?php echo $complaint['created_at']; ?></td>
                            <td><?php echo $complaint['status']; ?></td>
                            <td>
                                <a href="<?php echo BASE_URL . '/complaints/view/' . $complaint['id']; ?>" class="dv-action-btn"><i class="fas fa-eye"></i></a>
                                <?php if ((isLoggedIn() && $_SESSION['user_id'] == $complaint['author_id']) || in_array(1, $data['canEditAComplaints'])): ?>
                                    <a href="<?php echo BASE_URL . '/complaints/edit/' . $complaint['id']; ?>"><i class="fas fa-edit"></i></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php getFooter(); ?>
