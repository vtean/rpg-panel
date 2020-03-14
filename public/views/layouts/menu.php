<div class="dv-main-menu">
    <div class="dv-logo">
        <a href="<?php echo BASE_URL; ?>">DreamVibe Panel</a>
    </div>
    <div class="dv-user-bar">
        <div class="dv-user-welcome">
            <?php if (isLoggedIn()): ?>
                <img class="dv-user-avatar" src="<?php echo BASE_URL . '/public/resources/img/avatar.png' ?>" alt="User Avatar">
                <span class="dv-welcome-text">Welcome, Bitch</span>
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
                    <li class="dv-nav-item">
                        <a class="dv-nav-link" href="#">
                            <i class="dv-nav-icon fas fa-cog"></i>
                            <span class="dv-nav-text">Owner Panel</span>
                        </a>
                    </li>
                    <li class="dv-nav-item">
                        <a class="dv-nav-link" href="#">
                            <i class="dv-nav-icon fas fa-shield-alt"></i>
                            <span class="dv-nav-text">Admin Panel</span>
                        </a>
                    </li>
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
        </div>
    </nav>
</div>