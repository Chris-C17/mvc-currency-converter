HOMEPAGE
<h1><?php echo $data['title']; ?></h1>
<!DOCTYPE html>
<html>
<head>
    <title>Currency Converter</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

</head>
<body>
<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php">Simple Currency Converter</a>
        </div>
    </div>
</nav>
    <div class="container">
        <!-- Using action to submit the data ... currency controller? -->
        <form method="post" action="<?php echo URLROOT; ?>/?url=Currency/converter">
<!--        <form method="post" action="../controllers/CurrencyController.php">-->
            <div>
                <label>Convert From</label><br>
                <select name="fromCurrency">
                    <option value="BTC">Bitcoin</option>
                    <option value="USD">Dollars</option>
                    <option value="GBP">Pounds</option>
                    <option value="EUR">Euros</option>
                    <option value="CNY">Yuan</option>
                </select>
            </div>
            <div>
                <label>Convert to</label><br>
                <select name="toCurrency">
                    <option value="USD">Dollars</option>
                    <option value="BTC">Bitcoin</option>
                    <option value="GBP">Pounds</option>
                    <option value="EUR">Euros</option>
                    <option value="CNY">Yuan</option>
                </select>
            </div>
            <div>
                <label>Amount</label><br>
                <input type="number" name="amount">
            </div>
            <br>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>