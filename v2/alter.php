<?php
include('includes/open_con.php');
$db->debug = 1;

$db->Execute("ALTER TABLE `hh_rooms`
ADD COLUMN `price_pk` FLOAT UNSIGNED NULL DEFAULT NULL AFTER `price`;");


$db->Execute("INSERT INTO `hh_web_config` (`key_name`, `key_value`, `detail`, `c_type`) VALUES ('USD_RATE', '130', 'PKR to USD Rate to Calculate PK Rate', 'varchar');");
