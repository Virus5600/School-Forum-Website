$(() => {
	// PASSWORD
	$(document).on('click', '#toggle-show-password, .toggle-show-password', (e) => {
		let obj = $(e.currentTarget);
		let target = $(obj.attr('data-target'));
		let icons = {
			show: obj.find('#show, .show'),
			hide: obj.find('#hide, .hide'),
		}

		if (target.attr('type') == 'password') {
			obj.attr('aria-label', 'Hide Password');
			target.attr('type', 'text');
			icons.show.removeClass('d-none');
			icons.hide.addClass('d-none');
		}
		else {
			obj.attr('aria-label', 'Show Password');
			target.attr('type', 'password');
			icons.show.addClass('d-none');
			icons.hide.removeClass('d-none');
		}
	});

	// FORGOT PASSWORD
	$('#forgotPassword').on('click', (e) => {
		let obj = $(e.currentTarget);
		let input = $('[name=email]');

		if (input.val().trim().length > 0) {
			let emailQuery = typeof input === 'undefined' ? `` : `?e=${input.val()}`;

			obj.attr('href', `${obj.attr('href')}${emailQuery}`);
		}
	});

	// FORGOT PASSWORD REDIRECT
	$(`#redirectToForgotPassword`).on(`click`, (e) => {
		e.preventDefault();
		e.stopPropagation();
		e.stopImmediatePropagation();

		window.location.href = `${$(e.currentTarget).attr(`href`)}?username=${$(`#username`).val()}`;
	});

	// REGISTER REDIRECT
	$(`#redirectToRegister`).on(`click`, (e) => {
		e.preventDefault();
		e.stopPropagation();
		e.stopImmediatePropagation();

		window.location.href = `${$(e.currentTarget).attr(`href`)}?username=${$(`#username`).val()}`;
	});
});
