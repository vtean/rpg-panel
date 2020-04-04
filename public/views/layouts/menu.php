<div class="dv-main-menu">
    <div class="dv-menu-content">
        <div class="dv-logo">
            <a href="<?php echo BASE_URL; ?>">DreamVibe Panel</a>
        </div>
        <div class="dv-user-bar">
            <div class="dv-user-welcome">
                <?php if (isLoggedIn()): ?>
                    <div class="dv-user-avatar">
                        <a href="<?php echo BASE_URL . '/users/profile/' . $_SESSION['user_name']; ?>">
                            <img class="dv-logged-img" src="<?php echo BASE_URL . '/public/resources/img/skins/id-' . $_SESSION['user_skin'] . '.png'; ?>" alt="<?php echo $_SESSION['user_name'] . "'s Avatar"; ?>>">
                        </a>
                    </div>
                    <span class="dv-welcome-text"><?php echo $data['lang']['welcome_txt']; ?>, <?php echo $_SESSION['user_name']; ?></span>
                    <div class="dv-user-controls">
                        <ul class="list-style-none">
                            <li><a href="#"><i class="fas fa-user-cog"></i></a></li>
                            <li><a href=""><i class="fas fa-bell"></i></a></li>
                            <li><a href="<?php echo BASE_URL . '/logout'; ?>"><i class="fas fa-sign-out-alt"></i></a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <div class="dv-user-avatar">
                        <img class="dv-guest-img" src="<?php echo BASE_URL . '/public/resources/img/avatar.png' ?>" alt="User Avatar">
                    </div>
                    <span class="dv-welcome-text"><?php echo $data['lang']['welcome_txt']; ?>, <?php echo $data['lang']['guest_txt']; ?></span>
                    <div class="dv-user-controls">
                        <ul class="list-style-none">
                            <li><a href="<?php echo BASE_URL . '/login'; ?>"><i class="fas fa-sign-in-alt"></i></a></li>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
            <div class="dv-search">
                <form action="" class="dv-form">
                    <input type="search" class="form-control" placeholder="Looking for a player?">
                    <button class="btn btn-link" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>
        <nav class="dv-navbar navbar navbar-expand-lg navbar-dark">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#dreamvibe-navbar" aria-controls="dreamvibe-navbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="dreamvibe-navbar">
                <div class="dv-nav-group">
                    <h6 class="dv-nav-title"><?php echo $data['lang']['general_txt']; ?></h6>
                    <ul class="dv-nav">
                        <li class="dv-nav-item">
                            <a class="dv-nav-link" href="<?php echo BASE_URL; ?>">
                                <i class="dv-nav-icon fas fa-home"></i>
                                <span class="dv-nav-text"><?php echo $data['lang']['home_txt']; ?></span>
                            </a>
                        </li>
                        <li class="dv-nav-item">
                            <a class="dv-nav-link" href="https://forum.dreamvibe.ro">
                                <i class="dv-nav-icon fas fa-comments"></i>
                                <span class="dv-nav-text"><?php echo $data['lang']['forum_txt']; ?></span>
                            </a>
                        </li>
                    </ul>
                </div>
                <?php if ($data['fullAccess'] || $data['isAdmin'] || $data['isLeader']): ?>
                    <div class="dv-nav-group">
                        <h6 class="dv-nav-title"><?php echo $data['lang']['top_secret_txt']; ?></h6>
                        <ul class="dv-nav">
                            <?php if ($data['fullAccess']): ?>
                                <li class="dv-nav-item">
                                    <a class="dv-nav-link" href="<?php echo BASE_URL . '/owner'; ?>">
                                        <i class="dv-nav-icon fas fa-cog"></i>
                                        <span class="dv-nav-text"><?php echo $data['lang']['owner_panel_txt']; ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($data['isAdmin']): ?>
                                <li class="dv-nav-item">
                                    <a class="dv-nav-link" href="<?php echo BASE_URL . '/admin'; ?>">
                                        <i class="dv-nav-icon fas fa-shield-alt"></i>
                                        <span class="dv-nav-text"><?php echo $data['lang']['admin_panel_txt']; ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($data['isLeader']): ?>
                                <li class="dv-nav-item">
                                    <a class="dv-nav-link" href="<?php echo BASE_URL . '/leader'; ?>">
                                        <i class="dv-nav-icon fas fa-user-tie"></i>
                                        <span class="dv-nav-text"><?php echo $data['lang']['leader_panel_txt']; ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <div class="dv-nav-group">
                    <h6 class="dv-nav-title"><?php echo $data['lang']['topics_txt']; ?></h6>
                    <ul class="dv-nav">
                        <li class="dv-nav-item">
                            <a class="dv-nav-link" href="<?php echo BASE_URL . '/tickets'; ?>">
                                <i class="dv-nav-icon fas fa-ticket-alt"></i>
                                <span class="dv-nav-text"><?php echo $data['lang']['tickets_txt']; ?></span>
                                <span class="dv-badge badge badge-pill badge-danger"><?= $data['badges']['ticketBadge'] ?></span>
                            </a>
                        </li>
                        <li class="dv-nav-item">
                            <a class="dv-nav-link" href="<?php echo BASE_URL . '/complaints'; ?>">
                                <i class="dv-nav-icon fas fa-user-times"></i>
                                <span class="dv-nav-text"><?php echo $data['lang']['complaints_txt']; ?></span>
                            </a>
                        </li>
                        <li class="dv-nav-item">
                            <a class="dv-nav-link" href="<?php echo BASE_URL . '/unbans'; ?>">
                                <i class="dv-nav-icon fas fa-ban"></i>
                                <span class="dv-nav-text"><?php echo $data['lang']['unban_requests_txt']; ?></span>
                            </a>
                        </li>
                        <li class="dv-nav-item">
                            <a class="dv-nav-link" href="<?php echo BASE_URL . '/apps'; ?>">
                                <i class="dv-nav-icon fas fa-graduation-cap"></i>
                                <span class="dv-nav-text"><?php echo $data['lang']['apps_txt']; ?></span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="dv-nav-group">
                    <h6 class="dv-nav-title"><?php echo $data['lang']['groups_txt']; ?></h6>
                    <ul class="dv-nav">
                        <li class="dv-nav-item">
                            <a class="dv-nav-link" href="#">
                                <i class="dv-nav-icon fas fa-users-cog"></i>
                                <span class="dv-nav-text"><?php echo $data['lang']['staff_txt']; ?></span>
                            </a>
                        </li>
                        <li class="dv-nav-item">
                            <a class="dv-nav-link" href="#">
                                <i class="dv-nav-icon fas fa-user-friends"></i>
                                <span class="dv-nav-text"><?php echo $data['lang']['factions_txt']; ?></span>
                            </a>
                        </li>
                        <li class="dv-nav-item">
                            <a class="dv-nav-link" href="#">
                                <i class="dv-nav-icon fas fa-users"></i>
                                <span class="dv-nav-text"><?php echo $data['lang']['families_txt']; ?></span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="dv-nav-group">
                    <h6 class="dv-nav-title"><?php echo $data['lang']['other_txt']; ?></h6>
                    <ul class="dv-nav">
                        <li class="dv-nav-item">
                            <a class="dv-nav-link" href="#">
                                <i class="dv-nav-icon fas fa-shopping-bag"></i>
                                <span class="dv-nav-text"><?php echo $data['lang']['shop_txt']; ?></span>
                            </a>
                        </li>
                        <li class="dv-nav-item">
                            <a class="dv-nav-link dv-collapse" data-toggle="collapse" href="#collapseStats" role="button" aria-expanded="false" aria-controls="collapseStats">
                                <i class="dv-nav-icon fas fa-chart-bar"></i>
                                <span class="dv-nav-text"><?php echo $data['lang']['stats_txt']; ?></span>
                            </a>
                        </li>
                    </ul>
                    <ul class="dv-nav-collapse collapse list-style-none" id="collapseStats">
                        <li class="dv-nav-collapse-item">
                            <a href="<?php echo BASE_URL . '/online'; ?>" class="dv-nav-collapse-link">
                                <i class="dv-nav-collapse-icon fas fa-signal"></i>
                                <span class="dv-nav-collapse-text"><?php echo $data['lang']['online_txt']; ?></span>
                            </a>
                        </li>
                        <li class="dv-nav-collapse-item">
                            <a href="" class="dv-nav-collapse-link">
                                <i class="dv-nav-collapse-icon fas fa-user-friends"></i>
                                <span class="dv-nav-collapse-text"><?php echo $data['lang']['top_players_txt']; ?></span>
                            </a>
                        </li>
                        <li class="dv-nav-collapse-item">
                            <a href="" class="dv-nav-collapse-link">
                                <i class="dv-nav-collapse-icon fas fa-user-slash"></i>
                                <span class="dv-nav-collapse-text"><?php echo $data['lang']['bans_txt']; ?></span>
                            </a>
                        </li>
                        <li class="dv-nav-collapse-item">
                            <a href="" class="dv-nav-collapse-link">
                                <i class="dv-nav-collapse-icon fas fa-home"></i>
                                <span class="dv-nav-collapse-text"><?php echo $data['lang']['houses_txt']; ?></span>
                            </a>
                        </li>
                        <li class="dv-nav-collapse-item">
                            <a href="" class="dv-nav-collapse-link">
                                <i class="dv-nav-collapse-icon fas fa-building"></i>
                                <span class="dv-nav-collapse-text"><?php echo $data['lang']['businesses_txt']; ?></span>
                            </a>
                        </li>
                        <li class="dv-nav-collapse-item">
                            <a href="" class="dv-nav-collapse-link">
                                <i class="dv-nav-collapse-icon fas fa-car"></i>
                                <span class="dv-nav-collapse-text"><?php echo $data['lang']['vehicles_txt']; ?></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>