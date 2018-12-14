<?php

use ACFComposer\ACFComposer;
use function Flynt\Features\AcfGutenberg\registerGutenbergComponents;

add_action('acf/init', function () {
    $pageComponents = [
        'Flynt/Components/AccordionDefault/Fields/Layout',
        'Flynt/Components/BlockImage/Fields/Layout',
        'Flynt/Components/BlockImageText/Fields/Layout',
        'Flynt/Components/BlockMediaText/Fields/Layout',
        'Flynt/Components/BlockVideoOembed/Fields/Layout',
        'Flynt/Components/BlockWysiwyg/Fields/Layout',
        'Flynt/Components/GridContentLists/Fields/Layout',
        'Flynt/Components/GridDownloadPortrait/Fields/Layout',
        'Flynt/Components/GridPosts/Fields/Layout',
        'Flynt/Components/GridPostsSlider/Fields/Layout',
        'Flynt/Components/GridListSteps/Fields/Layout',
        'Flynt/Components/HeroCta/Fields/Layout',
        'Flynt/Components/HeroImage/Fields/Layout',
        'Flynt/Components/HeroImageText/Fields/Layout',
        'Flynt/Components/ListComponents/Fields/Layout',
        'Flynt/Components/ListFacts/Fields/Layout',
        'Flynt/Components/ListPostCards/Fields/Layout',
        'Flynt/Components/ListSocial/Fields/Layout',
        'Flynt/Components/ListTestimonialCards/Fields/Layout',
        'Flynt/Components/SliderMedia/Fields/Layout',
        'Flynt/Components/SliderImages/Fields/Layout',
        'Flynt/Components/SliderImageGallery/Fields/Layout',
    ];
    if (apply_filters('use_block_editor_for_post_type', true, 'page')) {
        registerGutenbergComponents($pageComponents, 'page');
    } else {
        ACFComposer::registerFieldGroup([
            'name' => 'pageComponents',
            'title' => 'Page Components',
            'style' => 'seamless',
            'fields' => [
                [
                    'name' => 'pageComponents',
                    'label' => 'Page Components',
                    'type' => 'flexible_content',
                    'button_label' => 'Add Component',
                    'layouts' => $pageComponents,
                ],
            ],
            'location' => [
                [
                    [
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'page',
                    ],
                    [
                        'param' => 'page_type',
                        'operator' => '!=',
                        'value' => 'posts_page',
                    ],
                ],
            ],
        ]);
    }
});
