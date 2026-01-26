<?php
include('includes/open_con.php');

if(isset($req_reference_number))
{
  $db->Execute("UPDATE ".DB_TABLE_PREFIX."orders SET reference_number = '{$req_reference_number}', cc_number = '{$req_card_number}', cc_expiry = '{$req_card_expiry_date}', transaction_id = '{$transaction_id}', merchant_message = '{$message}', status = '1' WHERE session_id = '". session_id() ."'");
  $order = $db->GetRow("SELECT * FROM ".DB_TABLE_PREFIX."orders WHERE session_id = '". session_id() ."'");
  if($order['id'] != '')
  {
    session_regenerate_id(true);
    $msg = urlencode('Payment processed successfully, the Transaction ID is <strong>'.$order['transaction_id'].'</strong> and Reference Number is <strong>'.$order['reference_number'].'</strong>');
    redirect('secure/cms/orders_detail.php?id='. $order['id'] .'&order_type=manual&msg='.$msg);
  }
  else
  {
    $msg = urlencode('There was error processing your transaction, here are order details: '.$message);
    redirect('secure/cms/orders.php?order_type=manual&cs=er&msg='.$msg);
  }
}
else
{
  $msg = urlencode('Unexpected error occurred, please try again later.');
  redirect('secure/cms/orders.php?order_type=manual&cs=er&msg='.$msg);
}