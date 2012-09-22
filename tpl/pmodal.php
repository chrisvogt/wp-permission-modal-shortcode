<?php
/**
 * Build the modal if it has an ID assigned. 
 */
// if ( isset( $options['id'] ) ) : ?>

<div id="consentdialog" title="<?php echo mytheme_option('headline'); ?>">

    <img src="<?php echo mytheme_option('header_logo'); ?>" id="topimage" />

    <h4><?php echo mytheme_option('headline'); ?></h4>

    <!-- <h4 style="color: red;"><?php echo $form['featureURL']; ?></h4> -->

    <p><?php echo mytheme_option('body'); ?></p>

    <form class="consentmodal">

        <fieldset class="subscriberinfo">
            <legend><h5>About you</h5></legend>
            <label for="firstname">First Name</label>
            <input type="text" name="firstname" placeholder="First Name" id="firstname" />
            <label for="lastname">Last Name</label>
            <input type="text" name="lastname" placeholder="Last Name" id="lastname" />
            <label for="email">E-mail Address</label>
            <input type="email" name="email" placeholder="Email Address" id="email" />
        </fieldset>

        <fieldset class="switchchecks">
            <legend><h5>Subscribe</h5></legend>
            <label for="subscribe">Subscribe to our newsletter?</label>
            <input type="checkbox" id="subscribe" checked="checked" />
            <label for="agentbroker">Are you an agent or broker?</label>
            <input type="checkbox" id="agentbroker" />
            <label for="activeseek">Actively looking to buy a home?</label>
            <input type="checkbox" id="activeseek" />
        </fieldset>

    </form>

</div><!-- /consentdialog -->

<?php // ================================== ?>

<script>
// custom.js - this needs to be in an external file, loaded after jQuery dialog plugin
jQuery(function($) { // Consent modal jQuery UI .Dialog() settings
    var btnURL = "<?php echo urldecode($form['URL']); ?>";
    var $consent = $("#consentdialog");
    $consent.dialog({                   
        'dialogClass'   : 'consent-dialog',           
        'modal'         : true,
        'autoOpen'      : true, // TRUE during development 
        'closeOnEscape' : true,
        'width'         : 365,
        'buttons'        : [ { 
                            text: "Cancel",
                            click: function() { $(this).dialog("close"); }
                           }, {
                            text: "Subscribe",
                            id: "btnSubscr",
                            click: function() { window.location = btnURL; }
                           }],
    });
    $(".feature a").click(function(event) { // Load the modal if the feature button is clicked
        event.preventDefault();
        $consent.dialog('open');
    });
    $("#btnSubscr").button("disable"); // Disable the subscribe button until validated
    $("#email").keyup(function(){
        if( $(this).val() != '' ){
            $("#btnSubscr").button("enable");
        };
    });
});

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