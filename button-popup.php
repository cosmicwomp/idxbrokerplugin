<?php
// this file contains the contents of the popup window
require_once '../../../wp-load.php';
if ( current_user_can('manage_options') == false) {
exit(0);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Insert Shortcode</title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.js"></script>
<script language="javascript" type="text/javascript" src="../../../../wp-includes/js/tinymce/tiny_mce_popup.js"></script>
<style type="text/css" src="../../wp-includes/js/tinymce/themes/advanced/skins/wp_theme/dialog.css"></style>
<link rel="stylesheet" href="css/idxbroker.css" />
<script type="text/javascript">
 
var ButtonDialog = {
	local_ed : 'ed',
	init : function(ed) {
		ButtonDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertShortCode(ed,selected_link, new_title) {

		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		var element = '#'+selected_link;
		var output = '';
 		output = $(element).val();

		tinyMCEPopup.execCommand('mceReplaceContent', false, output);
		// Return
		tinyMCEPopup.close();
	}
};
tinyMCEPopup.onInit.add(ButtonDialog.init, ButtonDialog);
<?php if(isset($_GET['uid']) AND $_GET['uid'] != ""):?>
//Function to update the title value when user clicks the ok button
function update_hidden_field() {
	var new_title = $('#new_title').val();
	var current_short_code = $('#<?php echo $_GET['uid']?>').val();
	var new_short_code = current_short_code.replace('<?php echo @$_GET['current_title']?>', new_title);
	$('#<?php echo $_GET['uid']?>').val(new_short_code);
}
<?php endif;?>
$(document).ready(function(){
    //  When user clicks on tab, this code will be executed
    $("#tabs li").click(function() {
        $("#tabs li").removeClass('active');
        $(this).addClass("active");
        $(".tab_content").hide();
        var selected_tab = $(this).find("a").attr("href");
        $(selected_tab).fadeIn();
 
        return false;
    });
});
</script>
</head>
<body>
	<div id="button-dialog">
		<?php if(!@$_GET['current_title'] AND !@$_GET['uid']):?>
		<?php //show_all_shortcodes();?>
		<div id="tabs_container">
    		<ul id="tabs">
        		<li class="active"><a href="#tab1">System Links</a></li>
        		<li><a class="icon_accept" href="#tab2">Saved Links</a></li>
        		<li><a href="#tab3">Widgets</a></li>
    		</ul>
		</div>
		<div id="tabs_content_container">
    		<div id="tab1" class="tab_content" style="display: block;">
				<?php show_link_short_codes(0);?>    		</div>
    		<div id="tab2" class="tab_content">
        		<?php show_link_short_codes(1);?>
    		</div>
		    <div id="tab3" class="tab_content">
		        <?php show_widget_shortcodes();?>
		    </div>
		</div>

		<?php else:?>
		<div class="change_title">
			<label>New Title</label>
			<input type="hidden" id="<?php echo $_GET['uid']?>" value = '<?php echo  stripslashes(($_GET['short_code']));?>'>
			<input type="text" class="input_text" name="new_title" id="new_title" value="<?php echo $_GET['current_title'];?>">
			<input type="button" class="input_button" name="insert" value="Ok" onclick="javascript:update_hidden_field();javascript:ButtonDialog.insert(ButtonDialog.local_ed,'<?php echo $_GET['uid']?>');">
			<input type="button" class="input_button" name="cancel" value="Cancel" onclick="javascript:ButtonDialog.insert(ButtonDialog.local_ed,'<?php echo $_GET['uid']?>');">
		</div>
		<?php endif;?>
	</div>
</body>

</html>