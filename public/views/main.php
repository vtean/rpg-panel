<?php getHeader($data['pageTitle']); ?>
    <div class="dv-main-menu">
        <div class="dv-logo">
            <a href="<?php echo BASE_URL; ?>">DreamVibe Panel</a>
        </div>
        <div class="dv-user-bar">
            <div class="dv-user-welcome">
                <?php if (isLoggedIn()): ?>
                    <img class="dv-user-avatar" src="<?php echo BASE_URL . '/public/resources/img/avatar.png' ?>" alt="User Avatar">
                    <span class="dv-welcome-text">Welcome, <?php echo $_SESSION['user_name']; ?></span>
                    <div class="dv-user-controls">
                        <ul class="list-style-none">
                            <li><a href=""><i class="fas fa-user-cog"></i></a></li>
                            <li><a href=""><i class="fas fa-bell"></i></a></li>
                            <li><a href="<?php echo BASE_URL . '/logout'; ?>"><i class="fas fa-sign-out-alt"></i></a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <img class="dv-user-avatar" src="<?php echo BASE_URL . '/public/resources/img/avatar.png' ?>" alt="User Avatar">
                    <span class="dv-welcome-text">Welcome, Guest</span>
                    <div class="dv-user-controls">
                        <ul class="list-style-none">
                            <li><a href="<?php echo BASE_URL . '/login'; ?>"><i class="fas fa-sign-in-alt"></i></a></li>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <nav class="dv-navbar navbar navbar-expand-lg navbar-dark">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#dreamvibe-navbar" aria-controls="dreamvibe-navbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="dreamvibe-navbar">
                <div class="dv-nav-group">
                    <h6 class="dv-nav-title">General</h6>
                    <ul class="dv-nav">
                        <li class="dv-nav-item">
                            <a class="dv-nav-link" href="<?php echo BASE_URL; ?>">
                                <i class="dv-nav-icon fas fa-home"></i>
                                <span class="dv-nav-text">Home</span>
                            </a>
                        </li>
                        <li class="dv-nav-item">
                            <a class="dv-nav-link" href="https://forum.dreamvibe.ro">
                                <i class="dv-nav-icon fas fa-comments"></i>
                                <span class="dv-nav-text">Forum</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="dv-nav-group">
                    <h6 class="dv-nav-title">Top secret</h6>
                    <ul class="dv-nav">
                        <?php if ($data['fullAccess']): ?>
                            <li class="dv-nav-item">
                                <a class="dv-nav-link" href="/owner">
                                    <i class="dv-nav-icon fas fa-cog"></i>
                                    <span class="dv-nav-text">Owner Panel</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ($data['isAdmin'] > 0): ?>
                            <li class="dv-nav-item">
                                <a class="dv-nav-link" href="#">
                                    <i class="dv-nav-icon fas fa-shield-alt"></i>
                                    <span class="dv-nav-text">Admin Panel</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ($data['isLeader'] > 0): ?>
                            <li class="dv-nav-item">
                                <a class="dv-nav-link" href="#">
                                    <i class="dv-nav-icon fas fa-shield-alt"></i>
                                    <span class="dv-nav-text">Leader Panel</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="dv-nav-group">
                    <h6 class="dv-nav-title">Topics</h6>
                    <ul class="dv-nav">
                        <li class="dv-nav-item">
                            <a class="dv-nav-link" href="#">
                                <i class="dv-nav-icon fas fa-ticket-alt"></i>
                                <span class="dv-nav-text">Tickets</span>
                            </a>
                        </li>
                        <li class="dv-nav-item">
                            <a class="dv-nav-link" href="#">
                                <i class="dv-nav-icon fas fa-user-times"></i>
                                <span class="dv-nav-text">Complaints</span>
                            </a>
                        </li>
                        <li class="dv-nav-item">
                            <a class="dv-nav-link" href="#">
                                <i class="dv-nav-icon fas fa-ban"></i>
                                <span class="dv-nav-text">Unban Requests</span>
                            </a>
                        </li>
                        <li class="dv-nav-item">
                            <a class="dv-nav-link" href="#">
                                <i class="dv-nav-icon fas fa-graduation-cap"></i>
                                <span class="dv-nav-text">Applications</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="dv-nav-group">
                    <h6 class="dv-nav-title">Groups</h6>
                    <ul class="dv-nav">
                        <li class="dv-nav-item">
                            <a class="dv-nav-link" href="#">
                                <i class="dv-nav-icon fas fa-users-cog"></i>
                                <span class="dv-nav-text">Staff</span>
                            </a>
                        </li>
                        <li class="dv-nav-item">
                            <a class="dv-nav-link" href="#">
                                <i class="dv-nav-icon fas fa-user-friends"></i>
                                <span class="dv-nav-text">Factions</span>
                            </a>
                        </li>
                        <li class="dv-nav-item">
                            <a class="dv-nav-link" href="#">
                                <i class="dv-nav-icon fas fa-users"></i>
                                <span class="dv-nav-text">Families</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <?php flashMessage(); ?>
    <div class="dv-row">
        <h4 class="dv-page-title">Server stats</h4>
        <div class="dv-server-stats">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="dv-server-stats-item shadow">
                        <i class="fas fa-users"></i>
                        <span class="dv-first">256</span>
                        <span class="dv-second">Registered Users</span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="dv-server-stats-item shadow">
                        <i class="fas fa-home"></i>
                        <span class="dv-first">860</span>
                        <span class="dv-second">Houses</span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="dv-server-stats-item shadow">
                        <i class="fas fa-building"></i>
                        <span class="dv-first">183</span>
                        <span class="dv-second">Businesses</span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="dv-server-stats-item shadow">
                        <i class="fas fa-car-side"></i>
                        <span class="dv-first">690</span>
                        <span class="dv-second">Personal Vehicles</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="dv-row">
        <h4 class="dv-page-title">Don't miss anything</h4>
        <div class="dv-main-feed shadow">
            <ul class="nav nav-tabs" id="dvTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="latest-actions-tab" data-toggle="tab" href="#latest-actions" role="tab" aria-controls="latest-actions" aria-selected="true">Latest actions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="server-news-tab" data-toggle="tab" href="#server-news" role="tab" aria-controls="server-news" aria-selected="false">Server news</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="server-updates-tab" data-toggle="tab" href="#server-updates" role="tab" aria-controls="server-updates" aria-selected="false">Server updates</a>
                </li>
            </ul>
            <div class="tab-content" id="dvTabContent">
                <div class="tab-pane fade show active" id="latest-actions" role="tabpanel" aria-labelledby="latest-actions-tab">
                    <ul class="dv-general-fh list-style-none">
                        <li class="dv-general-fh-item">
                            <img src="<?php echo BASE_URL . '/public/resources/img/avatar2.png'; ?>" alt="">
                            <div class="dv-general-fh-text">
                                <p>Indigo a fost demis de catre Adminul Lust din factiunea School Instructors (rank 10) dupa 69 de zile, fara FP. Motiv: Renuntare la functie!</p>
                                <span><i class="far fa-clock"></i> 15/03/2020 03:19</span>
                            </div>
                        </li>
                        <li class="dv-general-fh-item">
                            <img src="<?php echo BASE_URL . '/public/resources/img/avatar.png'; ?>" alt="">
                            <div class="dv-general-fh-text">
                                <p>Lust a fost demis de catre Indigo din factiunea School Instructors (rank 9) dupa 69 de zile, fara FP. Motiv: Cerere de demisie!</p>
                                <span><i class="far fa-clock"></i> 15/03/2020 02:25</span>
                            </div>
                        </li>
                        <li class="dv-general-fh-item">
                            <img src="<?php echo BASE_URL . '/public/resources/img/avatar.png'; ?>" alt="">
                            <div class="dv-general-fh-text">
                                <p>Lust a aderat la factiunea School Instructors (invitat de Indigo).</p>
                                <span><i class="far fa-clock"></i> 15/03/2020 00:15</span>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="tab-pane fade" id="server-news" role="tabpanel" aria-labelledby="server-news-tab">
                    Server news
                </div>
                <div class="tab-pane fade" id="server-updates" role="tabpanel" aria-labelledby="server-updates-tab">
                    Server updates
                </div>
            </div>
        </div>
    </div>
<?php getFooter(); ?>