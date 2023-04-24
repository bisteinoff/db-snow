<?php // THE SETTINGS PAGE

	$db_local = get_locale();
	setlocale ( LC_TIME, "{$db_local}.utf8" );

	$db_snow_start_day = (int) get_option( 'db_snow_start_day' );
	$db_snow_start_month = (int) get_option( 'db_snow_start_month' );
	$db_snow_finish_day = (int) get_option( 'db_snow_finish_day' );
	$db_snow_finish_month = (int) get_option( 'db_snow_finish_month' );
	$db_snow_max_number = (int) get_option( 'db_snow_max_number' );
	$db_snow_min_size = (int) get_option( 'db_snow_min_size' );
	$db_snow_max_size = (int) get_option( 'db_snow_max_size' );
	$db_snow_speed = (float) get_option( 'db_snow_speed' );
	$db_snow_colors = array(
		'Colors',
		sanitize_hex_color ( get_option('db_snow_color_1') ),
		sanitize_hex_color ( get_option('db_snow_color_2') ),
		sanitize_hex_color ( get_option('db_snow_color_3') ),
		sanitize_hex_color ( get_option('db_snow_color_4') ),
		sanitize_hex_color ( get_option('db_snow_color_5') )
	);

	if ( isset ( $_POST['submit'] ) )
	{

		if ( function_exists('current_user_can') &&
			 !current_user_can('manage_options') )
				die( _e('Error: You do not have the permission to update the value' , 'dbSnowFlakes') );

		if ( function_exists('check_admin_referrer') )
			check_admin_referrer('db_snow_form');

		// Start on
		if ( $_POST['start_day'] > 0 && $_POST['start_month'] > 0 )
		{
			$db_snow_start_day = (int) $_POST['start_day'];
			update_option( 'db_snow_start_day', $db_snow_start_day );
			$db_snow_start_month = (int) $_POST['start_month'];
			update_option( 'db_snow_start_month', $db_snow_start_month );
		}

		// Stop on
		if ( $_POST['finish_day'] > 0 && $_POST['finish_month'] > 0 )
		{
			$db_snow_finish_day = (int) $_POST['finish_day'];
			update_option( 'db_snow_finish_day', $db_snow_finish_day );
			$db_snow_finish_month = (int) $_POST['finish_month'];
			update_option( 'db_snow_finish_month', $db_snow_finish_month );
		}

		// Max Number
		if ( $_POST['max_number'] >= 0 )
		{
			$db_snow_max_number = (int) $_POST['max_number'];
			update_option ( 'db_snow_max_number', $db_snow_max_number );
		}

		// Min and Max Size
		if ( $_POST['min_size'] >= 0 )
		{
			$db_snow_min_size = (int) $_POST['min_size'];
			update_option ( 'db_snow_min_size', $db_snow_min_size );
		}

		if ( $_POST['max_size'] >= 0 )
		{
			$db_snow_max_size = (int) $_POST['max_size'];
			update_option ( 'db_snow_max_size', $db_snow_max_size );
		}

		if ( $_POST['min_size'] >= 0 && $_POST['max_size'] >= 0 && $db_snow_min_size > $db_snow_max_size )
		{
			update_option ( 'db_snow_min_size', $db_snow_max_size );
			update_option ( 'db_snow_max_size', $db_snow_min_size );
		}

		// Speed
		if ( $_POST['speed'] >= 0 )
		{
			$db_snow_speed = (float) $_POST['speed'];
			update_option ( 'db_snow_speed', $db_snow_speed );
		}


		// Colors
		for ( $i = 1; $i <= 5; $i++ )
		{
			$db_snow_colors[ $i ] = sanitize_hex_color ( $_POST["color_{$i}"] );
			update_option( 'db_snow_color_' . $i , $db_snow_colors[ $i ] );
		}

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
				<th scope="row">
					<?php _e('Stop on' , 'dbSnowFlakes') ?>
				</th>
				<td>
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
				<td>
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
			<tr valign="top">
				<th scope="rowgroup" rowspan="4">
					<?php _e('Parameters' , 'dbSnowFlakes') ?>
					<div class="db-snow-field-description"><?php _e('Customization of the performance of the snowflakes' , 'dbSnowFlakes') ?></div>
				</th>
				<th scope="row">
					<?php _e('Maximum number of snowflakes' , 'dbSnowFlakes') ?>
				</th>
				<td>
					<input type="text" name="max_number" id="db_snow_max_number"
							size="5" value="<?php echo $db_snow_max_number; ?>" />
				</td>
				<td rowspan="9" id="db_snow_preview">
				</td>
			</tr>
			<tr valign="top">
				<th scope="row" class="db-snow-after-rowspan">
					<?php _e('Minimum Size' , 'dbSnowFlakes') ?>
				</th>
				<td>
					<input type="text" name="min_size" id="db_snow_min_size"
							size="5" value="<?php echo $db_snow_min_size; ?>" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row" class="db-snow-after-rowspan">
					<?php _e('Maximum Size' , 'dbSnowFlakes') ?>
				</th>
				<td>
					<input type="text" name="max_size" id="db_snow_max_size"
							size="5" value="<?php echo $db_snow_max_size; ?>" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row" class="db-snow-after-rowspan">
					<?php _e('Speed' , 'dbSnowFlakes') ?>
				</th>
				<td>
					<div id="db_snow_speed_value"></div>
					<div class="db-snow-input-range">
						<input type="range" name="speed" id="db_snow_speed"
								size="5" min="0.1" max="2" step="0.01" value="<?php echo $db_snow_speed; ?>" />
					</div>
				</td>
			</tr>
			<tr valign="top">
				<th scope="rowgroup" rowspan="5">
					<?php _e('Colors' , 'dbSnowFlakes') ?>
					<div class="db-snow-field-description"><?php _e('Choose 5 colors of the snowflakes. The color of every other snowflake will be chosen randomly from these five ones' , 'dbSnowFlakes') ?></div>
				</th>
				<th scope="row">
					<?php _e('Color' , 'dbSnowFlakes') ?> 1
				</th>
				<td id="db_snow_color_inner">
					<input type="text" name="color_1" id="db_snow_color_1" class="db-snow-color"
							size="7" value="<?php echo $db_snow_colors[1]; ?>" data-default-color="#b9e0f5" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row" class="db-snow-after-rowspan">
					<?php _e('Color' , 'dbSnowFlakes') ?> 2
				</th>
				<td id="db_snow_color_inner">
					<input type="text" name="color_2" id="db_snow_color_2" class="db-snow-color"
							size="7" value="<?php echo $db_snow_colors[2]; ?>" data-default-color="#7ec8ff" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row" class="db-snow-after-rowspan">
					<?php _e('Color' , 'dbSnowFlakes') ?> 3
				</th>
				<td id="db_snow_color_inner">
					<input type="text" name="color_3" id="db_snow_color_3" class="db-snow-color"
							size="7" value="<?php echo $db_snow_colors[3]; ?>" data-default-color="#7eb0ff" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row" class="db-snow-after-rowspan">
					<?php _e('Color' , 'dbSnowFlakes') ?> 4
				</th>
				<td id="db_snow_color_inner">
					<input type="text" name="color_4" id="db_snow_color_4" class="db-snow-color"
							size="7" value="<?php echo $db_snow_colors[4]; ?>" data-default-color="#8ab4ff" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row" class="db-snow-after-rowspan">
					<?php _e('Color' , 'dbSnowFlakes') ?> 5
				</th>
				<td id="db_snow_color_inner">
					<input type="text" name="color_5" id="db_snow_color_5" class="db-snow-color"
							size="7" value="<?php echo $db_snow_colors[5]; ?>" data-default-color="#afd0f5" />
				</td>
			</tr>
		</table>

		<input type="hidden" name="action" value="update" />

		<input type="hidden" name="page_options" value="db_tagcloud_cols" />

		<?php submit_button(); ?>

	</form>

</div>