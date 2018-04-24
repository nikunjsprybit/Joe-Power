(function($){
    $('document').ready(function(){
        $('.role-list').on('click', 'a', function(e){
            e.preventDefault();
            $('.role-list a').removeClass('active');
            $(this).addClass('ajax-loading-img');
            $(this).addClass('active');
            $('#mime-list input').attr('disabled','disabled');
            $('#message, #error_message').hide();
            $('#role-name span').html($(this).html());
            $('#current-role').val($(this).attr('href'));

            var d = new Date();
            var data = {
                'action': 'get_selected_mimes_by_role',
                'role': $('#current-role').val()
            };

            $.post(ajaxurl, data, function(response) {
                $('#mime-list').html(response);
                $('.role-list a').removeClass('ajax-loading-img');
            });
        });
        
        $('.role-list a').first().trigger('click');
        
        $('.submit').on('click', 'input', function(){
            $('.submit-loading').css('display', 'inline-block');
            $('#message, #error_message').hide();           
            data = $('#wp-upload-restriction-form :input').serializeArray();
            
            $.post(ajaxurl, data, function(response) {
                $('.submit-loading').css('display', 'none');
                if(response == 'yes'){
                    $('#message').show();
                }
                else{
                    $('#error_message').show();
                }
            });
        });
    });
})(jQuery);