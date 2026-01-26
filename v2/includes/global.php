<?
define('DB_TABLE_PREFIX',	'hh_');

$rs_global = $db->Execute("select key_name, key_value from ".DB_TABLE_PREFIX."web_config order by id asc");

while(!$rs_global->EOF)
{
	define($rs_global->fields('key_name'), $rs_global->fields('key_value'));
	$rs_global->MoveNext();
}	$rs_global->Close();

define('ADMIN_FOOTER_NOTE', '&copy; '. COMPANY_NAME .' '.date('Y').', all rights reserved.');

define('HMAC_SHA256', 'sha256');
//define('SECRET_KEY', '05cdadc8d9324af9aca8d9e852e011eebded8dd50bf74752950f8c9f9cca2c25e395c60658264708b8bdef8282351b02f9bc2015d75c4903a6a16f616fb190eab0d1bd2617f84a62856e057852dc130b6db2ac7b15e04403aeaa9e924a1cf6e05dbf8c019e914fec8135a8362f6afda9350eb98b41294a0bb244ffdfdc7bf992');
//define('ACCESS_KEY', '2b311590233e3fcf89a1159589e4325e');
//define('PROFILE_ID', '1B30E861-00B4-4190-9FA1-C11915804FEE');
define('SECRET_KEY', '4e403fe318b547bba0f9d06b23f5cf66e9ec8a2706894bc3a04f9433978cf585bf15712c49874f0ba11f3dadd287e28159d9e1c33fd043d187bd2bc881dff7427311c339e38646ce90ec2d04ffbd0cd3957bf38ff684478fafbfe6298dbb196c423419b25a764492bbe78bc009909b57a9e5c477e5084f84a7a144759f540649');
define('ACCESS_KEY', 'a92a371963e93896aae3523c345e6bc0');
define('PROFILE_ID', '819F8F26-A191-4141-A664-B1DCCEDEF42E');

$G_IMG_EXTS = array('.jpg','.jpeg','.png','.gif');
$G_DOC_EXTS = array('.jpg','.jpeg','.png','.gif', '.pdf');


$G_TITLE = array(
				1 => 'Mr.',
				2 => 'Ms.',
				3 => 'Mrs.',
				4 => 'Dr.',
				5 => 'Prof.'
				);

$G_MONTHS = array(
						'01' 	=> 'January',
						'02' 	=> 'February',
						'03' 	=> 'March',
						'04' 	=> 'April',
						'05' 	=> 'May',
						'06' 	=> 'June',
						'07' 	=> 'July',
						'08' 	=> 'August',
						'09' 	=> 'September',
						'10' 	=> 'October',
						'11' 	=> 'November',
						'12' 	=> 'December'
						);

$G_WEEK_DAYS = array(
						1 => 'Monday',
						2 => 'Tuesday',
						3 => 'Wednesday',
						4 => 'Thursday',
						5 => 'Friday',
						6 => 'Saturday',
						7 => 'Sunday'
						);				

$ORDER_STATUSES = array(
                        0 => 'Unprocessed',
                        1 => 'Pending',
                        2 => 'In Progress',
                        3 => 'Confirmed',
                        4 => 'Cancelled',

                        );

$G_MAIL_SETTINGS = array(
                        'SERVER' => 'mail.heavenhotel.com.pk',
                        'USERNAME' => 'reservations@heavenhotel.com.pk',
                        'PASSWORD' => 'BgJRw]-R]6rr'
                        );

$G_SERVICES = array(
							1 => 'Reception desk open 24 hours a day',
							2 => 'The hotel has a no smoking policy',
							3 => 'PC + internet in the lobby',
							4 => 'Wi-Fi',
							5 => 'Coeliac catering (necessary to order in advance)',
							6 => 'Library',
							7 => 'DVD rental',
							8 => 'Fire alarm',
							9 => 'Wheelchair access',
							10 => 'Ironing board and iron available',
							11 => 'Telephone alarm',
							12 => 'Board games',
							13 => 'Pets are not allowed',
							14 => 'Baby cot – necessary to reserve in advance',
							15 => 'Training congress centre',
							16 => 'Babysitting',
							17 => 'Lobby bar',
							18 => 'Transfers arranged',
							19 => 'Laundry service',
							20 => 'Additional beds can be placed in the apartments',
							21 => 'Fruit basket (necessary to order in advance)',
							22 => 'Chocolates / Sweets (necessary to order in advance)',
							23 => 'Flowers in the room (necessary to order in advance)',
							24 => 'Upgrade to a higher room standard',
							25 => 'Guarded garages available for a fee of 20 EUR',
							26 => 'Car bearing capacity up to 2.5 tons',
							27 => 'Car height up to 1.9 metres excluding roof rack and antenna',
							28 => 'Car height up to 1.5 metres excluding roof rack and antenna',
							29 => 'Car lenght up to 5 metres and maximum car width 2 metres',
							30 => 'A parking space needs to be ordered and reserved in advance',
							31 => 'No parking for motorbikes',
							32 => 'Bathroom with shower and hairdryer (standard rooms)',
							33 => 'Bathroom with bath tub and hairdryer (apartments)',
							34 => 'Minibar',
							35 => 'Direct dial phone',
							36 => 'Healthy mattress (magniflex)',
							37 => 'Safe deposit box',
							38 => 'Air-conditioning',
							39 => 'Sat television with DVD',
							40 => 'Wifi and cable internet',
							41 => 'Fire and smoke detectors',
							42 => 'Tea and coffee making facilities',
							43 => 'Living-rooms (apartments)',
							44 => 'Dressing gown',
							45 => 'Hygiene accessories',
							46 => 'Slippers (on request)'
						);


$ip = $_SERVER['REMOTE_ADDR'];			
if($_SESSION['ses_visitor_country'] == '')
{
	$json = file_get_contents($url = 'http://api.ipstack.com/'. $ip .'?access_key=d78b5a65779b26958a9a2bb712284bd9');
	$json = json_decode($json, true);
	$_SESSION['ses_visitor_country'] = $json['country_code'];
}			