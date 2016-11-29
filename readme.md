# Ajax

via WP Orbit

This packaged provided as extensible PHP class *AjaxHandler*, which can be declared in any plugin or theme.

In your extending class declare any of the three appropriate protected properties (each arrays):

- $privateActions
- $publicActions
- $anyActions

Private actions are hooked to "wp_ajax".

Public actions are hooked to "wp_ajax_nopriv".

Actions declared on the $anyActions array will be hooked to both "wp_ajax" and "wp_ajax_nopriv".

Each action key in any of the 3 properties listed above must have an exactly matching method of the 
same name on the extending class.

For example: 

```php
<?php
use Zawntech\WordPress\Orbit\Ajax\AjaxHandler;

class CustomHandler extends AjaxHandler
{
    protected $publicActions = [
        'public_callback'
    ];
    
    protected $privateActions = [
        'private_callback'
    ];
    
    protected function public_callback()
    {
        // Do something...
    }
    
    protected function private_callback()
    {
        // Do something...
    }
}
```