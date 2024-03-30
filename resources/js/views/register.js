$(() => {
	$(`input[type='password']`).one(`focus`, () => {
		$(`#password-tips`)
			.css('left', '')
			.addClass('show');
	});
});
