<?php getHeader($data); ?>
    <div class="dv-row">
        <h3 class="dv-page-title">Vehicles</h3>
        <div class="dvTable">
            <table id="dvPropertiesTable">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Model</th>
                    <th>Owner</th>
                    <th>Cost</th>
                    <th>Other Info</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($data['vehicles'])): ?>
                    <?php foreach ($data['vehicles'] as $vehicle): ?>
                        <tr>
                            <td><?php echo $vehicle['ID']; ?></td>
                            <td><?php echo $vehicle['name']; ?></td>
                            <td>
                                <?php if ($vehicle['Owner'] == 'The State'): ?>
                                    The State
                                <?php else: ?>
                                    <a href="<?php echo BASE_URL . '/users/profile/' . $vehicle['Owner']; ?>"><?php echo $vehicle['Owner']; ?></a>
                                <?php endif; ?>
                            </td>
                            <td><?php echo number_format($vehicle['Cost'], 0, ',', ' '); ?>$</td>
                            <td>
                                <a href="<?php echo BASE_URL . '/search/map/' . $vehicle['Pos_X'] . '/' . $vehicle['Pos_Y']; ?>" data-toggle="tooltip" data-placement="top" title="Display on map"><i class="fas fa-map-marker-alt"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php getFooter(); ?>