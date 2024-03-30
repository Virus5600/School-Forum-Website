$(() => {
	$(`#resend-verification-email`).on(`click`, (e) => {
		let btn = $(e.currentTarget);

		// Prevents the button from being clicked multiple times
		if (btn.attr('data-ver-clicked') === 'true') {
			return false;
		}

		// Disables the button
		btn.addClass(`disabled cursor-default`)
			.attr('data-ver-clicked', 'true')
			.attr('data-ver-og', `${btn.html()}`)
			.html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...`);

		let reenable = true;

		// Set the headers
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="token"]').attr('content'),
				'Authorization': `Bearer ${$("meta[name=bearer]").attr('content')}`
			}
		});

		// Send the request
		$.post($('meta[name=resend-email-url]').attr('content'), {
			_method: 'POST',
			_token: $('meta[name=token]').attr('content'),
			bearer: $("meta[name=bearer]").attr('content')
		})
		.fail((response) => {
			let status = response.status;
			let data = response.responseJSON;

			console.log(data);
			if (status === 400) {
				if (data.message['token[exists]']) {
					SwalFlash.error(
						`Account Identification Failed`,
						`Please re-login to refresh your session and try again. Redirecting you in 5 seconds...`,
						true
					);

					reenable = false;
					setTimeout(() => {
						window.location.href = $('meta[name=login-url]').attr('content');
					}, 5000);
				}
			}
		})
		.done((response) => {
			console.log(response);

		}).always(() => {
			// Enables the button if the request fails but the user is logged in.
			if (reenable)
				btn.removeClass(`disabled cursor-default`)
					.attr('data-ver-clicked', 'false')
					.html(btn.attr('data-ver-og'));
			else
				btn.html('Redirecting...');
		});
	});
});
