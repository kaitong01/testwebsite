// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var choose_wholesale = {
		init: function (options, elem) {
			var self = this;

			self.options = $.extend( {}, $.fn.choose_wholesale.defaults, options );
			self.$elem = $(elem);

			self.$elem.find('[data-wholesale]').click(function(event) {
					var wholesale = parseInt($(this).data('wholesale')) ;
					const newClone = $(this).clone();
						self.$elem.find('.show-wholesale').append(newClone);
						$(newClone).attr('data-type',2);
						$(newClone).append('<input type="hidden" name="wholesale_id[]" value="'+wholesale+'">')
						$(this).hide();
			});

		  self.$elem.delegate('[data-type]', 'click', function(event) {
					var wholesale = parseInt($(this).data('wholesale')) ;
					self.$elem.find('[data-wholesale='+wholesale+']').show();
					$(this).remove();
				});

			if(options.data){
				$.each(options.data, function(index, el) {

					self.$elem.find('[data-wholesale='+options.data[index]+']').hide();
					const newClone = self.$elem.find('[data-wholesale='+options.data[index]+']').clone();
						self.$elem.find('.show-wholesale').append(newClone);
						$(newClone).attr('data-type',2);
						$(newClone).append('<input type="hidden" name="wholesale_id[]" value="'+options.data[index]+'">')
						$(newClone).show();

				});
			}

			console.log( self.options );
		}

	}
	$.fn.choose_wholesale = function( options ) {
		return this.each(function() {
			var $this = Object.create( choose_wholesale );
			$this.init( options, this );
			$.data( this, 'choose_wholesale', $this );
		});
	};
	$.fn.choose_wholesale.defaults = {
		loadThrottle: 300,
	}


})( jQuery, window, document );
