<div class="dv-row">
    <h4 class="dv-page-title"><i class="fas fa-chart-line"></i> <?php echo $data['lang']['sv_stats_txt']; ?></h4>
    <div class="dv-server-stats">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="dv-server-stats-item">
                    <i class="fas fa-users"></i>
                    <span class="dv-first"><?php echo $data['regUsers']; ?></span>
                    <span class="dv-second"><?php echo $data['lang']['reg_users_txt']; ?></span>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="dv-server-stats-item">
                    <i class="fas fa-home"></i>
                    <span class="dv-first"><?php echo $data['houses']; ?></span>
                    <span class="dv-second"><?php echo $data['lang']['houses_txt']; ?></span>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="dv-server-stats-item">
                    <i class="fas fa-building"></i>
                    <span class="dv-first"><?php echo $data['business']; ?></span>
                    <span class="dv-second"><?php echo $data['lang']['businesses_txt']; ?></span>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="dv-server-stats-item">
                    <i class="fas fa-car-side"></i>
                    <span class="dv-first"><?php echo $data['vehicles']; ?></span>
                    <span class="dv-second"><?php echo $data['lang']['personal_vehicles_txt']; ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="dv-row">
    <h4 class="dv-page-title"><i class="fas fa-exclamation-circle"></i> <?php echo $data['lang']['dont_miss_txt']; ?>
    </h4>
    <div class="row">
        <div class="col-lg-6 col-sm-12 col-12">
            <div class="dv-page-block">
                <h5 class="dv-block-title">
                    <a href="#" target="_blank"><?php echo $data['lang']['sv_news_txt']; ?></a>
                </h5>
                <div class="dv-feed">
                    <div class="dv-header clearfix">
                        <a href="#" class="dv-author float-left" target="_blank">
                            <img src="http://localhost/panel/public/resources/img/skins/id-299.png" alt="Avatar">
                            Author
                        </a>
                        <span class="float-right"><i class="far fa-clock"></i> 0000-00-00 00:00</span>
                    </div>
                    <div class="dv-body">
                        Server news go here.
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-12 col-12">
            <div class="dv-page-block">
                <h5 class="dv-block-title">
                    <a href="#" target="_blank"><?php echo $data['lang']['sv_updates_txt']; ?></a>
                </h5>
                <div class="dv-feed">
                    <div class="dv-header clearfix">
                        <a href="#" class="dv-author float-left" target="_blank">
                            <img src="http://localhost/panel/public/resources/img/skins/id-299.png" alt="Avatar">
                            Author
                        </a>
                        <span class="float-right"><i class="far fa-clock"></i> 0000-00-00 00:00</span>
                    </div>
                    <div class="dv-body">
                        Server updates go here.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h4 class="dv-page-title"><i class="fas fa-history"></i> <?php echo $data['lang']['latest_actions_txt']; ?></h4>
    <div class="dv-page-block">
        <div class="dv-user-fh">
            <?php if (!empty($data['latestFH'])): ?>
                <?php foreach ($data['latestFH'] as $fh): ?>
                    <div class="dv-user-fh-item">
                        <div class="dv-user-fh-avatar">
                            <img src="<?php echo BASE_URL . '/public/resources/img/skins/id-' . $fh['player_skin'] . '.png'; ?>"
                                 alt="User skin">
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
</div>