$(() => {
	// LOCK/UNLOCK VIEW
	const loginWrapper = $(`.login-card`);
	const lockView = $(`.login-card #lock-view`);
	const loginCard = $(`#login-form`);
	const loginCardComp = loginCard.find("*");

	lockView.on('click', (e) => {
		let obj = $(e.currentTarget);

		obj.toggleClass(`locked unlocked`)
			.trigger(`classChange`);

		if (obj.hasClass(`locked`)) {
			loginWrapper.addClass(`show`);
			loginCard.addClass(`show`);
		}
		else if (obj.hasClass(`unlocked`)) {
			loginWrapper.removeClass(`show`);
			loginCard.removeClass(`show`);
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
});
