<?php
	use Scienceguard\SG_Util;

	include(view_path('admin/template/vars'));
?>
<div id="ajax-content">
<?php
	$error_messages = $errors->all();
	if($error_messages){
		echo Notification::errorInstant($error_messages);
	}
?>
<?php include(view_path($content)); ?>
<?php echo Template::printScript() ?>
</div>