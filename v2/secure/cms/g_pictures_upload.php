<?
include('../../includes/open_con.php');

if($cmd == 'upload')
{
	for($i = 0 ; $i < $uploader_count ; $i++)
	{
		$file_name = 'gl_'.$cat_id.'_'.time().'_'.generate_file_name($_POST['uploader_'. $i .'_name']);
		$src_name = $_POST['uploader_'. $i .'_tmpname'];
		
		$title = substr($_POST['uploader_'. $i .'_name'], 0, -4);
		
		$src = '../../up_data/temp/'.$src_name;
		$dest = '../../up_data/pictures/'.$file_name;
		
		copy($src, $dest);
		
		if($i == 0)
			$is_primary = 'Y';
		else
			$is_primary = 'N';
		
		$sql = "insert into ".DB_TABLE_PREFIX."pictures set
				cat_id	= '$cat_id',
				title		= ". $db->qstr($title) .",
				src_image	= '$file_name',
				is_primary	= '$is_primary',
				date_added 	= now()
				";
		
		$db->Execute($sql);
		
		unlink($src);
	}
	
	echo '
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Upload Pictures</title>
	</head>
	<body>
	<script language="javascript">
		alert("Pictures uploaded successfully.");
		self.opener.location.reload();
		self.close();
	</script>
	</body>
	</html>
	';
	exit;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<title>Upload Pictures</title>

<?php /*?><link rel="stylesheet" href="css/jquery.ui.css" type="text/css"/><?php */?>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/base/jquery-ui.css" type="text/css" />

<link rel="stylesheet" href="css/cc_checks.css" type="text/css"/>
<link rel="stylesheet" href="js/pl_upload/jquery.ui.plupload/css/jquery.ui.plupload.css" type="text/css" />

<?php /*?><script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.ui.js"></script><?php */?>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>

<script type="text/javascript" src="js/pl_upload/browserplus-min.js"></script>

<script type="text/javascript" src="js/pl_upload/plupload.js"></script>
<script type="text/javascript" src="js/pl_upload/plupload.gears.js"></script>
<script type="text/javascript" src="js/pl_upload/plupload.silverlight.js"></script>
<script type="text/javascript" src="js/pl_upload/plupload.flash.js"></script>
<script type="text/javascript" src="js/pl_upload/plupload.browserplus.js"></script>
<script type="text/javascript" src="js/pl_upload/plupload.html4.js"></script>
<script type="text/javascript" src="js/pl_upload/plupload.html5.js"></script>
<script type="text/javascript" src="js/pl_upload/jquery.ui.plupload/jquery.ui.plupload.js"></script>

</head>
<body>

<h1>Upload Pictures</h1>


<form  method="post" action="g_pictures_upload.php?cmd=upload&cat_id=<?=$cat_id;?>">
	<div id="uploader">
		<p>You browser doesn't have Flash, Silverlight, Gears, BrowserPlus or HTML5 support.</p>
	</div>
  
  <div style="text-align:center; padding-top:10px;">
  	<div style="float:left;">
    <input name="button" type="submit" class="submit" id="button" value="Add Uploaded Pictures to Gallery!" />
    </div>
    <div style="float:right;">
	<input name="button" type="button" class="submit" id="button" value="Cancel / Close Window" onclick="self.close();" />
    </div>
  </div>
</form>
<script type="text/javascript">
// Convert divs to queue widgets when the DOM is ready
$(function() {
	$("#uploader").plupload({
		// General settings
		runtimes : 'flash,html5,browserplus,silverlight,gears,html4',
		url : 'g_uploader.php',
		max_file_size : '1000mb',
		max_file_count: 200, // user can add no more then 200 files at a time
		chunk_size : '1mb',
		unique_names : true,
		multiple_queues : true,

		// Resize images on clientside if we can
		// resize : {width : 320, height : 240, quality : 90},
		
		// Rename files by clicking on their titles
		rename: true,
		
		// Sort files
		sortable: true,

		// Specify what files to browse for
		filters : [
			{title : "Image files", extensions : "jpg,gif,png"}
			//,
			//{title : "Zip files", extensions : "zip,avi"}
		],

		// Flash settings
		flash_swf_url : 'js/pl_upload/plupload.flash.swf',

		// Silverlight settings
		silverlight_xap_url : 'js/pl_upload/plupload.silverlight.xap'
	});

	// Client side form validation
	$('form').submit(function(e) {
        var uploader = $('#uploader').plupload('getUploader');

        // Files in queue upload them first
        if (uploader.files.length > 0) {
            // When all files are uploaded submit form
            uploader.bind('StateChanged', function() {
                if (uploader.files.length === (uploader.total.uploaded + uploader.total.failed)) {
                    $('form')[0].submit();
                }
            });
                
            uploader.start();
        } else
            alert('You must at least upload one file.');

        return false;
    });
	 

});
</script>
</body>
</html>