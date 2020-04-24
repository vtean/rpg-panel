<div class="dv-row">
    <h3 class="dv-page-title">Houses</h3>
    <div class="dvTable">
        <table id="dvPropertiesTable">
            <thead>
            <tr>
                <th>ID</th>
                <th>Owner</th>
                <th>Cost</th>
                <th>Interior</th>
                <th>Other Info</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($data['houses'])): ?>
                <?php foreach ($data['houses'] as $house): ?>
                    <tr>
                        <td><?php echo $house['ID']; ?></td>
                        <td>
                            <?php if ($house['Owner'] == 'The State'): ?>
                                The State
                            <?php else: ?>
                                <a href="<?php echo BASE_URL . '/users/profile/' . $house['Owner']; ?>"><?php echo $house['Owner']; ?></a>
                            <?php endif; ?>
                        </td>
                        <td><?php echo number_format($house['Cost'], 0, ',', ' '); ?>$</td>
                        <td><?php echo $house['Interior']; ?></td>
                        <td>
                            <a href="<?php echo BASE_URL . '/search/map/' . $house['Enter_X'] . '/' . $house['Enter_Y']; ?>"
                               data-toggle="tooltip" data-placement="top" title="Display on map"><i
                                        class="fas fa-map-marker-alt"></i></a>
                            <?php if ($house['Garage'] == 1): ?>
                                <i class="fas fa-warehouse" data-toggle="tooltip" data-placement="top"
                                   title="Has garage"></i>
                            <?php endif; ?>
                            <?php if ($house['Podval'] == 1): ?>
                                <i class="fas fa-dungeon" data-toggle="tooltip" data-placement="top"
                                   title="Has basement"></i>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>