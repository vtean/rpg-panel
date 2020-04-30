<div class="dv-row">
    <h4 class="dv-row-title">Admins</h4>
    <div class="overflow-auto">
        <table class="dv-staff-table">
            <thead>
            <tr>
                <td>Username</td>
                <td>Admin Level</td>
                <td>Groups</td>
                <td>Last Login</td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($data['admins'] as $admin): ?>
                <tr>
                    <td>
                    <span class="dv-online-status<?php if ($admin['Online_status'] == 0): ?> dv-offline<?php else: ?> dv-online<?php endif; ?>"><i
                                class="fas fa-dot-circle" data-tooltip="tooltip" data-placement="top"
                                title="<?php if ($admin['Online_status'] == 0): ?>Offline<?php else: ?>Online<?php endif; ?>"></i></span>
                        <a href="<?php echo BASE_URL . '/users/profile/' . $admin['NickName']; ?>"><?php echo $admin['NickName']; ?></a>
                    </td>
                    <td><?php echo $admin['Admin']; ?></td>
                    <td class="dv-user-groups clearfix">
                        <?php if (!empty($admin['groups'])): ?>
                            <?php foreach ($admin['groups'] as $group): ?>
                                <?php if ($group['is_hidden'] == 0): ?>
                                    <span class="dv-user-single-group dv-<?php echo $group['group_keyword']; ?>">
                                        <i class="dv-user-group-icon fas fa-<?php if ($group['group_keyword'] == 'owner'): ?>user-astronaut<?php elseif ($group['group_keyword'] == 'scripter'): ?>code<?php elseif ($group['group_keyword'] == 'manager'): ?>cog<?php elseif ($group['group_keyword'] == 'support'): ?>life-ring<?php endif; ?>"></i>
                                        <span class="dv-user-group-title"><?php echo $group['group_name']; ?></span>
                                    </span>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </td>
                    <td><i class="far fa-clock"></i> <?php echo $admin['LastLogin']; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="dv-row">
    <h4 class="dv-row-title">Leaders</h4>
    <div class="overflow-auto">
        <table class="dv-staff-table">
            <thead>
            <tr>
                <td>Username</td>
                <td>Faction</td>
                <td>Faction Members</td>
                <td>Last Login</td>
            </tr>
            </thead>
            <tbody>
            <?php if (empty($data['leaders'])): ?>
                <td>There are currently no leaders.</td>
            <?php else: ?>
                <?php foreach ($data['leaders'] as $leader): ?>
                    <tr>
                        <td>
                    <span class="dv-online-status<?php if ($leader['Online_status'] == 0): ?> dv-offline<?php else: ?> dv-online<?php endif; ?>"><i
                                class="fas fa-dot-circle" data-tooltip="tooltip" data-placement="top"
                                title="<?php if ($leader['Online_status'] == 0): ?>Offline<?php else: ?>Online<?php endif; ?>"></i></span>
                            <a href="<?php echo BASE_URL . '/users/profile/' . $leader['NickName']; ?>"><?php echo $leader['NickName']; ?></a>
                        </td>
                        <td><?php echo $leader['faction_name']; ?></td>
                        <td><?php echo $leader['faction_members'] . '/30'; ?></td>
                        <td><i class="far fa-clock"></i> <?php echo $leader['LastLogin']; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>