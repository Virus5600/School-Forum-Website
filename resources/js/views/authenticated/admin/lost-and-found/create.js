$(() => {
	const uiToastElTarget = document.getElementById('editor');
	const uiToastOpt = {
	// Element to be used as a container for the editor
		el: uiToastElTarget,

		// Editor configurations
		initialEditType: `markdown`,
		initialValue: uiToastElTarget.innerText,
		previewStyle: `vertical`,
		placeholder: `Item description...`,
		toolbarItems: [
			['heading', 'bold', 'italic', 'strike'],
			['hr', 'quote'],
			['ul', 'ol', 'task', 'indent', 'outdent'],
		],
		minHeight: `150px`,
		height: `auto`,
		autoFocus: false,

		// Event handlers
		events: {
			blur: function() {
				document.getElementById('item_description').value = editor.getMarkdown();
			}
		},

		// Disable Google Analytics
		usageStatistics: false,
	};

	const editor = new Editor(uiToastOpt);

	$(editor.options.el).closest('form').on(`reset`, (e) => {
		editor.setMarkdown(editor.options.initialValue);
	});
});
