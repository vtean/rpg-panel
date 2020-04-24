<?php $family = $data['family']; ?>
<div class="dv-row">
    <h3 class="dv-page-title"><?php echo $family['name']; ?> <?php echo $family['familyType']; ?> <?php if ($family['galka'] == 1): ?>
            <i class="fas fa-check-circle dv-verified" data-toggle="tooltip" data-placement="right"
               title="Verified"></i><?php endif; ?></h3>
    <div class="row">
        <div class="col-lg-8 col-sm-12 col-12">
            <div class="dvTable">
                <table id="dvFamilyMembersTable">
                    <thead>
                    <tr>
                        <th>Member</th>
                        <th>Rank</th>
                        <th>Joined</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($data['family']['members'])): ?>
                        <?php foreach ($data['family']['members'] as $member): ?>
                            <tr>
                                <td>
                                    <a href="<?php echo BASE_URL . '/users/profile/' . $member['NickName']; ?>"><?php echo $member['NickName']; ?></a>
                                </td>
                                <td>Coming soon</td>
                                <td>00/00/0000 00:00</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-4 col-sm-12 col-12">
            <div class="dv-widget">
                <h5 class="dv-widget-title"><i class="fas fa-info-circle"></i> Family Information</h5>
                <div class="dv-widget-content">
                    <ul class="dv-details list-style-none">
                        <li class="dv-single">
                            <span class="dv-first">Slogan:</span>
                            <span class="dv-second"><?php echo $family['slogan']; ?></span>
                        </li>
                        <li class="dv-single">
                            <span class="dv-first">Reputation:</span>
                            <span class="dv-second"><?php echo $family['famrep']; ?></span>
                        </li>
                        <li class="dv-single">
                            <span class="dv-first">Type:</span>
                            <span class="dv-second"><?php echo $family['familyType']; ?></span>
                        </li>
                        <li class="dv-single">
                            <span class="dv-first">Level:</span>
                            <span class="dv-second"><?php echo $family['Level']; ?></span>
                        </li>
                        <?php if (!empty($family['discord'] && $family['discord'] != 'None')): ?>
                            <li class="dv-single">
                                <span class="dv-first">Discord:</span>
                                <span class="dv-second"><?php echo $family['discord']; ?></span>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>