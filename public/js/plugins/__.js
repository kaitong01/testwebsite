// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var pluginname = {
		init: function (options, elem) {
			var self = this;

			self.settings = $.extend( {}, $.fn.pluginname.defaults, options );
			self.$elem = $(elem);

        },

	}
	$.fn.pluginname = function( options ) {
		return this.each(function() {
			var $this = Object.create( pluginname );
			$this.init( options, this );
			$.data( this, 'pluginname', $this );
		});
	};
	$.fn.pluginname.defaults = {
	}

})( jQuery, window, document );
