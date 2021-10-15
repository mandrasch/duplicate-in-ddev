<?php
/**
 * Plugin Name:     Duplicate In Ddev
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          YOUR NAME HERE
 * Author URI:      YOUR SITE HERE
 * Text Domain:     duplicate-in-ddev
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Duplicate_In_Ddev
 */

// Your code starts here.

// TODO: use own functions

add_action( 'admin_menu', 'stp_api_add_admin_menu' );
add_action( 'admin_init', 'stp_api_settings_init' );

function stp_api_add_admin_menu(  ) {
    add_options_page( 'Duplicate in DDEV', 'Duplicate in DDEV', 'manage_options', 'duplicate-in-ddev-page', 'stp_api_options_page' );
}

function stp_api_settings_init(  ) {
    register_setting( 'stpPlugin', 'stp_api_settings' );
    add_settings_section(
        'stp_api_stpPlugin_section',
        __( 'Our Section Title', 'wordpress' ),
        'stp_api_settings_section_callback',
        'stpPlugin'
    );

    add_settings_field(
        'stp_api_text_field_0',
        __( 'Our Field 0 Title', 'wordpress' ),
        'stp_api_text_field_0_render',
        'stpPlugin',
        'stp_api_stpPlugin_section'
    );

    add_settings_field(
        'stp_api_select_field_1',
        __( 'Our Field 1 Title', 'wordpress' ),
        'stp_api_select_field_1_render',
        'stpPlugin',
        'stp_api_stpPlugin_section'
    );
}

function stp_api_text_field_0_render(  ) {
    $options = get_option( 'stp_api_settings' );
    ?>
    <input type='text' name='stp_api_settings[stp_api_text_field_0]' value='<?php echo $options['stp_api_text_field_0']; ?>'>
    <?php
}

function stp_api_select_field_1_render(  ) {
    $options = get_option( 'stp_api_settings' );
    ?>
    <select name='stp_api_settings[stp_api_select_field_1]'>
        <option value='1' <?php selected( $options['stp_api_select_field_1'], 1 ); ?>>Option 1</option>
        <option value='2' <?php selected( $options['stp_api_select_field_1'], 2 ); ?>>Option 2</option>
    </select>

<?php
}
// https://www.robbertvermeulen.com/wordpress-get-domain/
//
function get_domain() {
	$protocols = array( 'http://', 'https://', 'http://www.', 'https://www.', 'www.' );
	return str_replace( $protocols, '', site_url() );
	// TODO: strip domain ending(s) such as .co.at
 }

function stp_api_settings_section_callback(  ) {
    echo __( 'This Section Description', 'wordpress' );
}

function stp_api_options_page(  ) {
    ?>
    <form action='options.php' method='post'>

        <h2>Duplicate in DDEV</h2>

		<?php $new_domain_ddev = "my-local-site"; ?>
		<p>Your desired DDEV project URL: <input type="text" value="<?php echo $new_domain_ddev; ?>" />.ddev.site</p>

		<p style="color:#999;">Automatically collected setting values:
			<ul style="color:#999;">
				<li>DB_NAME = <?php echo DB_NAME; ?></li>
				<li> option:upload_path = "<?php echo get_option("upload_path"); ?>"</li>
				<li>option:siteurl = "<?php echo get_option('siteurl'); ?>"</li>
				<li> PHP = "<?php echo phpversion(); ?>" </li><?php // TODO: strip minor ?>
			</ul>
</p>

<b>Follow these steps</b>

		<ol>
			<li>Create backup with <a href="https://de.wordpress.org/plugins/backwpup/">BackWPup</a></li>
			<li>Download the created backup .zip-file</li>
			<li>Unzip it to a directory of your choice</li>
			<li>Run the following commands inside this directory:<br>

				<pre style="max-width:100%;white-space: pre-wrap;margin-right:10px;">ddev config --project-name="<?php echo $new_domain_ddev; ?>" --project-type=wordpress --php-version="7.4"

ddev start

ddev exec 'wp config set DB_NAME "db" && wp config set DB_USER "db" && wp config set DB_PASSWORD "db" && wp config set DB_HOST "db"'

ddev import-db --src="<?php echo DB_NAME; ?>.sql"

ddev exec 'wp search-replace "<?php echo get_option('siteurl'); ?>" "https://my-local-wordpress.ddev.site"'

# TODO replace upload_path if set with /var/www/html/wp-content/uploads

# TODO: Save permalinks again to re-generate, wp rewrite flush?!

ddev launch




</pre>

			<li>
		</ol>

        <?php
        settings_fields( 'stpPlugin' );
        do_settings_sections( 'stpPlugin' );
        submit_button();
        ?>

    </form>
    <?php
}
