(function ($) {
  "use strict";

  //Getting Dropdown value to Show Wp_list Table according to File Type
  $(document).ready(function () {
    $("#redirect_code").click(function (e) {
      e.preventDefault();
      let api_key = $("#api_key").val();
      let redirect_uri =
        "http://localhost/wordpress/wp-admin/admin.php?page=dropbox-setting";
      let url =
        "https://www.dropbox.com/oauth2/authorize?client_id=" +
        api_key +
        "&redirect_uri=" +
        redirect_uri +
        "&response_type=code";
      window.location.href = url;
    });

    $(document).on("click", "#upload_btn", function () {
		var id = $(this).attr("data-product");
		var fd = new FormData();
		var file_data = $('#media').prop('files')[0];
		fd.append('file',file_data);
		fd.append('action','ced_fetch_upload_file');
		fd.append('product_id',id);
      $.ajax({
		url: fetch_upload_file_name.ajaxurl,
		type: "POST",
		cache: false,
		contentType: false,
		processData: false,
        data:fd,
		processData: false,
        contentType: false,
        success: function (response) {
			console.log(response);

		},
      });
  });

  $(document).on("change","#setting_featured",function(){
    var id;
    var postid = $('#upload_btn').attr("data-product");
    if ($(this).is(":checked")) {
     id="checkedIN";
  } else {
     id="checkedOUT";
  }
  $.ajax({
		url: fetch_upload_file_name.ajaxurl,
		type: "POST",
		data:{
      action:'make_setting_featured_image',
      nonce: fetch_upload_file_name.nonce,
      status:id,
      postid:postid,
    },
      success: function (response) {
			console.log(response);

		},
    });

  })

})
})(jQuery)
