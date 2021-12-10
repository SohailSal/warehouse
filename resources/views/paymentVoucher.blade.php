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

    <hr />
    <table style="width:100%">
      <thead style="background-color: #a8b3b8;">
        <tr>
          <td style="width:75%;font-size: 15px; border-collapse: collapse;border: 1px solid black; padding: 15px 0px 15px 0px;text-align:center;">Particular</td>
          <td style="border:1px solid black;widht:20%;font-size: 15px; border-collapse: collapse;border: 1px solid black; padding: 15px 0px 15px 0px;text-align:center;">Rupees</td>
          <td style="border:1px solid black;width:5%;font-size: 15px; border-collapse: collapse;border: 1px solid black; padding: 15px 0px 15px 0px;text-align:center;">Ps.</td>
        </tr>
      </thead>
      <!-- <tr style="height: 250px;">
        <td style="width:75%;border-right:1px solid">Particular</td>
        <td style="widht:20%;border-right:1px solid;text-align:center;">Rupees</td>
        <td style="width:5%;text-align:center;">Ps.</td>
      </tr> -->
      <tbody style="height:250px;">
        <tr>
          <td style="width:75%;text-align: center; border-collapse: collapse;border: 1px solid black;padding: 50px 0px 240px 0px;"></td>
          <td style="widht:20%;text-align: center; border-collapse: collapse;border: 1px solid black;padding: 50px 0px 240px 0px;"></td>
          <td style="width:5%;text-align: center; border-collapse: collapse;border: 1px solid black;padding: 50px 0px 240px 0px;"></td>
        </tr>
      </tbody>

      <tfoot>
        <tr>
          <td style="width:75%;border-collapse: collapse;border:1px solid;font-weight:bold">Total Rupees </td>
          <td style="widht:20%;border-collapse: collapse;border:1px solid;text-align:center;"></td>
          <!-- <td style="width:5%;border-collapse: collapse;text-align:center;"></td> -->
        </tr>
      </tfoot>

    </table>
    <hr />



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
