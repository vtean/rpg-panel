<?php getHeader($data); ?>
    <div class="dv-row">
        <h3 class="dv-page-title">Top Players</h3>
        <div class="dvTable">
            <table id="dvTopPlayersTable">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Level</th>
                    <th>Played Time</th>
                    <th>EXP</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($data['allPlayers'])): ?>
                    <?php foreach ($data['allPlayers'] as $player): ?>
                        <tr>
                            <td>
                                <a href="<?php echo BASE_URL . '/users/profile/' . $player['NickName']; ?>"><?php echo $player['NickName']; ?></a>
                            </td>
                            <td><?php echo $player['Level']; ?></td>
                            <td><?php echo convertMinutes($player['TotalPlayed']); ?></td>
                            <td><?php echo $player['Exp']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php getFooter(); ?>