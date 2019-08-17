 // Utility
 if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var TableContact = {
		init: function ( options, elem ) {
			var self = this;

			self.settings = $.extend({}, $.fn.TableContact.settings, options);
			self.$elem = $(elem);
            self.$container = $( self.settings.container );

            self.$elem.delegate('[data-action]', 'click', function (e) {
                e.preventDefault();

                var evt = $(this).attr('data-action');

                var $parent = $(this).closest('tr');
                var max = parseInt($parent.parent().attr('data-max')) || 1;
                var length = $parent.siblings().length + 1;

                if( evt=='add' && length < max ){

                    var item = $parent.clone();
                    item.find(':input[type=text]').val('');

                    $parent.after( item );
                    item.find(':input[type=text]').first().focus();
                }

                if( evt=='del' ){

                    if( length==1 ){
                        $parent.find(':input[type=text]').first().focus();
                    }
                    else{
                        $parent.remove();
                    }
                }

                if( evt=='up' && $parent.prev().length==1 ){
                    $parent.prev().before($parent);
                }

                if( evt=='down' && $parent.next().length==1 ){
                    $parent.next().after($parent);
                }

            });
        },

        change: function () {
            var self = this;

            var val = self.$elem.find('[data-action=check]:checked').val();

            self.$elem.find('[role=content]').toggleClass('d-none', val!=2)

        }
	};

	$.fn.TableContact = function( options ) {
		return this.each(function() {
			var $this = Object.create( TableContact );
			$this.init( options, this );
			$.data( this, 'TableContact', $this );
		});
	};

	$.fn.TableContact.settings = {
        container: 'html, body',

        defaultTime: ['09:00', '17:00']
	};

})( jQuery, window, document );
