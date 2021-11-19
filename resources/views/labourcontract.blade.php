<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Labour contract</title>
</head>
<body>

<?php
  $dt = \Carbon\Carbon::now(new DateTimeZone('Asia/Karachi'))->format('M d, Y - h:m a');
  $date = \Carbon\Carbon::now(new DateTimeZone('Asia/Karachi'))->format('M d, Y');
//   $amt = new NumberFormatter( 'en_GB', NumberFormatter::SPELLOUT );
  ?>
 
  <div>
    <div>
      <h3 style="border-bottom:1px solid black;text-align:center;width:32%;margin-left:34%;margin-bottom:0px;">LABOUR CONTRACTOR</h3>
      <h2 style="text-align:center;margin:0px;">TULIP INDUSTRIES (Pvt) Limited</h2>
      <!-- <h2>Pwl 1/84</h2> -->
      <h5 style="text-align:center;margin-top:0px;">F-237, S.I.T.E., KARACHI</h5>
      <!-- <h4>Phone:32570409,32562367, Fax:32562366</h4> -->
    </div>
    <div class="main_table table-responsive" style="padding:0 20px 0 20px">
      <table style="width:100%;margin-bottom:0px;">
          <tr>
            <td style="widht:8%;">Bill #</td>
            <td style="border-bottom:1px solid;width:20%;"></td>
            <td style="width:45%;"></td>
            <td style="width:7%;">Date </td>
            <td style="border-bottom:1px solid;width:20%;">{{ $date }}</td>
          </tr>
      </table>
      <table style="width:100%;margin-top:0px;">
        <tr>
          <td style="width:5%">M/s.</td>
          <td style="border-bottom:1px solid;width:90%;"></td>
        </tr>
        <tr>
          <td style="width:5%">C/A</td>
          <td style="border-bottom:1px solid;width:90%;"></td>
        </tr>
      </table>
      <table style="width:100%;margin-top:50px;">
        <tr>
          <td style="width:15%;">Please Pay Rs. </td>
          <td style="width:60%;border-bottom:1px solid black"></td>
          <td style="width:20%;text-align:right"> only for unloading</td>
        </tr>
      </table>
      <table style="width:100%;margin-top:0px;">
        <tr>
          <td style="width:13%;"> charges of </td>
          <td style="width:87%;border-bottom:1px solid black"></td>
        </tr>
        <tr>
          <td style="width:13%;">of</td>
          <td style="width:87%;border-bottom:1px solid black"></td>
        </tr>
        <tr>
          <td style="width:13%;">Rupees </td>
          <td style="width:87%;border-bottom:1px solid black"></td>
        </tr>
      </table>
      <table style="width:100%;margin-top:20px;">
        <tr>
          <td style="width:10%">L/C No.</td>
          <td style="border-bottom:1px solid;width:90%;"></td>
        </tr>
        <tr>
          <td style="width:10%">File No.</td>
          <td style="border-bottom:1px solid;width:90%;"></td>
        </tr>
        <tr>
          <td style="width:10%">Date</td>
          <td style="border-bottom:1px solid;width:90%;">{{ $dt }}</td>
        </tr>
      </table>
      <table style="width:100%;margin-top:70px">
        <tr>
          <td style="width:65%;"></td>
          <td style="width:35%;font-weight:bold">FOR LABOUR CONTRACTOR</td>
        </tr>
      </table>
      


    </div>
  </div>
</body>
</html>
