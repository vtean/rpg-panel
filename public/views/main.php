<?php getHeader($data['pageTitle']); ?>
    <?php flashMessage(); ?>
    <div class="dv-widget">
        <h4 class="dv-page-title">Server stats</h4>
        <div class="dv-server-stats clearfix">
            <div class="dv-server-stats-item">
                <i class="fas fa-users"></i>
                <span class="dv-first">126</span>
                <span class="dv-second">Online Players</span>
            </div>
            <div class="dv-server-stats-item">
                <i class="fas fa-user-friends"></i>
                <span class="dv-first">256</span>
                <span class="dv-second">Registered Users</span>
            </div>
            <div class="dv-server-stats-item">
                <i class="fas fa-home"></i>
                <span class="dv-first">860</span>
                <span class="dv-second">Houses</span>
            </div>
            <div class="dv-server-stats-item">
                <i class="fas fa-building"></i>
                <span class="dv-first">183</span>
                <span class="dv-second">Businesses</span>
            </div>
            <div class="dv-server-stats-item">
                <i class="fas fa-car-side"></i>
                <span class="dv-first">690</span>
                <span class="dv-second">Personal Vehicles</span>
            </div>
        </div>
    </div>
<?php getFooter(); ?>