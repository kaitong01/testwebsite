// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var PageFonts = {
		init: function(options, elem) {
			var self = this;
			self.$elem = $(elem);

			self.options = options;

			self.$elem.find('input[type=radio]').change(function () {				
				var box = $(this).closest('.font-module').addClass('font-active').siblings().removeClass('font-active');
				self.save($(this).val());
			});

			self.$elem.find('.font-module').click(function () {
				var $input = $(this).find('input[type=radio]');
				$input.prop('checked', true);

				$(this).parent().addClass('font-active').siblings().removeClass('font-active');
				self.save($input.val());
			});

		},

		save: function ( id ) {
			var self = this;

			console.log( self.options );
		
			var is_loader = false;

			var t = setTimeout(function () {
				
				is_loader = true;

			}, 1300);

			$.ajax({
				type: "POST",
				url: '/business/save/fontsave',
				data: {font_id: id},
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				dataType: 'json'
			})
			.always(function() { 

				clearTimeout( t );				
				
			})			

		}
	}

	$.fn.page_fonts = function( options ) {
		return this.each(function() {
			var $this = Object.create( PageFonts );
			$this.init( options, this );
			$.data( this, 'page_fonts', $this );
		});
	};
	
})( jQuery, window, document );