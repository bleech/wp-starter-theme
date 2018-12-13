<?php

use Timber\Timber;

$context = getTimberDefaultContext(true);

Timber::render('twig/page.twig', $context);

// Flynt\echoHtmlFromConfig([
//     'name' => 'DocumentDefault',
//     'areas' => [
//         'layout' => [
//             [
//                 'name' => 'LayoutSinglePost',
//                 'areas' => [
//                     'mainHeader' => [
//                         [
//                             'name' => 'NavigationMain',
//                             'customData' => [
//                                 'menuSlug' => 'navigation_main'
//                             ]
//                         ]
//                     ],
//                     'pageComponents' => [
//                         [
//                             'name' => 'ComponentLoaderFlexible',
//                             'customData' => [
//                                 'fieldGroup' => 'postComponents'
//                             ]
//                         ]
//                     ],
//                     'mainFooter' => [
//                         [
//                             'name' => 'NavigationFooter',
//                             'customData' => [
//                                 'menuSlug' => 'navigation_footer'
//                             ]
//                         ],
//                         [
//                             'name' => 'BlockCookieNotice'
//                         ]
//                     ]
//                 ]
//             ]
//         ]
//     ]
// ]);
