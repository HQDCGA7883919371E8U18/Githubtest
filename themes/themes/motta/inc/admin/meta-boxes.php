<?php
/**
 * Meta boxes functions
 *
 * @package Motta
 */

namespace Motta\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Meta boxes initial
 *
 */
class Meta_Boxes {
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
		add_action( 'admin_enqueue_scripts', array( $this, 'meta_box_scripts' ) );
		add_filter( 'rwmb_meta_boxes', array( $this, 'register_meta_boxes' ) );

		add_action( 'admin_notices', array( $this, 'admin_notices' ) );

		add_action( 'switch_theme', array( $this, 'update_dismissed_notice' ) );

		add_action( 'admin_head', array( $this, 'dismissed_notice' ) );
	}

	/**
	 * Enqueue scripts
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function meta_box_scripts( $hook ) {
		if ( in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {
			wp_enqueue_script( 'motta-meta-boxes', get_template_directory_uri() . '/assets/js/backend/meta-boxes.js', array( 'jquery' ), '20201012', true );
			wp_enqueue_style( 'motta-meta-boxes-style', get_template_directory_uri() . '/assets/css/backend/meta-boxes.css' );
		}
	}


	/**
	 * Registering meta boxes
	 *
	 * @since 1.0.0
	 *
	 * Using Meta Box plugin: http://www.deluxeblogtips.com/meta-box/
	 *
	 * @see http://www.deluxeblogtips.com/meta-box/docs/define-meta-boxes
	 *
	 * @param array $meta_boxes Default meta boxes. By default, there are no meta boxes.
	 *
	 * @return array All registered meta boxes
	 */
	public function register_meta_boxes( $meta_boxes ) {
		// Header
		$meta_boxes[] = $this->register_display_settings();

		// Single Blog
		$meta_boxes[] = $this->register_single_blog_settings();

		// Single Product
		$meta_boxes[] = $this->register_single_product_360_settings();
		$meta_boxes[] = $this->register_single_product_video_settings();

		return $meta_boxes;
	}

	/**
	 * Register header settings
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function register_display_settings() {
		if( isset($_GET['post']) && $_GET['post'] == get_option('page_for_posts') ) {
			return;
		}

		if( isset($_GET['post']) && $_GET['post'] == get_option('woocommerce_shop_page_id') ) {
			return;
		}

		if( isset($_GET['post']) && \Motta\Helper::is_help_center_page(intval($_GET['post'])) ) {
			return;
		}
		return array(
			'id'       => 'display-settings',
			'title'    => esc_html__( 'Display Settings', 'motta' ),
			'pages'    => array( 'page' ),
			'context'  => 'normal',
			'priority' => 'high',
			'fields'   => array(
				array(
					'name' => esc_html__( 'Header', 'motta' ),
					'id'   => 'heading_site_header',
					'class' => 'header-heading',
					'type' => 'heading',
				),
				array(
					'name' => esc_html__( 'Hide Header Section', 'motta' ),
					'id'   => 'motta_hide_header_section',
					'type' => 'select',
					'type' => 'checkbox',
					'std'  => false,
				),
				array(
					'name'    => esc_html__( 'Header Section', 'motta' ),
					'id'      => 'header_layout',
					'type'    => 'select',
					'options' => array(
						''    => esc_html__( 'Default Header Global', 'motta' ),
						'page'    => esc_html__( 'Default Header Page', 'motta' ),
						'v1'  => esc_html__( 'Header V1', 'motta' ),
						'v2'  => esc_html__( 'Header V2', 'motta' ),
						'v3'  => esc_html__( 'Header V3', 'motta' ),
						'v4'  => esc_html__( 'Header V4', 'motta' ),
						'v5'  => esc_html__( 'Header V5', 'motta' ),
						'v6'  => esc_html__( 'Header V6', 'motta' ),
						'v7'  => esc_html__( 'Header V7', 'motta' ),
						'v8'  => esc_html__( 'Header V8', 'motta' ),
						'v9'  => esc_html__( 'Header V9', 'motta' ),
						'v10'  => esc_html__( 'Header V10', 'motta' ),
						'v11' => esc_html__( 'Header V11', 'motta' ),
						'v12' => esc_html__( 'Header V12', 'motta' ),
					),
				),
				array(
					'name' => esc_html__( 'Hide Topbar', 'motta' ),
					'id'   => 'motta_hide_topbar',
					'class'   => 'default-header-page',
					'type' => 'select',
					'type' => 'checkbox',
					'std'  => false,
				),
				array(
					'name' => esc_html__( 'Hide Campain Bar', 'motta' ),
					'id'   => 'motta_hide_campain_bar',
					'class'   => 'default-header-page',
					'type' => 'select',
					'type' => 'checkbox',
					'std'  => false,
				),
				array(
					'name' => esc_html__( 'Hide Border Bottom', 'motta' ),
					'id'   => 'motta_hide_header_border',
					'type' => 'select',
					'type' => 'checkbox',
					'std'  => false,
				),
				array(
					'name'    => esc_html__( 'Primary Menu', 'motta' ),
					'id'      => 'page_primary_menu',
					'class'   => 'default-header-page',
					'type'    => 'select',
					'options' => $this->get_menus(),
				),
				array(
					'name'    => esc_html__( 'Header Background', 'motta' ),
					'id'      => 'motta_header_background',
					'class'   => 'header-background-color hidden',
					'type'    => 'select',
					'options' => array(
						''     => esc_html__( 'Default', 'motta' ),
						'transparent' => esc_html__( 'Transparent', 'motta' ),
						'no-transparent' => esc_html__( 'No Transparent', 'motta' ),
					),
				),
				array(
					'name'    => esc_html__( 'Header Text Color', 'motta' ),
					'id'      => 'motta_header_text_color',
					'class'   => 'header-text-color hidden',
					'type'    => 'select',
					'options' => array(
						'' => esc_html__( 'Default', 'motta' ),
						'light'   => esc_html__( 'Light', 'motta' ),
						'dark'   => esc_html__( 'Dark', 'motta' ),
					),
				),
				array(
					'name'    => esc_html__( 'Category Menu Display', 'motta' ),
					'id'      => 'header_category_menu_display',
					'type'    => 'select',
					'options' => array(
						'default'    => esc_html__( 'On Click', 'motta' ),
						'onpageload' => esc_html__( 'On Page Load', 'motta' ),
					),
				),
				array(
					'name'    => esc_html__( 'Logo Type', 'motta' ),
					'id'      => 'header_logo_type',
					'type'    => 'select',
					'options' => array(
						'' => esc_html__( 'Default', 'motta' ),
						'image' => esc_html__( 'Image', 'motta' ),
						'text'  => esc_html__( 'Text', 'motta' ),
						'svg'   => esc_html__( 'SVG', 'motta' ),
					),
				),
				array(
					'name' 				=> esc_html__( 'Logo Image', 'motta' ),
					'id'   				=> 'header_logo_image',
					'class' 			=> 'header-logo-image  hidden',
					'type' 				=> 'image_advanced',
					'force_delete'     	=> false,
					'max_file_uploads' 	=> 1,
					'max_status'       	=> false,
					'image_size'       	=> 'thumbnail',
				),
				array(
					'name' 				=> esc_html__( 'Logo Image Light', 'motta' ),
					'id'   				=> 'header_logo_image_light',
					'class' 			=> 'header-logo-image hidden',
					'type' 				=> 'image_advanced',
					'force_delete'     	=> false,
					'max_file_uploads' 	=> 1,
					'max_status'       	=> false,
					'image_size'       	=> 'thumbnail',
					'desc' => esc_html__('This logo is used for the header transparent with text light', 'motta')
				),
				array(
					'name'  			=> esc_html__( 'Logo Text', 'motta' ),
					'id'    			=> 'header_logo_text',
					'class' 			=> 'header-logo-text hidden',
					'type'  			=> 'text',
				),
				array(
					'name'  			=> esc_html__( 'Logo SVG', 'motta' ),
					'id'    			=> 'header_logo_svg',
					'class' 			=> 'header-logo-svg hidden',
					'type'  			=> 'textarea',
					'sanitize_callback' => 'Motta\Icon::sanitize_svg',
				),
				array(
					'name'  			=> esc_html__( 'Logo SVG Light', 'motta' ),
					'id'    			=> 'header_logo_svg_light',
					'class' 			=> 'header-logo-svg  hidden',
					'type'  			=> 'textarea',
					'sanitize_callback' => 'Motta\Icon::sanitize_svg',
					'desc' => esc_html__('This logo is used for the header transparent with text light', 'motta')
				),
				array(
					'name' 				=> esc_html__( 'Logo Width', 'motta' ),
					'id'         		=> 'header_logo_width',
					'class'      		=> 'header-logo-width hidden',
					'type'       		=> 'slider',
					'suffix'     		=> esc_html__( ' px', 'motta' ),
					'js_options' 		=> array(
								'min' => 0,
								'max' => 500,
					),
				),
				array(
					'name' 				=> esc_html__( 'Logo Height', 'motta' ),
					'id'         		=> 'header_logo_height',
					'class'      		=> 'header-logo-height hidden',
					'type'       		=> 'slider',
					'suffix'     		=> esc_html__( ' px', 'motta' ),
					'js_options' 		=> array(
								'min' => 0,
								'max' => 200,
					),
				),
				array(
					'name' => esc_html__( 'Page Header', 'motta' ),
					'id'   => 'heading_site_page_header',
					'class' => 'page-header-heading',
					'type' => 'heading',
				),
				array(
					'name' => esc_html__( 'Hide Page Header', 'motta' ),
					'id'   => 'motta_hide_page_header',
					'type' => 'checkbox',
					'std'  => false,
				),
				array(
					'name'  => esc_html__( 'Hide Title', 'motta' ),
					'id'    => 'motta_hide_title',
					'type'  => 'checkbox',
					'std'   => false,
					'class' => 'page-header-hide-title',
				),
				array(
					'name'  => esc_html__( 'Hide Breadcrumb', 'motta' ),
					'id'    => 'motta_hide_breadcrumb',
					'type'  => 'checkbox',
					'std'   => false,
					'class' => 'page-header-hide-breadcrumb',
				),
				array(
					'name' => esc_html__( 'Content', 'motta' ),
					'id'   => 'heading_content',
					'class' => 'content-heading',
					'type' => 'heading',
				),
				array(
					'name'    => esc_html__( 'Content Top Spacing', 'motta' ),
					'id'      => 'motta_content_top_spacing',
					'type'    => 'select',
					'options' => array(
						'default' => esc_html__( 'Default', 'motta' ),
						'no'      => esc_html__( 'No spacing', 'motta' ),
						'custom'  => esc_html__( 'Custom', 'motta' ),
					),
				),
				array(
					'name'       => '&nbsp;',
					'id'         => 'motta_content_top_padding',
					'class'      => 'custom-spacing hidden',
					'type'       => 'slider',
					'suffix'     => esc_html__( ' px', 'motta' ),
					'js_options' => array(
						'min' => 0,
						'max' => 300,
					),
					'std'        => '63',
				),
				array(
					'name'    => esc_html__( 'Content Bottom Spacing', 'motta' ),
					'id'      => 'motta_content_bottom_spacing',
					'type'    => 'select',
					'options' => array(
						'default' => esc_html__( 'Default', 'motta' ),
						'no'      => esc_html__( 'No spacing', 'motta' ),
						'custom'  => esc_html__( 'Custom', 'motta' ),
					),
				),
				array(
					'name'       => '&nbsp;',
					'id'         => 'motta_content_bottom_padding',
					'class'      => 'custom-spacing hidden',
					'type'       => 'slider',
					'suffix'     => esc_html__( ' px', 'motta' ),
					'js_options' => array(
						'min' => 0,
						'max' => 300,
					),
					'std'        => '63',
				),
				array(
					'name' => esc_html__( 'Footer', 'motta' ),
					'id'   => 'heading_site_footer',
					'class' => 'footer-heading',
					'type' => 'heading',
				),
				array(
					'name' => esc_html__( 'Hide Footer Section', 'motta' ),
					'id'   => 'motta_hide_footer_section',
					'type' => 'select',
					'type' => 'checkbox',
					'std'  => false,
				),
				array(
					'name'    => esc_html__( 'Footer Layout', 'motta' ),
					'id'      => 'footer_layout',
					'type'    => 'select',
					'options' => \Motta\Helper::customizer_get_posts( array( 'post_type' => 'motta_footer', 'source' => 'page' ) ),
				),
				array(
					'name'    => esc_html__( 'Mobile Footer Layout', 'motta' ),
					'id'      => 'footer_mobile_layout',
					'type'    => 'select',
					'options' => \Motta\Helper::customizer_get_posts( array( 'post_type' => 'motta_footer', 'source' => 'page' ) ),
				),
				array(
					'name' => esc_html__( 'Navigation Bar', 'motta' ),
					'id'   => 'heading_site_navigation_bar',
					'class' => 'navigation-bar-heading',
					'type' => 'heading',
				),
				array(
					'name' => esc_html__( 'Hide Navigation Bar', 'motta' ),
					'id'   => 'motta_hide_navigation_bar',
					'type' => 'select',
					'type' => 'checkbox',
					'std'  => false,
				),
			),
		);
	}

	/**
	 * Register single blog settings
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function register_single_blog_settings() {
		return array(
			'id'       => 'post-format-settings',
			'title'    => esc_html__( 'Format Details', 'motta' ),
			'pages'    => array( 'post' ),
			'context'  => 'side',
			'priority' => 'high',
			'autosave' => true,
			'fields'   => array(
				array(
					'name'             => esc_html__( 'Image', 'motta' ),
					'id'               => 'image',
					'type'             => 'image_advanced',
					'class'            => 'image',
					'max_file_uploads' => 1,
				),
				array(
					'name'  => esc_html__( 'Gallery', 'motta' ),
					'id'    => 'images',
					'type'  => 'image_advanced',
					'class' => 'gallery',
				),
				array(
					'name'  => esc_html__( 'Video', 'motta' ),
					'id'    => 'video',
					'type'  => 'textarea',
					'class' => 'video',
				),
			),
		);
	}

	/**
	 * Register single product 360 settings
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function register_single_product_360_settings() {
		return array(
			'id'       => 'product-360-view',
			'title'    => esc_html__( 'Product 360 View', 'motta' ),
			'pages'    => array( 'product' ),
			'context'  => 'side',
			'priority' => 'low',
			'fields'   => array(
				array(
					'id'   => 'product_360_view',
					'type' => 'image_advanced',
				),
			),
		);
	}

	/**
	 * Register single product video settings
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function register_single_product_video_settings() {
		return array(
			'id'       => 'product-videos',
			'title'    => esc_html__( 'Product Video', 'motta' ),
			'pages'    => array( 'product' ),
			'context'  => 'side',
			'priority' => 'low',
			'fields'   => array(
				array(
					'id'   => 'video_url',
					'type' => 'oembed',
					'desc' => esc_html__( 'Enter URL of Youtube or Vimeo or specific filetypes such as mp4, webm, ogv.', 'motta' ),
				),
			),
		);
	}


		/**
	 * Get nav menus
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_menus() {
		if ( ! is_admin() ) {
			return [];
		}

		$menus = wp_get_nav_menus();
		if ( ! $menus ) {
			return [];
		}

		$output = array(
			0 => esc_html__( 'Select Menu', 'motta' ),
		);
		foreach ( $menus as $menu ) {
			$output[ $menu->slug ] = $menu->name;
		}

		return $output;
	}

	public function admin_notices() {
		if ( get_user_meta( get_current_user_id(), 'motta_support_dismissed_notice', true ) ) {
			return;
		}
		?>
		<div class="notice notice-info is-dismissible">
			<p>
				<strong><?php esc_html_e( 'Thank you for purchasing Motta theme!  First, check our handy Documentation for solutions.  Still stuck? Open a support ticket and our team will assist you promptly.', 'motta' ); ?></strong>
			</p>
			<p>
				<strong>
					<a href="https://docs.uix.store/motta/#/" target="_blank"><?php esc_html_e('Documentation', 'motta'); ?></a> |
					<a href="https://uix.ticksy.com/" target="_blank"><?php esc_html_e('Support Ticket', 'motta'); ?></a> |
					<a href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'motta-suport-dismiss', 'dismiss_admin_notices' ), 'motta-suport-dismiss-' . get_current_user_id() ) ) ?>" class="dismiss-notice" target="_parent"><?php esc_html_e('Dismiss this notice', 'motta'); ?></a>
				</strong>
			</p>
		</div>
		<?php
	}

	public function update_dismissed_notice() {
		delete_metadata( 'user', null, 'motta_support_dismissed_notice', null, true );
	}

	public function dismissed_notice() {
		if ( isset( $_GET['motta-suport-dismiss'] ) && check_admin_referer( 'motta-suport-dismiss-' . get_current_user_id() ) ) {
			update_user_meta( get_current_user_id(), 'motta_support_dismissed_notice', 1 );
		}
	}
}
