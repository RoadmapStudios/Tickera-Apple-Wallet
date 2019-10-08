<?php

$error_message = '';
$uploads       = wp_upload_dir();
// echo '<pre>';
// print_r( $_REQUEST );
// echo '</pre>';
if ( isset( $_POST['save_apple_wallet_settings_nonce'] ) && wp_verify_nonce( $_POST['save_apple_wallet_settings_nonce'], 'save_apple_wallet_settings' ) ) {
	if ( isset( $_POST['tc_apple_wallet'] ) ) {
		$tc_apple_wallet_settings = get_option( 'tc_apple_wallet_settings' );
		// print_r( $tc_apple_wallet_settings );
		$tc_apple_wallet = $_POST['tc_apple_wallet'];

		if ( isset( $_POST['icon_file'] ) && $_POST['icon_file'] != '' ) {

			$tc_apple_wallet['icon_file']    = $_POST['icon_file'];
			$tc_apple_wallet['icon_file_id'] = $_POST['icon_file_id'];


			$file_path                             = explode( 'uploads/', $_POST['icon_file'] )[1];
			$tc_apple_wallet['icon_file_abs_path'] = $uploads['basedir'] . '/' . $file_path;

		}
		if ( isset( $_POST['wwrd_file'] ) && $_POST['wwrd_file'] != '' ) {

			$tc_apple_wallet['wwrd_file']    = $_POST['wwrd_file'];
			$tc_apple_wallet['wwrd_file_id'] = $_POST['wwrd_file_id'];

			$file_path                             = explode( 'uploads/', $_POST['wwrd_file'] )[1];
			$tc_apple_wallet['wwrd_file_abs_path'] = $uploads['basedir'] . '/' . $file_path;


		}
		if ( isset( $_POST['p12_file'] ) && $_POST['p12_file'] != '' ) {

			$tc_apple_wallet['p12_file']    = $_POST['p12_file'];
			$tc_apple_wallet['p12_file_id'] = $_POST['p12_file_id'];

			$file_path = explode( 'uploads/', $_POST['p12_file'] )[1];

			$tc_apple_wallet['p12_file_abs_path'] = $uploads['basedir'] . '/' . $file_path;

		}

		if ( isset( $_REQUEST['icon_file'] ) && $_REQUEST['icon_file'] != '' ) {

		}

		/*
		if ( isset( $_FILES['icon_file'] ) && $_FILES['icon_file'] != '' ) {
			// Use the WordPress function to upload
			// test_upload_pdf corresponds to the position in the $_FILES array
			// 0 means the content is not associated with any other posts
			$uploaded = media_handle_upload( 'icon_file', 0 );
			echo 'uploaded: ' . $uploaded;
			die();
			// Error checking using WP functions
			if ( is_wp_error( $uploaded ) ) {
				// $error_message = "Error uploading file: " . $uploaded->get_error_message();
				if ( $tc_apple_wallet_settings['icon_file'] && $tc_apple_wallet_settings['icon_file'] != '' ) {
					$tc_apple_wallet['icon_file']          = $tc_apple_wallet_settings['icon_file'];
					$tc_apple_wallet['icon_file_abs_path'] = $tc_apple_wallet_settings['icon_file_abs_path'];
				}
			} else {
				$attachment_url                        = wp_get_attachment_url( $uploaded );
				$fullsize_path                         = get_attached_file( $uploaded );
				$tc_apple_wallet['icon_file']          = $attachment_url;
				$tc_apple_wallet['icon_file_abs_path'] = $fullsize_path;
				echo 'File upload successful!';
			}
		}

		if ( isset( $_FILES['wwrd_file'] ) && $_FILES['wwrd_file'] != '' ) {
			// Use the WordPress function to upload
			// test_upload_pdf corresponds to the position in the $_FILES array
			// 0 means the content is not associated with any other posts
			print_r( $_FILES['wwrd_file'] );
			$uploaded = media_handle_upload( 'wwrd_file', 0 );

			print_r( $uploaded );
			// Error checking using WP functions
			if ( is_wp_error( $uploaded ) ) {
				$error_message = 'Error uploading file: ' . $uploaded->get_error_message();
				if ( $tc_apple_wallet_settings['wwrd_file'] && $tc_apple_wallet_settings['wwrd_file'] != '' ) {
					$tc_apple_wallet['wwrd_file']          = $tc_apple_wallet_settings['wwrd_file'];
					$tc_apple_wallet['wwrd_file_abs_path'] = $tc_apple_wallet_settings['wwrd_file_abs_path'];
				}
			} else {
				$attachment_url                        = wp_get_attachment_url( $uploaded );
				$fullsize_path                         = get_attached_file( $uploaded );
				$tc_apple_wallet['wwrd_file']          = $attachment_url;
				$tc_apple_wallet['wwrd_file_abs_path'] = $fullsize_path;
			}
		}

		if ( isset( $_FILES['p12_file'] ) && $_FILES['p12_file'] != '' ) {
			// Use the WordPress function to upload
			// test_upload_pdf corresponds to the position in the $_FILES array
			// 0 means the content is not associated with any other posts
			$uploaded = media_handle_upload( 'p12_file', 0 );
			// print_r( $uploaded );
			// Error checking using WP functions
			if ( is_wp_error( $uploaded ) ) {
				$error_message = 'Error uploading file: ' . $uploaded->get_error_message();
				if ( $tc_apple_wallet_settings['p12_file'] && $tc_apple_wallet_settings['p12_file'] != '' ) {
					$tc_apple_wallet['p12_file']          = $tc_apple_wallet_settings['p12_file'];
					$tc_apple_wallet['p12_file_abs_path'] = $tc_apple_wallet_settings['p12_file_abs_path'];
				}
			} else {
				$attachment_url                       = wp_get_attachment_url( $uploaded );
				$fullsize_path                        = get_attached_file( $uploaded );
				$tc_apple_wallet['p12_file']          = $attachment_url;
				$tc_apple_wallet['p12_file_abs_path'] = $fullsize_path;
			}
		}
		*/
		update_option( 'tc_apple_wallet_settings', $tc_apple_wallet );
		$tc_apple_wallet_settings = get_option( 'tc_apple_wallet_settings' );
		// echo 'tc_apple_wallet_settings: ' . print_r( $tc_apple_wallet_settings, true );
		// die();
	}
}
$tc_apple_wallet_settings = get_option( 'tc_apple_wallet_settings' );


?>
<div class="wrap tc_wrap">
	<?php if ( ! empty( $error_message ) ) { ?>
		<div class="error"><p><?php echo $error_message; ?></p></div>
	<?php } ?>

	<div id="poststuff">
		<form action="" method="post" enctype="multipart/form-data">
			<div class="postbox">
				<h3 class="hndle"><span><?php _e( 'Apple Wallet Pass', 'tcawp' ); ?></span></h3>
				<div class="inside">
					<table class="form-table">
						<tbody>
							<tr>
								<th scope="row"><label for="qr_code_type"><?php _e( 'QR Code type', 'tcawp' ); ?></label></th>
								<td>
									<select name="tc_apple_wallet[qr_code_type]" id="qr_code_type">
										<option value="PKBarcodeFormatQR"
										<?php
										if ( $tc_apple_wallet_settings['qr_code_type'] == 'PKBarcodeFormatQR' ) {
											echo ' selected ';}
										?>
										 >PKBarcodeFormatQR</option>
										<option value="PKBarcodeFormatPDF417"
										<?php
										if ( $tc_apple_wallet_settings['qr_code_type'] == 'PKBarcodeFormatPDF417' ) {
											echo ' selected ';}
										?>
										>PKBarcodeFormatPDF417</option>
										<option value="PKBarcodeFormatAztec"
										<?php
										if ( $tc_apple_wallet_settings['qr_code_type'] == 'PKBarcodeFormatAztec' ) {
											echo ' selected ';}
										?>
										>PKBarcodeFormatAztec</option>
										<option value="PKBarcodeFormatCode128"
										<?php
										if ( $tc_apple_wallet_settings['qr_code_type'] == 'PKBarcodeFormatCode128' ) {
											echo ' selected ';}
										?>
										>PKBarcodeFormatCode128</option>
									</select>
									<p class="description"><?php _e( 'QR code type', 'tcawp' ); ?></p>
								</td>
							</tr>
							<?php if ( $tc_apple_wallet_settings['icon_file'] && $tc_apple_wallet_settings['icon_file'] != '' ) { ?>
							<tr>
								<th scope="row">&nbsp;</th>
								<td>
								<img src="<?php echo $tc_apple_wallet_settings['icon_file']; ?>" width="100" />
								</td>
							</tr>
							<?php }//if ?>
							<tr>
								<th scope="row"><label for="icon_file"><?php _e( 'Icon File', 'tcawp' ); ?></label></th>
								<td>
									<input type="hidden" name="icon_file_id" class="form-control-tc" id="icon_file_id" value="<?php echo $tc_apple_wallet_settings[ 'icon_file_id' ]; ?>" />

									<input name="icon_file" type="text" id="icon_file" value="<?php echo $tc_apple_wallet_settings[ 'icon_file' ]; ?>" class="regular-text"><input type="button" id="upload" value="Choose File" class="sub_btn upload_image_button" data="icon_file_id" rel="icon_file">

									<p class="description"><?php _e( 'Icon File', 'tcawp' ); ?></p>
								</td>
							</tr>
							<tr>
								<th scope="row"><label for="logo_text"><?php _e( 'Logo Text', 'tcawp' ); ?></label></th>
								<td>
									<input name="tc_apple_wallet[logo_text]" type="text" id="logo_text" value="<?php echo isset( $tc_apple_wallet_settings['logo_text'] ) ? $tc_apple_wallet_settings['logo_text'] : ''; ?>" class="regular-text">
									<p class="description"><?php _e( 'Logo Text', 'tcawp' ); ?></p>
								</td>
							</tr>
							<tr>
								<th scope="row"><label for="background_color"><?php _e( 'Background Color', 'tcawp' ); ?></label></th>
								<td>
									<input name="tc_apple_wallet[background_color]" type="text" id="background_color" value="<?php echo isset( $tc_apple_wallet_settings['background_color'] ) ? $tc_apple_wallet_settings['background_color'] : '#aaaaaa'; ?>" class="regular-text">
									<p class="description"><?php _e( 'Background Color', 'tcawp' ); ?></p>
								</td>
							</tr>
							<tr>
								<th scope="row"><label for="organisation_name"><?php _e( 'Organization Name', 'tcawp' ); ?></label></th>
								<td>
									<input name="tc_apple_wallet[organisation_name]" type="text" id="organisation_name" value="<?php echo isset( $tc_apple_wallet_settings['organisation_name'] ) ? $tc_apple_wallet_settings['organisation_name'] : ''; ?>" class="regular-text">
									<p class="description"><?php _e( 'Organization Name', 'tcawp' ); ?></p>
								</td>
							</tr>

							<tr>
								<th scope="row"><label for="team_identifier"><?php _e( 'Team Identifier', 'tcawp' ); ?></label></th>
								<td>
									<input name="tc_apple_wallet[team_identifier]" type="text" id="team_identifier" value="<?php echo isset( $tc_apple_wallet_settings['team_identifier'] ) ? $tc_apple_wallet_settings['team_identifier'] : ''; ?>" class="regular-text">
									<p class="description"><?php _e( 'Team Identifier', 'tcawp' ); ?></p>
								</td>
							</tr>

							<tr>
								<th scope="row"><label for="pass_type_identifier"><?php _e( 'Pass Type Identifier', 'tcawp' ); ?></label></th>
								<td>
									<input name="tc_apple_wallet[pass_type_identifier]" type="text" id="pass_type_identifier" value="<?php echo isset( $tc_apple_wallet_settings['pass_type_identifier'] ) ? $tc_apple_wallet_settings['pass_type_identifier'] : ''; ?>" class="regular-text">
									<p class="description"><?php _e( 'Pass Type Identifier', 'tcawp' ); ?></p>
								</td>
							</tr>

							<tr>
								<th scope="row"><label for="wwrd_file"><?php _e( 'WWRD File', 'tcawp' ); ?></label></th>
								<td>
								<input type="hidden" name="wwrd_file_id" class="form-control-tc" id="wwrd_file_id" value="<?php echo $tc_apple_wallet_settings[ 'wwrd_file_id' ]; ?>" />

									<input name="wwrd_file" type="text" id="wwrd_file" value="<?php echo $tc_apple_wallet_settings[ 'wwrd_file' ]; ?>" class="regular-text"><input type="button" id="upload1" value="Choose File" class="sub_btn upload_image_button" data="wwrd_file_id" rel="wwrd_file"> &nbsp;
																											<?php
																											if ( $tc_apple_wallet_settings[ 'wwrd_file' ] && $tc_apple_wallet_settings[ 'wwrd_file' ] != '' ) {
																												?>
										 <a href="<?php echo $tc_apple_wallet_settings[ 'wwrd_file' ]; ?>" target="_blank">Click here to download</a> <?php } ?>
									<p class="description"><?php _e( 'WWRD File', 'tcawp' ); ?></p>
								</td>
							</tr>

							<tr>
								<th scope="row"><label for="p12_file"><?php _e( 'P12 File', 'tcawp' ); ?></label></th>
								<td>
								<input type="hidden" name="p12_file_id" class="form-control-tc" id="p12_file_id" value="value="<?php echo $tc_apple_wallet_settings[ 'p12_file_id' ]; ?>"" />

								<input name="p12_file" type="text" id="p12_file" value="<?php echo $tc_apple_wallet_settings[ 'p12_file' ]; ?>" class="regular-text"><input type="button" id="upload2" value="Choose File" class="sub_btn upload_image_button" data="p12_file_id" rel="p12_file">&nbsp;
																									<?php
																									if ( $tc_apple_wallet_settings[ 'p12_file' ] && $tc_apple_wallet_settings[ 'p12_file' ] != '' ) {
																										?>
									 <a href="<?php echo $tc_apple_wallet_settings[ 'p12_file' ]; ?>" target="_blank">Click here to download</a> <?php } ?>
									<p class="description"><?php _e( 'P12 File', 'tcawp' ); ?></p>
								</td>
							</tr>

							<tr>
								<th scope="row"><label for="p12_passwrd"><?php _e( 'P12 password', 'tcawp' ); ?></label></th>
								<td>

									<input name="tc_apple_wallet[p12_passwrd]" type="text" id="p12_passwrd" value="<?php echo isset( $tc_apple_wallet_settings['p12_passwrd'] ) ? $tc_apple_wallet_settings['p12_passwrd'] : ''; ?>" class="regular-text">
									<p class="description"><?php _e( 'P12 password', 'tcawp' ); ?></p>
								</td>
							</tr>

							<tr>
								<th scope="row"></th>
								<td>
									You can read Apple wallet instruction <a href="https://developer.apple.com/library/archive/documentation/UserExperience/Conceptual/PassKit_PG/YourFirst.html" target="_blank">here</a>.
								</td>
							</tr>


						</tbody>
					</table>
				</div>
			</div>


			<?php
			wp_nonce_field( 'save_apple_wallet_settings', 'save_apple_wallet_settings_nonce' );
			?>
			<?php submit_button(); ?>
		</form>
	</div>
</div>
<script>
var above_id = '';

 jQuery(document).ready(function() {



 jQuery('#upload').click(function(e) {
  e.preventDefault();
  var custom_uploader = '';
   if (custom_uploader) {
   custom_uploader.open();
   return;
  }

  target_input = jQuery(this).attr('rel');
  target_id = jQuery(this).attr('data');

  custom_uploader = wp.media.frames.file_frame = wp.media({
   title: 'Choose Image',
   button: {
	text: 'Choose Image'
   },
   multiple: false
  });

  custom_uploader.on('select', function() {
   attachment = custom_uploader.state().get('selection').first().toJSON();
   jQuery('input[name=' + target_input + ']').val(attachment.url);
   jQuery('input[name=' + target_id + ']').val(attachment.id);

  });

 custom_uploader.open();
 });
 jQuery('#upload1').click(function(e) {
  e.preventDefault();
  var custom_uploader = '';
   if (custom_uploader) {
   custom_uploader.open();
   return;
  }

  target_input = jQuery(this).attr('rel');
  target_id = jQuery(this).attr('data');

  custom_uploader = wp.media.frames.file_frame = wp.media({
   title: 'Choose Image',
   button: {
	text: 'Choose Image'
   },
   multiple: false
  });

  custom_uploader.on('select', function() {
   attachment = custom_uploader.state().get('selection').first().toJSON();
   jQuery('input[name=' + target_input + ']').val(attachment.url);
   jQuery('input[name=' + target_id + ']').val(attachment.id);

  });

 custom_uploader.open();
 });
 jQuery('#upload2').click(function(e) {
  e.preventDefault();
  var custom_uploader = '';
   if (custom_uploader) {
   custom_uploader.open();
   return;
  }

  target_input = jQuery(this).attr('rel');
  target_id = jQuery(this).attr('data');

  custom_uploader = wp.media.frames.file_frame = wp.media({
   title: 'Choose Image',
   button: {
	text: 'Choose Image'
   },
   multiple: false
  });

  custom_uploader.on('select', function() {
   attachment = custom_uploader.state().get('selection').first().toJSON();
   jQuery('input[name=' + target_input + ']').val(attachment.url);
   jQuery('input[name=' + target_id + ']').val(attachment.id);
  });

 custom_uploader.open();
 });
 });
</script>
