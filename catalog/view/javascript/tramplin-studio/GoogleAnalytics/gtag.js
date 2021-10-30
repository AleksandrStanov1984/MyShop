/*
	Tramplin Studio - development of modules for OpenCart
	Google Analytics v1.0
*/

var gaCounterInited = false;

$.fn.extend({
	TSGoogleAnalytics: function(options) {
		var initCounterTimer;
		var options = $.extend({
			counter: {
				counter_id: 0,
				mode: false,
				pageview: {
					status: true,
					title: true,
					path: true,
					location: true,
				},
				timing: {
					status: true,
					name: 'load',
					category: 'JS Dependencies',
					label: 'Google CDN',
				},
				link_attr: {
					status: true,
					name: '_gaela',
					expires: 120,
				},
				linker: {
					status: false,
					incoming: false,
					domains: [],
				},
				ad_features: true,
				country: 'RU',
				currency: 'RUB',
				userId: '',
				userCookies: {
					name: '_ga',
					domain: '',
					expires: 63072000,
					update: true,
				},
				userParams: false,
				ecommerce: false,
				goals: false,
			},
		}, options);
		
		
		
		if (options.counter && options.ecommerce === undefined) {
			
			// gaCounter init
			initCounter(options.counter);
			
			// init Goals
			if (options.counter.goals) {
				initGoals();
			}
			
			// tracking eCommerce click and view action
			if (options.counter.ecommerce) {
				trackingEcommerceClick();
				trackingEcommerceView();
			}
			
		} else if (options.ecommerce) {
			
			// send eCommerce detail data
			sendEcommerce(options.ecommerce);
			
		} else {
			
			console.log('gaCounter: Error - not Params');
			
		}
		
		
		
		function initCounter(counter) {
			console.log('gaCounter: Counter init');
			

			// counter params for init
			var init_params = {};
			var init_logs = [];
			
			// beacon mode (asinc)
			if (counter.mode) {
				init_params.transport_type = 'beacon';
				init_logs.push('gaCounter: Beacon (asinc) mode ON');
			}
			
			// user id
			if (counter.userId) {
				init_params.user_id = counter.userId;
			}
			
			// user cookies
			if (counter.userCookies.name) {
				init_params.cookie_prefix = counter.userCookies.name;
			}
			if (counter.userCookies.domain) {
				init_params.cookie_domain = counter.userCookies.domain;
			}
			if (counter.userCookies.expires) {
				init_params.cookie_expires = counter.userCookies.expires;
			}
			if (counter.userCookies.update) {
				init_params.cookie_update = counter.userCookies.update;
			}
			init_logs.push('gaCounter: User cookies params sended');
			
			// pageview params
			if (counter.pageview.status) {
				init_params.send_page_view = true;
				init_logs.push('gaCounter: Pageview ON');
				
    			if (counter.pageview.title) {
    				init_params.page_title = document.title;
    			}
    			if (counter.pageview.path) {
    				init_params.page_path = document.location.href.replace(document.location.origin, '');
    			}
    			if (counter.pageview.location) {
    				init_params.page_location = document.location.href;
    			}
				init_logs.push('gaCounter: Pageview params sended');
			} else {
			    init_params.send_page_view = false;
				init_logs.push('gaCounter: Pageview OFF');
			}
			
			// link_attr params
			if (counter.link_attr.status) {
				init_params.link_attribution = {};
				init_logs.push('gaCounter: Link attribution ON');
				
				if (counter.link_attr.name) {
					init_params.link_attribution.cookie_name = counter.link_attr.name;
				}
				if (counter.link_attr.expires) {
					init_params.link_attribution.cookie_expires = counter.link_attr.expires;
				}
				init_params.link_attribution.levels = 3;
				init_logs.push('gaCounter: Link attribution params sended');
			} else {
				init_params.link_attribution = false;
				init_logs.push('gaCounter: Link attribution OFF');
			}
			
			// linker params
			if (counter.linker.status) {
				init_params.linker = {};
				init_logs.push('gaCounter: Linker ON');
				
				if (counter.linker.incoming) {
					init_params.linker.accept_incoming = counter.linker.incoming;
				}
				if (counter.linker.domains) {
					init_params.linker.domains = counter.linker.domains;
				}
				init_logs.push('gaCounter: Linker params sended');
			} else {
				init_params.linker = false;
				init_logs.push('gaCounter: Linker OFF');
			}
			
			// ad-features
			if (counter.ad_features) {
				init_params.allow_ad_personalization_signals = true;
				init_logs.push('gaCounter: Ad-features ON');
			} else {
				init_params.allow_ad_personalization_signals = false;
				init_logs.push('gaCounter: Ad-features OFF');
			}
			
			// country
			if (counter.country) {
				init_params.country = counter.country;
				init_logs.push('gaCounter: Country param sended');
			}
			
			// currency
			if (counter.currency) {
				init_params.currency = counter.currency;
				init_logs.push('gaCounter: Currency param sended');
			}
			
			// user params
			if (counter.userParams) {
				var cmp = 1;
				var custom_map_params = {};
				$.each( counter.userParams, function(key, value) {
					custom_map_params['dimension' + cmp] = key;
					cmp++;
				});
				init_params.custom_map = custom_map_params;
			}
			
			
			// gaCounter init
			gtag('js', new Date());
			gtag('config', counter.counter_id, init_params);
			//console.log( {'init_params': init_params} );
			gaCounterInited = true;
			
			// write init logs
			console.log('gaCounter: Counter inited');
			$.each( init_logs, function(key, log) {
				console.log(log);
			});
			
			
			// timing params
			if (counter.timing.status) {
				if (window.performance) {
					var timing_params = {};
					timing_params.value = Math.round(performance.now());
					if (counter.timing.name) {
						timing_params.name = counter.timing.name;
					}
					if (counter.timing.category) {
						timing_params.event_category = counter.timing.category;
					}
					if (counter.timing.label) {
						timing_params.event_label = counter.timing.label;
					}
					//console.log({timing_params: timing_params});
					gtag('event', 'timing_complete', timing_params);
					console.log('gaCounter: Timing ON');
					console.log('gaCounter: Timing params sended');
				} else {
					console.log('gaCounter: Timing params sending error - browser not support "Navigation Timing API"');
				}
			}

			
			// send User Params
			if (counter.userParams) {
				var user_params = {};						
				$.each( counter.userParams, function(key, value) {
					user_params[key] = value ? value : '';
				});
				//console.log({user_params: user_params});
				gtag('event', 'userParams', user_params);
				console.log('gaCounter: User params sended');
			}
			
		}
		
		
		function initGoals() {
			$.ajax({
				url: 'index.php?route=extension/analytics/ts_google_analytics/getGoals',
				method: 'post',
				dataType: 'json',
				data: {data: ''},
				cache: false,
				success: function(json) {
					if (!json.error) {
						//console.log(json.goals);
						$.each( json.goals, function(key, goal) {
							var goal_params = {};
							if (goal.category) {
								goal_params.event_category = goal.category;
							}
							if (goal.label) {
								goal_params.event_label = goal.label;
							}
							if (goal.value) {
								goal_params.value = goal.value;
							}
							//console.log({goal_action: goal.action, goal_params: goal_params});
							$(document).on(goal.event, goal.element, function () {
								gtag('event', goal.action, goal_params);
								console.log('gaCounter: Goal "' + goal.action + '" achieved');
							});
						});
						
						console.log('gaCounter: Goals inited');
					}
				}
			});
		}
		
		function sendEcommerce(ecommerce) {
			initCounterTimer = setTimeout(function() {
				if (!gaCounterInited) {
					sendEcommerce(ecommerce.params, ecommerce.event);
				} else {
					var ecommerce_event = getEcommerceEventName(ecommerce.event);
					if (ecommerce_event == 'purchase') {
						delete ecommerce.params.coupon;
					}
					//console.log({event: ecommerce_event, params: ecommerce.params});
					gtag('event', ecommerce_event, ecommerce.params);
					console.log('gaCounter: eCommerce sended');
					clearTimeout(initCounterTimer);
				}
			}, 200);
		}
		
		function trackingEcommerceClick() {
			$(document).on('click', '.ts-ga-ecommerce-product a', function () {
				var product = $(this).closest('.ts-ga-ecommerce-product');
				var list_name = product.data('list');
				var product_id = product.data('product');
				var list_position = product.data('position');
				$.ajax({
					url: 'index.php?route=extension/analytics/ts_google_analytics/trackingEcommerceClick',
					method: 'post',
					dataType: 'json',
					data: {data: { list_name: list_name, product_id: product_id, list_position: list_position } },
					cache: false,
					success: function(json) {
						if (json.success) {
							//console.log();
						}
					}
				});
			});
		}
		
		function trackingEcommerceView() {
			setInterval(function() {
				if (gaEcommerceViewList.length) {
					$.ajax({
						url: 'index.php?route=extension/analytics/ts_google_analytics/trackingEcommerceView',
						method: 'post',
						dataType: 'json',
						data: {data: gaEcommerceViewList },
						cache: false,
						success: function(json) {
							if (json.success) {
								//console.log(gaEcommerceViewList);
								gaEcommerceViewList = [];
							}
						}
					});
				}
			}, 1000);
		}
		
		function getEcommerceEventName(event) {
			var events = {
				'view':			'view_item_list',
				'click':		'select_content',
				'detail':		'view_item',
				'add':			'add_to_cart',
				'remove':		'remove_from_cart',
				'checkout':		'begin_checkout',
				'purchase':		'purchase'
			};
			return events[event];
		}

	}
});

var gaEcommerceViewList = [];
var gaEcommerceViewList2 = [];
$(function() {
	$('.ts-ga-ecommerce-product').each(function () {
		var product = $(this);
		setInterval(function() {
			if (gaCounterInited) {
				var screenTop = $(window).scrollTop();
				var screenBottom = screenTop + screen.height;
				var elemTop = product.offset().top;
				var elemBottom = elemTop + product.height();
				
				var list_name = product.data('list');
				var product_id = product.data('product');
				var list_position = product.data('position');
				
				if ((elemTop >= screenTop) && (elemBottom <= screenBottom)) {
					var listNotExists = true;
					$.each( gaEcommerceViewList2, function(key, value) {
						if (value.list_name == list_name && value.product_id == product_id && value.list_position == list_position) {
							listNotExists = false;
						}
					});
					if (listNotExists) {
						gaEcommerceViewList[gaEcommerceViewList.length] = {list_name: list_name, product_id: product_id, list_position: list_position};
						gaEcommerceViewList2[gaEcommerceViewList2.length] = {list_name: list_name, product_id: product_id, list_position: list_position};
					}
				}
			}
		}, 100);
	});
});