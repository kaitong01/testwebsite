 // Utility
 if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {


	var officehours = {
		init: function ( options, elem ) {
			var self = this;

			self.settings = $.extend({}, $.fn.officehours.settings, options);
			self.$elem = $(elem);
            self.$container = $( self.settings.container );

            self.$elem.find('[data-action=check]').change(function (e) {
                self.change();
            });

            self.$elem.find('[data-action=checkbox]').change(function (e) {
                // e.preventDefault();

                var $parent = $(this).closest('tr');

                var is = $(this).prop('checked');
                $parent.find('table').find(':input').prop('disabled', !is);

                if(is){
                    if($parent.find('table').find(':input[aria-id=start]').val()==''){
                        $parent.find('table').find(':input[aria-id=start]').val( self.settings.defaultTime[0] )
                    }

                    if($parent.find('table').find(':input[aria-id=end]').val()==''){
                        $parent.find('table').find(':input[aria-id=end]').val( self.settings.defaultTime[1] )
                    }
                }
                else{

                    $parent.find('table').find(':input[aria-id=start], :input[aria-id=end]').val('');
                }
            });

            // self.$elem.find(':input[data-action=check]:checked').tit('');

            self.change();

        },

        change: function () {
            var self = this;

            var val = self.$elem.find(':input[data-action=check]:checked').val();
            self.$elem.find('[role=content]').toggleClass('d-none', val!=2)

        }
	};

	$.fn.officehours = function( options ) {
		return this.each(function() {
			var $this = Object.create( officehours );
			$this.init( options, this );
			$.data( this, 'officehours', $this );
		});
	};

	$.fn.officehours.settings = {
        container: 'html, body',

        defaultTime: ['09:00', '17:00']
	};

})( jQuery, window, document );
