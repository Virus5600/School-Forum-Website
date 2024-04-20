document.addEventListener('DOMContentLoaded', () => {
	const UPDATE_COUNTER = (e) => {
		let obj = e.currentTarget;
		let parent = obj.parentElement;
		let counter = parent.querySelector('.text-counter');
		let max = obj.getAttribute('data-tc-max');
		let warnAt = obj.getAttribute('data-tc-warn-at') ?? 0;
		let restrictEnabled = obj.getAttribute('data-tc-restrict') ? obj.getAttribute('data-tc-restrict') == 'true' : false;
		const DEBUG = obj.getAttribute('data-tc-debug') ? obj.getAttribute('data-tc-debug') == 'true' : false;

		if (DEBUG) {
			console.log({
				obj,
				parent,
				counter,
				max,
				warnAt,
				DEBUG
			});
		}

		if (typeof warnAt !== 'number' && isNaN(warnAt))
			warnAt = 0;

		counter.innerText = max - obj.value.length;

		warnAt = parseInt(warnAt);
		textLen = parseInt(counter.innerText);

		if (restrictEnabled) {
			if (textLen < 0) {
				obj.value = obj.value.slice(0, max);
				counter.innerText = 0;
			}
		}

		if (textLen <= warnAt && textLen >= 0) {
			counter.classList.add('bg-warning');
			counter.classList.remove('bg-danger');
			obj.classList.add('mark-warning');
			obj.classList.remove('mark-danger');
		}
		else if (textLen < 0) {
			counter.classList.remove('bg-warning');
			counter.classList.add('bg-danger');
			obj.classList.remove('mark-warning');
			obj.classList.add('mark-danger');
		}
		else {
			counter.classList.remove('bg-danger');
			counter.classList.remove('bg-warning');
			obj.classList.remove('mark-danger');
			obj.classList.remove('mark-warning');
		}
	};

	document.querySelectorAll('.text-counter-input').forEach((el) => {
		el.addEventListener('change', UPDATE_COUNTER);
		el.addEventListener('keyup', UPDATE_COUNTER);
		el.addEventListener('keydown', UPDATE_COUNTER);
	});
});
