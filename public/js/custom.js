var IS_MAC        = /Mac/.test(navigator.userAgent);

var KEY_A         = 65;
var KEY_COMMA     = 188;
var KEY_RETURN    = 13;
var KEY_ESC       = 27;
var KEY_LEFT      = 37;
var KEY_UP        = 38;
var KEY_P         = 80;
var KEY_RIGHT     = 39;
var KEY_DOWN      = 40;
var KEY_N         = 78;
var KEY_BACKSPACE = 8;
var KEY_DELETE    = 46;
var KEY_SHIFT     = 16;
var KEY_CMD       = IS_MAC ? 91 : 17;
var KEY_CTRL      = IS_MAC ? 18 : 17;
var KEY_TAB       = 9;

var TAG_SELECT    = 1;
var TAG_INPUT     = 2;


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

/* -- ShotAlert -- */
const ShotAlert = {
	init: function (ops) {
		var self = this;
		self.ops = ops;

		if( self.ops.text ){
			self.show();
		}
	},
	_setElem: function (data) {
		var self = this;
		
		var $box = $('#shotalert');
		if( $box.length==0 ){
			$box = $('<div>', {id: 'shotalert', class: 'shotalert'});
			$('body').append($box)
		}

		var ops = data || self.ops;
		// console.log( 'setElem:', ops );

		if( !self.$elem ){
			self.$elem = $('<div>', {role:"alert", class: 'alert-item'});
			$box.append( self.$elem );

			self.$elem.delegate('[role=close]', 'click', function(event) {
				event.preventDefault();

				if( self._autoClose ){
					clearTimeout( self.__autoClose );
				}

				self.hide();
			}); 
		}

		self.is_update = true;
		var wrap = $('<div>', {class: 'alert-msg'});
		self.$elem.html( $('<div>', {class: 'alert-box'}).html( wrap ) );

		if( ops.type ){
			self.$elem.find('.alert-box').addClass( ops.type );

			if( ops.type=='success' || ops.type=='error' || ops.type=='info' ){
				wrap.append( self._icons[ops.type]() );
			}
		}

		if( ops.text ){
			wrap.append( $('<div>', {role: 'text', class: 'alert-text'}).text( ops.text ) );
		}


		if( ops.close ){
			var $last = $('<div>');

			$last.append( $('<button>', {type: 'button', role:'close', class:"alert-close"}).append( self._icons.close() ) );

			wrap.append( $last );
		}

	},
	_icons: {
		success: function () {
			
			return '<svg class="alert-icon" role="icon" focusable="false" aria-label="Success" role="img"><path d="M9 1a8 8 0 1 0 8 8 8 8 0 0 0-8-8zm5.333 4.54l-6.324 8.13a.6.6 0 0 1-.437.23h-.037a.6.6 0 0 1-.425-.176l-3.893-3.9a.6.6 0 0 1 0-.849l.663-.663a.6.6 0 0 1 .848 0L7.4 10.991l5.256-6.754a.6.6 0 0 1 .843-.1l.728.566a.6.6 0 0 1 .106.837z"></path></svg>';
		},

		close: function () {
			
			return '<svg focusable="false" aria-hidden="true" role="img"><path d="M7.77 6.709L5.061 4 7.77 1.291A.75.75 0 1 0 6.709.23L4 2.939 1.291.23A.75.75 0 1 0 .23 1.291L2.939 4 .23 6.709A.75.75 0 1 0 1.291 7.77L4 5.061 6.709 7.77A.75.75 0 1 0 7.77 6.709z"></path></svg>';
		},

		error: function () {
			return '<svg class="alert-icon" role="icon" focusable="false" aria-label="Error" role="img"><path d="M8.564 1.289L.2 16.256A.5.5 0 0 0 .636 17h16.728a.5.5 0 0 0 .5-.5.494.494 0 0 0-.064-.244L9.436 1.289a.5.5 0 0 0-.872 0zM10 14.75a.25.25 0 0 1-.25.25h-1.5a.25.25 0 0 1-.25-.25v-1.5a.25.25 0 0 1 .25-.25h1.5a.25.25 0 0 1 .25.25zm0-3a.25.25 0 0 1-.25.25h-1.5a.25.25 0 0 1-.25-.25v-6a.25.25 0 0 1 .25-.25h1.5a.25.25 0 0 1 .25.25z"></path></svg>'

			// <path d="M10.563 2.206l-9.249 16.55a.5.5 0 0 0 .436.744h18.5a.5.5 0 0 0 .5-.5.494.494 0 0 0-.064-.244l-9.251-16.55a.5.5 0 0 0-.872 0zM12 17.25a.25.25 0 0 1-.25.25h-1.5a.25.25 0 0 1-.25-.25v-1.5a.25.25 0 0 1 .25-.25h1.5a.25.25 0 0 1 .25.25zm0-3.5a.25.25 0 0 1-.25.25h-1.5a.25.25 0 0 1-.25-.25v-6a.25.25 0 0 1 .25-.25h1.5a.25.25 0 0 1 .25.25z" class="spectrum-UIIcon--large"></path>
		},

		info: function () {
			return '<svg class="alert-icon" role="icon" focusable="false" aria-label="Information" role="img"><path d="M9 1a8 8 0 1 0 8 8 8 8 0 0 0-8-8zm-.15 2.15a1.359 1.359 0 0 1 1.431 1.283v.129a1.332 1.332 0 0 1-1.223 1.432 1.444 1.444 0 0 1-.208 0 1.353 1.353 0 0 1-1.432-1.269 1.5 1.5 0 0 1 0-.164 1.359 1.359 0 0 1 1.3-1.412c.047-.002.089-.001.132.001zM11 13.5a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5H8V9h-.5a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V12h.5a.5.5 0 0 1 .5.5z" class="spectrum-UIIcon--medium"></path></svg>'
			// <path d="M11 2a9 9 0 1 0 9 9 9 9 0 0 0-9-9zm-.15 2.65a1.359 1.359 0 0 1 1.431 1.283v.129a1.332 1.332 0 0 1-1.224 1.432 1.444 1.444 0 0 1-.208 0 1.353 1.353 0 0 1-1.431-1.269 1.5 1.5 0 0 1 0-.164 1.359 1.359 0 0 1 1.3-1.412c.047-.002.089-.001.132.001zM13.5 16a.5.5 0 0 1-.5.5H9a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h1v-4H9a.5.5 0 0 1-.5-.5V9a.5.5 0 0 1 .5-.5h2.5a.5.5 0 0 1 .5.5v5.5h1a.5.5 0 0 1 .5.5z" class="spectrum-UIIcon--large"></path>
		},
	},
	_setOps: function (text, type) {
		var options = {
			onClose: function(){},
			auto: true,
		};


		if( typeof text ==='string' ){
			options.text = text;

			if( type ){
				options.type = type;
			}
			
		}else if( typeof text==='object' ){
			options = $.extend( {}, options, text );
		}

		if( options.type == 'success' ){
			options.close = true;
		}

		if( !options.close && !options.auto ){
			options.auto = true;
		}

		return options;
	},

	update: function (text, type) {
		var self = this;

		self.ops = self._setOps(text, type);
		self._setElem();

		return self;
	},

	show: function () {
		var self = this;
		var fn = self.onClose;
		
		if( !self.$elem ){
		 	self._setElem();
		}
		


		if( self.is_update ){

			setTimeout(function() {

				if( !self.$elem ){
					self._setElem();
				}

		 		self.$elem.addClass('show');
		 		self.done();
		 	}, 200);
		}
		else{
			self.$elem.addClass('show');	
			self.done();
		}		
	},

	done: function () {
		var self = this;

		if( self.ops.auto ) {
			self.__autoClose = setTimeout(function() {
	 			self.$elem.removeClass('animate');

	 			self._autoClose();
	 		}, 1300);
 		}
	},

	_autoClose: function () {
		var self = this;
		
		self.__autoClose = setTimeout(function() {
			self.hide();
		}, self.ops.delay || 2800);
	},

	hide: function () {
		var self = this;

		if( self.$elem ){

			if( self.ops.close ){
				self.$elem.removeClass('show');

				setTimeout(function() {
					self.$elem.remove();
					delete self.$elem;
				}, 300);
			}
			else{
				self.$elem.animate({height: 0, opacity: 0}, 200, function () {
					self.$elem.remove();
					delete self.$elem;
					/*
					$(this).removeClass('show');

					console.log( 'hide', self.ops );
					if( self.ops.remove ){
						
					}*/
				});
			}
		}
	}
}
var shotalert = function ( text, type ) {
	// var self = this;

	var alert = Object.create( ShotAlert );
	alert.init( ShotAlert._setOps(text, type) );
	return alert;
};

var Event = {
    getPlugin: function ( name, url ) {
		if( !Cache.plugins[ name ] ){
			Cache.plugins[ name ] = $.getScript( url||Doc.getURL('/js/plugins/' + name +".js" ) );
        }

		return Cache.plugins[ name ];
	},
	setPlugin: function ( $el, plugin, options, url ) {


		var self = this;
		if (typeof $.fn[plugin] !== 'undefined') {
			$el[plugin]( options );
		}
		else{
			self.getPlugin( plugin, url ).done(function () {
				Cache.plugins[ plugin ].status = 1;
                $el[plugin]( options );

			}).fail(function () {
				console.log( 'Is not connect plugin:'+ plugin );
			});
		}
	},
	plugins: function ( $el, _ops ){
		var self = this;
		$elem = $el || $('html');

		$.each( $elem.find('[data-plugins]'), function(){
			var $this = $(this),
				plugins = $this.attr('data-plugins');

			$.each( $this.data('plugins').split('|'), function(i, plugin){
				var options = _ops || {};
				if( $this.attr('data-options') ){
					var ops = $this.attr('data-options').split('|');
					if( $.trim(ops[ i ]) ){
						options = $.parseJSON( $.trim(ops[ i ]) );
					}
				}
				self.setPlugin( $this, $.trim(plugin), options );
			});

			$this.removeAttr('data-plugins').removeAttr('data-options');
		});

		$.each( $elem.find('[data-plugin]'), function(){
			var $this = $(this),
				plugin = $.trim( $this.attr('data-plugin') ),
				options = {};

			if( $this.attr('data-options') ){
				options = $.parseJSON( $this.attr('data-options') );
				$this.removeAttr('data-options');
            }

			$this.removeAttr('data-plugin');
			self.setPlugin( $this, plugin, options );
		});
	},
};
var PHP = {
	number_format: function (number, decimals, dec_point, thousands_sep) {
		// Strip all characters but numerical ones.
	    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
	    var n = !isFinite(+number) ? 0 : +number,
	        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
	        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
	        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
	        s = '',
	        toFixedFix = function (n, prec) {
	            var k = Math.pow(10, prec);
	            return '' + Math.round(n * k) / k;
	        };

	    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
	    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
	    if (s[0].length > 3) {
	        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
	    }
	    if ((s[1] || '').length < prec) {
	        s[1] = s[1] || '';
	        s[1] += new Array(prec - s[1].length + 1).join('0');
	    }

	    return s.join(dec);
	},

	dateJStoPHP: function ( date ) {
		m = date.getMonth()+1;
		m = m < 10 ? '0'+m:m;

		d = date.getDate();
		d = d < 10 ? '0'+d:d;
		return date.getFullYear() + '-' + m + '-' + d;
	}
};
var Cache = {
    plugins: {},
}
var Doc = {
    getURL: function ( path ) {
        return window.location.origin + ( path ? path: '' );
    },
};

function refreshDatatable() {
	// console.log('refreshDatatable');

	var $btn = $('.datatable-header').find('[data-action=refresh]');
	if( $btn.length ){
		$btn.trigger('click');
	}
}

$(document).ready(function(){
    // console.log( PHP, Doc.getURL() );

    function loadPlugins() {
		Event.plugins();
    }

    loadPlugins();

    // loadPlugins(), $(window).load(function(){
    // }), $(window).resize(function() {
	// 	// pageResize();
	// }), $(window).scroll(function() {
	// 	// pageScroll();
	// }), $(window).on(function() {

	// });

	

});
