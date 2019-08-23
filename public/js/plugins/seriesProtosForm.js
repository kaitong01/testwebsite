// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var seriesProtosForm = {
		init: function (options, elem) {
			var self = this;

			self.options = $.extend( {}, $.fn.seriesProtosForm.defaults, options );
            self.$elem = $(elem);
            self.$container = $( self.options.container );
            self.$listsbox = self.$elem.find('[role=listsbox]');
            self.$uplaod = self.$elem.find(':input[type=file]');

            self.$form = self.$elem.closest('form');
            self.dataForm = self.$form.data('formSubmit');
            self.$dropzone = self.$elem.find('[role=dropzone]');

            self.$uplaod.append('<div class="loader"><div></div><div></div><div></div></div>');

            self.$listsbox.empty();


            if( self.options.data.length>0 ){

                let $items = $.map( self.options.data, function (obj) {
                    let $item = self.setItem();
                    // console.log( obj );
                    self.loadImage($item, obj.src);

                    $item.find('.form-caption').append( obj.caption ? obj.caption: '' );
                    // $item.find('.td-data').append( $('<input>', {type: 'hidden', 'data-name': 'images[index][name]', value: obj.name}) );
                    $item.find('.td-data').append( $('<input>', {type: 'hidden', 'data-name': 'images[index][id]', value: obj.id}) );
                    return $item;
                } );

                self.$listsbox.append( $items );
                self.convert();
                self._updatePlugin();
            }
            else{
                self.$dropzone.removeClass('d-none');
            }


            // self.files = [];

            // Event
            self.$uplaod.change(function (e) {
                e.preventDefault();

                $.each(this.files, function (i, file) {
                    var $item = self.setItem( file );

                    self.$listsbox.append( $item );
                    self.reader($item, file);

                    $item.find('.form-caption').append( file.name );
                });

                self.convert();
                self._updatePlugin();
            });

            self.$listsbox.delegate('[data-action]', 'click', function (evt) {
                evt.preventDefault();

                var action = $(this).attr('data-action');
                var $parent = $(this).closest('tr');

                if( action=='remove'  ){

                    //&& $parent.siblings().length>0
                    $parent.remove();
                }

                if( action=='up' && $parent.prev().length==1 ){
                    $parent.prev().before( $parent );
                }

                if( action=='down' && $parent.next().length==1 ){
                    $parent.next().after( $parent );
                }

                self.convert();
            });


            self.$elem.find('[data-action=upload]').click(function () {
                self.$uplaod.trigger('click')
            })
        },
        setItem:function ( data ) {
            // let self = this;

            // if( !data ) data = {};

            // var OpsStr = JSON.stringify( self.options.datepickerOps );
            // console.log( data );

            var $tr = $('<tr>').append(
                  '<td class="td-index">1</td>'
                , $('<td>', {class: 'td-data'}).append(

                    $('<div>', {class: 'media'}).append(
                          '<div class="pic-wrap mr-2"><div class="pic"></div></div>'
                        , $('<div>', {class: 'media-body'}).append(

                            '<label class="control-label">คำบรรยายรูป (ไม่เกิน 200 อักษร)</label>'
                            , $('<textarea>', {class: 'form-control form-caption', 'data-name': 'images[index][caption]', 'data-plugin': 'autosize', rows: 1, maxLength: 200})
                        )
                    )
                )

                , '<td class="td-action"><div class="g-btns"><button data-action="up" type="button" title="ย้ายขึ้น" tabindex="-1" class="btn ml-1"><i class="fa fa-arrow-up"></i></button> <button data-action="down" type="button" title="ย้ายขึ้น" tabindex="-1" class="btn ml-1"><i class="fa fa-arrow-down"></i></button> <button data-action="remove" type="button" title="ลบ" tabindex="-1" class="btn ml-1"><i class="fa fa-remove"></i></button></div></td>'
            );



            if( data ){
                $tr.data( 'file', data );
            }

            return $tr;
        },

        convert:function () {
            var self = this;

            let formData = new FormData();
            $.each( self.$listsbox.find('>tr'), function (index) {
                $(this).find('.td-index').text( index+1 );

                if( $(this).data('file') ){
                    // console.log( $(this).data('file') );
                    formData.append( 'images['+index+'][upload]', $(this).data('file') );
                }

                $.each($(this).find(':input[data-name]'), function () {
                    $(this).attr('name', $(this).attr('data-name').replace("index", index));
                });
            } );


            self.dataForm.formData = formData;

            // console.log( self.$listsbox.find('>tr').length );

            self.$dropzone.toggleClass('d-none', self.$listsbox.find('>tr').length!=0);
            self.$listsbox.closest('table').toggleClass('d-none', self.$listsbox.find('>tr').length==0);
        },

        _updatePlugin:function () {
            var self = this;

            Event.plugins( self.$listsbox );
            // $('.js-flatpickr').flatpickr();
        },

        reader: function ( $elem, file ) {
			var self = this;

            var reader = new FileReader();

            //
            $elem.find('.pic').addClass('has-loading');
			reader.readAsDataURL(file);
			reader.onload = function(e){
				self.loadImage($elem, e.target.result)
			}
		},

		loadImage: function ( $elem, src ) {
			var self = this;

			var $image = $('<img/>', {class: 'img img-preveiw',alt: ''});
			var image = new Image();
	        image.src = src;
	        image.onload = function() {

                $elem.find('.pic').removeClass('has-loading');
	        	$elem.find('.pic').addClass('has-image').animate({height: (this.height * self.options.width) / this.width}, 100, function () {
	        	// 	self.$elem.addClass('has-image');
                    $elem.find('.pic').html( $image.attr('src', src) );
	        	});



	        	// display
	        }

	        image.onerror = function(){
	        	self.$elem.removeClass('has-loading');
	        	self.$elem.addClass('has-empty');


	        	self.$inputHas.val( 1 ).removeClass('disabled').prop('disabled', false);
			    //display error
			}
		},
	}
	$.fn.seriesProtosForm = function( options ) {
		return this.each(function() {
			var $this = Object.create( seriesProtosForm );
			$this.init( options, this );
			$.data( this, 'seriesProtosForm', $this );
		});
	};
	$.fn.seriesProtosForm.defaults = {
        loadThrottle: 300,
        data: [],
        container: 'html, body',


        width: 128

	}


})( jQuery, window, document );
