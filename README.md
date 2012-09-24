# Permission Modal Shortcode

Contributors: [CHR1SVOGT](http://chrisvogt.me)
Tags: permission marketing, dialog box, modal overlay, subscription modal
Tested up to: 3.4.2
Dependencies: [Contact Form 7](http://wordpress.org/extend/plugins/contact-form-7/)

## Overview ##

Permission Modal Shortcode is a Wordpress plugin adding a shortcode to create fast, robust subscription dialogs inspired by Seth Godin's description of [Permission Marketing](http://sethgodin.typepad.com/seths_blog/2008/01/permission-mark.html).

The intent is to encourage the submission of user information in exchange for goods or information you may provide through your website, and to present this _after_ the visitor has decided to claim the resource, not on page load.

This plug-in in the early stages of development. It may require someone who is Wordpress and/or PHP-savvy to implement. Have something to contribute? Fork it and build away!

## Installation ##

1. Upload or clone the `permission-modal-shortcode` directory into your `/wp-content/plugins/` folder.
1. Activate the plugin through the 'Plugins' menu in Wordpress.
1. Install and activate [Contact Form 7](http://wordpress.org/extend/plugins/contact-form-7/).
1. Create a new form in Contact Form 7. Set `on_sent_ok: pmodal_redirect()` in the 'Additional Settings' of that form.
1. Set the options in the 'Permission Modal' menu added to Wordpress by this plugin.
1. (optional) Download the [Contact Form 7 to Database Extension](http://wordpress.org/extend/plugins/contact-form-7-to-database-extension/) to access results via Wordpress and export as CSV, Excel, etc.

## Screenshots ##

![Applied Screenshot](http://i.imgur.com/1inbI.png "Permission Modal in action")
![Options Window](http://i.imgur.com/FFtzD.png "Option pane 1")
![Options Window](http://i.imgur.com/6fGJQ.png "Option pane 2")

## Changelog ##

### 0.0.2 ###
This is the first public release of this plug-in.