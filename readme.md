# Ajax

via WP Orbit

This packaged provides an extensible PHP class *AjaxHandler*, which can be extended in any plugin or theme.
It provides a lightweight wrapper for hooking ajax calls, sending ajax responses with HTTP status codes, allowing
for front-end error handling.

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

class CustomAjaxHandler extends AjaxHandler
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

# Responses

### Send a Successful JSON Response
In your callback function, call *$this->json( $data );* to send a JSON formatted response and terminate the program.
This will fire under jQuery's $.ajax.done() callback.

### Send an Error JSON Response
We can return an error JSON response via *$this->error( $data, $errorCode );*. This will fire under jQuery's $.ajax.fail()
callback.