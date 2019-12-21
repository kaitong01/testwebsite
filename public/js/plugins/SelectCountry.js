// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var SelectCountry = {
		init: function (options, elem) {
			var self = this;

			self.cogs = $.extend( {}, $.fn.SelectCountry.defaults, options );
			self.$elem = $(elem);

        },

	}
	$.fn.SelectCountry = function( options ) {
		return this.each(function() {
			var $this = Object.create( SelectCountry );
			$this.init( options, this );
			$.data( this, 'SelectCountry', $this );
		});
	};
	$.fn.SelectCountry.defaults = {
	}

})( jQuery, window, document );
