// Utility
if ( typeof Object.create !== 'function' ) {
    Object.create = function( obj ) {
        function F() {};
        F.prototype = obj;
        return new F();
    };
}

(function( $, window, document, undefined ) {

    var PageSlideshow = {
        init: function (options, elem) {
            var self = this;

            self.options = options;
            self.$elem = $(elem);
            self.$btn = self.$elem.find('.addinput');
            self.$delbtn = self.$elem.find('#removeinput');
            
            $(document).ready(function() {
                btndelhide();
            });

            self.$btn.click(function () {
                // btndelhide();
                $( "#file-select" ).clone().find("input:file").val("").end().appendTo( ".file-upload" );  
            });
            
            self.$delbtn.click(function () {

                $( "#file-select" ).remove().find('#file-select').not(':first').last(); 
                
            });

            $('#chooseFile').bind('change', function () {
              var filename = $("#chooseFile").val();

              if (/^\s*$/.test(filename)) {
                $(".file-upload").removeClass('active');
                $("#noFile").text("No file"); 
            }
            else {
                
                $(".file-upload").addClass('active');
                $("#noFile").text(filename.replace("C:\\fakepath\\", "")); 
            }
        });

            function btndelhide() {
                var num = $("#file-select .clone").length;
                if (num > 1) {
                    $("#removeinput").show();
                }
                else {
                    $("#removeinput").hide();
                }
            }
        },





        
    };


    $.fn.PageSlideshow = function( options ) {
        return this.each(function() {
            var $this = Object.create( PageSlideshow );
            $this.init( options, this );
            $.data( this, 'PageSlideshow', $this );
        });
    };

})( jQuery, window, document );
