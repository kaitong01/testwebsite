// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var select_route = {
		init: function (options, elem) {
			var self = this;

			self.options = $.extend( {}, $.fn.select_route.defaults, options );
			self.$elem = $(elem);


			$.ajax({
				url: '/apidata/tourroute',
				type: 'GET',
				dataType: 'json',
				data: {param1: 'value1'}
			})
			.done(function(data) {

					$.each(data, function(index, obj) {
			
						self.$elem.append( $('<option>', {value: obj.id}).text(obj.name) );
						// if(obj.country_id == self.options.id){
						// 		self.$elem.append( $('<option>', {value: obj.country_id}).text(obj.country_name) );
						// }else{
						//
						// }

					});

					self.$elem.val( self.options.id );
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});




		}

	}
	$.fn.select_route = function( options ) {
		return this.each(function() {
			var $this = Object.create( select_route );
			$this.init( options, this );
			$.data( this, 'select_route', $this );
		});
	};
	$.fn.select_route.defaults = {
		loadThrottle: 300,
	}


})( jQuery, window, document );
