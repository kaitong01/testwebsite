// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var SitePage = {
		init: function (options, elem) {
			var self = this;

			self.cogs = $.extend( {}, $.fn.SitePage.defaults, options );
			self.$elem = $(elem);
            self.$listbox = self.$elem.find('[role=listbox]');

            if( typeof dragula !=='function'  ){
                $.getScript( '/js/plugins/dragula.js' ).done(function () {
                    self.actionMove();
                });
            }
            else{
                self.actionMove();
            }

            self.$elem.find('[data-action]').click(function (e) {
                e.preventDefault();


                let action = $(this).attr('data-action');
                let tr = $(this).closest('tr');

                if( action=='up' ){
                    let prev = tr.prev();

                    prev.before(tr);
                }

                if( action=='down' ){
                    let next = tr.next();

                    next.after(tr);
                }

                self.sort();
                self.update();
            });
        },

        sort: function () {
            var self = this;

            self.ids = [];
            self.types = [];
            let seq = 1;
            $.each( self.$listbox.find('>tr'), function () {

                seq++;
                let id = $(this).attr('data-id');
                let type = $(this).attr('data-type');
                $(this).find('.td-seq').text( seq );

                self.ids.push(id);
                self.types.push(type);
            } );
        },

        update:function () {
            var self = this;


            $.post("/site/menu/sort", {
                ids: self.ids,
                types: self.types,
                _token: $('meta[name=csrf-token]').attr('content'),
                _method: 'POST',
            },
                function (data, textStatus, jqXHR) {
                    console.log( data, textStatus, jqXHR );

                    if( data.ids ){

                        let trs = self.$listbox.find('>tr');

                        $.each( data.ids, function (index, id) {
                            trs.eq(index).attr('data-id', id)
                        });
                    }
                },
                "json"
            );
        },

        actionMove:function () {
            var self = this;


            dragula([self.$listbox[0]], {
                moves: function (el, container, handle) {

                    return handle.classList.contains('handle');
                }

            }).on('drag', function(el) {

                  $(el).addClass('dragula-table')

            }).on('dragend', function(el) {

                  $(el).removeClass('dragula-table');

                  window.setTimeout(function() {

                    self.sort();
                    self.update();
                  }, 100);
            });
        }

	}
	$.fn.SitePage = function( options ) {
		return this.each(function() {
			var $this = Object.create( SitePage );
			$this.init( options, this );
			$.data( this, 'SitePage', $this );
		});
	};
	$.fn.SitePage.defaults = {
	}

})( jQuery, window, document );
