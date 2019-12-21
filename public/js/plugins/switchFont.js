// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var switchFont = {
		init: function (options, elem) {
			var self = this;

			self.cogs = $.extend( {}, $.fn.switchFont.defaults, options );
            self.$elem = $(elem);
            self.url = '/site/fonts';

            self.alert = shotalert();

            self.$elem.find(':input').change(function (e) {

                let li = $(this).closest('li');
                self.data = {
                    font_id: $(this).val()
                }

                li.addClass('active').siblings().removeClass('active');

                self.update();
            });
        },

        update:function ( delay ) {
            var self = this;

            if( self.alert ){ self.alert.hide(); }

            setTimeout(function () {

                $.ajax({
                    url: self.url,
                    type: 'POST',
                    dataType: 'json',
                    data: self.data,

                })
                .done(function( res ) {


                    if( res.message ){
                        self.showMessage( res.message, res.code==200 ? 'success': 'error' );
                    }

                    if( res.alert && typeof Swal === 'function' ){
                        Swal.fire( self.convertAlert( res.alert ) );
                    }

                    // if( res.data ){
                    //     self.data = $.extend( {}, self.data, res.data );
                    // }
                })
                .fail(function() {
                    // console.log("error");
                })
                .always(function() {
                    // console.log("complete");
                });
            }, delay||1);
        },
        showMessage: function (data, type) {
            var self = this, text = '';

			if(  typeof data === 'object' ){
				if( data.text ){
					text = data.text;
					type = data.type;
				}
				else{
					text = data[0];
					type = data[1];
				}
			}
			else{
				text = data;
			}


			self.alert.update(text, type).show();
        },
        convertAlert:function ( ops ) {
			var options = {};

			if( typeof ops === 'string' ){

				ops = ops.split(',');

				if( ops[0] ){
					options.title = ops[0];
				}

				if( ops[1] && !ops[2] ){
					options.type = ops[1];
				}else if( ops[1] ){
					options.text = ops[1];

					if( ops[2] ){
						options.type = ops[2];
					}
				}

				return options;

			}else if( typeof ops==='object' ){

				if( ops.title ){
					return ops;
				}
				else{

					if( ops[0] ){
						options.title = ops[0];
					}

					if( ops[1] && !ops[2] ){
						options.type = ops[1];
					}else if( ops[1] ){
						options.text = ops[1];

						if( ops[2] ){
							options.type = ops[2];
						}
					}

					return options;
				}
			}
        }

	}
	$.fn.switchFont = function( options ) {
		return this.each(function() {
			var $this = Object.create( switchFont );
			$this.init( options, this );
			$.data( this, 'switchFont', $this );
		});
	};
	$.fn.switchFont.defaults = {
	}

})( jQuery, window, document );
