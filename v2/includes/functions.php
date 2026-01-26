<?
/// Start Other Functions

function get_price($price, $price_pk)
{
	if(get_session('ses_visitor_country') == 'PK')
		$price = 'PKR ' . number_format($price_pk * USD_RATE);
	else 
		$price = '$ ' . number_format($price);

	return $price;
}

function sign ($params) {
  return signData(buildDataToSign($params), SECRET_KEY);
}

function signData($data, $secretKey) {
    return base64_encode(hash_hmac('sha256', $data, $secretKey, true));
}

function buildDataToSign($params) {
        $signedFieldNames = explode(",",$params["signed_field_names"]);
        foreach ($signedFieldNames as $field) {
           $dataToSign[] = $field . "=" . $params[$field];
        }
        return commaSeparate($dataToSign);
}

function commaSeparate ($dataToSign) {
    return implode(",",$dataToSign);
}

function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' )
{
    $datetime1 = date_create($date_1);
    $datetime2 = date_create($date_2);
    
    $interval = date_diff($datetime1, $datetime2);
    
    return $interval->format($differenceFormat);
    
}

function fetch_models($make_id, $model_id = '')
{
	global $db;
	
	$str = '<select name="model_id" id="model_id">
            	<option value="">Please Select ...</option>';
	
	$models = $db->Execute("SELECT id, name FROM ".DB_TABLE_PREFIX."models WHERE make_id = '$make_id' ORDER BY name ASC");
	while(!$models->EOF)
	{
		if($model_id == $models->fields('id')) $sl = 'selected="selected"';
		else $sl = '';
		
		$str .= '<option value="'. $models->fields('id') .'" '.$sl.'>'. stripslashes($models->fields('name')) .'</option>';
	
		$models->MoveNext();	
	}	$models->Close();	
	
	$str .= '</select>';
	
	return $str;
}

function print_a($array)
{
	echo '<pre>'.print_r($array, true).'<pre>';
}

function array_sort($a, $subkey, $order = 'asc') 
{
	foreach($a as $k=>$v) 
	{
		$b[$k] = strtolower($v[$subkey]);
	}
	
	asort($b);
	
	foreach($b as $key=>$val) 
	{
		$c[] = $a[$key];
	}
	
	if($order == 'desc')
		$c = array_reverse($c);
	
	return $c;
}

function time_diff($start_time_for_conversion, $end_time_for_conversion = '')
{
	#$start_time_for_conversion = strtotime('2012-07-31 14:26:23');;
    #$end_time_for_conversion = time();
   
    if($end_time_for_conversion == '')
		$end_time_for_conversion = time();
   
    $difference_of_times = $end_time_for_conversion - $start_time_for_conversion;
   
    $time_difference_string = "";
   
    for($i_make_time = 6; $i_make_time > 0; $i_make_time--)
    {
        switch($i_make_time)
        {
                // Handle Minutes
                // ........................
               
            case '1';
                $unit_title = "Minutes";
                $unit_size = 60;
                break;
               
                // Handle Hours
                // ........................
               
            case '2';
                $unit_title = "Hours";
                $unit_size = 3600;
                break;
               
                // Handle Days
                // ........................
               
            case '3';
                $unit_title = "Days";
                $unit_size = 86400;
                break;
               
                // Handle Weeks
                // ........................
               
            case '4';
                $unit_title = "Weeks";
                $unit_size = 604800;
                break;
               
                // Handle Months (31 Days)
                // ........................
               
            case '5';
                $unit_title = "Months";
                $unit_size = 2678400;
                break;
               
                // Handle Years (365 Days)
                // ........................
               
            case '6';
                $unit_title = "Years";
                $unit_size = 31536000;
                break;
        }
   
        if($difference_of_times > ($unit_size - 1))
        {
            $modulus_for_time_difference = $difference_of_times % $unit_size;
            $seconds_for_current_unit = $difference_of_times - $modulus_for_time_difference;
            $units_calculated = $seconds_for_current_unit / $unit_size;
            $difference_of_times = $modulus_for_time_difference;
   
            $time_difference_string .= "$units_calculated $unit_title, ";
        }
    }
   
        // Handle Seconds
        // ........................
	//$time_difference_string .= "$difference_of_times Seconds";
    
	$time_difference_string = substr($time_difference_string, 0, -2);
	
	return $time_difference_string;

}

function pic_thumb($pic, $w = 90, $h = '', $type = 'gallery', $alt = '', $css = '', $tag = true, $from = 'client')
{
	if($type == 'gallery') $dir = 'pictures';
	elseif($type == 'course') $dir = 'courses';
	elseif($type == 'news') $dir = 'news';
	elseif($type == 'banner') $dir = 'banners';
	elseif($type == 'icons') $dir = 'icons';
	
	$path = ROOT_DIR.'up_data/'.$dir.'/'.$pic;
	//exit;
	if($h > 0)
		$hs = 'height='. $h .'&amp;';
	
	#if($from == 'client')
	{
		$path = base64_encode($path);
		$enc = "&enc=yes";
	}
	//$src = '<img src="'. ROOT_DIR .'image.php/picture.jpg?width='. $w .'&amp;'. $hs .'image='. $path .'" alt="'. $alt .'" />';
	if($tag)
		$src = '<img src="'. ROOT_DIR .'image.php/picture.jpg?width='. $w .'&amp;'. $hs .'image='. $path . $enc .'" alt="'. $alt .'" width="'. $w .'" height="'. $h .'" class="'.$css.'" />';
	else
		$src = ROOT_DIR .'image.php/picture.jpg?width='. $w .'&amp;'. $hs .'image='. $path . $enc;
	return $src;
}

function get_avail_info($section)
{
	global $rooms_avail_data;
	
	if($section == 'status')
	{
		$size = $rooms_avail_data['data']['child']['http://v3.hotel.wsapi.ean.com/']['HotelRoomAvailabilityResponse'][0]['attribs']['']['size'];
		if($size > 0)
		{
			$ar = array('status' => 'ok', 'size' => $size);
			return $ar;
		}
		else
		{
			$msg = $rooms_avail_data['data']['child']['http://v3.hotel.wsapi.ean.com/']['HotelRoomAvailabilityResponse'][0]['child']['']['EanWsError'][0]['child']['']['presentationMessage'][0]['data'];
			$error_category = $rooms_avail_data['data']['child']['http://v3.hotel.wsapi.ean.com/']['HotelRoomAvailabilityResponse'][0]['child']['']['EanWsError'][0]['child']['']['category'][0]['data'];
			$ar = array('status' => 'error', 'msg' => $msg, 'error_category' => $error_category);
			return $ar;
		}
	}
	elseif($section == 'check_in_info')
		return $rooms_avail_data['data']['child']['http://v3.hotel.wsapi.ean.com/']['HotelRoomAvailabilityResponse'][0]['child']['']['checkInInstructions'][0]['data'];
	elseif($section == 'rate_key')
		return $rooms_avail_data['data']['child']['http://v3.hotel.wsapi.ean.com/']['HotelRoomAvailabilityResponse'][0]['child']['']['rateKey'][0]['data'];
	elseif($section == 'rooms')
	{
		$size = $rooms_avail_data['data']['child']['http://v3.hotel.wsapi.ean.com/']['HotelRoomAvailabilityResponse'][0]['attribs']['']['size'];
		
		if($size > 0)
		{
			$rooms = array();
			$data = $rooms_avail_data['data']['child']['http://v3.hotel.wsapi.ean.com/']['HotelRoomAvailabilityResponse'][0]['child']['']['HotelRoomResponse'];
			for($i = 0 ; $i < $size ; $i++)
			{
				$room['cancel_policy'] 			= $data[$i]['child']['']['cancellationPolicy'][0]['data'];
				$room['rate_code'] 				= $data[$i]['child']['']['rateCode'][0]['data'];
				$room['room_type_code'] 		= $data[$i]['child']['']['roomTypeCode'][0]['data'];
				$room['rate_description'] 		= $data[$i]['child']['']['rateDescription'][0]['data'];
				$room['room_type_description'] 	= $data[$i]['child']['']['roomTypeDescription'][0]['data'];
				$room['supplier_type'] 			= $data[$i]['child']['']['supplierType'][0]['data'];
				$room['tax_rate'] 				= $data[$i]['child']['']['taxRate'][0]['data'];
				$room['rate_change'] 			= $data[$i]['child']['']['rateChange'][0]['data'];
				$room['non_refundable'] 		= $data[$i]['child']['']['nonRefundable'][0]['data'];
				$room['guarantee_required'] 	= $data[$i]['child']['']['guaranteeRequired'][0]['data'];
				$room['deposit_required'] 		= $data[$i]['child']['']['depositRequired'][0]['data'];
				$room['immediate_charge_required'] 		= $data[$i]['child']['']['immediateChargeRequired'][0]['data'];
				$room['current_allotment'] 		= $data[$i]['child']['']['currentAllotment'][0]['data'];
				$room['property_id'] 			= $data[$i]['child']['']['propertyId'][0]['data'];
				$room['promo_id'] 				= $data[$i]['child']['']['promoId'][0]['data'];
				$room['promo_description'] 		= $data[$i]['child']['']['promoDescription'][0]['data'];
				
				$bt_size 						= sizeof($data[$i]['child']['']['BedTypes'][0]['child']['']['BedType']);
				
				unset($room['bed_types']);
				
				for($bt = 0 ; $bt < $bt_size ; $bt++)
				{
					$bt_data['id'] = $data[$i]['child']['']['BedTypes'][0]['child']['']['BedType'][$bt]['attribs']['']['id'];
					$bt_data['caption'] = $data[$i]['child']['']['BedTypes'][0]['child']['']['BedType'][$bt]['child']['']['description'][0]['data'];
					$room['bed_types'][] = $bt_data;
				}	
				
				#$room['bed_types'] 				= $data[$i]['child']['']['BedTypes'][0]['child']['']['BedType'][0]['child']['']['description'][0]['data'];
				
				
				$room['cancel_version_id']		= $data[$i]['child']['']['CancelPolicyInfoList'][0]['child']['']['CancelPolicyInfo'][0]['child']['']['versionId'][0]['data'];
				$room['cancel_time']			= $data[$i]['child']['']['CancelPolicyInfoList'][0]['child']['']['CancelPolicyInfo'][0]['child']['']['cancelTime'][0]['data'];
				$room['time_zone_description']	= $data[$i]['child']['']['CancelPolicyInfoList'][0]['child']['']['CancelPolicyInfo'][0]['child']['']['timeZoneDescription'][0]['data'];
				$room['smoking_preferences']	= $data[$i]['child']['']['smokingPreferences'][0]['data'];
				$room['rate_occupancy_per_room']= $data[$i]['child']['']['rateOccupancyPerRoom'][0]['data'];
				$room['quoted_occupancy']		= $data[$i]['child']['']['quotedOccupancy'][0]['data'];
				$room['quoted_occupancy']		= $data[$i]['child']['']['quotedOccupancy'][0]['data'];
				
				$room['rate_total']				= $data[$i]['child']['']['RateInfo'][0]['child']['']['ChargeableRateInfo'][0]['attribs']['']['total'];
				$room['rate_surcharge_total']	= $data[$i]['child']['']['RateInfo'][0]['child']['']['ChargeableRateInfo'][0]['attribs']['']['surchargeTotal'];
				$room['rate_nightly_rate_total']= $data[$i]['child']['']['RateInfo'][0]['child']['']['ChargeableRateInfo'][0]['attribs']['']['nightlyRateTotal'];
				$room['rate_max_nightly_rate']	= $data[$i]['child']['']['RateInfo'][0]['child']['']['ChargeableRateInfo'][0]['attribs']['']['maxNightlyRate'];
				$room['rate_average_rate']		= $data[$i]['child']['']['RateInfo'][0]['child']['']['ChargeableRateInfo'][0]['attribs']['']['averageRate'];
				$room['rate_average_base_rate']	= $data[$i]['child']['']['RateInfo'][0]['child']['']['ChargeableRateInfo'][0]['attribs']['']['averageBaseRate'];
				
				$night_size						= $data[$i]['child']['']['RateInfo'][0]['child']['']['ChargeableRateInfo'][0]['child']['']['NightlyRatesPerRoom'][0]['attribs']['']['size'];
				
				$room['no_nights']				= $night_size;
				
				$night_data 					= $data[$i]['child']['']['RateInfo'][0]['child']['']['ChargeableRateInfo'][0]['child']['']['NightlyRatesPerRoom'][0];
				
				$nd = array();
				
				unset($room['nights_data']);
				
				#echo '<h1>'. $night_size .'</h1>';
				
				for($k = 0 ; $k < $night_size ; $k++)
				{
					$nd['promo_night'] 	= $night_data['child']['']['NightlyRate'][$k]['attribs']['']['promo'];
					$nd['rate_night'] 	= $night_data['child']['']['NightlyRate'][$k]['attribs']['']['rate'];
					$nd['base_rate_night']= $night_data['child']['']['NightlyRate'][$k]['attribs']['']['baseRate'];
					$room['nights_data'][] = $nd;
				}				
				
				$surcharges_data 				= $data[$i]['child']['']['RateInfo'][0]['child']['']['ChargeableRateInfo'][0]['child']['']['Surcharges'][0];
				
				$surcharges_size				= $data[$i]['child']['']['RateInfo'][0]['child']['']['ChargeableRateInfo'][0]['child']['']['Surcharges'][0]['attribs']['']['size'];
				
				#$room['no_surcharges']				= $surcharges_size;
				
				$sd = array();
				unset($room['surcharge_data']);
				for($k = 0 ; $k < $surcharges_size ; $k++)
				{
					$sd['surcharge_amount'] 	= $surcharges_data['child']['']['Surcharge'][$k]['attribs']['']['amount'];
					$sd['surcharge_type'] 	= $surcharges_data['child']['']['Surcharge'][$k]['attribs']['']['type'];
					$room['surcharge_data'][] = $sd;
				}				
				
				
				$value_adds_data 				= $data[$i]['child']['']['ValueAdds'][0]['child']['']['ValueAdd'];
				
				$value_adds_size				= sizeof($value_adds_data);
				
				$vd = array();
				unset($room['value_adds']);
				for($k = 0 ; $k < $value_adds_size ; $k++)
				{
					$vd 					= $value_adds_data[$k]['child']['']['description'][0]['data'];
					$room['value_adds'][] 	= $vd;
				}
				
				$room['image']		= $data[$i]['child']['']['RoomImages'][0]['child']['']['RoomImage'][0]['child']['']['url'][0]['data'];
				
				$rooms[] = $room;
			}
		}
		return $rooms;
		#return $rooms_avail_data['data']['child']['http://v3.hotel.wsapi.ean.com/']['HotelRoomAvailabilityResponse'][0]['child']['']['HotelRoomResponse'];
	}
}

function check_room_availability()
{
	global $G_API_CONFIG;
	
	$hotel_id 	= $_POST['hotel_id'];
	$checkin 	= $_POST['checkin'];
	$checkout 	= $_POST['checkout'];
	$rooms 		= $_POST['rooms'];	
	
	$rg = '';
	
	for($i = 1 ; $i <= $rooms ; $i++)
	{
		$ages = array();
		
		for($j = 1 ; $j <= $_POST['children_'.$i] ; $j++)
		{
			$ages[] = $_POST['child_'.$i.'_'.$j]; 
		}
		
		$ages = implode(',', $ages);
		
		$rg .= '<Room><numberOfAdults>'. $_POST['adults_'.$i] .'</numberOfAdults><numberOfChildren>'. $_POST['children_'.$i] .'</numberOfChildren><childAges>'. $ages .'</childAges></Room>';
	}	
		
	$data = 'minorRev=1&cid='. $G_API_CONFIG['CID'] .'&apiKey='. $G_API_CONFIG['KEY'] .'&customerUserAgent='.$_SERVER['HTTP_USER_AGENT'].'&customerIpAddress='.$_SERVER['REMOTE_ADDR'].'&customerSessionId='.session_id().'&locale=en_US&currencyCode=USD&xml=<HotelRoomAvailabilityRequest><hotelId>' . $hotel_id . '</hotelId><arrivalDate>' . $checkin . '</arrivalDate><departureDate>' . $checkout . '</departureDate><numberOfBedRooms>'. $rooms .'</numberOfBedRooms><RoomGroup>'. $rg .'</RoomGroup><includeDetails>true</includeDetails><includeRoomImages>true</includeRoomImages></HotelRoomAvailabilityRequest>';	

	#echo htmlentities( $data );
	#exit;

	define('POSTURL', 'http://api.ean.com/ean-services/rs/hotel/v3/avail');

	define('POSTVARS', $data);  // POST VARIABLES TO BE SENT
	
	$url = POSTURL.'?'.POSTVARS;
	
	require_once('autoloader.php');
 
	// We'll process this feed with all of the default options.
	$feed = new SimplePie();
	 
	// Set which feed to process.
	$feed->set_feed_url($url);
	 
	// Run SimplePie.
	$feed->init();
	 
	// This makes sure that the content is sent to the browser as text/html and the UTF-8 character set (since we didn't change it).
	$feed->handle_content_type();
	
	
	//$feed = json_decode($feed);
	$feed = (array) $feed;
	
	return $feed;
}

function get_hotel_info($section)
{
	global $hotel_info;
	
	if($section == 'name')
		return $hotel_info['data']['child']['http://v3.hotel.wsapi.ean.com/']['HotelInformationResponse'][0]['child']['']['HotelSummary'][0]['child']['']['name'][0]['data'];
	elseif($section == 'address')
		return $hotel_info['data']['child']['http://v3.hotel.wsapi.ean.com/']['HotelInformationResponse'][0]['child']['']['HotelSummary'][0]['child']['']['address1'][0]['data'];
	elseif($section == 'city')
		return $hotel_info['data']['child']['http://v3.hotel.wsapi.ean.com/']['HotelInformationResponse'][0]['child']['']['HotelSummary'][0]['child']['']['city'][0]['data'];
	elseif($section == 'zip_code')
		return $hotel_info['data']['child']['http://v3.hotel.wsapi.ean.com/']['HotelInformationResponse'][0]['child']['']['HotelSummary'][0]['child']['']['postalCode'][0]['data'];
	elseif($section == 'country_code')
		return $hotel_info['data']['child']['http://v3.hotel.wsapi.ean.com/']['HotelInformationResponse'][0]['child']['']['HotelSummary'][0]['child']['']['countryCode'][0]['data'];
	elseif($section == 'rating')
		return $hotel_info['data']['child']['http://v3.hotel.wsapi.ean.com/']['HotelInformationResponse'][0]['child']['']['HotelSummary'][0]['child']['']['hotelRating'][0]['data'];
	elseif($section == 'rating_ta')
		return $hotel_info['data']['child']['http://v3.hotel.wsapi.ean.com/']['HotelInformationResponse'][0]['child']['']['HotelSummary'][0]['child']['']['tripAdvisorRating'][0]['data'];
	elseif($section == 'loc_desc')
		return $hotel_info['data']['child']['http://v3.hotel.wsapi.ean.com/']['HotelInformationResponse'][0]['child']['']['HotelSummary'][0]['child']['']['locationDescription'][0]['data'];
	elseif($section == 'rate_high')
		return $hotel_info['data']['child']['http://v3.hotel.wsapi.ean.com/']['HotelInformationResponse'][0]['child']['']['HotelSummary'][0]['child']['']['highRate'][0]['data'];
	elseif($section == 'rate_low')
		return $hotel_info['data']['child']['http://v3.hotel.wsapi.ean.com/']['HotelInformationResponse'][0]['child']['']['HotelSummary'][0]['child']['']['lowRate'][0]['data'];
	elseif($section == 'latitude')
		return $hotel_info['data']['child']['http://v3.hotel.wsapi.ean.com/']['HotelInformationResponse'][0]['child']['']['HotelSummary'][0]['child']['']['latitude'][0]['data'];
	elseif($section == 'longitude')
		return $hotel_info['data']['child']['http://v3.hotel.wsapi.ean.com/']['HotelInformationResponse'][0]['child']['']['HotelSummary'][0]['child']['']['longitude'][0]['data'];
	elseif($section == 'rooms')
		return $hotel_info['data']['child']['http://v3.hotel.wsapi.ean.com/']['HotelInformationResponse'][0]['child']['']['HotelDetails'][0]['child']['']['numberOfRooms'][0]['data'];
	elseif($section == 'floors')
		return $hotel_info['data']['child']['http://v3.hotel.wsapi.ean.com/']['HotelInformationResponse'][0]['child']['']['HotelDetails'][0]['child']['']['numberOfFloors'][0]['data'];
	elseif($section == 'check_in_time')
		return $hotel_info['data']['child']['http://v3.hotel.wsapi.ean.com/']['HotelInformationResponse'][0]['child']['']['HotelDetails'][0]['child']['']['checkInTime'][0]['data'];
	elseif($section == 'check_out_time')
		return $hotel_info['data']['child']['http://v3.hotel.wsapi.ean.com/']['HotelInformationResponse'][0]['child']['']['HotelDetails'][0]['child']['']['checkOutTime'][0]['data'];
	elseif($section == 'area_info')
		return $hotel_info['data']['child']['http://v3.hotel.wsapi.ean.com/']['HotelInformationResponse'][0]['child']['']['HotelDetails'][0]['child']['']['areaInformation'][0]['data'];
	elseif($section == 'prp_desc')
		return $hotel_info['data']['child']['http://v3.hotel.wsapi.ean.com/']['HotelInformationResponse'][0]['child']['']['HotelDetails'][0]['child']['']['propertyDescription'][0]['data'];
	elseif($section == 'hotel_policy')
		return $hotel_info['data']['child']['http://v3.hotel.wsapi.ean.com/']['HotelInformationResponse'][0]['child']['']['HotelDetails'][0]['child']['']['hotelPolicy'][0]['data'];
	elseif($section == 'room_info')
		return $hotel_info['data']['child']['http://v3.hotel.wsapi.ean.com/']['HotelInformationResponse'][0]['child']['']['HotelDetails'][0]['child']['']['roomInformation'][0]['data'];	
	elseif($section == 'driving_directions')
		return $hotel_info['data']['child']['http://v3.hotel.wsapi.ean.com/']['HotelInformationResponse'][0]['child']['']['HotelDetails'][0]['child']['']['drivingDirections'][0]['data'];	
	elseif($section == 'check_in_instructions')
		return $hotel_info['data']['child']['http://v3.hotel.wsapi.ean.com/']['HotelInformationResponse'][0]['child']['']['HotelDetails'][0]['child']['']['checkInInstructions'][0]['data'];	
	elseif($section == 'amenities')
	{
		$a = $hotel_info['data']['child']['http://v3.hotel.wsapi.ean.com/']['HotelInformationResponse'][0]['child']['']['PropertyAmenities'];
		
		$size = $a[0]['attribs']['']['size'];
		$am = array();
		
		for($i = 0 ; $i < $size ; $i++)
		{
			$am[] = $a[0]['child']['']['PropertyAmenity'][$i]['child']['']['amenity'][0]['data'];
		}
		
		return $am;
	}
	elseif($section == 'images')
	{
		$a = $hotel_info['data']['child']['http://v3.hotel.wsapi.ean.com/']['HotelInformationResponse'][0]['child']['']['HotelImages'];
		
		$size = $a[0]['attribs']['']['size'];
		$im = array();
		
		for($i = 0 ; $i < $size ; $i++)
		{
			$caption 	= $a[0]['child']['']['HotelImage'][$i]['child']['']['caption'][0]['data'];
			$thumbnail 	= $a[0]['child']['']['HotelImage'][$i]['child']['']['thumbnailUrl'][0]['data'];
			$large 		= $a[0]['child']['']['HotelImage'][$i]['child']['']['url'][0]['data'];
			
			$ar = array('caption' => $caption, 'thumbnail' => $thumbnail, 'large' => $large);
			$im[] = $ar;
		}
		
		return $im;
	}
	elseif($section == 'room_types')
	{
		$a = $hotel_info['data']['child']['http://v3.hotel.wsapi.ean.com/']['HotelInformationResponse'][0]['child']['']['RoomTypes'];
		$size = $a[0]['attribs']['']['size'];
		$rm = array();
		
		for($i = 0 ; $i < $size ; $i++)
		{
			$caption 		= $a[0]['child']['']['RoomType'][$i]['child']['']['description'][0]['data'];
			$description 	= $a[0]['child']['']['RoomType'][$i]['child']['']['descriptionLong'][0]['data'];
			
			$room_code 		= $a[0]['child']['']['RoomType'][$i]['attribs']['']['roomCode'];
			$room_type_id	= $a[0]['child']['']['RoomType'][$i]['attribs']['']['roomTypeId'];
			
			$ams_size		= $a[0]['child']['']['RoomType'][$i]['child']['']['roomAmenities'][0]['attribs']['']['size'];
			
			$ams			= array();
			
			$ra 			= $a[0]['child']['']['RoomType'][$i]['child']['']['roomAmenities'][0]['child']['']['RoomAmenity'];
			
			for($j = 0 ; $j < $ams_size ; $j++)
				$ams[] 		= $ra[$j]['child']['']['amenity'][0]['data'];	
			
			$ar = array('caption' => $caption, 'description' => $description, 'room_code' => $room_code, 'room_type_id' => $room_type_id, 'amenities' => $ams);
			
			$rm[] = $ar;
		}
		
		return $rm;
	}	
}

function fetch_hotel_info($hotel_id)
{
	global $G_API_CONFIG;
	
	$data = 'cid='. $G_API_CONFIG['CID'] .'&minorRev=1&apiKey='. $G_API_CONFIG['KEY'] .'&customerSessionId='. session_id() .'&customerUserAgent='. $_SERVER['HTTP_USER_AGENT'] .'&customerIpAddress='. $_SERVER['REMOTE_ADDR'] .'&locale=en_US&currencyCode=USD&xml=<HotelInformationRequest><hotelId>'. $hotel_id .'</hotelId><options>0</options></HotelInformationRequest> ';
	
	define('POSTURL', 'http://api.ean.com/ean-services/rs/hotel/v3/info');
	
	
	define('POSTVARS', $data);  // POST VARIABLES TO BE SENT
	
	$url = POSTURL.'?'.POSTVARS;
	
	require_once('autoloader.php');
 
	// We'll process this feed with all of the default options.
	$feed = new SimplePie();
	 
	// Set which feed to process.
	$feed->set_feed_url($url);
	 
	// Run SimplePie.
	$feed->init();
	 
	// This makes sure that the content is sent to the browser as text/html and the UTF-8 character set (since we didn't change it).
	$feed->handle_content_type();
	
	
	//$feed = json_decode($feed);
	$feed = (array) $feed;
	return $feed;
}

function fetch_city_hotels($city, $country)
{
	global $G_API_CONFIG;
	$data = '
	&cid='. $G_API_CONFIG['CID'] .'&apiKey='. $G_API_CONFIG['KEY'] .'&customerUserAgent='.$_SERVER['HTTP_USER_AGENT'].'&customerIpAddress='.$_SERVER['REMOTE_ADDR'].'
	&locale=en_US&currencyCode=USD
	&xml=
	<HotelListRequest>
	<city>'. $city .'</city>
	<countryCode>'. $country .'</countryCode>
	<supplierCacheTolerance>MED_ENHANCED</supplierCacheTolerance>
	</HotelListRequest>';
	// include GET as well as POST variables; your needs may vary.
	
	define('POSTURL', 'http://api.ean.com/ean-services/rs/hotel/v3/list');

	define('POSTVARS', $data);  // POST VARIABLES TO BE SENT
	
	// INITIALIZE ALL VARS
	$ch = curl_init(POSTURL);
	curl_setopt($ch, CURLOPT_POST      ,1);
	curl_setopt($ch, CURLOPT_POSTFIELDS    ,POSTVARS);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
	curl_setopt($ch, CURLOPT_HEADER      ,0);  // DO NOT RETURN HTTP HEADERS
	curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);  // RETURN THE CONTENTS OF THE CALL
	$response = curl_exec($ch);
	curl_close($ch);
	$response = json_decode($response);
	error_reporting(0);
	$a = $response->HotelListResponse->HotelList;
	$a = (array) $a;
	$no_hotels = $a['@size']; //sizeof($hotel_list);
	$hotel_list = $response->HotelListResponse->HotelList->HotelSummary;
	
	if($no_hotels > 1)
	{
		$rate_low = $hotel_list[0]->lowRate;
		$rate_high = $hotel_list[0]->highRate;
		for($i = 0 ; $i < sizeof($hotel_list) ; $i++)
		{
			if($hotel_list[$i]->lowRate < $rate_low && $hotel_list[$i]->lowRate > 0)
				$rate_low = $hotel_list[$i]->lowRate;
			if($hotel_list[$i]->highRate > $rate_high && $hotel_list[$i]->highRate > 0)
				$rate_high = $hotel_list[$i]->highRate;
		}
	}
	else
	{
		$rate_low = $hotel_list->lowRate;
		$rate_high = $hotel_list->highRate;
		$hotel_list = array($hotel_list);
	}
	
	$enc = json_encode($hotel_list);

	$hotels_file = generate_file_name($country.'_'.$city).'_'.time().'.txt';
	$path = $_SERVER['DOCUMENT_ROOT'].ROOT_DIR.'up_data/cities/'.$hotels_file;
	$fp = fopen($path, 'x+') or die('Error');
	print_r($fp);
	fwrite($fp, $enc);
	fclose($fp);
	
	$ret = array('hotels' => $no_hotels, 'hotels_file' => $hotels_file, 'rate_low' => $rate_low, 'rate_high' => $rate_high);
	
	return $ret;
}

function list_cities($name, $sel = '', $region_id, $ext = '')
{
	global $db;
	$str = '<select name="'. $name .'" id="'. $name .'" '. $ext .'>';
	$str .= '<option value="">Please Select ...</option>';
	$rs = $db->Execute("SELECT id, city_name FROM ".DB_TABLE_PREFIX."cities WHERE region_id = '$region_id' ORDER BY city_name ASC");
	while(!$rs->EOF)
	{
		if($rs->fields('id') == $sel) $sl = 'selected="selected"'; else $sl = '';
		$str .= '<option value="'. $rs->fields('id') .'" '. $sl .'>'. stripslashes($rs->fields('city_name')) .'</option>';
		$rs->MoveNext();	
	}	$rs->Close();
	$str .= '</select>';
	return $str;
}

function list_regions($name, $sel = '', $country_id, $ext = '')
{
	global $db;
	$str = '<select name="'. $name .'" id="'. $name .'" '. $ext .'>';
	$str .= '<option value="">Please Select ...</option>';
	$rs = $db->Execute("SELECT id, region_name FROM ".DB_TABLE_PREFIX."regions WHERE country_id = '$country_id' ORDER BY region_name ASC");
	while(!$rs->EOF)
	{
		if($rs->fields('id') == $sel) $sl = 'selected="selected"'; else $sl = '';
		$str .= '<option value="'. $rs->fields('id') .'" '. $sl .'>'. stripslashes($rs->fields('region_name')) .'</option>';
		$rs->MoveNext();	
	}	$rs->Close();
	$str .= '</select>';
	return $str;
}

function list_countries($name, $sel = '', $ext = '')
{
	global $db;
	$str = '<select name="'. $name .'" id="'. $name .'" '. $ext .'>';
	$str .= '<option value="">Please Select ...</option>';
	$rs = $db->Execute("SELECT id, country_name FROM ".DB_TABLE_PREFIX."countries ORDER BY country_name ASC");
	while(!$rs->EOF)
	{
		if($rs->fields('id') == $sel) $sl = 'selected="selected"'; else $sl = '';
		$str .= '<option value="'. $rs->fields('id') .'" '. $sl .'>'. stripslashes($rs->fields('country_name')) .'</option>';
		$rs->MoveNext();	
	}	$rs->Close();
	$str .= '</select>';
	return $str;
}

function customer_rpp_notice($order_id)
{
	global $db;
	global $G_TITLE;
	global $email_id;
	
	$email_text = $db->GetRow("select subject, email_text, send_email from ".DB_TABLE_PREFIX."email_notifications where id = '$email_id'");
	
	if($email_text['send_email'] == 'Y')
	{
		$cust = $db->GetRow("select c.*, o.gen_id from ".DB_TABLE_PREFIX."customers c, ".DB_TABLE_PREFIX."orders o where o.id = '$order_id' and o.customer_id = c.id");
		
		$oms_link = COMPANY_URL.'customer';
		$oms_link = '<a href="'. $oms_link .'">'. $oms_link .'</a>';
		
		$cust_name = $G_TITLE[$cust['title']].' '.$cust['first_name'].' '.$cust['last_name'];
		
		$subject = str_replace('{ORDER_ID}', $cust['gen_id'], $email_text['subject']);

		$body = str_replace('{ORDER_ID}', $cust['gen_id'], $email_text['email_text']);
		$body = str_replace('{CUSTOMER_NAME}', $cust_name, $body);
		$body = str_replace('{OMS_LINK}', $oms_link, $body);
		$body = str_replace('{COMPANY_NAME}', COMPANY_NAME, $body);
		
		$subject = stripslashes($subject);
		$body = '<div style="font-family:Verdana; font-size:12px;">'. stripslashes($body) .'</div>';	
		
		$email = array($cust['email'], 'farhanasim@gmail.com');
		send_mail($email, $subject, $body);
			
	}
}

function order_rpp_email($assigned_to, $order_gen_id, $cust_name)
{
	global $db;
	global $cmd;
	
	$id = 21;
	if($cmd == 'rppap')
		$id = 22;
		
	$email_text = $db->GetRow("select subject, email_text, send_email from ".DB_TABLE_PREFIX."email_notifications where id = '$id'");
	
	if($email_text['send_email'] == 'Y')
	{
		$oms_link = COMPANY_URL.'secure/oms';
		$oms_link = '<a href="'. $oms_link .'">'. $oms_link .'</a>';
		
		$admin = $db->GetRow("select name, email from ".DB_TABLE_PREFIX."users where id = '1'");
		
		$subject = str_replace('{ORDER_ID}', $order_gen_id, $email_text['subject']);
		$subject = str_replace('{CUSTOMER_NAME}', $cust_name, $subject);

		$body = str_replace('{ADMIN_NAME}', $admin['name'], $email_text['email_text']);
		$body = str_replace('{CUSTOMER_NAME}', $cust_name, $body);
		$body = str_replace('{ORDER_ID}', $order_gen_id, $body);
		
		$body = str_replace('{DATE}', date('M d, Y H:i:s'), $body);
		$body = str_replace('{OMS_ADMIN_LINK}', $oms_link, $body);
		$body = str_replace('{COMPANY_NAME}', COMPANY_NAME, $body);
		
		$subject = stripslashes($subject);
		$body = '<div style="font-family:Verdana; font-size:12px;">'. stripslashes($body) .'</div>';	
		
		$email = array($admin['email'], 'farhanasim@gmail.com');
		
		send_mail($email, $subject, $body);
		
		if($assigned_to > 1)
		{
		
			$staff = $db->GetRow("select name, email from ".DB_TABLE_PREFIX."users where id = '". $assigned_to ."'");
		
			$body = str_replace('{ADMIN_NAME}', $staff['name'], $email_text['email_text']);
			$body = str_replace('{CUSTOMER_NAME}', $cust_name, $body);
			$body = str_replace('{ORDER_ID}', $order_gen_id, $body);
			
			$body = str_replace('{DATE}', date('M d, Y H:i:s'), $body);
			$body = str_replace('{OMS_ADMIN_LINK}', $oms_link, $body);
			$body = str_replace('{COMPANY_NAME}', COMPANY_NAME, $body);
			
			$body = '<div style="font-family:Verdana; font-size:12px;">'. stripslashes($body) .'</div>';	
			
			$email = array($staff['email']);
			
			send_mail($email, $subject, $body);
			
		}
	}
}

function order_artwork_email($assigned_to, $order_gen_id, $cust_name)
{
	global $db;
	
	$email_text = $db->GetRow("select subject, email_text, send_email from ".DB_TABLE_PREFIX."email_notifications where id = '20'");
	
	if($email_text['send_email'] == 'Y')
	{
		$oms_link = COMPANY_URL.'secure/oms';
		$oms_link = '<a href="'. $oms_link .'">'. $oms_link .'</a>';
		
		$admin = $db->GetRow("select name, email from ".DB_TABLE_PREFIX."users where id = '1'");
		
		$subject = str_replace('{ORDER_ID}', $order_gen_id, $email_text['subject']);
		$subject = str_replace('{CUSTOMER_NAME}', $cust_name, $subject);

		$body = str_replace('{ADMIN_NAME}', $admin['name'], $email_text['email_text']);
		$body = str_replace('{CUSTOMER_NAME}', $cust_name, $body);
		$body = str_replace('{ORDER_ID}', $order_gen_id, $body);
		
		$body = str_replace('{DATE}', date('M d, Y H:i:s'), $body);
		$body = str_replace('{OMS_ADMIN_LINK}', $oms_link, $body);
		$body = str_replace('{COMPANY_NAME}', COMPANY_NAME, $body);
		
		$subject = stripslashes($subject);
		$body = '<div style="font-family:Verdana; font-size:12px;">'. stripslashes($body) .'</div>';	
		
		$email = array($admin['email'], 'farhanasim@gmail.com');
		
		send_mail($email, $subject, $body);
		
		if($assigned_to > 1)
		{
		
			$staff = $db->GetRow("select name, email from ".DB_TABLE_PREFIX."users where id = '". $assigned_to ."'");
		
			$body = str_replace('{ADMIN_NAME}', $staff['name'], $email_text['email_text']);
			$body = str_replace('{CUSTOMER_NAME}', $cust_name, $body);
			$body = str_replace('{ORDER_ID}', $order_gen_id, $body);
			
			$body = str_replace('{DATE}', date('M d, Y H:i:s'), $body);
			$body = str_replace('{OMS_ADMIN_LINK}', $oms_link, $body);
			$body = str_replace('{COMPANY_NAME}', COMPANY_NAME, $body);
			
			$body = '<div style="font-family:Verdana; font-size:12px;">'. stripslashes($body) .'</div>';	
			
			$email = array($staff['email']);
			
			send_mail($email, $subject, $body);
			
		}
	}
}

function order_products_menu($order_id, $op_id)
{
	global $db;
	
	if($op_id == '') $dis = 'style="display:none;"';
	else $dis = '';
	
	$str = '
	<select name="op_id" class="txt_input" id="op_id" onChange="if(this.value != \'\') $(\'#sp_link\').show(); else $(\'#sp_link\').hide();">
	  <option value="">Please Select ...</option>';
	  
	  $ops = $db->Execute("select id, product_name from ".DB_TABLE_PREFIX."orders_products where order_id = '$order_id' order by id asc");
	  while(!$ops->EOF)
	  {
		  if($op_id == $ops->fields('id')) $sl = 'selected="selected"'; else $sl = '';
		  $str .= '<option value="'. $ops->fields('id') .'" '. $sl .'>'. stripslashes($ops->fields('product_name')) .'</option>';
		  $ops->MoveNext();
	  }	$ops->Close();
	  
	  $str .= '
	</select>
	<span id="sp_link" '. $dis .'>
	&nbsp;&nbsp;	<a href="javascript:;" onClick="list_artworks();">See list of artworks uploaded for this item.</a>
	</span>
	';
	return $str;
}

function customer_order_supplier_response_email($order_id)
{
	global $db;
	global $G_TITLE;
	
	$email_text = $db->GetRow("select subject, email_text, send_email from ".DB_TABLE_PREFIX."email_notifications where id = '19'");
	
	if($email_text['send_email'] == 'Y')
	{
		$cust = $db->GetRow("select c.*, o.gen_id from ".DB_TABLE_PREFIX."customers c, ".DB_TABLE_PREFIX."orders o where o.id = '$order_id' and o.customer_id = c.id");
		
		$oms_link = COMPANY_URL.'customer';
		$oms_link = '<a href="'. $oms_link .'">'. $oms_link .'</a>';
		
		$cust_name = $G_TITLE[$cust['title']].' '.$cust['first_name'].' '.$cust['last_name'];
		
		$subject = str_replace('{ORDER_ID}', $cust['gen_id'], $email_text['subject']);

		$body = str_replace('{ORDER_ID}', $cust['gen_id'], $email_text['email_text']);
		$body = str_replace('{CUSTOMER_NAME}', $cust_name, $body);
		$body = str_replace('{OMS_LINK}', $oms_link, $body);
		$body = str_replace('{COMPANY_NAME}', COMPANY_NAME, $body);
		
		$subject = stripslashes($subject);
		$body = '<div style="font-family:Verdana; font-size:12px;">'. stripslashes($body) .'</div>';	
		
		$email = array($cust['email'], 'farhanasim@gmail.com');
		send_mail($email, $subject, $body);
			
	}
}

function order_edit_email($assigned_to, $order_gen_id, $cust_name)
{
	global $db;
	
	$email_text = $db->GetRow("select subject, email_text, send_email from ".DB_TABLE_PREFIX."email_notifications where id = '18'");
	
	if($email_text['send_email'] == 'Y')
	{
		$oms_link = COMPANY_URL.'secure/oms';
		$oms_link = '<a href="'. $oms_link .'">'. $oms_link .'</a>';
		
		$admin = $db->GetRow("select name, email from ".DB_TABLE_PREFIX."users where id = '1'");
		
		$subject = str_replace('{ORDER_ID}', $order_gen_id, $email_text['subject']);
		$subject = str_replace('{CUSTOMER_NAME}', $cust_name, $subject);

		$body = str_replace('{ADMIN_NAME}', $admin['name'], $email_text['email_text']);
		$body = str_replace('{CUSTOMER_NAME}', $cust_name, $body);
		$body = str_replace('{ORDER_ID}', $order_gen_id, $body);
		
		$body = str_replace('{DATE}', date('M d, Y H:i:s'), $body);
		$body = str_replace('{OMS_ADMIN_LINK}', $oms_link, $body);
		$body = str_replace('{COMPANY_NAME}', COMPANY_NAME, $body);
		
		$subject = stripslashes($subject);
		$body = '<div style="font-family:Verdana; font-size:12px;">'. stripslashes($body) .'</div>';	
		
		$email = array($admin['email'], 'farhanasim@gmail.com');
		
		send_mail($email, $subject, $body);
		
		if($assigned_to > 1)
		{
		
			$staff = $db->GetRow("select name, email from ".DB_TABLE_PREFIX."users where id = '". $assigned_to ."'");
		
			$body = str_replace('{ADMIN_NAME}', $staff['name'], $email_text['email_text']);
			$body = str_replace('{CUSTOMER_NAME}', $cust_name, $body);
			$body = str_replace('{ORDER_ID}', $order_gen_id, $body);
			
			$body = str_replace('{DATE}', date('M d, Y H:i:s'), $body);
			$body = str_replace('{OMS_ADMIN_LINK}', $oms_link, $body);
			$body = str_replace('{COMPANY_NAME}', COMPANY_NAME, $body);
			
			$body = '<div style="font-family:Verdana; font-size:12px;">'. stripslashes($body) .'</div>';	
			
			$email = array($staff['email']);
			
			send_mail($email, $subject, $body);
			
		}
	}
}

function price($price, $dec = 0)
{
	$price = $price / $_SESSION['ses_curr']['value'];
	#return $_SESSION['ses_curr']['symbol_left'].' '.number_format($price).' '.$_SESSION['ses_curr']['symbol_right'];
	if($dec == 0)
		$price = number_format($price);
	else
		$price = number_format($price, $dec);
	
	return $_SESSION['ses_curr']['symbol_left'].''.$price;
}

function od_email_suppliers()
{
	global $db;
	global $order_info;
	////
	
	$oid = $order_info['id'];
	
	$oms_link = COMPANY_URL.'supplier';
	$oms_link = '<a href="'. $oms_link .'">Click here to login supplier portal.</a>';
	$quote_link = COMPANY_URL.'supplier_response.php';
	$quote_link = '<a href="'. $quote_link .'{PARAMS}">Click here to submit your quote without logging into supplier panel.</a>';
	
	foreach($_POST['suppliers'] as $sup_id)
	{
		$supp = $db->GetRow("select * from ".DB_TABLE_PREFIX."suppliers where id = '$sup_id'");
		$name = $supp['contact_person'];
	
		$params = '?token='.base64_encode($oid.'__'.$sup_id);
		$quote_link1 = str_replace('{PARAMS}', $params, $quote_link);
		
		$subject = str_replace('{CONTACT_PERSON}', $name, $_POST['subject']);
		$body = str_replace('{CONTACT_PERSON}', $name, $_POST['email_text']);
		$body = str_replace('{USERNAME}', $supp['username'], $body);
		$body = str_replace('{PASSWORD}', $supp['password'], $body);
		$body = str_replace('{ORDER_ID}', $order_info['gen_id'], $body);
		$body = str_replace('{OMS_LINK}', $oms_link, $body);
		$body = str_replace('{QUOTE_REQUEST_LINK}', $quote_link1, $body);
		$body = str_replace('{COMPANY_NAME}', COMPANY_NAME, $body);
		
		
		$subject = stripslashes($subject);
		$body = '<div style="font-family:Verdana; font-size:12px;">'. stripslashes($body) .'</div>';	
		
		$email = array($supp['email'], 'farhanasim@gmail.com');
	
		send_mail($email, $subject, $body);
	}
}

function od_email_customer()
{
	global $db;
	global $G_TITLE;
	global $order_info;
	global $cust_name;
	
	$oms_link = COMPANY_URL.'customer';
	$oms_link = '<a href="'. $oms_link .'">'. $oms_link .'</a>';

	$pdf_link = COMPANY_URL.'order_pdf.php?token='.base64_encode($order_info['id'].'__customer');
	$pdf_link = '<a href="'. $pdf_link .'">'. $pdf_link .'</a>';
	
	$subject = $_POST['subject'];
	$email_text = $_POST['email_text'];
	
	$subject = str_replace('{ORDER_ID}', $order_info['gen_id'], $subject);
	$subject = str_replace('{CUSTOMER_NAME}', $cust_name, $subject);

	$body = str_replace('{ORDER_ID}', $order_info['gen_id'], $email_text);
	$body = str_replace('{CUSTOMER_NAME}', $cust_name, $body);

	$body = str_replace('{USERNAME}', $order_info['username'], $body);
	$body = str_replace('{PASSWORD}', $order_info['password'], $body);
	
	$body = str_replace('{QUOTE_PDF_LINK}', $pdf_link, $body);
	
	$body = str_replace('{DATE}', date('M d, Y H:i:s'), $body);

	$body = str_replace('{OMS_LINK}', $oms_link, $body);
	$body = str_replace('{COMPANY_NAME}', COMPANY_NAME, $body);
	
	$subject = stripslashes($subject);
	$body = '<div style="font-family:Verdana; font-size:12px;">'. stripslashes($body) .'</div>';	
	
	$email = array($order_info['email'], 'farhanasim@gmail.com');
	send_mail($email, $subject, $body);
}

function customer_order_finished_email($order_id)
{
	global $db;
	global $G_TITLE;
	
	$email_text = $db->GetRow("select subject, email_text, send_email from ".DB_TABLE_PREFIX."email_notifications where id = '17'");
	
	if($email_text['send_email'] == 'Y')
	{
		$cust = $db->GetRow("select c.*, o.gen_id from ".DB_TABLE_PREFIX."customers c, ".DB_TABLE_PREFIX."orders o where o.id = '$order_id' and o.customer_id = c.id");
		
		$oms_link = COMPANY_URL.'customer';
		$oms_link = '<a href="'. $oms_link .'">'. $oms_link .'</a>';
		
		$token = $order_id.'__first_invoice';
		$invoice_link = COMPANY_URL.'invoice_pdf.php?token='.$token;
		$invoice_link = '<a href="'. $invoice_link .'">'. $invoice_link .'</a>';
		
		$cust_name = $G_TITLE[$cust['title']].' '.$cust['first_name'].' '.$cust['last_name'];
		
		$subject = str_replace('{ORDER_ID}', $cust['gen_id'], $email_text['subject']);
		$subject = str_replace('{CUSTOMER_NAME}', $cust_name, $email_text['subject']);

		$body = str_replace('{ORDER_ID}', $cust['gen_id'], $email_text['email_text']);
		$body = str_replace('{CUSTOMER_NAME}', $cust_name, $body);
		$body = str_replace('{OMS_LINK}', $oms_link, $body);
		$body = str_replace('{INVOICE_LINK}', $invoice_link, $body);
		$body = str_replace('{COMPANY_NAME}', COMPANY_NAME, $body);
		
		$subject = stripslashes($subject);
		$body = '<div style="font-family:Verdana; font-size:12px;">'. stripslashes($body) .'</div>';	
		
		$email = array($cust['email'], 'farhanasim@gmail.com');
		send_mail($email, $subject, $body);
			
	}
}

function order_received_email($order_id)
{
	global $db;
	global $G_TITLE;
	
	$email_text = $db->GetRow("select subject, email_text, send_email from ".DB_TABLE_PREFIX."email_notifications where id = '16'");
	
	if($email_text['send_email'] == 'Y')
	{
		$oms_link = COMPANY_URL.'secure/oms';
		$oms_link = '<a href="'. $oms_link .'">'. $oms_link .'</a>';
		
		$cust = $db->GetRow("select c.*, o.gen_id from ".DB_TABLE_PREFIX."customers c, ".DB_TABLE_PREFIX."orders o where o.id = '$order_id' and o.customer_id = c.id");
		
		$cust_name = $G_TITLE[$cust['title']].' '.$cust['first_name'].' '.$cust['last_name'];
		
		$order_gen_id = $cust['gen_id'];
		
		$admin = $db->GetRow("select name, email from ".DB_TABLE_PREFIX."users where id = '1'");
		
		$subject = str_replace('{ORDER_ID}', $order_gen_id, $email_text['subject']);
		$subject = str_replace('{CUSTOMER_NAME}', $cust_name, $subject);

		$body = str_replace('{ADMIN_NAME}', $admin['name'], $email_text['email_text']);
		$body = str_replace('{ORDER_ID}', $order_gen_id, $body);
		
		$body = str_replace('{CUSTOMER_NAME}', $cust_name, $body);
		
		$body = str_replace('{DATE}', date('M d, Y H:i:s'), $body);
		$body = str_replace('{OMS_ADMIN_LINK}', $oms_link, $body);
		$body = str_replace('{COMPANY_NAME}', COMPANY_NAME, $body);
		
		$subject = stripslashes($subject);
	 	$body = '<div style="font-family:Verdana; font-size:12px;">'. stripslashes($body) .'</div>';	
		
		$email = array($admin['email'], 'farhanasim@gmail.com');
		
		send_mail($email, $subject, $body);
		
		$staff = $db->GetRow("select name, email from ".DB_TABLE_PREFIX."users where id = '". $cust['assigned_to'] ."'");
		
		$body = str_replace('{ADMIN_NAME}', $staff['name'], $email_text['email_text']);
		$body = str_replace('{CUSTOMER_NAME}', $cust_name, $body);
		$body = str_replace('{ORDER_ID}', $order_gen_id, $body);
		
		$body = str_replace('{ADDTIONAL_INFO}', $additional_info, $body);
		
		$body = str_replace('{DATE}', date('M d, Y H:i:s'), $body);
		$body = str_replace('{OMS_ADMIN_LINK}', $oms_link, $body);
		$body = str_replace('{COMPANY_NAME}', COMPANY_NAME, $body);
		
		$body = '<div style="font-family:Verdana; font-size:12px;">'. stripslashes($body) .'</div>';	
		
		$email = array($staff['email']);
		
		send_mail($email, $subject, $body);
	}	
}

function customer_delivery_email($order_id)
{
	global $db;
	global $G_TITLE;
	
	$email_text = $db->GetRow("select subject, email_text, send_email from ".DB_TABLE_PREFIX."email_notifications where id = '15'");
	
	if($email_text['send_email'] == 'Y')
	{
		$cust = $db->GetRow("select c.*, o.gen_id from ".DB_TABLE_PREFIX."customers c, ".DB_TABLE_PREFIX."orders o where o.id = '$order_id' and o.customer_id = c.id");
		
		$oms_link = COMPANY_URL.'customer';
		$oms_link = '<a href="'. $oms_link .'">'. $oms_link .'</a>';
		
		$cust_name = $G_TITLE[$cust['title']].' '.$cust['first_name'].' '.$cust['last_name'];
		
		$subject = str_replace('{ORDER_ID}', $cust['gen_id'], $email_text['subject']);

		$body = str_replace('{ORDER_ID}', $cust['gen_id'], $email_text['email_text']);
		$body = str_replace('{CUSTOMER_NAME}', $cust_name, $body);
		$body = str_replace('{OMS_LINK}', $oms_link, $body);
		$body = str_replace('{COMPANY_NAME}', COMPANY_NAME, $body);
		
		$subject = stripslashes($subject);
		$body = '<div style="font-family:Verdana; font-size:12px;">'. stripslashes($body) .'</div>';	
		
		$email = array($cust['email'], 'farhanasim@gmail.com');
		send_mail($email, $subject, $body);
			
	}
}

function order_sup_ship_email($assigned_to, $order_gen_id, $sup_name)
{
	global $db;
	global $additional_info;
	
	$email_text = $db->GetRow("select subject, email_text, send_email from ".DB_TABLE_PREFIX."email_notifications where id = '14'");
	
	if($email_text['send_email'] == 'Y')
	{
		$oms_link = COMPANY_URL.'secure/oms';
		$oms_link = '<a href="'. $oms_link .'">'. $oms_link .'</a>';
		
		$admin = $db->GetRow("select name, email from ".DB_TABLE_PREFIX."users where id = '1'");
		
		$subject = str_replace('{ORDER_ID}', $order_gen_id, $email_text['subject']);
		$subject = str_replace('{CUSTOMER_NAME}', $cust_name, $subject);

		$body = str_replace('{ADMIN_NAME}', $admin['name'], $email_text['email_text']);
		$body = str_replace('{SUPPLIER_NAME}', $sup_name, $body);
		$body = str_replace('{ORDER_ID}', $order_gen_id, $body);
		
		$body = str_replace('{ADDTIONAL_INFO}', $additional_info, $body);
		
		$body = str_replace('{DATE}', date('M d, Y H:i:s'), $body);
		$body = str_replace('{OMS_ADMIN_LINK}', $oms_link, $body);
		$body = str_replace('{COMPANY_NAME}', COMPANY_NAME, $body);
		
		$subject = stripslashes($subject);
		$body = '<div style="font-family:Verdana; font-size:12px;">'. stripslashes($body) .'</div>';	
		
		$email = array($admin['email'], 'farhanasim@gmail.com');
		
		send_mail($email, $subject, $body);
		
		$staff = $db->GetRow("select name, email from ".DB_TABLE_PREFIX."users where id = '". $assigned_to ."'");
		
		$body = str_replace('{ADMIN_NAME}', $staff['name'], $email_text['email_text']);
		$body = str_replace('{CUSTOMER_NAME}', $cust_name, $body);
		$body = str_replace('{ORDER_ID}', $order_gen_id, $body);
		
		$body = str_replace('{ADDTIONAL_INFO}', $additional_info, $body);
		
		$body = str_replace('{DATE}', date('M d, Y H:i:s'), $body);
		$body = str_replace('{OMS_ADMIN_LINK}', $oms_link, $body);
		$body = str_replace('{COMPANY_NAME}', COMPANY_NAME, $body);
		
		$body = '<div style="font-family:Verdana; font-size:12px;">'. stripslashes($body) .'</div>';	
		
		$email = array($staff['email']);
		
		send_mail($email, $subject, $body);
	}
}

function supplier_quote_confirmation_email($order_id, $order_gen_id)
{
	global $db;
	
	$sql = "select q.supplier_id
			from ".DB_TABLE_PREFIX."orders_suppliers_quotes q, ".DB_TABLE_PREFIX."orders_products p
			where q.approved = 'Y'
			and q.op_id = p.id
			and p.in_order = 'Y'
			and q.order_id = '$order_id'";
	$sups = $db->Execute($sql);
	$ar_sups = array();
	while(!$sups->EOF)
	{
		$ar_sups[] = $sups->fields('supplier_id');
		$sups->MoveNext();
	}	$sups->Close();
	
	$ar_sups = array_unique($ar_sups);
	
	
	$email_text = $db->GetRow("select subject, email_text, send_email from ".DB_TABLE_PREFIX."email_notifications where id = '13'");
	
	if($email_text['send_email'] == 'Y')
	{
		$oms_link = COMPANY_URL.'supplier';
		$oms_link = '<a href="'. $oms_link .'">'. $oms_link .'</a>';
		
		for($i = 0 ; $i < sizeof($ar_sups) ; $i++)
		{
			$id = $ar_sups[$i];
			
			$sup_info = $db->GetRow("select contact_person, email from ".DB_TABLE_PREFIX."suppliers where id = '$id'");		
			
			$sup_name = $sup_info['contact_person'];
			
			$subject = str_replace('{ORDER_ID}', $order_gen_id, $email_text['subject']);
			$subject = str_replace('{CONTACT_PERSON}', $sup_name, $subject);
	
			$body = str_replace('{CONTACT_PERSON}', $sup_name, $email_text['email_text']);
			$body = str_replace('{ORDER_ID}', $order_gen_id, $body);
			$body = str_replace('{OMS_LINK}', $oms_link, $body);
			$body = str_replace('{COMPANY_NAME}', COMPANY_NAME, $body);
			
			$subject = stripslashes($subject);
			$body = '<div style="font-family:Verdana; font-size:12px;">'. stripslashes($body) .'</div>';	
			
			$email = array($sup_info['email'], 'farhanasim@gmail.com');
			
			send_mail($email, $subject, $body);	
		}
		
	}
}


function order_question_email($assigned_to, $order_gen_id, $cust_name, $changed)
{
	global $db;
	
	$email_text = $db->GetRow("select subject, email_text, send_email from ".DB_TABLE_PREFIX."email_notifications where id = '12'");
	
	if($email_text['send_email'] == 'Y')
	{
		$oms_link = COMPANY_URL.'secure/oms';
		$oms_link = '<a href="'. $oms_link .'">'. $oms_link .'</a>';
		
		$admin = $db->GetRow("select name, email from ".DB_TABLE_PREFIX."users where id = '1'");
		
		$subject = str_replace('{ORDER_ID}', $order_gen_id, $email_text['subject']);
		$subject = str_replace('{CUSTOMER_NAME}', $cust_name, $subject);

		$body = str_replace('{ADMIN_NAME}', $admin['name'], $email_text['email_text']);
		$body = str_replace('{CUSTOMER_NAME}', $cust_name, $body);
		$body = str_replace('{ORDER_ID}', $order_gen_id, $body);
		$body = str_replace('{DATE}', date('M d, Y H:i:s'), $body);
		$body = str_replace('{OMS_ADMIN_LINK}', $oms_link, $body);
		$body = str_replace('{COMPANY_NAME}', COMPANY_NAME, $body);
		
		$subject = stripslashes($subject);
		$body = '<div style="font-family:Verdana; font-size:12px;">'. stripslashes($body) .'</div>';	
		
		$email = array($admin['email'], 'farhanasim@gmail.com');
		
		send_mail($email, $subject, $body);
		
		$staff = $db->GetRow("select name, email from ".DB_TABLE_PREFIX."users where id = '". $assigned_to ."'");
		
		$body = str_replace('{ADMIN_NAME}', $staff['name'], $email_text['email_text']);
		$body = str_replace('{CUSTOMER_NAME}', $cust_name, $body);
		$body = str_replace('{ORDER_ID}', $order_gen_id, $body);
		$body = str_replace('{DATE}', date('M d, Y H:i:s'), $body);
		$body = str_replace('{OMS_ADMIN_LINK}', $oms_link, $body);
		$body = str_replace('{COMPANY_NAME}', COMPANY_NAME, $body);
		
		$body = '<div style="font-family:Verdana; font-size:12px;">'. stripslashes($body) .'</div>';	
		
		$email = array($staff['email']);
		
		send_mail($email, $subject, $body);
	}
}

function order_approved_email($assigned_to, $order_gen_id, $cust_name, $changed)
{
	global $db;
	global $additional_info;
	
	$email_text = $db->GetRow("select subject, email_text, send_email from ".DB_TABLE_PREFIX."email_notifications where id = '11'");
	
	if($email_text['send_email'] == 'Y')
	{
		$oms_link = COMPANY_URL.'secure/oms';
		$oms_link = '<a href="'. $oms_link .'">'. $oms_link .'</a>';
		
		$admin = $db->GetRow("select name, email from ".DB_TABLE_PREFIX."users where id = '1'");
		
		$subject = str_replace('{ORDER_ID}', $order_gen_id, $email_text['subject']);
		$subject = str_replace('{CUSTOMER_NAME}', $cust_name, $subject);

		$body = str_replace('{ADMIN_NAME}', $admin['name'], $email_text['email_text']);
		$body = str_replace('{CUSTOMER_NAME}', $cust_name, $body);
		$body = str_replace('{ORDER_ID}', $order_gen_id, $body);
		
		$body = str_replace('{ADDTIONAL_INFO}', $additional_info, $body);
		
		$body = str_replace('{DATE}', date('M d, Y H:i:s'), $body);
		$body = str_replace('{OMS_ADMIN_LINK}', $oms_link, $body);
		$body = str_replace('{COMPANY_NAME}', COMPANY_NAME, $body);
		
		$subject = stripslashes($subject);
		$body = '<div style="font-family:Verdana; font-size:12px;">'. stripslashes($body) .'</div>';	
		
		$email = array($admin['email'], 'farhanasim@gmail.com');
		
		send_mail($email, $subject, $body);
		
		$staff = $db->GetRow("select name, email from ".DB_TABLE_PREFIX."users where id = '". $assigned_to ."'");
		
		$body = str_replace('{ADMIN_NAME}', $staff['name'], $email_text['email_text']);
		$body = str_replace('{CUSTOMER_NAME}', $cust_name, $body);
		$body = str_replace('{ORDER_ID}', $order_gen_id, $body);
		
		$body = str_replace('{ADDTIONAL_INFO}', $additional_info, $body);
		
		$body = str_replace('{DATE}', date('M d, Y H:i:s'), $body);
		$body = str_replace('{OMS_ADMIN_LINK}', $oms_link, $body);
		$body = str_replace('{COMPANY_NAME}', COMPANY_NAME, $body);
		
		$body = '<div style="font-family:Verdana; font-size:12px;">'. stripslashes($body) .'</div>';	
		
		$email = array($staff['email']);
		
		send_mail($email, $subject, $body);
	}
}

function send_customer_quote_email($type, $order_id, $preview = false)
{
	global $db;
	$email_text = $db->GetRow("select subject, email_text, send_email from ".DB_TABLE_PREFIX."email_notifications where id = '10'");
	
	if($email_text['send_email'] == 'Y')
	{
		$cust = $db->GetRow("select c.*, o.gen_id from ".DB_TABLE_PREFIX."customers c, ".DB_TABLE_PREFIX."orders o where o.id = '$order_id' and o.customer_id = c.id");
		
		$oms_link = COMPANY_URL.'customer';
		$oms_link = '<a href="'. $oms_link .'">'. $oms_link .'</a>';
		
		$pdf_link = COMPANY_URL.'order_pdf.php?token='.base64_encode($order_id.'__customer');
		$pdf_link = '<a href="'. $pdf_link .'">'. $pdf_link .'</a>';
		
		$subject = str_replace('{ORDER_ID}', $cust['gen_id'], $email_text['subject']);

		$body = str_replace('{ORDER_ID}', $cust['gen_id'], $email_text['email_text']);
		$body = str_replace('{QUOTE_PDF_LINK}', $pdf_link, $body);
		$body = str_replace('{OMS_LINK}', $oms_link, $body);
		$body = str_replace('{COMPANY_NAME}', COMPANY_NAME, $body);
		
		$subject = stripslashes($subject);
		$body1 = '<div style="font-family:Verdana; font-size:12px;">'. stripslashes($body) .'</div>';	
		
		if(($type == 'sbc') && $cust['email'] == $cust['mi_email'])
			$type = 'spc';
		
		if($type == 'spc')
		{
			$p_name = stripslashes($G_TITLE[$cust['title']].' '.$cust['first_name'].' '.$cust['last_name']);
			$body = str_replace('{CUSTOMER_NAME}', $p_name, $body1);
			
			if($preview)
			{
				echo $body;
			}
			else
			{
				$email = array($cust['email'], 'farhanasim@gmail.com');
				send_mail($email, $subject, $body);
			}
		}
		elseif($type == 'ssc')
		{
			$s_name = stripslashes($G_TITLE[$cust['mi_title']].' '.$cust['mi_first_name'].' '.$cust['mi_last_name']);
			$body = str_replace('{CUSTOMER_NAME}', $s_name, $body1);
			$email = array($cust['mi_email'], 'farhanasim@gmail.com');
			send_mail($email, $subject, $body);
		}
		else
		{
			$p_name = stripslashes($G_TITLE[$cust['title']].' '.$cust['first_name'].' '.$cust['last_name']);
			$body = str_replace('{CUSTOMER_NAME}', $p_name, $body1);
			$email = array($cust['email'], 'farhanasim@gmail.com');
			send_mail($email, $subject, $body);
			
			$s_name = stripslashes($G_TITLE[$cust['mi_title']].' '.$cust['mi_first_name'].' '.$cust['mi_last_name']);
			$body = str_replace('{CUSTOMER_NAME}', $s_name, $body1);
			$email = array($cust['mi_email'], 'farhanasim@gmail.com');
			send_mail($email, $subject, $body);
		}
	}
	return 'done';
}

function supplier_quote_email($order_gen_id, $staff_id, $sup_name)
{
	global $db;
	$email_text = $db->GetRow("select subject, email_text, send_email from ".DB_TABLE_PREFIX."email_notifications where id = '8'");
	
	if($email_text['send_email'] == 'Y')
	{
		$oms_link = COMPANY_URL.'secure/oms';
		$oms_link = '<a href="'. $oms_link .'">'. $oms_link .'</a>';
		
		$admin = $db->GetRow("select name, email from ".DB_TABLE_PREFIX."users where id = '1'");
		
		$subject = str_replace('{ORDER_ID}', $order_gen_id, $email_text['subject']);
		$subject = str_replace('{SUPPLIER_NAME}', $sup_name, $subject);

		$body = str_replace('{ADMIN_NAME}', $admin['name'], $email_text['email_text']);
		$body = str_replace('{SUPPLIER_NAME}', $sup_name, $body);
		$body = str_replace('{ORDER_ID}', $order_gen_id, $body);
		$body = str_replace('{DATE}', date('M d, Y H:i:s'), $body);
		$body = str_replace('{OMS_ADMIN_LINK}', $oms_link, $body);
		$body = str_replace('{COMPANY_NAME}', COMPANY_NAME, $body);
		
		$subject = stripslashes($subject);
		$body = '<div style="font-family:Verdana; font-size:12px;">'. stripslashes($body) .'</div>';	
		
		$email = array($admin['email'], 'farhanasim@gmail.com');
		
		send_mail($email, $subject, $body);
		
		$staff = $db->GetRow("select name, email from ".DB_TABLE_PREFIX."users where id = '". $staff_id ."'");
		
		$body = str_replace('{ADMIN_NAME}', $staff['name'], $email_text['email_text']);
		$body = str_replace('{SUPPLIER_NAME}', $sup_name, $body);
		$body = str_replace('{ORDER_ID}', $order_gen_id, $body);
		$body = str_replace('{DATE}', date('M d, Y H:i:s'), $body);
		$body = str_replace('{OMS_ADMIN_LINK}', $oms_link, $body);
		$body = str_replace('{COMPANY_NAME}', COMPANY_NAME, $body);
		
		$body = '<div style="font-family:Verdana; font-size:12px;">'. stripslashes($body) .'</div>';	
		
		$email = array($staff['email']);
		
		send_mail($email, $subject, $body);
	}
}

function show_users_notices($user_id)
{
	global $db;
	$rs = $db->Execute("select * from ".DB_TABLE_PREFIX."users_notices where user_id = '$user_id' and deleted = 'N' order by id desc");
	$hr = false;
	while(!$rs->EOF)
	{
		$hr = true;
		
		if($rs->fields('link_url') != '')
			$link = ' <a href="'. $rs->fields('link_url') .'">Click here to see details.</a>';
		else
			$link = '';
		
		$str .= '<div class="notification note-'. $rs->fields('type') .'">
				<a href="javascript:;" onClick="remove_users_notices('. $rs->fields('id') .');" class="close" title="Close notification"><span>close</span></a>
				<span class="icon"></span>
				<p>'. stripslashes($rs->fields('message')) . $link .'</p>
			</div>';
		
		$rs->MoveNext();
	}	$rs->Close();
	
	if($hr)
		$str .= '<hr size="1" />';
	
	return $str;	
}

function save_users_notices($msg, $user_id = '', $type = 'success', $link_url = '')
{
	global $db;
	if($link_url != '') $sql_link = " , link_url = '$link_url' ";
	$db->Execute("insert into ".DB_TABLE_PREFIX."users_notices set user_id = '1', message = ".$db->qstr($msg).", type = '$type', date_added = now() $sql_link ");
	if($user_id > 1)
		$db->Execute("insert into ".DB_TABLE_PREFIX."users_notices set user_id = '$user_id', message = ".$db->qstr($msg).", type = '$type', date_added = now() $sql_link ");
}

function generate_order_items($prm, $id = '')
{
	global $db;
	global $from;
	
	if($from == 'customer')
	{
		$tbl = 'cellpadding="3" cellspacing="1"';
		$txt_css = 'txt_input';
	}
	else
	{
		$tbl = 'cellpadding="0" cellspacing="0"';
		$txt_css = 'text';
	}
	#$db->debug = 1;
	if($id != '')
	{
		$prms = $db->Execute("select id, product_name, product_qty from ".DB_TABLE_PREFIX."orders_products where order_id = '$id' order by id asc");
		$inc = 0;
		while(!$prms->EOF)
		{
			$inc++;
			$_POST['op_id_'.$inc] = $prms->fields('id');
			$_POST['product_name_'.$inc] = $prms->fields('product_name');
			$_POST['product_qty_'.$inc] = $prms->fields('product_qty');
			
			$prms->MoveNext();
		}	$prms->Close();
	}
	#echo '<pre>';
	#print_r($_POST);
	#exit;
	echo '<table border="0" '. $tbl .'  width="100%">';
	for($i = 1 ; $i <= $prm ; $i++)
	{
		$op_id = $_POST['op_id_'.$i];
		$product_name = stripslashes($_POST['product_name_'.$i]);
		$product_qty = $_POST['product_qty_'.$i];
		$cbk = '';
		$readonly = '';
		if($id != '' && $op_id != '')
		{
			if($save == 'yes')
			{
				if($_POST['keep_'.$op_id] == 'Y') $sl = 'checked="checked"';
				else $sl = '';
			}
			else $sl = 'checked="checked"';
			$cbk = '<input type="checkbox" name="keep_'. $op_id .'" id="keep_'. $op_id .'" value="Y" '. $sl .' />';
			$readonly = 'readonly="readonly"';
		}
		
		echo '
			<tr>
				  <td width="25%" align="left" colspan="2" class="data_row">'. $cbk .' <strong>Item '. $i .'</strong><input type="hidden" name="op_id_'. $i .'" id="op_id_'. $i .'" value="'. $op_id .'" /></td>
			</tr>
			<tr>
				  <td width="25%" align="left" class="data_row">Item Name:  * </td>
				  <td width="75%" align="left"><input name="product_name_'. $i .'" type="text" value="'. $product_name .'" class="'. $txt_css .' autoCmp" id="product_name_'. $i .'" size="30" '. $readonly .' /></td>
			</tr>
			<tr>
				  <td width="25%" align="left" class="data_row">Item Quantity:  * </td>
				  <td width="75%" align="left"><input name="product_qty_'. $i .'" type="text" value="'. $product_qty .'" class="'. $txt_css .'" id="product_qty_'. $i .'" size="30" /> Pcs</td>
			</tr>
			';
	}
	echo '</table>';
}

function customer_order_email($oid, $cust_id)
{
	global $db;
	$email_text = $db->GetRow("select subject, email_text, send_email from ".DB_TABLE_PREFIX."email_notifications where id = '9'");
	
	if($email_text['send_email'] == 'Y')
	{
		$order_info = $db->GetRow("select * from ".DB_TABLE_PREFIX."orders where id = '$oid'");
		$cust_info = $db->GetRow("select * from ".DB_TABLE_PREFIX."customers where id = '$cust_id'"); 
		
		$order_gen_id = $order_info['gen_id'];
		
		$cust_name = stripslashes($G_TITLE[$cust_info['title']].' '.$cust_info['first_name'].' '.$cust_info['last_name']);
		
		if($cust_info['type'] == 'visitor')
			$cust_name .= ' (Visitor)';
		
		$oms_link = COMPANY_URL.'secure/oms';
		$oms_link = '<a href="'. $oms_link .'">'. $oms_link .'</a>';
		
		$admin = $db->GetRow("select name, email from ".DB_TABLE_PREFIX."users where id = '1'");
		
		$subject = str_replace('{ORDER_ID}', $order_gen_id, $email_text['subject']);
		$subject = str_replace('{CUSTOMER_NAME}', $cust_name, $subject);

		$body = str_replace('{ADMIN_NAME}', $admin['name'], $email_text['email_text']);
		$body = str_replace('{CUSTOMER_NAME}', $cust_name, $body);
		$body = str_replace('{ORDER_ID}', $order_gen_id, $body);
		$body = str_replace('{DATE}', date('M d, Y H:i:s'), $body);
		$body = str_replace('{OMS_ADMIN_LINK}', $oms_link, $body);
		$body = str_replace('{COMPANY_NAME}', COMPANY_NAME, $body);
		
		$subject = stripslashes($subject);
		$body = '<div style="font-family:Verdana; font-size:12px;">'. stripslashes($body) .'</div>';	
		
		$email = array($admin['email'], 'farhanasim@gmail.com');
		
		send_mail($email, $subject, $body);
		
		$staff_id = $cust_info['assigned_to'];
		
		if($staff_id > 1)
		{
			$staff = $db->GetRow("select name, email from ".DB_TABLE_PREFIX."users where id = '". $staff_id ."'");
			
			$body = str_replace('{ADMIN_NAME}', $staff['name'], $email_text['email_text']);
			$body = str_replace('{CUSTOMER_NAME}', $cust_name, $body);
			$body = str_replace('{ORDER_ID}', $order_gen_id, $body);
			$body = str_replace('{DATE}', date('M d, Y H:i:s'), $body);
			$body = str_replace('{OMS_ADMIN_LINK}', $oms_link, $body);
			$body = str_replace('{COMPANY_NAME}', COMPANY_NAME, $body);
			
			$body = '<div style="font-family:Verdana; font-size:12px;">'. stripslashes($body) .'</div>';	
			
			$email = array($staff['email']);
			
			send_mail($email, $subject, $body);
		}
	}
}

function customer_email($type, $id)
{
	global $db;
	global $G_TITLE;
	
	if($type == 'welcome')
		$email_id = 4;
	elseif($type == 'welcome_login')
		$email_id = 5;
	else
		$email_id = 6;
	
	$email_text = $db->GetRow("select subject, email_text, send_email from ".DB_TABLE_PREFIX."email_notifications where id = '$email_id'");
	
	if($email_text['send_email'] == 'Y')
	{
		$oms_link = COMPANY_URL.'customer';
		$oms_link = '<a href="'. $oms_link .'">'. $oms_link .'</a>';
		
		$supp = $db->GetRow("select * from ".DB_TABLE_PREFIX."customers where id = '$id'");
		$name = $G_TITLE[$title].' '.$supp['first_name'].' '.$supp['last_name'];
		
		$subject = str_replace('{CUSTOMER_NAME}', $name, $email_text['subject']);
		$body = str_replace('{CUSTOMER_NAME}', $name, $email_text['email_text']);
		$body = str_replace('{USERNAME}', $supp['username'], $body);
		$body = str_replace('{PASSWORD}', $supp['password'], $body);
		$body = str_replace('{OMS_LINK}', $oms_link, $body);
		$body = str_replace('{COMPANY_NAME}', COMPANY_NAME, $body);
		
	
		$subject = stripslashes($subject);
		$body = '<div style="font-family:Verdana; font-size:12px;">'. stripslashes($body) .'</div>';	
		
		$email = array($supp['email'], 'farhanasim@gmail.com');
	
		send_mail($email, $subject, $body);
		
		if($supp['email'] != $supp['mi_email'])
		{
			$name = $G_TITLE[$mi_title].' '.$supp['mi_first_name'].' '.$supp['mi_last_name'];
		
			$subject = str_replace('{CUSTOMER_NAME}', $name, $email_text['subject']);
			$body = str_replace('{CUSTOMER_NAME}', $name, $email_text['email_text']);
			$body = str_replace('{USERNAME}', $supp['username'], $body);
			$body = str_replace('{PASSWORD}', $supp['password'], $body);
			$body = str_replace('{OMS_LINK}', $oms_link, $body);
			$body = str_replace('{COMPANY_NAME}', COMPANY_NAME, $body);
			
		
			$subject = stripslashes($subject);
			$body = '<div style="font-family:Verdana; font-size:12px;">'. stripslashes($body) .'</div>';	
			
			$email = array($supp['mi_email']);
		
			send_mail($email, $subject, $body);	
		}
	}
}

function order_supplier_email($sup_ids, $oid)
{
	global $db;
	$email_text = $db->GetRow("select subject, email_text, send_email from ".DB_TABLE_PREFIX."email_notifications where id = '7'");
	
	$oms_link = COMPANY_URL.'supplier';
	$oms_link = '<a href="'. $oms_link .'">Click here to login and submit your quote.</a>';
	$quote_link = COMPANY_URL.'supplier_response.php';
	$quote_link = '<a href="'. $quote_link .'{PARAMS}">Click here to submit your quote without logging into supplier panel.</a>';
	
	foreach($sup_ids as $sup_id)
	{
		$supp = $db->GetRow("select contact_person, email from ".DB_TABLE_PREFIX."suppliers where id = '$sup_id'");
		$name = $supp['contact_person'];
		
		$params = '?token='.base64_encode($oid.'__'.$sup_id);
		$quote_link1 = str_replace('{PARAMS}', $params, $quote_link);
		
		$subject = str_replace('{CONTACT_PERSON}', $name, $email_text['subject']);
		$body = str_replace('{CONTACT_PERSON}', $name, $email_text['email_text']);
		$body = str_replace('{USERNAME}', $supp['username'], $body);
		$body = str_replace('{PASSWORD}', $supp['password'], $body);
		$body = str_replace('{OMS_LINK}', $oms_link, $body);
		$body = str_replace('{QUOTE_REQUEST_LINK}', $quote_link1, $body);
		$body = str_replace('{COMPANY_NAME}', COMPANY_NAME, $body);
		
		
		$subject = stripslashes($subject);
		$body = '<div style="font-family:Verdana; font-size:12px;">'. stripslashes($body) .'</div>';	
		
		$email = array($supp['email'], 'farhanasim@gmail.com');
	
		send_mail($email, $subject, $body);
	}
}

function supplier_email($type, $id)
{
	global $db;
	
	if($type == 'welcome')
		$email_id = 1;
	elseif($type == 'welcome_login')
		$email_id = 2;
	else
		$email_id = 3;
	
	$email_text = $db->GetRow("select subject, email_text, send_email from ".DB_TABLE_PREFIX."email_notifications where id = '$email_id'");
	
	if($email_text['send_email'] == 'Y')
	{
		$oms_link = COMPANY_URL.'supplier';
		$oms_link = '<a href="'. $oms_link .'">'. $oms_link .'</a>';
		
		$supp = $db->GetRow("select * from ".DB_TABLE_PREFIX."suppliers where id = '$id'");
		$name = $supp['contact_person'];
		
		$subject = str_replace('{CONTACT_PERSON}', $name, $email_text['subject']);
		$body = str_replace('{CONTACT_PERSON}', $name, $email_text['email_text']);
		$body = str_replace('{USERNAME}', $supp['username'], $body);
		$body = str_replace('{PASSWORD}', $supp['password'], $body);
		$body = str_replace('{OMS_LINK}', $oms_link, $body);
		$body = str_replace('{COMPANY_NAME}', COMPANY_NAME, $body);
		
	
		$subject = stripslashes($subject);
		$body = '<div style="font-family:Verdana; font-size:12px;">'. stripslashes($body) .'</div>';	
		
		$email = array($supp['email'], 'farhanasim@gmail.com');
	
		send_mail($email, $subject, $body);
	}
}

function generate_products($prm, $id = '')
{
	global $db;
	if($id != '')
	{
		$prms = $db->Execute("select * from ".DB_TABLE_PREFIX."products_params where prd_id = '$id' order by id asc");
		$inc = 0;
		while(!$prms->EOF)
		{
			$inc++;
			
			$_POST['param_name_'.$inc] = $prms->fields('param_name');
			$_POST['param_type_'.$inc] = $prms->fields('param_type');
			$_POST['show_other_'.$inc] = $prms->fields('show_other');
			$_POST['param_value_'.$inc] = $prms->fields('param_value');
			
			$prms->MoveNext();
		}	$prms->Close();
	}
	
	for($i = 1 ; $i <= $prm ; $i++)
	{
		$param_name = stripslashes($_POST['param_name_'.$i]);
		$param_value = stripslashes($_POST['param_value_'.$i]);
		
		if($_POST['param_type_'.$i] == 'text' || $_POST['param_type_'.$i] == '') $dis = 'style="display:none;"';
		
?>
<table width="100%" cellpadding="2" cellspacing="1" border="0">
	<tr>
      <td colspan="2" align="left" class="data_row"><strong>Parameter # <?=$i;?></strong></td>
    </tr>
    <tr>
      <td width="25%" align="left" class="data_row">Parameter Name:</td>
      <td width="75%" align="left"><input name="param_name_<?=$i;?>" type="text" class="text" id="param_name_<?=$i;?>" size="30" maxlength="128" value="<?=$param_name;?>" /></td>
    </tr>
    <tr>
      <td align="left" class="data_row">Parameter Type:</td>
      <td align="left">
            <label><input type="radio" name="param_type_<?=$i;?>" id="param_type_<?=$i;?>" value="text" <? if($_POST['param_type_'.$i] == 'text') echo 'checked="checked"'; ?> onClick="if(this.checked) $('#td_other_<?=$i;?>').hide();" />
            Text Input</label>
            <label><input type="radio" name="param_type_<?=$i;?>" id="param_type_<?=$i;?>" value="radio" <? if($_POST['param_type_'.$i] == 'radio') echo 'checked="checked"'; ?> onClick="if(this.checked) $('#td_other_<?=$i;?>').show();" /> 
            Radio Button (Single Selection)</label>
            <label><input type="radio" name="param_type_<?=$i;?>" id="param_type_<?=$i;?>" value="checkbox" <? if($_POST['param_type_'.$i] == 'checkbox') echo 'checked="checked"'; ?> onClick="if(this.checked) $('#td_other_<?=$i;?>').show();" />
            Checkbox (Multi Selection)</label></td>
    </tr>
    <tr id="td_other_<?=$i;?>" <?=$dis;?>>
      <td align="left" class="data_row">Show "Other (Not Listed)" Option:</td>
      <td align="left"><label>
        <input type="radio" name="show_other_<?=$i;?>" id="other_<?=$i;?>" value="Y" <? if($_POST['show_other_'.$i] == 'Y') echo 'checked="checked"'; ?> />
        Yes</label>
        <label>
        <input type="radio" name="show_other_<?=$i;?>" id="other_<?=$i;?>" value="N" <? if($_POST['show_other_'.$i] == 'N') echo 'checked="checked"'; ?> />
        No</label>
        </td>
    </tr>
    <tr>
      <td align="left" class="data_row">Parameter Value(s):</td>
      <td align="left"><textarea name="param_value_<?=$i;?>" cols="30" rows="6" class="text" id="param_value_<?=$i;?>"><?=$param_value;?></textarea></td>
    </tr>
    </table>
<?	
	}
}

function access_denied()
{
	$msg = urlencode("You don't have permission to access this section.");
	redirect("home.php?msg=$msg&cs=er");
}

function show_status($status, $id, $name = 'status')
{
	if($status == 'Y')
	{
		$caption_active = 'Active';
		$caption_inactive = 'De-activate';
		$dis_class_a = '';
		$dis_class_i = ' hide';
		$chk_y = 'checked="checked"';
		$chk_n = '';
	}
	else
	{
		$caption_active = 'Activate';
		$caption_inactive = 'In-active';
		$dis_class_a = ' hide';
		$dis_class_i = '';
		$chk_y = '';
		$chk_n = 'checked="checked"';
	}
	$str = '
	<label for="'.$name.'_'.$id.'_N" id="'.$name.'_label_'.$id.'_Y" class="st_active'.$dis_class_a.'" onclick="toggle_status(this,\'Y\','.$id.',\''.$name.'\');">'.$caption_active.'</label>
	<label for="'.$name.'_'.$id.'_Y" id="'.$name.'_label_'.$id.'_N" class="st_inactive'.$dis_class_i.'" onclick="toggle_status(this,\'N\','.$id.',\''.$name.'\');">'.$caption_inactive.'</label>
	<div class="hide">
	<input name="'.$name.'_'.$id.'" type="radio" class="no_bdr" id="'.$name.'_'.$id.'_Y" value="Y" '.$chk_y.' />
	<input name="'.$name.'_'.$id.'" type="radio" class="no_bdr" id="'.$name.'_'.$id.'_N" value="N" '.$chk_n.' />
	</div>';
	
	return $str;
}

function send_approval_email($user_id)
{
	global $db;
	global $G_TITLE;

	$row = $db->GetRow("select title, first_name, last_name, email, username from ".DB_TABLE_PREFIX."users where id = '$user_id'");
	extract($row);
	
	$member_name = $G_TITLE[$title].' '.$first_name.' '.$last_name;

	// To User
	$email_text = $db->GetRow("select * from ".DB_TABLE_PREFIX."email_notifications where id = '6'");
	if($email_text['send_email'] == 'Y')
	{	
		$subject = stripslashes(str_replace('{COMPANY_NAME}', COMPANY_NAME, $email_text['subject']));
		
		$login_link = BASE_PATH.'?sl=true';
		
		$body = str_replace('{MEMBER_NAME}', $member_name, $email_text['email_text']);
		$body = str_replace('{USERNAME}', $username, $body);
		$body = str_replace('{ACCOUNT_LINK}', $login_link, $body);
		$body = str_replace('{COMPANY_NAME}', COMPANY_NAME, $body);
		
		$body = stripslashes('<div style="font-family:Tahoma; font-size:12px;">'.$body.'</div>');
		
		$emails = array($email, 'farhanasim@gmail.com');
		send_mail($emails, $subject, $body);				
	}
	// To User
}

function send_mail($email, $subject, $body, $sender = '', $has_names = false)
{
	global $db;
	
	$mime_boundary = "----".COMPANY_NAME."----".md5(time()); 
	
	$headers = "From: ".COMPANY_NAME." <".COMPANY_WEBMASTER.">\n";
	
	if($sender == '')
		$headers .= "Reply-To: ".COMPANY_NAME." <".COMPANY_WEBMASTER.">\n";
	else
		$headers .= "Reply-To: ".$sender."\n";
		
	$headers .= "MIME-Version: 1.0\n";
	$headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n"; 
	
	$message .= "--$mime_boundary\n";
	$message .= "Content-Type: text/html; charset=UTF-8\n";
	$message .= "Content-Transfer-Encoding: 8bit\n\n"; 
	$message .= $body;
	
	$message .= "<br /><br />--$mime_boundary--\n\n"; 
	
	if($has_names)
	{
		foreach($email as $k => $v)
		{
			if(($v) != '')
			{
				$eml = "$k <$v>";
				@mail($eml, $subject, $message, $headers);
			}
		}
	}
	else
	{
		foreach($email as $v)
		{
			if(($v) != '')
			{
				$eml = "$v";
				@mail($eml, $subject, $message, $headers);
			}
		}
	}
}


function gen_order_id($id, $prefix = 'Q')
{
	$pat = '000000';
	$gen_id = $prefix .'-'.substr($pat,0,strlen($pat)-strlen($id)).$id;
	return $gen_id;
}

function bread_crumb($page_id)
{
	global $db;

	$current_row = $db->GetRow("select id, parent_id, page_name, seo_name from ".DB_TABLE_PREFIX."web_pages where id = '$page_id'");	
	
	$bc_array[] = array('seo_name' => $current_row['seo_name'], 'page_name' => $current_row['page_name']);
	if($current_row['parent_id'] != '0')
	{
		$loop = true;
		$fetch_id = $current_row['parent_id'];
		while($loop)
		{
			$sub_row = $db->GetRow("select id, parent_id, page_name, seo_name from ".DB_TABLE_PREFIX."web_pages where id = '$fetch_id'");	
			$fetch_id = $sub_row['parent_id'];
			$bc_array[] = array('seo_name' => $sub_row['seo_name'], 'page_name' => $sub_row['page_name']);
			if($sub_row['parent_id'] == '0')
				$loop = false;
		}
	}	

	foreach($bc_array as $v)	
	{
		extract($v);
		//$link_str[] = '<a href="'.ROOT_DIR.$seo_name.'">'. stripslashes($page_name) .'</a>';
		$link_str[] = stripslashes($page_name);
	}
	$link_str = array_reverse($link_str);
	//return $link_str = '<a href="'.ROOT_DIR.'">Home</a> &raquo; '.implode(' &raquo; ', $link_str);
	return $link_str = 'Home &raquo; '.implode(' &raquo; ', $link_str);
}

function week_dates()
{
	$diff = date('N');
	$start_date = date('Ymd', strtotime('-'.$diff.' days'));
	$end_date = date('Ymd', strtotime('+6 Days', strtotime($start_date)));
	$ar_time['start_date'] = $start_date;
	$ar_time['end_date'] = $end_date;
	return $ar_time;
}

///
class tableExtractor {

	var $source            = NULL;
	var $anchor            = NULL;
	var $anchorWithin    = false;
	var $headerRow        = true;
	var $startRow        = 0;
	var $maxRows        = 0;
	var $startCol        = 0;
	var $maxCols        = 0;
	var $stripTags        = false;
	var $extraCols        = array();
	var $rowCount        = 0;
	var $dropRows        = NULL;
	
	var $cleanHTML        = NULL;
	var $rawArray        = NULL;
	var $finalArray        = NULL;
	
	function extractTable() {
	
		$this->cleanHTML();
		$this->prepareArray();
		
		return $this->createArray();
		
	}


	function cleanHTML() {
	
		// php 4 compatibility functions
		if(!function_exists('stripos')) {
			function stripos($haystack,$needle,$offset = 0) {
			   return(strpos(strtolower($haystack),strtolower($needle),$offset));
			}
		}
					
		// find unique string that appears before the table you want to extract
		if ($this->anchorWithin) {
			/*------------------------------------------------------------
				With thanks to Khary Sharp for suggesting and writing
				the anchor within functionality.
			------------------------------------------------------------*/                
			$anchorPos = stripos($this->source, $this->anchor) + strlen($this->anchor);
			$sourceSnippet = strrev(substr($this->source, 0, $anchorPos));
			$tablePos = stripos($sourceSnippet, strrev(("<table"))) + 6;
			$startSearch = strlen($sourceSnippet) - $tablePos;
		}                       
		else {
			$startSearch = stripos($this->source, $this->anchor);
		}
	
		// extract table
		$startTable = stripos($this->source, '<table', $startSearch);
		$endTable = stripos($this->source, '</table>', $startTable) + 8;
		$table = substr($this->source, $startTable, $endTable - $startTable);
	
		if(!function_exists('lcase_tags')) {
			function lcase_tags($input) {
				return strtolower($input[0]);
			}
		}
		
		// lowercase all table related tags
		$table = preg_replace_callback('/<(\/?)(table|tr|th|td)/is', 'lcase_tags', $table);
		
		// remove all thead and tbody tags
		$table = preg_replace('/<\/?(thead|tbody).*?>/is', '', $table);
		
		// replace th tags with td tags
		$table = preg_replace('/<(\/?)th(.*?)>/is', '<$1td$2>', $table);
								
		// clean string
		$table = trim($table);
		$table = str_replace("\r\n", "", $table); 
						
		$this->cleanHTML = $table;
	
	}
	
	function prepareArray() {
	
		// split table into individual elements
		$pattern = '/(<\/?(?:tr|td).*?>)/is';
		$table = preg_split($pattern, $this->cleanHTML, -1, PREG_SPLIT_DELIM_CAPTURE);    

		// define array for new table
		$tableCleaned = array();
		
		// define variables for looping through table
		$rowCount = 0;
		$colCount = 1;
		$trOpen = false;
		$tdOpen = false;
		
		// loop through table
		foreach($table as $item) {
		
			// trim item
			$item = str_replace(' ', ' ', $item);
			$item = trim($item);
			
			// save the item
			$itemUnedited = $item;
			
			// clean if tag                                    
			$item = preg_replace('/<(\/?)(table|tr|td).*?>/is', '<$1$2>', $item);

			// pick item type
			switch ($item) {
				

				case '<tr>':
					// start a new row
					$rowCount++;
					$colCount = 1;
					$trOpen = true;
					break;
					
				case '<td>':
					// save the td tag for later use
					$tdTag = $itemUnedited;
					$tdOpen = true;
					break;
					
				case '</td>':
					$tdOpen = false;
					break;
					
				case '</tr>':
					$trOpen = false;
					break;
					
				default :
				
					// if a TD tag is open
					if($tdOpen) {
					
						// check if td tag contained colspan                                            
						if(preg_match('/<td [^>]*colspan\s*=\s*(?:\'|")?\s*([0-9]+)[^>]*>/is', $tdTag, $matches))
							$colspan = $matches[1];
						else
							$colspan = 1;
												
						// check if td tag contained rowspan
						if(preg_match('/<td [^>]*rowspan\s*=\s*(?:\'|")?\s*([0-9]+)[^>]*>/is', $tdTag, $matches))
							$rowspan = $matches[1];
						else
							$rowspan = 0;
							
						// loop over the colspans
						for($c = 0; $c < $colspan; $c++) {
												
							// if the item data has not already been defined by a rowspan loop, set it
							if(!isset($tableCleaned[$rowCount][$colCount]))
								$tableCleaned[$rowCount][$colCount] = $item;
							else
								$tableCleaned[$rowCount][$colCount + 1] = $item;
								
							// create new rowCount variable for looping through rowspans
							$futureRows = $rowCount;
							
							// loop through row spans
							for($r = 1; $r < $rowspan; $r++) {
								$futureRows++;                                    
								if($colspan > 1)
									$tableCleaned[$futureRows][$colCount + 1] = $item;
								else                    
									$tableCleaned[$futureRows][$colCount] = $item;
							}

							// increase column count
							$colCount++;
						
						}
						
						// sort the row array by the column keys (as inserting rowspans screws up the order)
						ksort($tableCleaned[$rowCount]);
					}
					break;
			}    
		}
		// set row count
		if($this->headerRow)
			$this->rowCount    = count($tableCleaned) - 1;
		else
			$this->rowCount    = count($tableCleaned);
		
		$this->rawArray = $tableCleaned;
		
	}
	
	function createArray() {
		
		// define array to store table data
		$tableData = array();
		
		// get column headers
		if($this->headerRow) {
		
			// trim string
			$row = $this->rawArray[$this->headerRow];
						
			// set column names array
			$columnNames = array();
			$uniqueNames = array();
					
			// loop over column names
			$colCount = 0;
			foreach($row as $cell) {
							
				$colCount++;
				
				$cell = strip_tags($cell);
				$cell = trim($cell);
				
				// save name if there is one, otherwise save index
				if($cell) {
				
					if(isset($uniqueNames[$cell])) {
						$uniqueNames[$cell]++;
						$cell .= ' ('.($uniqueNames[$cell] + 1).')';    
					}            
					else {
						$uniqueNames[$cell] = 0;
					}

					$columnNames[$colCount] = $cell;
					
				}                        
				else
					$columnNames[$colCount] = $colCount;
				
			}
			
			// remove the headers row from the table
			unset($this->rawArray[$this->headerRow]);

		}
		
		// remove rows to drop
		foreach(explode(',', $this->dropRows) as $key => $value) {
			unset($this->rawArray[$value]);
		}
							
		// set the end row
		if($this->maxRows)
			$endRow = $this->startRow + $this->maxRows - 1;
		else
			$endRow = count($this->rawArray);
			
		// loop over row array
		$rowCount = 0;
		$newRowCount = 0;                            
		foreach($this->rawArray as $row) {
		
			$rowCount++;
			
			// if the row was requested then add it
			if($rowCount >= $this->startRow && $rowCount <= $endRow) {
			
				$newRowCount++;
								
				// create new array to store data
				$tableData[$newRowCount] = array();
				
				//$tableData[$newRowCount]['origRow'] = $rowCount;
				//$tableData[$newRowCount]['data'] = array();
				$tableData[$newRowCount] = array();
				
				// set the end column
				if($this->maxCols)
					$endCol = $this->startCol + $this->maxCols - 1;
				else
					$endCol = count($row);
				
				// loop over cell array
				$colCount = 0;
				$newColCount = 0;                                
				foreach($row as $cell) {
				
					$colCount++;
					
					// if the column was requested then add it
					if($colCount >= $this->startCol && $colCount <= $endCol) {
				
						$newColCount++;
						
						if($this->extraCols) {
							foreach($this->extraCols as $extraColumn) {
								if($extraColumn['column'] == $colCount) {
									if(preg_match($extraColumn['regex'], $cell, $matches)) {
										if(is_array($extraColumn['names'])) {
											$this->extraColsCount = 0;
											foreach($extraColumn['names'] as $extraColumnSub) {
												$this->extraColsCount++;
												$tableData[$newRowCount][$extraColumnSub] = $matches[$this->extraColsCount];
											}                                        
										} else {
											$tableData[$newRowCount][$extraColumn['names']] = $matches[1];
										}
									} else {
										$this->extraColsCount = 0;
										if(is_array($extraColumn['names'])) {
											$this->extraColsCount = 0;
											foreach($extraColumn['names'] as $extraColumnSub) {
												$this->extraColsCount++;
												$tableData[$newRowCount][$extraColumnSub] = '';
											}                                        
										} else {
											$tableData[$newRowCount][$extraColumn['names']] = '';
										}
									}
								}
							}
						}
						
						if($this->stripTags)        
							$cell = strip_tags($cell);
						
						// set the column key as the column number
						$colKey = $newColCount;
						
						// if there is a table header, use the column name as the key
						if($this->headerRow)
							if(isset($columnNames[$colCount]))
								$colKey = $columnNames[$colCount];
						
						// add the data to the array
						//$tableData[$newRowCount]['data'][$colKey] = $cell;
						$tableData[$newRowCount][$colKey] = $cell;
					}
				}
			}
		}
				
		$this->finalArray = $tableData;
		return $tableData;
	}    
}

// 



function gen_lead_id($id)
{
	$pat = '000000';
	$lead_id = 'ACM-'.substr($pat,0,strlen($pat)-strlen($id)).$id;
	return $lead_id;
}

function generate_form($form_id, $cmd = 'live', $lp_id = '', $subscribe = false)
{
	global $db, $imp_product_ids, $promo_id, $page_from;
	if($cmd == 'demo') $demo_str = 'onclick="alert(\'Form demo, submission functionality will be on client end.\'); return false;"';
	$rs = $db->Execute("select * from ".DB_TABLE_PREFIX."forms_fields where form_id = '$form_id' order by pos asc");
	$html = '
	<form name="frm_landing_'.$form_id.'" id="frm_landing_'.$form_id.'" action="" method="post">
		<table width="100%" border="0" cellspacing="1" cellpadding="3">';
		while(!$rs->EOF)
		{  
			$test_v = strtolower($rs->fields('caption'));
			
			if($rs->fields('is_required') == 'Y')
			{
				$req = '*';
				if($rs->fields('text_type') == 'text')
					$req_code = ' validate[required]';
				elseif($rs->fields('text_type') == 'email')
					$req_code = ' validate[required,custom[email]] text-input';
				elseif($rs->fields('text_type') == 'phone')
					$req_code = ' validate[required,custom[telephone]] text-input';
				else
					$req_code = ' validate[required,custom[fax]] text-input';
				
				if($rs->fields('field_type') == 'checkbox')
					$req_code = ' validate[minCheckbox[1]] checkbox';
				elseif($rs->fields('field_type') == 'radio')
					$req_code = ' validate[required] radio';
				
			}
			else
			{
				$req = '';
				$req_code = '';
			}
			
			$field_name = 'frm_field_'.$rs->fields('id');
			$field_caption = 'frm_caption_'.$rs->fields('id');
			
			
		  $html .= '<tr>
			<td width="45%">'. stripslashes($rs->fields('caption')) .': '. $req .'</td>
			<td width="55%">';
			
			$html .= '<input type="hidden" name="'.$field_caption.'" id="'.$field_caption.'" value="'. $rs->fields('caption') .'" />';
			$html .= '<input type="hidden" name="form_ids[]" id="form_ids[]" value="'. $rs->fields('id') .'" />';
			
			if($rs->fields('field_type') == 'text')
			{
				if($rs->fields('max_length') > 0) $len = 'maxlength="'. $rs->fields('max_length') .'"';
				else $len = '';
				
				$html .= '<input type="text" name="'.$field_name.'" id="'.$field_name.'" '. $len .' size="30" class="txt_input '.$req_code.'" />';
			}
			elseif($rs->fields('field_type') == 'textarea')
			{
				$html .= '<textarea name="'.$field_name.'" cols="50" rows="5" id="'.$field_name.'" class="txt_input '.$req_code.'"></textarea>';
			}
			else
			{
				$options = $db->Execute("select * from ".DB_TABLE_PREFIX."forms_fields_options where form_field_id = '". $rs->fields('id') ."' order by pos asc");		  
				
				if($rs->fields('field_type') == 'combo')
				{
					$html .= '<select name="'.$field_name.'" id="'.$field_name.'" class="txt_input '.$req_code.'">
								<option value="">Please Select ...</option>';
					
								$country_check = $db->GetOne("select id from ".DB_TABLE_PREFIX."forms_fields_options where form_field_id = '". $rs->fields('id') ."' and is_country = 'Y'");
								if($country_check > 0)
								{
									$cnts = $db->Execute("select country_name, iso2 from ".DB_TABLE_PREFIX."countries order by country_name asc");
									while(!$cnts->EOF)
									{
										$html .= '<option value="'.stripslashes($cnts->fields('country_name')).'">'.stripslashes($cnts->fields('country_name')).'</option>';	
										$cnts->MoveNext();
									}	$cnts->Close();
								}
								else
								{
									while(!$options->EOF)
									{
										$html .= '<option value="'.stripslashes($options->fields('option_value')).'">'.stripslashes($options->fields('option_name')).'</option>';	
										$options->MoveNext();
									}	$options->Close();
								}
								
					$html .= '</select>';
				}
				elseif($rs->fields('field_type') == 'checkbox')
				{
					$field_name_1 = $field_name;
					$field_name = $field_name.'[]';
					while(!$options->EOF)
					{
						$field_name_id = $field_name_1.'_'.$options->fields('id');
						$html .= '<label><input type="checkbox" name="'.$field_name.'" id="'.$field_name_id.'" value="'.stripslashes($options->fields('option_value')).'" class="'.$req_code.'" /> '.stripslashes($options->fields('option_name')).' </label>';	
						$options->MoveNext();
					}	$options->Close();			
				}
				elseif($rs->fields('field_type') == 'radio')
				{
					while(!$options->EOF)
					{
						$html .= '<label><input name="'.$field_name.'" id="'.$field_name.'" type="radio" value="'.stripslashes($options->fields('option_value')).'" class="'.$req_code.'" /> '.stripslashes($options->fields('option_name')).'</label>';	
						$options->MoveNext();
					}	$options->Close();					
				}
			}
			
			
			$html .='
			</td>
		  </tr>';
		  	$rs->MoveNext();
		}  	$rs->Close();
		
	$html .= '	
		<tr>
			<td valign="bottom" style="padding-bottom:5px;">
				Security Code: *
			</td>
			<td>
				
				<img id="siimage" style="padding-right: 5px; border: 0" src="'.ROOT_DIR.'captcha/securimage_show.php?sid='.md5(time()).'" />
				
				<br />
        		<a tabindex="-1" style="border-style: none" href="#" title="Refresh Image" onClick="document.getElementById(\'siimage\').src = \''.ROOT_DIR.'captcha/securimage_show.php?sid=\' + Math.random(); return false"><img src="'.ROOT_DIR.'captcha/images/refresh.gif" alt="Reload Image" border="0" onClick="this.blur()" align="bottom" /></a>
		
				
				<br />
				<input type="text" name="code" id="code" class="txt_input validate[required]" size="12" />
				
				
			</td>
		</tr>
		<tr>
			<td>
				* required
				<input type="hidden" name="save" id="save" value="yes" />
				<input type="hidden" name="imp_product_ids" id="imp_product_ids" value="'. $imp_product_ids .'" />
				<input type="hidden" name="form_id" id="form_id" value="'.$form_id.'" />
				<input type="hidden" name="page_from" id="page_from" value="'.$page_from.'" />
				<input type="hidden" name="url_referral" id="url_referral" value="http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] .'" />
				<input type="hidden" name="promo_id" id="promo_id" value="'.$promo_id.'" />
				<input type="hidden" name="lp_id" id="lp_id" value="'.$lp_id.'" />
			</td>
			<td><input type="submit" name="btn_submit" id="btn_submit" class="btns" value="Submit" '.$demo_str.' /></td>
		</tr>';
		if($subscribe) 
		{
			$html .= '	
			<tr>
				<td colspan="2">You will also be added to our mailing list and can unsubscibe from at any time.<input type="hidden" name="subscribe" id="subscribe" value="yes" /></td>			
			</tr>  ';
		}		
		$html .= '
		</table>
	</form>
	';
	
	return $html;
}

function show_banner_new($area_id)
{
	global $db;
	$banner_dir = 'up_data/banners/';
	//if($page_id != '') $sql_page_id = " and find_in_set($page_id, page_id) ";
	// $rs_banner = $db->GetRow("select * from ".DB_TABLE_PREFIX."banners where status = 1 and area_id = '$area_id' $sql_page_id order by rand() limit 1");
	
	if($area_id < 3) $limit = " LIMIT 1";
	
	$rs_banner = $db->Execute("select * from ".DB_TABLE_PREFIX."banners where status = 'Y' and area_id = '$area_id' order by rand() $limit");
	
	$bs = $db->GetRow("SELECT width, height FROM ".DB_TABLE_PREFIX."banner_areas WHERE id = '$area_id'");
	
	while(!$rs_banner->EOF)
	{
		$banner = 'banner'.$rs_banner->fields('id').$rs_banner->fields('ext');
		$banner_path = ROOT_DIR.$banner_dir.$banner;
		
	
		if($rs_banner->fields('id') != '')
		{
			if($rs_banner->fields('banner_code') != '')
			{
				$banner_str .= stripslashes($rs_banner->fields('banner_code'));
			}
			
			$file_size = @getimagesize($banner_path);
			
			$ext = $rs_banner->fields('ext');
			
			if($ext == ".swf") /// IF  --  Flash Banner
			{
				$banner_str = '
				<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" '.$file_size[3].' ALIGN="">
						<param name="wmode" value="transparent"><PARAM NAME="FlashVars" VALUE=""><PARAM NAME="movie" value="'.$banner_path.'"><PARAM NAME="quality" VALUE="high"><PARAM NAME="menu" VALUE="true"><PARAM NAME="scale" VALUE="noscale"><PARAM NAME="salign" VALUE="LT"><PARAM NAME="BASE" VALUE=""><EMBED src="'.$banner_path.'" FlashVars="" menu="false" quality="high" scale="noscale" salign="LT" '.$file_size[3].' ALIGN="" TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer" BASE=""></EMBED></OBJECT>
				';				
			}	/// IF   --   Flash Banner
			else ////   Other than Flash Banner
			{ 
				$img = pic_thumb($banner, $bs['width'], $bs['height'], 'banner', $rs_banner->fields('detail'), '', false);
				
				if($rs_banner->fields('linkURL') == '') $banner_str .= '<img alt="'.stripslashes( $rs_banner->fields('detail') ).'" src="'.$img.'" />'; /// if Link is Given
				else $banner_str .= '<a href="'.ROOT_DIR.'open/'. $rs_banner->fields('id') .'/'.base64_encode( $rs_banner->fields('linkURL') ).'" target="'. $rs_banner->fields('target') .'"><img alt="'.stripslashes($rs_banner->fields('detail')).'" src="'.$img.'" border="0" /></a>'; /// widthout link banner
			}			
		} /// if num rows	
		
		$rs_banner->MoveNext();
	}	$rs_banner->Close();
	
		
	return $banner_str;
}

function show_banner($page_id)
{
	global $db;
		$banner_dir = 'up_data/banners/banner';
		$rs_banner = $db->GetRow("select * from ".DB_TABLE_PREFIX."banners where status = 1 and page_id = '".$page_id."' order by rand() limit 1");
 	
		/*if($rs_banner['id'] == '')
		{
			$banner_path = ROOT_DIR.'up_data/banners/default.jpg';
			$rs_banner['ext'] = '.jpg';
			$rs_banner['id'] = '0';
		}
		else	*/
			$banner_path = ROOT_DIR.$banner_dir.$rs_banner['id'].$rs_banner['ext'];
		
			
		if($rs_banner['id'] != '')
		{
			if($rs_banner['banner_code'] !='')
			{
				return stripslashes($rs_banner['banner_code']);
			}
			
			$file_size = @getimagesize($banner_path);
			
			if($rs_banner['ext'] == ".swf") /// IF  --  Flash Banner
			{
				$banner_str = '
				
				<script type="text/javascript">
							FL_RunContent( 
							\'codebase\',\'http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0\',
							\'pluginspage\',\'http://www.macromedia.com/go/getflashplayer\',
							\'name\',\'myflash\',
							\'id\',\'myflash\',
							\'width\',\''.$file_size[0].'\',
							\'height\',\''.$file_size[1].'\',
							\'BASE\',\'\',
							\'align\',\'\',
							\'salign\',\'LT\',
							\'src\',\''.$banner_path.'\',
							\'movie\',\''.$banner_path.'\',
							\'flashvars\',\'\',
							\'menu\',\'true\',
							\'scale\',\'noscale\',
							\'quality\',\'high\'
							); //end ActivsteFlash
							</script>
						<noscript>
						<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" '.$file_size[3].' ALIGN="">
					    <PARAM NAME="FlashVars" VALUE=""><PARAM NAME="movie" value="'.$banner_path.'"><PARAM NAME="quality" VALUE="high"><PARAM NAME="menu" VALUE="true"><PARAM NAME="scale" VALUE="noscale"><PARAM NAME="salign" VALUE="LT"><PARAM NAME="BASE" VALUE=""><EMBED src="'.$banner_path.'" FlashVars="" menu="false" quality="high" scale="noscale" salign="LT" '.$file_size[3].' ALIGN="" TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer" BASE=""></EMBED></OBJECT></noscript>
				
				';				
			}	/// IF   --   Flash Banner
			else ////   Other than Flash Banner
			{ 
				if(empty($rs_banner['linkURL'])) $banner_str = '<img alt="'.stripslashes($rs_banner['detail']).'" src="'.$banner_path.'">'; /// if Link is Given
				else $banner_str = '<a href="'.ROOT_DIR.'open/'.$rs_banner['id'].'/'.base64_encode($rs_banner['linkURL']).'" target="'.$rs_banner['target'].'"><img alt="'.stripslashes($rs_banner['detail']).'" src="'.$banner_path.'" border="0"></a>'; /// widthout link banner
			}			
		} /// if num rows		
		return $banner_str;
}

function no_results()
{
	return '<strong>Sorry!</strong>, no results found.';
}

function print_user_title($page_title = '')
{
	if($page_title == '') 
		return stripslashes(COMPANY_NAME);
	else
		return stripslashes($page_title);
}

function print_admin_title($page_title = '')
{
	if($page_title != '') $title = $page_title.' - ';
	return stripslashes($title.ADMIN_HEADER_NOTE);
}

function check_alpha_numeric($field)
{
	$strings = array($field);
	foreach ($strings as $testcase) 
	{
		if(!ctype_alnum($testcase))
			return false;
		else
			return true;
	}
}

function generate_random_value($length=6,$level=1)
{
	list($usec, $sec) = explode(' ', microtime());
	srand((float) $sec + ((float) $usec * 100000));
   
	$validchars[1] = "123456789ABCDEFGHIJKLMNPQRSTUVWXYZ";
	$validchars[2] = "0123456789abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$validchars[3] = "0123456789_!@#$%&*()-=+/abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_!@#$%&*()-=+/";

	$value  = "";
	$counter   = 0;

	while ($counter < $length) 
	{
		$actChar = substr($validchars[$level], rand(0, strlen($validchars[$level])-1), 1);
		
		if(!strstr($value, $actChar)) 
		{
			$value .= $actChar;
			$counter++;
		}
	}
	
	return $value;
}

function pageing_execute($sql, $npage = '')
{	
	global $no_of_rows, $total_records, $db;
	if($npage == '')
		global $page_no;
	else
		$page_no  = $npage;

	$result = $db->Execute($sql);
	$total_records = $result->RecordCount();

	if (!isset($page_no)) $page_no = 0;
		
	$page_no = (int) $page_no;
	
	$start = $page_no * $no_of_rows;
	
	$sql .=" LIMIT $start,$no_of_rows";
	$result = $db->Execute($sql);
		
	return $result;
}

function links($npage = '', $page_v = '')
{
	if($page_v == '') $page_v = 'page';

	global $no_of_rows,$total_records,$num_to_show;
	if($npage == '')
		global $page_no;
	else
		$page_no  = $npage;
	
	list($fullfile, $voided) = explode("?", $_SERVER["REQUEST_URI"]);
	$arr_val = explode("?",$_SERVER["REQUEST_URI"]);
	$arr_parameters = explode("&".$page_v."=",$arr_val[1]);
	$parameters = $arr_parameters[0];
	$file = $fullfile;
	
	
	$no_of_pages = ceil($total_records/$no_of_rows);
	
	$path = $_REQUEST["REQUEST_URI"];
	for ($i=1;$i<=strlen($path);$i++){
		if (substr($path,-$i,1)=="/"){
			$file = substr($path,-$i+1);
			break;
		}
	}
	if(strpos($file,"?") || $parameters!=""){
		$var_val = "&";
		$parameters = "?".$parameters;
	}
	else{
		$var_val = "?";
	}
	if ($total_records > $no_of_rows) {

		if (!($page_no == 0)){
			$str .= " <a href='"; 
			$str .=  $file; 
			$str .=  $parameters.$var_val."". $page_v ."=";
			$str .=  $page_no - 1;
			$str .= "' ><strong>Previous</strong></a> ";
		}
		else{		
			$str .= "<strong>Previous</strong>";
		}


		/* get current page */
		$current_page = $page_no + 1;
					
		if ($current_page >= 6 && $no_of_pages > 10) {
			$from_nav = $current_page - 5;
			$to_nav = $current_page + 5;
			
			if ($to_nav > $no_of_pages) {
				$to_nav = $no_of_pages;
				$from_nav = $no_of_pages - 10;
			}
		}
		else {
			$from_nav = 0;
			
			if ($no_of_pages < 10)
				$to_nav = $no_of_pages;
			else
				$to_nav = 10;
		}

		for ( $i=$from_nav ; $i< $to_nav ; $i++) {
			$str .= " ";
			if ($page_no != $i) {
				$str .= " <a href='$file".$parameters.$var_val."".$page_v."=$i'>";
				$str .= $i+1;
				$str .= "</a> ";
			}
			else {
				$str .= ' <strong class="LpText">' . $current_page . '</strong> ';
			}

		}

		
		
		
		
	
		if (!($page_no >= $no_of_pages-1)){
			$str .= " <a href='"; 
			$str .=  $file; 
			$str .=  $parameters.$var_val."".$page_v."=";
			$str .=  $page_no + 1;
			$str .= "' ><strong>Next</strong></a> ";
		}
		else{		
			$str .= "<strong>Next</strong>";
		}
	
		
	}
	return $str;
}

function generate_file_name($file_name, $sep = '_')
{
	$old_pattern = array("/[^a-zA-Z0-9.]/", "/$sep+/", "/$sep$/");
	$new_pattern = array($sep, $sep, "");
	$file_name = preg_replace($old_pattern, $new_pattern , strtolower($file_name));
	return $file_name;
}



function caution_new($msg, $cs, $errors = '')
{
	
	if($cs == 'er' || $errors != '')
	{
		$cs = "note-error";
		$cap = 'Error Notification';
	}
	elseif($cs == '' || $cs == 'ok')
	{
		$cs = "note-success";
		$cap = 'Success Notification';
	}
	elseif($cs == 'info')
	{
		$cs = "note-info";
		$cap = 'Information Notification';
	}
	elseif($cs == 'att')
	{
		$cs = "note-attention";
		$cap = 'Attention Notification';
	}
	
	if($errors == '')
	{
		if($msg != '')
			$message = $msg;
	}
	else $message = $errors;
	
	if(trim($message) != '')
	{
		$str = '<div class="notification '. $cs .'">
				<a href="#" class="close" title="Close notification"><span>close</span></a>
				<span class="icon"></span>
				<p><strong>'.$cap.':</strong><br />
				'. stripslashes(stripslashes(urldecode($message))) .'</p>
		</div>';
		return $str;
	}	
} /// end caution



function print_errors($errors, $tag = 'span', $cs = 'er')
{
	global $login_page;
	
	if($cs == '' || $cs == 'ok') { $cs = 'er'; $cl = '#F00'; } else $cl = '#090';
	
	if($errors != '') $str = '<'.$tag.' class="'.$cs.'" style="color:'. $cl .';"><strong>Error(s)</strong><br><img src="images/spacer.gif" height="8" width="1" /><br><span style="font-weight:normal;">'.$errors.'</span></'.$tag.'>';
	if($login_page != 'yes') $str .= '<br><img src="images/spacer.gif" height="8" width="1" />';
	return $str;
}

function caution($msg, $cs, $tag, $errors = '')
{
	if($errors == '')
	{
		if(!empty($msg))
		{
			if(empty($cs)) { $cs = "ok"; }
			
				return '<'.$tag.' class="'.$cs.'">'.stripslashes(stripslashes(urldecode($msg))).'</'.$tag.'><br><img src="'.ROOT_DIR.'images/spacer.gif" height="8" width="1" />';
		}
	}
	else return print_errors($errors, 'span', $cs);
} /// end caution
	
function redirect($url)
{
	header("location:".$url);
	exit;
} // end redirect
	

function js_redirect($url,$html)
{
	if(!$html)
	{
		echo '
			<script language="javascript">
			<!--
			location.href="'.$url.'";
			-->
			</script>
		';
	}
	else
	{
			echo '
				<html>
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
				<title>Redirecting...</title>
				</head>
				<body>
				<script language="javascript">
				<!--
				location.href="'.$url.'";
				-->
				</script>
				</body>
				</html>
				';
	}

} // end js_redirect

function dl_file($file){

   //First, see if the file exists
   if (!is_file($file)) { die("<b>404 File not found!</b>"); }

   //Gather relevent info about file
   $len = filesize($file);
   $filename = basename($file);
   $file_extension = strtolower(substr(strrchr($filename,"."),1));

   //This will set the Content-Type to the appropriate setting for the file
   switch( $file_extension ) {
     case "pdf": $ctype="application/pdf"; break;
     case "exe": $ctype="application/octet-stream"; break;
     case "zip": $ctype="application/zip"; break;
     case "doc": $ctype="application/msword"; break;
     case "xls": $ctype="application/vnd.ms-excel"; break;
     case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
     case "gif": $ctype="image/gif"; break;
     case "png": $ctype="image/png"; break;
     case "jpeg":
     case "jpg": $ctype="image/jpg"; break;
     case "mp3": $ctype="audio/mpeg"; break;
     case "wav": $ctype="audio/x-wav"; break;
     case "mpeg":
     case "mpg":
     case "mpe": $ctype="video/mpeg"; break;
     case "mov": $ctype="video/quicktime"; break;
     case "avi": $ctype="video/x-msvideo"; break;

     //The following are for extensions that shouldn't be downloaded (sensitive stuff, like php files)
     case "php":
     case "htm":
     case "html":
     case "txt": die("<b>Cannot be used for ". $file_extension ." files!</b>"); break;

     default: $ctype="application/force-download";
   }

   //Begin writing headers
   header("Pragma: public");
   header("Expires: 0");
   header("Cache-Control: must-revalidate, post-check=0, pre-`=0");
   header("Cache-Control: public");
   header("Content-Description: File Transfer");
  
   //Use the switch-generated Content-Type
   header("Content-Type: $ctype");

   //Force the download
   $header="Content-Disposition: attachment; filename=". substr($filename,11) .";";
   header($header);
   header("Content-Transfer-Encoding: binary");
   header("Content-Length: ".$len);
   @readfile($file);
   exit;
}

function no_cache()
{
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");    // Date in the past
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
                                                     // always modified
	header("Cache-Control: no-store, no-cache, must-revalidate");  // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache"); 
}

function set_cookie($cookie_name,$cookie_value,$expire)
{
	return setcookie($cookie_name,$cookie_value,time() + ($expire));
}

function get_cookie($cookie_name)
{
	return @$_COOKIE[$cookie_name];
}

function unset_cookie($cookie_name)
{
	return setcookie($cookie_name,'',time() - (60*60*36));
}

function set_session($session_name, $session_value)
{	
	if(isset($_SESSION[$session_name])) unset($_SESSION[$session_name]);
	#session_register($session_name);
	$_SESSION[$session_name] = $session_value;	
}

function get_session($session_name)
{
	if(@$_SESSION[$session_name] == '') return false;
	else return @$_SESSION[$session_name];
}

function unset_session($name)
{
	$_SESSION[$name] = '';
	unset($_SESSION[$name]);
	return true;
}

function post($param)
{
	if(!isset($_POST[$param])) return false;
	else return $_POST[$param];
}

function get($param)
{
	if(!isset($_GET[$param])) return false;
	else return $_GET[$param];
}

function req($param)
{
	if(!isset($_REQUEST[$param])) return false;
	else return $_REQUEST[$param];
}


// Function that Validate Email
function check_email($field)
{
	$pattern = '/.*@.*\..*/';
	if (preg_match($pattern, $field) > 0) 
   		return true;
    else
   		return false;
}//Email

//Encrypt_Credit Card Information 
function Encrypt_CC($p_Value)
{
	$chunk_1	= base64_encode( substr ( $p_Value , 0 , 4 ) * 1982 ) ;
	$chunk_2	= base64_encode( substr ( $p_Value , 4 , 4 ) * 9874 ) ;
	$chunk_3	= base64_encode( substr ( $p_Value , 8 , 4 ) * 8795 );
	$chunk_4	= base64_encode( substr ( $p_Value , 12 ) 	 * 4578 );
	
	return $chunk_1 .'->'.$chunk_2.'->'.$chunk_3.'->'.$chunk_4;
	
}

//Decrypt_Credit Card Information 
function Decrypt_CC($p_Value)
{
	$array		= split('->',$p_Value);
	$chunk_1	= base64_decode( $array[0] ) / 1982;
	$chunk_2	= base64_decode( $array[1] ) / 9874;
	$chunk_3	= base64_decode( $array[2] ) / 8795;
	$chunk_4	= base64_decode( $array[3] ) / 4578;
	
	return $chunk_1 . $chunk_2 . $chunk_3 . $chunk_4;
}

/// End Other Functions
