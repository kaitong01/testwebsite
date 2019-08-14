// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var FormStaps = {
		init: function (options, elem) {
			var self = this;

			self.options = $.extend( {}, $.fn.formstaps.defaults, options );
			self.$elem = $(elem);
			

			self.$section = self.$elem.find('[data-stap-section]');
			self.$nav = self.$elem.find('[data-stap-action]');

			self.$elem.find('.form-staps-content').css({
				minHeight: self.$elem.find('.form-staps-content').outerHeight(),
				// overflowY: 'auto'
			});

			self.$nav.click(function(evt) {
				evt.preventDefault();

				var index = $(this).index();


				self.$nav.eq( index ).addClass('active').siblings().removeClass('active');
				self.$section.eq( index ).addClass('active').siblings().removeClass('active');


			});
		}
		
	}
	$.fn.formstaps = function( options ) {
		return this.each(function() {
			var $this = Object.create( FormStaps );
			$this.init( options, this );
			$.data( this, 'formstaps', $this );
		});
	};
	$.fn.formstaps.defaults = {
	}
	

})( jQuery, window, document );
	