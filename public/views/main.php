<?php getHeader($data); ?>
    <?php flashMessage(); ?>
    <div class="dv-row">
        <h4 class="dv-page-title"><?php echo $data['lang']['sv_stats_txt']; ?></h4>
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
        <h4 class="dv-page-title"><?php echo $data['lang']['dont_miss_txt']; ?></h4>
        <div class="dv-main-feed">
            <ul class="nav nav-tabs" id="dvTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="latest-actions-tab" data-toggle="tab" href="#latest-actions" role="tab" aria-controls="latest-actions" aria-selected="true"><?php echo $data['lang']['latest_actions_txt']; ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="server-news-tab" data-toggle="tab" href="#server-news" role="tab" aria-controls="server-news" aria-selected="false"><?php echo $data['lang']['sv_news_txt']; ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="server-updates-tab" data-toggle="tab" href="#server-updates" role="tab" aria-controls="server-updates" aria-selected="false"><?php echo $data['lang']['sv_updates_txt']; ?></a>
                </li>
            </ul>
            <div class="tab-content" id="dvTabContent">
                <div class="tab-pane fade show active" id="latest-actions" role="tabpanel" aria-labelledby="latest-actions-tab">
                    <ul class="dv-general-fh list-style-none">
                        <li class="dv-general-fh-item">
                            <img src="<?php echo BASE_URL . '/public/resources/img/avatar2.png'; ?>" alt="">
                            <div class="dv-general-fh-text">
                                <p>Indigo was uninvited by Admin Lust from faction School Instructors (rank 10) after 69 days, without FP. Reason: Renuntare la functie!</p>
                                <span><i class="far fa-clock"></i> 15/03/2020 03:19</span>
                            </div>
                        </li>
                        <li class="dv-general-fh-item">
                            <img src="<?php echo BASE_URL . '/public/resources/img/avatar.png'; ?>" alt="">
                            <div class="dv-general-fh-text">
                                <p>Lust was uninvited by Indigo from faction School Instructors (rank 9) after 69 days, without FP. Reason: Cerere de demisie!</p>
                                <span><i class="far fa-clock"></i> 15/03/2020 02:25</span>
                            </div>
                        </li>
                        <li class="dv-general-fh-item">
                            <img src="<?php echo BASE_URL . '/public/resources/img/avatar.png'; ?>" alt="">
                            <div class="dv-general-fh-text">
                                <p>Lust has joined the faction School Instructors (invited by Indigo).</p>
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