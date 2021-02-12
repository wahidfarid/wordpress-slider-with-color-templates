<?php
/**
 * Elementor_Awesomesauce class.
 *
 * @category   Class
 * @package    WSLIDER
 * @subpackage WordPress
 * @author     Ben Marshall <me@benmarshall.me>
 * @copyright  2020 Ben Marshall
 * @license    https://opensource.org/licenses/GPL-3.0 GPL-3.0-only
 * @link       link(https://www.benmarshall.me/build-custom-elementor-widgets/,
 *             Build Custom Elementor Widgets)
 * @since      1.0.0
 * php version 7.3.9
 */

if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly.
	exit;
}

/**
 * Main Elementor Awesomesauce Class
 *
 * The init class that runs the Elementor Awesomesauce plugin.
 * Intended To make sure that the plugin's minimum requirements are met.
 *
 * You should only modify the constants to match your plugin's needs.
 *
 * Any custom code should go inside Plugin Class in the class-widgets.php file.
 */
final class WSLIDER {

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 * @var string The plugin version.
	 */
	const VERSION = '1.0.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '7.0';

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		// Load the translation.
		add_action( 'init', array( $this, 'i18n' ) );

		// Initialize the plugin.
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	/**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 * Fired by `init` action hook.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function i18n() {
		load_plugin_textdomain( 'w-slider' );
	}

	/**
	 * Initialize the plugin
	 *
	 * Validates that Elementor is already loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed include the plugin class.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function init() {

		// Check if Elementor installed and activated.
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
			return;
		}

		// Check for required Elementor version.
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
			return;
		}

		// Check for required PHP version.
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
			return;
		}


		add_action( 'add_meta_boxes', 'wslider_add_meta_boxes' );
		add_action( 'save_post_car', 'wslider_save_meta_box_data' );

		// Once we get here, We have passed all validation checks so we can safely include our widgets.
		require_once 'class-widgets.php';
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {
		deactivate_plugins( plugin_basename( WSLIDER ) );

		return sprintf(
			wp_kses(
				'<div class="notice notice-warning is-dismissible"><p><strong>"%1$s"</strong> requires <strong>"%2$s"</strong> to be installed and activated.</p></div>',
				array(
					'div' => array(
						'class'  => array(),
						'p'      => array(),
						'strong' => array(),
					),
				)
			),
			'w-slider',
			'Elementor'
		);
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {
		deactivate_plugins( plugin_basename( WSLIDER ) );

		return sprintf(
			wp_kses(
				'<div class="notice notice-warning is-dismissible"><p><strong>"%1$s"</strong> requires <strong>"%2$s"</strong> version %3$s or greater.</p></div>',
				array(
					'div' => array(
						'class'  => array(),
						'p'      => array(),
						'strong' => array(),
					),
				)
			),
			'w-slider',
			'Elementor',
			self::MINIMUM_ELEMENTOR_VERSION
		);
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {
		deactivate_plugins( plugin_basename( WSLIDER ) );

		return sprintf(
			wp_kses(
				'<div class="notice notice-warning is-dismissible"><p><strong>"%1$s"</strong> requires <strong>"%2$s"</strong> version %3$s or greater.</p></div>',
				array(
					'div' => array(
						'class'  => array(),
						'p'      => array(),
						'strong' => array(),
					),
				)
			),
			'w-slider',
			'Elementor',
			self::MINIMUM_ELEMENTOR_VERSION
		);
	}

}

// Adding Meta Box

function wslider_add_meta_boxes( $post ){
	add_meta_box( 'wslider_meta_box', __( '360 Slider Images', 'w-slider' ), 'wslider_build_meta_box', 'car', 'advanced');
}

function wslider_build_meta_box( $post ){
	// make sure the form request comes from WordPress
	wp_nonce_field( basename( __FILE__ ), 'wslider_meta_box_nonce' );

	// retrieve the _food_cholesterol current value
	$current_cholesterol = get_post_meta( $post->ID, '_food_cholesterol', true );

	// retrieve the _food_carbohydrates current value
	$current_carbohydrates = get_post_meta( $post->ID, '_food_carbohydrates', true );

	$vitamins = array( 'Vitamin A', 'Thiamin (B1)', 'Riboflavin (B2)', 'Niacin (B3)', 'Pantothenic Acid (B5)', 'Vitamin B6', 'Vitamin B12', 'Vitamin C', 'Vitamin D', 'Vitamin E', 'Vitamin K' );
	
	// stores _food_vitamins array 
	$current_vitamins = ( get_post_meta( $post->ID, '_food_vitamins', true ) ) ? get_post_meta( $post->ID, '_food_vitamins', true ) : array();

	$wslider_hash = get_post_meta( $post->ID, '_wslider_hash', true );
	$wslider_hash = json_decode($wslider_hash);
	if($wslider_hash == NULL)
		$wslider_hash = new stdClass();

	$image = 'Upload Image';
    $button = 'button';
    $image_size = 'full'; // it would be better to use thumbnail size here (150x150 or so)
	$display = 'none'; // display state of the "Remove image" button
	$name="wslider";
	$value="";
     
    ?>
     
    <!-- <p><?php
        _e( '<i>Set Images for Featured Image Gallery</i>', 'mytheme' );
    ?></p> -->
	<div class='inside'>
	
		<h3><?php _e( '360 images', 'wslider' ); ?></h3>

		<input type="text" id="wslider-hash" value="'{}'" name="wslider-hash" hidden />
		<input type="text" id="color-name" placeholder="new color name" />
		<input id="add-color" class="button" type="button" value="Add Color" onclick="addColor()"/>
		<hr />

		<div class="wslider-wrapper">

<!-- molto -->

<?php 
	foreach( $wslider_hash as $key => $value) {
		// echo "$key => $value\n";
		?>

		<label class="wslider-color-block" data-color="<?php echo $key ?>">
			<h4><?php echo $key ?></h4>
			<br/>
			<input type="color" value="<?php echo $value->{'color'} ?>" class="wslider-color-value" name="wslider.color-<?php echo $key ?>" onchange="update_wslider_meta()">
			<div class="gallery-screenshot clearfix">
				<?php
				{
					$ids = explode(',', $value->{'images'});
					if(count($ids)>0){
						foreach ($ids as $attachment_id) {
							$img = wp_get_attachment_image_src($attachment_id, 'thumbnail');
							if($img){
								echo '<div class="screen-thumb" style="float: left;"><img src="' . esc_url($img[0]) . '" /></div>';
							}
						}
					}
				}
				?>
			</div>
			
			<input id="edit-gallery" class="button upload_gallery_button" type="button"
				value="<?php esc_html_e('Add/Edit Gallery', 'mytheme') ?>" onclick="triggerUploadGallery(event)"/>
			<input id="clear-gallery" class="button upload_gallery_button" type="button"
				value="<?php esc_html_e('Clear Images', 'mytheme') ?>" onclick="triggerUploadGallery(event)"/>
			<input id="delete-gallery" class="button" type="button"
				value="Delete Color" onclick="deleteColorBlock(event)"/>
			<input type="hidden" name="wslider.<?php echo $key ?>" id="<?php echo esc_attr($name); ?>" class="gallery_values" value="<?php echo $value->{'images'} ?>">
		</label>
		<hr/>

		<?php
	}
?>
		</div>
		

		<script>

		function addColor(){

			if(!jQuery("#color-name").val()){
				alert("please enter color name");
				return;
			}

			var controls = `<label class="wslider-color-block" data-color="`+jQuery("#color-name").val()+`">
			<h4>`+jQuery("#color-name").val()+`</h4>
			<br/>
			<input type="color" value="#CC0000" class="wslider-color-value" name="wslider.color-`+jQuery("#color-name").val()+`" onchange="update_wslider_meta()">
			<div class="gallery-screenshot clearfix">
			</div>
			
			<input id="edit-gallery" class="button upload_gallery_button" type="button"
				value="<?php esc_html_e('Add/Edit Gallery', 'mytheme') ?>" onclick="triggerUploadGallery(event)"/>
			<input id="clear-gallery" class="button upload_gallery_button" type="button"
				value="<?php esc_html_e('Clear', 'mytheme') ?>" onclick="triggerUploadGallery(event)"/>
			<input type="hidden" name="wslider.`+jQuery("#color-name").val()+`" class="gallery_values" value="">
		</label>
		<hr/>`

			jQuery(".wslider-wrapper").append(controls);
			jQuery("#color-name").val("");
		}


		function deleteColorBlock(event){

			var r = confirm("Are you sure you want to delete this color?");
			if (r == true) {
				var current_gallery = jQuery( event.srcElement ).closest( 'label' );
				current_gallery.remove();	
				update_wslider_meta();			
			} else {
				return;
			}
		}

		function triggerUploadGallery(event){

			var current_gallery = jQuery( event.srcElement ).closest( 'label' );
			
			if ( event.currentTarget.id === 'clear-gallery' ) {
				//remove value from input
				current_gallery.find( '.gallery_values' ).val( '' ).trigger( 'change' );
	
				//remove preview images
				current_gallery.find( '.gallery-screenshot' ).html( '' );
				return;
			}
	
			// Make sure the media gallery API exists
			if ( typeof wp === 'undefined' || !wp.media || !wp.media.gallery ) {
				return;
			}
			event.preventDefault();
	
			// Activate the media editor
			var val = current_gallery.find( '.gallery_values' ).val();
			var final;
	
			if ( !val ) {
				final = '[gallery ids="0"]';
			} else {
				final = '[gallery ids="' + val + '"]';
			}
			var frame = wp.media.gallery.edit( final );
	
			frame.state( 'gallery-edit' ).on(
				'update', function( selection ) {
	
					//clear screenshot div so we can append new selected images
					current_gallery.find( '.gallery-screenshot' ).html( '' );

	
					var element, preview_html = '', preview_img;
					var ids = selection.models.map(
						function( e ) {
							element = e.toJSON();

							preview_img = typeof element.sizes.thumbnail !== 'undefined' ? element.sizes.thumbnail.url : element.url;
							preview_html = "<div class='screen-thumb' style='float: left;'><img src='" + preview_img + "'/></div>";
							current_gallery.find( '.gallery-screenshot' ).append( preview_html );

							return e.id;
						}
					);
	
					current_gallery.find( '.gallery_values' ).val( ids.join( ',' ) ).trigger( 'change' );
					update_wslider_meta();
				}
			);

			return false;
		
		}


		function update_wslider_meta(){
			var hash = {};
			// get all colors listed
			var colorBlocks = jQuery(".wslider-color-block").each(function(index){
				hash[jQuery(this).data("color")] = {
					images: jQuery(this).find(".gallery_values").val(),
					color: jQuery(this).find(".wslider-color-value").val()
				};
			});
			jQuery("#wslider-hash").attr("value", JSON.stringify(hash));
			console.log("hash is", hash);
		}
		update_wslider_meta();
		</script>

		<!-- <p>
			<input type="radio" name="cholesterol" value="0" <?php checked( $current_cholesterol, '0' ); ?> /> Yes<br />
			<input type="radio" name="cholesterol" value="1" <?php checked( $current_cholesterol, '1' ); ?> /> No
		</p>

		<h3><?php _e( 'Carbohydrates', 'food_example_plugin' ); ?></h3>
		<p>
			<input type="text" name="carbohydrates" value="<?php echo $current_carbohydrates; ?>" /> 
		</p>

		<h3><?php _e( 'Vitamins', 'food_example_plugin' ); ?></h3>
		<p>
		<?php
			foreach ( $vitamins as $vitamin ) {
				?>
				<input type="checkbox" name="vitamins[]" value="<?php echo $vitamin; ?>" <?php checked( ( in_array( $vitamin, $current_vitamins ) ) ? $vitamin : '', $vitamin ); ?> /><?php echo $vitamin; ?> <br />
				<?php
			}
		?>
		</p> -->
	</div>
	<?php
}

function wslider_save_meta_box_data( $post_id ){
	// verify taxonomies meta box nonce
	if ( !isset( $_POST['wslider_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['wslider_meta_box_nonce'], basename( __FILE__ ) ) ){
		return;
	}

	// return if autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
		return;
	}

	// Check the user's permissions.
	if ( ! current_user_can( 'edit_post', $post_id ) ){
		return;
	}

	// store custom fields values
	// cholesterol string
	if ( isset( $_REQUEST['cholesterol'] ) ) {
		update_post_meta( $post_id, '_food_cholesterol', sanitize_text_field( $_POST['cholesterol'] ) );
	}
	
	// store custom fields values
	// carbohydrates string
	if ( isset( $_REQUEST['carbohydrates'] ) ) {
		update_post_meta( $post_id, '_food_carbohydrates', sanitize_text_field( $_POST['carbohydrates'] ) );
	}
	
	// store custom fields values
	if( isset( $_POST['vitamins'] ) ){
		$vitamins = (array) $_POST['vitamins'];

		// sinitize array
		$vitamins = array_map( 'sanitize_text_field', $vitamins );

		// save data
		update_post_meta( $post_id, '_food_vitamins', $vitamins );
	}else{
		// delete data
		delete_post_meta( $post_id, '_food_vitamins' );
	}

	if ( isset( $_REQUEST['wslider-hash'] ) ) {
		update_post_meta( $post_id, '_wslider_hash', $_POST['wslider-hash'] );
	}


}

// Instantiate Elementor_Awesomesauce.
new WSLIDER();