<?php

use Timber\Timber;
$context = getTimberDefaultContext();

Timber::render('twig/index.twig', $context);

// Flynt\echoHtmlFromConfig([
//     'name' => 'DocumentDefault',
//     'areas' => [
//         'layout' => [
//             [
//                 'name' => 'LayoutMultiplePosts',
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
//                             'name' => 'GridPosts'
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
