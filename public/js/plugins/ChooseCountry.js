// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {


    var debounce = function(fn, delay) {
		var timeout;
		return function() {
			var self = this;
			var args = arguments;
			window.clearTimeout(timeout);
			timeout = window.setTimeout(function() {
				fn.apply(self, args);
			}, delay);
		};
    };

    // var scoreValue = function(value, token) {
    //     var score, pos;

    //     if (!value) return 0;
    //     value = String(value || '');
    //     pos = value.search(token.regex);
    //     if (pos === -1) return 0;
    //     score = token.string.length / value.length;
    //     if (pos === 0) score += 0.5;
    //     return score;
    // };

	var ChooseCountry = {
		init: function (options, elem) {
            var self = this;



			self.cogs = $.extend( {}, $.fn.ChooseCountry.defaults, options );
            self.$elem = $(elem);


            $.extend(self, {
                onSearchChange   : self.cogs.loadThrottle === null ? self.onSearchChange : debounce(self.onSearchChange, self.cogs.loadThrottle)
            });

            self.$items = self.$elem.find('[action-country=item]');
            self.$selected = self.$elem.find('[role-country=selected]');
            self.$listbox = self.$elem.find('[role-country=listbox]');

            self.$searchbox = self.$elem.find('[role-country=searchbox]');

            self.$elem.delegate('[action-country=item]', 'click', function (e) {
                e.preventDefault();

                $(this).toggleClass('active');
                var is = $(this).hasClass('active');
                var id = $(this).attr('country-id');

                if( is ){
                    let $item = $(this).clone();

                    $item.append( $('<input>', {type: 'hidden', name: 'country[]', value: id}) );
                    self.$selected.append( $item );
                }
                else{
                    self.$selected.find('[country-id='+ id +']').remove();
                    self.$listbox.find('[country-id='+ id +']').removeClass('active');
                }


                self.$elem.find('[ref-country=count]').text( self.$selected.find('>li').length )
            });


            self.$searchbox.keyup(function (e) {
                self.onSearchChange();
            }).change(function (e) {
                self.onSearchChange();
            });;
        },

        onSearchChange: function () {
            var self = this;

            let val =  $.trim(self.$searchbox.val());

            if( val=='' ){
                self.$items.removeClass('d-none');
                return;
            }

            $.each(self.$items, function () {
                let text = $(this).find('.country-text').text();
                let subtext = $(this).find('.country-subtext').text();

                if( text.search( val )>=0 || text.toLowerCase().search( val )>=0 || (subtext!=''&&subtext.search(val)>=0) ){
                    $(this).removeClass('d-none');
                }
                else{
                    $(this).addClass('d-none');
                }
            });
        }

	}
	$.fn.ChooseCountry = function( options ) {
		return this.each(function() {
			var $this = Object.create( ChooseCountry );
			$this.init( options, this );
			$.data( this, 'ChooseCountry', $this );
		});
	};
	$.fn.ChooseCountry.defaults = {
        loadThrottle: 300
	}

})( jQuery, window, document );
