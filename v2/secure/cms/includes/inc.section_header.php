<div style="float:left;"><h1><?=$g_page_heading;?></h1></div>
<? if($add_link != ''){ ?>
<div style="float:right; padding-top:30px;">
  <input type="button" class="submit fr" value="<?=$add_link['caption'];?>" onClick="<? if($add_link['js']) echo $add_link['func_name']; else echo 'location.href=\''.$add_link['link'].'\';'; ?>" />
</div>
<? } ?>
<div style="clear:both;"></div>
<?=@caution_new(get("msg"),get("cs"),$errors);?>