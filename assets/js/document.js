var config = {
	toolbar: [
		{ name: 'document', items: [ 'Print' ] },
		{ name: 'clipboard', items: [ 'Undo', 'Redo' ] },
		{ name: 'styles', items: [ 'Format', 'Font', 'FontSize' ] },
		{ name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat', 'CopyFormatting' ] },
		{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
		{ name: 'align', items: [ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
		{ name: 'links', items: [ 'Link', 'Unlink' ] },
		{ name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote' ] },
		{ name: 'insert', items: [ 'Image', 'Table' ] },
		{ name: 'tools', items: [ 'Maximize' ] },
		{ name: 'editing', items: [ 'Scayt' ] }
	],
	customConfig: '',
	disallowedContent: 'img{width,height,float}',
	extraAllowedContent: 'img[width,height,align]',
	height: 950,
	contentsCss: [ 'https://cdn.ckeditor.com/4.6.1/full-all/contents.css', '/assets/style/document.css' ],
	bodyClass: 'document-editor',
	format_tags: 'p;h1;h2;h3;pre',
	removeDialogTabs: 'image:advanced;link:advanced',
	stylesSet: [
		/* Inline Styles */
		{ name: 'Marker', element: 'span', attributes: { 'class': 'marker' } },
		{ name: 'Cited Work', element: 'cite' },
		{ name: 'Inline Quotation', element: 'q' },
		/* Object Styles */
		{
			name: 'Special Container',
			element: 'div',
			styles: {
				padding: '5px 10px',
				background: '#eee',
				border: '1px solid #ccc'
			}
		},
		{
			name: 'Compact table',
			element: 'table',
			attributes: {
				cellpadding: '5',
				cellspacing: '0',
				border: '1',
				bordercolor: '#ccc'
			},
			styles: {
				'border-collapse': 'collapse'
			}
		},
		{ name: 'Borderless Table', element: 'table', styles: { 'border-style': 'hidden', 'background-color': '#E6E6FA' } },
		{ name: 'Square Bulleted List', element: 'ul', styles: { 'list-style-type': 'square' } }
	]
};

var docContainer = $('.document-container');

$('[data-delete]').click(function() {
	alertify.confirm('Confirmation', 'Êtes-vous sûr(e) de vouloir supprimer ce document ?<br/>Cette action est irréversible.', () => {
		$.post(location.origin + '/nexus/delete/' + $(this).data('delete'), {}).done(() => {
			alertify.warning('<div class="text-center"><i class="fa fa-spinner fa-pulse fa-fw"></i> Stabbing document until it dies</div>');
			setTimeout(() => {
				location.href = location.origin + "/nexus";
			}, 500);
		});
	}, () => {});
});

$('[data-edit]').click(function() {
	location.href = location.origin + "/nexus/edit/" + $(this).data('edit');
});
