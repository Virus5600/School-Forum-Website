$(() => {
	const loginWrapper = $(`.auth-card`);
	const lockView = $(`#lock-view`);
	const loginCard = $(`#content`);
	const loginCardComp = loginCard.find("*");

	// BLUR CONTROLLER
	if (window.noBlur === undefined) {
		window.noBlur = false;
	}

	if (!window.noBlur) {
		const leftHemi = $(`#left-hemisphere`);
		const rightHemi = $(`#right-hemisphere`);
		loginCard.on(`mouseover focus`, () => {
			if (!loginCard.hasClass(`show`))
				leftHemi.removeClass(`unblur`);
		}).on(`mouseleave blur`, () => {
			if (!loginCard.hasClass(`show`))
				leftHemi.addClass(`unblur`);
		});

		loginCardComp.on(`focus`, () => {
			loginWrapper.addClass(`show`);
			loginCard.addClass(`show`);
		}).on(`blur`, () => {
			if (!lockView.hasClass(`locked`)) {
				loginWrapper.removeClass(`show`);
				loginCard.removeClass(`show`);
			}
		});

		leftHemi.on(`click`, () => {
			if (!loginCard.hasClass(`show`))
				leftHemi.addClass(`unblur`);
		});

		rightHemi.on(`click`, () => {
			if (!loginCard.hasClass(`show`))
				leftHemi.addClass(`unblur`);
		});

		lockView.on(`classChange`, (e) => {
			// Container of the lock/unlock icon buttons
			let obj = $(e.currentTarget);

			if (obj.hasClass(`locked`)) {
				leftHemi.removeClass(`unblur`);

				let icon = obj.find(`.fa-lock-open`);
				bootstrap.Tooltip.getInstance(icon[0])
					.hide();
			}
			else if (obj.hasClass(`unlocked`)) {
				leftHemi.addClass(`unblur`);

				let icon = obj.find(`.fa-lock`);
				bootstrap.Tooltip.getInstance(icon[0])
					.hide();
			}
		});

		// RETAIN FOCUS ON CARD IF INPUT HAS VALUE
		if (![true, false, 'true', 'false'].includes(window.isDirty))
			window.isDirty = false;

		var isDirty = global.isDirty;
		$(`#content input`).on('keyup', (e) => {
			if (!isDirty) {
				let len = $(e.currentTarget).val().trim().length;

				if (isDirty || len > 0) {
					isDirty = true;
					$(`#lock-view`)[0].click();
				}
			}
		});
	}
});
