// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var input__number = {
		init: function (options, elem) {
            var self = this;

			self.options = options;
            self.$elem = $(elem);

			self.$elem.attr('type', 'text').addClass('inputnum');
			self.set();

			// Event
			self.$elem.keydown( function(e) {

				// Allow: backspace, delete, tab, escape, enter and .
		        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
		             // Allow: Ctrl/cmd+A
		            (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
		             // Allow: Ctrl/cmd+C
		            (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
		             // Allow: Ctrl/cmd+X
		            (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
		             // Allow: home, end, left, right
		            (e.keyCode >= 35 && e.keyCode <= 39)) {
		                 // let it happen, don't do anything
		                 return;
		        }

		        if( e.ctrlKey && e.keyCode==86 ){

		        }
		        // Ensure that it is a number and stop the keypress
		        else if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
		            e.preventDefault();
		        }

			}).click(function () {

				if( self.$elem.val()!='' ){
					self.$elem.select();
				}

			}).keyup(function(e) {
				self.set();

			}).blur('blur', function(e) {
				self.set();
			});
		},
		set: function () {
			var self = this;

			if( self.$elem.val()!='' ){
				self.$elem.val( PHP.number_format( self.$elem.val() ) );
			}
		},

		get_numbers: function (input) {
			var number = input.match(/[0-9]+/g);
			if( number ){
				number = number.join([]);
			}
			return number;
		}

	};


	$.fn.input__number = function( options ) {
		return this.each(function() {
			var $this = Object.create( input__number );
			$this.init( options, this );
			$.data( this, 'input__number', $this );
		});
	};

})( jQuery, window, document );
