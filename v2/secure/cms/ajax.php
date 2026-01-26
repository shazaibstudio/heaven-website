<?
include('../../includes/open_con.php'); 

if($cmd == 'fetch_models')
{
	echo fetch_models($make_id);
	exit;
}

if($cmd == 'auto_cmp_emails')
{
	$rs = $db->Execute("select name, subject from ".DB_TABLE_PREFIX."email_notifications where (name like '%$value%' or subject like '%$value%') order by name asc");
	
	while(!$rs->EOF)
	{
		$names[] = array('value' => stripslashes($rs->fields('name')), 'display' => stripslashes($rs->fields('name').' &diams;&diams;&diams; '.$rs->fields('subject')));
		$rs->MoveNext();
	}	$rs->Close();
	
	echo json_encode($names);
	exit;
}

if($cmd == 'gen_seo')
{
	$name = str_replace('&','and',urldecode($name));
	$seo_name_org = $seo_name = generate_file_name($name,'-');
	$loop = true;
	
	if($action != 'add')
		$sql_id = " and id != '$id' ";
	
	$inc = 0;		
	do
	{
		$inc++;
		$check = $db->GetOne("select id from ".DB_TABLE_PREFIX.$table." where slug = '$seo_name' $sql_id");
		if($check != '')
			$seo_name = $seo_name_org . $inc;
		else
			$loop = false;
		
	} while($loop);
	
	echo $seo_name;
	exit;
}