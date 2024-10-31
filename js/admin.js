document.addEventListener('DOMContentLoaded', function () {

	const tabs = document.querySelectorAll('.nav-tab');

	const tabContents = document.querySelectorAll('.tab-content');



	tabs.forEach(tab => {

		tab.addEventListener('click', function (e) {

			e.preventDefault();

			tabs.forEach(t => t.classList.remove('nav-tab-active'));

			tabContents.forEach(tc => tc.style.display = 'none');

			this.classList.add('nav-tab-active');

			const targetTab = this.getAttribute('href').replace('#', '');

			document.getElementById(targetTab).style.display = 'block';

		});

	});

});



jQuery(document).ready(function($){

	var imageUrl = $('#ninjaworkspace_popup_image').val();

    if (imageUrl) {

        $('#image-preview').html('<img src="' + imageUrl + '" alt="Selected Image" style="max-width: 65px; height: auto;">');

    }

	$('#upload-image').click(function(e) {

		e.preventDefault();

		var mediaUploader = wp.media({

			frame: 'post',

			state: 'insert',

			multiple: false

		});

		mediaUploader.on('insert', function() {

			var attachment = mediaUploader.state().get('selection').first().toJSON();

			$('#ninjaworkspace_popup_image').val(attachment.url);

			$('#image-preview').html('<img src="' + attachment.url + '" alt="Selected Image" style="max-width: 65px; height: auto;">');

		});

		mediaUploader.open();

	});

});