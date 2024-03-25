$(() => {
	$(`input[type='password']`).one(`focus`, () => {
		$(`#password-tips`).addClass('show');
	});
});
