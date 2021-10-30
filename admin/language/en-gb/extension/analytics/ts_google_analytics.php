<?php
// Heading
$_['heading_title']				= '<b>Google Analytics <a href="https://tramplin-studio.store/" target="blank">by Tramplin Studio</a></b>';

// Buttons
$_['button_save']				= 'Save';
$_['button_cancel']				= 'Сancel';
$_['button_add']				= 'Add';
$_['button_edit']				= 'Edit';
$_['button_remove']				= 'Remove';

// Tabs
$_['tab_main_settings']			= 'Main settings';
$_['tab_userParams']			= 'User params';
$_['tab_ecommerce']				= 'eCommerce';
$_['tab_goals']					= 'Goals';
$_['tab_help']					= 'Help!';

// Entry
$_['entry_status']						= 'Status';
$_['entry_counter']['counter_id']		= 'Tracking Id';
$_['entry_counter']['type']				= 'Counter type';
$_['entry_counter']['mode']				= 'Counter mode';
$_['entry_counter']['pageview']			= 'Track page views';
$_['entry_counter']['pageview_path']	= 'Send page path';
$_['entry_counter']['pageview_title']	= 'Send page title';
$_['entry_counter']['pageview_location']= 'Send page location';
$_['entry_counter']['timing']			= 'Track user timings';
$_['entry_counter']['timing_name']		= 'Name';
$_['entry_counter']['timing_category']	= 'Category';
$_['entry_counter']['timing_label']		= 'Label';
$_['entry_counter']['link_attr']		= 'Improved link attribution';
$_['entry_counter']['link_attr_name']	= 'Cookie name (prefix)';
$_['entry_counter']['link_attr_expires']= 'Cookie expiration time (seconds)';
$_['entry_counter']['linker']			= 'Cross-domain tracking';
$_['entry_counter']['linker_domains']	= 'Linked domains';
$_['entry_counter']['linker_domain']	= 'Domain (example: site.com)';
$_['entry_counter']['linker_incoming']	= 'Accept linker parameters';
$_['entry_counter']['ad_features']		= 'Advertiser features';
$_['entry_counter']['currency']			= 'Main currency';
$_['entry_counter']['country']			= 'Main country';
$_['entry_counter']['cookie_name']		= 'Cookie name (prefix)';
$_['entry_counter']['cookie_domain']	= 'Cookie domain configuration';
$_['entry_counter']['cookie_expires']	= 'Cookie expiration time (seconds)';
$_['entry_counter']['cookie_update']	= 'Cookie update';
$_['entry_userParams']['status']		= 'Send user params';
$_['entry_userParams']['userId']		= 'User Id';
$_['entry_userParams']['type']			= 'Send user type';
$_['entry_userParams']['group']			= 'Send customer group';
$_['entry_userParams']['date_added']	= 'Send date of registration';
$_['entry_userParams']['safe']			= 'Send safe status';
$_['entry_userParams']['newsletter']	= 'Send newsletter subscription status';
$_['entry_userParams']['country']		= 'Send country';
$_['entry_userParams']['zone']			= 'Send zone';
$_['entry_userParams']['city']			= 'Send city';
$_['entry_userParams']['postcode']		= 'Send postcode';
$_['entry_userParams']['custom_field']	= 'Send custom fields values';
$_['entry_ecommerce']['status']			= 'Send eCommerce data';
$_['entry_ecommerce']['view']			= 'When viewing a product in lists';
$_['entry_ecommerce']['click']			= 'When user click on a product';
$_['entry_ecommerce']['detail']			= 'When viewing a product detail';
$_['entry_ecommerce']['add']			= 'When added to cart';
$_['entry_ecommerce']['remove']			= 'When removed from the cart';
$_['entry_ecommerce']['checkout']		= 'When proceeding to checkout';
$_['entry_ecommerce']['purchase']		= 'After order checkout';
$_['entry_ecommerce']['brand']			= 'Send manufacturer name';
$_['entry_ecommerce']['category']		= 'Send category name';
$_['entry_ecommerce']['list_name']		= 'Send list of products';
$_['entry_ecommerce']['position']		= 'Send product position in the list';
$_['entry_ecommerce']['price']			= 'Send price';
$_['entry_ecommerce']['quantity']		= 'Send quantity';
$_['entry_ecommerce']['variant']		= 'Send variant (options)';
$_['entry_ecommerce']['affiliation']	= 'Send store name';
$_['entry_ecommerce']['revenue']		= 'Send income';
$_['entry_ecommerce']['revenue_codes']	= 'Consider when calculating income';
$_['entry_ecommerce']['revenue_tax']	= 'Consider expenses';
$_['entry_ecommerce']['tax']			= 'Send tax deduction';
$_['entry_ecommerce']['shipping']		= 'Send cost of delivery';
$_['entry_ecommerce']['coupon']			= 'Send coupon';
$_['entry_goal']['status']				= 'Send goals data';
$_['entry_goal']['label']				= 'Goal label';
$_['entry_goal']['category']			= 'Goal category';
$_['entry_goal']['action']				= 'Goal identifier (action)';
$_['entry_goal']['element']				= 'Element';
$_['entry_goal']['event']				= 'Event';
$_['entry_goal']['value']				= 'Goal cost';

// Help
$_['help_counter']['counter_id']		= 'Copy the tracking identifier (counter id) in the settings on the site Google Analytics.';
$_['help_counter']['type']				= 'Type of JS used to transfer data to Google Analytics.';
$_['help_counter']['mode']				= 'Different JS loading methods. Asynchronous mode used the data transfer method is `Beacon`.';
$_['help_counter']['pageview']			= 'Track page views and transfer advanced page parameters.';
$_['help_counter']['pageview_path']		= 'The URL of the page viewing begins with a slash (/).';
$_['help_counter']['pageview_title']	= 'The title of the page viewing.';
$_['help_counter']['pageview_location']	= 'The full URL of the page viewing.';
$_['help_counter']['timing']			= 'Tracking page load speed. Allows you to reduce page loading time and improve the overall impression of the site.';
$_['help_counter']['timing_name']		= 'A string that is used to identify the transmitted variable. Example: `load`.';
$_['help_counter']['timing_category']	= 'A string that is used to split all user time variables into logical groups. Example: `JS Dependencies`.';
$_['help_counter']['timing_label']		= 'A string that can be used for more flexible time visualization in reports. Example: `Google CDN`.';
$_['help_counter']['link_attr']			= 'Increases click tracking accuracy by automatically distinguishing clicks on links with the same URL on the same page.';
$_['help_counter']['link_attr_name']	= 'A cookie is used to recognize links.';
$_['help_counter']['link_attr_expires']	= 'Maximum cookie storage time (in seconds).';
$_['help_counter']['linker']			= 'Domain linker feature that allows you to register visits to multiple resources as a single session.';
$_['help_counter']['linker_domains']	= 'A list of target domains to bind. One field - one domain.';
$_['help_counter']['linker_incoming']	= 'Accept linker parameters from target domains.';
$_['help_counter']['ad_features']		= 'Allows to disable all features for advertisers, remarketing and advertising reports.';
$_['help_counter']['currency']			= 'Tracking of the main currency of the online store.';
$_['help_counter']['country']			= 'Tracking of the main country of activity of the online store.';
$_['help_counter']['cookie_name']		= 'To avoid conflicts with other cookies, may need to change the cookie prefix.';
$_['help_counter']['cookie_domain']		= 'A cookie can be written to different levels of a domain. For example, if the site is located at `shop.example.com`, the cookie can be written to the domain `example.com`.';
$_['help_counter']['cookie_expires']	= 'The cookie expires every time the page loads, the value of this field is added to the current time. If you enter the value `0`, the cookie expires with the end of the current browser session.';
$_['help_counter']['cookie_update']		= 'If active, then the cookies will be updated every time the page is loaded, and the cookie will write on the most recent visit to the site. If not active, then cookies will NOT be updated every time the page is loaded, and the cookie will write on the user`s first visit to the site.';
$_['help_userParams']['status']			= 'Identification and the tracking of site visitors parameters.';
$_['help_userParams']['userId']			= 'Parameter `userId`. Unique value.';
$_['help_userParams']['type']			= 'Parameter `type`. Value `Guest` or `Registered`.';
$_['help_userParams']['group']			= 'Parameter `group`. Values ​​are equal to the names of customer group. Only for registered users!';
$_['help_userParams']['date_added']		= 'Parameter `date_added`. Значения в формате 0000-00-00. Only for registered users!';
$_['help_userParams']['safe']			= 'Parameter `safe`. Value `true` or `false`. Only for registered users!';
$_['help_userParams']['newsletter']		= 'Parameter `newsletter`. Value `true` or `false`. Only for registered users!';
$_['help_userParams']['country']		= 'Parameter `country`. Value is equal to the country which entered in the address settings. Only for registered users!';
$_['help_userParams']['zone']			= 'Parameter `zone`. Value is equal to the zone which entered in the address settings. Only for registered users!';
$_['help_userParams']['city']			= 'Parameter `city`. Value is equal to the city which entered in the address settings. Only for registered users!';
$_['help_userParams']['postcode']		= 'Parameter `postcode`. Value is equal to the postcode which entered in the address settings. Only for registered users!';
$_['help_userParams']['custom_field']	= 'Parameter is equal to the name of custom fields. Values ​​is equal to those entered in the account settings. Only for registered users!';
$_['help_ecommerce']['status']			= 'Collect and analyze data related to eCommerce.';
$_['help_ecommerce']['view']			= 'Data sended when viewing the products in lists: category, search, manufacturer, specials, modules with products, etc.';
$_['help_ecommerce']['click']			= 'Data sended when clicking on the product.';
$_['help_ecommerce']['detail']			= 'Data sended when viewing the product page.';
$_['help_ecommerce']['add']				= 'Data sended when adding products to the cart.';
$_['help_ecommerce']['remove']			= 'Data sended when removing products from the cart.';
$_['help_ecommerce']['checkout']		= 'Data sended when proceed to checkout.';
$_['help_ecommerce']['purchase']		= 'Data sended after the successful completion of the purchase.';
$_['help_ecommerce']['brand']			= 'Name of the manufacturer which entered in the product settings.';
$_['help_ecommerce']['category']		= 'Full category branch, for example: `category 1/category 2`. Sended only when viewing the product page.';
$_['help_ecommerce']['list_name']		= 'The list in which the product was located under the action of `clicking on the product`. For example: category, search, manufacturer, specials, modules with products, etc.';
$_['help_ecommerce']['position']		= 'The sort order which entered in the product settings, if the value is not equal to 0.';
$_['help_ecommerce']['price']			= 'Product price, including the tax rate.';
$_['help_ecommerce']['quantity']		= 'The quantity of product in stock, the quantity when adding or removing in the cart, or the quantity in the success purchase.';
$_['help_ecommerce']['variant']			= 'Listing of checked options separated by commas. Sends in all cases except viewing the product page.';
$_['help_ecommerce']['affiliation']		= 'Tracking store name which entered in OpenCart settings.';
$_['help_ecommerce']['revenue']			= 'Calculation and sending of income data from each order.';
$_['help_ecommerce']['revenue_codes']	= 'Enter the surcharges to be considered when calculating the profit from the success purchase.';
$_['help_ecommerce']['revenue_tax']		= 'Enter the average percentage of your expenses to calculate the profit from each success purchase.';
$_['help_ecommerce']['tax']				= 'Calculation and sending of the amount of tax deduction for a order in the currency of the store.';
$_['help_ecommerce']['shipping']		= 'Tracking of the cost of delivery data for a order in the currency of the store.';
$_['help_ecommerce']['coupon']			= 'Sends the coupon number with which the discount was accrued when making the purchase.';
$_['help_goal']['status']				= 'Tracking of data on events (goals achieved by visitors) for further calculation of conversions in the online store.';
$_['help_goal']['label']				= 'Describe the goal for more flexible visualization of events in reports and copy it into the Google Analytics goal settings.';
$_['help_goal']['category']				= 'Specify the goal category for breaking events into logical groups and copy it into the Google Analytics goal settings.';
$_['help_goal']['action']				= 'Create an identifier for the goal and copy it into the Google Analytics goal settings.';
$_['help_goal']['element']				= 'Select the element at the event of which the goal will be achieved as `id` or `class`. For example: `#cart`, `.cart`, `#product .cart`.';
$_['help_goal']['event']				= 'Enter the event of element at which the goal will be reached.';
$_['help_goal']['value']				= 'You can send the cost of the goal to Google Analytics as an integer in the store currency!';

// Text
$_['text_module']						= 'Modules';
$_['text_analytics']   					= 'Analytics';
$_['text_extension']					= 'Extensions';
$_['text_edit']							= 'Edit module settings';
$_['text_success']						= 'Module`s settings has been updated!';
$_['text_title']['counter']				= 'Counter settings';
$_['text_title']['userCookies']			= 'User cookies';
$_['text_title']['userParams']			= 'User params';
$_['text_title']['ecommerce_actions']	= 'Send data on actions';
$_['text_title']['ecommerce_products']	= 'Product data';
$_['text_title']['ecommerce_purchase']	= 'Purchase data';
$_['text_title']['goal_action']			= 'JavaScript event';
$_['text_seconds']						= 'Seconds';
$_['text_copy_to_clipboard']['action']	= 'Copy goal identifier';
$_['text_copy_to_clipboard']['param_id']= 'Copy dimension identifier';
$_['text_copy_to_clipboard']['param_name']= 'Copy dimension name';
$_['text_counter']['gtag']				= 'gtag.js';
$_['text_counter']['analytics']			= 'analytics.js';
$_['text_counter']['default']			= 'Default';
$_['text_counter']['asynch']			= 'Asynchronous';
$_['text_goal']['label']				= 'Goal label';
$_['text_goal']['category']				= 'Goal category';
$_['text_goal']['action']				= 'Goal action';
$_['text_goal']['element']				= 'Element';
$_['text_goal']['event']				= 'Event';
$_['text_goal']['value']				= 'Goal cost';
$_['text_goal_modal']['title_add']			= 'Add JavaScript event';
$_['text_goal_modal']['title_edit']			= 'Edit JavaScript event';
$_['text_goal_modal']['goal_title']			= 'Goal settings';
$_['text_goal_modal']['value_title']	= 'Goal cost';
$_['text_goal_event']['mouse']			= 'Mouse events';
$_['text_goal_event']['touch']			= 'Touchpad events';
$_['text_goal_event']['keyboard']		= 'Keyboard events';
$_['text_goal_event']['form']			= 'Form events';
$_['text_goal_event']['window']			= 'Window events';

// Success
$_['success_goal']['add']				= 'Goal of Google Analytics successfully added!';
$_['success_goal']['edit']				= 'Goal of Google Analytics successfully edited!';
$_['success_goal']['delete']			= 'Goal of Google Analytics successfully removed!';

// Error
$_['error_counter_id']					= 'Invalid tracking identifier format (counter id)!';
$_['error_timing_name']					= 'The event name must contain at least 3 and no more than 32 characters!';
$_['error_timing_category']				= 'The event category must contain at least 3 and no more than 64 characters!';
$_['error_timing_label']				= 'The event label must contain at least 3 and no more than 255 characters!';
$_['error_link_attr_name']				= 'The cookie name must contain at least 3 and no more than 32 characters!';
$_['error_link_attr_expires']			= 'Cookie expiration time must be at least 0 seconds!';
$_['error_linker_domains']				= 'Invalid domain format!';
$_['error_cookie_name']					= 'Visitors cookie name must contain at least 3 and no more than 32 characters!';
$_['error_cookie_expires']				= 'Visitors cookie expiration time must be at least 0 seconds!';
$_['error_cookie_domain']				= 'Invalid domain format in visitors cookie, or site does not belong to domain!';
$_['error_ecommerce_revenue_tax']		= 'Expenses must be at least 0 and not more than 99!';
$_['error_goal']['action_exists']		= 'A goal with such an identifier already exists!';
$_['error_goal']['action_format']		= 'Goal identifier should contain only Latin characters and numbers, and use underscores instead of spaces!';
$_['error_goal']['action_size']			= 'Goal identifier must be at least 3 and no more than 64 characters!';
$_['error_goal']['category']			= 'Goal category must be 64 characters or less!';
$_['error_goal']['label']				= 'Goal label must be 255 characters or less!';
$_['error_goal']['element']				= 'Element identifier must contain at least 2 and no more than 255 characters!';
$_['error_goal']['value']				= 'The cost of the goal can not be less than 0!';
$_['error_permission']					= 'Warning: You do not have permission to modify module!';

$_['text_help']					= '<p><b>Google Analytics v1.0 <a href="https://tramplin-studio.store/" target="blank">by Tramplin Studio</a></b> - this module itself creates the counter and sends the data of the online store to the Google Analytics tool, which helps to get visual reports, visitors actions, monitor traffic sources and evaluate advertising effectiveness. The data collected by the counter is processed on the Google servers and supplemented with various information. But the most important feature of the module is its ability to very easily set up and send <u>data on achieved goals</u>, <u>e-commerce data</u> and <u>detailed users data</u>. <u><b>With these tools you can significantly increase the conversion of your online store, which will positively affect your income.</b></u></p>
<br>
<p><b>Main settings of counter.</b></p>
	<p>Working with the module begins with the creation of a counter on the Google Analytics site. After that, copy the tracking identifier (counter id) into the module settings and it will immediately start sending data of pages and events that occurred while interacting visitors with the site. In the main settings there are the following options:
	<ul>
		<li>Counter type. There are 2 types of JS used to transfer data to Google Analytics: `analytics.js` and` gtag.js`.</li>
		<li>Counter mode. Different JS loading methods. Asynchronous mode used the data transfer method is `Beacon`.</li>
		<li>Tracking page views. May contain additional parameters.</li>
		<li>Monitoring user time for tracking page load speed. Allows you to reduce page loading time and improve the overall impression of the site. May contain additional parameters.</li>
		<li>Improved link attribution. Increases click tracking accuracy by automatically distinguishing clicks on links with the same URL on the same page. May contain additional parameters.</li>
		<li>Cross-domain tracking. Domain linker feature that allows you to register visits to multiple resources as a single session. May contain additional parameters.</li>
		<li>Advertiser features. Allows to disable all features for advertisers, remarketing and advertising reports.</li>
		<li>Tracking of the main currency of the online store.</li>
		<li>Tracking of the main country of activity of the online store.</li>
		<li>Various cookie settings for visitors.</li>
	</ul>
	</p>
	<p><font color="red">Attention!</font> Delete the default counter code from your website if it is already placed to avoid duplication of some data.</p>
	<br>
<p><b>Tracking users parameters.</b></p>
	<p>This tool can be useful for generating a report based on data obtained at the time when the visitor is on the site. Using this data, it is possible to form segments for the selection of an auditory in Google Analytics. Visitor data is passed to Google Analytics as special parameters `dimensions`. You can configure the data to be sent:
	<ul>
		<li>User ID can be: session id or registered user identifier in OpenCart;</li>
		<li>type: guest or registered;</li>
		<li>customer group if the user is registered;</li>
		<li>registration date if the user is registered;</li>
		<li>safe-status of the account that is assigned to the registered user during moderation;</li>
		<li>newsletter subscription status if the user is registered;</li>
		<li>country which entered in the address of the registered user by default;</li>
		<li>zone which entered in the address of the registered user by default;</li>
		<li>city which entered in the address of the registered user by default;</li>
		<li>postcode which entered in the address of the registered user by default;</li>
		<li>as well the values ​​of additional custom fields of registered users!</li>
	</ul>
	</p>
	<br>	
<p><b>Tracking e-commerce data.</b></p>
	<p>This is a tool that enables the collection and analysis of data which related to the e-commerce. The information that was sent is displayed on the Google Analytics website in the "E-commerce" report group.</p>
	<p>Sending data occurs when actions are performed with a product or a products set:
	<ul>
		<li>when viewing a products in lists (categories, search, manufacturers, specials, modules with products, etc);</li>
		<li>when clicking on the product in lists;</li>
		<li>when viewing the product page;</li>
		<li>when adding product to the cart;</li>
		<li>when removing product from the cart;</li>
		<li>when proceeding to checkout;</li>
		<li>after the successful completion of the order.</li>
	</ul>
	For more up-to-date statistics, the data on addition or deletion is also sent if the product quantity in the cart has been changed.<br>
	Attention! Data on adding, deleting or ordering may not always be sent or not sent at all, in the case of some modules replacing the order form on site. E-commerce data is successfully transmitted using the standard OpenCart checkout form, and if using the <u>Simple</u> and <u>FastOrder</u> modules. Work with other modules is not guaranteed!</p>
	<p>With the above actions, the following data can be sent:
	<ul>
		<li>manufacturer of the product;</li>
		<li>full category branch, but only when viewing the product page (for example: "category 1/category 2");</li>
		<li>list of products (categories, search, manufacturers, specials, modules with products, etc), but only by clicking on the product and viewing in the lists;</li>
		<li>product position in the list, if the value is not equal to 0;</li>
		<li>product price, including the tax rate;</li>
		<li>product quantity in stock, quantity when adding or removing in the cart, or quantity in the success order;</li>
		<li>variant of product, that is, the selected product options are listed separated by commas.</li>
	</ul>
	</p>
	<p>When making the order, additional data can also be sent:
	<ul>
		<li>store name which entered in OpenCart settings;</li>
		<li>income from the purchase (contain additional parameters);</li>
		<li>tax deduction on purchase;</li>
		<li>shipping costs for the purchase;</li>
		<li>coupon number with which the discount was accrued when making the order.</li>
	</ul>
	</p>
	<br>
<p><b>Tracking achievement of goals (events).</b></p>
	<p>A goal is a visitor action in which the site owner is interested: visiting a some page, clicking a button, clicking on a link, paying for an order, etc. When visitors come to your site and interact with it, Google Analytics collects information about it and records achievements of goals. Information on goals in the Google Analytics interface is available in the "Conversions" report, as well as in all standard and users reports that are generated by visits.</p>
	<p>The module allows you to create goals like "JavaScript event" easily and without interfering in the site code. Such type of goals as a "JavaScript event" allows you to track almost any casual events on the site (pressing a button, filling out a form, etc.), which does not change the URL of the page. If the URL is changing, use the type of goal “Page visits”, they are configured on the Google Analytics site.</p>
	<p>When creating a goal, you need to enter its identifier (action of goal), the element on the page and the event carried out with this element (for example: mouse click).<br>
		In addition to the required, goal settings may contain additional parameters:
		<ul>
			<li>Goal label. Used for more flexible visualization of events in reports;</li>
			<li>Goal category. Used for breaking events into logical groups;</li>
			<li>Goal cost. Used if the goal brings or affects profit.</li>
		</ul>
	</p>
	<p><u>After installing the module, you will be immediately available 25 ready-made goals</u> and will only need to copy their identifiers into the settings on the Google Analytics site. However, if you have a non-default template or other modules affecting the layout code of the site, then some goals may not work and will be require reconfiguration.</p>
	<br>
<p><b>Useful tips:</b></p>
	<ul>
		<li>If you want to receive more comprehensive data on the actions of visitors to your online store, we recommend installing our other module "<u><a href="https://tramplin-studio.store/module/ts-yandex-metrika" target="_blank">TS Yandex Metrika</a></u>". Yandex.Metrica service is the Russian analogue of Google Analytics and has similar functionality. Using both services, you will be able to compare their reports, find the middle point, which means it is better to understand your customers, reduce marketing costs and increase revenues.</li>
		<li>We also suggest that you familiarize with the module package "<u><a href="https://tramplin-studio.store/module/ts-ab-test-3-in-1" target="_blank">TS AB-Test 3 в 1</a></u>". This is a set of simple but powerful marketing tools to increase the effectiveness of your banners, sliders, HTML texts and any other design elements in OpenCart, using the analytical method "AB testing" (Split test). Thanks to this modules package, you can better convey to the visitor the necessary information, and thereby significantly increase the conversion of your online store.</li>
	</ul>';

$_['text_author']				= '<p>If you have any questions or suggestions for improving the work of the module, you can contact us:</p>
								<p>Site: <a href="https://tramplin-studio.store/" target="_blank">https://tramplin-studio.store/</a><br>
								E-mail: <a href="mailto:info@tramplin-studio.store">info@tramplin-studio.store</a></p>';
?>