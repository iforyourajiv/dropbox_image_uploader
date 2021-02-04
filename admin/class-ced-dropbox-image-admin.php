<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://cedcommerce.com/
 * @since      1.0.0
 *
 * @package    Ced_Dropbox_Image
 * @subpackage Ced_Dropbox_Image/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ced_Dropbox_Image
 * @subpackage Ced_Dropbox_Image/admin
 * 
 */
class Ced_Dropbox_Image_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * 
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 *
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

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

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/ced-dropbox-image-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

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

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/ced-dropbox-image-admin.js', array('jquery'), $this->version, false);
		$ajax_nonce = wp_create_nonce('verify-ajax-call');
		wp_localize_script(
			$this->plugin_name,
			'fetch_upload_file_name', //handle Name
			array(
				'ajaxurl' => admin_url('admin-ajax.php'),
				'nonce' => $ajax_nonce,
			)
		);
	}


	/**
	 * Function: ced_dropbox_setting_page
	 * Description : Creating New Menu Having a name 'DropBox Setting' For Saving a Api Key And secret key in DB
	 * Version:1.0.0
	 *
	 * @since    1.0.0
	 * @return void
	 */
	public function ced_dropbox_setting_page()
	{
		add_menu_page(
			'Dropbox Setting', // Menu Title
			'DropBox Setting', // Menu Name
			'manage_options', //Capabilities
			'dropbox-setting', //Slug
			'ced_dropbox_setting_html', // call backFunction
			'dashicons-index-card', //Icon
			30
		);

		function ced_dropbox_setting_html()
		{
			include CED_DROPBOX_DIR_PATH . '/admin/save_api_credential.php';
		}
	}

	/**
	 * Function Name :ced_custom_meta_product_image
	 * Description. Creating New Meta Box  For uploading Image to Dropbox on Product page 
	 *
	 * @since  :1.0.0
	 * Version :1.0.0
	 * @return void
	 */
	public function ced_custom_meta_product_image()
	{
		add_meta_box(
			'ced_metabox_product_image',          // Unique ID
			'Upload Image on Dropbox', // Box title
			'ced_custom_meta_product_image_html',  // Content callback, must be of type callable
			'Product', // Post type
			'side' //postiton
		);


		/**
		 * function Name :ced_custom_meta_product_image_html
		 * Description. HTML for For uploading Image to Dropbox on Product page 
		 *
		 * @since  :1.0.0
		 * Version :1.0.0
		 * @return void
		 * @param int $post Global Variable for Post.
		 * @param int $post->Id for getting individual Post Id.
		 */

		function ced_custom_meta_product_image_html()
		{
?>
			<label>Upload Image File:</label><br />
			<form method="post" action="">
				<input type="file" name="media" id="media">
				<input type="button" class="button button-primary" value="Upload Image" data-product="<?php echo get_the_ID() ?>" id="upload_btn" name="upload_btn" class="btnSubmit" />
			</form>
			<div id='image'>
				<?php
				$checked='';
				$image_url_list = get_post_meta(get_the_ID(), 'ced_dropbox_url', 1);
				if(is_array($image_url_list) && !empty($image_url_list)){
				foreach ($image_url_list as $image_url) {
					$htmlTypeUrl = str_replace("dl=0", "dl=1", $image_url);
				?>
					<img src="<?php echo $htmlTypeUrl ?>" alt="<?php echo basename($htmlTypeUrl) ?>" width="80px" height="80px">
				<?php

					$status = get_post_meta(get_the_ID(), 'ced_featured_image_setting', 1);
					$checked = '';
					if ('yes' == $status) {
						$checked = 'checked';
					} else {
						$checked = '';
					}
				}
			} else {
				echo esc_html('Image Not Found');
			}

				?>
			</div>
			<br>
			<input type="checkbox" name='setting_featured' id='setting_featured' <?php echo $checked ?>> Set First Image As Featured Image

<?php
		}
	}



	/**
	 * Function:ced_featured_image_setting
	 *
	 * @return void
	 */
	public function ced_featured_image_setting()
	{

		if (isset($_POST['setting_featured'])) {
			update_post_meta(get_the_ID(), 'ced_featured_image_setting', 'yes');
		} else {
			update_post_meta(get_the_ID(), 'ced_featured_image_setting', 'no');
		}
	}

		
	/**
	 * Function:ced_custom_meta_product_image_save
	 * Description:
	 *
	 * @since  :1.0.0
	 * Version :1.0.0
	 * @return void
	 */
	public function ced_custom_meta_product_image_save()
	{
		$id = $_POST['product_id'];
		$path = '/test/' . $_FILES['file']['name'];
		$acessToken = get_option('access_token', 1);
		$fp = fopen($_FILES['file']['tmp_name'], 'rb');
		$size = filesize($_FILES['file']['tmp_name']);
		$contentType = 'Content-Type:  application/octet-stream';
		$args = 'Dropbox-API-Arg: {"path":"' . $path . '", "mode":"add","autorename": true,"mute": false,"strict_conflict": false}';
		$headers = array(
			'Authorization: Bearer ' . $acessToken,
			$contentType, $args
		);
		$ch = curl_init('https://content.dropboxapi.com/2/files/upload');
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_PUT, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_INFILE, $fp);
		curl_setopt($ch, CURLOPT_INFILESIZE, $size);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		$error = curl_error($ch);
		if ($response) {
			$contentType = 'Content-Type:  application/json';
			$headers = array(
				'Authorization: Bearer ' . $acessToken,
				$contentType
			);
			$data = '{"path":"' . $path . '"}';
			$ch = curl_init('https://api.dropboxapi.com/2/sharing/create_shared_link_with_settings');
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			if ($response) {
				$encodedjson = json_decode($response, true);
				$check = $this->ced_add_url_to_product($encodedjson, $id);
				if ($check) {
					echo "hello";
				}
			}
		} else {
			echo $error;
		}
		curl_close($ch);
		fclose($fp);
		wp_die();
	}


	/**
	 * Function : ced_add_url_to_product
	 * @since  :1.0.0
	 * Version :1.0.0
	 * @param  mixed $data
	 * @param  mixed $id
	 * @return true;
	 */
	public function ced_add_url_to_product($data, $id)
	{
		$current_value = get_post_meta($id, 'ced_dropbox_url', 1);
		$url = $data['url'];
		if (empty($current_value) || !isset($current_value)) {
			$current_value = array($url);
			add_post_meta($id, 'ced_dropbox_url', $current_value, 1);
		} else {
			if (in_array($url, $current_value)) {
				_e("Custom Post Type Already Exist");
			} else {
				if (!empty($current_value)) {
					$current_value[] = $url;
				} else {
					$current_value = array($url);
				}
				update_post_meta($id, 'ced_dropbox_url', $current_value);
			}
		}

		return true;
	}
}
