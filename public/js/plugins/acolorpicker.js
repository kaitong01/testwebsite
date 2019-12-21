// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {


	var acolorpicker = {
		init: function (options, elem) {
			var self = this;

			self.settings = $.extend( {}, $.fn.acolorpicker.defaults, options );
			self.$elem = $(elem);
            

            // edit 
            
            self.$preview = self.$elem.find('#preview');
            self.colorinputs = self.$elem.find('.colorpicker');

            
            $.getScript( '/assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js' ).done(function () {
                
                self.colorinputs.colorpicker() // เรียกใช้ plugin
                
                .on('changeColor', function(e) {
                    self.updateTheme();
                });
            });

            self.updateTheme();
        },
        
        // edit 
        updateTheme: function () {
            var self = this;

            $.each(self.colorinputs, function () {
                
                var color = $(this).val();
                var role = $(this).attr('data-role');
                
                var type = $(this).attr('data-type') || 'background';
                var css = {};
                
                
                css[ type ] = color;
                
                self.$preview.find('[role=' +role+ ']').css(css);
                
            })
 
         }
		
	}
	$.fn.acolorpicker = function( options ) {
		return this.each(function() {
			var $this = Object.create( acolorpicker );
			$this.init( options, this );
			$.data( this, 'acolorpicker', $this );
		});
	};
	$.fn.acolorpicker.defaults = {
		loadThrottle: 300,
	}

})( jQuery, window, document );
	