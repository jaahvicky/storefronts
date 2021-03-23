/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function() {
   
    $(".dropdown-menu > .treeview").click(function(event) {
        
        $("*[data-methys-filter=dropdown-toggle]").trigger('changed');
        
    });
    
});