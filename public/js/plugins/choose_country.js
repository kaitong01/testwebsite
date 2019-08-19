// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var choose_country = {
		init: function (options, elem) {
			var self = this;

			self.options = $.extend( {}, $.fn.choose_country.defaults, options );
			self.$elem = $(elem);

			self.$elem.find('[data-country]').click(function(event) {
					var country = parseInt($(this).data('country')) ;
					const newClone = $(this).clone();
						self.$elem.find('.show-country').append(newClone);
						$(newClone).attr('data-type',2);
						$(newClone).append('<input type="hidden" name="country_id[]" value="'+country+'">')
						$(this).hide();
			});

		  self.$elem.delegate('[data-type]', 'click', function(event) {
					var country = parseInt($(this).data('country')) ;
					self.$elem.find('[data-country='+country+']').show();
					$(this).remove();
				});
			console.log( self.options );
		}

	}
	$.fn.choose_country = function( options ) {
		return this.each(function() {
			var $this = Object.create( choose_country );
			$this.init( options, this );
			$.data( this, 'choose_country', $this );
		});
	};
	$.fn.choose_country.defaults = {
		loadThrottle: 300,
	}


})( jQuery, window, document );
