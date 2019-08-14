// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	
	var Lightbox = {
		init: function (options, elem) {
			var self = this;

			self.$elem = $(elem);
			self.set( $.extend( {}, $.fn.lightbox.options, options ) );

			var url = self.$elem.attr('href');
			
			if( self.$elem.data('url') ){
				url = self.$elem.data('url');
				self.$elem.removeAttr('data-url');
			}


			if( self.$elem.is('a') ){
				self.$elem.attr('href', 'javascript:void(0)');
			}
			else if( self.$elem.data('href') ){
				self.$elem.removeAttr('href');
			}
			
			if( !self.options.toggle || !url ) return false;

			self.$elem.click(function(e) {
				e.preventDefault();

				var parent = self.$elem.parents('.model-outer');

				if( parent.length==1 ){

					self.parent = parent.data();
					self.parent.$outer.removeClass('active');
					// self.parent.$dialog.removeClass('active');

					self.submit_parent_close = false;
				}

				self.$elem.prop('disabled', true);

				self.load( url );
			});

		},
		set: function ( options ) {
			this.options = $.extend( {}, $.fn.lightbox.settings, options );
		},

		load: function (url, post, f) {
			var self = this;

			self.fetch( url, post ).done(function( results ) {
				if( results.error ){

					if( !results.message || results.message=='' ){
						results.message = 'Error 400';
					}

					console.log( 'load', results.message );
					// Event.showMsg({text: results.message, load: 1, auto: 1});
					return false;
				}

				self.open( $.extend( {}, self.options, results), f );
			});
		},
		fetch: function(url, getData){
			var self = this;

			var elem_loading = $('<div class="page-loading-wrap"><div class="router-loader"><svg width="100%" height="100%" viewBox="0 0 200 200" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="spinner__spinner"><defs><linearGradient id="spinner" x1="0%" y1="0%" x2="65%" y2="0%"><stop offset="0%" class="stop"></stop> <stop offset="100%" stop-opacity="0" class="stop"></stop></linearGradient></defs><circle cx="100" cy="100" r="90" fill="transparent" stroke="url(#spinner)" stroke-width="20"></circle></svg></div></div>');
			$('body').append( elem_loading );

			return $.ajax({
				url: url,
				data: getData,
				dataType: 'json',
				headers: {
    				"content-type": "application/json",
  				}
			})
			.always(function() {

				elem_loading.fadeOut('fast', function() {
					elem_loading.remove();
				});
			})
			.fail(function() { 
				
				if( typeof self.options.onError==='function' ){
					self.options.onError.apply(self, arguments);
				}
				
				elem_loading.fadeOut('fast', function() {
					elem_loading.remove();

					console.log( 'load', 'Error 400' );
					// Event.showMsg({ text: "Error 400", load: true , auto: true });
				});

				self.$elem.prop('disabled', false);

				// self.close();
			});
		},
		open: function (options, f) {
			var self = this;

			// set options
			self.settings = $.extend( {}, $.fn.lightbox.settings, options );
			// setElemDialog
			
			self.setElemDialog();

			self.resize();
			$(window).resize(function(){
				self.resize();
			});

			if( self.settings.effect ){
				setTimeout(function(){ self.display(); }, 150);
			}
			else{
				self.display();
			}

			if( typeof f==='function' ){

				f.call( {
					onSubmit: function () {
						// return '11';
					}
				} );
				// f( self )
				// f.apply();
			}

			if( typeof self.settings.onComplete==='function' ){
				self.settings.onComplete( self.$dialog );
			}

			// return self;
		},


		newElemDialog: function () {
			var self = this;

			self.classDefault = "model model-dialog outer";

			self.$pop = $('<div>', {class: 'model-container inner'});
			self.$dialog = $('<div>').addClass( self.classDefault ).html(  $('<div>', {class: 'middle'}).html( self.$pop )  ) ;
			self.$doc = $('#doc');


			self.$outer = $('<div>', {class: 'model-outer'});
			self.$outer.data(self);
			self.$background = $('<div>', {class: 'model-background'});
			self.$outer.append( self.$background, self.$dialog );
			
			$('body').append( self.$outer );
		},
		setElemDialog: function () {
			var self = this;

			self.newElemDialog();

			// insert Content
			self.$pop.html( self.setContent( self.settings ) );

			if( self.settings.effect ){
				self.$dialog.addClass( 'effect-' +  self.settings.effect );
			}

			if( self.settings.width ){
				if( self.settings.width=='full'){
					self.settings.width = $(window).width() - 80;
				}
				self.$pop.css("width", self.settings.width);	
			}

			if( self.$pop.find('[data-action=close]').length==0 || self.settings.close ){

				if( self.settings.close!==false ){
					self.$pop.append( $('<button>', { type:"button", 'data-action': 'close' }).addClass('model-close').html( $('<svg viewBox="0 0 8 8" fill="currentColor" width="8" height="8"><path d="M7.2 0L4 3.2.8 0 .1.7 3.3 4 0 7.3l.7.7L4 4.7 7.3 8l.7-.7L4.7 4 7.9.7z"></path></svg>') ) );
				}
			}


			/* -- actions -- */
			/*self.$actions = $('<div>', {class: 'model-actions'});
			self.$pop.append( self.$actions );
			
			if( self.settings.close==true ){
				self.$actions.append( $('<button>', { type:"button", 'data-action': 'close', 'class': 'action close' }).html( $('<i>', {class: 'icon-remove'}) ) );
			}*/

			self.$background.addClass( self.settings.bg || 'black' );
			self.$dialog.addClass( self.settings.bg || 'black' );


			// Event

			self.$background.click(function(evt) {
				if( self.settings.close ){
					self.close();
				}
			});

			self.$dialog.delegate('[data-action]', 'click', function(event) {
				if( self.settings.call ){
					self.settings.call( $(this).attr('data-action'), self.$pop, self );
				}
			});

		},
		setContent: function( s ){
			// content
			var $elem = $( s.form || '<div/>' )
				.addClass("model-content")
				.addClass( s.addClass )
				.addClass( s.style ? 'style-'+s.style: '' );

			// Input hidden
			if( s.hiddenInput ){
				$elem.append( this.setHiddenInput( s.hiddenInput ) );
			}

			// Title
			if( s.title ){
				$elem.append( $('<div/>', {class: 'model-title'}).html(s.title) );
			}

			// Summary
			if( s.summary ){
				$elem.append( $('<div/>', {class: 'model-summary'}).html(s.summary) );
			}

			// Body
			if( s.body ){
				$elem.append( $('<div/>', {class: 'model-body'}).html(s.body) );
			}

			// Buttons
			if( s.button || s.bottom_msg || s.cancel || s.submit ){

				var $btnLeft = $('<div>', {class: 'model-buttons-msg'});
				var $btnRight = $('<div>', {class: 'model-buttons-right'});

				var $btn = $('<div>', {class: 'model-buttons'}).append( $btnLeft, $btnRight );

	            if ( s.bottom_msg ){
	            	$btnLeft.html(s.bottom_msg);
	            }
	            else if ( s.cancel ){
	            	$btnLeft.html( $(s.cancel).attr('data-action', 'close') );
	            }

	            if ( s.button ){
	                $btnRight.append( s.button );
				}else if( s.submit ){
					$btnRight.append( s.submit );
				}

	            $elem.append($btn);
			}

			// Footer
			if( s.footer ){
				$elem.append( $('<div/>', {class: 'model-footer'}).html(s.footer) );
			}

			return $elem;
		},
		setHiddenInput: function( data ){
			return $.map( data, function(obj, i){
				return $('<input/>', {
					// class: 'hiddenInput',
					type: "hidden",
					autoComplete: "off"
				}).attr( obj )[0];
			});
		},
		resize: function(){
			var self = this;

			var area = $(window).height(), margin = 80;

			if( self.settings.height ){

				var height = self.settings.height;
				var overflow = self.settings.overflowY || 'scroll';
				var $inner = self.$pop.find( self.settings.$height || '.model-body' );

				var outer = 0;
					inner = $inner.outerHeight();

				area -= margin;

				outer += self.$pop.find('.model-title').outerHeight();
				outer += self.$pop.find('.model-summary').outerHeight();
				outer += self.$pop.find('.model-buttons').outerHeight();

				if( height=='auto' && (inner+outer)>area ){
					height = parseInt(area-outer);
				}
				else if( height=='full' ) {
					self.$pop.find('.model-body').css('padding', 0);
					height = parseInt(area-outer);
				}

				$inner.css({
					height: height,
					overflowY: overflow
				});
			}

			// console.log( self.$pop.height(), area-margin );
			if( self.$pop.height() > (area-margin) ){
				$('body').addClass('overflow-page');
			}
			else if($('body').hasClass('overflow-page')){
				$('body').removeClass('overflow-page');
			}
			
			// self.resizeHeight();
			var marginTop = ($(window).height()/2) - (self.$pop.height()/2);

			marginTop = marginTop<25 ? 25:marginTop;
			// self.$pop.css( 'margin-top', marginTop);
		},

		display: function () {
			var self = this;

			Event.plugins( self.$dialog );
			var scrollTop = $('html, body').scrollTop();
			if( !$( 'html' ).hasClass('hasModel') ){
				setTimeout(function () {
					$( 'html' ).addClass('hasModel');
				},200);
				// 
				self.$doc.addClass('fixed_elem').css('top', scrollTop*-1 );
			}
			$(window).scrollTop( 0 );

			// show
			self.$outer.addClass('active');
			self.$dialog.addClass("show").addClass('active');
			self.$dialog.data( self );

			// event close
			self.$dialog.find('[data-action=close]').click(function() {
				self.close();
			});


			self.$dialog.delegate('form', 'submit', function(e) {
				
				var fn = self.settings.onSubmit
				if( self.settings.parent_onSubmit_autoClose && self.parent ){
					self.parent.autoClose = true;
				}

				if( typeof fn === 'function' ){
					e.stopPropagation(); e.preventDefault();
					fn( $(this), self );
					// fn.apply(self, arguments);
				}
				else{
					var fn = self.settings.onSave;
					if( typeof fn === 'function' ){
						fn.apply(self, arguments);
					}
				}
				
			});

			self.$dialog.find('[data-action=submit]').click(function(e) {
				if( typeof self.settings.onSubmit === 'function' && self.$dialog.find('form').length==0 ){
					e.stopPropagation(); e.preventDefault();
					self.settings.onSubmit(self);
				}
			});
		},
		close: function ( $el ) {
			var self = this;

			if( self.sleep ) return false;
			var fn = self.settings.onClose;

			var scroll = parseInt( $("#doc").css("top") );
				scroll= scroll < 0 ? scroll*-1:scroll;

			self.$outer.removeClass('active');
			self.$dialog.removeClass("show");

			if( self.parent ){
				self.parent.$outer.addClass('active');
			}
			
			if( typeof fn === 'function' ){
				fn.apply( self, arguments );
			}

			setTimeout( function(){
				self.$outer.remove();
				// self.$dialog.remove();

				if( self.parent ){
					if( self.parent.autoClose ){
						self.parent.close();
					}
				}

				if( $('.model-dialog').length==0 ){
					$('html').removeClass('hasModel');
					$("#doc").removeClass('fixed_elem').css('top', "");
					$('html, body').scrollTop( scroll );
				}

				self.$elem.prop('disabled', false);

			}, 250);
		},

		error: function () {
			
		}
	};

	$.fn.lightbox = function( options ) {
		return this.each(function() {
			var $this = Object.create( Lightbox );
			$this.init( options, this );
			$.data( this, 'lightbox', $this );
		});
	};
	$.fn.lightbox.options = {
		toggle: 1,
	};
	$.fn.lightbox.settings = {
		effect: 5,
		outer: true
	};

	$.lightbox =  function ( a, b, c ) {
		var $this = Object.create( Lightbox );


		var parent = $('.model-outer.active');
		if( parent.length==1 ){

			$this.parent = parent.data();
			$this.parent.$outer.removeClass('active');
			// self.parent.$dialog.removeClass('active');

			$this.submit_parent_close = false;
		}

		if( typeof a==='object' ){
			$this.set( b || {} );
			$this.open( a );
		}
		else {

			if( c ){

				$this.set( c || {} );
				$this.load( a, b || {} );
			}
			else{
				$this.set( b || {} );
				$this.load( a );
			}			
		}
	};
})( jQuery, window, document );