jQuery(document).ready(function ($) {
	$('#add-row').on('click', function () {
		var row = $('.empty-row');
		row.removeClass('empty-row');
		row.css('display', 'block');
		row.insertBefore('#repeatable-fieldset-one li:last');
		return false;
	});

	$('.remove-row').on('click', function () {
		$(this).parents('li').remove();
		return false;
	});
});
