/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {
        
    var section = $('input[name=account_type]:checked').val();
    toggleSection(section);

    $("input[name=account_type]").on('change', function() {
        var section = $('input[name=account_type]:checked').val();
        toggleSection(section);
    });

    function toggleSection(section) {

        if (section == 'subscriber-acc') {
            $("#section-merchant").css('display', 'none');
            $("#section-subscriber").css('display', 'inline');
        }
        else {
            $("#section-merchant").css('display', 'inline');
            $("#section-subscriber").css('display', 'none');
        }
    }

});