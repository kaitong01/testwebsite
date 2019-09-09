 // Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {


	var datatable = {
		init: function ( options, elem ) {
			var self = this;

			self.settings = $.extend({}, $.fn.datatable.settings, options);
			self.$elem = $(elem);
			self.$container = $( self.settings.container );


			self.$total = self.$elem.find( '[ref=total]' );
			self.$title = self.$elem.find( '[ref=title]' );

			self.$el = {};
			$.each( self.$elem.find('[role]'), function(index, el) {
				var key = $(this).attr('role');
				self.$el[ key ] = $(this);
			});


			self.alert = shotalert();

			$.extend(self, {
				onSearchChange: debounce(self.onSearchChange, self.settings.loadThrottle)
			});
			self.lastValue = '';



			// Data
			self._setData();


			// Event
			self.resize();
			$(window).resize(function(event) {
				self.resize();
			});

			if( self.$elem.attr('data-url') ){
				self.data.url = self.$elem.attr('data-url');
				self.$elem.removeAttr('data-url');
			}

			if( !self.data.url ){

				self.$el.container.addClass('has-error');
			}
			else{
				self.refresh();
			}


			if( self.settings.triggerMenu ){
				$(self.settings.triggerMenu).click(function(event) {

					setTimeout(function() {

						self.resize();
					}, 10);
				});
			}

			self.$elem.find('[data-action=refresh]').click(function(evt) {
				evt.preventDefault();

				self._reData();
				self.refresh(200);
			});

			self.$elem.find('[data-action=tryagain]').click(function(evt) {
				evt.preventDefault();

				self.refresh(200);
			});

			self.$elem.find('[data-action=more]').click(function(evt) {
				evt.preventDefault();

				self.data.options.page++;
				self.refresh(200);
			});


			$( window ).scroll(function(event) {

				var st = $(this).scrollTop();

				var dh = ($(document).height()*90) /100;
				var wh = ($(window).height()*90) /100;

				if( st >= dh-wh && self.data.options.more && !self.$el.container.hasClass('has-loading') ){

					self.data.options.page++;
					self.refresh(200);
				}
				// console.log( st, $(document).height() - $(window).height(), dh - wh, self.data.options.more,  );
			});


			if( self.$el.filter ){
				self.$input__search = self.$el.filter.find(':input[data-action=search]');

				self.$el.filter.delegate('[data-action=multichecked]', 'change', function(event) {


					var name = $(this).attr('name');
					var c_checked = 0;

					self.data.options[ name ] = [];

					$.each(self.$el.filter.find('[data-action=multichecked][name='+name+']'), function(index, el) {
						if( $(this).prop('checked') ){
							c_checked++;
							self.data.options[ name ].push($(this).val());
						}
					});

					if( c_checked==0 ){
						delete self.data.options[ name ];
					}

					self.data.options.page = 1;
					self.refresh(200);
				});

				self.$el.filter.find('[data-action=checked]').change(function(event) {
					var name = $(this).attr('name');

					if( $(this).prop('checked') ){
						self.data.options[ name ] = 1;
					}
					else{
						delete self.data.options[ name ];
					}

					self.data.options.page = 1;
					self.refresh(200);
				});


				self.$el.filter.find('[data-action=change]').change(function(event) {
					var name = $(this).attr('name');

					self.data.options[ name ] = $.trim($(this).val());

					self.data.options.page = 1;
					self.refresh(200);
				});


				self.$el.filter.find('[data-action=tab]').click(function(evt) {
					evt.preventDefault();

					var data = $(this).data();

					$(this).parent().addClass('active').siblings().removeClass('active');

					if( data.value=='' ){
						if( self.data.options[ data.name ] ){
							delete self.data.options[ data.name ];
						}
					}
					else{
						self.data.options[ data.name ] = data.value;
					}


					self.data.options.page = 1;
					self.refresh(200);
				});

			}

			if( self.$input__search ){

				self.$input__search.keyup(function(evt) {

					var value = $.trim($(this).val()) || '';

					if (self.lastValue !== value) {
						self.lastValue = value;

						self.onSearchChange(value);
					}

				}).keypress(function(evt) {
					var value = $.trim($(this).val()) || '';

					if( value!=='' && evt.keyCode===13){
						self.data.options.q = value;
						self.is_input__search = true;

						self.data.options.page = 1;
						self.refresh(200);
					}

				});

				self.$input__search.siblings('.textbox-clear').click(function(evt) {
					evt.preventDefault();

					if( self.data.options.q ){
						delete self.data.options.q;

						self.data.options.page = 1;
						self.refresh(200);
					}

					self.$input__search.val('').focus();
				});
			}


			// console.log( 'datatable', self.$el );
		},

		_setData: function () {
			var self = this;

			self.data = {
				total: 0,
				options: $.extend({}, {
					page: 1,
					limit: 24,

					more: false,
				}, self.settings.options),

				url: self.settings.url
			};

			if( self.$el.filter ){

				$.each(self.$el.filter.find('[data-action=checked]'), function() {
					var name = $(this).attr('name');
					if( $(this).prop('checked') ){
						self.data.options[ name ] = 1;
					}
				});

				$.each(self.$el.filter.find('[data-action=multichecked]'), function() {

					var name = $(this).attr('name');
					if( $(this).prop('checked') ){
						self.data.options[ name ].push($(this).val());
					}
				});


				$.each(self.$el.filter.find('[data-action=change]'), function() {
					var val = $.trim($(this).val());
					var name = $.trim($(this).attr('name'));

					if( name && val!='' ){
						self.data.options[name] = val;
					}
				});


				$.each(self.$el.filter.find('[data-action=tab]'), function() {

					if( $(this).parent().hasClass('className') ){

						var data = $(this).data();
						if( data.value!='' ){
							self.data.options[ data.name ] = data.value;
						}
					}
				});

			}
		},
		_reData: function () {
			var self = this;

			self.data.options.page = 1;
			self.data.options.seq = 0;

			self.$container.scrollTop(0);

			self.$el.listsbox.empty();
		},

		resize: function () {
			var self = this;

			var os = self.$elem.offset();
			var left = os.left;
			var right = 0, overHeight = 0, headerHeight = 0;


			// console.log( self.$el.listsbox.find('tr[role=table__fixed]') );
			if( self.$el.listsbox.find('tr[role=table__fixed]').length ){
				self.$el.table__fixed = self.$el.listsbox.find('tr[role=table__fixed]');
			}

			if( self.$el.header ){

				if( self.$el.table__fixed ){
					self.$el.header__table.html( self.$el.table__fixed.clone() );
				}

				headerHeight = self.$el.header.outerHeight();

				self.$el.header.css({
					position: 'fixed',
					left: left,
					top: os.top,
					right: right,
					// background: bg,
					zIndex: 200,
				});
			}


			if( self.$el.table__fixed ){
				headerHeight-= self.$el.table__fixed.outerHeight();
			}


			self.$elem.css({
				// minHeight: h,
				paddingTop: headerHeight,
			});


			// resizeTable
			if( self.$el.table__fixed && self.$el.header__table ){

				self.$el.table__fixed.find('th').each(function(index, th) {
					self.$el.header__table.find('tr>th').eq(index).css( 'width', $(th).outerWidth() )
				});
			}
		},

		refresh: function ( delay ) {
			var self = this;

			if( !self.data.url ) return;
			if( self.is_load ) clearTimeout( self.is_load );

			if( self.data.options.page==1 ){

				if( self.$el.header__table ){
					self.$el.header__table.empty();
				}

				self.$el.listsbox.empty();

				self.data.options.more = false;
				self.$elem.addClass('off');
			}

			self.$el.container
				.removeClass('has-error')
				.removeClass('has-empty')
				.removeClass('has-more')
				.addClass('has-loading');

			self.data.options.more = false;

			self.is_load = setTimeout(function () {

				self.fetch().done(function( res ) {

					if( res.error ){
						self.$el.container.addClass('has-error');
						return false;
                    }

					if( res.options ){
						self.data.options = $.extend({}, self.data.options, res.options);
					}

					self.data.options.limit = parseInt(self.data.options.limit);
					self.data.options.page = parseInt(self.data.options.page);
					self.data.options.more = self.data.options.limit*self.data.options.page < res.total;

					// has data
					if( res.data ){

						if(	res.data.length==0 && self.data.options.page==1 ){
							self.$el.container.addClass('has-empty');

							self.$title.parent().removeClass('is-text');

							return false;
							// self.$total.parent().addClass('d-none');
						}


						if( res.data.length > 0 && res.total ){

							self.$total.text( PHP.number_format(res.total) )
							self.$title.parent().toggleClass('is-text', res.total>0);
						}

						self.$elem.removeClass('off');

						if( res.items ){

							self.$items = $( res.items );
							// console.log( self.$items );
							self.$el.listsbox.append( self.$items );
							self._updateModules( self.$items )
						}


						if( res.update_filter ){
							self._updateFilter( res.update_filter );
						}


						self.$el.container.toggleClass('has-more', self.data.options.more);

						// console.log( res, res.data.length, self.data.options.page );

					 	self.resize();

					 	if( self.$el.header__table ){
					 		self.$el.header__table.addClass('show');
					 	}

					}
				});

			}, delay || 1);
		},
		fetch: function () {
			var self = this;

			if( self.$el.filter ){
				self.$el.filter.find(':input').not('.disabled').prop('disabled', true);
			}


			return $.ajax({
				url: self.data.url,
				data: self.data.options,
				dataType: 'json',

			}).always(function () {
				if( self.$el.filter ){
					self.$el.filter.find(':input').not('.disabled').prop('disabled', false);
				}

				if( self.is_input__search ){
					self.is_input__search = false;

					self.$input__search.focus();
				}


				self.$el.container.removeClass('has-loading');
			}).fail(function() {


				self.$el.container.addClass('has-error');
			});

		},

		_updateModules: function ( el ) {
			var self = this;

			Event.plugins( el );
			// self.$el.listsbox.drop();
		},

		_updateFilter: function ( data ) {
			var self = this;

			$.each(data, function(key, lis) {

				var $el = self.$el.filter.find('[filter-key='+ key +']');
				if( $el.length ){

					// var item = $el.children().first().clone();
					// $el.empty();

					$.each(lis, function(i, obj) {


						var $item = $el.find('[data-id='+ obj.id +']');

						if( $item.length ){

							$item.find('[ref-text=count]').text( PHP.number_format( obj.count ) );
						}

						/*var $item = item.clone();
						$item.find('[ref-text=name]').text( obj.name );
						$item.find(':input').prop('checked', false).val( obj.id )
						$el.append( $item );*/
					});
				}

			});
		},


		onSearchChange: function ( value ) {
			var self = this;


			if( self.$el.container.hasClass('has-loading') )  return;

			// var fn = self.settings.load;
			if( value=='' && self.data.options.q ){
				delete self.data.options.q;
				self.is_input__search = true;

				self.data.options.page = 1;
				self.refresh(200);
			}
		}
	};

	$.fn.datatable = function( options ) {
		return this.each(function() {
			var $this = Object.create( datatable );
			$this.init( options, this );
			$.data( this, 'datatable', $this );
		});
	};

	$.fn.datatable.settings = {
		container: 'html, body',
		options: {

			more: true,
			q: ''
		},

		infinite: 'scrolling', //Scrolling Vs. Pagination https://medium.com/@dalpattapaniya/infinite-scrolling-vs-pagination-f237592f339a

		triggerMenu: '#page-navigation-trigger',

		loadThrottle: 300
	};

})( jQuery, window, document );
