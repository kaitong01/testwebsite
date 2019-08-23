// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var seriesPlansForm = {
		init: function (options, elem) {
			var self = this;

			self.options = $.extend( {}, $.fn.seriesPlansForm.defaults, options );
            self.$elem = $(elem);
            self.$container = $( self.options.container );
            self.$listsbox = self.$elem.find('[role=listsbox]');

            self.$listsbox.empty();

            console.log( self.options.data );
            if(!self.options.data || self.options.data.length==0){
                self.addDay();
                self.calDay();
            }
            else{

                // console.log(self.options.data);
                $.each(self.options.data, function (i, obj) {
                    self.addDay(obj);
                });

                // self.addDay();
                self.calDay();
            }

            // Event
            self.$listsbox.delegate('[data-day-action]', 'click', function (evt) {
                evt.preventDefault();

                var action = $(this).attr('data-day-action');


                var $parentDay = $(this).closest('li');

                if( action=='add' ){
                    var $item = self.setDay({});
                    $parentDay.after( $item );
                    Event.plugins( $item );
                    $item.find(':input.form-control').first().focus();
                    self.calDay();
                }

                if( action=='remove' ){

                    if($parentDay.siblings().length == 0){
                        $parentDay.find(':input').val('');
                        $parentDay.find(':input.form-control').first().focus();

                        $parentDay.find('.travel-plan-content>li').not(':first-child').remove();
                    }
                    else{
                        $parentDay.remove();
                    }

                    self.calDay();
                }

                if( action=='up' && $parentDay.prev().length==1 ){
                    $parentDay.prev().before( $parentDay );
                    self.calDay();
                }

                if( action=='down' && $parentDay.next().length==1 ){

                    $parentDay.next().after( $parentDay );
                    self.calDay();
                }

            });


            self.$listsbox.delegate('[data-time-action]', 'click', function (evt) {
                evt.preventDefault();

                var action = $(this).attr('data-time-action');
                var $parentTime = $(this).closest('li');

                if( action=='add' ){

                    var $item = self.setTime({});
                    $parentTime.after( $item );

                    Event.plugins( $item );
                    $item.find(':input.form-control').first().focus();
                    self.calDay();
                }


                if( action=='remove' ){

                    if($parentTime.siblings().length == 0){
                        $parentTime.find(':input').val('');
                        $parentTime.find(':input.form-control').first().focus();
                    }
                    else{
                        $parentTime.remove();
                    }

                }

                if( action=='up' && $parentTime.prev().length==1 ){

                    $parentTime.prev().before( $parentTime );
                }

                if( action=='down' && $parentTime.next().length==1 ){

                    $parentTime.next().after( $parentTime );
                }
            });


        },
        addDay: function ( data ) {
            var self = this;

            var $item = self.setDay(data||{});
            self.$listsbox.append(  $item  );
            Event.plugins( $item );
        },

        setDay:function ( data ) {
            var self = this;

            var $item = $('<li>');


            var $header = $('<div>', {class: 'travel-plan-header d-flex'});
            $header.append(
                $('<div>', {class: 'travel-plan-days-wrap'}).append(

                    $('<div>', {class: 'travel-plan-days'}).append(

                        $('<span>').text( 'วันที่' )
                        , $('<strong>', {ref: 'day'}).text( '1' )
                    )


                )
                , $('<div>', {class: 'travel-plan-title'}).append(
                    $('<div>', {class: 'travel-plan-textbox'}).append(
                        $('<div>', {class: 'd-flex align-items-center justify-content-between'}).append(
                              '<label>หัวเรื่องวันนี้</label>'
                            , $('<div>', {class: 'travel-plan-title-button ml-2'}).append(
                                ''
                                , '<button type="button" data-day-action="up" title="ย้ายขึ้น" tabindex="-1" class="btn ml-1"><i class="fa fa-arrow-up"></i></button>'
                                , '<button type="button" data-day-action="down" title="ย้ายลง" tabindex="-1" class="btn ml-1"><i class="fa fa-arrow-down"></i></button>'
                                , '<button type="button" data-day-action="remove" title="ลบวันนี้" tabindex="-1" class="btn ml-1"><i class="fa fa-remove"></i></button>'
                            )

                        )
                        , $('<textarea>', {rows: 3, class: 'form-control', 'data-name': 'plans[id][title]', 'data-plugin': 'autosize'}).val( data.title || '' )
                        // , '<textarea rows="1" class="form-control" rows="3"></textarea>'
                    )
                )

            );


            var $content = $('<div>', {class: 'travel-plan-content'});

            if( data.items ){

                if( data.items.length==0 ){
                    $content.append( self.setTime({}) )
                }
                else{
                    $.each( data.items, function (i, obj) {
                        $content.append( self.setTime(obj) )
                    } );
                }
            }
            else{
                $content.append( self.setTime({}) )
            }


            $.each($content.find(':input.form-textbox'), function () {
                $(this).toggleClass('dirty', $(this).val()!='');
            });

            $item.append( $header, $content, '<div class="travel-plan-footer mt-2 text-center"><button type="button" class="btn btn-sm btn-outline-secondary" data-day-action="add" tabindex="-1"><i class="fa fa-plus"></i><span class="ml-1">เพิ่มวันที่</span></button></div>' );

            return $item;
        },

        setTime:function (data) {
            var self = this;
            var $li = $('<li>');

            $li.append( $('<div>', {class: 'travel-plan-content-group'}).append(

                $('<div>', {class: 'mb-2 row no-gutters align-items-center'}).append(

                    $('<div>', {class: 'col'}).append(
                        $('<div>', {class: 'travel-plan-textbox textbox-wrap'}).append(
                              $('<input>', {type: 'text', class: 'form-control form-textbox', 'data-name': 'plans[id][items][index][name]'}).val( data.name || "" )
                            , $('<label>', {class: 'form-label'}).text( 'ช่วงเวลา' )
                        )
                    )
                    , $('<div>', {class: 'col-auto travel-plan-content-button ml-2'}).append(
                          '<button type="button" title="ย้ายขึ้น" tabindex="-1" class="btn ml-1" data-time-action="up"><i class="fa fa-arrow-up"></i></button>'
                        , '<button type="button" title="ย้ายขึ้น" tabindex="-1" class="btn ml-1" data-time-action="down"><i class="fa fa-arrow-down"></i></button>'
                        , '<button type="button" title="เพิ่ม" tabindex="-1" class="btn ml-1" data-time-action="add"><i class="fa fa-plus"></i></button>'
                        , '<button type="button" title="ลบ" tabindex="-1" class="btn ml-1" data-time-action="remove"><i class="fa fa-remove"></i></button>'
                    )

                )

                ,  $('<div>', {class: 'travel-plan-textbox'}).append(
                      $('<textarea>', {rows: 1, class: 'form-control form-textbox', 'data-plugin': 'autosize', 'data-name': 'plans[id][items][index][text]'}).val( data.text || "" )
                    , $('<label>', {class: 'form-label'}).text( 'รายละเอียด' )
                )
            ) );


            return $li;
        },


        calDay:function () {
            var self = this;

            var cDay = 0;
            $.each( self.$listsbox.find('>li'), function () {


                $(this).find('[ref=day]').text( cDay+1 );

                // var cTime = 0;
                // $.each($(this).find('.travel-plan-content>li'), function () {
                //     cTime++;

                //     $.each($(this).find(':input[data-name]'), function () {
                //         $(this).attr('name', $(this).attr('data-name').replace("id", cDay));
                //     });
                // });

                $.each($(this).find(':input[data-name]'), function () {
                    $(this).attr('name', $(this).attr('data-name').replace("id", cDay));
                });

                var cTime = 0;
                $.each($(this).find('.travel-plan-content>li'), function () {

                    $.each($(this).find(':input[data-name]'), function () {

                        $(this).attr('name', $(this).attr('data-name').replace("id", cDay).replace("index", cTime) );
                    });
                    // var input = $(this).find(':input[data-name]');
                    // console.log( $(this).find(':input[data-name]') );


                    cTime ++;
                });

                cDay++;
            } );
        }

	}
	$.fn.seriesPlansForm = function( options ) {
		return this.each(function() {
			var $this = Object.create( seriesPlansForm );
			$this.init( options, this );
			$.data( this, 'seriesPlansForm', $this );
		});
	};
	$.fn.seriesPlansForm.defaults = {
        loadThrottle: 300,
        data: [],
        container: 'html, body',
	}


})( jQuery, window, document );
