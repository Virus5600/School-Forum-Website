$(() => {
	$(`.autocomplete`).each((index, element) => {
		const obj = $(element);

		let source;
		source = element.list ?? obj.attr('data-autocomplete-source');

		if (source === undefined) {
			source = obj.attr('data-autocomplete-source-url');

			if (source === undefined) {
				console.error('No source or source url provided for autocomplete.', {
					element: element
				});

				return;
			}

			source = $.ajax({
				url: source,
				dataType: 'json',
				success: (data) => {
					return data;
				}
			});
		}
		else {
			if (source instanceof HTMLElement) {
				source = $(source)
					.find('option')
					.map((index, element) => {
						return $(element).text();
					})
					.get();
			}
			else {
				source = $(`datalist${source} > option`)
					.map((index, element) => {
						return $(element).text();
					})
					.get();
			}
		}

		console.log(source);
		obj.autocomplete({
			source: source,
			delay: 0,
			minLength: 0,
		});
	});
});
