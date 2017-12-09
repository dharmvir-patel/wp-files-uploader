window.onload = function() {
	var securityNonce = document.getElementById("dv_files_uploader_nonce").value;
}
// dvFilesUploader is the configuration for the element that has an id attribute
// with the value dvFilesUploader (or dvFilesUploader)
Dropzone.options.dvFilesUploader = {
	url: dv_ajax_object.ajax_url,
	//acceptedFiles: "image/*", // all image mime types
	//acceptedFiles: ".jpg", // only .jpg files
	//maxFiles: 1,
	//uploadMultiple: false,
	//maxFilesize: 5, // 5 MB
	//addRemoveLinks: true,
	//dictRemoveFile: 'X (remove)',
	init: function() {
		this.on("sending", function(file, xhr, formData) {
			// Append all the additional input data of your form here!
			formData.append("action", "dv_files_upload_action");
			//formData.append("dv_files_uploader_nonce", securityNonce);
		});
	}
};
