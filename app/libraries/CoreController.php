<?php
/**
 * App Core Class (was called Core.php before)
 * Creates URL and loads core controller
 * URL FORMAT - /controller/method/params
 */
# This will look at urls and pull out arrays and decide
# what controller/method to load

class CoreController
{
    # If there are no other controllers then set default (Pages)Controller to load
    # The controllers and methods will change as the URL changes
    # Therefore need to create a method in Core to get URL
    protected $currentController = 'CurrencyController';
    protected $currentMethod = 'converter';
    protected $params = [];

    public function __construct()
    {

        $url = $this->getUrl();

        # Look in controllers for first index/value - remember this file
        # is already in libraries but is being called by public/index.php
        if(file_exists('../app/controllers/'.ucwords($url[0]) . 'Controller.php')) {
            # if exists, set as controller (added Controller to be consistent with Symf4)
            $this->currentController = ucwords($url[0])."Controller";
            # Unset 0 index
            unset($url[0]);
        }

        // Require the controller (The default controller needs to exist for no errors)
        require_once '../app/controllers/' . $this->currentController . '.php';

        # Instantiate Controller Class (I think this is tight-coupling and dependency
        # injection should be used here instead?)
        $this->currentController = new $this->currentController;

        # Check for 2nd part (method) of URL
        if(isset($url[1]))
        {
            # Check to see if method exists in controller
            if(method_exists($this->currentController, $url[1]))
            {
                $this->currentMethod = $url[1];
                # Unset array element 1 (method/index by default)
                unset($url[1]);

                # Get params using ternary shorthand (the lines below were originally
                # out of if statement but will return an error if the method doesn't
                # exist in the controller that is entered in the URL)
                $this->params = $url ? array_values($url) : [];

                # Call a callback with array of params
                call_user_func_array(
                    [$this->currentController, $this->currentMethod],
                    $this->params);

            }

            # Adding an else statement because .htaccess doesn't work and I need the
            # default controller, method and parameters to be called
        } else {call_user_func_array(
            [$this->currentController, $this->currentMethod],
            $this->params);
        }

    }

    # Note .htaccess isn't working so I need full url to public/ then ?url=
    # default is public/index.php and looks for databases there
    # http://localhost/mvc-currency-converter/public/?url=currency/converter
    # url[0] = Currency (Controller), url[1] = converter (method), url[2+] = params
    public function getUrl()
    {
        if(isset($_GET['url']))
        {
            # Not sure what rtrim is doing (doesn't seem to be doing anything)
            $url = rtrim($_GET["url"], "/");
            #sanitize so URL doesn't have any characters it shouldn't have
            $url = filter_var($url, FILTER_SANITIZE_URL);
            # Split the URL up into an array. "/" separates elements
            $url = explode('/', $url);

            return $url;
        }
    }
}


