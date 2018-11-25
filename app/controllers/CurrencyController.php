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
        $this->view('index', ['title' => 'Welcome']);
    }

    # Remember .htaccess isn't working so need awkward url with /public/?url=
    # http://localhost/mvc-currency-converter/public/?url=currency/about/12


    public function converter()
    {
        $fromCurrency = $_POST['fromCurrency'];
        $toCurrency = $_POST['toCurrency'];
        $amount = $_POST['amount'];

        $from_Currency = urlencode($fromCurrency);
        $to_Currency = urlencode($toCurrency);
        $query =  "{$from_Currency}_{$to_Currency}";

        $json = file_get_contents("https://free.currencyconverterapi.com/api/v6/convert?q={$query}&compact=ultra");
        $obj = json_decode($json, true);

        $rate = floatval($obj["$query"]);

        $total = $rate * $amount;
        $total_format = number_format($total, 2, '.', ',');
        echo $amount . " " . $fromCurrency . ' = ' . $total_format . " " . $toCurrency;
//        return $total_format;
    }
}