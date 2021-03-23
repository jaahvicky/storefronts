/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {
    
    $().ownaivalidator({
        email: {
            whenTrue: function() {
                $("#preference_email").removeAttr('disabled');
                $("#disabled-message").css('display', 'none');
            },
            whenFalse: function() {
                $('#preference_email').attr('disabled', true);
                $("#disabled-message").css('display', 'inline');
            }
        },
        phone: {
            whenTrue: function() {$('#preference_sms').removeAttr('disabled')},
            whenFalse: function() {$('#preference_sms').attr('disabled', true)}
        }
    });
    
});

function setFocused(el) {
    setTimeout(function() {
        $(el).select();    
    }, 500);
}
