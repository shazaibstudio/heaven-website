<?
include('../../includes/open_con.php');

$order_info = $db->GetRow("select c.title, c.first_name, c.last_name, c.email, c.username, c.password, o.* from ".DB_TABLE_PREFIX."customers c, ".DB_TABLE_PREFIX."orders o where o.id = '$order_id' and o.customer_id = c.id");

if($save == 'yes')
{
	if($rpp_price == '')
		$errors .= '- Please enter plate price.<br />';
	elseif(!is_numeric($rpp_price))
		$errors .= '- Please enter only numeric value for plate price.<br />';
	
	if($order_info['request_artwork'] == 'Y')
	{
		$ops = $db->Execute("select id, product_name from ".DB_TABLE_PREFIX."orders_products where in_order = 'Y' and order_id = '$order_id' order by id asc");
		while(!$ops->EOF)
		{
			$op_id = $ops->fields('id');
			
			$param = 'ap_'.$op_id;
			
			if($_FILES[$param]['tmp_name'] == '')
				$errors .= '- Please upload artwork proof for '. stripslashes($ops->fields('product_name')) .'.<br />';
			else
			{
				$ext = strtolower(strrchr($_FILES[$param]['name'], '.'));
				if($ext != '.pdf')
					$errors .= '- Please upload only PDF files for '. stripslashes($ops->fields('product_name')) .'.<br />';
			}
			
			$ops->MoveNext();
		}	$ops->Close();
	}
			
	if($errors == '')
	{
		$msg = urlencode('Plate prices updated successfully.');
		$email_id = 22;
		if($order_info['request_artwork'] == 'Y')
		{
			$email_id = 24;
			$ops = $db->Execute("select id, product_name from ".DB_TABLE_PREFIX."orders_products where in_order = 'Y' and order_id = '$order_id' order by id asc");
			while(!$ops->EOF)
			{
				$op_id = $ops->fields('id');
				
				$param = 'ap_'.$op_id;
				
				$file_name = time().'_'.generate_file_name($_FILES[$param]['name']);
				
				copy($_FILES[$param]['tmp_name'], '../../up_data/artwork_proofs/'.$file_name);
				
				$db->Execute("update ".DB_TABLE_PREFIX."orders_products set artwork_proof = '$file_name' where id = '$op_id'");
				
				$ops->MoveNext();
			}	$ops->Close();
		
			$ext_sql = " , artwork_proof_sent = 'Y' ";
			$msg = urlencode('Plate prices and artwork proofs uploaded successfully.');
		}
		
		$grand_total = $order_info['grand_total'] + $rpp_price;
		$sql = "update ".DB_TABLE_PREFIX."orders set rpp_price = '$rpp_price', grand_total = '$grand_total', rpp_replied = 'Y', rpp_replied_date = now() $ext_sql where id = '$order_id'";
		$db->Execute($sql);
		customer_rpp_notice($order_id);
		redirect("orders_detail_rpp.php?id=$id&order_id=$order_id&msg=$msg");
	}
}
elseif($order_info['rpp_price'] > 0) $rpp_price = $order_info['rpp_price'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Plate Price</title>
<link href="css/cc_checks.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="js/jquery.js"></script>
</head>

<body>
<h1>Search for E-mail Notification Template</h1>
<script type='text/javascript' src='js/jquery.metadata.js'></script> 
<script type='text/javascript' src='js/jquery.auto-complete.min.js'></script>
<link rel='stylesheet' type='text/css' href='css/jquery.auto-complete.css' />
<script language="javascript">
            	jQuery(function($){
					$('.autoCmp').autoComplete({
						ajax: 'ajax.php',
						postData: {
							cmd: 'auto_cmp_emails'
						},
						postFormat: function(event, ui){
							// Add the current timestamp to each request
							ui.data.requestTimestamp = (new Date()).getTime();
				
							// Return the data object to be passed with the ajax function
							return ui.data;
						}
					});
				});
            </script>
<form id="form1" method="post" action="">
  <table width="100%" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <td colspan="2" height="26">Please enter your search keywords to search for e-mail notificaiton templates.</td>
    </tr>
    <tr>
      <td width="26%" height="26">Search Keywords:</td>
      <td width="74%"><input name="keywords" type="text" id="keywords" value="<?=stripslashes($keywords);?>" style="width:395px;" class="text autoCmp" /></td>
    </tr>
  </table>
</form>
</body>
</html>