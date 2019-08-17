// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {


	var SwitchCompany = {
        init: function (options, elem) {
            var self = this;

			self.$elem = $(elem);
            // self.set( $.extend( {}, $.fn.lightbox.options, options ) );

            self.$listsbox = self.$elem.find('[role=listbox]');
			self.$content = self.$elem.find('[role=content]');
            self.$toggle = self.$elem.find('[data-toggle=dropdown]');


            self.settings = options;
            self.settings.current = self.$toggle.attr('data-company-id');
            // console.log( options );

            self.$toggle.click(()=>{
                if( !self.is_first ){
					self._setData( options || {} );
					self.is_first = true;
					self.refresh();
				}
            });

            self.$elem.find('[data-action=tryagain]').click(function(evt) {
				evt.preventDefault();
				evt.stopPropagation();

				self.refresh(200);
			});

			self.$elem.find('[data-action=more]').click(function(evt) {
				evt.preventDefault();
				evt.stopPropagation();

				self.options.page++;
				self.refresh(200);
			});

			self.$elem.delegate('.dropdown-item', 'click', function(evt) {
				evt.preventDefault();
				// evt.stopPropagation();

                var data = $(this).data();

                self._switchCompany( data );
			});
        },

        _setData: function ( settings ) {
			var self = this;

			self.options = settings.options || {
                page: 1,
                status: 1,
                limit: 24
			};

			self.total = 0;
			// self.settings = settings;
			self.url = '/api/v1/companies'; //settings.url; // ||
		},

		refresh: function ( delay ) {
			var self = this;

			if( !self.url ) return;
			if( self.is_load ) clearTimeout( self.is_load );

			self.$content
				.removeClass('has-error')
				.removeClass('has-empty')
				.removeClass('has-more')
				.addClass('has-loading');

			self.options.more = false;

			self.is_load = setTimeout(function () {

				self.fetch().done(function( res ) {

					if( res.options ){
						self.options = $.extend({}, self.options, res.options);
                    }

                    self.options.page = parseInt( self.options.page );
                    self.options.limit = parseInt( self.options.limit );

                    var amout = self.options.page*self.options.limit;

                    self.options.more = amout < res.total;

					if( res.error ){
						self.$content.addClass('has-error');
					}

					if( !res.data ){
						self.$content.addClass('has-empty');
						// return false;
					}

					if( res.data ){
						self.buildFrag( res.data );
						self.display();
                    }

                    self.$content.toggleClass('has-more', self.options.more);
				});

			}, delay || 1);
		},
		fetch: function () {
			var self = this;

			// if( self.$el.filter ){
			// 	self.$el.filter.find(':input').not('.disabled').prop('disabled', true);
			// }

			return $.ajax({
				url: self.url,
				data: self.options,
				dataType: 'json'
			}).always(function () {
				// if( self.$el.filter ){
				// 	self.$el.filter.find(':input').not('.disabled').prop('disabled', false);
				// }

				self.$content.removeClass('has-loading');
			}).fail(function() {
				self.$content.addClass('has-error');
			});

		},
		buildFrag: function ( results ) {
			var self = this;

			self.$items = $.map(results, function(obj) {
				return self.setItem( obj )[0];
			})
		},
		setItem: function ( data ) {
			var self = this;
			var li = $('<li>', {class: 'dropdown-item account-group d-flex align-items-center'}).append(
				  $('<div>', {class: 'avatar'}).html( $('<img>', {src: '', alt: ''}) )
				, $('<div>', {class: 'content'}).append(
					$('<div>', {class: 'pl-2'}).append(
					  $('<div>', {class: 'title'}).text( data.name )
					, $('<div>', {class: 'text'}).text( data.domain ||  data.username || '' )
					)
				)
			).data( data );

			if( self.settings.current == data.id ){
				li.addClass('active');
			}

			return li;
		},

		display: function () {
			var self = this;
			self.$listsbox.append( self.$items )
        },

        _switchCompany: function (data) {
            var self = this;
            //config.base_url +



            $.post('/account/change_company', {
                id: data.id,
                _token: $('meta[name=csrf-token]').attr('content')
            }, function(data, textStatus, xhr) {

                if( data.code==200 ){
                    location.reload();
                }
            }, 'json');

        }
    }

    $.fn.SwitchCompany = function( options ) {
		return this.each(function() {
			var $this = Object.create( SwitchCompany );
			$this.init( options, this );
			$.data( this, 'SwitchCompany', $this );
		});
	};

})( jQuery, window, document );
