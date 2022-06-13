jQuery(document).ready(function () {

	jQuery(function ($) {

		// Product Image Btn
		$('.upload_image_button').click(function (event) {

			event.preventDefault();

			const button = $(this);

			const customUploader = wp.media({
				title: 'Выберите изображение',
				library: {
					type: 'image'
				},
				button: {
					text: 'Выбрать изображение'
				},
				multiple: false
			});

			customUploader.on('select', function () {

				const image = customUploader.state().get('selection').first().toJSON();

				button.parent().prev().attr('src', image.url);
				button.prev().val(image.id);

			});

			customUploader.open();
		});

		$('.remove_image_button').click(function (event) {

			event.preventDefault();

			const src = $(this).parent().prev().data('src');
			$(this).parent().prev().attr('src', src);
			$(this).prev().prev().val('');
		});


		// Product Reset Fields Btn
		$('#product-reset-btn').click(function (event) {

			event.preventDefault();

			if (true == confirm("Уверены?")) {

				const src = $('.remove_image_button').parent().prev().data('src');
				$('.remove_image_button').parent().prev().attr('src', src);
				$('.remove_image_button').prev().prev().val('');

				$('#product_date').val('');

				$("#product-select").val('');
			}
		});

	});


	// Datepicker
	jQuery('#product_date').datepicker({
		dateFormat: 'd M, y'
	});
});