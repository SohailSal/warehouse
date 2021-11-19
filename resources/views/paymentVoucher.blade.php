<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Voucher</title>
</head>
<body>

<?php
  $dt = \Carbon\Carbon::now(new DateTimeZone('Asia/Karachi'))->format('M d, Y - h:m a');
  $date = \Carbon\Carbon::now(new DateTimeZone('Asia/Karachi'))->format('M d, Y');
//   $amt = new NumberFormatter( 'en_GB', NumberFormatter::SPELLOUT );
  ?>
 
  <div>
    <div style="justify-content:center">
      <h2 style="text-align:center;margin-bottom:0px;"><span style="border-bottom:1px solid black;width:54%;">TULIP INDUSTRIES (Pvt) Limited</span></h2>
      <h4 style="text-align:center;margin-top:0px;"><span style="background-color:black;color:white;padding: 5 10">PAYMENT VOUCHER</span></h4>
    </div>

    <table style="width:100%">
      <tr>
        <td style="width:10%">PAYEE</td>
        <td style="border-bottom:1px solid black;"></td>
        <td style="width:7%">Date</td>
        <td style="width:25%;border-bottom:1px solid black;"></td>
      </tr>
    </table>
    <table style="width:100%;margin-bottom:20px">
      <tr>
        <td style="width:10%">DEBIT</td>
        <td style="border-bottom:1px solid black;"></td>
      </tr>
    </table>

    <table style="width:100%">
      <tr>
        <td style="width:10%">DEBIT</td>
        <td style="border:1px solid black;"></td>
        <td style="border:1px solid black;"></td>
      </tr>
      <tr>
        <td style="width:10%">DEBIT</td>
        <!-- <td style="border-bottom:1px solid black;"></td>
        <td style="border-bottom:1px solid black;"></td> -->
      </tr>
      <tr>
        <td style="width:10%">DEBIT</td>
        <!-- <td style="border-bottom:1px solid black;"></td>
        <td style="border-bottom:1px solid black;"></td> -->
      </tr>
    </table>



    <table style="width:100%;margin-top:50px">
      <tr style="margin-bottom:0px">
        <td style="width:14%;border-bottom:1px solid black;"></td>
        <td style="width:14%;"></td>
        <td style="width:14%;border-bottom:1px solid black;"></td>
        <td style="width:14%;"></td>
        <td style="width:14%;border-bottom:1px solid black;"></td>
        <td style="width:14%;"></td>
        <td style="width:14%;border-bottom:1px solid black;"></td>
      </tr>
      <tr style="margin-top:0px">
        <td style="width:14%;">Prepared by</td>
        <td style="width:14%;"></td>
        <td style="width:14%;">Checked by</td>
        <td style="width:14%;"></td>
        <td style="width:14%;">Approved by</td>
        <td style="width:14%;"></td>
        <td style="width:22%;">Receiver's Signature</td>
      </tr>
    </table>

  </div>
</body>
</html>
