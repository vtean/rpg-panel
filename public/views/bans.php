<?php getHeader($data); ?>
    <div class="dv-row">
        <h3 class="dv-page-title">Banned Players</h3>
        <div class="dvTable">
            <table id="dvBannedPlayersTable">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Banned By</th>
                    <th>Reason</th>
                    <th>Ban Time</th>
                    <th>Banned on</th>
                    <th>Unbanned on</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($data['bannedPlayers'])): ?>
                    <?php foreach ($data['bannedPlayers'] as $player): ?>
                        <tr>
                            <td>
                                <a href="<?php echo BASE_URL . '/users/profile/' . $player['Name']; ?>"><?php echo $player['Name']; ?></a>
                            </td>
                            <td>
                                <a href="<?php echo BASE_URL . '/users/profile/' . $player['BanAdmin']; ?>"><?php echo $player['BanAdmin']; ?></a>
                            </td>
                            <td><?php echo $player['BanReason']; ?></td>
                            <td><?php echo $player['BanSeconds'] / 86400; ?> days</td>
                            <td><?php echo $player['CreatedAt']; ?></td>
                            <td><?php echo $player['unbanDate']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php getFooter(); ?>