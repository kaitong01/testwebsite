// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var seriesForm = {
		init: function (options, elem) {
			var self = this;

			self.options = $.extend( {}, $.fn.seriesForm.defaults, options );
            self.$elem = $(elem);
            self.$container = $( self.options.container );

            self.top = self.$elem.find('[role=content]').offset().top + 24;


            // self.$elem.submitForm({

            //     success:function () {
            //         console.log("success");
            //     },
            //     error:function () {
            //         console.log("error");
            //     },
            //     complete: function () {
            //         console.log("complete");
            //     }
            // });

            self.$elem.find('.section-nav').css({
                position: 'fixed',
                top:self.top
            })

            self.$elem.find('[role=actions]').css({
                position: 'fixed',
                width:  self.$elem.find('[role=content]').outerWidth(),
                bottom: 0,
                zIndex: 5,
                background: '#fbfbfb',
                padding: '15px 18px',
                borderTop: '1px solid rgba(0,0,0,.1)',
                left:self.$elem.find('[role=content]').offset().left,
            });

            self.$elem.find('[data-section-action]').click(function (e) {
                e.preventDefault();

                var $section = self.$elem.find('[data-section-id='+ $(this).attr('data-section-action') +']');

                if( $section.length ){
                    self.$container.animate({scrollTop: $section.offset().top - (self.top) }, '500');
                }
            });

            self.$elem.find('#days').bind('change keyup', function () {
                let val = parseInt($(this).val()) || 0;
                let sectionPeriod = self.$elem.find('[data-section-id=period]>.business-settings-section').data('seriesPeriodsForm');

                if( sectionPeriod ){
                    sectionPeriod.options.period_days = val;
                }
            });
        }

	}
	$.fn.seriesForm = function( options ) {
		return this.each(function() {
			var $this = Object.create( seriesForm );
			$this.init( options, this );
			$.data( this, 'seriesForm', $this );
		});
	};
	$.fn.seriesForm.defaults = {
        loadThrottle: 300,
        container: 'html, body',
	}


})( jQuery, window, document );
