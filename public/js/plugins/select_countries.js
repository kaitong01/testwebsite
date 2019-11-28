// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var select_countries = {
		init: function (options, elem) {
			var self = this;

			self.options = $.extend( {}, $.fn.select_countries.defaults, options );
			self.$elem = $(elem);


			$.ajax({
				url: '/apidata/countries',
				type: 'GET',
				dataType: 'json',
				data: {param1: 'value1'}
			})
			.done(function(data) {

					$.each(data, function(index, obj) {
						self.$elem.append( $('<option>', {value: obj.country_id}).text(obj.country_name) );
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
	$.fn.select_countries = function( options ) {
		return this.each(function() {
			var $this = Object.create( select_countries );
			$this.init( options, this );
			$.data( this, 'select_countries', $this );
		});
	};
	$.fn.select_countries.defaults = {
		loadThrottle: 300,
	}


})( jQuery, window, document );
