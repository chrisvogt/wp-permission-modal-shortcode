<?php
/**
 * Build the modal if it has an ID assigned. 
 */
// if ( isset( $options['id'] ) ) : ?>

<?php // ================================== ?>

<div id="consentdialog" title="<?php echo mytheme_option('headline'); ?>">

    <?php if( mytheme_option('header_logo') ) : ?>
    <img src="<?php echo mytheme_option('header_logo'); ?>" id="topimage" />
    <?php endif; ?>

    <h4><?php echo mytheme_option('headline'); ?></h4>

    <p><?php echo mytheme_option('body'); ?></p>

    <?php echo do_shortcode( mytheme_option('cf7_shortcode') ); ?>

</div><!-- /consentdialog -->

<?php // ================================== ?>

<script>
// custom.js - this needs to be in an external file, loaded after jQuery dialog plugin
jQuery(function($) { // Consent modal jQuery UI .Dialog() settings
    
    var $consent = $("#consentdialog");
    $consent.dialog({                   
        'dialogClass'   : 'consent-dialog',           
        'modal'         : true,
        'autoOpen'      : false, // TRUE during development 
        'closeOnEscape' : true,
        'width'         : 365
    });
    $(".feature a").click(function(event) { // Load the modal if the feature button is clicked
        event.preventDefault();
        $consent.dialog('open');
    });
    $("#skipthis").click(function(event) { // Load the modal if the feature button is clicked
        event.preventDefault();
        pmodal_redirect();
    });
});

/**
 * Redirect the user on CF7 form validation.
 * Requires `on_sent_ok: pmodal_redirect()` 
 * set in CF7 additional settings.
 */
function pmodal_redirect() {
    var btnURL = "<?php echo $atts['href']; ?>";
    window.location = btnURL;
};

</script>

<?php // ================================== ?>

<?php
/**
 * Danger! Danger! Danger!
 * (@internal as seen in @link http://www.freakingnews.com/pictures/8000/Rodney-Dangerfish--8451.jpg )
 */
//else :
//    echo 'Modal ID undefined.';
//endif;