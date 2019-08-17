 // Utility
 if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var BusinessSeo = {
		init: function ( options, elem ) {
			var self = this;

			self.settings = $.extend({}, $.fn.BusinessSeo.settings, options);
			self.$elem = $(elem);
            self.$container = $( self.settings.container );

            self.$preview = self.$elem.find('[role=preview]');

            self.$elem.find(':input#seo_title').bind('change keyup', function () {

                self.$preview.find('.title').text( $.trim($(this).val()) );
            });

            self.$elem.find(':input#seo_description').bind('change keyup', function () {
                self.$preview.find('.description').text( $.trim($(this).val()) );
            });




            // self.$elem.find('input#seo_keywords').selectize({
            //     create: true,
            //     plugins: ['remove_button'],
            //     delimiter: ',',
            //     persist: false,
            //     openOnFocus: false,

            //     onInitialize: function () {
            //         var that = this;

            //         this.$control.on("click", function () {
            //             that.ignoreFocusOpen = true;
            //             setTimeout(function () {
            //                 that.ignoreFocusOpen = false;
            //             }, 50);
            //         });
            //     },

            //     onFocus: function () {
            //         if (!this.ignoreFocusOpen) {
            //             this.open();
            //         }
            //     }
            // });
            // //  data-options="<?= htmlentities(Fn::stringify( ['create'=>true,  'delimiter' => ',', 'persist'=> false, 'openOnFocus'=> false,] ) )?>"
            // //  data-plugin="selectize"
            // console.log(self.settings)
        },

	};

	$.fn.BusinessSeo = function( options ) {
		return this.each(function() {
			var $this = Object.create( BusinessSeo );
			$this.init( options, this );
			$.data( this, 'BusinessSeo', $this );
		});
	};

	$.fn.BusinessSeo.settings = {
        container: 'html, body',


	};

})( jQuery, window, document );
