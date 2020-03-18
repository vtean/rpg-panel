<?php global $lang; ?>
<?php getHeader($data); ?>
<div class="dv-user-profile">
    <div class="row justify-content-center">
        <div class="col-auto">
            <div class="dv-user-profile-main">
                <h3 class="dv-user-profile-name"><?php echo $data['user']['NickName']; ?></h3>
                <img class="dv-user-profile-skin"
                     src="<?php echo BASE_URL . '/public/resources/img/skins/id-' . $data['user']['Skin'] . '.png'; ?>"
                     alt="<?php echo $data['user']['NickName'] . "'s Skin"; ?>">
            </div>
            <div class="dv-user-profile-controls m-auto">
                <?php if (isLoggedIn() && ($_SESSION['user_id'] == $data['user']['ID'])): ?>
                    <a class="dv-btn btn btn-primary" href="#" role="button"><i class="fas fa-user-edit"></i> <?php echo $lang['profile_settings_txt']; ?></a>
                <?php endif; ?>
                <?php if ((isLoggedIn() && ($_SESSION['user_id'] == $data['user']['ID'])) || (isLoggedIn() && ($data['isAdmin'] > 0))): ?>
                    <a class="dv-btn btn btn-warning" href="#" role="button"><i class="fas fa-exclamation-triangle"></i> <?php echo $lang['last_punish_txt']; ?></a>
                <?php endif; ?>
                <?php if (isLoggedIn() && ($data['fullAccess'] == true)): ?>
                    <a class="dv-btn btn btn-info" href="#" role="button"><i class="fas fa-wrench"></i> <?php echo $lang['edit_user_txt']; ?></a>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-lg-8 col-md-12 col-sm-12">
            <div class="dv-user-groups dv-row clearfix">
                <div class="dv-user-single-group dv-owner">
                    <i class="dv-user-group-icon fas fa-user-astronaut"></i>
                    <span class="dv-user-group-title">Owner</span>
                </div>
                <div class="dv-user-single-group dv-admin">
                    <i class="dv-user-group-icon fas fa-shield-alt"></i>
                    <span class="dv-user-group-title">Admin</span>
                </div>
                <div class="dv-user-single-group dv-faction-leader">
                    <i class="dv-user-group-icon fas fa-user-tie"></i>
                    <span class="dv-user-group-title">Faction Leader</span>
                </div>
                <div class="dv-user-single-group dv-support">
                    <i class="dv-user-group-icon fas fa-life-ring"></i>
                    <span class="dv-user-group-title">Tickets Support</span>
                </div>
                <div class="dv-user-single-group dv-vip">
                    <i class="dv-user-group-icon fas fa-star"></i>
                    <span class="dv-user-group-title">Titan VIP</span>
                </div>
            </div>
            <div class="dv-user-profile-info dv-row">
                <div class="dv-user-info-group">
                    <span class="dv-first"><?php echo $lang['faction_txt']; ?></span>
                    <span class="dv-second"><?php echo $data['user']['Member'] != 0 ? $data['faction'] : 'No Faction'; ?></span>
                </div>
                <div class="dv-user-info-group">
                    <span class="dv-first"><?php echo $lang['level_txt']; ?></span>
                    <span class="dv-second"><?php echo $data['user']['Level']; ?></span>
                </div>
                <div class="dv-user-info-group">
                    <span class="dv-first"><?php echo $lang['joined_txt']; ?></span>
                    <span class="dv-second"><?php $date = date_create($data['user']['RegData']);
                        echo date_format($date, 'd.n.Y - H:i:s'); ?></span>
                </div>
                <div class="dv-user-info-group">
                    <span class="dv-first"><?php echo $lang['faction_rank_txt']; ?></span>
                    <span class="dv-second"><?php echo $data['user']['Member'] != 0 ? $data['factionRank'] : 'No Rank'; ?></span>
                </div>
                <div class="dv-user-info-group">
                    <span class="dv-first"><?php echo $lang['phone_nr_txt']; ?></span>
                    <span class="dv-second"><?php echo $data['user']['TelNum'] != 0 ? $data['user']['TelNum'] : 'No Phone'; ?></span>
                </div>
                <div class="dv-user-info-group">
                    <span class="dv-first"><?php echo $lang['last_online_txt']; ?></span>
                    <span class="dv-second"><?php echo $data['user']['LastLogin']; ?></span>
                </div>
                <div class="dv-user-info-group">
                    <span class="dv-first"><?php echo $lang['family_txt']; ?></span>
                    <span class="dv-second"><?php echo $data['user']['pFamily'] != 0 ? $data['family'] : 'No Family'; ?></span>
                </div>
                <div class="dv-user-info-group">
                    <span class="dv-first"><?php echo $lang['played_time_txt']; ?></span>
                    <span class="dv-second"><?php echo convertMinutes($data['user']['PlayedTime']); ?></span>
                </div>
                <div class="dv-user-info-group">
                    <span class="dv-first"><?php echo $lang['warnings_txt']; ?></span>
                    <span class="dv-second"><?php echo $data['user']['Warns']; ?>/3</span>
                </div>
                <div class="dv-user-info-group">
                    <span class="dv-first"><?php echo $lang['family_rank_txt']; ?></span>
                    <span class="dv-second">Leader</span>
                </div>
                <div class="dv-user-info-group">
                    <span class="dv-first"><?php echo $lang['job_txt']; ?></span>
                    <span class="dv-second"><?php echo $data['user']['Job'] == 0 ? 'Unemployed' : $data['job']; ?></span>
                </div>
                <div class="dv-user-info-group">
                    <span class="dv-first"><?php echo $lang['faction_warns_txt']; ?></span>
                    <span class="dv-second"><?php echo $data['user']['FWarns']; ?>/3</span>
                </div>
                <div class="dv-user-info-group">
                    <span class="dv-first"><?php echo $lang['forum_name_txt']; ?></span>
                    <span class="dv-second">Lust</span>
                </div>
                <?php if (isLoggedIn() && ($_SESSION['user_id'] == $data['user']['ID'])): ?>
                    <div class="dv-user-info-group">
                        <span class="dv-first"><?php echo $lang['email_txt']; ?></span>
                        <span class="dv-second"><?php echo $data['user']['Mail']; ?></span>
                    </div>
                    <div class="dv-user-info-group">
                        <span class="dv-first"><?php echo $lang['2step_txt']; ?></span>
                        <span class="dv-second"><?php echo $data['user']['GoogleStatus'] == 0 ? 'No' : 'Yes'; ?></span>
                    </div>
                    <div class="dv-user-info-group">
                        <span class="dv-first"><?php echo $lang['money_txt']; ?></span>
                        <span class="dv-second">$<?php echo number_format($data['user']['Money'], 0, ',', ' '); ?></span>
                    </div>
                    <div class="dv-user-info-group">
                        <span class="dv-first"><?php echo $lang['bank_money_txt']; ?></span>
                        <span class="dv-second">$<?php echo number_format($data['user']['Bank'], 0, ',', ' '); ?></span>
                    </div>
                    <div class="dv-user-info-group">
                        <span class="dv-first"><?php echo $lang['dv_coins_txt']; ?></span>
                        <span class="dv-second"><?php echo $data['user']['VirMoney']; ?></span>
                    </div>
                <?php endif; ?>
            </div>
            <div class="dv-user-properties dv-row">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <h4 class="dv-row-title"><?php echo $lang['houses_txt']; ?></h4>
                        <div class="dv-user-property dv-house">
                            <ul class="list-style-none">
                                <li>
                                    <span class="dv-first"><?php echo $lang['house_id_txt']; ?>: </span>
                                    <span class="dv-second">420</span>
                                </li>
                                <li>
                                    <span class="dv-first"><?php echo $lang['level_txt']; ?>: </span>
                                    <span class="dv-second">7</span>
                                </li>
                                <li>
                                    <span class="dv-first"><?php echo $lang['price_txt']; ?>: </span>
                                    <span class="dv-second">$1,750,000</span>
                                </li>
                                <li>
                                    <span class="dv-first"><?php echo $lang['locked_txt']; ?>: </span>
                                    <span class="dv-second">Yes</span>
                                </li>
                            </ul>
                        </div>
                        <div class="dv-user-property dv-house">
                            <ul class="list-style-none">
                                <li>
                                    <span class="dv-first"><?php echo $lang['house_id_txt']; ?>: </span>
                                    <span class="dv-second">422</span>
                                </li>
                                <li>
                                    <span class="dv-first"><?php echo $lang['level_txt']; ?>: </span>
                                    <span class="dv-second">7</span>
                                </li>
                                <li>
                                    <span class="dv-first"><?php echo $lang['price_txt']; ?>: </span>
                                    <span class="dv-second">$1,750,000</span>
                                </li>
                                <li>
                                    <span class="dv-first"><?php echo $lang['locked_txt']; ?>: </span>
                                    <span class="dv-second">Yes</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <h4 class="dv-row-title"><?php echo $lang['businesses_txt']; ?></h4>
                        <div class="dv-user-property dv-business">
                            <ul class="list-style-none">
                                <li>
                                    <span class="dv-first"><?php echo $lang['biz_id_txt']; ?>: </span>
                                    <span class="dv-second">69</span>
                                </li>
                                <li>
                                    <span class="dv-first"><?php echo $lang['type_txt']; ?>: </span>
                                    <span class="dv-second">Ammunition</span>
                                </li>
                                <li>
                                    <span class="dv-first"><?php echo $lang['price_txt']; ?>: </span>
                                    <span class="dv-second">$3,500,000</span>
                                </li>
                                <li>
                                    <span class="dv-first"><?php echo $lang['products_txt']; ?>: </span>
                                    <span class="dv-second">5000</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <h4 class="dv-row-title"><?php echo $lang['vehicles_txt']; ?></h4>
                        <?php
                        if (!empty($data['getVehicle'])) {
                            foreach ($data['getVehicle'] as $index => $vehicle) { ?>
                                <div class="dv-user-property dv-vehicle">
                                    <ul class="list-style-none">
                                        <li>
                                            <span class="dv-first"><?php echo $lang['type_txt']; ?>: </span>
                                            <span class="dv-second"><?php echo $data['getModelName'][$index]['Name'] ?></span>
                                        </li>
                                        <li>
                                            <span class="dv-first"><?php echo $lang['days_txt']; ?>: </span>
                                            <span class="dv-second">7</span>
                                        </li>
                                        <li>
                                            <span class="dv-first"><?php echo $lang['odometer_txt']; ?>: </span>
                                            <span class="dv-second"><?php echo $vehicle['Milage'] ?>KM</span>
                                        </li>
                                        <li>
                                            <span class="dv-first"><?php echo $lang['colors_txt']; ?>: </span>
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
                <h4 class="dv-row-title"><?php echo $lang['fh_txt']; ?></h4>
                <ul class="dv-user-fh list-style-none">
                    <li class="dv-user-fh-item">
                        <div class="dv-user-fh-avatar">
                            <img src="<?php echo BASE_URL . '/public/resources/img/skins/id-' . $data['user']['Skin'] . '.png'; ?>"
                                 alt="<?php echo $data['user']['NickName'] . "'s Skin"; ?>">
                        </div>
                        <div class="dv-user-fh-text">
                            <p>Lust has joined the faction School Instructors (invited by Indigo).</p>
                            <span><i class="far fa-clock"></i> 15/03/2020 05:25</span>
                        </div>
                    </li>
                    <li class="dv-user-fh-item">
                        <div class="dv-user-fh-avatar">
                            <img src="<?php echo BASE_URL . '/public/resources/img/skins/id-' . $data['user']['Skin'] . '.png'; ?>"
                                 alt="<?php echo $data['user']['NickName'] . "'s Skin"; ?>">
                        </div>
                        <div class="dv-user-fh-text">
                            <p>Lust was uninvited by Indigo from faction School Instructors (rank 9) after 69 days,
                                without FP. Reason: Cerere de demisie!</p>
                            <span><i class="far fa-clock"></i> 15/03/2020 02:25</span>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="dv-row">
                <h4 class="dv-row-title"><?php echo $lang['weapon_skills_txt']; ?></h4>
                <div class="dv-user-weapon-skills">
                    <div class="dv-weapon-single">
                        <h5 class="skill-title">SD Pistol</h5>
                        <div class="dv-progress progress">
                            <div class="progress-bar progress-bar-striped dv-progress-color" role="progressbar"
                                 style="width: <?php echo $data['user']['SDPistol_Skill'] / 100; ?>%" aria-valuenow="10"
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="dv-weapon-single">
                        <h5 class="skill-title">Desert Eagle</h5>
                        <div class="dv-progress progress">
                            <div class="progress-bar progress-bar-striped dv-progress-color" role="progressbar"
                                 style="width: <?php echo $data['user']['Eagle_Skill'] / 100; ?>%" aria-valuenow="10"
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="dv-weapon-single">
                        <h5 class="skill-title">Shotgun</h5>
                        <div class="dv-progress progress">
                            <div class="progress-bar progress-bar-striped dv-progress-color" role="progressbar"
                                 style="width: <?php echo $data['user']['ShotGun_Skill'] / 100; ?>%" aria-valuenow="10"
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="dv-weapon-single">
                        <h5 class="skill-title">Micro Uzi</h5>
                        <div class="dv-progress progress">
                            <div class="progress-bar progress-bar-striped dv-progress-color" role="progressbar"
                                 style="width: <?php echo $data['user']['UZI_Skill'] / 100; ?>%" aria-valuenow="10"
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="dv-weapon-single">
                        <h5 class="skill-title">MP5</h5>
                        <div class="dv-progress progress">
                            <div class="progress-bar progress-bar-striped dv-progress-color" role="progressbar"
                                 style="width: <?php echo $data['user']['MP5_Skill'] / 100; ?>%" aria-valuenow="10"
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="dv-weapon-single">
                        <h5 class="skill-title">AK-47</h5>
                        <div class="dv-progress progress">
                            <div class="progress-bar progress-bar-striped dv-progress-color" role="progressbar"
                                 style="width: <?php echo $data['user']['AK47_Skill'] / 100; ?>%" aria-valuenow="10"
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="dv-weapon-single">
                        <h5 class="skill-title">M4A1</h5>
                        <div class="dv-progress progress">
                            <div class="progress-bar progress-bar-striped dv-progress-color" role="progressbar"
                                 style="width: <?php echo $data['user']['M4_Skill'] / 100; ?>%" aria-valuenow="10"
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="dv-weapon-single">
                        <h5 class="skill-title">Sniper Rifle</h5>
                        <div class="dv-progress progress">
                            <div class="progress-bar progress-bar-striped dv-progress-color" role="progressbar"
                                 style="width: <?php echo $data['user']['Sniper_Skill'] / 100; ?>%" aria-valuenow="10"
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php getFooter(); ?>
