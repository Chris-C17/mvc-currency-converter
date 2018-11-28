<?php require APPROOT . "/views/inc/header.php"; ?>


<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body mt-5">
                <h2>Convert a Currency</h2>
                <!-- Using action to submit the data ... currency controller? -->
                <form method="post" action="<?php echo URLROOT; ?>/?url=Currency/converter">
                    <!--        <form method="post" action="../controllers/CurrencyController.php">-->
                    <div class="form-group">
                        <label>Convert From</label><br>
                        <select name="fromCurrency">
                            <option value="BTC">Bitcoin</option>
                            <option value="USD">Dollars</option>
                            <option value="GBP">Pounds</option>
                            <option value="EUR">Euros</option>
                            <option value="CNY">Yuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Convert to</label><br>
                        <select name="toCurrency">
                            <option value="USD">Dollars</option>
                            <option value="BTC">Bitcoin</option>
                            <option value="GBP">Pounds</option>
                            <option value="EUR">Euros</option>
                            <option value="CNY">Yuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="col-3">
                            <label>Amount</label><br>
                            <!-- set value to $data['amount'] so users don't have to retype -->
                            <input type="number" name="amount" class="form-control
                            <?php echo (!empty($data['amount_err'])) ? 'is-invalid' : ''; ?>"
                            value="<?php echo $data['amount']; ?>">
                            <span class="invalid-feedback"><?php echo $data['amount_err']; ?></span>
                        </div>
                    </div>
                    <br>
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <?php
            if($data != null)
            {
                echo $data['amount'] . " " . $data['fromCurrency'] . ' = ' .
                    $data['total_format'] . " " . $data['toCurrency'];
            }
            ?>
        </div>
    </div>
</div>

<?php require APPROOT . "/views/inc/footer.php"; ?>