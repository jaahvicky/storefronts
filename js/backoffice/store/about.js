/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {
    
    CKEDITOR.replace( 'description', {
        
        // Define the toolbar groups as it is a more accessible solution.
        toolbarGroups: [
                {"name":"basicstyles","groups":["basicstyles"]},
                {"name":"paragraph","groups":["list","blocks"]},
                {"name":"styles","groups":["styles"]},
                {"name":"about","groups":["about"]}
        ],
        // Remove the redundant buttons from toolbar groups defined above.
        removeButtons: 'Strike,Subscript,Superscript,Anchor,Insert,Links,Styles,Specialchar'
    });
    
});