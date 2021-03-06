<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://cedcommerce.com/
 * @since      1.0.0
 *
 * @package    Ced_Dropbox_Image
 * @subpackage Ced_Dropbox_Image/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Ced_Dropbox_Image
 * @subpackage Ced_Dropbox_Image/public
 * @author     Cedcommerce <rajivranjanshrivastav@cedcoss.com>
 */
class Ced_Dropbox_Image_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ced_Dropbox_Image_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ced_Dropbox_Image_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ced-dropbox-image-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ced_Dropbox_Image_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ced_Dropbox_Image_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ced-dropbox-image-public.js', array( 'jquery' ), $this->version, false );

	}


	/**
	 * ced_custom_featured_image_frontend
	 *
	 * @param  mixed $html
	 * @param  mixed $attachment_id
	 * @return void
	 */
	public function ced_custom_featured_image_frontend( $html, $attachment_id)
	{
			global $post;
			if('yes'==get_post_meta($post->ID, 'ced_featured_image_setting', 1)){
				$image_url_list = get_post_meta(get_the_ID(), 'ced_dropbox_url', 1);
				$htmlTypeUrl = str_replace("dl=0", "dl=1", $image_url_list[0]);
				$featured_image = get_post_thumbnail_id( $post->ID );
				if ( $attachment_id == $featured_image ){
					$html = '<img src="'.$htmlTypeUrl.'">';
					return $html;
				}
			}
			return $html;
	}


	// public function ced_custom_featured_image_shop_page($size = 'shop_catalog' ){
	// 	global $post, $woocommerce;
	// 	if('yes'==get_post_meta($post->ID, 'ced_featured_image_setting', 1)){
	// 		$image_url_list = get_post_meta(get_the_ID(), 'ced_dropbox_url', 1);
	// 		$htmlTypeUrl = str_replace("dl=0", "dl=1", $image_url_list[0]);
    //     $output = '<div class="col-lg-4">';
    //     if ( has_post_thumbnail() ) {
    //         $output .= get_the_post_thumbnail( $post->ID, $size );
    //     } else {
    //          $output .= wc_placeholder_img( $size );
    //          $output .= '<img src="' . $htmlTypeUrl . '" alt="Placeholder" width="300px" height="300px" />';
    //     }
    //     $output .= '</div>';
	// 	return $output;
	// }
	// }


	// public function ced_custom_featured_image_shop_page_show(){
	// 	echo $this->ced_custom_featured_image_shop_page();


	// }


}
