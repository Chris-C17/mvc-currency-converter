<?php
/**
 * Created by PhpStorm.
 * User: c_chambers
 * Date: 15/11/2018
 * Time: 15:27
 */

# Set PagesController to be the default Controller in CoreController
class CurrencyController extends BaseController
{
    public function __construct()
    {
//        echo "Pages loaded";
    }

    # Need an index method if setting the params outside of if statement that checks
    # for a method in URL (array element[1])
    public function index()
    {
        # Using a pages directory in view so need to load pages/index
        $this->view('index', ['title' => 'Welcome']);
    }

    # Remember .htaccess isn't working so need awkward url with /public/?url=
    # http://localhost/mvc-currency-converter/public/?url=currency/about/12
    public function about($id)
    {
        $this->view('about');
        echo "this is about in CurrencyController and the id is ".$id;
    }
}