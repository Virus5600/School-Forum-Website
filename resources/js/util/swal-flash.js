if (!Swal)
	throw Error('Sweetalert2 not instantiated. Please include the said library (https://sweetalert2.github.io/). Currently testing for `Swal` keyword.');

class SwalFlash {
	constructor() {
		if (this instanceof SwalFlash)
			throw Error('SwalFlash is a static class and cannot be instantiated');
	}

	static error(title, msg = undefined, plain_text = false, has_icon = undefined, toast = undefined, pos = undefined, has_timer = undefined, duration = undefined) {
		SwalFlash.#sendEvent(`flash_error`, {
			flash_error: title,
			message: msg,
			plain_text: plain_text,
			has_icon: has_icon,
			is_toast: toast,
			position: pos,
			has_timer: has_timer,
			duration: duration
		});
	}

	static info(title, msg = undefined, plain_text = false, has_icon = undefined, toast = undefined, pos = undefined, has_timer = undefined, duration = undefined) {
		SwalFlash.#sendEvent(`flash_info`, {
			flash_info: title,
			message: msg,
			plain_text: plain_text,
			has_icon: has_icon,
			is_toast: toast,
			position: pos,
			has_timer: has_timer,
			duration: duration
		});
	}

	static success(title, msg = undefined, plain_text = false, has_icon = undefined, toast = undefined, pos = undefined, has_timer = undefined, duration = undefined) {
		SwalFlash.#sendEvent(`flash_success`, {
			flash_success: title,
			message: msg,
			plain_text: plain_text,
			has_icon: has_icon,
			is_toast: toast,
			position: pos,
			has_timer: has_timer,
			duration: duration
		});
	}

	static #sendEvent(type, params) {
		window.dispatchEvent(new CustomEvent(type, {
			detail: params
		}));
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
			title: `text-white text-center`,
			htmlContainer: `text-white text-center`,
			popup: `px-3`
		},
	}

	Swal.fire(__setSwalFlashOptions(options, flash, 'error'));
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
			title: `text-white text-center`,
			htmlContainer: `text-white text-center`,
			popup: `px-3`
		},
	}

	Swal.fire(__setSwalFlashOptions(options, flash, 'info'));
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
			title: `text-white text-center`,
			htmlContainer: `text-white text-center`,
			popup: `px-3`
		},
	}

	Swal.fire(__setSwalFlashOptions(options, flash, 'success'));
});

const __setSwalFlashOptions = (options, flash, type) => {
	let plainText = false;
	if (flash.plain_text != undefined)
		plainText = flash.plain_text == true ? true : false;

	if (flash.has_icon != undefined)
		options["icon"] = `${type}`;

	if (flash.message != undefined)
		options[plainText ? "text" : "html"] = `${flash.message}`;

	if (flash.position != undefined)
		options["position"] = flash.position;

	if (flash.is_toast != undefined)
		options["toast"] = flash.is_toast;

	if (flash.has_timer != undefined)
		if (flash.has_timer)
			options['timer'] = flash.duration != undefined ? flash.duration : 10000;
		else
			delete options['duration'];

	return options;
}
