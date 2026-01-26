function pgp_upload(cat_id)
{
	openwin('g_pictures_upload.php?cat_id=' + cat_id, 'UploadPics', 'scrollbars=no,width=650,height=450', 650, 450);
}


function toggle_status(lbl, clicked, id, name)
{
	if(clicked == 'Y')
	{
		$('#'+lbl.id).attr('className', 'st_active hide');
		$('#'+name+'_label_'+id+'_N').attr('className', 'st_inactive');
	}
	else
	{
		$('#'+lbl.id).attr('className', 'st_inactive hide');
		$('#'+name+'_label_'+id+'_Y').attr('className', 'st_active');
	}
}

function gen_seo_name(name)
{
	var table = $('#table_name').val();
	var action = $('#action').val();
	var id = '';
	if(action != 'add')
		id = $('#id').val();
	
	$('#slug').val('Loading ...');
	$('#slug').attr('disabled', true);

	name = escape(name);

	$.ajax({
	   type: "POST",
	   url: "ajax.php",
	   data: "cmd=gen_seo&name="+name+"&table="+table+"&action="+action+"&id="+id,
	   success: function(msg)
	   {
		  $('#slug').val(msg);
		  $('#slug').attr('disabled', false);
	   }
	 });
}

function navigate(hlink)
{
	self.location.href = hlink;
}

$(document).ready(function () {
	Cufon.replace('.logo .title');	
	InitMenuEffects ();
	InitTables ();	
	InitNotifications ()
});

function InitNotifications () {
	$('.notification .close').click(function () {
		$(this).parent().fadeOut(1000, function() {
			$(this).find('p').fixClearType ();
		});		
		return false;
	});
}


/* *********************************************************************
 * Main Menu
 * *********************************************************************/
function InitMenuEffects () {
	/* Sliding submenus */
	$('.sidebar .menu ul ul').hide();
	$('.sidebar .menu ul li.active ul').show();
	
	$('.sidebar .menu ul li').click(function () {
		submenu = $(this).find('ul');
		if (submenu.is(':visible'))
			submenu.slideUp(150);					
		else
			submenu.slideDown(200);									
		return false;
	});
	
	/* Hover effect on links */
	$('.sidebar .menu li a').hover(
		function () { $(this).stop().animate({'paddingLeft': '18px'}, 200); },
		function () { $(this).stop().animate({'paddingLeft': '12px'}, 200); }
	)
}


/* *********************************************************************
 * Data Tables
 * *********************************************************************/
function InitTables () {
	$('.datatable').dataTable(
	{
		'bLengthChange': true,
		'bPaginate': true,
		'sPaginationType': 'full_numbers',
		'iDisplayLength': 5,
		'bInfo': false		
	}
	);

	/*$('.datatable').dataTable({
		'bLengthChange': true,
		'bPaginate': true,
		'sPaginationType': 'full_numbers',
		'iDisplayLength': 5,
		'bInfo': false,
		'oLanguage': 
		{
			'sSearch': 'Search all columns:',
			'oPaginate': 
			{
				'sNext': '&gt;',
				'sLast': '&gt;&gt;',
				'sFirst': '&lt;&lt;',
				'sPrevious': '&lt;'
			}
		},		
		'aoColumns': [ 
			{ "bSortable": false },
			null,
			null,
			null,
			null,
			null,
			null
		]	
	});*/
}


jQuery.fn.fixClearType = function(){
    return this.each(function(){
        if( !!(typeof this.style.filter  && this.style.removeAttribute))
            this.style.removeAttribute("filter");
    })

} 








function generate_cp_fields(cmd)
{
	if($('#no_fields').val() == '')
	{
		alert('Please enter number of products to continue.');	
		$('#no_fields').focus();
		return false;
	}
	if(isNaN($('#no_fields').val()))
	{
		alert('Please enter only numeric value for products fields.');	
		$('#no_fields').focus();
		return false;
	}
	
	$.ajax({
	   type: "POST",
	   url: "ajax.php",
	   data: "cmd=generate_promo&no_fields="+$('#no_fields').val(),
	   success: function(msg){
		 $('#tr_fields').show();
		 $('#td_fields').html(msg);
	   }
	 });
}




function validate_option()
{
	if(document.getElementById('is_country_y') && document.getElementById('is_country_y').checked)
	{
		return true;	
	}
	else
	{
		if($('#option_name').val() == '')
		{
			alert('Please enter option text.');	
			$('#option_name').focus();
			return false;
		}
		if($('#option_value').val() == '')
		{
			alert('Please enter option value.');	
			$('#option_value').focus();
			return false;
		}
		if($('#pos').val() == '')
		{
			alert('Please enter option position.');	
			$('#pos').focus();
			return false;
		}
	}
}

function validate_form_single()
{
	if($('#caption').val() == '')
	{
		alert('Please enter caption for field.');	
		$('#caption').focus();
		return false;
	}
	if($('#pos').val() == '')
	{
		alert('Please enter position for field.');	
		$('#pos').focus();
		return false;
	}	
}

function validate_form_edit()
{
	if($('#name').val() == '')
	{
		alert('Please enter form name.');	
		$('#name').focus();
		return false;
	}
	
	for(var i = 1 ; i <= Number($('#no_fields').val()) ; i++)
	{
		if($('#caption_'+i).val() == '')
		{
			alert('Please enter caption for field # '+ i +'.');	
			$('#caption_'+i).focus();
			return false;
		}
		if($('#pos_'+i).val() == '')
		{
			alert('Please enter position for field # '+ i +'.');	
			$('#pos_'+i).focus();
			return false;
		}
	}
	
}

function validate_form()
{
	if($('#name').val() == '')
	{
		alert('Please enter form name.');	
		$('#name').focus();
		return false;
	}
	if($('#no_fields').val() == '')
	{
		alert('Please enter number of fields for this form.');	
		$('#no_fields').focus();
		return false;
	}
	if(isNaN($('#no_fields').val()))
	{
		alert('Please enter only numeric value for form fields.');	
		$('#no_fields').focus();
		return false;
	}
	
	for(var i = 1 ; i <= Number($('#no_fields').val()) ; i++)
	{
		if($('#caption_'+i).val() == '')
		{
			alert('Please enter caption for field # '+ i +'.');	
			$('#caption_'+i).focus();
			return false;
		}
		if($('#pos_'+i).val() == '')
		{
			alert('Please enter position for field # '+ i +'.');	
			$('#pos_'+i).focus();
			return false;
		}
	}
	
}

function load_lp(template_id)
{
	if(template_id != '_')
	{
		$('#div_editor').html('Loading, please wait ...');
		$.ajax({
		   type: "POST",
		   url: "ajax.php",
		   data: "cmd=generate_lp&template_id="+template_id,
		   success: function(msg){
			 $('#div_editor').html(msg);
		   }
		 });	
	}
}

function generate_form_fields(cmd)
{
	if($('#no_fields').val() == '')
	{
		alert('Please enter number of fields to continue.');	
		$('#no_fields').focus();
		return false;
	}
	if(isNaN($('#no_fields').val()))
	{
		alert('Please enter only numeric value for form fields.');	
		$('#no_fields').focus();
		return false;
	}
	
	$.ajax({
	   type: "POST",
	   url: "ajax.php",
	   data: "cmd=generate_form&no_fields="+$('#no_fields').val(),
	   success: function(msg){
		 //alert( "Data Saved: " + msg );
		 $('#td_fields').show();
		 $('#td_fields').html(msg);
	   }
	 });
}


function make_selection(frm, cbk)
{
	for(var i = 0 ; i < frm.elements.length ; i++)
	{
		var e = frm.elements[i];
		if(e.type == 'checkbox' && e.name == 'del_id[]')
			e.checked = cbk.checked;
	}
}

function validate_sel(frm)
{
	var error = true;
	for(var i = 0 ; i < frm.elements.length ; i++)
	{
		var e = frm.elements[i];
		if(e.type == 'checkbox' && e.name == 'del_id[]' && e.checked)
			error = false;
	}
	if(error)
	{
		alert('Please select at-least one (1) record to continue.');
		return false;
	}
	else return true;
}

function validate_restore(frm)
{
	var error = true;
	for(var i = 0 ; i < frm.elements.length ; i++)
	{
		var e = frm.elements[i];
		if(e.type == 'checkbox' && e.name == 'del_id[]' && e.checked)
			error = false;
	}
	if(error)
	{
		alert('Please select at-least one (1) record to activate.');
		frm.act.focus();
		return false;
	}
	
	return window.confirm('Are you sure, you want to activate selected record(s)?');	
}


function validate_delete(frm)
{
	var error = true;
		
	for(var i = 0 ; i < frm.elements.length ; i++)
	{
		var e = frm.elements[i];
		if(e.type == 'checkbox' && e.name == 'del_id[]' && e.checked)
			error = false;
	}
	if(error)
	{
		alert('Please select at-least one (1) record to delete.');
		return false;
	}
	else if(window.confirm('Are you sure, you want to delete selected record(s)?'))
		return true;
	else return false;	
}

function openwin(theURL,winName,features,w,h)
{
	var subwin = window.open(theURL,winName,features);
	var x,y;	
	x = (Number(screen.width) - w) / 2;
	y = 125;
	subwin.moveTo(x,y);
	subwin.focus();
}

function seo_name_gen(o_name, s_name)
{
	var temp = o_name.value;
	temp =  temp.replace(/[^a-zA-Z 0-9]+/g,'');
	temp =  temp.replace(/ +/g,'-');
	s_name.value = temp.toLowerCase();
}



function validate_callback_done(frm)
{
	var error = true;
	for(var i = 0 ; i < frm.elements.length ; i++)
	{
		var e = frm.elements[i];
		if(e.type == 'checkbox' && e.name == 'del_id[]' && e.checked)
			error = false;
	}
	if(error)
		alert('Please select at-least one (1) record to mark as completed.');
	else if(window.confirm('Are you sure, you want to mark selected records as completed?'))
	{
		frm.act.value = 'completed';
		frm.submit();
	}
}

function validate_callback(frm)
{
	var error = true;
	for(var i = 0 ; i < frm.elements.length ; i++)
	{
		var e = frm.elements[i];
		if(e.type == 'checkbox' && e.name == 'del_id[]' && e.checked)
			error = false;
	}
	if(error)
		alert('Please select at-least one (1) record to set callback / notes.');
	else
	{
		$("#dialog-message").dialog({
			//resizable: false,
			height:340,
			width:650,
			modal: true,
			buttons: {
				'Submit': function() {
					
					if(document.getElementById('callback_y').checked == true && document.getElementById('callback_date').value == '')
					{
						alert('Please enter callback date.');
						document.getElementById('callback_date').focus();
						return false;
					}
					else if(document.getElementById('lead_status').value == '_')
					{
						alert('Please select lead status.');
						document.getElementById('lead_status').focus();
						return false;
					}
					else if(document.getElementById('notes').value == '')
					{
						alert('Please enter notes.');
						document.getElementById('notes').focus();
						return false;
					}
					else
					{
						var a = '';
						for(var i = 0 ; i < document.form1.elements.length ; i++)
						{
							var e = frm.elements[i];
							if(e.type == 'checkbox' && e.name == 'del_id[]' && e.checked)
							{
								a = a + e.value + ','
							}
						}
						document.getElementById('ids').value = a;
						document.frm_callback.submit();
					}
				},
				Cancel: function() {
					$(this).dialog('close');
				}
			}

		});

	}
}



function caution(msg, errors)
{
	if(errors != '')
		alert('Error(s):\n'+errors);
	else if(msg != '')
		alert(msg);
}


function check_country(country)
{
    if(country == 'CA' || country == 'US')
    {
        $('#div_states').show();
        $('#states_box').html('Loading, please wait ...');

        $.ajax({
		   type: "POST",
		   url: "../../ajax.php",
		   data: "cmd=states&country="+country,
		   success: function(states)
		   {
			  $('#states_box').html(states);
		   }
		 });
    }
    else $('#div_states').hide();
}