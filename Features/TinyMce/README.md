# TinyMCE (Flynt Feature)

Cleans up TinyMCE Buttons to show all relevant buttons on the first bar.

### Editor Toolbar

The MCE Buttons that show up by default are specified by the `mce_buttons` filter in `functions.php` file.
You can modify that filter for all the Wysiwyg toolbars (all over your project).

```php
<?php

// First Bar

add_filter('mce_buttons', function ($buttons) {
  return [
    'formatselect',
    'styleselect',
    'bold',
    'italic',
    'underline',
    'strikethrough',
    '|',
    'bullist',
    'numlist',
    '|',
    'outdent',
    'indent',
    'blockquote',
    'hr',
    '|',
    'alignleft',
    'aligncenter',
    'alignright',
    'alignjustify',
    '|',
    'link',
    'unlink',
    '|',
    'forecolor',
    'wp_more',
    'charmap',
    'spellchecker',
    'pastetext',
    'removeformat',
    '|',
    'undo',
    'redo',
    'wp_help',
    'fullscreen',
    'wp_adv', // toogle second bar button
  ];
});

// Second Bar
add_filter('mce_buttons_2', function ($buttons) {
  return [];
});
```
Do your modifications there by adding/deleting the buttons you need.
You can also reactivate the second bar if needed.

To show the toggle visibilty button of the Second Bar you need to add the this button to the __First Bar__ `'wp_adv'`

NB: If you want to change the toolbar specifically to one Wysiwig acf field, check out the readme file of the Wysiwyg component for the instructions.

### Block Formats Configuration

You can configure the block formats in the `'formatselect'` button.

```php
<?php

add_filter('tiny_mce_before_init', function($init) {
  $init['block_formats'] = 'Paragraph=p;Heading 1=h1;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6;Address=address;Pre=pre';
  return $init;
});
```

### Editor Styles

You can also create new **styles**, globally by modifying the TinyMce Feature, by adding the `styleselect` pulldown menu to the button list:

```php
<?php

add_filter('mce_buttons', function ($buttons) {
  return [
    'formatselect',
    'styleselect',
    'bold',
    'italic',
    'underline',
    'strikethrough',
    '|',
    'bullist',
    'numlist',
    '|',
    'link',
    'unlink',
    '|',
    'wp_more',
    'pastetext',
    'removeformat',
    '|',
    'undo',
    'redo',
    'fullscreen',
  ];
});
```

You need the `styleselect` in place to be able to register your own custom styles.
Once that it is done, use the `tiny_mce_before_init` filter to build your configuration parameters which you will inject your custom styles:

```php
<?php

add_filter('tiny_mce_before_init', function($init_array) {
  $style_formats = array(
    array(
      'title' => 'Highlight Text',
      'selector' => 'p',
      'classes' => 'primary-font'
    ),
    array(
      'title' => 'Brand Colour (Turquoise)',
      'inline' => 'span',
      'classes' => 'color-highlight'
    )
  );
  $init_array['style_formats'] = json_encode($style_formats);
  return $init_array;
});
```

### Editor Stylesheet

You can link a custom stylesheet to the TinyMce editor with the `add_editor_style` function.

Go to the **TinyMce Feature** `functions.php` file:

```php
<?php

add_editor_style('Features/TinyMce/customEditorStyle.css');
```

Call the `add_editor_style` function and pass as a parameter your stylesheet file path (that we called `customEditorStyle.css` here). This file must be present inside this `TinyMce` feature.

### Adding custom toolbars

Open `toolbars.json` and add your toolbar configuration to the toolbar Array. This will automatically be loaded. You can call the toolbar inside your ACF configuration in lowercase.

**Example**:<br>
`CustomToolbar` ==> `"toolbar": "customtoolbar"`

### Adding new Style Formats via JSON

Open `styleformats.json` and add your configuration to the styleformats Array. This will automatically be loaded.