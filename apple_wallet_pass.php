<?php
/*
Plugin Name: Tickera - Apple+Android Wallet Pass
Plugin URI: http://tickera.com/
Description: Adds Apple & Android Wallet Pass for Tickera
Author: https://roadmapstudios.com
Version: 1.2.2
 */
require 'vendor/autoload.php';
use Passbook\PassFactory;
use Passbook\Pass\Barcode;
use Passbook\Pass\Field;
use Passbook\Pass\Image;
use Passbook\Pass\Structure;
use Passbook\Type\EventTicket;
if ( ! function_exists( 'my_modify_mimes' ) ) {
	function my_modify_mimes( $mimes ) {
		$mimes['p12']    = 'application/x-pkcs12';
		$mimes['pem']    = 'application/x-pem-file';
		$mimes['pkpass'] = 'application/vnd.apple.pkpass';
		return $mimes;
	}
}
add_filter( 'upload_mimes', 'my_modify_mimes' );

/**
 * Function which checks if it's iOS device
 *
 * @return boolean
 */
if ( ! function_exists( 'tc_check_is_ios' ) ) {
	function tc_check_is_ios() {
		$iPod    = stripos( $_SERVER['HTTP_USER_AGENT'], 'iPod' );
		$iPhone  = stripos( $_SERVER['HTTP_USER_AGENT'], 'iPhone' );
		$iPad    = stripos( $_SERVER['HTTP_USER_AGENT'], 'iPad' );
		$Android = stripos( $_SERVER['HTTP_USER_AGENT'], 'Android' );
		if ( $iPod || $iP / nas / content / staging / eventproky / wp - content / plugins / tickera - apple - wallet - master / vendor / eo / passbook / src / Passbook / PassFactory . phphone || $iPad ) {
			return true;
		} elseif ( $Android ) {
			return true;
		} else {
			return false;
		}
	}
}


if ( tc_check_is_ios() ) {
	// remove comments for this check in production in order to show the column only when accessed via iOS devices
	add_filter( 'tc_owner_info_orders_table_fields_front', 'tc_apple_wallet_pass' );

}

/**
 * show a new column on the order details page (when an order has a paid-like status - order paid, order processing, order completed)
 *
 * @param type $fields
 * @return string
 */
if ( ! function_exists( 'tc_apple_wallet_pass' ) ) {
	function tc_apple_wallet_pass( $fields ) {
		$fields[] = array(
			'id'                => 'ticket_apple_wallet_pass',
			'field_name'        => 'ticket_apple_wallet_pass_column',
			'field_title'       => __( 'Wallet Pass', 'tc' ),
			'field_type'        => 'function',
			'function'          => 'tc_get_wallet_pass_for_ticket',
			'field_description' => '',
			'post_field_type'   => 'post_meta',
		);
		return $fields;
	}
}

if ( ! function_exists( 'hex2RGB' ) ) {
	function hex2RGB( $hexStr, $returnAsString = false, $seperator = ',' ) {
		$hexStr   = preg_replace( '/[^0-9A-Fa-f]/', '', $hexStr ); // Gets a proper hex string
		$rgbArray = array();
		if ( strlen( $hexStr ) == 6 ) { // If a proper hex code, convert using bitwise operation. No overhead... faster
			$colorVal          = hexdec( $hexStr );
			$rgbArray['red']   = 0xFF & ( $colorVal >> 0x10 );
			$rgbArray['green'] = 0xFF & ( $colorVal >> 0x8 );
			$rgbArray['blue']  = 0xFF & $colorVal;
		} elseif ( strlen( $hexStr ) == 3 ) { // if shorthand notation, need some string manipulations
			$rgbArray['red']   = hexdec( str_repeat( substr( $hexStr, 0, 1 ), 2 ) );
			$rgbArray['green'] = hexdec( str_repeat( substr( $hexStr, 1, 1 ), 2 ) );
			$rgbArray['blue']  = hexdec( str_repeat( substr( $hexStr, 2, 1 ), 2 ) );
		} else {
			return false; // Invalid hex color code
		}
		return $returnAsString ? implode( $seperator, $rgbArray ) : $rgbArray; // returns the rgb string or the associative array
	}
}
if ( ! function_exists( 'appleWallet_get_blog_timezone' ) ) {
	function appleWallet_get_blog_timezone() {

		$tzstring = get_option( 'timezone_string' );
		$offset   = get_option( 'gmt_offset' );

		// Manual offset...
		// @see http://us.php.net/manual/en/timezones.others.php
		// @see https://bugs.php.net/bug.php?id=45543
		// @see https://bugs.php.net/bug.php?id=45528
		// IANA timezone database that provides PHP's timezone support uses POSIX (i.e. reversed) style signs
		if ( empty( $tzstring ) && 0 != $offset && floor( $offset ) == $offset ) {
			$offset_st = $offset > 0 ? "-$offset" : '+' . absint( $offset );
			$tzstring  = 'Etc/GMT' . $offset_st;
		}

		// Issue with the timezone selected, set to 'UTC'
		if ( empty( $tzstring ) ) {
			$tzstring = 'UTC';
		}

		$timezone = new DateTimeZone( $tzstring );
		return $timezone;
	}
}

if ( ! function_exists( 'appleWalletPass' ) ) {
	function appleWalletPass( $event_title, $location, $datetime, $ticket_title, $ticket_id, $ticket_code, $first_name, $last_name ) {
		// $fp           = fopen( dirname( __FILE__ ) . '/sample2222.txt', 'w+' );
		$current_user = wp_get_current_user();

		$upload_dir = wp_upload_dir();
		// fwrite( $fp, PHP_EOL . "\n\n upload_dir = " . print_r( $upload_dir, true ) );
		$user_dirname = $upload_dir['basedir'] . '/' . $ticket_code . '.pkpass';
		if ( ! file_exists( $user_dirname ) ) {
			$tc_apple_wallet_settings = get_option( 'tc_apple_wallet_settings' );
			// fwrite( $fp, PHP_EOL . "\n\n tc_apple_wallet_settings = " . print_r( $tc_apple_wallet_settings, true ) );
			$data = hex2RGB( $tc_apple_wallet_settings['background_color'] );
			// fwrite( $fp, PHP_EOL . "\n\n data = " . print_r( $data, true ) );
			// Create an event ticket
			// fwrite( $fp, PHP_EOL . "\n\n ticket = " . $ticket_id . ' & ticket_title :' . $ticket_title );
			$pass = new EventTicket( $ticket_id, $ticket_title );
			// fwrite( $fp, PHP_EOL . "\n\n Event ticket = " );
			$pass->setBackgroundColor( 'rgb(' . $data['red'] . ', ' . $data['green'] . ', ' . $data['blue'] . ')' );
			// fwrite( $fp, PHP_EOL . "\n\n Background = " );
			$pass->setLogoText( $tc_apple_wallet_settings['logo_text'] );
			// fwrite( $fp, PHP_EOL . "\n\n logo = " . $tc_apple_wallet_settings['logo_text'] );
			$dtTime = @date_format( $datetime, 'Y-m-d H:i:s' );
			// fwrite( $fp, PHP_EOL . "\n\n relevant Date = " . $datetime );
			$pass->setRelevantDate( new \DateTime( $datetime, appleWallet_get_blog_timezone() ) );

			// fwrite( $fp, PHP_EOL . "\n\n ticket = " . $datetime );
			// Create pass structure
			$structure = new Structure();
			// Add primary field
			$primary = new Field( 'event', $event_title );
			$primary->setLabel( 'Event' );
			$structure->addPrimaryField( $primary );
			// fwrite( $fp, PHP_EOL . "\n\n primary field = " );
			// Add secondary field
			$secondary = new Field( 'location', $location );
			$secondary->setLabel( 'Location' );
			$structure->addSecondaryField( $secondary );
			// fwrite( $fp, PHP_EOL . "\n\n secondary field " );
			$secondary1 = new Field( 'passenger', $first_name . ' ' . $last_name );
			$secondary1->setLabel( 'Customer' );
			$structure->addSecondaryField( $secondary1 );
			// Add auxiliary field
			$auxiliary = new Field( 'datetime', $datetime );
			$auxiliary->setLabel( 'Date & Time' );

			$structure->addAuxiliaryField( $auxiliary );
			// fwrite( $fp, PHP_EOL . "\n\n auxiliary field " );
			// Add icon image
			$icon = new Image( $tc_apple_wallet_settings['icon_file_abs_path'], 'icon' );
			$pass->addImage( $icon );
			// fwrite( $fp, PHP_EOL . "\n\n icon " );
			// Add logo image
			$logo = new Image( $tc_apple_wallet_settings['icon_file_abs_path'], 'logo' );
			$pass->addImage( $logo );
			// fwrite( $fp, PHP_EOL . "\n\n logo " );
			// Set pass structure
			$pass->setStructure( $structure );
			// Add barcode
			$barcode = new Barcode( $tc_apple_wallet_settings['qr_code_type'], $ticket_code );
			$pass->setBarcode( $barcode );
			// fwrite( $fp, PHP_EOL . "\n\n barcode " );
			// Create pass factory instance
			if ( $tc_apple_wallet_settings['pass_type_identifier'] && $tc_apple_wallet_settings['pass_type_identifier'] != '' && $tc_apple_wallet_settings['team_identifier'] && $tc_apple_wallet_settings['team_identifier'] != '' && $tc_apple_wallet_settings['organisation_name'] && $tc_apple_wallet_settings['organisation_name'] != '' && $tc_apple_wallet_settings['p12_file_abs_path'] && $tc_apple_wallet_settings['p12_file_abs_path'] != '' && $tc_apple_wallet_settings['p12_passwrd'] && $tc_apple_wallet_settings['p12_passwrd'] != '' && $tc_apple_wallet_settings['wwrd_file_abs_path'] && $tc_apple_wallet_settings['wwrd_file_abs_path'] != '' ) {

				$factory = new PassFactory( $tc_apple_wallet_settings['pass_type_identifier'], $tc_apple_wallet_settings['team_identifier'], $tc_apple_wallet_settings['organisation_name'], $tc_apple_wallet_settings['p12_file_abs_path'], $tc_apple_wallet_settings['p12_passwrd'], $tc_apple_wallet_settings['wwrd_file_abs_path'] );
				// fwrite( $fp, PHP_EOL . "\n\n final " );
				$factory->setOutputPath( $upload_dir['path'] );
				$t = time();

				// fwrite( $fp, PHP_EOL . "\n\n pass " . print_r( $pass, true ) );
				// fwrite( $fp, PHP_EOL . "\n\n ticket_code " . $ticket_code );
				$fileName = $factory->package( $pass, $ticket_code );
				// fwrite( $fp, PHP_EOL . "\n\n final =>  " . $fileName->getFilename() );
				$displayFileName = $upload_dir['url'] . '/' . $fileName->getFilename();
				// fwrite( $fp, PHP_EOL . "\n\n final > " . $displayFileName );
				$Android = stripos( $_SERVER['HTTP_USER_AGENT'], 'Android' );
				if ( $Android ) {
					echo '<a href="https://walletpass.io?u=' . $displayFileName . '" target="_system"><img src="https://www.walletpasses.io/badges/badge_web_generic_en@2x.png" /></a>';
				} else {
					echo '<a href="' . $displayFileName . '" target="_system"><img src="' . plugin_dir_url( __FILE__ ) . 'includes/add-to-apple-wallet.jpg" width="100px" /></a>';
				}
			}
		} else {
			$displayFileName = $upload_dir['url'] . '/' . $ticket_code . '.pkpass';
			// fwrite( $fp, PHP_EOL . "\n\n final > " . $displayFileName );
			$Android = stripos( $_SERVER['HTTP_USER_AGENT'], 'Android' );
			if ( $Android ) {
				echo '<a href="https://walletpass.io?u=' . $displayFileName . '" target="_system"><img src="https://www.walletpasses.io/badges/badge_web_generic_en@2x.png" /></a>';
			} else {
				echo '<a href="' . $displayFileName . '" target="_system"><img src="' . plugin_dir_url( __FILE__ ) . 'includes/add-to-apple-wallet.jpg" width="100px" /></a>';
			}
		}
		// fclose( $fp );
	}
}

/**
 * Show a result in the column for each ticket purchased
 *
 * @param type $field_name
 * @param type $post_field_type
 * @param type $ticket_id
 */
if ( ! function_exists( 'tc_get_wallet_pass_for_ticket' ) ) {
	function tc_get_wallet_pass_for_ticket( $field_name, $post_field_type, $tickets_id ) {
		// examples:
		$events       = get_post_meta( $tickets_id, '', false ); // get a ticket event id so you can obtain an event information like location, date & time, even title etc
		$event_id     = $events['event_id'][0];
		$ticket_id    = $events['ticket_type_id'][0];
		$ticket_code  = $events['ticket_code'][0];
		$first_name   = $events['first_name'][0];
		$last_name    = $events['last_name'][0];
		$event_obj    = new TC_Event( $event_id );
		$location_obj = get_post_meta( $event_id, '', false );
		$ticket       = new TC_Ticket( $ticket_id );

		// $fp = fopen( dirname( __FILE__ ) . '/sample.txt', 'w+' );
		// fwrite( $fp, PHP_EOL . 'field_name = ' . $field_name );
		// fwrite( $fp, PHP_EOL . 'ticket_code = ' . $ticket_code );
		// fwrite( $fp, PHP_EOL . 'events = ' . print_r( $events, true ) );
		// fwrite( $fp, PHP_EOL . 'tickets_id = ' . $tickets_id );
		// fclose( $fp );
		$wallet_pass = appleWalletPass( $event_obj->details->post_title, $location_obj['event_location'][0], $location_obj['event_date_time'][0], $ticket->details->post_title, $ticket_id, $ticket_code, $first_name, $last_name );
		// echo $wallet_pass;
	}
}

add_filter( 'tc_settings_new_menus', 'tc_settings_new_menus' );

if ( ! function_exists( 'tc_settings_new_menus' ) ) {
	function tc_settings_new_menus( $menus ) {
		$menus['wallet'] = __( 'Apple Wallet Pass', 'tc' );
		return $menus;
	}
}
add_action( 'tc_settings_menu_wallet', 'tc_settings_menu_wallet' );

if ( ! function_exists( 'tc_settings_menu_wallet' ) ) {
	function tc_settings_menu_wallet() {

		include plugin_dir_path( __FILE__ ) . 'includes/tc_settings_new_menu_apple_wallet_pass.php';    }
}
if ( ! function_exists( 'setAppleMimeType' ) ) {
	function setAppleMimeType() {
		// Get path to main .htaccess for WordPress
		$htaccess = get_home_path() . '.htaccess';

		$lines   = array();
		$lines[] = 'AddType application/vnd.apple.pkpass    pkpass';
		insert_with_markers( $htaccess, 'Apple Wallet Pass', $lines );

	}
}
register_activation_hook( __FILE__, 'setAppleMimeType' );
