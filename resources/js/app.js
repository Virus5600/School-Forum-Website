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
