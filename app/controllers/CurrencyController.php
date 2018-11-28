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
//        echo "CurrencyController loaded";
    }

    # Need an index method if setting the params outside of if statement that checks
    # for a method in URL (array element[1])
    public function index()
    {
        # Using a pages directory in view so need to load pages/index
        $this->view('currency/index');
    }

    # Remember .htaccess isn't working so need awkward url with /public/?url=
    # http://localhost/mvc-currency-converter/public/?url=currency/about/12


    public function converter()
    {
        # Check for POST
        if($_SERVER['REQUEST_METHOD'] == POST) {
            # Process conversion

            # Init data so users don't need to re-click everything
            $data = [
                'fromCurrency' => $_POST['fromCurrency'],
                'toCurrency' => $_POST['toCurrency'],
                'amount' => $_POST['amount'],
                'amount_err' => '',
            ];

            # Ensure amount is set
            if (empty($data['amount'])) {
                $data['amount_err'] = 'Please enter an amount you want to convert';

                # load view with errors
                $this->view('currency/converter', $data);

            } else {

                $from_Currency = urlencode($data['fromCurrency']);
                $to_Currency = urlencode($data['toCurrency']);
                $query = "{$from_Currency}_{$to_Currency}";

                $json = file_get_contents("https://free.currencyconverterapi.com/api/v6/convert?q={$query}&compact=ultra");
                $obj = json_decode($json, true);

                $rate = floatval($obj["$query"]);

                $total = $rate * $data['amount'];
                $total_format = number_format($total, 2, '.', ',');

                $data['total_format'] = $total_format;

//            echo $amount . " " . $fromCurrency . ' = ' . $total_format . " " . $toCurrency;

                # Pass data to view
                $this->view('currency/converter', $data);

            }
//            $fromCurrency = $_POST['fromCurrency'];
//            $toCurrency = $_POST['toCurrency'];
//            $amount = $_POST['amount'];

//        return $total_format;
        } else {
            # init data so users don't need to re-enter data
            $data = [
                'fromCurrency' => '',
                'toCurrency' => '',
                'amount' => '',
                'amount_err' => '',
            ];

            #load View (form) and pass in data
            $this->view('currency/converter', $data);
        }
    }

    # Remember .htaccess isn't working so need awkward url with /mvc/public/?url=
    # http://localhost/mvc/public/?url=pages/about/33
//    public function about($id)
    public function about()
    {
        $data = [
            'title' => 'About Us',
            'description' => 'Simple app for converting currencies built in a 
            PHP MVC framework. Enjoy!',
        ];
        $this->view('currency/about', $data);
//        echo "this is about in Pages and the id is ".$id;
    }
}