<?php
/**
 * WooCommerce additional settings.
 *
 * @package Motta
 */

namespace Motta\WooCommerce;

use \Motta\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class of Product Settings
 */
class Settings {
	/**
	 * Instance
	 *
	 * @var $instance
	 */
	protected static $instance = null;

	/**
	 * Initiator
	 *
	 * @since 1.0.0
	 * @return object
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Instantiate the object.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		if ( ! function_exists( 'is_woocommerce' ) ) {
			return;
		}

		// Register custom post type and custom taxonomy
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );

		// Add form
		add_action( 'product_cat_add_form_fields', array( $this, 'add_category_fields' ), 30 );
		add_action( 'product_cat_edit_form_fields', array( $this, 'edit_category_fields' ), 20 );
		add_action( 'created_term', array( $this, 'save_category_fields' ), 20, 3 );
		add_action( 'edit_term', array( $this, 'save_category_fields' ), 20, 3 );

		// Option of newness.
		add_action( 'woocommerce_product_options_advanced', array( __CLASS__, 'product_advanced_options' ) );
		add_action( 'save_post', array( __CLASS__, 'save_product_data' ) );
	}

	/**
	 * Register admin scripts
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_admin_scripts( $hook ) {
		$screen = get_current_screen();
		if ( ( $hook == 'edit-tags.php' && ( $screen->taxonomy == 'product_cat' || $screen->taxonomy == 'product_brand' || $screen->taxonomy == 'product_author' ) ) || ( $hook == 'term.php' && $screen->taxonomy == 'product_cat' ) ) {
			wp_enqueue_media();
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_script( 'motta_product_cat_js', get_template_directory_uri() . "/assets/js/backend/product-cat.js", array( 'jquery' ), '20190407', true );
			wp_enqueue_style( 'motta_product_cat_style', get_template_directory_uri() . "/assets/css/backend/product-cat.css", array(), '20161101' );
		}
	}

	/**
	 * Category thumbnail fields.
     *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function add_category_fields() {
	if( Helper::get_option( 'shop_page_header' ) == 'standard' ) : ?>
		<div class="form-field">
            <label><?php esc_html_e( 'Page Header Background', 'motta' ); ?></label>

            <div id="motta_page_header_bg" class="motta-page-header-bg">
                <ul class="motta-cat-page-header-bg"></ul>
                <input type="hidden" id="motta_page_header_bg_id" class="motta_page_header_bg_id" name="motta_page_header_bg_id"/>
                <button type="button"
                        data-delete="<?php esc_attr_e( 'Delete image', 'motta' ); ?>"
                        data-text="<?php esc_attr_e( 'Delete', 'motta' ); ?>"
                        class="upload_images_button button"><?php esc_html_e( 'Upload/Add Images', 'motta' ); ?></button>
            </div>
            <div class="clear"></div>
        </div>
		<tr class="form-field">
			<th scope="row" valign="top">
				<label for="motta_page_header_background_overlay"><?php esc_html_e( 'Background Overlay', 'motta' ); ?></label>
			</th>
			<td>
				<input type="text" value="" name="motta_page_header_background_overlay" id="motta_page_header_background_overlay" class="motta_page_header_background_overlay" data-alpha-enabled="true" />
				<label class="motta_page_header_background_overlay_opacity_label" for="motta_page_header_background_overlay"><?php esc_html_e( 'Opacity', 'motta' ); ?></label>
				<input id="motta_page_header_background_overlay_opacity" class="motta_page_header_background_overlay_opacity" name="motta_page_header_background_overlay_opacity" type="number" step="0.01" min="0" max="1">
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row" valign="top">
				<label for="motta_page_header_textcolor"><?php esc_html_e( 'Page Header Text Color', 'motta' ); ?></label>
			</th>
			<td>
				<select name="motta_page_header_textcolor" id="motta_page_header_textcolor" class="postform">
					<option value=""><?php esc_html_e( 'Default', 'motta' ) ?></option>
					<option value="dark"><?php esc_html_e( 'Dark', 'motta' ) ?></option>
					<option value="light"><?php esc_html_e( 'Light', 'motta' ) ?></option>
					<option value="custom"><?php esc_html_e( 'Custom', 'motta' ) ?></option>
				</select>
			</td>
		</tr>
		<tr class="form-field form-field-hidden">
			<th scope="row" valign="top">
				<label for="motta_page_header_textcolor_custom"><?php esc_html_e( 'Color', 'motta' ); ?></label>
			</th>
			<td>
				<input type="text" value="" name="motta_page_header_textcolor_custom" id="motta_page_header_textcolor_custom" class="motta_page_header_textcolor_custom" />
			</td>
		</tr>
	<?php endif;
	if( Helper::get_option( 'shop_header' ) ) : ?>
		<tr class="form-field">
			<th scope="row" valign="top">
				<label for="motta_shop_header_template"><?php esc_html_e( 'Category Header', 'motta' ); ?></label>
			</th>
			<td>
				<select name="motta_shop_header_template" id="motta_shop_header_template">
					<?php $args = Helper::customizer_get_posts( array( 'post_type' => 'elementor_library' )) ;
					foreach ( $args as $key => $value) {
						echo '<option value="' . $key . '">' . $value . '</option>';}
					?>
				</select>
			</td>
		</tr>

	<?php endif;
	}

	/**
	 * Edit category thumbnail field.
	 *
	 * @since 1.0.0
	 *
	 * @param mixed $term Term (category) being edited
     *
	 * @return void
	 */
	public function edit_category_fields( $term ) {
		$page_header_bg_id                            = get_term_meta( $term->term_id, 'motta_page_header_bg_id', true );
		$motta_page_header_background_overlay         = get_term_meta( $term->term_id, 'motta_page_header_background_overlay', true);
		$motta_page_header_background_overlay_opacity = get_term_meta( $term->term_id, 'motta_page_header_background_overlay_opacity', true);
		$text_color                                   = get_term_meta( $term->term_id, 'motta_page_header_textcolor', true );
		$text_color_custom                            = get_term_meta( $term->term_id, 'motta_page_header_textcolor_custom', true);
		$template_page                                = get_term_meta( $term->term_id, 'motta_shop_header_template', true);

		if( Helper::get_option( 'shop_page_header' ) == 'standard' ) : ?>
			<tr class="form-field">
				<th scope="row" valign="top"><label><?php esc_html_e( 'Page Header Background', 'motta' ); ?></label></th>
				<td>
					<div id="motta_page_header_bg" class="motta-page-header-bg">
						<ul class="motta-cat-page-header-bg">
							<?php

							if ( $page_header_bg_id ) {
								$image = wp_get_attachment_image_url( $page_header_bg_id, 'full' );
								?>
								<li class="image" data-attachment_id="<?php echo esc_attr( $page_header_bg_id ); ?>">
									<img alt="<?php echo esc_attr__( 'Page Header Image', 'motta' ); ?>" src="<?php echo esc_url( $image ); ?>" width="auto" height="100px"/>
									<ul class="actions">
										<li>
											<a href="#" class="delete"
												title="<?php esc_attr_e( 'Delete image', 'motta' ); ?>"><?php esc_html_e( 'Delete', 'motta' ); ?></a>
										</li>
									</ul>
								</li>
								<?php
							}
							?>
						</ul>
						<input type="hidden" id="motta_page_header_bg_id" class="motta_page_header_bg_id" name="motta_page_header_bg_id"
							value="<?php echo esc_attr( $page_header_bg_id ); ?>"/>
						<button type="button"
								data-delete="<?php esc_attr_e( 'Delete image', 'motta' ); ?>"
								data-text="<?php esc_attr_e( 'Delete', 'motta' ); ?>"
								class="upload_images_button button"><?php esc_html_e( 'Upload/Add Images', 'motta' ); ?></button>
					</div>
					<div class="clear"></div>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="motta_page_header_background_overlay"><?php esc_html_e( 'Background Overlay', 'motta' ); ?></label>
				</th>
				<td>
					<input type="text" value="<?php echo esc_attr( $motta_page_header_background_overlay ); ?>" name="motta_page_header_background_overlay" id="motta_page_header_background_overlay" class="motta_page_header_background_overlay" data-alpha-enabled="true" />
					<label class="motta_page_header_background_overlay_opacity_label" for="motta_page_header_background_overlay"><?php esc_html_e( 'Opacity', 'motta' ); ?></label>
					<input value="<?php echo esc_attr( $motta_page_header_background_overlay_opacity ); ?>" id="motta_page_header_background_overlay_opacity" class="motta_page_header_background_overlay_opacity" name="motta_page_header_background_overlay_opacity" type="number" step="0.01" min="0" max="1">
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="motta_page_header_textcolor"><?php esc_html_e( 'Page Header Text Color', 'motta' ); ?></label>
				</th>
				<td>
					<select name="motta_page_header_textcolor" id="motta_page_header_textcolor" class="postform">
						<option value=""><?php esc_html_e( 'Default', 'motta' ) ?></option>
						<option value="dark" <?php selected( 'dark', $text_color ) ?>><?php esc_html_e( 'Dark', 'motta' ) ?></option>
						<option value="light" <?php selected( 'light', $text_color ) ?>><?php esc_html_e( 'Light', 'motta' ) ?></option>
						<option value="custom" <?php selected( 'custom', $text_color ) ?>><?php esc_html_e( 'Custom', 'motta' ) ?></option>
					</select>
				</td>
			</tr>
			<tr class="form-field form-field-hidden">
				<th scope="row" valign="top">
					<label for="motta_page_header_textcolor_custom"><?php esc_html_e( 'Color', 'motta' ); ?></label>
				</th>
				<td>
					<input type="text" value="<?php echo esc_attr( $text_color_custom ); ?>" name="motta_page_header_textcolor_custom" id="motta_page_header_textcolor_custom" class="motta_page_header_textcolor_custom" />
				</td>
			</tr>
		<?php endif;
		if( Helper::get_option( 'shop_header' ) ) : ?>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="motta_shop_header_template"><?php esc_html_e( 'Category Header', 'motta' ); ?></label>
				</th>
				<td>
					<select name="motta_shop_header_template" id="motta_shop_header_template">
						<?php $args = Helper::customizer_get_posts( array( 'post_type' => 'elementor_library' )) ;
						foreach ( $args as $key => $value) {
							echo '<option value="' . $key . '" ' .  selected(  $key, $template_page ) . '>' . $value . '</option>'; }
						?>
					</select>
				</td>
			</tr>
		<?php endif;
	}

	/**
	 * Save Category fields
	 *
	 * @param mixed $term_id Term ID being saved
	 * @param mixed $tt_id
	 * @param string $taxonomy
     *
	 * @return void
	 */
	public function save_category_fields( $term_id, $tt_id = '', $taxonomy = '' ) {
		if ( 'product_cat' === $taxonomy && function_exists( 'update_term_meta' ) ) {
			if ( isset( $_POST['motta_page_header_bg_id'] ) ) {
				update_term_meta( $term_id, 'motta_page_header_bg_id', $_POST['motta_page_header_bg_id'] );
			}

			if ( isset( $_POST['motta_page_header_background_overlay'] ) ) {
				update_term_meta( $term_id, 'motta_page_header_background_overlay', $_POST['motta_page_header_background_overlay'] );
			}

			if ( isset( $_POST['motta_page_header_background_overlay_opacity'] ) ) {
				update_term_meta( $term_id, 'motta_page_header_background_overlay_opacity', $_POST['motta_page_header_background_overlay_opacity'] );
			}

			if ( isset( $_POST['motta_page_header_textcolor'] ) ) {
				update_term_meta( $term_id, 'motta_page_header_textcolor', $_POST['motta_page_header_textcolor'] );
			}

			if ( isset( $_POST['motta_page_header_textcolor_custom'] ) ) {
				update_term_meta( $term_id, 'motta_page_header_textcolor_custom', $_POST['motta_page_header_textcolor_custom'] );
			}

			if ( isset( $_POST['motta_shop_header_template'] ) ) {
				update_term_meta( $term_id, 'motta_shop_header_template', $_POST['motta_shop_header_template'] );
			}
		}
	}

	/**
	 * Add more options to advanced tab.
	 */
	public static function product_advanced_options() {
		echo '<div class="options_group">';
		woocommerce_wp_checkbox( array(
			'id'          => '_is_new',
			'label'       => esc_html__( 'New product?', 'motta' ),
			'description' => esc_html__( 'Enable to set this product as a new product. A "New" badge will be added to this product.', 'motta' ),
		) );
		echo '</div>';

		echo '<div class="options_group">';
		$post_custom = get_post_custom( get_the_ID());

		woocommerce_wp_text_input(
			array(
				'id'       => 'custom_badges_text',
				'label'    => esc_html__( 'Custom Badge Text', 'motta' ),
				'desc_tip'    => true,
				'description' => esc_html__( 'Enter this optional to show your badges.', 'motta' ),
			)
		);

		$bg_color = ( isset( $post_custom['custom_badges_bg'][0] ) ) ? $post_custom['custom_badges_bg'][0] : '';
		woocommerce_wp_text_input(
			array(
				'id'       => 'custom_badges_bg',
				'label'    => esc_html__( 'Custom Badge Background', 'motta' ),
				'description' => esc_html__( 'Pick background color for your badge', 'motta' ),
				'value'    => $bg_color,
			)
		);

		$color = ( isset( $post_custom['custom_badges_color'][0] ) ) ? $post_custom['custom_badges_color'][0] : '';
		woocommerce_wp_text_input(
			array(
				'id'       => 'custom_badges_color',
				'label'    => esc_html__( 'Custom Badge Color', 'motta' ),
				'description' => esc_html__( 'Pick color for your badge', 'motta' ),
				'value'    => $color,
			)
		);
		echo '</div>';
	}

	/**
	 * Save product data.
	 *
	 * @param int $post_id The post ID.
	 */
	public static function save_product_data( $post_id ) {
		if ( 'product' !== get_post_type( $post_id ) ) {
			return;
		}

		if ( ! isset( $_POST['_is_new'] ) ) {
			delete_post_meta( $post_id, '_is_new' );
		} else {
			update_post_meta( $post_id, '_is_new', 'yes' );
		}

		if ( isset( $_POST['custom_badges_text'] ) ) {
			$woo_data = $_POST['custom_badges_text'];
			update_post_meta( $post_id, 'custom_badges_text', $woo_data );
		}

		if ( isset( $_POST['custom_badges_bg'] ) ) {
			$woo_data = $_POST['custom_badges_bg'];
			update_post_meta( $post_id, 'custom_badges_bg', $woo_data );
		}

		if ( isset( $_POST['custom_badges_color'] ) ) {
			$woo_data = $_POST['custom_badges_color'];
			update_post_meta( $post_id, 'custom_badges_color', $woo_data );
		}
	}
}
