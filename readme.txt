=== WordPress Landing Pages ===

Contributors: Hudson Atwell, David Wells, Giulio Daprela, Matt Bisset, ahmedkaludi
Donate link: mailto:hudson@inboundnow.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: landing pages, inbound marketing, conversion pages, split testing, a b test, a b testing, a/b test, a/b testing, coming soon page, email list, landing page, list building, maintenance page, squeeze page, inbound now, landing-pages, splash pages, cpa, click tracking, goal tracking, analytics, free landing page templates
Requires at least: 3.8
Tested up to: 4.7.4
Stable Tag: 2.5.5


Create landing pages for your WordPress site. Monitor and improve conversion rates, run A/B split tests, customize your own templates and more.

== Description ==

> WordPress Landing Pages works as a standalone plugin or hand in hand with [WordPress Calls to Action](http://wordpress.org/plugins/cta/ "Learn more about Calls to Action") & [WordPress Leads](http://wordpress.org/plugins/leads/ "Learn more about WordPress Leads") to create a powerful & free lead generation system for your business.

WordPress Landing Pages plugin framework provides a way to add and even create landing pages for your WordPress site. Landing Page templates are powered by the [Advanced Custom Fields](https://wordpress.org/plugins/advanced-custom-fields/ "Advanced Custom Fields") framework.

Landing Pages plugin provides administrators the abilities to monitor and track conversion rates, run a/b or multivariate split tests on landing pages, and most importantly increase lead flow!

The landing page plugin was designed with inbound marketing practices in mind and will help you drive & convert more leads on your site.

Landing pages are an ideal way to convert more of your passive website visitors into active leads or email list subscribers.

= Highlights =

* Create beautiful Landing Pages on your WordPress site.
* Visual Editor to view changes being made on the fly!
* Track conversion rates on your landing pages for continual optimization.
* Easily clone existing landing pages and run A/B Split tests on variations.
* Use your current WordPress theme or choose from our library of custom landing page designs.
* Pre-populate Forms with visitor information to increase conversion rates
* Gather lead intelligence and track lead activity with <a href="http://wordpress.org/plugins/leads/screenshots/">WordPress Leads</a>
* Extend functionality with our growing repository of <a href="http://www.inboundnow.com/marketplace">third party add ons</a>.
* Easily implement your own custom landing page design.


= About the Plugin =

http://www.youtube.com/watch?v=flEd0sRTFUo

= Developers & Designers =

We built the landing page plugin as a framework! Need A/B testing out of the box implemented for your existing designs? Use WordPress Landing Pages to quickly spin up new landing pages that have all the functionality your clients will need.

You can quickly take your existing designs and implement them using our <a href="http://docs.inboundnow.com/section/developer/">templating framework</a>.

The plugin is also fully extendable and has a number of actions, filters, and hooks available for use. If a hook doesn't exist, simply ask and we can implement custom changes.


[Follow Development on GitHub ](https://github.com/inboundnow/landing-pages "Follow & Contribute to core development on GitHub")
 |
[Follow Inbound Now on Twitter ](https://twitter.com/inboundnow "Stay notified with updates.")


= Templates =

Landing Pages plugin ships with only small selection of responsive landing page templates. More templates are offered at the <a href="https://www.inboundnow.com/marketplace/">Inbound Now Marketplace</a>.

Landing Pages plugin also offers the ability to use your current selected theme as a template which open the door to <a href="http://docs.inboundnow.com/guide/default-wp-themes/">further customizations</a>.

We also offer a guide for using <a href="https://github.com/inboundnow/landing-pages/blob/develop/shared/docs/how.to.create.landing.page.templates.using.ACF.md">Advanced Custom Fields to build your own template.</a>

== Installation ==

1. Upload `landing-pages` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==
*Can I create my own landing page designs?,
*Yes! You can learn how to <a href="http://docs.inboundnow.com/guide/creating-landing-page-templates/">create your own landing page template here</a>.

== Screenshots ==

1. Listing created landing pages - Powered by custom post type
2. Selecting a template when creating a new landing page
3. Editing the landing page. Viewing variation performance
4. Viewing setting options for a landing page variation
5. Framework is powered by Advanced Custom Fields
6. Add custom CSS and custom JS
7. Administrative popup preview of landing page
8. Landing page comes with a visual editor

== Changelog ==

= 2.5.5 =
* Updating shared files


= 2.5.4 =
* Making sure PHP sessions are only used on the backend to fix X-CACHE issue.
* Updating shared files and database tables.

= 2.5.3 =
* Support for Avada theme

= 2.5.1 =
* Increasing use of nonces for extra security.

= 2.4.9 =
* Removing two admin notices related to legacy templates
* Variation notes migrated to custom metabox
* Removing 'Insert default content' button from landing page and modifying metabox order
* Anti XSS security improvement

= 2.4.7 =
* Adding revision support to Landing Pages
* Updating Select2 assets to work with WooCommerce 3.0

= 2.4.6 =
* Improving way we handle the replacement of sidebars when using default template
* FireFox support for datetime picker.
* Better ACF4 media uploader support for WYSIWG

= 2.4.5 =
* Improving WYSIWYG "Add Media" button support for core templates
* Updating ACF4 to latest version.

= 2.4.4 =
* Adding wpautop to 'Single Double Column' template.

= 2.4.3 =
* Fixing database upgrade routine and refacting way we record funnel information.

= 2.4.2 =
* Updating shared directory, minor code structure improvements.

= 2.3.8 =
* Improving events storage and events reporting.

= 2.3.7 =
* [tweak] Better CSS support for SVTLE template
* [update] Update shared folder.

= 2.3.6 =
* [fix] Fixing Inbound Forms error when Leads is not activated

= 2.3.4 =
* [fix] fixing broken include file for Inbound Forms when wp-config.php is outside of it's normal location.

= 2.3.4 =
* Fixing double admin notifications
* Fixing settings issue with Simple Solid Lite template

= 2.3.3 =
* Updating ACF4
* Adding support for Inbound Forms without redirect URLs (no ajax)

= 2.2.9 =
* Fixing sanitation in image generation script.

= 2.2.8 =
* Fixing function placement in image generation script.

= 2.2.7 =
* [security fix] Adding additional sanitation requirements.

= 2.2.6 =
* Removing Dropcap, Half and Half, Tubelar,  & Countdown Lander from the core.

= 2.2.4 =
* Adding custom capabilities to landing-page post type
* Debugging fatal when checking for Leads plugin

= 2.2.3 =
* Debugging impression count
* Removing Inbound Statistics for content in favor of Inbound Google Analytics extension.
* Fix issue with impressions driving up on first landing page in list.

= 2.1.9 =
* UI improvements
* Quality Control improvements / debug
* 301 instead of 302 when only one variation present

= 2.1.8 =
* Fix simple solid light
* Fix issue with legacy image uploader issue.

= 2.1.7 =
* Fix issue with Half and Half
* Code & responsive improvements to core free templates.

= 2.1.3 =
* Call to action updates

= 2.1.2 =
* Call to action updates

= 2.1.1 =
* Removing old admin notification

= 2.1.0 =
* Preparing for Inbound Pro

= 2.0.5 =
* fix issue with pausing variation A and misbehaving statistics when A is deleted. 
* fix issue with dropcap conversion area not displaying

= 2.0.3 =
* security fix

= 2.0.2 =
* fixing fatal that prevented full landing page render

= 2.0.1 =
* brand new frontend editor
* updated template editor for improved user experience
* code consolidation and optimization (refactoring)
* migrating away from custom field system for core templates, now leveraging ACF4
* misc. UI improvements
* restore broken sidebar conversion area placement for 'default' template
* now loading landing page template data on init hook instead of as global.
* cleaned up config.php requirements for landing page templates
* repair work on variation switching when in landing page preview mode

= 1.9.2 =
* Security Patch

= 1.9.1 =
* Security Patch

= 1.9.0 =
* New preview views in landing page edit screens
* Temporarily disabling geolocation services

= 1.8.8 =
* Security Patch for XSS in firefox

= 1.8.6 =
* Security Patch

= 1.8.5 =
* Security Patch

= 1.8.4 =
* preparation for Inbound Attachments
* general bug fixes and improvements

= 1.8.3 =
* Fixing white screen of death issues with other plugin conflicts
* Improvements on NoConflict jQuery Class

= 1.8.2 =
* Debugging release issues with 1.8.1
* Security Update

= 1.8.1 =
* WYSIWYG buttons overlapping fixed
* Fixes issue with Homepage extensions and variation switching
* Template preview links
* Removing 'get short url' from landing pages.
* View full list of changes [here](https://github.com/inboundnow/landing-pages/issues?q=label%3A1.8.1+is%3Aclosed)

= 1.8.0 =
* Fixing addon store

= 1.7.9 =
* Even more security updates! Security for the win!

= 1.7.8 =
* Security Patch

= 1.7.7 =
* Fix double lead notification email

= 1.7.6 =
* Fixed double email submission on contact form 7

= 1.7.5 =
* Added form field exclusions to ignore sensitive data

= 1.7.3 =
* See changelog here: https://github.com/inboundnow/landing-pages/issues?q=is%3Aissue+is%3Aclosed+label%3Av1.7.3

= 1.7.2 =
* Improved form email typo detection
* Improved Template Styles
* Fixed content wysiwyg scroll freezing bug

= 1.7.1 =
* removed iframe of inbound now addon store. For addons please visit: http://inboundnow.com/market

= 1.7.0 =
* Removed anonymous PHP functions for PHP 5.2 support
* Updated template creation standards
* Converted varition modules to CLASS based system & documented
* Move /lang/ file outside of shared

= 1.6.2 =
* Bug Fix: Fix with lead email notifications

= 1.5.9 =
* Various bug fixes.
* Refactored main plugin file to class loader.
* Improved localization systems.

= 1.5.8 =
* Bug Fix: Check all required fields

= 1.5.7 =
* Improvement: All core template now use new consolidated settings system.
* Improvement: Leads Dashboard styling & stats
* Improvement: Screenshots on local installation replaced with template thumbnails.


= 1.5.6 =
* Fix to insert marketing shortcode popup

= 1.5.5 =
* Added events to lead tracking
* Bug Fix: Marketing Button
* Optimized CTA Tracking JS.
* Expanded impression/conversion analytics to all post types.

= 1.5.4 =
* Impression tracking bug fix.
* Bringing Inbound Tracking to All Posts/Pages

= 1.5.3 =
* Temporary fix for shortcodes disappearing from wordpress 3.8 to 3.9
* Performance improvements on analytics and lead tracking

= 1.5.1 =
* Misc bug fixes

= 1.5.0 =
* fixed field mapping bug
* Added better compability for js conflicts
* Prepping for marketing automation

= 1.4.9 =
* Fixed and improved default landing page templates
* Updates to work with V2 of the CTA plugins
* Improved form compatibilty with contact form 7, gravity forms, and ninja forms
* Numerous bug files and code improvements

= 1.4.8 =
* Added Google Analytics Custom Event Tracking for form submissions
* Added Ability: automatically sort leads into lists on form completions
* Added Ability: Send lead notification emails to multiple people. Use comma separated values
* Improved Social Media Buttons called with lp_social_media() function
* Fixed qTranslate plugin bug
* Fixed Genesis Title tag conflict
* Added improved asset loader
* Updated main docs.inboundnow.com site. Check it out!

= 1.4.7 =
* GPL fix with js library

= 1.4.6 =
* New Feature: Bulk Lead management with leads plugin wordpress.org/plugins/leads/
* Added tags to lead profiles for improved management/categorization
* Added new compatibility options to fix third party plugin conflicts!
* Added new debugging javascript debugging tools for users
* Fixed Email Sending Error on forms
* Improved support for master license keys

= 1.4.5 =
* Added New HTML Lead Email Template with clickable links for faster lead management
* Added Button Shortcodes!
* Added HTML field option to form tool
* Added Divider Option to Form tool
* Added multi column support to icon list shortcode
* Added Font Awesome Icons option to Inbound Form Submit buttons
* Added Social Sharing Shortcode
* Bug fix - emails not sending after form conversion fixed

= 1.4.1 =
* Bug fix - missing trackingObj

= 1.4.0 =
* Added feature request form to all plugin admin pages. Submit your feature requests today! =)

= 1.3.9 =
* Bug fixes for form creation issues
* Bug fixes for safari page tracking not firing
* Added quick menu to WP admin bar for quicker marketing!

= 1.3.8 =
* Updated styles to 3.8 wordpress
* Streamlined form creation
* fixed rogue PHP errors

= 1.3.7 =
* Added: Shortcode now automatically render in landing page option echos in templates
* Updated: Visual Editor tool
* Updated: Template selection interface
* Updated: Major updates to core templates, CSS tweaks and fixes
* Fixed: Shortcode insert into correct editor box
* Fixed: editor always on HTML view

= 1.3.6 =

* Added: New Shortcodes! Fancy List and Column shortcodes
* Added: Added email confirmation support to Inbound Forms tool
* Added: Added New Welcome Page with Tutorial Video on Getting Started
* Added: New Debug Tab for faster support requests/debugging
* Fixed: CSS conflicts with button classes

=  1.3.1 =

* Added: Added InboundNow form creation and management system (beta)
* Added: Support for InboundNow cross plugin extensions
* Added: 'Sticky Variations' to global settings.
* Added: Easier way for extension developers to license their extensions.
* Added: 'header' setting component to global settings.
* Fixed: Security issues
* Improvement: Improved data management for global settings, metaboxes, and extensions.

=  1.2.3 =

* Fixed: Security issue with vulnerability to sql injection.

=  1.2.1 =

* Fixed: Issues with shortcodes rendering in wp-admin for variations.

=  1.1.9 =

* Fixed: Issues with navigation menu items breaking on landing pages with the default template selected.

=  1.1.8 =

* Fixed: Issue with post_content not saving for variations.
* Added: [lp_conversion_area] Shortcode. It renders form conversion area anywhere on landing page
* Fixed: Restored the ability to delete custom templates from 'Templates' section.

=  1.1.7 =

* Fixed: Issue with extension license keys not validating
* Fixed: Issue with shortcodes not firing on select core templates
* Improvement: Converted global settings data array to new easier to read format for development, added in legacy support.

=  1.1.0.1 =

* Fixed: Variation saves for custom css and custom js.
* Fixed: jQuery error related to wysiwyg content formatting.

= 1.0.9.9 =
* Improved extension metabox loading for quicker load times and optimized meta data storage.
* Phased out more 'old method' split testing components.
* Improved .htaccess parsing.
* Addressed issue with line breaks being removed from WYSIWYG editors.

= 1.0.9.4 =
* Added in tours for the edit screen and the list of landing page screen for new users to learn how to use the tool quickly and easily
* Updated conversion tracking for wp-leads addon plugin
* Added in option for default templates to toggle on/off navigation

= 1.0.9.3 =

* Removed old A/B split testing and the new system is fully in place!

= 1.0.9.0 =

* Added in A/B stats to the main landing page list view

= 1.0.8.6 =

* Release new and improved version of A/B testing!
* Ajax saving on landing page options for faster page edits
* Frontend Visual Editor to see what you are editing/changing
* Enabled frontend editor for use on normal pages and posts

= 1.0.8.5 =

Providing better conversion and impression tracking for landing pages that are set as homepage.

= 1.0.8.4 =

Fixing activation bug

= 1.0.8.1 =

Fixing issue with jquery submission errors.

= 1.0.7.9 =

Added capability to activate and update license keys for premium extensions. Added ability to define white listed HTML elements for Form Standardization process.

= 1.0.7.3 =

Fixed issue with WP_List_table causing posts to to save or edit propperly Attempt 001

= 1.0.7.1 =

Added cookie based auto-field population & lead data collection to core.

= 1.0.5.6 =

Fixed issue with global setting's radio buttons not holding new set values.

= 1.0.5.3 =

Solutions for custom post type wp rewrite issue on activation.

= 1.0.5.1 =

Introducing version control system for extensions.

= 1.0.4.4 =

Migrating store to new location.  Updating version control systems

= 1.0.4.2 =

Added new defitions to form standardization parser. Limited .htaccess rewrites to plugin activation to try and mitigate .htaccess corruptions.

= 1.0.4.1 =

Fixed issue with conversions not recording on some servers by forcing form submittal to wait until ajax has completely finnished loading before continuing to process form.

= 1.0.3.9 =

Fixed issue with plugins and wp core refusing to update on some installations when landing page plugin is activated.

= 1.0.3.8 =

Debugging cross browser impressions and conversion tracking. Implemented soltion for url-to-postid conversions that's compatible with the /slug/ removal extension for landing pages plugin.
Added email validation check to prevent false positives when form standardization is turned on.

= 1.0.3.7 =

Bug Fix: 'Clear Stats' button.

= 1.1 =

Released
