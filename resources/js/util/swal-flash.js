if (!Swal)
	throw Error('Sweetalert2 not instantiated. Please include the said library (https://sweetalert2.github.io/). Currently testing for `Swal` keyword.');

/**
 * SwalFlash Class for handling flash messages using SweetAlert2.
 *
 * This class is a singleton wrapper for SweetAlert2 to handle flash messages. It provides a more
 * convenient way to display flash messages using the `error`, `info`, and `success` methods.
 *
 * The `custom` method allows for easier customization of the flash messages. The `fire` method
 * is a direct call to `Swal.fire()` with additional offsets option.
 *
 * For convenience, the class listens to the `flash_error`, `flash_info`, and `flash_success` events
 * to display the flash messages, allowing developers to use the `error`, `info`, and `success` methods
 * to trigger the said events. Additionally, the class listens to the `click` event to close the flash
 * messages when clicked.
 *
 * The class also provides a debug mode to log the options before and after setting the options
 * by setting the `SwalFlash.debug` property to `true`.
 *
 * For reference, the `options` parameter for the `custom` method is as follows:
 * - **`type`**: `string` 		- Must be either `error`, `info`, or `success`.
 * - **`title`**: `string`		- Title of the flash message.
 * - **`msg`**: `string`			- Message of the flash message.
 * - **`plain_text`**: `bool`		- Whether the message (`msg`) is plain text or HTML.
 * - **`has_icon`**: `bool`		- Whether the flash message has an icon. This cannot be customized and will be set based on the type using the built-in icons.
 * - **`toast`**: `bool`			- Whether the flash message is a toast.
 * - **`pos`**: `string`			- Position of the flash message. Default is `top`. All allowed positions are `top`, `top-start`, `top-end`, `center`, `center-start`, `center-end`, `bottom`, `bottom-start`, and `bottom-end`.
 * - **`offsets`**: `object`		- Offsets for the flash message. Default is `undefined`. The object should contain the following properties: `top`, `bottom`, `left`, and `right`.
 * - **`has_timer`**: `bool`		- Whether the flash message has a timer. Default is `true`.
 * - **`duration`**: `int`		- Duration of the flash message. Default is `10000` which is 10 seconds (10000 milliseconds / 1 second).
 *
 * When using the `custom` method, the `type` property is required. The rest of the
 * properties are optional. Furthermore, all options are also used in the `error`,
 * `info`, and `success` methods in the same order as listed above, with the exception
 * of the `type` property.
 *
 *
 * @version 1.0.0
 *
 * @class SwalFlash
 *
 * ---
 * @method error(title, msg, plain_text, has_icon, toast, pos, offsets, has_timer, duration)
 * \- Displays an error message.
 * ---
 * @method info(title, msg, plain_text, has_icon, toast, pos, offsets, has_timer, duration)
 * \- Displays an info message.
 * ---
 * @method success(title, msg, plain_text, has_icon, toast, pos, offsets, has_timer, duration)
 * \- Displays a success message.
 * ---
 * @method custom(options)
 * \- Displays one of the earlier flashes with easier customization option.
 * ---
 * @method fire(options)
 * \- Standard `Swal.fire()` method with additional offsets option.
 * ---
 *
 * @author Virus5600
 * @GitHub https://github.com/Virus5600
 */
class SwalFlash {
	static debug = false;

	constructor() {
		if (this instanceof SwalFlash)
			throw Error('SwalFlash is a static class and cannot be instantiated');
	}

	static error(title, msg = undefined, plain_text = false, has_icon = undefined, toast = undefined, pos = undefined, offsets = undefined, has_timer = undefined, duration = undefined) {
		SwalFlash.#sendEvent(`flash_error`, {
			flash_error: title,
			message: msg,
			plain_text: plain_text,
			has_icon: has_icon,
			is_toast: toast,
			position: pos,
			offsets: offsets,
			has_timer: has_timer,
			duration: duration
		});
	}

	static info(title, msg = undefined, plain_text = false, has_icon = undefined, toast = undefined, pos = undefined, offsets = undefined, has_timer = undefined, duration = undefined) {
		SwalFlash.#sendEvent(`flash_info`, {
			flash_info: title,
			message: msg,
			plain_text: plain_text,
			has_icon: has_icon,
			is_toast: toast,
			position: pos,
			offsets: offsets,
			has_timer: has_timer,
			duration: duration
		});
	}

	static success(title, msg = undefined, plain_text = false, has_icon = undefined, toast = undefined, pos = undefined, offsets = undefined, has_timer = undefined, duration = undefined) {
		SwalFlash.#sendEvent(`flash_success`, {
			flash_success: title,
			message: msg,
			plain_text: plain_text,
			has_icon: has_icon,
			is_toast: toast,
			position: pos,
			offsets: offsets,
			has_timer: has_timer,
			duration: duration
		});
	}

	static custom(options) {
		const {
			type = `info`,
			title,
			msg = undefined,
			plain_text = false,
			has_icon = undefined,
			toast = undefined,
			pos = undefined,
			offsets = undefined,
			has_timer = undefined,
			duration = undefined
		} = options;

		if (!['error', 'info', 'success'].includes(type))
			throw Error('Invalid type. Must be either `error`, `info`, or `success`.');

		SwalFlash[type](
			title,
			msg,
			plain_text,
			has_icon,
			toast,
			pos,
			offsets,
			has_timer,
			duration
		);
	}

	static #sendEvent(type, params) {
		window.dispatchEvent(new CustomEvent(type, {
			detail: params
		}));
	}

	static fire(options) {
		// Check if the offsets are set
		let offsets = undefined;
		if (options[`offsets`]) {
			// If they are, transfer the offsets to another variable
			offsets = options[`offsets`];
			delete options[`offsets`];
		}

		Swal.fire(options);

		if (offsets) {
			if (SwalFlash.debug)
				console.log("OFFSETS:", options.offsets);

			let obj = Swal.getPopup();

			obj.style.marginTop = offsets.top ?? "auto";
			obj.style.marginBottom = offsets.bottom ?? "auto";

			obj.style.marginLeft = offsets.left ?? "auto";
			obj.style.marginRight = offsets.right ?? "auto";
		}
	}
}

window.addEventListener('flash_error', (e) => {
	let flash = e.detail;
	let options = {
		title: `${flash.flash_error}`,
		position: `top`,
		showConfirmButton: false,
		toast: true,
		timer: 10000,
		background: `#dc3545`,
		customClass: {
			container: `swal-flash`,
			title: `text-white text-center`,
			htmlContainer: `text-white text-center`,
			popup: `px-3`
		},
	}

	SwalFlash.fire(__setSwalFlashOptions(options, flash, 'error'));
});

window.addEventListener('flash_info', (e) => {
	let flash = e.detail;
	let options = {
		title: `${flash.flash_info}`,
		position: `top`,
		showConfirmButton: false,
		toast: true,
		timer: 10000,
		background: `#17a2b8`,
		customClass: {
			container: `swal-flash`,
			title: `text-white text-center`,
			htmlContainer: `text-white text-center`,
			popup: `px-3`
		},
	}

	SwalFlash.fire(__setSwalFlashOptions(options, flash, 'info'));
});

window.addEventListener('flash_success', (e) => {
	let flash = e.detail;
	let options = {
		title: `${flash.flash_success}`,
		position: `top`,
		showConfirmButton: false,
		toast: true,
		timer: 10000,
		background: `#28a745`,
		customClass: {
			container: `swal-flash`,
			title: `text-white text-center`,
			htmlContainer: `text-white text-center`,
			popup: `px-3`
		},
	}

	SwalFlash.fire(__setSwalFlashOptions(options, flash, 'success'));
});

const __setSwalFlashOptions = (options, flash, type) => {
	if (SwalFlash.debug)
		console.log("START:", {options, flash});

	let plainText = false;
	if (flash.plain_text != undefined)
		plainText = flash.plain_text == true ? true : false;

	if (flash.has_icon != undefined)
		options["icon"] = `${type}`;

	if (flash.message != undefined)
		options[plainText ? "text" : "html"] = `${flash.message}`;

	if (flash.position != undefined)
		options["position"] = flash.position;

	if (flash.offsets != undefined)
		options["offsets"] = flash.offsets;

	if (flash.is_toast != undefined)
		options["toast"] = flash.is_toast;

	if (flash.has_timer != undefined)
		if (flash.has_timer)
			options['timer'] = flash.duration != undefined ? flash.duration : 10000;
		else
			delete options['duration'];

	if (SwalFlash.debug)
		console.log("END:", {options, flash});

	return options;
}

document.addEventListener('DOMContentLoaded', () => {
	document.addEventListener("click", (e) => {
		const obj = e.target;
		const flash = obj.closest(`.swal-flash`)

		if (flash && Swal.isVisible())
			Swal.close();
	});
});
