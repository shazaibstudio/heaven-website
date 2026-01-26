<div class="sidebar"> <!-- *** sidebar layout *** -->
  <div class="logo clear"> <a href="home.php" title="View dashboard"> <span class="title">
    <?=COMPANY_NAME;?>
    CMS</span> <span class="text">version 1.0b</span> </a> </div>
  <div class="lhsMenu">
    <div class="menu">
      <ul>
        <li <? if($g_page_heading == 'Dashboard') echo 'class="active"'; ?>><a href="home.php" onclick="navigate(this.href);">Dashboard</a></li>
        <li <? if($g_page_heading == 'Preferences') echo 'class="active"'; ?>><a href="#">Preferences</a>
          <ul>
            <li <? if($g_section_heading == 'Global Configuration') echo 'class="active"'; ?>><a href="web_config.php" onclick="navigate(this.href);">Global Configuration</a></li>
            <li <? if($g_section_heading == 'Change Password') echo 'class="active"'; ?>><a href="change_password.php" onclick="navigate(this.href);">Change Password</a></li>
            <li><a href="admin_panel.php?act=logout">Logout</a></li>
          </ul>
        </li>
        
        <li <? if($g_page_heading == 'Manage Rooms') echo 'class="active"'; ?>><a href="#">Manage Rooms</a>
          <ul>
            <li <? if($g_section_heading == 'Manage Rooms') echo 'class="active"'; ?>><a href="rooms.php" onclick="navigate(this.href);">Manage Rooms</a></li>
            <li <? if($g_section_heading == 'Add Room') echo 'class="active"'; ?>><a href="rooms_add.php" onclick="navigate(this.href);">Add Room</a></li>
          </ul>
        </li>

        <li <? if($g_page_heading == 'Manage Orders') echo 'class="active"'; ?>><a href="#">Manage Orders</a>
          <ul>
            <?php
            foreach($ORDER_STATUSES as $k => $v) {
              $count = $db->GetOne("SELECT COUNT(id) AS tot FROM ".DB_TABLE_PREFIX."orders WHERE order_type = 'reservation' and viewed = 'N' AND status = '{$k}'");
            ?>
            <li <? if($g_page_heading == 'Manage Orders' && $g_section_heading == $v.' Orders') echo 'class="active"'; ?>><a href="orders.php?order_type=reservation&os=<?=$k;?>" onclick="navigate(this.href);"><?=$v;?> Orders (<?php echo $count; ?>)</a></li>
            <?php } ?>
          </ul>
        </li>

        <li <? if($g_page_heading == 'Manage Pay Later Orders') echo 'class="active"'; ?>><a href="#">Manage Pay Later Orders</a>
          <ul>
            <?php
            foreach($ORDER_STATUSES as $k => $v) {
              $count = $db->GetOne("SELECT COUNT(id) AS tot FROM ".DB_TABLE_PREFIX."orders WHERE order_type = 'pay-later' and viewed = 'N' AND status = '{$k}'");
            ?>
            <li <? if($g_page_heading == 'Manage Pay Later Orders' && $g_section_heading == $v.' Orders') echo 'class="active"'; ?>><a href="orders.php?order_type=pay-later&os=<?=$k;?>" onclick="navigate(this.href);"><?=$v;?> Orders (<?php echo $count; ?>)</a></li>
            <?php } ?>
          </ul>
        </li>

        <li <? if($g_page_heading == 'Manual Transaction') echo 'class="active"'; ?>><a href="#">Manual Transaction</a>
          <ul>
            <li <? if($g_section_heading == 'Charge Credit Card') echo 'class="active"'; ?>><a href="manual_charge.php" onclick="navigate(this.href);">Charge Credit Card</a></li>
            <li <? if($g_section_heading == 'Manual Transactions') echo 'class="active"'; ?>><a href="orders.php?order_type=manual" onclick="navigate(this.href);">Manual Transactions</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</div>
