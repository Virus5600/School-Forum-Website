$(() => {
	const uiToastElTarget = document.getElementById('editor');
	const uiToastOpt = {
	// Element to be used as a container for the editor
		el: uiToastElTarget,

		// Editor configurations
		initialEditType: `markdown`,
		initialValue: uiToastElTarget.innerText,
		previewStyle: `vertical`,
		placeholder: uiToastElTarget.dataset.uiPlaceholder ?? `Comment...`,
		toolbarItems: [
			['heading', 'bold', 'italic', 'strike'],
			['hr', 'quote'],
			['ul', 'ol', 'task'],
			['link', 'image'],
		],
		minHeight: `150px`,
		height: `auto`,
		autoFocus: false,

		// Event handlers
		events: {
			blur: function() {
				document.getElementById('content-input').value = editor.getMarkdown();
			}
		},

		// Disable Google Analytics
		usageStatistics: false,
	};

	const editor = new Editor(uiToastOpt);

	$(editor.options.el).closest('form').on(`reset`, (e) => {
		editor.setMarkdown(editor.options.initialValue);
	});

	// Disables the file upload button
	$(window).on(`click`, (e) => {
		const targetParent = `.toastui-editor-popup.toastui-editor-popup-add-image`;
		const urlInp = $(`${targetParent} [aria-label="URL"]`);
		const fileInp = $(`${targetParent} [aria-label="File"]`);

		urlInp[0]?.click();
		fileInp?.addClass(`d-none`);
	});
});
