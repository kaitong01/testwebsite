// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var seriesMealsForm = {
		init: function (options, elem) {
			var self = this;

			self.options = $.extend( {}, $.fn.seriesMealsForm.defaults, options );
            self.$elem = $(elem);
            self.$container = $( self.options.container );
            self.$listsbox = self.$elem.find('[role=listsbox]');

            // console.log( self.options.data );

            self.$listsbox.empty();

            if( self.options.data.length==0 ){
                var $item = self.setItem();


                self.$listsbox.append( $item );
                self.convert();
            }
            else{
                var $items = $.map( self.options.data, function (obj) {
                    return self.setItem(obj);
                } );

                self.$listsbox.append( $items );
                self.convert();
            }



            self.$listsbox.delegate('[data-action]', 'click', function (evt) {
                evt.preventDefault();

                var action = $(this).attr('data-action');
                var $parent = $(this).closest('tr');

                if( action=='add' ){

                    var $item = self.setItem();
                    $parent.after( $item );
                }

                if( action=='remove' && $parent.siblings().length>0 ){
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

        },
        setItem:function (d) {
            var self = this;

            var data = d||{};

            return '<tr>'+
                '<td class="td-index">0</td>'+
                '<td class="td-checkbox"><label class="checkbox"><input type="checkbox" data-name="meals[id][1]" value="1"'+ ( data[1]? ' checked': '' ) +'></label></td>'+
                '<td class="td-checkbox"><label class="checkbox"><input type="checkbox" data-name="meals[id][2]" value="1"'+ ( data[2]? ' checked': '' ) +'></label></td>'+
                '<td class="td-checkbox"><label class="checkbox"><input type="checkbox" data-name="meals[id][3]" value="1"'+ ( data[3]? ' checked': '' ) +'></label></td>'+
                '<td class="td-action" style="white-space: nowrap;"><button type="button" title="ย้ายขึ้น" tabindex="-1" data-action="up" class="btn ml-1"><i class="fa fa-arrow-up"></i></button> <button type="button" title="ย้ายขึ้น" tabindex="-1" data-action="down" class="btn ml-1"><i class="fa fa-arrow-down"></i></button> <button type="button" title="เพิ่ม" tabindex="-1" data-action="add" class="btn ml-1"><i class="fa fa-plus"></i></button> <button type="button" title="ลบ" tabindex="-1" data-action="remove" class="btn ml-1"><i class="fa fa-remove"></i></button></td>'+

                // '<td></td>'+

            '</tr>';

        },
        convert:function () {
            var self = this;


            var row = 0;
            $.each( self.$listsbox.find('>tr'), function () {

                $(this).find('.td-index').text( row+1 );

                $.each($(this).find(':input[data-name]'), function () {
                    $(this).attr('name', $(this).attr('data-name').replace("id", row));
                });

                row ++;
            } );
        }

	}
	$.fn.seriesMealsForm = function( options ) {
		return this.each(function() {
			var $this = Object.create( seriesMealsForm );
			$this.init( options, this );
			$.data( this, 'seriesMealsForm', $this );
		});
	};
	$.fn.seriesMealsForm.defaults = {
        loadThrottle: 300,
        data: [],
        container: 'html, body',
	}


})( jQuery, window, document );
