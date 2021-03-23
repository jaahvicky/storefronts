/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function() {
   
    setButtonText();
   
    $("#visibility").change(function() {
        setButtonText();
    });
    
    function setButtonText() {
        var visibility = $("#visibility").val();
        
        if (visibility === "Draft") {
            $("#saveButton").val("Save Draft");
        }
        else {
            $("#saveButton").val("Save & Submit for Moderation");
        }
    }
    
});