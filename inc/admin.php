<?php // THE SETTINGS PAGE

	$db_local = get_locale();
	setlocale ( LC_TIME, "{$db_local}.utf8" );

	$db_snow_start_day = (int) get_option('db_snow_start_day');
	$db_snow_start_month = (int) get_option('db_snow_start_month');
	$db_snow_finish_day = (int) get_option('db_snow_finish_day');
	$db_snow_finish_month = (int) get_option('db_snow_finish_month');

	$db_calendar = Array (
		Array ('Month', '', '', '', '', '', '', '', '', '', '', '', ''),
		Array ()
	);

	if ( isset ( $_POST['submit'] ) )
	{

		if ( function_exists('current_user_can') &&
			 !current_user_can('manage_options') )
				die( _e('Error: You do not have the permission to update the value' , 'dbSnowFlakes') );

		if ( function_exists('check_admin_referrer') )
			check_admin_referrer('db_snow_form');

		// Start on
		$db_snow_start_day = (int) $_POST['start_day'];
		update_option( 'db_snow_start_day', $db_snow_start_day );
		$db_snow_start_month = (int) $_POST['start_month'];
		update_option( 'db_snow_start_month', $db_snow_start_month );

		// Stop on
		$db_snow_finish_day = (int) $_POST['finish_day'];
		update_option( 'db_snow_finish_day', $db_snow_finish_day );
		$db_snow_finish_month = (int) $_POST['finish_month'];
		update_option( 'db_snow_finish_month', $db_snow_finish_month );

/*
		// Font size
		if ( $_POST['fontsize'] !== '' )
			$fontsize = (float) $_POST['fontsize'];
		else
			$fontsize = '';
		update_option ( 'db_tagcloud_fontsize', $fontsize );

		// Font weight
		$fontweight = (int) $_POST['fontweight'];
		update_option ( 'db_tagcloud_fontweight', $fontweight );

		// Border width
		if ( $_POST['borderwidth'] !== '' )
			$borderwidth = (float) $_POST['borderwidth'];
		else
			$borderwidth = '';
		update_option ( 'db_tagcloud_borderwidth', $borderwidth );

		// Color
		$color = sanitize_hex_color ( $_POST['color'] );
		update_option( 'db_tagcloud_color', $color );
*/
	}

?>
<div class='wrap db-snow-admin'>

	<h1><?php _e('DB Snow Flakes', 'dbSnowFlakes') ?></h1>

	<div class="db-snow-description">
		<p><?php _e("The plugin generates snowflakes falling down on the foreground of the pages of the website.", 'dbSnowFlakes') ?></p>
		<p><?php _e("Once installed it will run the script only in the period of time when you want. A lot of options to customize snowflakes and their actions.", 'dbSnowFlakes') ?></p>
	</div>

	<h2><?php _e('Settings', 'dbSnowFlakes') ?></h2>

	<form name="db-snow" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>?page=db-snow&amp;updated=true">

		<?php
			if (function_exists ('wp_nonce_field') )
				wp_nonce_field('db_snow_form');
		?>

		<table class="form-table db-snow-table" width="100%">
			<tr valign="top">
				<th scope="row" width="20%">
					<?php _e('Start on' , 'dbSnowFlakes') ?>
				</th>
				<td width="10%">
					<select type="text" name="start_day" id="db_snow_start_day">
						<option value="0" disabled><?php _e('Day' , 'dbSnowFlakes') ?></option>
					<?php
						for ( $i = 1; $i <= 31 ; $i++ )
						{
					?>
						<option value="<?php echo $i; ?>" <?php selected( $db_snow_start_day, $i ); ?>><?php echo $i ?></option>
					<?php
						}
					?>
					</select>
				</td>
				<td width="10%">
					<select type="text" name="start_month" id="db_snow_start_month">
						<option value="0" disabled><?php _e('Month' , 'dbSnowFlakes') ?></option>
					<?php
						for ( $i = 1; $i <= 12 ; $i++ )
						{
					?>
						<option value="<?php echo $i; ?>" <?php selected( $db_snow_start_month, $i ); ?>><?php echo strftime( '%B' , strtotime ( "{$i}/01/2000" ) ) ?></option>
					<?php
						}
					?>
					</select>
				</td>
				<th scope="col" rowspan="2" width="70%">
					<?php _e('Preview' , 'dbSnowFlakes') ?>
				</th>
			</tr>
			<tr valign="top">
				<th scope="row" width="20%">
					<?php _e('Stop on' , 'dbSnowFlakes') ?>
				</th>
				<td width="10%">
					<select type="text" name="finish_day" id="db_snow_finish_day">
						<option value="0" disabled><?php _e('Day' , 'dbSnowFlakes') ?></option>
					<?php
						for ( $i = 1; $i <= 31 ; $i++ )
						{
					?>
						<option value="<?php echo $i; ?>" <?php selected( $db_snow_finish_day, $i ); ?>><?php echo $i ?></option>
					<?php
						}
					?>
					</select>
				</td>
				<td width="10%">
					<select type="text" name="finish_month" id="db_snow_finish_month">
						<option value="0" disabled><?php _e('Month' , 'dbSnowFlakes') ?></option>
					<?php
						for ( $i = 1; $i <= 12 ; $i++ )
						{
					?>
						<option value="<?php echo $i; ?>" <?php selected( $db_snow_finish_month, $i ); ?>><?php echo strftime( '%B' , strtotime ( "{$i}/01/2000" ) ) ?></option>
					<?php
						}
					?>
					</select>
				</td>
			</tr>
		</table>

		<input type="hidden" name="action" value="update" />

		<input type="hidden" name="page_options" value="db_tagcloud_cols" />

		<?php submit_button(); ?>

	</form>

</div>