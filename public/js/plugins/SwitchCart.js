// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var SwitchCart = {
		init: function (options, elem) {
			var self = this;

			self.data = $.extend( {}, $.fn.SwitchCart.defaults, options );
            self.$elem = $(elem);

            self.$elem.addClass('btn-cart');
            self.$elem.append('<div class="loader"><div></div><div></div><div></div></div>');


            self.url = '/carts/switch';
            self.alert = shotalert();

            self.$elem.click(function (e) {
                e.preventDefault();


                self.update( 200 );
            });

        },

        update: function (delay, fn) {
            var self = this;

            self.$elem.removeClass('btn-error');
            self.$elem.prop('disabled', true).addClass('loading');
            if( self.alert ) self.alert.hide();

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

                    if( res.error ){
                        return false;
                    }

                    if( res.data ){

                        self.$elem.removeClass('btn-primary').addClass('btn-warning');
                        self.$elem.find('i').removeClass('fa-plus').addClass('fa-check');
                        self.$elem.find('span').text('อยู่ในตะกร้าแล้ว');

                        // return false;
                    }
                })
                .fail(function() {

                    self.$elem.addClass('btn-error');

                    self.alert.update({
						text: 'เกิดข้อผิดพลาด, กรุณาลองใหม่',
						type: 'error',
						close: true,
						auto: true
                    }).show();

                    // console.log("error");
                })
                .always(function() {
                    self.$elem.prop('disabled', false).removeClass('loading');
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
	$.fn.SwitchCart = function( options ) {
		return this.each(function() {
			var $this = Object.create( SwitchCart );
			$this.init( options, this );
			$.data( this, 'SwitchCart', $this );
		});
	};
	$.fn.SwitchCart.defaults = {}

})( jQuery, window, document );
