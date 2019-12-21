// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var seriesPeriodsForm = {
		init: function (options, elem) {
			var self = this;

			self.options = $.extend( {}, $.fn.seriesPeriodsForm.defaults, options );
            self.$elem = $(elem);
            self.$container = $( self.options.container );
            self.$listsbox = self.$elem.find('[role=listsbox]');

            // console.log( self.options.data );

            // self.$listsbox.empty();

            if( self.options.data.length==0 ){
                var $item = self.setItem();

                self.$listsbox.append( $item );
                self.convert();

                self._updatePlugin( $item );
            }
            else{
                var $items = $.map( self.options.data, function (obj) {
                    return self.setItem(obj);
                } );

                self.$listsbox.append( $items );
                self.convert();
                self._updatePlugin();
            }

            self.$listsbox.delegate('[data-action]', 'click', function (evt) {
                evt.preventDefault();

                var action = $(this).attr('data-action');
                var $parent = $(this).closest('tbody');

                if( action=='add' ){

                    var $item = self.setItem();
                    $parent.after( $item );
                    self._updatePlugin();
                }

                if( action=='clone' ){
                    var $item = $parent.clone();

                    $item.find('.form-start-date, .form-end-date').attr({ 'data-plugin':'datepicker', 'data-options': JSON.stringify( self.options.datepickerOps ) });
                    $item.find('.inputnum').attr('data-plugin','input__number');

                    $item.find(':input.form-id').remove();

                    $parent.after( $item );
                    self._updatePlugin();
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

            let is_update = false;
            self.$listsbox.delegate('.form-start-date', 'change', function (e) {
                // e.preventDefault();

                var val = $(this).val();
                var $parent = $(this).closest('tr');

                if( $(this).data('datepicker') && !is_update ){
                    var data = $(this).data('datepicker');

                    var theDate = new Date( data.viewDate );


                    let today = new Date();
                    $parent.toggleClass('disabled', today.getTime() > theDate.getTime() );


                    theDate.setDate( theDate.getDate() + self.options.period_days );

                    var $endDate = $parent.find('.form-end-date');
                    var _d = $endDate.data('datepicker');

                    if( val!='' ){
                        is_update = true;
                        _d.update( theDate );
                        is_update = false;
                    }

                }

            });

            self.$listsbox.delegate('.form-end-date', 'change', function (e) {
                // e.preventDefault();

                var val = $(this).val();
                var $parent = $(this).closest('tr');

                if( $(this).data('datepicker') && !is_update ){

                    var data = $(this).data('datepicker');

                    var theDate = new Date( data.viewDate );
                    theDate.setDate( theDate.getDate() - self.options.period_days );

                    var $startDate = $parent.find('.form-start-date');
                    var _d = $startDate.data('datepicker');

                    if( val!='' ){
                        is_update = true;
                        _d.update( theDate );
                        is_update = false;
                    }
                }

            });
        },
        setItem:function (d) {
            var self = this;

            var data = d||{};

            let startDateStr = '';
            if(data.start_date){


                let res = data.start_date.split("-");
                // let startDate = new Date(parseInt(res[0]), parseInt(res[1]), parseInt(res[2]));

                // let d = startDate.getDate();
                // d = d < 10 ? '0'+d:d;

                // let m = startDate.getMonth();
                // m = m < 10 ? '0'+m:m;

                startDateStr = res[2]+'/'+res[1]+'/'+res[0];
            }


            let endDateStr = '';
            if(data.end_date){
                let res = data.end_date.split("-");
                // console.log( data.end_date );
                // let endDate = new Date();

                // endDate.setFullYear(parseInt(res[0]));
                // endDate.setMonth(parseInt(res[1]));
                // endDate.setDate(parseInt(res[2]));

                // console.log( parseInt(res[0]), parseInt(res[1]), parseInt(res[2]) );
                // // parseInt(res[0]), parseInt(res[1]), parseInt(res[2])

                // let d = parseInt(res[2]);
                // d = d < 10 ? '0'+d:d;

                // let m = parseInt(res[1]);
                // m = m < 10 ? '0'+m:m;

                endDateStr = res[2]+'/'+res[1]+'/'+res[0];
                //d+'/'+m+'/'+endDate.getFullYear();
            }

            let pricesOps = [];
            if( data.prices_options ){
                pricesOps = $.parseJSON( data.prices_options );
            }

            // console.log( pricesOps );

            var OpsStr = JSON.stringify( self.options.datepickerOps );
            // console.log( OpsStr );

            var $tr = $('<tr>').append(
                  '<td class="td-index">0</td>'

                , $('<td>', {class: 'td-start-date'}).html( $('<input>', {
                    type: 'text',
                    maxLength: 8,
                    class: 'form-control form-start-date',
                    'data-name': "period[index][start_date]",
                    'data-plugin': 'datepicker',
                    'data-options': OpsStr
                }).val( startDateStr ) )

                , $('<td>', {class: 'td-end-date'}).html( $('<input>', {
                    type: 'text',
                    maxLength: 8,
                    class: 'form-control form-end-date',
                    'data-name': "period[index][end_date]",
                    'data-plugin': 'datepicker',
                    'data-options': OpsStr
                }).val( endDateStr ) )

                , $('<td>', {class: 'td-number td-light'}).css({'padding-left': 8, 'padding-right': 6}).html( $('<input>', {
                    type: 'text',
                    maxLength: 8,
                    class: 'form-control',
                    'data-name': "period[index][prices_options][]",
                    'data-plugin': 'input__number'
                }).val(  pricesOps[0] ? PHP.number_format(pricesOps[0]): '' ) )


                , $('<td>', {class: 'td-number td-light'}).html( $('<input>', {
                    type: 'text',
                    maxLength: 8,
                    class: 'form-control',
                    'data-name': "period[index][prices_options][]",
                    'data-plugin': 'input__number'
                }).val(  pricesOps[1] ? PHP.number_format(pricesOps[1]): '' ) )


                // , $('<td>', {class: 'td-number td-danger-light'}).css('padding-left', 15).append(

                //     $('<input>', {
                //         type: 'text',
                //         maxLength: 8,
                //         class: 'form-control',
                //         'data-name': "period[index][discount]",
                //         'data-plugin': 'input__number'
                //     }).val( data.discount ? PHP.number_format( data.discount): '' )
                //     , ( data.id
                //         ? $('<input>', {type: 'hidden', 'class':'form-id', 'data-name': 'period[index][id]', value: data.id})
                //         : ''
                //     )
                // )

                , $('<td>', {class: 'td-status'}).css({'padding-left': 15}).html( self.selectStatus( data.status?data.status:1 ) )

                , '<td class="td-action" style="white-space: nowrap;padding-left:15px"><div class="g-btns"><button data-action="clone" type="button" title="คัดลอก" tabindex="-1" class="btn ml-1"><i class="fa fa-clone"></i></button> <button data-action="up" type="button" title="ย้ายขึ้น" tabindex="-1" class="btn ml-1"><i class="fa fa-arrow-up"></i></button> <button data-action="down" type="button" title="ย้ายขึ้น" tabindex="-1" class="btn ml-1"><i class="fa fa-arrow-down"></i></button> <button data-action="add" type="button" title="เพิ่ม" tabindex="-1" class="btn ml-1"><i class="fa fa-plus"></i></button> <button data-action="remove" type="button" title="ลบ" tabindex="-1" class="btn ml-1"><i class="fa fa-remove"></i></button></div></td>'
            );

            //  data-plugin="datepicker" data-options=\''+ OpsStr +'\'
            // $tr.find('.form-datepicker').datepicker();

            return $('<tbody>').append( $tr );
        },

        selectStatus:function ( data ) {

            let $select = $('<select>', {class: 'form-control',  'data-name': "period[index][status]", 'data-plugin': 'input__status'}).css('width', 100);

            let items = [];
            // items.push( {id: 0, name: 'แบบร่าง'} );
            items.push( {id: 1, name: 'ใช้งาน'} );
            items.push( {id: 2, name: 'ระงับ'} );

            $.each( items, function (i, obj) {
                let op =  $('<option>', {value: obj.id}).text(  obj.name );
                $select.append( op );
            } );

            $select.val( data );

            return $select;
        },

        convert:function () {
            var self = this;

            $.each( self.$listsbox.find('>tbody'), function (index) {

                $(this).find('.td-index').text( index+1 );

                $.each($(this).find(':input[data-name]'), function () {
                    $(this).attr('name', $(this).attr('data-name').replace("index", index));
                });
            } );
        },

        _updatePlugin:function () {
            var self = this;

            Event.plugins( self.$listsbox );

            // $('.js-flatpickr').flatpickr();
        },


        groupPrices: function () {

        }
	}
	$.fn.seriesPeriodsForm = function( options ) {
		return this.each(function() {
			var $this = Object.create( seriesPeriodsForm );
			$this.init( options, this );
			$.data( this, 'seriesPeriodsForm', $this );
		});
	};
	$.fn.seriesPeriodsForm.defaults = {
        loadThrottle: 300,
        data: [],
        container: 'html, body',

        period_days: 2,

        datepickerOps: {
            format: "dd/mm/yyyy",
            autoclose: 1,
            todayHighlight: true,
            language: "th",
        }
	}


})( jQuery, window, document );
