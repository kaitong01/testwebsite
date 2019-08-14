// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var debounce = function(fn, delay) {
		var timeout;
		return function() {
			var self = this;
			var args = arguments;
			window.clearTimeout(timeout);
			timeout = window.setTimeout(function() {
				fn.apply(self, args);
			}, delay);
		};
	};

	var FormSEO = {
		init: function (options, elem) {
			var self = this;

			self.settings = $.extend( {}, $.fn.formseo.defaults, options );
			self.$elem = $(elem);
			
			self.$title = self.$elem.find(':input.input-title');
			self.$content = self.$elem.find(':input.input-content');
			self.$title_seo = self.$elem.find(':input.input-title-seo');
			self.$url_seo = self.$elem.find(':input.input-url-seo');
			self.$content_seo = self.$elem.find(':input.input-content-seo');
			self.content_seo = '';
			self.base_url = self.$elem.find('.seourl-base').text();


			self.$preview = self.$elem.find('.control-google-preview');

			$.extend(self, {
				onCreateLink: debounce(self.onCreateLink, self.settings.loadThrottle)
			});

			self.$title.on({
				mousedown : function(e) { e.stopPropagation(); },
				keydown   : function() { return self.onKeyDown.apply(self, arguments); },
				keyup     : function() { return self.onKeyUp.apply(self, arguments); },
				keypress  : function() { return self.onKeyPress.apply(self, arguments); },
				resize    : function() { self.positionDropdown.apply(self, []); },
				blur      : function() { return self.onBlur.apply(self, arguments); },
				focus     : function() { self.ignoreBlur = false; return self.onFocus.apply(self, arguments); },
				paste     : function() { return self.onPaste.apply(self, arguments); }
			});


			self.$url_seo.focus(function(event) {
				$(this).closest('.seourl-wrap').addClass('is-focus')
			}).blur(function(event) {
				$(this).closest('.seourl-wrap').removeClass('is-focus');


				var placeholder = $(this).attr('data-label');
				var val = $(this).val();

				if( val != placeholder ){
					placeholder = val;
					$(this).attr('data-label', val);
					
				}

				$(this).val(placeholder);
				self.preview();

			}).keyup(function(event) {
				var val = $(this).val();
				$(this).attr('data-value', val);

				self.preview();
			});


			self.$title_seo.keyup(function() {
				self.preview();
			}).change(function() {
				self.preview();
			});

			if( self.$content.hasClass('input-editor') ){

				self.$content.editor2({
					onChange : function (ed) {
						self.setContent( this.getContent() );
					}
				});
			}
			else{

				self.$content.on({
					// mousedown : function(e) { e.stopPropagation(); },
					// keydown   : function() { return self.onKeyDown.apply(self, arguments); },
					keyup     : function() { self.setContent( $.trim( $(this).val() ) ) },
					// keypress  : function() { return self.onKeyPress.apply(self, arguments); },
					// resize    : function() { self.positionDropdown.apply(self, []); },
					blur      : function() { self.setContent( $.trim( $(this).val() ) ) },
					// focus     : function() { self.ignoreBlur = false; return self.onFocus.apply(self, arguments); },
					// paste     : function() { return self.onPaste.apply(self, arguments); }
				});
			}


			$('[data-stap-action]').click(function() {

				setTimeout(function() {

					var ta = self.$content_seo[0];
					autosize.update(ta);
				}, 10);
				
			});

			self.preview();
		},

		onKeyDown: function () {
			// console.log( 'onKeyDown' );
		},
		onKeyUp: function () {
			var self = this;

			// console.log( 'onKeyUp' );


			var value = self.$title.val() || '';
			self.$title_seo.val( $.trim(value) );

			if (self.lastValue !== value) {
				self.lastValue = value;
				self.onCreateLink(value);
				// self.refreshOptions();
				// self.trigger('type', value);
			}

		},
		onKeyPress: function () {
			// console.log( 'onKeyPress' );
		},
		positionDropdown: function () {
			// console.log( 'positionDropdown' );
		},
		onBlur: function () {
			// console.log( 'onBlur' );
		},
		onPaste: function () {
			// console.log( 'onPaste' );
		},
		onFocus: function () {
			// console.log( 'onFocus' );
		},

		onCreateLink: function(value) {
			var self = this;

			var placeholder = self.$url_seo.attr('data-value') || '';

			if( placeholder!='' ) return;

			if( value=='' ){

				self.$url_seo.attr( {
					// placeholder: '',
					'data-label': '',
				}).val('');

				return;
			}

			setTimeout(function() {

				/*var uri = self.createLink(value);

				self.$url_seo.attr( {
					// placeholder: res.data,
					'data-label': uri,
				}).val(uri);

				self.preview();*/


				self.createLink(value).done(function(res) {

					if( res.data ){
						self.$url_seo.attr( {
							// placeholder: res.data,
							'data-label': res.data,
						}).val(res.data);

						self.preview();
					}
				})
			}, 10);
			// return 
		},

		createLink: function (value) {




			// return encodeURIComponent( value.replace(/[\s\/\'\\]+/g, " ").trim().replace(/\s+/g, "-") );

			//config.base_url + 
			return $.ajax({
				url: '/createPrimaryLink',
				type: 'GET',
				dataType: 'json',
				data: {
					text: value,
					type: 'sitepage'
				},
			})
			
			.fail(function() {
				// console.log("error");
			})
			.always(function() {
				// console.log("complete");
			});
		},

		setContent: function ( original ) {
			var self = this;

			var $div = $('<div>').html(original.replace(/(<\S([^>]+)>)/ig,""));
			var content = $div.text().replace(/\s+/g," ");

			var desired = content.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, '');
			// console.log( desired );

			self.content_seo = desired.substring(0, 320);
			
			self.$content_seo.val( self.content_seo );
			// console.log( content );

			var ta = self.$content_seo[0];
			autosize.update(ta);

			self.preview();
		},


		preview: function () {
			var self = this;

			var title = $.trim( self.$title_seo.val() );
			var url = $.trim( self.$url_seo.val() );


			self.$preview.toggleClass('d-none', title=='' );

			self.$preview.find('.title').text( title );
			self.$preview.find('.url').text( self.base_url+url );
			self.$preview.find('.description').text( self.content_seo );
		}
		
	}
	$.fn.formseo = function( options ) {
		return this.each(function() {
			var $this = Object.create( FormSEO );
			$this.init( options, this );
			$.data( this, 'formseo', $this );
		});
	};
	$.fn.formseo.defaults = {
		loadThrottle: 300,
	}
	

})( jQuery, window, document );
	