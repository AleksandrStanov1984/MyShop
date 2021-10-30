<?php if(isset($owlmodules) && $owlmodules) { ?>
		<?php for ($i=0; $i < count($owlmodules); $i++) { ?>
			<div id="owlcarousel-<?php echo $owlmodules[$i]; ?>" class="owlcarousel-by-scroll" data-id="<?php echo $owlmodules[$i]; ?>"></div>
		<?php } ?>
		<script>
			(function($) {
			  $(document).ready(function() {

			  	$('.j-tab-switcher').on('click', function (e){
	            e.preventDefault();
	            $('.j-tab-switcher.active').removeClass('active');
	            $(this).addClass('active');
	            var tab = $(this).find('a').attr('href');
	            $('.tab-content-carousel .tab-pane-carousel.active').removeClass('active')
	            $(tab).addClass('active loading-tab-carousel');


	            setTimeout(function(){$(tab).removeClass('loading-tab-carousel');}, 700);


	        });

			  	function random(owlSelector){
						owlSelector.children().sort(function(){
							return Math.round(Math.random()) - 0.5;}).each(function(){$(this).appendTo(owlSelector);
						});
					}

					function initOwlCarousel($mid, $show_loop, $show_nav, $show_random_item) {
						var owl = $("#owl-" + $mid);
	          owl.owlCarousel({
	              dots:false,
	              loop: $show_loop,
	              navText: ['<i></i>','<i></i>'],
	              nav: $show_nav,
	              responsiveClass:true,
	              responsive:{
			            0:{
			                loop:false,
			                mouseDrag: false,
			                touchDrag: false,
			                autoWidth: false,
			                items: 2.5,
			                margin: 18,
			                nav: false
			            },
			            375:{
			                loop:false,
			                items: 2.7,
			                autoWidth: false,
			                margin: 18,
			                nav: false
			            },
			            479:{
			                loop:false,
			                items: 2.9,
			                autoWidth: false,
			                margin: 18
			            },
			             500:{
			                loop:false,
			                items: 3.2,
			                margin: 18,
			                autoWidth: false,
			                nav: false
			            },
			            600:{
			                loop:false,
			                items: 3.8,
			                autoWidth: false,
			                nav: false,
			                margin: 18,
			            },
			            768:{
			                mouseDrag: true,
			                touchDrag: true,
			                nav: true,
			                loop: $show_loop,
			                items: 2
			            },
			            900:{
			                mouseDrag: true,
			                loop: $show_loop,
			                touchDrag: true,
			                nav: true,
			                items: 2
			            },
			            992:{
			                nav:true,
			                loop: $show_loop,
			                items: 3
			            },
			            1199:{
			                nav:true,
			                loop: $show_loop,
			                items: 5
			            }
			        	},
	              beforeInit : function(elem){
	              	if($show_random_item == 'true') {
	              		random(elem)
	              	}
	              ;},
	          });

					}

					function initOwlCarouselAccount($mid, $show_loop, $show_nav, $show_random_item, $loop) {
						var owl = $("#owl-" + $mid);
	          owl.owlCarousel({
	              dots:false,
	              navText: ['<i id="prev_carousel_account"></i>','<i id="next_carousel_account"></i>'],
	              responsiveClass:true,
	              responsive:{
                    0:{
                        loop:false,
                        mouseDrag: false,
                        touchDrag: false,
                        autoWidth: false,
                        items: 2.5,
                        nav: false,
                    },
                    375:{
                        loop:false,
                        items: 2.7,
                        autoWidth: false,
                    },
                    479:{
                        loop:false,
                        items: 2.9,
                        autoWidth: false,
                    },
                     500:{
                        loop:false,
                        items: 3.2,
                        autoWidth: false,
                        nav: false
                    },
                    600:{
                        loop:false,
                        items: 3.8,
                        autoWidth: false,
                        nav: false
                    },
                    768:{
                        mouseDrag: true,
                        touchDrag: true,
                        nav: true,
                        loop: $loop,
                        items: 2
                    },
                    900:{
                        mouseDrag: true,
                        loop: $loop,
                        touchDrag: true,
                        nav: true,
                        items: 3
                    },
                    1150:{
                        nav:true,
                        loop: $loop,
                        items: 4
                    },
                    1260:{
                        nav:true,
                        loop: $loop,
                        items: 5
                    },
                    1390:{
                        nav:true,
                        loop: $loop,
                        items: 6
                    }
                },
	              beforeInit : function(elem){
	              	if($show_random_item == 'true') {
	              		random(elem)
	              	}
	              ;},
	          });

					}

					// Простая очередь
					$.qajaxSimple = function (url, blockId) {
					    var intervalTimeout = 1500;
					    
					    $._qajaxSimpleQueue = $._qajaxSimpleQueue || [];
					    
					    $._qajaxSimpleQueue.push({
					        url: url,
					        options: blockId
					    });
					    
					    $._qajaxSimpleInterval = $._qajaxSimpleInterval ||
					        setInterval(function () {
					            var params = $._qajaxSimpleQueue.shift();
					            if(params) {
					                $.ajax({
											      url: params.url,
											      type: 'get',
											      dataType: 'json',
											      cache: false,
											      success: function(json) {

											      	if(json['error']) {
											      		$('#'+params.options).html();
											      		console.log(json['error']);
											      	} else {

											      		if(json['template']) {
												        	 $('#'+params.options).html(json['template']);
												        }

												        if(json['template_name'] == 'account' && !json['hide']) {
												        	initOwlCarouselAcount(json['module'], json['show_loop'], json['show_nav'], json['show_random_item'], json['loop']);
												        } else if(!json['hide']) {
												        	initOwlCarousel(json['module'], json['show_loop'], json['show_nav'], json['show_random_item']);
												        }
												        

											      	}

											      	if(json['hide']) {
											      		$('#'+params.options).remove();
											      	}

											        

											      }
											    });
					            }
					        }, intervalTimeout);
					};

			  	windowHeight = $(window).height();

			    //$(window).scroll(function () {

			        if($(window).width() < 768 + 15) {
			            ofsetInit = windowHeight - 450; 
			        } else {
			            ofsetInit = windowHeight - 550;
			        }
			        

			        $('.owlcarousel-by-scroll').each(function() {
		              //if ($(window).scrollTop() + windowHeight + ofsetInit > $(this).offset().top) {

		              		if(!$(this).hasClass('showed')) {

		              			
			                  $(this).addClass('showed');
			                  var owlModuleId = $(this).attr("data-id");
			                  var blockId = $(this).attr("id");

			                  $('#'+blockId).html('<div style="text-align:center"><img src="image/spinner.gif"></div>');

			                  $.qajaxSimple('index.php?route=extension/module/owlcarousel/crossdomainRequest&module_id=' +  encodeURIComponent(owlModuleId) + '&product_id=' + encodeURIComponent(<?php echo $product_id; ?>), blockId);
			                  /*$.ajax({
										      url: 'index.php?route=extension/module/owlcarousel/crossdomainRequest&module_id=' +  encodeURIComponent(owlModuleId),
										      type: 'get',
										      dataType: 'json',
										      success: function(json) {
										        console.log(json);

										        if(json['template']) {
										        	$this.html(json['template']);
										        }

										        initOwlCarousel(json['module'], json['show_loop'], json['show_nav'], json['show_random_item']);

										      }
										    }); */

										  }



		              //} 
		          });

				  //});  

				}); 
			})( jQuery );
		</script>
<?php } ?>
<?php foreach ($modules as $module) { ?>
<?php echo $module; ?>
<?php } ?>