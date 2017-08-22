<?php

namespace Flynt\Components\HeroPostHeader;

use Timber\Timber;
use Flynt\Features\Components\Component;
use Flynt\Utils\Asset;

add_action('wp_enqueue_scripts', function () {
    Component::enqueueAssets('HeroPostHeader', []);
});

add_filter('Flynt/addComponentData?name=HeroPostHeader', function ($data) {
    $data['post'] = Timber::get_post();
    $data['providers'] = getShareProviders(
        $data['post']->post_title,
        $data['post']->link,
        $data['post']->post_excerpt
    );
    return $data;
});

function getShareProviders($postTitle, $postUrl, $postExcerpt)
{
    $providers = [
        [
            'title' => 'Facebook',
            'class' => 'share-facebook',
            'url' => 'https://www.facebook.com/sharer/sharer.php?u=$url'
        ],
        [
            'title' => 'Twitter',
            'class' => 'share-twitter',
            'url' => 'https://twitter.com/home?status=$url'
        ],
        [
            'title' => 'Google+',
            'class' => 'share-google',
            'url' => 'https://plus.google.com/share?url=$url'
        ],
        [
            'title' => 'Linkedin',
            'class' => 'share-linkedin',
            'url' => 'https://www.linkedin.com/shareArticle?mini=true&url=$url&title=$title&summary=$summary'
        ]
    ];

    $providers = array_map(function ($provider) use ($postTitle, $postUrl, $postExcerpt) {
        $shareUrl = str_replace('$url', $postUrl, $provider['url']);
        $shareUrl = str_replace('$title', $postTitle, $shareUrl);
        $shareUrl = str_replace('$summary', $postExcerpt, $shareUrl);
        $provider['shareUrl'] = $shareUrl;
        return $provider;
    }, $providers);
    return $providers;
}
