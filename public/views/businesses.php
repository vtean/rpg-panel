<div class="dv-row">
    <h3 class="dv-page-title">Businesses</h3>
    <div class="dvTable">
        <table id="dvPropertiesTable">
            <thead>
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Owner</th>
                <th>Cost</th>
                <th>Other Info</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($data['businesses'])): ?>
                <?php foreach ($data['businesses'] as $business): ?>
                    <tr>
                        <td><?php echo $business['ID']; ?></td>
                        <td><?php echo $business['Name']; ?></td>
                        <td>
                            <?php if ($business['Owner'] == 'The State'): ?>
                                The State
                            <?php else: ?>
                                <a href="<?php echo BASE_URL . '/users/profile/' . $business['Owner']; ?>"><?php echo $business['Owner']; ?></a>
                            <?php endif; ?>
                        </td>
                        <td><?php echo number_format($business['Cost'], 0, ',', ' '); ?>$</td>
                        <td>
                            <a href="<?php echo BASE_URL . '/search/map/' . $business['Enter_X'] . '/' . $business['Enter_Y']; ?>"
                               data-toggle="tooltip" data-placement="top" title="Display on map"><i
                                        class="fas fa-map-marker-alt"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>