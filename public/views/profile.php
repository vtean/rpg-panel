<div class="dv-user-profile">
    <div class="row justify-content-center">
        <div class="col-auto">
            <div class="dv-user-profile-main">
                <h3 class="dv-user-profile-name">
                    <span class="dv-online-status<?php if ($data['user']['Online_status'] == 0): ?> dv-offline<?php else: ?> dv-online<?php endif; ?>"
                          data-toggle="tooltip" data-placement="left"
                          title="<?php if ($data['user']['Online_status'] == 0): ?>Offline<?php else: ?>Online<?php endif; ?>"><i
                                class="fas fa-dot-circle"></i></span>
                    <span> <?php echo $data['user']['NickName']; ?></span>
                </h3>
                <div class="dv-progress progress">
                    <div class="progress-bar <?php if ($data['user']['HP'] >= 90): ?> dv-green<?php elseif ($data['user']['HP'] >= 70 && $data['user']['HP'] < 90): ?> dv-orange<?php elseif ($data['user']['HP'] >= 20 && $data['user']['HP'] < 70): ?> dv-dark-orange<?php else: ?> dv-red<?php endif; ?>"
                         role="progressbar"
                         style="width: <?php echo $data['user']['HP']; ?>%"
                         aria-valuenow="<?php echo $data['user']['HP']; ?>" aria-valuemin="0" aria-valuemax="100"
                         data-toggle="tooltip" data-placement="left"
                         title="<?php echo $data['user']['HP']; ?> HP"></div>
                </div>
                <div class="dv-user-profile-skin">
                    <img src="<?php echo BASE_URL . '/public/resources/img/skins/id-' . $data['user']['Skin'] . '.png'; ?>"
                         alt="<?php echo $data['user']['NickName'] . "'s Skin"; ?>">
                </div>
            </div>
            <div class="dv-user-profile-controls m-auto">
                <?php if (isLoggedIn() && ($_SESSION['user_id'] == $data['user']['ID'])): ?>
                    <a class="dv-btn btn btn-primary" href="<?php echo BASE_URL . '/users/settings'; ?>"
                       role="button"><i
                                class="fas fa-user-edit"></i> <?php echo $data['lang']['profile_settings_txt']; ?></a>
                <?php endif; ?>
                <?php if ((isLoggedIn() && ($_SESSION['user_id'] == $data['user']['ID'])) || (isLoggedIn() && ($data['privileges']['isAdmin'] > 0))): ?>
                    <a class="dv-btn btn btn-warning" href="#" role="button"><i
                                class="fas fa-exclamation-triangle"></i> <?php echo $data['lang']['last_punish_txt']; ?>
                    </a>
                <?php endif; ?>
                <?php if (isLoggedIn() && ($data['privileges']['fullAccess'] == 1)): ?>
                    <a href="<?php echo BASE_URL . '/groups/assign/' . $data['user']['NickName']; ?>"
                       class="dv-btn btn btn-primary" role="button"><i class="fas fa-user-tag"></i> Assign Groups</a>
                <?php endif; ?>
                <?php if (isLoggedIn() && ($data['privileges']['isAdmin']) > 6): ?>
                    <a href="<?php echo BASE_URL . '/logs/player/' . $data['user']['ID']; ?>"
                       class="dv-btn btn btn-info" role="button"><i class="fas fa-history"></i> Player Logs</a>
                    <button class="dv-btn btn btn-danger btn-block" data-toggle="modal" data-target="#suspendModal"><i
                                class="fas fa-ban"></i> Suspend
                    </button>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-lg-8 col-md-12 col-sm-12">
            <?php if ($data['userGroups']): ?>
                <div class="dv-user-groups dv-row clearfix">
                    <?php foreach ($data['userGroups'] as $key => $userGroup): ?>
                        <div class="dv-user-single-group dv-<?php echo $userGroup['group_keyword']; ?>">
                            <i class="dv-user-group-icon fas fa-<?php if ($userGroup['group_keyword'] == 'owner'): ?>user-astronaut<?php elseif ($userGroup['group_keyword'] == 'scripter'): ?>code<?php elseif ($userGroup['group_keyword'] == 'admin'): ?>shield-alt<?php elseif ($userGroup['group_keyword'] == 'manager'): ?>cog<?php elseif ($userGroup['group_keyword'] == 'leader'): ?>user-tie<?php elseif ($userGroup['group_keyword'] == 'support'): ?>life-ring<?php elseif ($userGroup['group_keyword'] == 'vip'): ?>star<?php endif; ?>"></i>
                            <span class="dv-user-group-title"><?php echo $userGroup['group_name']; ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <div class="dv-user-profile-info dv-row">
                <div class="dv-user-info-group">
                    <span class="dv-first"><?php echo $data['lang']['faction_txt']; ?></span>
                    <span class="dv-second"><?php echo $data['faction']; ?></span>
                </div>
                <div class="dv-user-info-group">
                    <span class="dv-first"><?php echo $data['lang']['level_txt']; ?></span>
                    <span class="dv-second"><?php echo $data['user']['Level']; ?></span>
                </div>
                <div class="dv-user-info-group">
                    <span class="dv-first"><?php echo $data['lang']['joined_txt']; ?></span>
                    <span class="dv-second"><?php $date = date_create($data['user']['RegData']);
                        echo date_format($date, 'd.n.Y - H:i:s'); ?></span>
                </div>
                <div class="dv-user-info-group">
                    <span class="dv-first"><?php echo $data['lang']['faction_rank_txt']; ?></span>
                    <span class="dv-second"><?php echo $data['user']['Member'] != 0 ? $data['factionRank'] : 'No Rank'; ?></span>
                </div>
                <div class="dv-user-info-group">
                    <span class="dv-first"><?php echo $data['lang']['phone_nr_txt']; ?></span>
                    <span class="dv-second"><?php echo $data['user']['TelNum'] != 0 ? $data['user']['TelNum'] : 'No Phone'; ?></span>
                </div>
                <div class="dv-user-info-group">
                    <span class="dv-first"><?php echo $data['lang']['last_online_txt']; ?></span>
                    <span class="dv-second"><?php echo $data['user']['LastLogin']; ?></span>
                </div>
                <div class="dv-user-info-group">
                    <span class="dv-first"><?php echo $data['lang']['family_txt']; ?></span>
                    <span class="dv-second"><?php echo $data['family']; ?></span>
                </div>
                <div class="dv-user-info-group">
                    <span class="dv-first"><?php echo $data['lang']['played_time_txt']; ?></span>
                    <span class="dv-second"><?php echo convertMinutes($data['user']['PlayedTime']); ?></span>
                </div>
                <div class="dv-user-info-group">
                    <span class="dv-first"><?php echo $data['lang']['warnings_txt']; ?></span>
                    <span class="dv-second"><?php echo $data['user']['Warns']; ?>/3</span>
                </div>
                <div class="dv-user-info-group">
                    <span class="dv-first"><?php echo $data['lang']['family_rank_txt']; ?></span>
                    <span class="dv-second">Leader</span>
                </div>
                <div class="dv-user-info-group">
                    <span class="dv-first"><?php echo $data['lang']['job_txt']; ?></span>
                    <span class="dv-second"><?php echo $data['job']; ?></span>
                </div>
                <div class="dv-user-info-group">
                    <span class="dv-first"><?php echo $data['lang']['faction_warns_txt']; ?></span>
                    <span class="dv-second"><?php echo $data['user']['FWarns']; ?>/3</span>
                </div>
                <div class="dv-user-info-group">
                    <span class="dv-first"><?php echo $data['lang']['forum_name_txt']; ?></span>
                    <span class="dv-second">Lust</span>
                </div>
                <?php if (isLoggedIn() && ($_SESSION['user_id'] == $data['user']['ID'])): ?>
                    <div class="dv-user-info-group">
                        <span class="dv-first"><?php echo $data['lang']['email_txt']; ?></span>
                        <span class="dv-second"><?php echo $data['user']['Mail']; ?></span>
                    </div>
                    <div class="dv-user-info-group">
                        <span class="dv-first"><?php echo $data['lang']['2step_txt']; ?></span>
                        <span class="dv-second"><?php echo $data['user']['GoogleStatus'] == 0 ? 'No' : 'Yes'; ?></span>
                    </div>
                    <div class="dv-user-info-group">
                        <span class="dv-first"><?php echo $data['lang']['money_txt']; ?></span>
                        <span class="dv-second">$<?php echo number_format($data['user']['Money'], 0, ',', ' '); ?></span>
                    </div>
                    <div class="dv-user-info-group">
                        <span class="dv-first"><?php echo $data['lang']['bank_money_txt']; ?></span>
                        <span class="dv-second">$<?php echo number_format($data['user']['Bank'], 0, ',', ' '); ?></span>
                    </div>
                    <div class="dv-user-info-group">
                        <span class="dv-first"><?php echo $data['lang']['dv_coins_txt']; ?></span>
                        <span class="dv-second"><?php echo $data['user']['VirMoney']; ?></span>
                    </div>
                <?php endif; ?>
            </div>
            <div class="dv-user-properties dv-row">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <h4 class="dv-row-title"><?php echo $data['lang']['houses_txt']; ?></h4>
                        <?php
                        if (!empty($data['getHouse'])) {
                            foreach ($data['getHouse'] as $house) { ?>
                                <div class="dv-user-property dv-house">
                                    <ul class="list-style-none">
                                        <li>
                                            <span class="dv-first"><?php echo $data['lang']['house_id_txt']; ?>: </span>
                                            <span class="dv-second"><?php echo $house['ID']; ?></span>
                                        </li>
                                        <li>
                                            <span class="dv-first"><?php echo $data['lang']['level_txt']; ?>: </span>
                                            <span class="dv-second"><?php echo $house['Level']; ?></span>
                                        </li>
                                        <li>
                                            <span class="dv-first"><?php echo $data['lang']['price_txt']; ?>: </span>
                                            <span class="dv-second">$<?php echo number_format($house['Cost'], 0, ',', ' '); ?></span>
                                        </li>
                                        <li>
                                            <span class="dv-first"><?php echo $data['lang']['locked_txt']; ?>: </span>
                                            <span class="dv-second"><?php echo $house['Lock'] == 0 ? 'No' : 'Yes'; ?></span>
                                        </li>
                                    </ul>
                                </div>
                                <?php
                            }
                        } else { ?> <span class="dv-first">No Houses</span> <?php }
                        ?>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <h4 class="dv-row-title"><?php echo $data['lang']['businesses_txt']; ?></h4>
                        <?php
                        if (!empty($data['getBusiness'])) {
                            foreach ($data['getBusiness'] as $business) { ?>
                                <div class="dv-user-property dv-business">
                                    <ul class="list-style-none">
                                        <li>
                                            <span class="dv-first"><?php echo $data['lang']['biz_id_txt']; ?>: </span>
                                            <span class="dv-second"><?php echo $business['ID']; ?></span>
                                        </li>
                                        <li>
                                            <span class="dv-first"><?php echo $data['lang']['type_txt']; ?>: </span>
                                            <span class="dv-second"><?php echo $business['Name']; ?></span>
                                        </li>
                                        <li>
                                            <span class="dv-first"><?php echo $data['lang']['price_txt']; ?>: </span>
                                            <span class="dv-second">$<?php echo number_format($business['Cost'], 0, ',', ' '); ?></span>
                                        </li>
                                        <li>
                                            <span class="dv-first"><?php echo $data['lang']['products_txt']; ?>: </span>
                                            <span class="dv-second"><?php echo $business['Products']; ?></span>
                                        </li>
                                    </ul>
                                </div>
                                <?php
                            }
                        } else { ?> <span class="dv-first">No Businesses</span> <?php }
                        ?>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <h4 class="dv-row-title"><?php echo $data['lang']['vehicles_txt']; ?></h4>
                        <?php
                        if (!empty($data['getVehicle'])) {
                            foreach ($data['getVehicle'] as $index => $vehicle) { ?>
                                <div class="dv-user-property dv-vehicle">
                                    <ul class="list-style-none">
                                        <li>
                                            <span class="dv-first"><?php echo $data['lang']['type_txt']; ?>: </span>
                                            <span class="dv-second"><?php echo $data['getModelName'][$index]['Name'] ?></span>
                                        </li>
                                        <li>
                                            <span class="dv-first"><?php echo $data['lang']['days_txt']; ?>: </span>
                                            <span class="dv-second">7</span>
                                        </li>
                                        <li>
                                            <span class="dv-first"><?php echo $data['lang']['odometer_txt']; ?>: </span>
                                            <span class="dv-second"><?php echo $vehicle['Milage'] ?>KM</span>
                                        </li>
                                        <li>
                                            <span class="dv-first"><?php echo $data['lang']['colors_txt']; ?>: </span>
                                            <span class="dv-second"><?php echo $vehicle['Color_1'] ?>, <?php echo $vehicle['Color_2'] ?></span>
                                        </li>
                                    </ul>
                                </div>
                                <?php
                            }
                        } else { ?> <span class="dv-first">No Vehicles</span> <?php }
                        ?>
                    </div>
                </div>
            </div>
            <div class="dv-row">
                <h4 class="dv-row-title"><?php echo $data['lang']['fh_txt']; ?></h4>
                <div class="dv-user-fh">
                    <?php if (!empty($data['userFH'])): ?>
                        <?php foreach ($data['userFH'] as $fh): ?>
                            <div class="dv-user-fh-item">
                                <div class="dv-user-fh-avatar">
                                    <img src="<?php echo BASE_URL . '/public/resources/img/skins/id-' . $data['user']['Skin'] . '.png'; ?>"
                                         alt="<?php echo $data['user']['NickName'] . "'s Skin"; ?>">
                                </div>
                                <div class="dv-user-fh-text">
                                    <p><?php echo $fh['action']; ?></p>
                                    <span><i class="far fa-clock"></i> <?php echo $fh['date']; ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <span>There are currently no actions.</span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="dv-row">
                <h4 class="dv-row-title"><?php echo $data['lang']['weapon_skills_txt']; ?></h4>
                <div class="dv-user-weapon-skills">
                    <div class="dv-weapon-single">
                        <h5 class="skill-title">SD Pistol</h5>
                        <div class="dv-progress progress">
                            <div class="progress-bar dv-progress-color" role="progressbar"
                                 style="width: <?php echo $data['user']['SDPistol_Skill'] / 100; ?>%" aria-valuenow="10"
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="dv-weapon-single">
                        <h5 class="skill-title">Desert Eagle</h5>
                        <div class="dv-progress progress">
                            <div class="progress-bar dv-progress-color" role="progressbar"
                                 style="width: <?php echo $data['user']['Eagle_Skill'] / 100; ?>%" aria-valuenow="10"
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="dv-weapon-single">
                        <h5 class="skill-title">Shotgun</h5>
                        <div class="dv-progress progress">
                            <div class="progress-bar dv-progress-color" role="progressbar"
                                 style="width: <?php echo $data['user']['ShotGun_Skill'] / 100; ?>%" aria-valuenow="10"
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="dv-weapon-single">
                        <h5 class="skill-title">Micro Uzi</h5>
                        <div class="dv-progress progress">
                            <div class="progress-bar dv-progress-color" role="progressbar"
                                 style="width: <?php echo $data['user']['UZI_Skill'] / 100; ?>%" aria-valuenow="10"
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="dv-weapon-single">
                        <h5 class="skill-title">MP5</h5>
                        <div class="dv-progress progress">
                            <div class="progress-bar dv-progress-color" role="progressbar"
                                 style="width: <?php echo $data['user']['MP5_Skill'] / 100; ?>%" aria-valuenow="10"
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="dv-weapon-single">
                        <h5 class="skill-title">AK-47</h5>
                        <div class="dv-progress progress">
                            <div class="progress-bar dv-progress-color" role="progressbar"
                                 style="width: <?php echo $data['user']['AK47_Skill'] / 100; ?>%" aria-valuenow="10"
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="dv-weapon-single">
                        <h5 class="skill-title">M4A1</h5>
                        <div class="dv-progress progress">
                            <div class="progress-bar dv-progress-color" role="progressbar"
                                 style="width: <?php echo $data['user']['M4_Skill'] / 100; ?>%" aria-valuenow="10"
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="dv-weapon-single">
                        <h5 class="skill-title">Sniper Rifle</h5>
                        <div class="dv-progress progress">
                            <div class="progress-bar dv-progress-color" role="progressbar"
                                 style="width: <?php echo $data['user']['Sniper_Skill'] / 100; ?>%" aria-valuenow="10"
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($data['privileges']['isAdmin'] > 6): ?>
            <div class="dv-modal modal fade" id="suspendModal" tabindex="-1" role="dialog"
                 aria-labelledby="suspendModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="suspendModalLabel">
                                Suspend <?php echo $data['user']['NickName']; ?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" class="dv-form">
                                <input type="hidden" name="csrfToken" value="<?php echo $_SESSION['csrfToken']; ?>"/>
                                <div class="form-group">
                                    <label for="suspendTime">Suspend Time</label>
                                    <input type="number" name="suspend_time" class="form-control" id="suspendTime"
                                           aria-describedby="suspendHelp">
                                    <small id="suspendHelp" class="form-text">Time is counted in days. Use 999 for
                                        permanent.</small>
                                </div>
                                <div class="form-group">
                                    <label for="suspendReason">Reason</label>
                                    <input type="text" name="suspend_reason" class="form-control" id="suspendReason">
                                </div>
                                <div class="clearfix">
                                    <button type="submit" name="suspend_user" class="dv-btn btn btn-danger float-right">
                                        <i class="fas fa-ban"></i> Suspend
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>