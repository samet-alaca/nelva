jQuery(function() {

	function ckeditor_callback(fct) {
		if(typeof CKEDITOR !== 'undefined') {
			$.get(location.origin + '/users/usernames', {}).done(function(data) {
				var users = JSON.parse(data);
				var values = [];
				for(var user of users) {
					values.push(user.username);
				}
				var at_config = {
					at: "@",
					data: values,
					limit: users.length,
					displayTpl: "<li data-value='@${username}'>${username}</li>",
					insertTpl: '<a data-mention="${username}" href="'+location.origin+'/users/${id}">@${username}</a>'
				}

				CKEDITOR.on('instanceReady', function(event) {
					if(event.editor.atwho_loaded == undefined) {
						var editor = event.editor;
						editor.on('mode', function(e) {
							load_atwho(this, at_config);
						});
						load_atwho(editor, at_config);
						event.editor.atwho_loaded = true;
					}
				});
			});
		}
	}

	function load_atwho(editor, at_config) {
		if (editor.mode != 'source') {
			editor.document.getBody().$.contentEditable = true;
			$(editor.document.getBody().$)
			.atwho('setIframe', editor.window.getFrame().$)
			.atwho(at_config);
		}
		else {
			$(editor.container.$).find(".cke_source").atwho(at_config);
		}
	}

	ckeditor_callback();

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

	var file = $('#file');
	var ext = $('#ext');

	file.on('change', (e) => {
		ext.val(file.val().substr(file.val().lastIndexOf('.')));
	});

	$("#file").fileinput({
		resizeImage: true,
		maxImageHeight: 500,
		maxImageWidth: 500
	});

	if($('#editor').length > 0) {
		CKEDITOR.replace('editor', config);
	}

	$('#category').change(function() {
		updateCourseWrapper($(this).val());
	});

	$('#courseType').change(function() {
		updateCourseOrder($(this).val());
	});

	updateCourseWrapper($('#category').val());
	updateCourseOrder($('#courseType').val());

	function updateCourseWrapper(value) {
		if(value == '["coursjeu"]') {
			$('#courseWrap').removeClass('hidden');
		} else {
			$('#courseWrap').addClass('hidden');
		}
	}

	function updateCourseOrder(value) {
		$.post(location.origin + '/nexus/getCourseNames', { category: value }).done((data) => {
			var data = JSON.parse(data);
			if(data.length > 0) {
				$('#courseOrder').removeClass('hidden');
				var html = "";
				for(var course of data) {
					if(course.slug != location.pathname.substr(12) && course.slug != location.pathname.substr(14)) {
						html += '<option value="' + course.slug + '">Après ' + course.title + '</option>';
					}
				}
				$('#courseOrder').html(html);
			} else {
				$('#courseOrder').addClass('hidden');
			}
		});
	}

	$('form').submit(function(event) {
		$('#editor').val(CKEDITOR.instances['editor'].getData());
		var data = $(this).serializeArray();

		var errors = [];
		for(item of data) {
			if(item.name == "title" && (item.value.length < 5 || item.value.length > 60)) {
				errors.push("Titre trop court ou trop long (5 < titre > 60).");
			}
			if(item.name == "description" && item.value.length > 100) {
				errors.push("Description trop longue (max 100 caractères).");
			}
			if(item.name == "content" && item.value.length < 5) {
				errors.push("Contenu vide ou trop court.");
			}
		}
		if(errors.length > 0) {
			event.preventDefault();
			alertify.alert("Erreur", errors.join('<br>'));
		}
	});
});
