// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var choose_product = {
		init: function (options, elem) {
			var self = this;

			self.options = $.extend( {}, $.fn.choose_product.defaults, options );
			self.$elem = $(elem);
			self.$elem.find('.cart-btn').click(function(event) {
				var url = options.url
				var ids = options.id;

				// $.ajax({
				// 	url: '/path/to/file',
				// 	type: 'default GET (Other values: POST)',
				// 	dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
				// 	data: {param1: 'value1'}
				// })
				// .done(function() {
				// 	console.log("success");
				// })
				// .fail(function() {
				// 	console.log("error");
				// })
				// .always(function() {
				// 	console.log("complete");
				// });

				$.ajax({

					url:url ,
					data:{id:ids},
					method:'GET',
					dataType: 'json',
					success:function(data){
								console.log(data);
								if(data.status==1){
									self.$elem.find('.cart-btn').removeClass('btn-primary').addClass('btn-info');
									self.$elem.find('.span-cart').html('<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"><path d="M20.285 2l-11.285 11.567-5.286-5.011-3.714 3.716 9 8.728 15-15.285z"/></svg> <span class="ml-1">เพิ่มแล้ว</span>');
								}else if(data.status==0){
									self.$elem.find('.cart-btn').removeClass('btn-info').addClass('btn-primary');
									self.$elem.find('.span-cart').html('<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"><path d="M2 5v2h3v3h2V7h3V5H7V2H5v3H2z"></path></svg><span class="ml-1">เพิ่มลงในตะกร้า</span>');
								}else{

								}

					}
				});

			});

			console.log( self.options );
		}

	}
	$.fn.choose_product = function( options ) {
		return this.each(function() {
			var $this = Object.create( choose_product );
			$this.init( options, this );
			$.data( this, 'choose_product', $this );
		});
	};
	$.fn.choose_product.defaults = {
		loadThrottle: 300,
	}


})( jQuery, window, document );
