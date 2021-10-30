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
			
			// linker incoming param, user cookies params and user id for init
			var init_params = {};
			if (counter.userId) {
				init_params.userId = counter.userId;
			}
			if (counter.userCookies.incoming) {
				init_params.cookieName = counter.userCookies.name;
			}
			if (counter.userCookies.domain) {
				init_params.cookieDomain = counter.userCookies.domain;
			}
			if (counter.userCookies.expires) {
				init_params.cookieExpires = counter.userCookies.expires;
			}
			if (counter.linker.incoming) {
				init_params.allowLinker = counter.linker.incoming;
			}
			//console.log({init_params: init_params});
			
			// gaCounter init
			if (counter.userCookies.domain) {
				ga('create', counter.counter_id, init_params);
			} else {
				ga('create', counter.counter_id, 'auto', init_params);
			}
			
			// gaCounter inited
			console.log('gaCounter: Counter inited');
			console.log('gaCounter: User cookies params sended');
			gaCounterInited = true;
			
			// beacon mode (asinc)
			if (counter.mode) {
				ga('set', 'transport', 'beacon');
				console.log('gaCounter: Beacon (asinc) mode ON');
			}
			
			// pageview params
			if (counter.pageview.status) {
				ga('send', 'pageview');
				console.log('gaCounter: Pageview ON');
				var pageview_params = {};
				if (counter.pageview.title) {
					pageview_params.title = document.title;
				}
				if (counter.pageview.path) {
					pageview_params.page = document.location.href.replace(document.location.origin, '');
				}
				if (counter.pageview.location) {
					pageview_params.location = document.location.href;
				}
				//console.log({pageview_params: pageview_params});
				ga('set', pageview_params);
				console.log('gaCounter: Pageview params sended');
			} else {
				console.log('gaCounter: Pageview OFF');
			}
			
			// timing params
			if (counter.timing.status) {
				if (window.performance) {
					var timing_params = {};
					timing_params.hitType = 'timing';
					timing_params.timingValue = Math.round(performance.now());
					if (counter.timing.name) {
						timing_params.timingVar = counter.timing.name;
					}
					if (counter.timing.category) {
						timing_params.timingCategory = counter.timing.category;
					}
					if (counter.timing.label) {
						timing_params.timingLabel = counter.timing.label;
					}
					//console.log({timing_params: timing_params});
					ga('send', timing_params);
					console.log('gaCounter: Timing ON');
					console.log('gaCounter: Timing params sended');
				} else {
					console.log('gaCounter: Timing params sending error - browser not support "Navigation Timing API"');
				}
			}
			
			// link_attr params
			if (counter.link_attr.status) {
				ga('require', 'linkid');
				console.log('gaCounter: Link attribution ON');
				var link_attr_params = {};
				if (counter.link_attr.name) {
					link_attr_params.cookieName = counter.link_attr.name;
				}
				if (counter.link_attr.expires) {
					link_attr_params.duration = counter.link_attr.expires;
				}
				//console.log({link_attr_params: link_attr_params});
				ga('require', 'linkid', link_attr_params);
				console.log('gaCounter: Link attribution params sended');
			} else {
				console.log('gaCounter: Link attribution OFF');
			}
			
			// linker params
			if (counter.linker.status) {
				ga('require', 'linker');
				console.log('gaCounter: Linker ON');
				if (counter.linker.domains) {
					ga('linker:autoLink', counter.linker.domains, false, true);
				}
				//console.log({linker_incoming: counter.linker.incoming, linker_domains: counter.linker.domains});
				console.log('gaCounter: Linker params sended');
			} else {
				console.log('gaCounter: Linker OFF');
			}
			
			// ad-features
			if (counter.ad_features) {
				ga('require', 'displayfeatures');
				console.log('gaCounter: Ad-features ON');
			} else {
				ga('set', 'allowAdFeatures', false);
				console.log('gaCounter: Ad-features OFF');
			}
			
			// country
			/*if (counter.country) {
				ga('set', 'countryCode', counter.country);
				console.log('gaCounter: Country param sended');
			}*/
			
			// currency
			if (counter.currency) {
				ga('set', 'currencyCode', counter.currency);
				console.log('gaCounter: Currency param sended');
			}
			
			// send User Params
			if (counter.userParams) {
				var cmp = 1;
				var user_params = {};						
				$.each( counter.userParams, function(key, value) {
					user_params['dimension' + cmp] = value ? value : '';
					cmp++;
				});
				//console.log({user_params: user_params});
				//ga('set', user_params); //send for all life time of dataLayer
				ga('send', 'event', 'userParams', 'userParams', user_params);
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
							goal_params.hitType = 'event';
							goal_params.transport = 'beacon';
							if (goal.action) {
								goal_params.eventAction = goal.action;
							}
							if (goal.category) {
								goal_params.eventCategory = goal.category;
							}
							if (goal.label) {
								goal_params.eventLabel = goal.label;
							}
							if (goal.value) {
								goal_params.eventValue = goal.value;
							}
							//console.log({goal_params: goal_params});
							$(document).on(goal.event, goal.element, function () {
								ga('send', goal_params);
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
					ga('require', 'ec');
					var ecommerce_event = getEcommerceEventName(ecommerce.event);
					var click_list = '';
					$.each( ecommerce.params.items, function(product_key, product) {
						var product_params = {};
						$.each( product, function(param_key, param) {
							product_params[getEcommerceParamName(param_key)] = param;
						});
						if (ecommerce_event == 'view') {
							ga('ec:addImpression', product_params);
						} else {
							click_list = product_params.list;
							delete product_params.list;
							ga('ec:addProduct', product_params);
						}
						//console.log({event: ecommerce_event, product_params: product_params});
					});
					if (ecommerce_event == 'click') {
						ga('ec:setAction', ecommerce_event, {'list': click_list});
						//console.log({event_set: ecommerce_event, click_params: {'list': click_list}});
					} else if (ecommerce_event == 'purchase') {
						var purchase_params = {};
						$.each( ecommerce.params, function(param_key, param) {
							purchase_params[getEcommerceParamName(param_key)] = param;
						});
						delete purchase_params.items;
						ga('ec:setAction', ecommerce_event, purchase_params);
						//console.log({event_set: ecommerce_event, purchase_params: purchase_params});
					} else {
						//console.log({event_set: ecommerce_event});
						ga('ec:setAction', ecommerce_event);
					}
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
				'view':			'view',
				'click':		'click',
				'detail':		'detail',
				'add':			'add',
				'remove':		'remove',
				'checkout':		'checkout',
				'purchase':		'purchase'
			};
			return events[event];
		}
		function getEcommerceParamName(param) {
			var params = {
				'id':				'id',
				'name':				'name',
				'brand':			'brand',
				'category':			'category',
				'variant':			'variant',
				'price':			'price',
				'quantity':			'quantity',
				'list_position':	'position',
				'list_name':		'list',
				'coupon':			'coupon',
				'transaction_id':	'id',
				'affiliation':		'affiliation',
				'value':			'revenue',
				'tax':				'tax',
				'shipping':			'shipping',
				'currency':			'currency',		//not used
				'content_type':		'content_type',	//not used
				'items':			'items'			//not used
			};
			return params[param];
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

