<script language="javascript" type="text/javascript" src="packages/core/includes/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
function fileBrowserCallBack(field_name, url, type, win) {
	// Insert new URL, this would normaly be done in a popup
	win.document.forms[0].elements[field_name].value = "images/upload/";
}
</script>
