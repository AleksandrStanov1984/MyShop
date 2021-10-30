<?php
/**
 * iScroller 1.2.1, September 20, 2017
 * Copyright 2014-2017 Igor Bukin / egozza88@gmail.com
 * License: Commercial. Reselling of this software or its derivatives is not allowed. You may use this software for one website ONLY including all its subdomains if the top level domain belongs to you and all subdomains are parts of the same OpenCart store.
 * Support: oc.iscroller@gmail.com
 */
$_['heading_title']               = 'iScroller';
$_['heading_title_adv']           = 'iScroller';
$_['save_and_stay']               = 'Save & Stay';
$_['save_and_close']              = 'Save & Close';
$_['text_edit']                   = 'Edit';
$_['modules']                     = 'Modules';
$_['status']                      = 'Status';
$_['enabled']                     = 'Enabled';
$_['disabled']                    = 'Disabled';
$_['loading_msg']                 = '<span  data-toggle="tooltip" title="" data-original-title="The message will be shown while loading the next portion of items">Loading Message</span>';
$_['loading_def_msg']             = 'Loading... Please wait';
$_['finish_msg']                  = '<span  data-toggle="tooltip" title="" data-original-title="The message will be shown when the end of item list will be achieved">Message at the end of list</span>';
$_['finish_def_msg']              = 'End of list';
$_['show_page_separator']         = '<span  data-toggle="tooltip" title="" data-original-title="Whether or not to show a thin line with page number between pages">Show page separator</span>';
$_['container_selector']          = '<span  data-toggle="tooltip" title="" data-original-title="CSS selector of the DOM element which contains products and where the new ones will be appended">Product Container CSS Selector</span>';
$_['paginator_selector']          = '<span  data-toggle="tooltip" title="" data-original-title="CSS selector of the DOM element which contains pagination links">Pagination Block CSS Selector</span>';
$_['item_selector']               = '<span  data-toggle="tooltip" title="" data-original-title="CSS selector of the DOM element which contains image and other accompanying data of a single product">Product Item CSS Selector</span>';
$_['min_dist_to_bottom']          = '<span  data-toggle="tooltip" title="" data-original-title="Minimum distance in pixels to the bottom of the product list when the next page should be loaded">Minimum Distance to Bottom</span>';
$_['loading_mode']                = 'Next Page Loading Mode';
$_['animation']                   = '<span  data-toggle="tooltip" title="" data-original-title="The feature enables smooth autoscroll to the top of just loaded portion of items.<br />Suggested to use the animation in loading mode with button">Enable Animation</span>';
$_['auto']                        = 'Auto';
$_['with_button']                 = 'With Button';
$_['smart']                       = 'Mixed (auto-loading + button)';
$_['button_label']                = '<span  data-toggle="tooltip" title="" data-original-title="Means the button, which will trigger loading items of the next page if loading mode with button was selected">Button Label</span>';
$_['button_def_label']            = 'Get More Products';
$_['infinite_scroller']           = 'Infinite Scroller';
$_['scroll_to_top']               = 'Scroll To Top';
$_['translation']                 = 'Translation';
$_['enable_sroll_to_top']         = 'Enable Scroll to Top Bar';
$_['enable_infinite_scroll']      = 'Enable Infinite Scroll';
$_['scroll_top_pos']              = 'Scroll Bar Position';
$_['bar_color']                   = 'Scroll Bar Color';
$_['left']                        = 'Left';
$_['right']                       = 'Right';
$_['arrow_color']                 = 'Arrow Color';
$_['scroll_bar_speed']            = '<span  data-toggle="tooltip" title="" data-original-title="Scroll animation time in miliseconds">Scroll Speed</span>';
$_['min_width_to_show_bar']       = '<span  data-toggle="tooltip" title="" data-original-title="Set the parameter in order to hide the bar for mobile devices. The bar will be totally hidden for screen width less than specified.">Minimum Width To Show The Bar</span>';
$_['min_width_show_bar']          = '<span  data-toggle="tooltip" title="" data-original-title="Show button instead of a bar for screen width less than specified.">Show button at width</span>';
$_['fit_to_container']            = '<span  data-toggle="tooltip" title="" data-original-title="The bar (or button) will stick to one of the sides of the element with CSS selector specified, e.g. #content. Leave the text field empty if you want it to stick to the window.">Fit to the container</span>';
$_['error_permission']            = 'Access Denied! You are not allowed to modify the settings';
$_['text_success']                = 'Success: You have modified featured module!';
$_['stateful_scroll']             = '<span  data-toggle="tooltip" title="" data-original-title="The position of product list will be preserved when the user is returned here from another page. In other words, when the user press the Go Back button, he won\'t have to scroll down all the reviewed goods again.">Stateful scrolling</span>';
$_['show_button_after']           = '<span  data-toggle="tooltip" title="" data-original-title="Auto loading stops after specified number of times. The &quot;Show more&quot; button will be shown instead">Show Button After N-Loadings</span>';
$_['module_name']                 = 'Module Name';
$_['custom_js_code']              = '<span  data-toggle="tooltip" title="" data-original-title="The code will be performed at the moment when a new portion of data has been loaded and appended to the product list.">Custom Javascript Code</span>';
$_['custom_css_code']             = '<span  data-toggle="tooltip" title="" data-original-title="Use this field in order to override the default style of the extension">Custom CSS Code</span>';
$_['dom_observer_desrcription']   = '<p><b>Note:</b> Enabling of this setting may cause performance issues in old versions of browsers.</p><p>It is <b>recommended</b> to disable the feature in case there is not third-party extensions on the page, which could dynamically change the product list (e.g. AJAX product filters). <br>Otherwise enable the feature if it doesn\'t cause noticeable loss of performance while loading new portion of data.</p>';
$_['dom_observer_advanced']       = '<p><b>For developers:</b> The feature listens for DOM change events, which are not fully supported even by modern versions of browsers. The extension also listens for \'productlistchange\' custom event. Thus, as alternative to the observation of DOM change events, the \'productlistchange\' event can be triggered in order to re-initialize the iScroller module.<br>E.g., once some extension has modified the product list, the following string will update the iScroller: <br><b>$(document).trigger(\'productlistchange\');</b></p>';
$_['enhanced_compatibility']      = '<span  data-toggle="tooltip" title="" data-original-title="Compatibility with third-party extensions, which can dynamically change product list. E.g. product filters, ajax sort ordering, etc.">Enhanced Compatibility</span>';
$_['custom_loading_animation']    = '<span  data-toggle="tooltip" title="" data-original-title="Upload custom GIF animation file in order to replace the default spinner">Custom Loading Animation</span>';
$_['read_the_notice']             = 'Read the notice carefully';
