<?php // THE SETTINGS PAGE

$db_snow_start_day = (int) get_option('db_snow_start_day');
$db_snow_start_month = (int) get_option('db_snow_start_month');
$db_snow_finish_day = (int) get_option('db_snow_finish_day');
$db_snow_finish_month = (int) get_option('db_snow_finish_month');

	if ( isset ( $_POST['submit'] ) )
	{
	}

?>
<div class='wrap db-snow-admin'>

	<h1><?php _e('DB Snow Flakes', 'dbSnowFlakes'); ?></h1>

</div>