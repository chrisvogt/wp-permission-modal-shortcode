// jQuery in noConflict mode, call dialog() on
// the #consentdialog element.
jQuery(function($) {
    var $consent = $("#consentdialog");
    $consent.dialog({                   
        'dialogClass'   : 'consent-dialog',           
        'modal'         : true,
        'autoOpen'      : true, 
        'closeOnEscape' : true,
        'width'         : 365
    });
    $(".feature a").click(function(event) {
        event.preventDefault();
        $consent.dialog('open');
    });
});