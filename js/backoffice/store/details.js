/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


// Location functionality
// PLEASE LEAVE OUTSIDE READY FUNCTION

var street_address_1;

var componentForm = {
    street_number: 'short_name',
    route: 'long_name',
    locality: 'long_name',
    administrative_area_level_1: 'short_name',
    country: 'long_name',
    postal_code: 'short_name' 
};

function getCoord()
{

    $address = document.getElementById('street_address_1').value;
    $key     = google_api_key;
    $components = 'country:ZW';

    if (!$address) {
        
        $('#l1').val('');
        $('#l2').val('');
        $('.street-address-1 input').val('');
        $('.street-address-1-message').html('The address is required and must exist.');

        return false;
    }
    
    $.ajax({

        url: 'https://maps.googleapis.com/maps/api/geocode/json?address=' + $address + ' &key=' + $key + ' &components=' + $components,
        method: 'get',

    }).done(function (data) {

        if (data.status == 'OK') {
            console.log('success');

            var lt  = data.results[0].geometry.location.lat; // set latitude
            var lng = data.results[0].geometry.location.lng; // set longitude

            // -33.9248685, 18.4240553
            $('#l1').val(lt);
            $('#l2').val(lng);

            if(data.results[0].formatted_address === 'Zimbabwe') {
                $('.street-address-1').addClass('has-error');
                $('.street-address-1 input').val('Zimbabwe');
                $('.street-address-1-message').html('Please make sure the address is correct.');
            } else {
                $('.street-address-1').removeClass('has-error');
                $('.street-address-1-message').html('&nbsp;');
            }

        } else {
            
            $('#l1').val('');
            $('#l2').val('');

            $('.street-address-1-message').html('The address is required and must exist.');

        }

    });
}

$(function() {
    
    $().ownaivalidator([]);

    // if page is store-details .
	if ($('#backend-store-details').length > 0) {
	    getCoord();
	}

    $('#street_address_1').bind('cut copy paste', function(e) {
        e.preventDefault();
    });
    
});