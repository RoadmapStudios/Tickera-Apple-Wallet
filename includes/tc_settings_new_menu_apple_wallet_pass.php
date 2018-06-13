<?php

$error_message = '';

if (isset($_POST['save_apple_wallet_settings_nonce']) && wp_verify_nonce($_POST['save_apple_wallet_settings_nonce'], 'save_apple_wallet_settings')) {
    if(isset($_POST['tc_apple_wallet'])) {
$tc_apple_wallet_settings = get_option('tc_apple_wallet_settings');
// print_r($tc_apple_wallet_settings);
        $tc_apple_wallet = $_POST['tc_apple_wallet'];
        if(isset($_FILES['icon_file']) && $_FILES['icon_file']!=""){
            // Use the wordpress function to upload
            // test_upload_pdf corresponds to the position in the $_FILES array
            // 0 means the content is not associated with any other posts
            $uploaded=media_handle_upload('icon_file', 0);
            // print_r($attachment_url);
            // Error checking using WP functions
            if(is_wp_error($uploaded)){
                // $error_message = "Error uploading file: " . $uploaded->get_error_message();
                if($tc_apple_wallet_settings["icon_file"] && $tc_apple_wallet_settings["icon_file"]!="") {
                    $tc_apple_wallet["icon_file"] = $tc_apple_wallet_settings["icon_file"];
                    $tc_apple_wallet["icon_file_abs_path"] = $tc_apple_wallet_settings["icon_file_abs_path"];    
                }
            }else{
                $attachment_url = wp_get_attachment_url($uploaded);
                $fullsize_path = get_attached_file( $uploaded );
                $tc_apple_wallet["icon_file"] = $attachment_url;
                $tc_apple_wallet["icon_file_abs_path"] = $fullsize_path;
                // echo "File upload successful!";
            }
        }

        if(isset($_FILES['wwrd_file']) && $_FILES['wwrd_file']!=""){
            // Use the wordpress function to upload
            // test_upload_pdf corresponds to the position in the $_FILES array
            // 0 means the content is not associated with any other posts
            print_r($_FILES['wwrd_file']);
            $uploaded=media_handle_upload('wwrd_file', 0);

            print_r($uploaded);
            // Error checking using WP functions
            if(is_wp_error($uploaded)){
                $error_message = "Error uploading file: " . $uploaded->get_error_message();
                if($tc_apple_wallet_settings["wwrd_file"] && $tc_apple_wallet_settings["wwrd_file"]!="") {
                    $tc_apple_wallet["wwrd_file"] = $tc_apple_wallet_settings["wwrd_file"];
                    $tc_apple_wallet["wwrd_file_abs_path"] = $tc_apple_wallet_settings["wwrd_file_abs_path"];    
                }
            }else{
                $attachment_url = wp_get_attachment_url($uploaded);
                $fullsize_path = get_attached_file( $uploaded );
                $tc_apple_wallet["wwrd_file"] = $attachment_url;
                $tc_apple_wallet["wwrd_file_abs_path"] = $fullsize_path;
            }
        }

        if(isset($_FILES['p12_file']) && $_FILES['p12_file']!=""){
            // Use the wordpress function to upload
            // test_upload_pdf corresponds to the position in the $_FILES array
            // 0 means the content is not associated with any other posts
            $uploaded=media_handle_upload('p12_file', 0);
            print_r($uploaded);
            // Error checking using WP functions
            if(is_wp_error($uploaded)){
                $error_message = "Error uploading file: " . $uploaded->get_error_message();
                if($tc_apple_wallet_settings["p12_file"] && $tc_apple_wallet_settings["p12_file"]!="") {
                    $tc_apple_wallet["p12_file"] = $tc_apple_wallet_settings["p12_file"];
                    $tc_apple_wallet["p12_file_abs_path"] = $tc_apple_wallet_settings["p12_file_abs_path"];    
                }
            }else{
                $attachment_url = wp_get_attachment_url($uploaded);
                $fullsize_path = get_attached_file( $uploaded );
                $tc_apple_wallet["p12_file"] = $attachment_url;
                $tc_apple_wallet["p12_file_abs_path"] = $fullsize_path;               
            }
        }
        update_option('tc_apple_wallet_settings', $tc_apple_wallet);
        $tc_apple_wallet_settings = get_option('tc_apple_wallet_settings');
    }
}
$tc_apple_wallet_settings = get_option('tc_apple_wallet_settings');
?>
<div class="wrap tc_wrap">
    <?php if (!empty($error_message)) { ?>
        <div class="error"><p><?php echo $error_message; ?></p></div>
    <?php } ?>

    <div id="poststuff">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="postbox">
                <h3 class="hndle"><span><?php _e('Apple Wallet Pass', 'tcawp'); ?></span></h3>
                <div class="inside">
                    <table class="form-table">
                        <tbody>
                            <tr>
                                <th scope="row"><label for="qr_code_type"><?php _e('QR Code type', 'tcawp') ?></label></th>
                                <td>
                                    <select name="tc_apple_wallet[qr_code_type]" id="qr_code_type">
                                        <option value="PKBarcodeFormatQR" <?php if($tc_apple_wallet_settings['qr_code_type']=="PKBarcodeFormatQR") echo " selected "; ?> >PKBarcodeFormatQR</option>
                                        <option value="PKBarcodeFormatPDF417" <?php if($tc_apple_wallet_settings['qr_code_type']=="PKBarcodeFormatPDF417") echo " selected "; ?>>PKBarcodeFormatPDF417</option>
                                        <option value="PKBarcodeFormatAztec" <?php if($tc_apple_wallet_settings['qr_code_type']=="PKBarcodeFormatAztec") echo " selected "; ?>>PKBarcodeFormatAztec</option>
                                        <option value="PKBarcodeFormatCode128" <?php if($tc_apple_wallet_settings['qr_code_type']=="PKBarcodeFormatCode128") echo " selected "; ?>>PKBarcodeFormatCode128</option>
                                    </select>
                                    <p class="description"><?php _e('QR code type', 'tcawp'); ?></p>
                                </td>
                            </tr>
                            <?php if($tc_apple_wallet_settings['icon_file'] && $tc_apple_wallet_settings['icon_file']!="")  { ?>
                            <tr>
                                <th scope="row">&nbsp;</th>
                                <td>
                                <img src="<?php echo $tc_apple_wallet_settings['icon_file']; ?>" width="100" />
                                </td>
                            </tr>
                            <?php }//if ?>
                            <tr>
                                <th scope="row"><label for="icon_file"><?php _e('Icon File', 'tcawp') ?></label></th>
                                <td>

                                    <input name="icon_file" type="file" id="icon_file" class="regular-text">
                                    <p class="description"><?php _e('Icon File', 'tcawp'); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="logo_text"><?php _e('Logo Text', 'tcawp') ?></label></th>
                                <td>
                                    <input name="tc_apple_wallet[logo_text]" type="text" id="logo_text" value="<?php echo isset($tc_apple_wallet_settings['logo_text']) ? $tc_apple_wallet_settings['logo_text'] : ''; ?>" class="regular-text">
                                    <p class="description"><?php _e('Logo Text', 'tcawp'); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="background_color"><?php _e('Background Color', 'tcawp') ?></label></th>
                                <td>
                                    <input name="tc_apple_wallet[background_color]" type="text" id="background_color" value="<?php echo isset($tc_apple_wallet_settings['background_color']) ? $tc_apple_wallet_settings['background_color'] : '#aaaaaa'; ?>" class="regular-text">
                                    <p class="description"><?php _e('Background Color', 'tcawp'); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="organisation_name"><?php _e('Organization Name', 'tcawp') ?></label></th>
                                <td>
                                    <input name="tc_apple_wallet[organisation_name]" type="text" id="organisation_name" value="<?php echo isset($tc_apple_wallet_settings['organisation_name']) ? $tc_apple_wallet_settings['organisation_name'] : ''; ?>" class="regular-text">
                                    <p class="description"><?php _e('Organization Name', 'tcawp'); ?></p>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row"><label for="team_identifier"><?php _e('Team Identifier', 'tcawp') ?></label></th>
                                <td>
                                    <input name="tc_apple_wallet[team_identifier]" type="text" id="team_identifier" value="<?php echo isset($tc_apple_wallet_settings['team_identifier']) ? $tc_apple_wallet_settings['team_identifier'] : ''; ?>" class="regular-text">
                                    <p class="description"><?php _e('Team Identifier', 'tcawp'); ?></p>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row"><label for="pass_type_identifier"><?php _e('Pass Type Identifier', 'tcawp') ?></label></th>
                                <td>
                                    <input name="tc_apple_wallet[pass_type_identifier]" type="text" id="pass_type_identifier" value="<?php echo isset($tc_apple_wallet_settings['pass_type_identifier']) ? $tc_apple_wallet_settings['pass_type_identifier'] : ''; ?>" class="regular-text">
                                    <p class="description"><?php _e('Pass Type Identifier', 'tcawp'); ?></p>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row"><label for="wwrd_file"><?php _e('WWRD File', 'tcawp') ?></label></th>
                                <td>
                                    <input name="wwrd_file" type="file" id="wwrd_file" class="regular-text"> &nbsp; <?php if($tc_apple_wallet_settings[wwrd_file] && $tc_apple_wallet_settings[wwrd_file] !="") { ?> <a href="<?php echo $tc_apple_wallet_settings[wwrd_file]; ?>" target="_blank">Click here to download</a> <?php } ?>
                                    <p class="description"><?php _e('WWRD File', 'tcawp'); ?></p>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row"><label for="p12_file"><?php _e('P12 File', 'tcawp') ?></label></th>
                                <td>
                                    <input name="p12_file" type="file" id="p12_file"  class="regular-text"> &nbsp; <?php if($tc_apple_wallet_settings[p12_file] && $tc_apple_wallet_settings[p12_file] !="") { ?> <a href="<?php echo $tc_apple_wallet_settings[p12_file]; ?>" target="_blank">Click here to download</a> <?php } ?>
                                    <p class="description"><?php _e('P12 File', 'tcawp'); ?></p>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row"><label for="p12_passwrd"><?php _e('P12 password', 'tcawp') ?></label></th>
                                <td>
                                    <input name="tc_apple_wallet[p12_passwrd]" type="text" id="p12_passwrd" value="<?php echo isset($tc_apple_wallet_settings['p12_passwrd']) ? $tc_apple_wallet_settings['p12_passwrd'] : ''; ?>" class="regular-text">
                                    <p class="description"><?php _e('P12 password', 'tcawp'); ?></p>
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

           
            <?php wp_nonce_field('save_apple_wallet_settings', 'save_apple_wallet_settings_nonce');
            ?>
            <?php submit_button(); ?>
        </form>
    </div>
</div>