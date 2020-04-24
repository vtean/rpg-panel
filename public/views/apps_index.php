<div class="dv-row">
    <h3 class="dv-page-title">Wanna be a part of our STAFF?</h3>
    <div class="dv-grid-2">
        <div class="dv-magic-block">
            <h4 class="dv-magic-title">Helper Applications</h4>
            <div class="dv-magic-desc">
                <p>
                    First of all, make sure you know by heart the server and other function related rules.<br>
                    Secondly, you need to know that your <strong>behavior</strong> and <strong>activity</strong> are the
                    qualities which are a priority for us. We want to have an organized staff, who will also be a model
                    for the players.<br>
                    If you don't have enough time or don't take seriously these functions, then do not waste our and
                    your time.<br>
                    We reserve the right to choose who we want to be a part of our staff, but also we promise that we
                    will be as objective as we can.<br>
                    You can find all the rules on the following link: <a href="">dreamvibe.ro/rules</a><br>
                    So, if you are interested, follow the link below and make an application.<br>
                    Good luck!
                </p>
            </div>
            <div class="text-align-center">
                <a href="<?php echo BASE_URL . '/apps/create/helper'; ?>" class="btn dv-magic-btn"><i
                            class="fas fa-plus-circle"></i> Apply now</a>
            </div>
        </div>
        <div class="dv-magic-block">
            <h4 class="dv-magic-title">Leader Applications</h4>
            <div class="dv-magic-desc">
                <p>
                    Being a leader means being able to organize a group of people and make them feel good.<br>
                    It is important to know all the rules, to follow them and also to know how to behave in different
                    situations.<br>
                    You must act carefully and take the full responsibility for your actions.<br>
                    The leader is the image of the faction, so show everyone that you deserve this function and make
                    them be proud of you.<br>
                    Be honest in your application, we will check everything twice before giving you such an important
                    function.<br>
                    Follow the link below to apply. Good luck!
                </p>
            </div>
            <div class="text-align-center">
                <button class="btn dv-magic-btn" type="button" data-toggle="collapse" data-target="#collapseFactions"
                        aria-expanded="false" aria-controls="collapseFactions"><i class="fas fa-plus-circle"></i> Apply
                    now
                </button>
            </div>
            <div class="collapse" id="collapseFactions">
                <div class="dv-magic-group">
                    <ul class="list-style-none">
                        <?php if (empty($data['fWithoutLeader'])): ?>
                            <li>All the factions have leaders.</li>
                        <?php else: ?>
                            <?php foreach ($data['fWithoutLeader'] as $faction): ?>
                                <li>
                                    <a href="<?php echo BASE_URL . '/apps/create/leader/' . $faction['ID']; ?>"><?php echo $faction['Name']; ?></a>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="dv-row">
    <div class="dv-grid-2">
        <div class="dvTable">
            <table id="dvHelperAppsTable">
                <thead>
                <tr>
                    <th>Player Name</th>
                    <th>Played Time</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($data['helperApps'])): ?>
                    <?php foreach ($data['helperApps'] as $app): ?>
                        <tr>
                            <td>
                                <a href="<?php echo BASE_URL . '/users/profile/' . $app['author_name']; ?>"><?php echo $app['author_name']; ?></a>
                            </td>
                            <td><?php echo convertMinutes($app['played_time']); ?></td>
                            <td><a href="<?php echo BASE_URL . '/apps/view/' . $app['id']; ?>"><i
                                            class="fas fa-eye"></i></a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="dvTable">
            <table id="dvLeaderAppsTable">
                <thead>
                <tr>
                    <th>Player Name</th>
                    <th>Played Time</th>
                    <th>Faction</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($data['leaderApps'])): ?>
                    <?php foreach ($data['leaderApps'] as $app): ?>
                        <tr>
                            <td>
                                <a href="<?php echo BASE_URL . '/users/profile/' . $app['author_name']; ?>"><?php echo $app['author_name']; ?></a>
                            </td>
                            <td><?php echo convertMinutes($app['played_time']); ?></td>
                            <td><?php echo $app['faction_name']; ?></td>
                            <td><a href="<?php echo BASE_URL . '/apps/view/' . $app['id']; ?>"><i
                                            class="fas fa-eye"></i></a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>