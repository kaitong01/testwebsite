// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var StoreProductGrid = {
		init: function (options, elem) {
			var self = this;

			self.options = $.extend( {}, $.fn.storeProductGrid.defaults, options );
            self.$elem = $(elem);
            self.$container = $( self.options.container );
            self.$listsbox = self.$elem.find('[role=listsbox]');

            console.log( self.options );
        }
	}
	$.fn.storeProductGrid = function( options ) {
		return this.each(function() {
			var $this = Object.create( StoreProductGrid );
			$this.init( options, this );
			$.data( this, 'storeProductGrid', $this );
		});
	};
	$.fn.storeProductGrid.defaults = {
        loadThrottle: 300,
        data: [],
        container: 'html, body',


        width: 128

	}


})( jQuery, window, document );
