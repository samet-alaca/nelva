jQuery(function() {
	$('[data-lang]').click(function() {
		$.post(location.origin + '/lang', { lang: $(this).data('lang') }).done(function() {
			location.reload();
		});
	});

	$('[data-toggle="tooltip"]').tooltip();

	alertify.defaults.transition = "slide";
	alertify.defaults.theme.ok = "btn btn-primary";
	alertify.defaults.theme.cancel = "btn btn-danger";
	alertify.defaults.theme.input = "form-control";
});
