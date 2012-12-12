var search;
var modal;

$(document).ready(function(){
    search = new Search();
    modal = new Modal();
    
    var $datepickers = $('[rel="datepicker"]');
        
    if ( $datepickers.length > 0 ){
        //destroy old instances
        $datepickers.datepicker( 'destroy' );
        
        $datepickers.datepicker({
            dateFormat: "yy-mm-dd",
            maxDate: new Date(),
            onSelect: function( selectedDate ) {
                if ( $(this).hasClass('daterange from') ){
                    $( '.daterange.to' ).datepicker( "option", "minDate", selectedDate );   
                } else if ( $(this).hasClass('daterange to') ) {
                    $( '.daterange.from' ).datepicker( "option", "maxDate", selectedDate );       
                }
            }
        });
    }
  
    $('[rel="tooltip"]').tooltip();
    
    var menu = new Menu( $('.menu') );
});