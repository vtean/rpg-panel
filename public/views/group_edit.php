<?php $group = $data['group']; ?>
<h3 class="dv-page-title">Edit Group: <?php echo $group['group_name']; ?></h3>
<div class="dv-row">
    <div class="dv-secret-actions">
        <form action="" method="post">
            <input type="hidden" name="csrfToken" value="<?php echo $_SESSION['csrfToken']; ?>">
            <button type="submit" name="delete_group" class="dv-btn btn btn-danger"><i class="fas fa-trash-alt"></i>
                Delete Group
            </button>
        </form>
    </div>
</div>
<div class="dv-row dv-create-group">
    <form action="" method="post" class="dv-form">
        <input type="hidden" name="csrfToken" value="<?php echo $_SESSION['csrfToken']; ?>">
        <!-- Group Details -->
        <h5 class="dv-row-title">Group Details</h5>
        <div class="form-group">
            <label for="group_name">Group Name</label>
            <input type="text" name="group_name"
                   class="form-control<?php if (!empty($errors['group_name_error'])): ?> is-invalid<?php endif; ?>"
                   id="group_name" value="<?php echo $group['group_name']; ?>">
            <?php if (!empty($errors['group_name_error'])): ?>
                <div class="invalid-feedback"><?php echo $errors['group_name_error']; ?></div>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <label for="group_keyword">Group Keyword</label>
            <input type="text" name="group_keyword"
                   class="form-control<?php if (!empty($errors['group_keyword_error'])): ?> is-invalid<?php endif; ?>"
                   id="group_keyword" value="<?php echo $group['group_keyword']; ?>">
            <?php if (!empty($errors['group_keyword_error'])): ?>
                <div class="invalid-feedback"><?php echo $errors['group_keyword_error']; ?></div>
            <?php endif; ?>
        </div>
        <!-- General Permissions -->
        <h5 class="dv-row-title">General Permissions</h5>
        <div class="form-group">
            <label for="is_hidden">Is hidden</label>
            <label class="dv-switch">
                <input type="checkbox" name="is_hidden" id="is_hidden"
                       value="<?php echo $group['is_hidden'] ?>"<?php if ($group['is_hidden'] == 1): ?> checked<?php endif; ?>>
                <span class="dv-switch-slider dv-round"></span>
            </label>
        </div>
        <div class="form-group">
            <label for="can_access_site">Can access site</label>
            <label class="dv-switch">
                <input type="checkbox" name="can_access_site" id="can_access_site"
                       value="<?php echo $group['can_access_site'] ?>"<?php if ($group['can_access_site'] == 1): ?> checked<?php endif; ?>>
                <span class="dv-switch-slider dv-round"></span>
            </label>
        </div>
        <!-- Tickets -->
        <h5 class="dv-row-title">Tickets</h5>
        <div class="form-group">
            <label for="can_view_tickets">Can view tickets</label>
            <label class="dv-switch">
                <input type="checkbox" name="can_view_tickets" id="can_view_tickets"
                       value="<?php echo $group['can_view_tickets']; ?>"<?php if ($group['can_view_tickets'] == 1): ?> checked<?php endif; ?>>
                <span class="dv-switch-slider dv-round"></span>
            </label>
        </div>
        <div class="form-group">
            <label for="can_edit_tickets">Can edit tickets</label>
            <label class="dv-switch">
                <input type="checkbox" name="can_edit_tickets" id="can_edit_tickets"
                       value="<?php echo $group['can_edit_tickets']; ?>"<?php if ($group['can_edit_tickets'] == 1): ?> checked<?php endif; ?>>
                <span class="dv-switch-slider dv-round"></span>
            </label>
        </div>
        <div class="form-group">
            <label for="can_delete_tickets">Can delete tickets</label>
            <label class="dv-switch">
                <input type="checkbox" name="can_delete_tickets" id="can_delete_tickets"
                       value="<?php echo $group['can_delete_tickets']; ?>"<?php if ($group['can_delete_tickets'] == 1): ?> checked<?php endif; ?>>
                <span class="dv-switch-slider dv-round"></span>
            </label>
        </div>
        <div class="form-group">
            <label for="can_delete_treplies">Can delete ticket replies</label>
            <label class="dv-switch">
                <input type="checkbox" name="can_delete_treplies" id="can_delete_treplies"
                       value="<?php echo $group['can_delete_treplies']; ?>"<?php if ($group['can_delete_treplies'] == 1): ?> checked<?php endif; ?>>
                <span class="dv-switch-slider dv-round"></span>
            </label>
        </div>
        <div class="form-group">
            <label for="can_close_tickets">Can close tickets</label>
            <label class="dv-switch">
                <input type="checkbox" name="can_close_tickets" id="can_close_tickets"
                       value="<?php echo $group['can_close_tickets']; ?>"<?php if ($group['can_close_tickets'] == 1): ?> checked<?php endif; ?>>
                <span class="dv-switch-slider dv-round"></span>
            </label>
        </div>
        <!-- User Complaints -->
        <h5 class="dv-row-title">User Complaints</h5>
        <div class="form-group">
            <label for="can_edit_ucomplaints">Can edit user complaints</label>
            <label class="dv-switch">
                <input type="checkbox" name="can_edit_ucomplaints" id="can_edit_ucomplaints"
                       value="<?php echo $group['can_edit_ucomplaints']; ?>"<?php if ($group['can_edit_ucomplaints'] == 1): ?> checked<?php endif; ?>>
                <span class="dv-switch-slider dv-round"></span>
            </label>
        </div>
        <div class="form-group">
            <label for="can_delete_ucomplaints">Can delete user complaints</label>
            <label class="dv-switch">
                <input type="checkbox" name="can_delete_ucomplaints" id="can_delete_ucomplaints"
                       value="<?php echo $group['can_delete_ucomplaints']; ?>"<?php if ($group['can_delete_ucomplaints'] == 1): ?> checked<?php endif; ?>>
                <span class="dv-switch-slider dv-round"></span>
            </label>
        </div>
        <div class="form-group">
            <label for="can_delete_ucreplies">Can delete user complaint replies</label>
            <label class="dv-switch">
                <input type="checkbox" name="can_delete_ucreplies" id="can_delete_ucreplies"
                       value="<?php echo $group['can_delete_ucreplies']; ?>"<?php if ($group['can_delete_ucreplies'] == 1): ?> checked<?php endif; ?>>
                <span class="dv-switch-slider dv-round"></span>
            </label>
        </div>
        <div class="form-group">
            <label for="can_close_ucomplaints">Can close user complaints</label>
            <label class="dv-switch">
                <input type="checkbox" name="can_close_ucomplaints" id="can_close_ucomplaints"
                       value="<?php echo $group['can_close_ucomplaints']; ?>"<?php if ($group['can_close_ucomplaints'] == 1): ?> checked<?php endif; ?>>
                <span class="dv-switch-slider dv-round"></span>
            </label>
        </div>
        <div class="form-group">
            <label for="can_hide_ucomplaints">Can hide user complaints</label>
            <label class="dv-switch">
                <input type="checkbox" name="can_hide_ucomplaints" id="can_hide_ucomplaints"
                       value="<?php echo $group['can_hide_ucomplaints']; ?>"<?php if ($group['can_hide_ucomplaints'] == 1): ?> checked<?php endif; ?>>
                <span class="dv-switch-slider dv-round"></span>
            </label>
        </div>
        <!-- Faction Complaints -->
        <h5 class="dv-row-title">Faction Complaints</h5>
        <div class="form-group">
            <label for="can_edit_fcomplaints">Can edit faction complaints</label>
            <label class="dv-switch">
                <input type="checkbox" name="can_edit_fcomplaints" id="can_edit_fcomplaints"
                       value="<?php echo $group['can_edit_fcomplaints']; ?>"<?php if ($group['can_edit_fcomplaints'] == 1): ?> checked<?php endif; ?>>
                <span class="dv-switch-slider dv-round"></span>
            </label>
        </div>
        <div class="form-group">
            <label for="can_delete_fcomplaints">Can delete faction complaints</label>
            <label class="dv-switch">
                <input type="checkbox" name="can_delete_fcomplaints" id="can_delete_fcomplaints"
                       value="<?php echo $group['can_delete_fcomplaints']; ?>"<?php if ($group['can_delete_fcomplaints'] == 1): ?> checked<?php endif; ?>>
                <span class="dv-switch-slider dv-round"></span>
            </label>
        </div>
        <div class="form-group">
            <label for="can_delete_fcreplies">Can delete faction complaint replies</label>
            <label class="dv-switch">
                <input type="checkbox" name="can_delete_fcreplies" id="can_delete_fcreplies"
                       value="<?php echo $group['can_delete_fcreplies']; ?>"<?php if ($group['can_delete_fcreplies'] == 1): ?> checked<?php endif; ?>>
                <span class="dv-switch-slider dv-round"></span>
            </label>
        </div>
        <div class="form-group">
            <label for="can_close_fcomplaints">Can close faction complaints</label>
            <label class="dv-switch">
                <input type="checkbox" name="can_close_fcomplaints" id="can_close_fcomplaints"
                       value="<?php echo $group['can_close_fcomplaints']; ?>"<?php if ($group['can_close_fcomplaints'] == 1): ?> checked<?php endif; ?>>
                <span class="dv-switch-slider dv-round"></span>
            </label>
        </div>
        <div class="form-group">
            <label for="can_hide_fcomplaints">Can hide faction complaints</label>
            <label class="dv-switch">
                <input type="checkbox" name="can_hide_fcomplaints" id="can_hide_fcomplaints"
                       value="<?php echo $group['can_hide_fcomplaints']; ?>"<?php if ($group['can_hide_fcomplaints'] == 1): ?> checked<?php endif; ?>>
                <span class="dv-switch-slider dv-round"></span>
            </label>
        </div>
        <!-- Admin Complaints -->
        <h5 class="dv-row-title">Admin Complaints</h5>
        <div class="form-group">
            <label for="can_edit_acomplaints">Can edit admin complaints</label>
            <label class="dv-switch">
                <input type="checkbox" name="can_edit_acomplaints" id="can_edit_acomplaints"
                       value="<?php echo $group['can_edit_acomplaints']; ?>"<?php if ($group['can_edit_acomplaints'] == 1): ?> checked<?php endif; ?>>
                <span class="dv-switch-slider dv-round"></span>
            </label>
        </div>
        <div class="form-group">
            <label for="can_delete_acomplaints">Can delete admin complaints</label>
            <label class="dv-switch">
                <input type="checkbox" name="can_delete_acomplaints" id="can_delete_acomplaints"
                       value="<?php echo $group['can_delete_acomplaints']; ?>"<?php if ($group['can_delete_acomplaints'] == 1): ?> checked<?php endif; ?>>
                <span class="dv-switch-slider dv-round"></span>
            </label>
        </div>
        <div class="form-group">
            <label for="can_delete_acreplies">Can delete admin complaint replies</label>
            <label class="dv-switch">
                <input type="checkbox" name="can_delete_acreplies" id="can_delete_acreplies"
                       value="<?php echo $group['can_delete_acreplies']; ?>"<?php if ($group['can_delete_acreplies'] == 1): ?> checked<?php endif; ?>>
                <span class="dv-switch-slider dv-round"></span>
            </label>
        </div>
        <div class="form-group">
            <label for="can_close_acomplaints">Can close admin complaints</label>
            <label class="dv-switch">
                <input type="checkbox" name="can_close_acomplaints" id="can_close_acomplaints"
                       value="<?php echo $group['can_close_acomplaints']; ?>"<?php if ($group['can_close_acomplaints'] == 1): ?> checked<?php endif; ?>>
                <span class="dv-switch-slider dv-round"></span>
            </label>
        </div>
        <div class="form-group">
            <label for="can_hide_acomplaints">Can hide admin complaints</label>
            <label class="dv-switch">
                <input type="checkbox" name="can_hide_acomplaints" id="can_hide_acomplaints"
                       value="<?php echo $group['can_hide_acomplaints']; ?>"<?php if ($group['can_hide_acomplaints'] == 1): ?> checked<?php endif; ?>>
                <span class="dv-switch-slider dv-round"></span>
            </label>
        </div>
        <!-- Helper Complaints -->
        <h5 class="dv-row-title">Helper Complaints</h5>
        <div class="form-group">
            <label for="can_edit_hcomplaints">Can edit helper complaints</label>
            <label class="dv-switch">
                <input type="checkbox" name="can_edit_hcomplaints" id="can_edit_hcomplaints"
                       value="<?php echo $group['can_edit_hcomplaints']; ?>"<?php if ($group['can_edit_hcomplaints'] == 1): ?> checked<?php endif; ?>>
                <span class="dv-switch-slider dv-round"></span>
            </label>
        </div>
        <div class="form-group">
            <label for="can_delete_hcomplaints">Can delete helper complaints</label>
            <label class="dv-switch">
                <input type="checkbox" name="can_delete_hcomplaints" id="can_delete_hcomplaints"
                       value="<?php echo $group['can_delete_hcomplaints']; ?>"<?php if ($group['can_delete_hcomplaints'] == 1): ?> checked<?php endif; ?>>
                <span class="dv-switch-slider dv-round"></span>
            </label>
        </div>
        <div class="form-group">
            <label for="can_delete_hcreplies">Can delete helper complaint replies</label>
            <label class="dv-switch">
                <input type="checkbox" name="can_delete_hcreplies" id="can_delete_hcreplies"
                       value="<?php echo $group['can_delete_hcreplies']; ?>"<?php if ($group['can_delete_hcreplies'] == 1): ?> checked<?php endif; ?>>
                <span class="dv-switch-slider dv-round"></span>
            </label>
        </div>
        <div class="form-group">
            <label for="can_close_hcomplaints">Can close helper complaints</label>
            <label class="dv-switch">
                <input type="checkbox" name="can_close_hcomplaints" id="can_close_hcomplaints"
                       value="<?php echo $group['can_close_hcomplaints']; ?>"<?php if ($group['can_close_hcomplaints'] == 1): ?> checked<?php endif; ?>>
                <span class="dv-switch-slider dv-round"></span>
            </label>
        </div>
        <div class="form-group">
            <label for="can_hide_hcomplaints">Can hide helper complaints</label>
            <label class="dv-switch">
                <input type="checkbox" name="can_hide_hcomplaints" id="can_hide_hcomplaints"
                       value="<?php echo $group['can_hide_hcomplaints']; ?>"<?php if ($group['can_hide_hcomplaints'] == 1): ?> checked<?php endif; ?>>
                <span class="dv-switch-slider dv-round"></span>
            </label>
        </div>
        <!-- Leader Complaints -->
        <h5 class="dv-row-title">Leader Complaints</h5>
        <div class="form-group">
            <label for="can_edit_lcomplaints">Can edit leader complaints</label>
            <label class="dv-switch">
                <input type="checkbox" name="can_edit_lcomplaints" id="can_edit_lcomplaints"
                       value="<?php echo $group['can_edit_lcomplaints']; ?>"<?php if ($group['can_edit_lcomplaints'] == 1): ?> checked<?php endif; ?>>
                <span class="dv-switch-slider dv-round"></span>
            </label>
        </div>
        <div class="form-group">
            <label for="can_delete_lcomplaints">Can delete leader complaints</label>
            <label class="dv-switch">
                <input type="checkbox" name="can_delete_lcomplaints" id="can_delete_lcomplaints"
                       value="<?php echo $group['can_delete_lcomplaints']; ?>"<?php if ($group['can_delete_lcomplaints'] == 1): ?> checked<?php endif; ?>>
                <span class="dv-switch-slider dv-round"></span>
            </label>
        </div>
        <div class="form-group">
            <label for="can_delete_lcreplies">Can delete leader complaint replies</label>
            <label class="dv-switch">
                <input type="checkbox" name="can_delete_lcreplies" id="can_delete_lcreplies"
                       value="<?php echo $group['can_delete_lcreplies']; ?>"<?php if ($group['can_delete_lcreplies'] == 1): ?> checked<?php endif; ?>>
                <span class="dv-switch-slider dv-round"></span>
            </label>
        </div>
        <div class="form-group">
            <label for="can_close_lcomplaints">Can close leader complaints</label>
            <label class="dv-switch">
                <input type="checkbox" name="can_close_lcomplaints" id="can_close_lcomplaints"
                       value="<?php echo $group['can_close_lcomplaints']; ?>"<?php if ($group['can_close_lcomplaints'] == 1): ?> checked<?php endif; ?>>
                <span class="dv-switch-slider dv-round"></span>
            </label>
        </div>
        <div class="form-group">
            <label for="can_hide_lcomplaints">Can hide leader complaints</label>
            <label class="dv-switch">
                <input type="checkbox" name="can_hide_lcomplaints" id="can_hide_lcomplaints"
                       value="<?php echo $group['can_hide_lcomplaints']; ?>"<?php if ($group['can_hide_lcomplaints'] == 1): ?> checked<?php endif; ?>>
                <span class="dv-switch-slider dv-round"></span>
            </label>
        </div>
        <!-- Unban Requests -->
        <h5 class="dv-row-title">Unban Requests</h5>
        <div class="form-group">
            <label for="can_view_unbans">Can view unban requests</label>
            <label class="dv-switch">
                <input type="checkbox" name="can_view_unbans" id="can_view_unbans"
                       value="<?php echo $group['can_view_unbans']; ?>"<?php if ($group['can_view_unbans'] == 1): ?> checked<?php endif; ?>>
                <span class="dv-switch-slider dv-round"></span>
            </label>
        </div>
        <div class="form-group">
            <label for="can_edit_unbans">Can edit unban requests</label>
            <label class="dv-switch">
                <input type="checkbox" name="can_edit_unbans" id="can_edit_unbans"
                       value="<?php echo $group['can_edit_unbans']; ?>"<?php if ($group['can_edit_unbans'] == 1): ?> checked<?php endif; ?>>
                <span class="dv-switch-slider dv-round"></span>
            </label>
        </div>
        <div class="form-group">
            <label for="can_delete_unbans">Can delete unban requests</label>
            <label class="dv-switch">
                <input type="checkbox" name="can_delete_unbans" id="can_delete_unbans"
                       value="<?php echo $group['can_delete_unbans']; ?>"<?php if ($group['can_delete_unbans'] == 1): ?> checked<?php endif; ?>>
                <span class="dv-switch-slider dv-round"></span>
            </label>
        </div>
        <div class="form-group">
            <label for="can_close_unbans">Can close unban requests</label>
            <label class="dv-switch">
                <input type="checkbox" name="can_close_unbans" id="can_close_unbans"
                       value="<?php echo $group['can_close_unbans']; ?>"<?php if ($group['can_close_unbans'] == 1): ?> checked<?php endif; ?>>
                <span class="dv-switch-slider dv-round"></span>
            </label>
        </div>
        <!-- Leader Applications -->
        <h5 class="dv-row-title">Leader Applications</h5>
        <div class="form-group">
            <label for="can_edit_lapps">Can edit leader applications</label>
            <label class="dv-switch">
                <input type="checkbox" name="can_edit_lapps" id="can_edit_lapps"
                       value="<?php echo $group['can_edit_lapps']; ?>"<?php if ($group['can_edit_lapps'] == 1): ?> checked<?php endif; ?>>
                <span class="dv-switch-slider dv-round"></span>
            </label>
        </div>
        <div class="form-group">
            <label for="can_delete_lapps">Can delete leader applications</label>
            <label class="dv-switch">
                <input type="checkbox" name="can_delete_lapps" id="can_delete_lapps"
                       value="<?php echo $group['can_delete_lapps']; ?>"<?php if ($group['can_delete_lapps'] == 1): ?> checked<?php endif; ?>>
                <span class="dv-switch-slider dv-round"></span>
            </label>
        </div>
        <!-- Helper Applications -->
        <h5 class="dv-row-title">Helper Applications</h5>
        <div class="form-group">
            <label for="can_edit_happs">Can edit helper applications</label>
            <label class="dv-switch">
                <input type="checkbox" name="can_edit_happs" id="can_edit_happs"
                       value="<?php echo $group['can_edit_happs']; ?>"<?php if ($group['can_edit_happs'] == 1): ?> checked<?php endif; ?>>
                <span class="dv-switch-slider dv-round"></span>
            </label>
        </div>
        <div class="form-group">
            <label for="can_delete_happs">Can delete helper applications</label>
            <label class="dv-switch">
                <input type="checkbox" name="can_delete_happs" id="can_delete_happs"
                       value="<?php echo $group['can_delete_happs']; ?>"<?php if ($group['can_delete_happs'] == 1): ?> checked<?php endif; ?>>
                <span class="dv-switch-slider dv-round"></span>
            </label>
        </div>
        <div class="text-align-center">
            <button type="submit" name="edit_group" class="dv-btn btn btn-primary m-auto">Submit</button>
        </div>
    </form>
</div>