<div class="dv-row">
    <h3 class="dv-page-title"><?php echo $data['pageTitle']; ?></h3>
    <div class="dvTable">
        <table id="dreamTable">
            <thead>
            <tr>
                <th>Nume</th>
                <th>Level</th>
                <th>Faction</th>
                <th>Timp jucat</th>
                <th><?php echo $data['lang']['actions_txt']; ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($data['players'] as $player): ?>
                <tr>
                    <td>
                        <a href="<?php echo BASE_URL . '/users/profile/' . $player['name']; ?>"><?php echo $player['name'] ?></a>
                    </td>
                    <td><?php echo $player['score']; ?></td>
                    <td><?php echo $player['faction_name']; ?></td>
                    <td><?php echo $player['played_time']; ?></td>
                    <td>
                        <a href="<?php echo BASE_URL . '/users/profile/' . $player['name']; ?>" class="dv-action-btn"><i
                                    class="fas fa-eye"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>