<?php

namespace Flynt\Features\LoremIpsum;

class Helper
{
    public static function getApiBase()
    {
        return 'http://loripsum.net/api';
    }

    public static function getMappedOptions()
    {
        return [
            'dynamic' => [
                'plength',
                'length'
            ],
            'boolean' => [
                'decorate',
                'link',
                'ul',
                'ol',
                'dl',
                'bq',
                'code',
                'headers',
                'allcaps',
                'prude',
                'plaintext'
            ],
            'shortcode' => [
              'dynamic' => [
                'paragraphs' => 'plength',
                'length' => 'length'
              ],
              'boolean' => [
                'decorate' => 'decorate',
                'ul' => 'ul',
                'ol' => 'ol',
                'dl' => 'dl',
                'quote' => 'bq',
                'code' => 'code',
                'headers' => 'headers',
                'caps' => 'allcaps',
                'prude' => 'prude',
                'plain' => 'plaintext'
              ]
            ]
        ];
    }
    
    public static function getLoremIpsum($options = [])
    {
        $url = self::getApiBase();
        $mappedOptions = self::getMappedOptions();

        foreach ($mappedOptions['dynamic'] as $option) {
            if (isset($options[$option])) {
                $url .= '/' . $options[$option];
            }
        }

        foreach ($mappedOptions['boolean'] as $option) {
            if (isset($options[$option]) && $options[$option] === true) {
                $url .= '/' . $option;
            }
        }

        try {
            $response = wp_remote_get($url);
            return $response['body'];
        } catch (Exception $e) {
            return false;
        }
    }
}

add_shortcode('lorem-ipsum', function ($attr) {
    $options = [];
    $mappedOptions = Helper::getMappedOptions();

    foreach ($mappedOptions['shortcode'] as $type => $typeOptions) {
        foreach ($typeOptions as $attrName => $option) {
            if ($type === 'dynamic') {
                if (isset($attr[$attrName])) {
                    $options[$option] = $attr[$attrName];
                }
            }

            if ($type === 'boolean') {
                if (isset($attr[$attrName]) && $attr[$attrName] === '1') {
                    $options[$option] = true;
                }
            }
        }
    }

    $content = Helper::getLoremIpsum($options);
    if ($content) {
        return $content;
    }
});
