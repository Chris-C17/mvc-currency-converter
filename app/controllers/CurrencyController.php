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
    }

    # Remember .htaccess isn't working so need awkward url with /public/?url=
    # http://localhost/mvc-currency-converter/public/?url=currency/about/12


    public function converter()
    {
        # Check for POST
        if($_SERVER['REQUEST_METHOD'] == POST) {
            # Process conversion

            # Init data so users don't need to re-click anything (only works for amount)
            $data = [
                'fromCurrency' => $_POST['fromCurrency'],
                'toCurrency' => $_POST['toCurrency'],
                'amount' => $_POST['amount'],
                'amount_err' => '',
            ];

            # Ensure amount is set
            if (empty($data['amount'])) {
                $data['amount_err'] = 'Enter an amount to convert';

                # load view with errors
                $this->view('currency/converter', $data);

            } else {

                # The API documentation suggests using urlencode but doesn't seem to be necessary
//                $from_Currency = urlencode($data['fromCurrency']);
//                $to_Currency = urlencode($data['toCurrency']);
//                $query = "{$from_Currency}_{$to_Currency}";
                $query = "{$data['fromCurrency']}_{$data['toCurrency']}";

                # Retrieve json data from API, then decode
                $json = file_get_contents("https://free.currencyconverterapi.com/api/v6/convert?q={$query}&compact=ultra");
                $obj = json_decode($json, true);

                # Set rate as variable
                $rate = floatval($obj["$query"]);

                # Calculate total amount, format it, then add to $data array
                $total = $rate * $data['amount'];
                $total_format = number_format($total, 2, '.', ',');
                $data['total_format'] = $total_format;

                # Pass data to view
                $this->view('currency/converter', $data);

            }

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
    # http://localhost/mvc-currency-converter/public/?url=Currency/about/
    public function about()
    {
        $data = [
            'title' => 'About Us',
            'description' => 'Simple app for converting currencies built in a 
            PHP MVC framework. Enjoy!',
        ];
        $this->view('currency/about', $data);
    }
}