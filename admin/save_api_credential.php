<?php

if(isset($_POST['save_api_settings'])){
    if(isset($_GET['code'])){

    $code=$_GET['code'];
    $nonce = isset($_REQUEST['nonce_verify']) ? sanitize_text_field($_REQUEST['nonce_verify']) : false;
	if (wp_verify_nonce($nonce, 'save_api_nonce')) {
        $api_key= isset($_POST['api_key'])?sanitize_text_field($_POST['api_key']):false;
        $api_secret= isset($_POST['api_secret'])?sanitize_text_field($_POST['api_secret']):false;
        $auth= base64_encode($api_key.':'.$api_secret);
        $header[]="Authorization: Basic $auth";
        $curl=curl_init();
        $link="https://api.dropboxapi.com/oauth2/token?code=$code&grant_type=authorization_code&redirect_uri=http://localhost/wordpress/wp-admin/admin.php?page=dropbox-setting";
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl,CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        $err=curl_error($curl);
        echo $err;
        if($result){
            $decodedResult=json_decode($result,true);
            update_option('api_key',$api_key,'yes');
            update_option('api_secret_key',$api_secret,'yes');
            update_option('access_token',$decodedResult['access_token'],'yes');
            update_option('api_response',json_encode($decodedResult),'yes');
            echo '<div class="notice is-dismissible notice-success">
            <p>API Credentials Saved Successfully</p>
        </div>';
        }

    }
}
}
   
    // }





?>



<h3>Enter API Setting Details</h3>
<table class="form-table woocommerce-importer-options">
    <tbody>
        <tr>
            <td>
                <form method='post' action='' name='myform' enctype='multipart/form-data'>
                    <input type="hidden" value="<?php echo esc_html(wp_create_nonce('save_api_nonce')); ?>" name="nonce_verify">
                    <label>API Key: </label>
                    <input type="text" value="" id="api_key" name="api_key" placeholder="Enter API Key">
            </td>
        </tr>
        <tr>
            <td>
                <label>API Secret: </label>
                <input type="password" value="" id="api_secret" name="api_secret" placeholder="Enter API Secret Key">
            </td>
        </tr>
        <tr>
            <td>
                <input type='submit' id="redirect_code" name='redirect_code' value='Generate'>
                <input type='submit' id='save_api_settings' name='save_api_settings' value='Save'>
            </td>
        </tr>
        </form>
    </tbody>
</table>