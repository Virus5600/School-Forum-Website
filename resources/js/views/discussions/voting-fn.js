$(() => {
	const UID = parseInt($(`meta[name='uid']`).attr('content') ?? 0);

	/**
	 * Sends an API request to the server through an XHR request using jQuery AJAX.
	 *
	 * @param {int} id				ID of the affected item.
	 * @param {int} userID			ID of the user who did the action.
	 * @param {string} route		URL of the API for the said action.
	 * @param {string} action		Action to be done. (upvote, downvote, remove)
	 *
	 * @return {Promise}
	 */
	const sendAPIReq = async (id, userID, route, action) => {
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
			_method: "PATCH",
			_token: token,
			bearer: bearer,
			id: id,
			userID: userID,
			action: action
		};

		// Sends the PATCH request
		return $.post(route, payload);
	};

	const responseHandler = (response) => {
		const { action, message, newAction, status, updatedData } = response;
		const {id, updatedCount} = updatedData ?? {id: null, updatedCount: null};

		// If the response is successful
		if (status === 200) {
			// Update the vote count
			$(`#vote-count-${id}`).text(updatedCount);

			// Update the vote action
			$(`#upvote-${id}`).attr(`data-vote-action`, newAction.upvote);
			$(`#downvote-${id}`).attr(`data-vote-action`, newAction.downvote);

			// Check action whether its upvote/downvote, swap, or unvote and apply style
			// changes accordingly.
			let actualAction = action.replace(/.*-/, ``),
				otherAction = actualAction === `upvote` ? `downvote` : `upvote`;

			switch (action.replace(/-.*/, '')) {
				case `upvote`:
				case `downvote`:
					// Update the vote action class
					$(`#${action}-${id}`).addClass(`active`);

					// If the other action is active, remove the active class
					$(`#${otherAction}-${id}`).removeClass(`active`);
					break;

				case `swap`:
					// Update the vote action class
					$(`#${actualAction}-${id}`).addClass(`active`);
					$(`#${otherAction}-${id}`).removeClass(`active`);
					break;

				case `unvote`:
					// Update the vote action class
					$(`#upvote-${id}, #downvote-${id}`).removeClass(`active`);
					break;
			}
		}
		// If there are validation errors
		else if (status === 422) {
			const message = response.responseJSON.message;
			console.log(`%cINFO: %c`, "color: #42b0f5; font-weight: bold; background-color: rgba(66, 176, 245, 0.25);", "color: white; background-color: rgba(66, 176, 245, 0.25);", message);
		}
		// If the user is not authenticated
		else if (status === 401) {
			const message = response.responseJSON.message;
			console.warn(message);
		}
		// If the server encountered an error
		else if (status === 500) {
			const message = response.responseJSON.message;
			console.error(message);
		}
	};

	// Upvote Functionality
	$(document).on(`click`, `.upvote`, (e) => {
		const obj = $(e.currentTarget),
			IID = parseInt(obj.attr(`data-vote-id`) ?? 0),
			route = obj.attr(`data-vote-route`),
			action = obj.attr(`data-vote-action`) ?? `upvote`;

		sendAPIReq(IID, UID, route, action)
			.then(responseHandler)
			.catch(responseHandler);
	});

	// Downvote Functionality
	$(document).on(`click`, `.downvote`, (e) => {
		const obj = $(e.currentTarget),
			IID = parseInt(obj.attr(`data-vote-id`) ?? 0),
			route = obj.attr(`data-vote-route`),
			action = obj.attr(`data-vote-action`) ?? `downvote`;

		sendAPIReq(IID, UID, route, action)
			.then(responseHandler)
			.catch(responseHandler);
	});
});
