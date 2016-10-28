
function widgetPostsListSortable(selector)
{
	// init objects
	var cont = jQuery(selector),
		posts = jQuery('ul', cont).first(),
		message =
			jQuery('<div></div>')
				.insertBefore(posts),
		item =
			jQuery('div.ice-content', posts)
				.addClass('ui-state-default ui-corner-all'),
		status =
			jQuery('span.ice-status', posts)
				.buttonset(),
		trash =
			jQuery('a.ice-do-trash', posts)
				.button({icons: {primary: 'ui-icon-trash'}});

	// add icons to status buttons
	status.each(function()
	{
		var buttons = jQuery('input', this);
		buttons.eq(0).button('option', 'icons', {primary: 'ui-icon-pencil'});
		buttons.eq(1).button('option', 'icons', {primary: 'ui-icon-document'});
	});

	// handle status change
	jQuery('input', status).click(function()
	{
		var $this = jQuery(this),
			id_arr = iceEasyAjax.splitDash($this.attr('id')),
			p_id = id_arr[2],
			p_stat = id_arr[1];

		// show spinner
		message.iceEasyFlash('loading', 'Updating status to: ' + p_stat).fadeIn();

		// save hierarchy
		jQuery.post(
			iceEasyGlobalL10n.ajax_url,
			{
				'action': 'ice_widgets_posts_list_item_status',
				'post_id': p_id,
				'post_status': p_stat
			},
			function(r){
				var rs = iceEasyAjax.splitResponseStd(r);
				if (rs.code >= 1) {
					message.iceEasyFlash('alert', rs.message);
				} else {
					message.iceEasyFlash('error', rs.message);
				}
			}
		);

		return false;
	});

	// handle trash click
	trash.click(function()
	{
		if (!confirm('Are you sure you want to trash this post?')) {
			return false;
		}

		var $this = jQuery(this),
			p_id = $this.prop('hash').substr(1);

		// show spinner
		message.iceEasyFlash('loading', 'Moving item to trash').fadeIn();

		// trash the post
		jQuery.post(
			iceEasyGlobalL10n.ajax_url,
			{
				'action': 'ice_widgets_posts_list_item_trash',
				'post_id': p_id
			},
			function(r){
				var rs = iceEasyAjax.splitResponseStd(r);
				if (rs.code >= 1) {
					$this.closest('li').remove();
					message.iceEasyFlash('alert', rs.message);
				} else {
					message.iceEasyFlash('error', rs.message);
				}
			}
		);

		return false;
	});

	// make posts sortable
	posts.nestedSortable({
		handle: 'div',
		helper:	'clone',
		listType: 'ul',
		items: 'li',
		maxLevels: 0,
		opacity: .6,
		revert: 250,
		tabSize: 25,
		tolerance: 'pointer',
		toleranceElement: '> div',
		stop: function(event,ui){
			// show spinner
			message.iceEasyFlash('loading', 'Saving hiearchy').fadeIn();
			// save hierarchy
			jQuery.post(
				iceEasyGlobalL10n.ajax_url,
				{
					'action': 'ice_widgets_posts_list_save',
					'posts': posts.nestedSortable('toArray')
				},
				function(r){
					var rs = iceEasyAjax.splitResponseStd(r);
					if (rs.code >= 1) {
						message.iceEasyFlash('loading', rs.message).fadeOut(500);
					} else {
						message.iceEasyFlash('error', rs.message);
					}
				}
			);
		}
	});
}

var iceEasyColorPicker = function ()
{
	var
		inputEl,
		pickerEl,
		pickerBg = function(pickerEl, color)
		{
			// get child div
			var el = pickerEl.children('div');
			// set color if needed
			if (color) {
				el.css('background-color', color);
				pickerEl.ColorPickerSetColor(color);
			}
			// return color
			return el.css('background-color', color);
		};

	return {
		// Initialize a colorpicker
		init: function (inputSelector, pickerSelector)
		{
			// set elements on init
			pickerEl = jQuery(pickerSelector);
			inputEl = jQuery(inputSelector).bind('click', function () {
				jQuery(this).bind('keyup', function () {
					pickerBg(jQuery(pickerSelector), this.value);
				});
			});

			// attach color picker event
			pickerEl.ColorPicker({
				onBeforeShow: function () {
					// set elements before show
					pickerEl = jQuery(pickerSelector);
					inputEl = jQuery(inputSelector);
				},
				onShow: function (colpkr) {
					jQuery(colpkr).fadeIn(500);
					return false;
				},
				onHide: function (colpkr) {
					jQuery(colpkr).fadeOut(500);
					return false;
				},
				onChange: function (hsb, hex, rgb) {
					color = '#' + hex;
					inputEl.val(color);
					pickerBg(pickerEl, color);
				}
			});

			// initialize color on init
			if (inputEl.val()) {
				pickerBg(pickerEl, inputEl.val());
			}
		}
	};
}();
(function($)
{
	// all instances share dialog vars to there is
	// only ever one instance of each at a time
	var _muDialog,
		_zoomDialog;

	// the plugin!
	$.fn.icextOptionUploader = function (method)
	{
		var $base = this,
			settings = {
				ibarSelector: '',
				imageSelector: '',
				inputSelector: '',
				defImage: { value: null, url: '' },
				noImage: { value: null, url: '' },
				muOptions: {
					autoOpen: false,
					modal: true,
					height: 600,
					width: 700,
					minHeight: 600,
					minWidth: 700
				},
				zoomOptions: {
					autoOpen: false,
					modal: true,
					height: 600,
					width: 800
				}
			};

		var _btnLibrary,
			_btnTrash,
			_btnUpload,
			_btnZoom,
			_chkDisable,
			_controls,
			_image,
			_input,
			_notifyOnce;

		var initControls = function()
		{
			// select elements
			_controls = $( settings.ibarSelector, $base );
			_btnUpload = _controls.children().eq(0);
			_btnLibrary = _controls.children().eq(1);
			_btnZoom = _controls.children().eq(2);
			_btnTrash = _controls.children().eq(3);
			_chkDisable = $( 'div.ice-do-disable input', $base );
			_image = $( settings.imageSelector, $base );
			_input = $( settings.inputSelector, $base );

			// init upload button
			_btnUpload.button({
				icons: {
					primary: "ui-icon-circle-arrow-n"
				}
			}).click(function(e){
				methods.muOpen( 'type' );
				e.preventDefault();
			}).show();

			// init library button
			_btnLibrary.button({
				icons: {
					primary: "ui-icon-folder-open"
				}
			}).click(function(e){
				methods.muOpen( 'library' );
				e.preventDefault();
			}).show();

			// init zoom button
			_btnZoom.button({
				icons: {
					primary: "ui-icon-zoomin"
				}
			}).click(function(e){
				methods.zoomOpen();
				e.preventDefault();
			}).show();

			// init rem button
			_btnTrash.button({
				icons: {
					primary: "ui-icon-trash"
				}
			}).click(function(e){
				updateImage( settings.defImage.value );
				e.preventDefault();
			});

			// init disabled checked status
			if ( settings.noImage.value == _input.val() ) {
				// check it
				_chkDisable.attr( 'checked', 'checked' );
				// set no image graphic
				_image.attr( 'src', settings.noImage.url );
			}
			
			// init disable click event
			_chkDisable.click( function() {
				// was it checked?
				if ( 'checked' == $(this).attr( 'checked' ) ) {
					// maybe save previous value
					if ( _input.val() !== settings.noImage.value ) {
						_input.data( 'last', _input.val() );
					}
					// set no image value
					updateImage( settings.noImage.value );
				} else {
					// get last value
					var lastVal = _input.data( 'last' );
					// revert to previous value
					if ( lastVal ) {
						updateImage( lastVal );
					} else {
						updateImage( null );
					}
				}
			});
			
			// display trash on load?
			toggleTrash();
		}

		var toggleTrash = function()
		{
			// get current attach id
			var attachId = parseInt( _input.val() );

			// is attach id a "non trashable" value?
			if ( isNaN( attachId ) || settings.noImage.value == attachId ) {
				// yes, fade it out
				_btnTrash.fadeOut( 500 );
			} else {
				// no, fade it in
				_btnTrash.fadeIn( 500 );
			}
		};

		var updateImage = function( attachId )
		{
			_input.val( attachId );

			if ( settings.noImage.value === attachId ) {

				// set no image graphic
				_image.fadeOut(500, function(){
					$(this).attr( 'src', settings.noImage.url )
						.fadeIn(500, function(){
							notifySave();
						});
				});

			} else if ( !attachId || settings.defImage.value === attachId ) {

				// use def url if configured
				_image.fadeOut(500, function(){
					if ( settings.defImage.url ) {
						_image.attr( 'src', settings.defImage.url )
							.fadeIn(500, function(){
								notifySave();
							});
					} else {
						_image.attr( 'src', '' );
						notifySave();
					}
				});

			} else {

				_image.fadeTo( 500, 0.3, function(){

					$.ajax({
						type: 'POST',
						url: iceEasyGlobalL10n.ajax_url,
						data: {
							'action': 'ice_options_uploader_media_url',
							'attachment_id': attachId,
							'attachment_size': 'full'
						},
						success: function(rs){
							var r = iceEasyAjax.splitResponse(rs);
							// TODO error handling
							_image
								.attr( 'src', r[1] )
								.fadeTo( 500, 1, function(){
									_chkDisable.removeAttr( 'checked' );
									notifySave();
								});
						}
					});

				});

			}

			// toggle the trash
			toggleTrash();
		};

		var notifySave = function()
		{
			if ( !_notifyOnce ) {
				alert( 'You must save this setting if you want any changes to become permanent.' );
				_notifyOnce = true;
			}
		};

		var methods = {

			init: function( options )
			{
				// merge options
				$.extend( true, settings, options );

				// kill existing mu dialog
				if ( _muDialog && $('div.icextOptionUploadWin').hasClass('ui-dialog-content') ) {
					_muDialog.dialog('destroy').remove();
				}

				// kill existing zoom dialog
				if ( _zoomDialog ) {
					_zoomDialog.dialog('destroy').remove();
				}

				// init controls
				initControls();
			},

			muOpen: function( tab )
			{
				_muDialog = $('<div class="icextOptionUploadWin"><iframe></iframe></div>').appendTo('body');
				_muDialog.dialog( settings.muOptions );
				_muDialog.dialog({
					close: function(){
						var iframe = $( 'iframe', this ),
							iframeWin = iframe.prop( 'contentWindow' ) || iframe.prop( 'contentDocument' );
						updateImage( iframeWin.icextOptionUploadAttachmentId );
						iframe.attr( 'src', '' );
						_muDialog.dialog('destroy').remove();
					}
				});
				_muDialog.dialog('open');
				$( 'iframe', _muDialog )
					.attr( 'src', 'media-upload.php?post_id=0&icext_option_upload=1&tab=' + tab );
			},

			zoomOpen: function()
			{
				_zoomDialog = $('<div></div>').appendTo('body');
				_zoomDialog.dialog( settings.zoomOptions );
				_zoomDialog.dialog({
					close: function(){
						_zoomDialog.dialog('destroy').remove();
					}
				});

				_image.clone().appendTo( _zoomDialog );
				
				_zoomDialog.dialog('open');
			}
		}
		
		if ( methods[method] ) {
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || ! method) {
			return methods.init.apply(this, arguments);
		} else {
			return $.error('Method ' +  method + ' does not exist on jQuery.icextOptionUploader');
		}
	}

}(jQuery));

