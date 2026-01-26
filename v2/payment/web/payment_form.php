<html>
<head>
    <title>Secure Acceptance - Payment Form Example</title>
    <link rel="stylesheet" type="text/css" href="payment.css"/>
    <script type="text/javascript" src="jquery-1.7.min.js"></script>
</head>
<body>
<form id="payment_form" action="payment_confirmation.php" method="post">
    <input type="hidden" name="access_key" value="2b311590233e3fcf89a1159589e4325e">
    <input type="hidden" name="profile_id" value="1B30E861-00B4-4190-9FA1-C11915804FEE">
    <input type="hidden" name="transaction_uuid" value="<?php echo uniqid() ?>">
    <input type="hidden" name="signed_field_names" value="access_key,profile_id,transaction_uuid,signed_field_names,unsigned_field_names,signed_date_time,locale,transaction_type,reference_number,amount,currency,bill_to_address_line1,bill_to_address_city,bill_to_address_country,bill_to_email,bill_to_forename,bill_to_surname,bill_to_address_postal_code,bill_to_phone">
    <input type="hidden" name="unsigned_field_names">
    <input type="hidden" name="signed_date_time" value="<?php echo gmdate("Y-m-d\TH:i:s\Z"); ?>">
    <input type="hidden" name="locale" value="en">
    <fieldset>
        <legend>Payment Details</legend>
        <div id="paymentDetailsSection" class="section">
            <span>transaction_type:</span><input type="text" name="transaction_type" value="sale" size="25"><br/>
            <span>reference_number:</span><input type="text" name="reference_number" size="25"><br/>
            <span>amount:</span><input type="text" name="amount" size="25"><br/>
            <span>currency:</span><input type="text" name="currency" value="usd" size="25"><br/>
            
            <span>bill_to_address_line1:</span><input type="text" name="bill_to_address_line1" value="224 Y Block DHA Lahore, Pakistan" size="25"><br/>
            <span>bill_to_address_city:</span><input type="text" name="bill_to_address_city" size="25" value="Lahore"><br/>
            <span>bill_to_address_country:</span><input type="text" name="bill_to_address_country" size="25" value="PK"><br/>
            <span>bill_to_email:</span><input type="text" name="bill_to_email" size="25" value="farhanasim@gmail.com"><br/>
            <span>bill_to_forename:</span><input type="text" name="bill_to_forename" size="25" value="Farhan"><br/>
            <span>bill_to_surname:</span><input type="text" name="bill_to_surname" size="25" value="Asim"><br/>
            <span>bill_to_address_postal_code:</span><input type="text" name="bill_to_address_postal_code" size="25" value="54000"><br/>
            <span>bill_to_phone:</span><input type="text" name="bill_to_phone" size="25" value="+923008433121"><br/>
            
            <!-- <span>override_custom_receipt_page:</span><input type="text" name="override_custom_receipt_page" size="25" value="http://heavenhotel.local/payment/web/payment_receipt.php"><br/> -->
         
            
        </div>
    </fieldset>
    <input type="submit" id="submit" name="submit" value="Submit"/>
    <script type="text/javascript" src="payment_form.js"></script>
</form>
</body>
</html>
