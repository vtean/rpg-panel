<?php getHeader($data); ?>
<?php flashMessage(); ?>
 <div class="dv-row">
     <h3 class="dv-page-title"><?php echo $data['player_name']; ?>'s Logs</h3>
     <div class="dv-main-feed">
         <ul class="nav nav-tabs" id="dvTab" role="tablist">
             <li class="nav-item">
                 <a class="nav-link active" id="all-logs-tab" data-toggle="tab" href="#all-logs" aria-controls="all-logs" aria-selected="true">All Logs</a>
             </li>
             <li class="nav-item">
                 <a class="nav-link" id="admin-logs-tab" data-toggle="tab" href="#admin-logs" aria-controls="admin-logs" aria-selected="true">Admin Logs</a>
             </li>
             <li class="nav-item">
                 <a class="nav-link" id="anticheat-logs-tab" data-toggle="tab" href="#anticheat-logs" aria-controls="anticheat-logs" aria-selected="true">Anticheat Logs</a>
             </li>
             <li class="nav-item">
                 <a class="nav-link" id="chat-logs-tab" data-toggle="tab" href="#chat-logs" aria-controls="chat-logs" aria-selected="true">Chat Logs</a>
             </li>
             <li class="nav-item">
                 <a class="nav-link" id="biz-logs-tab" data-toggle="tab" href="#biz-logs" aria-controls="biz-logs" aria-selected="true">Business Logs</a>
             </li>
             <li class="nav-item">
                 <a class="nav-link" id="house-logs-tab" data-toggle="tab" href="#house-logs" aria-controls="house-logs" aria-selected="true">House Logs</a>
             </li>
             <li class="nav-item">
                 <a class="nav-link" id="car-logs-tab" data-toggle="tab" href="#car-logs" aria-controls="car-logs" aria-selected="true">Car Logs</a>
             </li>
             <li class="nav-item">
                 <a class="nav-link" id="money-logs-tab" data-toggle="tab" href="#money-logs" aria-controls="money-logs" aria-selected="true">Money Logs</a>
             </li>
         </ul>
         <div class="tab-content" id="dvTabContent">
             <div class="tab-pane fade show active" id="all-logs" role="tabpanel" aria-labelledby="all-logs-tab">
                 <div class="dvTable">
                     <table id="dvAllLogsTable">
                         <thead>
                         <tr>
                             <th>User</th>
                             <th>Action</th>
                             <th>Date</th>
                         </tr>
                         </thead>
                         <tbody>
                         <?php if (!empty($data['playerAllLogs'])): ?>
                             <?php foreach ($data['playerAllLogs'] as $log): ?>
                                 <tr>
                                     <td>
                                         <a href="<?php echo BASE_URL . '/users/profile/' . $log['player']; ?>"><?php echo $log['player']; ?></a>
                                     </td>
                                     <td><?php echo $log['action']; ?></td>
                                     <td><?php echo $log['date']; ?></td>
                                 </tr>
                             <?php endforeach; ?>
                         <?php endif; ?>
                         </tbody>
                     </table>
                 </div>
             </div>
             <div class="tab-pane fade" id="admin-logs" role="tabpanel" aria-labelledby="admin-logs-tab">
                 <div class="dvTable">
                     <table id="dvAdminLogsTable">
                         <thead>
                         <tr>
                             <th>User</th>
                             <th>Action</th>
                             <th>Date</th>
                         </tr>
                         </thead>
                         <tbody>
                         <?php if (!empty($data['playerAdminLogs'])): ?>
                             <?php foreach ($data['playerAdminLogs'] as $log): ?>
                                 <tr>
                                     <td>
                                         <a href="<?php echo BASE_URL . '/users/profile/' . $log['admin']; ?>"><?php echo $log['admin']; ?></a>
                                     </td>
                                     <td><?php echo $log['action']; ?></td>
                                     <td><?php echo $log['date']; ?></td>
                                 </tr>
                             <?php endforeach; ?>
                         <?php endif; ?>
                         </tbody>
                     </table>
                 </div>
             </div>
             <div class="tab-pane fade" id="anticheat-logs" role="tabpanel" aria-labelledby="anticheat-logs-tab">
                 <div class="dvTable">
                     <table id="dvAnticheatLogsTable">
                         <thead>
                         <tr>
                             <th>User</th>
                             <th>Action</th>
                             <th>Date</th>
                         </tr>
                         </thead>
                         <tbody>
                         <?php if (!empty($data['playerAnticheatLogs'])): ?>
                             <?php foreach ($data['playerAnticheatLogs'] as $log): ?>
                                 <tr>
                                     <td>
                                         <a href="<?php echo BASE_URL . '/users/profile/' . $log['player']; ?>"><?php echo $log['player']; ?></a>
                                     </td>
                                     <td><?php echo $log['action']; ?></td>
                                     <td><?php echo $log['date']; ?></td>
                                 </tr>
                             <?php endforeach; ?>
                         <?php endif; ?>
                         </tbody>
                     </table>
                 </div>
             </div>
             <div class="tab-pane fade" id="chat-logs" role="tabpanel" aria-labelledby="chat-logs-tab">
                 <div class="dvTable">
                     <table id="dvChatLogsTable">
                         <thead>
                         <tr>
                             <th>User</th>
                             <th>Log</th>
                             <th>Date</th>
                         </tr>
                         </thead>
                         <tbody>
                         <?php if (!empty($data['playerChatLogs'])): ?>
                             <?php foreach ($data['playerChatLogs'] as $log): ?>
                                 <tr>
                                     <td>
                                         <a href="<?php echo BASE_URL . '/users/profile/' . $log['player']; ?>"><?php echo $log['player']; ?></a>
                                     </td>
                                     <td><?php echo $log['action']; ?></td>
                                     <td><?php echo $log['date']; ?></td>
                                 </tr>
                             <?php endforeach; ?>
                         <?php endif; ?>
                         </tbody>
                     </table>
                 </div>
             </div>
             <div class="tab-pane fade" id="biz-logs" role="tabpanel" aria-labelledby="biz-logs-tab">
                 <div class="dvTable">
                     <table id="dvBusinessLogsTable">
                         <thead>
                         <tr>
                             <th>User</th>
                             <th>Action</th>
                             <th>Date</th>
                         </tr>
                         </thead>
                         <tbody>
                         <?php if (!empty($data['playerBusinessLogs'])): ?>
                             <?php foreach ($data['playerBusinessLogs'] as $log): ?>
                                 <tr>
                                     <td>
                                         <a href="<?php echo BASE_URL . '/users/profile/' . $log['player']; ?>"><?php echo $log['player']; ?></a>
                                     </td>
                                     <td><?php echo $log['action']; ?></td>
                                     <td><?php echo $log['date']; ?></td>
                                 </tr>
                             <?php endforeach; ?>
                         <?php endif; ?>
                         </tbody>
                     </table>
                 </div>
             </div>
             <div class="tab-pane fade" id="house-logs" role="tabpanel" aria-labelledby="house-logs-tab">
                 <div class="dvTable">
                     <table id="dvHouseLogsTable">
                         <thead>
                         <tr>
                             <th>User</th>
                             <th>Action</th>
                             <th>Date</th>
                         </tr>
                         </thead>
                         <tbody>
                         <?php if (!empty($data['playerHouseLogs'])): ?>
                             <?php foreach ($data['playerHouseLogs'] as $log): ?>
                                 <tr>
                                     <td>
                                         <a href="<?php echo BASE_URL . '/users/profile/' . $log['player']; ?>"><?php echo $log['player']; ?></a>
                                     </td>
                                     <td><?php echo $log['action']; ?></td>
                                     <td><?php echo $log['date']; ?></td>
                                 </tr>
                             <?php endforeach; ?>
                         <?php endif; ?>
                         </tbody>
                     </table>
                 </div>
             </div>
             <div class="tab-pane fade" id="car-logs" role="tabpanel" aria-labelledby="car-logs-tab">
                 <div class="dvTable">
                     <table id="dvCarLogsTable">
                         <thead>
                         <tr>
                             <th>User</th>
                             <th>Action</th>
                             <th>Date</th>
                         </tr>
                         </thead>
                         <tbody>
                         <?php if (!empty($data['playerCarLogs'])): ?>
                             <?php foreach ($data['playerCarLogs'] as $log): ?>
                                 <tr>
                                     <td>
                                         <a href="<?php echo BASE_URL . '/users/profile/' . $log['player']; ?>"><?php echo $log['player']; ?></a>
                                     </td>
                                     <td><?php echo $log['action']; ?></td>
                                     <td><?php echo $log['date']; ?></td>
                                 </tr>
                             <?php endforeach; ?>
                         <?php endif; ?>
                         </tbody>
                     </table>
                 </div>
             </div>
             <div class="tab-pane fade" id="money-logs" role="tabpanel" aria-labelledby="money-logs-tab">
                 <div class="dvTable">
                     <table id="dvMoneyLogsTable">
                         <thead>
                         <tr>
                             <th>User</th>
                             <th>Action</th>
                             <th>Date</th>
                         </tr>
                         </thead>
                         <tbody>
                         <?php if (!empty($data['playerMoneyLogs'])): ?>
                             <?php foreach ($data['playerMoneyLogs'] as $log): ?>
                                 <tr>
                                     <td>
                                         <a href="<?php echo BASE_URL . '/users/profile/' . $log['player']; ?>"><?php echo $log['player']; ?></a>
                                     </td>
                                     <td><?php echo $log['action']; ?></td>
                                     <td><?php echo $log['date']; ?></td>
                                 </tr>
                             <?php endforeach; ?>
                         <?php endif; ?>
                         </tbody>
                     </table>
                 </div>
             </div>
         </div>
     </div>
 </div>
<?php getFooter(); ?>