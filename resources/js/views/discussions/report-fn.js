$(() => {
	const UID = parseInt($(`meta[name='uid']`).attr('content') ?? 0);

	/**
	 * Sends an API request to the server through an XHR request using jQuery AJAX.
	 *
	 * @param {int} id				ID of the affected item.
	 * @param {int} userID			ID of the user who did the action.
	 * @param {string} route		URL of the API for the said action.
	 * @param {string} reason		Reason for the report.
	 *
	 * @return {Promise}
	 */
	const sendAPIReq = async (id, userID, route, reason) => {
		const token = $('meta[name="token"]').attr('content'),
			bearer = $("meta[name=bearer]").attr('content');

		// AJAX Headers Setup
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': token,
				'Authorization': `Bearer ${bearer}`
			}
		});

		const payload = {
			_method: "POST",
			_token: token,
			bearer: bearer,
			id: id,
			userID: userID,
			reason: reason
		};

		// Sends the POST request
		return $.post(route, payload);
	};

	const responseHandler = (response) => {
		const { message, status } = response;

		// If the response is successful
		if (status === 200) {
			SwalFlash.success(`Success`, message);
		} else {
			SwalFlash.error(`Error`, message);
		}
	};

	// Report Functionality
	$(document).on(`click`, `[data-report]`, (e) => {
		const obj = $(e.currentTarget),
			type = obj.attr(`data-report`),
			route = obj.attr(`data-report-route`),
			id = parseInt(obj.attr(`data-report-id`));

		const htmlTmp = `
		<div class="form-group vstack text-start">
			<label for="reason" class="form-label required-after">Reason</label>
			<p>Please provide a reason why you are reporting this ${type}.</p>

			<textarea id="reason" name="reason" class="swal2-textarea form-control not-resizable m-0" required></textarea>
		</div>
		`;

		Swal.fire({
			title: `Report this ${type}?`,
			html: htmlTmp,
			showCancelButton: true,
			confirmButtonText: `Report`,
			showLoaderOnConfirm: true,
			preConfirm: () => {
				const textarea = $(`#reason`),
					reason = textarea.val();

				let validated = true;

				if (!reason) {
					Swal.showValidationMessage(`Reason is required.`);
					textarea.addClass(`is-invalid`)
						.removeClass(`is-valid`);

					validated = false;
				}

				if (!validated)
					return false;

				textarea.addClass(`is-valid`)
					.removeClass(`is-invalid`);
				return reason;
			},
			customClass: {
				confirmButton: `btn btn-bad`,
			}
		}).then((result) => {
			if (result.isConfirmed) {
				sendAPIReq(id, UID, route, result.value)
					.then(responseHandler)
					.catch(responseHandler);
			}
		});

		if (typeof TextCounter !== `undefined`) {
			TextCounter.init(
				`#reason[name=reason]`,
				{
					max: 8192,
					warnAt: 25,
					restrict: true
				}
			);
		}
		else {
			$(`#reason[name=reason]`).removeClass(`m-0`)
				.addClass(`m-1`);
		}
	});
});
