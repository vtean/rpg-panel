<?php $faction = $data['faction']; ?>
<?php getHeader($data); ?>
<div class="dv-row">
    <h3 class="dv-page-title"><?php echo $faction['Name']; ?></h3>
    <div class="row">
        <div class="col-lg-8 col-sm-12 col-12">
            <div class="dvTable">
                <table id="dvFMembersTable">
                    <thead>
                    <tr>
                        <th>Member</th>
                        <th>Rank</th>
                        <th>Member Info</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($data['factionMembers'])): ?>
                        <?php foreach ($data['factionMembers'] as $member): ?>
                            <tr>
                                <td>
                                    <a href="<?php echo BASE_URL . '/users/profile/' . $member['NickName']; ?>">
                                        <img src="<?php echo BASE_URL . '/public/resources/img/skins/id-' . $member['Skin'] . '.png'; ?>" alt="<?php echo $member['NickName'] . "'s Skin" ?>">
                                        <span><?php echo $member['NickName']; ?></span>
                                    </a>
                                </td>
                                <td><?php echo $member['Rank']; ?></td>
                                <td>
                                    <span class="dv-first">Joined:</span>
                                    <span class="dv-second">01/01/2000 00:00:00</span>
                                    <br>
                                    <span class="dv-first">Faction Days:</span>
                                    <span class="dv-second">69</span>
                                    <br>
                                    <span class="dv-first">Faction Warns:</span>
                                    <span class="dv-second"><?php echo $member['FWarns'] . '/3'; ?></span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-4 col-sm-12 col-12">
            <div class="dv-widget">
                <h5 class="dv-widget-title"><i class="fas fa-file"></i> Pages</h5>
                <div class="dv-widget-content">
                    <a href="<?php echo BASE_URL . '/factions/applications/' . $faction['ID']; ?>" class="dv-btn btn btn-success btn-block"><i class="fas fa-graduation-cap"></i> Applications</a>
                    <a href="<?php echo BASE_URL . '/factions/complaints/' . $faction['ID']; ?>" class="dv-btn btn btn-warning btn-block"><i class="fas fa-user-times"></i> Complaints</a>
                    <a href="<?php echo BASE_URL . '/factions/resignations/' . $faction['ID']; ?>" class="dv-btn btn btn-danger btn-block"><i class="fas fa-sign-out-alt"></i> Resignations</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php getFooter(); ?>