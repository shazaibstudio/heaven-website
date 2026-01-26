<?
include('../../includes/open_con.php'); 
include('includes/inc.session_check.php');

$row = $db->GetRow("select * from ".DB_TABLE_PREFIX."orders where id = '".get('id')."'");
foreach($row as $k => $v)
{
    if($v == '')
        $$k = 'N/A';
    else
        $$k = stripslashes($v);

    $order_id = get('id');
}

if(isset($cmd) && $cmd == 'update_status')
{
    $errors = '';
    if($status == '')
        $errors .= '- Please select status for this reservation.<br />';
    if($subject == '')
        $errors .= '- Please enter subject to update reservation.<br />';
    if(trim(strip_tags($message)) == '')
        $errors .= '- Please enter message to update reservation.<br />';

    if($errors == '')
    {
        $sql = "INSERT INTO ".DB_TABLE_PREFIX."orders_status SET
                  order_id = '$id',
                  status = '$status',
                  subject = ".$db->qstr($subject).",
                  message = ".$db->qstr($message).",
                  notify = '$notify',
                  date_added = '".date('Y-m-d H:i:s')."'
                ";
        $db->Execute($sql);

        if($notify == 'Y')
        {
            $email_cl = 'Dear '. $order['bl_first_name'] . ' ' . $order['bl_last_name'] .',<br><br>Following is the update on your reservation with Heaven Hotel:<br><br>';
            $email_cl .= '
                              <table width="100%" cellpadding="6" border="0" style="font-family: verdana,sans-serif; font-size;12px; border:solid 1px #CCC;border-collapse:collapse;">
                                <tr>
                                  <td width="35%" style="border:solid 1px #CCC;">Subject: </td>
                                  <td width="65%" style="border:solid 1px #CCC;">'. $subject .'</td>
                                </tr>
                                <tr>
                                  <td style="border:solid 1px #CCC;">Message: </td>
                                  <td style="border:solid 1px #CCC;">'. $message .'</td>
                                </tr>
                                <tr>
                                  <td style="border:solid 1px #CCC;">Status: </td>
                                  <td style="border:solid 1px #CCC;">'. $ORDER_STATUSES[$status] .'</td>
                                </tr>
                              </table>';
            $email_cl .= '<br><br>Thank you for choosing Heaven Hotel.<br><br>--<br>Best Regards,<br>Heaven Hotel Team.';

            $email_cl = '<div style="font-family: verdana,sans-serif; font-size;12px; ">'.$email_cl.'</div>';

            include('../../mailer/class.phpmailer.php');

            $mail             = new PHPMailer();

            $mail->IsSMTP();
            $mail->Host       = $G_MAIL_SETTINGS['SERVER'];

            $mail->Username   = $G_MAIL_SETTINGS['USERNAME'];
            $mail->Password   = $G_MAIL_SETTINGS['PASSWORD'];

            $mail->AddReplyTo("no-reply@heavenhotel.com.pk","No Reply");

            $mail->From       = "reservations@heavenhotel.com.pk";
            $mail->FromName   = "Reservations";

            $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
            $mail->WordWrap   = 50; // set word wrap

            $mail->IsHTML(true); // send as HTML

            $mail->AddAddress($order['bl_email'], $order['bl_first_name'].' '.$order['bl_last_name']);
            $mail->Subject    = 'Your Reservation Update at '.COMPANY_NAME;
            $mail->MsgHTML($email_cl);

            $mail->Send();
        }

        redirect('orders_detail.php?id='.$id.'&msg='.urlencode('Order status updated successfully.'));
    }
}

if($order_type == 'reservation')
{
  $g_page_heading = 'Manage Orders';
  $g_section_heading = $ORDER_STATUSES[$os].' Orders';
}
elseif($order_type == 'pay-later')
{
  $g_page_heading = 'Manage Pay Later Orders';
  $g_section_heading = $ORDER_STATUSES[$os].' Orders';
}
elseif($order_type == 'manual')
{
  $g_page_heading = 'Manual Transaction';
  $g_section_heading = 'Manual Transactions';
}

$g_page_title = $g_section_heading.' - '.$g_page_heading;
#$add_link = array('caption' => 'Add Subscriber', 'link' => 'subscribers_add.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- InstanceBegin template="/Templates/cms_template.dwt.php" codeOutsideHTMLIsLocked="false" -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8">
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="description"  content=""/>
<meta name="keywords" content=""/>
<meta name="robots" content="ALL,FOLLOW"/>
<meta name="Author" content="AIT"/>
<meta http-equiv="imagetoolbar" content="no"/>
<!-- InstanceBeginEditable name="doctitle" -->
<title>
<?=print_admin_title($g_page_title);?>
</title>
<!-- InstanceEndEditable -->
<link rel="stylesheet" href="css/reset.css" type="text/css"/>
<link rel="stylesheet" href="css/screen.css" type="text/css"/>
<link rel="stylesheet" href="css/jquery.ui.css" type="text/css"/>
<!--[if IE 7]>
	<link rel="stylesheet" type="text/css" href="css/ie7.css" />
<![endif]-->
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.datatables.js"></script>
<script type="text/javascript" src="js/jquery.jeditable.js"></script>
<script type="text/javascript" src="js/jquery.ui.js"></script>
<script type="text/javascript" src="js/excanvas.js"></script>
<script type="text/javascript" src="js/cufon.js"></script>
<script type="text/javascript" src="js/Geometr231_Hv_BT_400.font.js"></script>
<script type="text/javascript" src="js/script.js"></script>
<link rel="stylesheet" href="css/thickbox.css" type="text/css" />
<script type="text/javascript" language="javascript" src="js/thickbox.js"></script>
</head>

<body>
<div class="clear">
  <? include('includes/inc.menu.php'); ?>
  <div class="main"> <!-- *** mainpage layout *** -->
    <div class="main-wrap">
      <? include('includes/inc.header.php'); ?>
      <div class="page clear">
        <? include('includes/inc.section_header.php'); ?>
        
        <!-- CONTENT BOXES -->
        <div class="content-box">
          <div class="box-header clear">
            <h2>
              <?=$g_section_heading;?>
            </h2>
          </div>
          <div class="box-body clear"> 
            <!-- CONTENT --> 
            <!-- InstanceBeginEditable name="txt" --> 

              <table width="100%"  border="0" cellpadding="2" cellspacing="1" class="one_px_bdr">
                <tr>
                  <td class="data_row" width="25%">Name: </td>
                  <td class="td_bdr" width="75%"><?=$bl_first_name. ' ' .$bl_last_name;?></td>
                </tr>
                <tr>
                  <td valign="top" class="data_row">Email:</td>
                  <td class="td_bdr"><?=$bl_email;?></td>
                </tr>
                <tr>
                  <td valign="top" class="data_row">Phone:</td>
                  <td class="td_bdr"><?=$bl_phone;?></td>
                </tr>
                <tr>
                  <td valign="top" class="data_row">Address:</td>
                  <td class="td_bdr"><?=$bl_address;?></td>
                </tr>
                <tr>
                  <td valign="top" class="data_row">City:</td>
                  <td class="td_bdr"><?=$bl_city;?></td>
                </tr>
                <tr>
                  <td valign="top" class="data_row">Zip:</td>
                  <td class="td_bdr"><?=$bl_zip;?></td>
                </tr>
                <tr>
                  <td valign="top" class="data_row">Country:</td>
                  <td class="td_bdr"><?=$bl_country;?></td>
                </tr>
                <?php if($bl_state != '') { ?>
                <tr>
                  <td valign="top" class="data_row">State:</td>
                  <td class="td_bdr"><?=$bl_state;?></td>
                </tr>
                <?php } ?>
                <tr>
                  <td colspan="2" class="td_heading"><strong>Merchant Related Details</strong></td>
                </tr>
                <tr>
                  <td class="data_row">CC Number: </td>
                  <td class="td_bdr"><?=$cc_number;?>
                  </td>
                </tr>
                <tr>
                  <td class="data_row">CC Expiry:</td>
                  <td class="td_bdr"><?=$cc_expiry;?></td>
                </tr>
                <tr>
                  <td class="data_row">Transaction ID: </td>
                  <td class="td_bdr"><?=$transaction_id;?></td>
                </tr>
                <tr>
                  <td class="data_row">Reference Number: </td>
                  <td class="td_bdr"><?=$reference_number;?></td>
                </tr>
                <tr>
                  <td class="data_row">Merchant Response Number: </td>
                  <td class="td_bdr"><?=$merchant_message;?></td>
                </tr>
                <tr>
                  <td class="data_row">IP Address: </td>
                  <td class="td_bdr"><?=$customer_ip;?></td>
                </tr>
                <tr>
                  <td colspan="2" class="td_heading"><strong>Order Basic Details</strong></td>
                </tr>
                <tr>
                  <td valign="top" class="data_row">Order Date: </td>
                  <td class="td_bdr"><?=date('M d, Y H:i:s', strtotime($order_date));?></td>
                </tr>
                <tr>
                  <td valign="top" class="data_row">Amount: </td>
                  <td class="td_bdr">$<?=number_format($amount, 2);?></td>
                </tr>
                <tr>
                  <td valign="top" class="data_row">Notes: </td>
                  <td class="td_bdr"><?=stripslashes(nl2br($notes));?></td>
                </tr>
              </table>

              <?php if($order_type != 'manual') { ?>

              <table class="table table-striped">
                <thead>
                <tr>
                  <th width="55%">Reservation Detail</th>
                  <th width="15%" class="text-center">Price</th>
                  <th width="15%" class="text-center">Nights</th>
                  <th width="15%" class="text-center">Total</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $cart = $db->Execute("SELECT * FROM ".DB_TABLE_PREFIX."orders_rooms WHERE order_id = '{$order_id}'");
                $index = 0;
                $sub_total = 0;
                while(!$cart->EOF)
                {
//                  $room = $db->GetRow("SELECT * FROM ".DB_TABLE_PREFIX."rooms WHERE id = '". $cart['room_id'] ."'");
                  $nights = $cart->fields('nights');
                  $total = $cart->fields('price') * $nights;
                  ?>
                  <tr>
                    <td>
                      <div class="media">
                        <div class="media-body">
                          <h4 class="media-heading"><?php echo $cart->fields('room_name'); ?></h4>
                          <h5 class="media-heading">Checkin: <?php echo date('M d, Y', strtotime($cart->fields('checkin_date'))); ?></h5>
                          <h5 class="media-heading">Checkout: <?php echo date('M d, Y', strtotime($cart->fields('checkout_date'))); ?></h5>
                          <span>
                                  <?php
                                  echo 'Adults: '.$cart->fields('adults');
                                  if($cart->fields('children') != '' && $cart->fields('children') > 0)
                                  {
                                    echo ', Children: '.$cart->fields('children');
                                  }
                                  ?>

                                </span>
                        </div>
                      </div></td>
                    <td class="text-center"><strong><?php echo '$'.$cart->fields('price'); ?></strong></td>
                    <td class="text-center"><?php echo $nights; ?></td>
                    <td class="text-center"><strong><?php echo '$'.$total; ?></strong></td>
                  </tr>
                  <?
                  $sub_total += $total;
                  $cart->MoveNext();
                } $cart->Close();
                ?>
                <tr>
                  <td>   </td>
                  <td>   </td>
                  <td><h5>Subtotal</h5></td>
                  <td class="text-right"><h5><strong><?php echo '$'.$sub_total;?></strong></h5></td>
                </tr>
                <tr>
                  <td>   </td>
                  <td>   </td>
                  <td><h5>Tax</h5></td>
                  <td class="text-right"><h5><strong>$0</strong></h5></td>
                </tr>
                <tr>
                  <td>   </td>
                  <td>   </td>
                  <td><h3>Total</h3></td>
                  <td class="text-right"><h3><strong><?php echo '$'.$sub_total;?></strong></h3></td>
                </tr>

                </tbody>
              </table>

              <h2>Reservation Status Updates</h2>

              <?php
              $statuses = $db->Execute("SELECT * FROM ".DB_TABLE_PREFIX."orders_status WHERE order_id = '$id' ORDER BY id ASC");
              if($statuses->RecordCount() > 0)
              {
                ?>

                  <table class="table table-striped">
                      <thead>
                      <tr>
                          <th width="25%">Subject</th>
                          <th width="50%" class="text-center">Message</th>
                          <th width="15%" class="text-center">Date Sent</th>
                          <th width="10%" class="text-center">Customer Notified</th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                      while(!$statuses->EOF)
                      {
                          ?>
                          <tr>
                              <td><?php echo stripslashes($statuses->fields('subject')); ?></td>
                              <td><?php echo stripslashes($statuses->fields('message')); ?></td>
                              <td><?php echo date('M d, Y H:i:s', strtotime($statuses->fields('date_added'))); ?></td>
                              <td><?php if($statuses->fields('notify') == 'Y') echo 'Yes'; else echo 'No'; ?></td>
                          </tr>
                          <?
                          $statuses->MoveNext();
                      } $statuses->Close();
                      ?>
                      </tbody>
                  </table>

                  <?
              }
              else echo '<strong>Sorry!</strong>, no status updates found.';
              ?>





              <h2>Update Reservation Status</h2>
            <form method="post" action="">
              <table class="table table-striped">
                <tr>
                  <td width="25%" align="left" class="data_row">Status:  * </td>
                  <td width="75%" align="left">

                    <select name="o_status" id="o_status">
                      <option value="">Please Select ...</option>
                      <?php
                        if(!isset($o_status)) $o_status = $status;
                        foreach($ORDER_STATUSES as $k => $v)
                        {
                            if($o_status == $k) $sl = 'selected="selected"'; else $sl = '';
                            ?>

                              <option value="<?php echo $k; ?>" <?php echo $sl; ?>><?php echo $v; ?></option>

                            <?

                        }
                      ?>
                    </select>

                  </td>
                  </tr>
                  <tr>
                      <td align="left" class="data_row">Subject:  * </td>
                      <td align="left"><input name="subject" type="text" class="text" id="subject" size="50" maxlength="128" value="<?=$subject?>" /></td>
                  </tr>
                  <tr>
                    <td align="left" class="data_row">Message:  * </td>
                    <td align="left">
                        <? include('tiny_mce_config.php'); ?>
                        <textarea name="message" cols="60" rows="8" class="text mce" id="message"><?=$message?></textarea>
                    </td>
                  </tr>
                  <tr>
                    <td align="left" class="data_row">Notify Customer: </td>
                    <td align="left">

                        <label>
                            <input type="radio" name="notify" id="notify" value="Y" <? if($notify == '' || $notify == 'Y') echo 'checked="checked"'; ?> />
                            Yes</label>
                        <label>
                            <input type="radio" name="notify" id="notify" value="N" <? if($notify == 'N') echo 'checked="checked"'; ?> />
                            No</label>
                    </td>
                </tr>
                  <tr>
                      <td align="left" class="data_row"><input type="hidden" name="id" id="id" value="<?php echo $id; ?>" /><input type="hidden" name="cmd" value="update_status" /> </td>
                      <td align="left"><input type="submit" value="Submit" class="submit" /></td>
                  </tr>
              </table>
            </form>

            <? } ?>


              <input name="Button" type="button" class="submit" value="&laquo; Back" onclick="history.back();" />
            
            <!-- InstanceEndEditable --> 
            
            <!-- CONTENT --> 
            
            <!-- Custom Forms --><!-- /#forms --> 
          </div>
          <!-- end of box-body --> 
        </div>
        <!-- end of content-box --><!-- end of content-box --><!-- end of content-box --><!-- /.content-box --><!-- /.clear --><!-- end of content-box --><!-- end of content-box --></div>
      <!-- end of page -->
      
      <? include('includes/inc.footer.php'); ?>
    </div>
  </div>
</div>
</body>
<!-- InstanceEnd -->
</html>
