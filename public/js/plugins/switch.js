// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var Switch = {
		init: function (options, elem) {
			var self = this;

			self.cogs = $.extend( {}, $.fn.switch.defaults, options );
            self.$elem = $(elem);

            if( !self.cogs.url ){
                return false;
            }

            self.alert = shotalert();
            self.name = self.$elem.attr('name');

            self.data = $.extend( {}, {
                _token: $('meta[name=csrf-token]').attr('content'),
                _method: 'POST',
            }, self.cogs.data );

            self.$elem.change(function (e) {


                self.data[self.name] = $(this).prop('checked') ? 1: 0;

                if( self.cogs.logged ){
                    e.preventDefault();
                }
                else{
                    self.save();
                }
            });


        },

        save: function (delay, fn) {
            var self = this;

            // var formData = new FormData();

            // $.each( self.data, function (name, value) {
            //     formData.append(name, value);
            // });

            if( self.alert ){ self.alert.hide(); }

            setTimeout(function () {

                $.ajax({
                    url: self.cogs.url,
                    type: 'POST',
                    dataType: 'json',
                    data: self.data,

                    // headers: {
                    //     "Accept": "application/json",
                    // }
                })
                .done(function( res ) {


                    if( res.message ){
                        self.showMessage( res.message, res.code==200 ? 'success': 'error' );
                    }

                    if( res.alert && typeof Swal === 'function' ){
                        Swal.fire( self.convertAlert( res.alert ) );
                    }

                    if( res.data ){
                        self.data = $.extend( {}, self.data, res.data );
                    }
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
	$.fn.switch = function( options ) {
		return this.each(function() {
			var $this = Object.create( Switch );
			$this.init( options, this );
			$.data( this, 'switch', $this );
		});
	};
	$.fn.switch.defaults = {
        logged: false,
	}

})( jQuery, window, document );
