<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <?php foreach ($analytics as $analytic) { ?>
    <?php echo $analytic; ?>
    <?php } ?>
    <meta charset="utf-8"/>
    <title>
        <?php echo $title; ?>
    </title>
    <?php if(isset($noindex)) { ?>
    <!-- OCFilter Start -->
    <meta name="robots" content="noindex,nofollow" />
    <!-- OCFilter End -->
    <?php } ?>
    <base href="<?php echo $base; ?>"/>
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?php echo $og_title; ?>" />
    <meta property="og:url" content="<?php echo $og_url; ?>" />
    <meta property="og:description" content="<?php echo $og_description; ?>" />
    <meta property="article:author" content="https://www.facebook.com/www.sz.ua" />
    <meta property="og:image" content="<?php echo $og_image; ?>" />
    <meta property="og:publisher" content="https://www.facebook.com/www.sz.ua" />
    <meta property="og:site_name" content="<?php echo $og_site_name; ?>" />
    <?php
    if ($description) { ?>
    <meta name="description" content="<?php echo $description; ?>"/>
    <?php } ?>
    <?php if ($keywords) { ?>
    <meta name="keywords" content="<?php echo $keywords; ?>"/>
    <?php } ?>
    <link rel="preload" href="catalog/view/theme/OPC080193_6/fonts/montserrat/Montserrat-Light.woff" as="font" type="font/woff" crossorigin>
    <link rel="preload" href="catalog/view/theme/OPC080193_6/fonts/montserrat/Montserrat-Thin.woff" as="font" type="font/woff" crossorigin>
    <link rel="preload" href="catalog/view/theme/OPC080193_6/fonts/montserrat/Montserrat-SemiBold.woff" as="font" type="font/woff" crossorigin>
    <link rel="preload" href="catalog/view/theme/OPC080193_6/fonts/montserrat/Montserrat-ExtraLight.woff" as="font" type="font/woff" crossorigin>
    <link rel="preload" href="catalog/view/theme/OPC080193_6/fonts/montserrat/Montserrat-Bold.woff" as="font" type="font/woff" crossorigin>
    <link rel="preload" href="catalog/view/theme/OPC080193_6/fonts/montserrat/Montserrat-Regular.woff" as="font" type="font/woff" crossorigin>
    <link rel="preload" href="catalog/view/theme/OPC080193_6/fonts/montserrat/Montserrat-Medium.woff" as="font" type="font/woff" crossorigin>
    <link rel="apple-touch-icon" sizes="57x57" href="/image/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/image/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/image/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/image/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/image/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/image/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/image/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/image/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/image/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/image/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/image/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/image/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/image/favicon/favicon-16x16.png">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/image/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#fff">
    <!-- Адаптируем страницу для мобильных устройств -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Подключаем файлы стилей -->

    <?php

    // {literal}
    $cssClearing = [
        'patterns' => [
    '/\/\*.*?\*\//s',
    '/\s\s+(.*)/',
    '/([,;:])[\s\n\r]*/',
    '/\;}/',
    '/([\r\s\n]*)?(\{|\})([\r\s\n]*)?/s',
    '/url\s*\((\'|\")?\./s',
    ],
    'replacing' => [
    '',
    ' $1',
    '$1',
    '}',
    '$2',
    'url($1%script_directory%/.',
    ],
    ];
    $jsClearing = [
    'patters' => [
    '/(\/\*.*\*\/)|(\/\/.*\n)/sU',
    '/\s+/s',
    '/\n\n*/s',
    '/(\)|\}) (\$|jQuery|var|return|this)/s',
    ],
    'replacing' => [
    "\n\n\n",
    ' ',
    "\n",
    '$1;$2',
    ],
    ];
    // {/literal}
    $cssNoInline = [
    'ocfilter/ocfilter.css',
    ];
    $inlineStyles = [];
    $linkedStyles = [];
    foreach(array_merge([
    ["rel" => "stylesheet", "href" => "catalog/view/theme/%mytemplate%/assets/reset.css#cf-inline=true"],
    ["rel" => "stylesheet", "href" => "catalog/view/theme/%mytemplate%/assets/slick.css?ver1.195#cf-inline=true"],
    ["rel" => "stylesheet", "href" => "catalog/view/theme/OPC080193_6/assets/bootstrap4-grid.min.css#cf-inline=true"],
    ["rel" => "stylesheet", "href" => "catalog/view/theme/%mytemplate%/assets/style.css?ver3.46#cf-inline=true"],
    ["rel" => "stylesheet", "href" => "catalog/view/theme/%mytemplate%/assets/header.css?ver3.43#cf-inline=true"],
    ], $styles) as $src) {
    $src["href"] = str_replace("%mytemplate%", $mytemplate, $src["href"]);
    if ($src['load-inline']??false) {
    $output = file_get_contents($src['href']);
    $inlineStyles[] = "\n\n/**{$src['href']}*/\n{$output}";
    continue;
    }
    $file = preg_split('/\?|\#/',DIR_APPLICATION . substr($src['href'], 8))[0];

    if (!isset($src['media'])) {
    $src['media'] = 'screen';
    }

    $noInline = false;
    foreach($cssNoInline as $inner) {
    if (strpos($src['href'], $inner) !== false) {
    $noInline = true;
    }
    }

    if ((is_file($file) && (filesize($file) < 25000) && !$noInline) || (strpos($src['href'], '#cf-inline=true') !== false)) {
    //{literal}
    $output = file_get_contents($file);
    if (strpos($src['href'], '#cf-minify=false') === False) {
    $output = preg_replace($cssClearing['patterns'], $cssClearing['replacing'], $output);
    }
    $output = str_replace('%script_directory%', dirname($src['href']), $output);
    //{/literal}
    $src['href'] = explode('#', $src['href'])[0];
    $inlineStyles[] =  "\n\n/**{$src['href']}*/\n@media {$src['media']} {{$output}}\n";
    } else {
    $src['href'] = explode('#', $src['href'])[0];
    $linkedStyles[] = "<link rel=\"{$src['rel']}\" href=\"{$src['href']}\" media=\"{$src['media']}\"/>";
    }
    }
    $inlineStyles = implode('', $inlineStyles);
    print "<style>{$inlineStyles}</style>";
    print implode('', $linkedStyles);
    ?>
    <script src="catalog/view/theme/OPC080193_6/js/jquery-1.11.0.min.js"></script>
    <?php
    $inlineScripts = [];
    $linkedScripts = [];
    foreach(array_merge([
        /*"catalog/view/theme/OPC080193_6/js/jquery-1.11.0.min.js#cf-force-inline=true#cf-minify=false",*/
        /*"catalog/view/theme/%mytemplate%/js/jquery.lazyloadxt.min.js#cf-force-inline=true#cf-minify=false",*/
        "catalog/view/theme/OPC080193_6/js/slick.min.js#cf-force-inline=true#cf-minify=false",
        "catalog/view/javascript/megnor/bootstrap-notify.min.js#cf-force-inline=true",
        "catalog/view/theme/OPC080193_6/js/scripts.js?ver3.93#cf-defer=true&cf-async=true",
        "catalog/view/javascript/common.js?ver2.44#cf-defer=false&cf-async=false",
    ], $scripts) as $src) {
        $src = str_replace("%mytemplate%", $mytemplate, $src);
        $file = preg_split('/\?|\#/',DIR_APPLICATION . substr($src, 8))[0];
        if (strpos($src, "owl-carousel/owl.carousel.min.js")!==false) {
            $src.="#cf-force-inline=true#cf-minify=false";
        }
        if ((strpos($src, "cf-force-inline=true") !== false) || ((filesize($file) < 25000))) {
            // {literal}
            $output = file_get_contents($file);
            if (strpos($src, 'cf-minify=false') === false) {
                $output = preg_replace($jsClearing['patters'], $jsClearing['replacing'], $output);
            }
            // {/literal}
            $src = explode('#', $src)[0];
            $inlineScripts[] = "\n\n/** {$src} */\n{$output}\n";
        } else {
            $defer = '';
            $async = '';
            if (strpos($src, "cf-defer=true")!==false) {
                $defer = ' defer';
            }
            if (strpos($src, "cf-async=true")!==false) {
                $async = ' async';
            }
            $src = explode('#', $src)[0];
            $linkedScripts[] = "\n<script src=\"{$src}\"{$async}{$defer}></script>";
    }
    }
    $inlineScripts = implode('', $inlineScripts);
    print "<script>{$inlineScripts}</script>";
    print implode('', $linkedScripts);

    ?>
    <?php foreach ($links as $link) { ?>
    <link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>"/>
    <?php } ?>

    <?php ob_start();?>
    <!-- Убераем из вывода -->

    <link rel="stylesheet" href="catalog/view/theme/<?php echo $mytemplate; ?>/css/reset.css"/>
    <link rel="stylesheet" href="catalog/view/theme/<?php echo $mytemplate; ?>/css/slick.css?ver2.2"/>

    <link rel="preload" href="catalog/view/theme/<?php echo $mytemplate; ?>/css/style.css?ver3.35"/>


    <?php foreach ($styles as $style) { ?>
    <link rel="stylesheet" href="<?php echo $style['href']; ?>" rel="<?php echo $style['rel']; ?>"
          media="<?php echo $style['media']; ?>"/>
    <?php } ?>


    <script defer src="catalog/view/theme/<?php echo $mytemplate; ?>/js/jquery-1.11.0.min.js"></script>
    <script defer src="catalog/view/javascript/jquery/ui/jquery-ui.min.js"></script>
    <script defer src="catalog/view/theme/<?php echo $mytemplate; ?>/js/slick.js"></script>


    <script defer src="catalog/view/javascript/megnor/bootstrap-notify.min.js"></script>
    <script defer src="catalog/view/theme/<?php echo $mytemplate; ?>/js/scripts.js?ver3.61"></script>
    <script defer src="catalog/view/javascript/common.js?ver2.30" ></script>
    <?php foreach ($scripts as $script) { ?>
    <script defer src="<?php echo $script; ?>"></script>
    <?php } ?>
    <?php ob_end_clean(); ?>
    <style>
        .white-popup {
            position: relative;
            background: #FFF;
            padding: 20px;
            width: auto;
            max-width: 700px;
            margin: 20px auto;
        }
        .mfp-zoom-in .mfp-content > div {
            opacity: 0;
            transition: all 0.2s ease-in-out;
            transform: scale(0.7);
        }
        .mfp-zoom-in.mfp-ready .mfp-content > div {
            opacity: 1;
            transform: scale(1);
        }
        .mfp-zoom-in.mfp-removing .mfp-content > div {
            transform: scale(0.7);
            opacity: 0;
        }
    </style>
</head>

<body id="szbody" class="<?php echo $is_mobile ? 'is_mobile' : ''; ?> <?php echo $class_page; ?>">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WZN8BFK"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div class="remodal-overlay remodal-is-opened" id="overlay-popup2"></div>
<div class="site-overlay"></div>
<div class="envelop_header">
    <div class="beanie">
        <header class="header">
            <div class="wrapper wrapper-wide">
                <?php if (isset($tongue_home)&&$tongue_home) { ?>
                <div class="tongue-home">
                    <a href="/">
                        <img src="/catalog/view/theme/OPC080193_6/image/icons/home-white.svg" alt="home">
                    </a>
                </div>
                <?php } ?>

                <ul class="header_nav-left">
                    <li class="header_nav__ip">
                        <?php if (($ip_info??false) && ($ip_info['info']??false)) { ?>
                        <div class="ip-info" data-remodal-target="modal-city"><span id="header_city" class="ip-info__city"><?php print $ip_info['info']; ?></span>
                        </div>
                        <?php } ?>
                    </li>
                    <?php foreach ($informations as $information) { ?>
                    <li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
                    <?php } ?>
                    <li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
                </ul>
                <div class="city-possible <?php echo $show_city_possible ? 'hidden': '' ?>"><div class="city-possible__name"><?php echo $text_question_city; ?> <span id="city-possible__name"><?php print $ip_info['info']; ?></span>?</span></div><button type="button" class="btn-main city-possible__yes"><?php echo $text_yes; ?></button><button type="button" data-remodal-target="modal-city" class="city-possible__show"><?php echo $text_choose_another_city; ?></button></div>
                <div class="header_nav-right">
                    <div class="phones" id="block-phones-header">
                        <div class="phones-board">
                            <div>
                                <a href="javascript:void(0)" class="main-phone binct-phone-number-1">
                                    <?php echo $telephone; ?></a><img src="catalog/view/theme/OPC080193_6/images/phone_arrow_down.svg" class="phone-board-arrow" alt="arrow">
                            </div>
                        </div>
                        <div class="all-phone">
                            <a href="tel:0660204021" class="tel tel-mts binct-phone-number-2" rel="nofollow">066 02 04 021</a>
                            <a href="tel:0980204021" class="tel tel-kyiv binct-phone-number-3" rel="nofollow">098 02 04 021</a>
                            <a href="tel:0930204021" class="tel tel-life"><!--<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="catalog/view/theme/<?php echo $mytemplate; ?>/images/icon/0930204021.svg" class="lazy-sz" alt="phone">-->093 02 04 021</a>
                            <a href="tel:0444997668" class="tel tel-city"><!--<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="catalog/view/theme/<?php echo $mytemplate; ?>/images/icon/0444497686.svg" class="lazy-sz" alt="phone">-->044 499 76 68</a>
                        </div>
                    </div>
                    <div class="callback">
                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0)">
                                <path d="M9.73759 7.71557L7.71356 6.36577C7.4567 6.19586 7.11239 6.25177 6.9225 6.49425L6.33292 7.2523C6.25715 7.35221 6.11942 7.38119 6.0098 7.3203L5.89765 7.25847C5.52587 7.05583 5.06328 6.80354 4.13126 5.87118C3.19923 4.93882 2.94643 4.47588 2.74379 4.10478L2.68229 3.99263C2.62056 3.88304 2.64899 3.74472 2.74894 3.66834L3.50648 3.07894C3.74887 2.88902 3.80486 2.54482 3.63514 2.28788L2.28534 0.263849C2.1114 0.00220808 1.76243 -0.0763349 1.49315 0.0855355L0.646773 0.593956C0.380836 0.7503 0.185728 1.0035 0.102361 1.30051C-0.202418 2.41101 0.0268647 4.32756 2.85012 7.15114C5.09596 9.39681 6.76788 10.0007 7.91704 10.0007C8.18151 10.0019 8.44495 9.96745 8.70026 9.89841C8.99733 9.81514 9.25057 9.62002 9.40682 9.354L9.91575 8.50813C10.0779 8.2388 9.99935 7.88961 9.73759 7.71557Z" fill="#9F97B8"/>
                            </g></svg>
                        <a href="javascript: void(0);" onClick="window.BinotelGetCall['33479'].openPassiveForm('<h4>Замовити дзвінок</h4><label>Номер телефону</label>');" class="callback_link ">
                            <?php echo $text_callback3 ?></a>
                    </div>
                    <?php echo $language; ?>
                </div>

            </div>
        </header>
        <div class="header-mob high-header <?php echo $logged ? 'header-user-logged' : ''; ?>" id="header-mob">
            <div class="wrapper wrapper-wide">
                <div class="toggle-menu" <?php echo !$is_mobile ? 'style="display: none"' : ''; ?>>
                <span></span>
            </div>
            <div style="width: 238px; height: 100%; margin-right: 50px; <?php echo $is_mobile ? 'display: none' : ''; ?>" class="hidden-xs hidden-sm">
                <div class="logo">
                    <?php if (isset($home)) { ?><a href="<?php echo $home ?>"><?php } ?>
                        <img src="catalog/view/theme/<?php echo $mytemplate; ?>/images/logo.svg" alt="SMARTZONE" title="SMARTZONE" class="img-logo"/>
                        <?php if (isset($home)) { ?></a><?php } ?>
                </div>
            </div>

            <?php echo $search; ?>
            <div class="wishlist-header">
                <a href="<?php echo $wishlist; ?>" id="wishlist-total" title="<?php echo $text_wishlist; ?>"><span class="scoreboard"><?php echo $text_wishlist_total; ?></span><svg height="20" viewBox="0 0 24 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21.6472 1.96468C20.5324 0.697724 18.9859 0 17.2926 0C14.9111 0 13.4033 1.42463 12.5579 2.61978C12.3385 2.92991 12.1519 3.24088 11.9953 3.5335C11.8386 3.24088 11.6521 2.92991 11.4327 2.61978C10.5872 1.42463 9.07946 0 6.69796 0C5.00467 0 3.45817 0.697768 2.34335 1.96472C1.28 3.17332 0.694336 4.79196 0.694336 6.52248C0.694336 8.4062 1.42859 10.1582 3.00507 12.0362C4.41402 13.7146 6.441 15.4447 8.78819 17.448C9.66283 18.1946 10.5673 18.9666 11.5302 19.8104L11.5591 19.8358C11.684 19.9453 11.8396 20 11.9953 20C12.1509 20 12.3066 19.9453 12.4314 19.8358L12.4603 19.8104C13.4233 18.9666 14.3277 18.1946 15.2025 17.448C17.5496 15.4447 19.5765 13.7146 20.9855 12.0362C22.562 10.1582 23.2962 8.4062 23.2962 6.52248C23.2962 4.79196 22.7106 3.17332 21.6472 1.96468Z" fill="white"/>
                    </svg></a>
            </div>
            <div class="account-header <?php echo $logged ? 'user-logged' : ''; ?>">
                <a href="<?php echo $account_edit; ?>" title="<?php echo $text_account_title; ?>" class="account-header-link"><svg height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.584473 16.5003C0.584468 16.5725 0.60004 16.6437 0.63012 16.7092C0.660199 16.7748 0.704075 16.833 0.758736 16.8799C0.907169 17.0073 4.44616 20 9.06992 20C13.6937 20 17.2327 17.0073 17.3811 16.8799C17.4358 16.833 17.4796 16.7748 17.5097 16.7092C17.5398 16.6437 17.5554 16.5725 17.5554 16.5003C17.5554 12.6308 14.9598 9.35729 11.4214 8.33345C12.2551 7.82048 12.8987 7.04891 13.2546 6.13603C13.6104 5.22314 13.659 4.21885 13.3929 3.27579C13.1268 2.33274 12.5605 1.50248 11.7803 0.911215C11 0.319948 10.0483 0 9.06992 0C8.0915 0 7.13984 0.319948 6.35956 0.911215C5.57929 1.50248 5.01307 2.33274 4.74696 3.27579C4.48086 4.21885 4.52942 5.22314 4.88527 6.13603C5.24111 7.04891 5.88478 7.82048 6.71845 8.33345C3.18002 9.35729 0.584473 12.6308 0.584473 16.5003Z" fill="white"/>
                    </svg><?php if($logged){ ?><span class="enter-account-text hidden-xs hidden-sm"><?php echo $text_account; ?></span><?php } ?></a>
                <ul class="dropdown-account hidden-xs hidden-sm">
                    <?php if ($logged) { ?>
                    <li><a href="<?php echo $account_edit; ?>"><?php echo $text_profile; ?></a></li>
                    <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
                    <li><a href="<?php echo $logout; ?>"><?php echo $text_logout; ?></a></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="cart" data-remodal-target="modal-cart">
                <div class="cart-packing">
                    <svg  height="20" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.19515 16.699C8.01126 16.699 7.0481 17.6637 7.0481 18.8495C7.0481 20.0353 8.01126 21 9.19515 21C10.379 21 11.3422 20.0353 11.3422 18.8495C11.3422 17.6637 10.379 16.699 9.19515 16.699Z" fill="white"/>
                        <path d="M8.24691 18.8494C8.24691 19.3731 8.67227 19.7992 9.19515 19.7992C9.71798 19.7992 10.1434 19.3732 10.1434 18.8494M9.19515 16.699C8.01126 16.699 7.0481 17.6637 7.0481 18.8495C7.0481 20.0353 8.01126 21 9.19515 21C10.379 21 11.3422 20.0353 11.3422 18.8495C11.3422 17.6637 10.379 16.699 9.19515 16.699Z" stroke="white" stroke-width="0.5"/>
                        <path d="M16.7266 16.699C15.5428 16.699 14.5796 17.6637 14.5796 18.8495C14.5796 20.0353 15.5428 21 16.7266 21C17.9105 21 18.8737 20.0353 18.8737 18.8495C18.8736 17.6637 17.9105 16.699 16.7266 16.699Z" fill="white"/>
                        <path d="M15.7784 18.8494C15.7784 19.3731 16.2038 19.7992 16.7266 19.7992C17.2495 19.7992 17.6749 19.3732 17.6749 18.8494M16.7266 16.699C15.5428 16.699 14.5796 17.6637 14.5796 18.8495C14.5796 20.0353 15.5428 21 16.7266 21C17.9105 21 18.8737 20.0353 18.8737 18.8495C18.8736 17.6637 17.9105 16.699 16.7266 16.699Z" stroke="white" stroke-width="0.5"/>
                        <path d="M21.481 5.32837C21.2525 5.04736 20.9137 4.88622 20.5518 4.88622H5.02789L4.65082 3.05281C4.5721 2.67036 4.31167 2.34923 3.95401 2.19368L1.32308 1.04986C1.01935 0.917713 0.666361 1.05731 0.534617 1.36144C0.402729 1.66566 0.542103 2.01927 0.845691 2.15122L3.47667 3.29509L5.90013 14.8174C6.06361 15.5425 6.89804 15.4387 7.19836 15.4387H18.8752C19.4413 15.4387 19.9351 15.0357 20.0493 14.4803L21.7259 6.32911C21.7989 5.97416 21.7097 5.60934 21.481 5.32837Z" fill="white"/>
                        <path d="M6.95141 14.2381L5.522 7.28839C5.39442 6.6681 5.86822 6.08692 6.5015 6.08693L20.5517 6.08697M21.481 5.32837C21.2525 5.04736 20.9137 4.88622 20.5518 4.88622H5.02789L4.65082 3.05281C4.5721 2.67036 4.31167 2.34923 3.95401 2.19368L1.32308 1.04986C1.01935 0.917713 0.666361 1.05731 0.534617 1.36144C0.402729 1.66566 0.542103 2.01927 0.845691 2.15122L3.47667 3.29509L5.90013 14.8174C6.06361 15.5425 6.89804 15.4387 7.19836 15.4387H18.8752C19.4413 15.4387 19.9351 15.0357 20.0493 14.4803L21.7259 6.32911C21.7989 5.97416 21.7097 5.60934 21.481 5.32837Z" stroke="white" stroke-width="0.5"/>
                    </svg>

                    <i class="scoreboard"><?php echo $countcart; ?></i>
                </div>
            </div>
            <?php if(!$is_mobile){ ?>
            <div class="all-inline-category">
                <div class="main-category-block hidden-xs hidden-sm">
                    <button class="button-link-catalog"><svg width="26" height="16" viewBox="0 0 26 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="26" height="2.90909" rx="1.45455" fill="#BEB7D1"/><rect y="6.54541" width="26" height="2.90909" rx="1.45455" fill="#BEB7D1"/><rect y="13.0908" width="26" height="2.90909" rx="1.45455" fill="#BEB7D1"/>
                        </svg>
                        <span class="title-button-link-catalog">
          <?php echo $catalog; ?></span>
                    </button>
                </div>
                <div class="inline-category hidden-xs hidden-sm">
                    <ul class="topmenus">
                        <?php foreach($categories as $category) { ?>
                        <li class="topmenus-item" data-menu-id="<?php echo $category['category_id']; ?>"><a class="inline-category-item" href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
                <div id="top-menu-inner" class="wrapper-for-dropdown">
                    <div class="dropdown-category j-all-categories">
                        <ul class="main-menu">
                            <?php foreach($categories as $category) { ?>
                            <li class="item item-category vertical-item-categore" data-menu-vertical-id="<?php echo $category['category_id']; ?>">
                                <a href="<?php echo $category['href']; ?>">
                                    <?php echo $category['name']; ?>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <?php foreach($categories as $category) { ?>
                    <div class="dropdown-item j-dropdown-item j-sub-categories" data-menu-id="<?php echo $category['category_id']; ?>" style="">
                        <?php if($category['children']) { ?>
                        <div class="j_fiels_submenu" style="margin-left: -15px; margin-right: -15px">
                            <ul class="j_fiels_submenu-col">
                                <?php $i=1; foreach($category['children'] as $key => $child) { ?>
                                <li class="topmenus-column">
                                    <a href="<?php echo $child['href']; ?>">
                                        <?php echo $child['name']; ?>
                                    </a>
                                    <?php if($child['childs']) { ?>
                                    <ul class="topmenus-level3">
                                        <?php foreach($child['childs'] as $grandchild) { ?>
                                        <li>
                                            <a href="<?php echo $grandchild['href']; ?>" class="">
                                                <?php echo $grandchild['name']; ?>
                                            </a>
                                        </li>
                                        <?php $i++; ?>
                                        <?php } ?>
                                    </ul>
                                    <a class="j_fiels_link_all" href="<?php echo $child['href']; ?>"><?php echo $text_all_caterogies; ?></a>
                                    <?php } ?>
                                </li>
                                <?php } ?>
                            </ul>
                            <div class="j_fiels_submenu-image" style="float: right!important">
                                <?php if($category['banners']) { ?>
                                <?php foreach($category['banners'] as $banner) { ?>
                                <a href="<?php echo $banner['link']; ?>">
                                    <img data-src="<?php echo $banner['image']; ?>" src="catalog/view/theme/OPC080193_6/images/goods-picture.svg" class="img-responsive lazy-sz" alt="<?php echo $category['name']; ?>" title="<?php echo $category['name']; ?>">
                                </a>
                                <?php break; } ?>
                                <?php } ?>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
</div>
