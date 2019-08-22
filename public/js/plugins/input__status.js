// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var input__status = {
		init: function (options, elem) {
            var self = this;

			self.options = options;
            self.$elem = $(elem);

            self.$elem.addClass('input-status');

			// Event
			self.$elem.change(function (e) {
                e.preventDefault();

                self._change();
            });

            self._change();
		},

        _change: function () {
            let self = this;

            let val = self.$elem.val();
            self.$elem.removeClass('primary').removeClass('danger');


            switch ( parseInt(val)  ) {
                case 1:
                    self.$elem.addClass('primary');
                    break;

                case 2:
                    self.$elem.addClass('danger');
                    break;

                default:
                    break;
            }
        }
	};


	$.fn.input__status = function( options ) {
		return this.each(function() {
			var $this = Object.create( input__status );
			$this.init( options, this );
			$.data( this, 'input__status', $this );
		});
	};

})( jQuery, window, document );
