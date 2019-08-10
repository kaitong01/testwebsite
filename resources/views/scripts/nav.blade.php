<script type="text/javascript">

    $(document).ready(function(){

    	$.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
	    });


        $('#page-navigation-trigger').click( (evt) => {
            evt.preventDefault();

            $('body').toggleClass('is-pushed-left');

            $.post( '/site/menu', {is_open: $('body').hasClass('is-pushed-left')? 1: 0}, function (res) {
            	console.log( res );
            }, 'json');
        });
    });

</script>
