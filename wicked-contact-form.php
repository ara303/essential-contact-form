<?php
/* Plugin Name: Wicked Contact Form
Plugin URI: https://github.com/edadams/wickedcontactform
Description: A contact form plugin with just the essentials.
Version: 1
Author: E. Adams
Author URI: https://edadams.io
License: GPL2
*/
function wickedcf_register_shortcode() {
	ob_start();
	include( 'templates/form-markup.php' );
	return ob_get_clean();
}
add_shortcode( 'wicked_contact_form', 'wickedcf_register_shortcode' );



function wickedcf_create_settings_page() {
    add_options_page( 'Contact Form Settings', 'Contact Form', 'manage_options', 'wicked-contact-form', 'wickedcf_settings_page' );
}
add_action( 'admin_menu', 'wickedcf_create_settings_page' );

function wickedcf_settings_page() {
    ?>
    <div class="wrap">
	    <h2>Contact Form Settings</h2>
	    <form action="options.php" method="post">
	        <?php 
	        settings_fields( 'wickedcf_settings' );
	        do_settings_sections( __FILE__ );
	        submit_button();
	        ?>
	    </form>
	</div>
    <?php
}


function wickedcf_register_settings() {
	register_setting( 'wickedcf_settings', 'wickedcf_settings', 'wickedcf_settings_validate' );
	add_settings_section( 'wickedcf_settings_email', 'Submissions', 'wickedcf_settings_email_get', __FILE__ );
	add_settings_field( 'email_address', 'Recipient email address', 'wickedcf_settings_email_address_get', __FILE__, 'wickedcf_settings_recaptcha' );
	
	add_settings_section( 'wickedcf_settings_recaptcha', 'reCAPTCHA v3 keys', 'wickedcf_settings_recaptcha_get', __FILE__ );
	add_settings_field( 'recaptcha_site', 'Site key', 'wickedcf_settings_recaptcha_site_get', __FILE__, 'wickedcf_settings_recaptcha' );
	add_settings_field( 'recaptcha_secret', 'Secret key', 'wickedcf_settings_recaptcha_secret_get', __FILE__, 'wickedcf_settings_recaptcha' );
}
add_action( 'admin_init', 'wickedcf_register_settings' );

function wickedcf_settings_recaptcha_get() {
	?>
	<p>Generate site and secret keys on <a href="https://www.google.com/recaptcha/admin/create" target="_new" rel="nofollow">reCAPTCHA admin console</a>. You must choose <strong>reCAPTCHA v3</strong>. Domain name: <kbd><?php echo $_SERVER['SERVER_NAME']; ?></kbd>.</p>
	<?php
}

function wickedcf_settings_email_get() {
	?>
	<p>The email address to which form submissions are sent.</p>
	<?php
}

function wickedcf_settings_email_address_get() {
    $settings = get_option( 'wickedcf_settings' );
	echo '<input id="email_address" name="wickedcf_settings[email_address]" type="text" value="' . $settings['email_address'] . '" style="width: 100%; max-width: 600px;">';
}

function wickedcf_settings_recaptcha_site_get() {
    $settings = get_option( 'wickedcf_settings' );
	echo '<input id="recaptcha_site" name="wickedcf_settings[recaptcha_site]" type="text" value="' . $settings['recaptcha_site'] . '" style="width: 100%; max-width: 400px;">';
}

function wickedcf_settings_recaptcha_secret_get() {
    $settings = get_option( 'wickedcf_settings' );
	echo '<input id="recaptcha_secret" name="wickedcf_settings[recaptcha_secret]" type="text" value="' . $settings['recaptcha_secret'] . '" style="width: 100%; max-width: 400px;">';
}


function wickedcf_if_no_keys() {
    $wickedcf_settings = get_option( 'wickedcf_settings' );
	if( empty( $wickedcf_settings['recaptcha_site'] ) || empty( $wickedcf_settings['recaptcha_site'] ) ){
	    ?>
	    <div class="notice notice-error">
	        <p>reCAPTCHA site and/or secret keys not configured. <a href="options-general.php?page=wicked-contact-form">Set up now</a></p>
	    </div>
	    <?php
	}
}
add_action( 'admin_notices', 'wickedcf_if_no_keys' );



function wickedcf_settings_defaults() {
    $wickedcf_settings_defaults = [
    	'email_address' => get_userdata( 1 )->user_email,
    	'recaptcha_site' => '',
    	'recaptcha_secret' => ''
    ];
    update_option( 'wickedcf_settings', $wickedcf_settings_defaults );
}
register_activation_hook( __FILE__, 'wickedcf_settings_defaults' );


function wickedcf_uninstall() {
	delete_option( 'wickedcf_settings' );
}
register_deactivation_hook( __FILE__, 'wickedcf_uninstall' );
