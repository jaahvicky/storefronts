$(function() {
    
    $( ".login-form" ).submit(function( event ) {
        event.preventDefault();
        var formData = $(this).serializeArray();
        $('#load-modal').modal('show');
        $('.loading-migrate').animate({ width: '90%' }, 'slow');
        $.ajax({
          url: "user/migration",
          data: formData,
          method: "POST",
          
        }).done(function( data ) {
              console.log(data);
            if(data.success){
                $("input#username").attr('readonly',true);
                $("input#password").attr('readonly',true);
                $('#submit_btn').prop('disabled', true);
                //$('.item-box').show();
                getItems();
                $('.your-items').show();
            }else{
                var error = data.message;
                $.each(data.message, (index, value)=>{
                        console.log(index, value);
                    $('.error-login').append('<p>'+value+'</p>');
                })
                $('.error-login').show();
                 setTimeout(function(){ $('.error-login').hide().html(''); }, 3000);   
            }
          
            
            
            $('#load-modal').modal('hide');
            
        });

    });
    checkMigration();
    function checkMigration(){
        if($('#migrated').val() == '1'){
            $("input#username").val($('#migrated_number').val()).attr('readonly',true);
            $("input#password").val(1223343545).attr('readonly',true);
            $('#submit_btn').prop('disabled', true);
            
            getItems();
            $('.your-items').show();
        }
    }
    function getItems(){
         $.ajax({
          url: "items/migration",
          method: "GET",
          
        }).done(function( data ) {
            console.log(data);
           window.getAllData(data, true);
            
        });
    }


    $('.action-option').on('change', function(e){
        console.log('toggled');
        $('.action-toggle').html($('.action-option:checked').val() + ' <span class="caret actions"></span>');
        $('.action-bulk').show();
    });

    
    
});