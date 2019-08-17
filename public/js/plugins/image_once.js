// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var image_once = {
		init: function (options, elem) {
			var self = this;
			self.$elem = $(elem);

			self.options = $.extend( {}, {
				width: self.$elem.outerWidth(),
				height: self.$elem.outerHeight(),
				name: 'file1',
            }, options );

            self.$input = self.$elem.find(':input[type=file]');
            self.$inputCancel = self.$elem.find(':input[role=input-cancel]');
            self.$preview = self.$elem.find('[role=preview]');



            if( self.$inputCancel.length==0 ){
                self.$inputCancel = $('<input>', {
                    type: "hidden",
                    name: self.$input.attr('name') + '_cancel',
                    autoComplete: "off",
                    value: 1
                })

                self.$elem.append(self.$inputCancel);
                self.$inputCancel.prop('disabled', true);
            }

            self.$elem.find('[data-action]').click(function (e) {
                e.preventDefault();
                var evt = $(this).attr('data-action');


                if( evt=='drop' ){
                    self.$input.trigger('click');
                }

                if( evt=='remove' ){
                    self.$input.val('');

                    self.$preview.empty();
                    self.$elem.removeClass('has-image');

                    self.$inputCancel.prop('disabled', false);
                }

            });

            self.$input.change( function () {
                var file = this.files[0];

                if( file ){
                    self.reader( file );
                }
            } );


            if( self.$elem.attr('data-url') ){
                self.url = self.$elem.attr('data-url');
                self.$elem.removeAttr('data-url');

                if( self.url != ''){
                    self.loadImage( self.url );
                }
            }


			// if( options.size=='auto' ){
			// 	self.options.height = (self.options.height * self.$elem.parent().outerWidth()) / self.options.width;
			// 	self.options.width = self.$elem.parent().outerWidth();
			// }


			//
			//


			// // console.log( self.options );

			// self.$elem.attr({
			// 	'data-width': self.options.width,
			// 	width: self.options.width,

			// 	'data-height': self.options.height,
			// 	height: self.options.height,
			// }).css({
			// 	width: self.options.width,
			// 	height: self.options.height,
			// });


			// if( self.options.src ){

			// 	var name_cancel = options.name_cancel || '_'+self.options.name;


			// 	self.$inputHas = $('<input type="hidden" name="'+ name_cancel +'" value="1" autocomplete="off" >');
			// 	self.$elem.append(self.$inputHas);
			// 	self.$inputHas.val( 0 ).addClass('disabled').prop('disabled', true);

			// 	self.$refresh =  $('<button type="button" class="uiCoverImage_refresh" data-action="refresh">').html( '<i class="icon-refresh"></i>' );
			// 	self.$elem.append( self.$refresh );

			// 	self.loadImage( self.options.src );
			// }

			//

			// self.$elem.find('[data-action=remove]').click(function() {

			// 	self.$input.val('');
			// 	self.$elem.css({
		    // 		height: self.options.height,
		    // 	}).addClass('has-empty').removeClass('has-image');
			//    	self.$preview.empty();


			//    	if( self.$inputHas ){
			//    		self.$inputHas.val( 1 ).removeClass('disabled').prop('disabled', false);
			//    		self.$refresh.show(1);
			//    	}
			// });

			// self.$elem.find('[data-action=trigger]').click(function() {
			// 	self.$input.trigger('click');
			// });

			// if( self.$refresh ){
			// 	self.$refresh.click(function() {

			// 		self.$inputHas.val( 0 ).addClass('disabled').prop('disabled', true);
			// 		self.$input.val('');
			// 		self.loadImage( self.options.src );
			// 	});
			// }
		},
		reader: function ( file ) {
			var self = this;

			var reader = new FileReader();

			reader.readAsDataURL(file);
			reader.onload = function(e){

				self.loadImage(e.target.result)
			}
		},

		loadImage: function ( src ) {
			var self = this;

			self.$elem.removeClass('has-empty').removeClass('has-image').addClass('has-loading');
			var $image = $('<img/>', {class: 'img img-preveiw',alt: ''});
			var image = new Image();
	        image.src = src;
	        image.onload = function() {

	        	self.$elem.removeClass('has-loading');

                self.$elem.addClass('has-image');
                self.$preview.html($image.attr('src', src));


	        	// self.$elem.animate({height: (this.height* self.options.width) / this.width}, 100, function () {
	        	//
	        	//
	        	// });

	        	// if( self.$refresh ){
	        	// 	self.$refresh.hide(1);
	        	// }


	        	// if( self.$input.val()!='' && self.$inputHas ){
	        	// 	self.$inputHas.val( 1 ).removeClass('disabled').prop('disabled', false);
	        	// 	self.$refresh.show(1);
	        	// }

	        	// display
	        }

	        image.onerror = function(){
	        	self.$elem.removeClass('has-loading');
	        	self.$elem.addClass('has-empty');


	        	// self.$inputHas.val( 1 ).removeClass('disabled').prop('disabled', false);
			    //display error
			}
		},

	};


	$.fn.image_once = function( options ) {
		return this.each(function() {
			var $this = Object.create( image_once );
			$this.init( options, this );
			$.data( this, 'image_once', $this );
		});
	};

})( jQuery, window, document );
