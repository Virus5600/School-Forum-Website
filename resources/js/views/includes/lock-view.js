$(() => {
	// TOOLTIP
	$(`[data-bs-toggle="tooltip"]`).map((k, v) =>
		new bootstrap.Tooltip(v)
	);

	// LOCK/UNLOCK VIEW
	const loginWrapper = $(`#content`);
	const lockView = $(`#lock-view`);
	const loginCard = $(`#form, #content`);

	lockView.on('click', (e) => {
		e.preventDefault();
		e.stopPropagation();
		e.stopImmediatePropagation();

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
});
