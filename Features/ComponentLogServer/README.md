# HowTo

## Register Feature `/lib/init.php`
```php
<?php

function initTheme()
{
    add_theme_support('flynt-component-log-server');
}
```

## Usage
This functionality is only enabled on the development environment or for logged in administrators / editors on all environments.

Add the GET parameter `log` to any url (e.g. `http://localhost:3000/?log`) and all the data for that page will be output via console.log in the dev tools of your browser. By specifying an additional `component` parameter with component names separated by a comma you can limit the output to specific components: `http://localhost:3000/?log&component=BlockWysiwyg,DocumentDefault`.
