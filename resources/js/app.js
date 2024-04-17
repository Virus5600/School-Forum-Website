try {
	// Setting user language
	window.lang = global.lang = (window.navigator.userLanguage || window.navigator.language);

	// jQuery 3.7
	require('./libs/jQuery');

	// Bootstrap 5.3
	require('./libs/bootstrap5');

	// Sweetalert 2
	require('./libs/swal');

	// Fontawesome 6
	require('./libs/fontawesome');

	// Toast UI - Editor
	require('./libs/toast-editor');
} catch (ex) {
	console.error(ex);
}

// Adjusts the target scrolling offset
$(() => {
	$(document).on('click', 'a[href^="#"]', (e) => {
		e.preventDefault();

		const LOCATION = $(e.currentTarget).attr('href');
		const TOP = $(LOCATION).offset().top;
		let offset = getComputedStyle(document.body).getPropertyValue('--navbar-height');

		offset = offset.replace(/[a-zA-Z]/, '');
		offset = parseInt(offset);
		offset = isNaN(offset) ? 0 : offset;

		console.log({
			"Top": TOP,
			"Offset": offset,
			"Diff": TOP - offset,
		});
		$(document).scrollTop(TOP - offset);
		history.pushState(null, null, LOCATION);
	});
});
