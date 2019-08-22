// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var seriesFilesForm = {
		init: function (options, elem) {
			var self = this;

			self.options = $.extend( {}, $.fn.seriesFilesForm.defaults, options );
            self.$elem = $(elem);
            self.$container = $( self.options.container );

            self.$upload = self.$elem.find('[type=file]');
            self.$choosefile = self.$elem.find('.btn-choosefile');
            self.name = self.$upload.attr('name');

            self.$name = self.$elem.find('[role=name]');
            self.$label = self.$elem.find('[role=label]');
            self.$remove = self.$elem.find('[role=remove]');

            // console.log( self.options );

            self.$upload.change(function (e) {
                // e.preventDefault();
                let file = this.files[0];

                if( file ){

                    self.hasFile( file.name );
                }
            });

            self.$elem.find('[data-action]').click(function (evt) {
                evt.preventDefault();

                var action = $(this).attr('data-action');

                if( action=='remove' ){

                    self.$label.removeClass('d-none');
                    self.$name.attr('type', 'hidden').removeClass('form-control').val('');

                    self.$elem.find('[data-action=remove]').addClass('d-none');
                    self.$choosefile.removeClass('d-none');

                    self.$upload.val('');
                    // self.$text.text( self.options.label );

                    if( self.options.src ){

                        self.$remove.prop('disabled', false);
                        self.$elem.find('[data-action=undo]').removeClass('d-none');
                        // self.$text.append( $('<input>', {type: 'hidden', class: 'hidden_elem', name: '_'+self.name, value: 1}) );
                    }
                }

                if( action=='undo' && self.options.src ){


                    self.hasFile( self.options.name  );
                }
            });

            if( self.options.src ){
                self.hasFile( self.options.name );
                // self.$text.text( self.options.data );
            }
            // self.$listsbox = self.$elem.find('[role=listsbox]');
        },

        hasFile:function ( name ) {
            var self = this;

            self.$label.addClass('d-none');
            self.$name.attr('type', 'text').addClass('form-control').val( name );

            self.$elem.find('[data-action=remove]').removeClass('d-none');
            self.$choosefile.addClass('d-none');

            if( self.options.src ){
                self.$remove.prop('disabled', true);
                self.$elem.find('[data-action=undo]').addClass('d-none');
            }
        }
	}
	$.fn.seriesFilesForm = function( options ) {
		return this.each(function() {
			var $this = Object.create( seriesFilesForm );
			$this.init( options, this );
			$.data( this, 'seriesFilesForm', $this );
		});
	};
	$.fn.seriesFilesForm.defaults = {
        loadThrottle: 300,
        // data: [],
        container: 'html, body',
	}


})( jQuery, window, document );

var reFormSeries = function (data) {
    console.log( 'reFormSeries' );
}
