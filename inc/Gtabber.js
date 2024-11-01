/* 
*     Tabber widget plugin for wordpress
*     Copyright (C) 2011 - 2021 www.gopiplus.com
*     http://www.gopiplus.com/work/2012/11/10/tabber-widget-plugin-for-wordpress/
*     License: GPLv2 or later
*/

$j = jQuery.noConflict();

$j(document).ready(function(){

        // UL = .GTabberTabs
        // Tab contents = .GTabberInside
        
       var tag_cloud_class = '#tag-cloud'; 
       
       var tag_cloud_height = jQuery('#tag-cloud').height();

       jQuery('.GTabberInside ul li:last-child').css('border-bottom','0px') // remove last border-bottom from list in tab conten
       jQuery('.GTabberTabs').each(function(){
       	jQuery(this).children('li').children('a:first').addClass('selected'); // Add .selected class to first tab on load
       });
       jQuery('.GTabberInside > *').hide();
       jQuery('.GTabberInside > *:first-child').show();
       

       jQuery('.GTabberTabs li a').click(function(evt){ // Init Click funtion on GTabberTabs
        
            var clicked_tab_ref = jQuery(this).attr('href'); // Strore Href value
            
            jQuery(this).parent().parent().children('li').children('a').removeClass('selected'); //Remove selected from all GTabberTabs
            jQuery(this).addClass('selected');
            jQuery(this).parent().parent().parent().children('.GTabberInside').children('*').hide();
            
            jQuery('.GTabberInside ' + clicked_tab_ref).fadeIn(500);
             
             evt.preventDefault();

        })
    
})