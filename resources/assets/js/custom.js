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
