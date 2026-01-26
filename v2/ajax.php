<?php
include('includes/open_con.php');

if($cmd == 'states')
{
	$states = $db->Execute("SELECT s.name, s.abbrev 
				FROM  ".DB_TABLE_PREFIX."states s,  ".DB_TABLE_PREFIX."countries c
				WHERE s.country_id = c.id
				AND c.iso_code_2 = '{$country}'
				ORDER BY name ASC ");
	echo '<select class="form-control text" name="bill_to_address_state" id="bill_to_address_state">';
	while(!$states->EOF)
	{
		echo '<option value="'. $states->fields('abbrev') .'">'. $states->fields('name') .'</option>';
		$states->MoveNext();
	} $states->Close();
	echo '</select>';
}