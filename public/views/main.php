<?php getHeader($data['pageTitle']); ?>
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