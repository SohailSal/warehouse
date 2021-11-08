<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Receipt</title>

      <style>
      @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap');
      .slip_sec{  
      width:700px;
      margin: 0% auto 0;
      display: table;
      }
      .slip_head#head{ text-align: center !important; position: relative;}
      .slip_head h1 {
      font-size: 40px;
      line-height: 45px;
      color: #cd0d19;
      font-weight: 700;
      margin: 0 0 10px;
      font-family: 'Raleway', sans-serif;
      text-transform: uppercase;
      text-align: center !important;
      }
      .slip_head h2{
      font-size: 30px;
      line-height: 35px;
      color: #cd0d19;
      font-weight: 700;
      margin: 0 0 10px;
      font-family: 'Poppins', sans-serif;
      text-transform: uppercase;
      }
      .slip_head h3{
      font-size: 20px;
      line-height: 25px;
      color: #cd0d19;
      font-weight: 700;
      margin: 0 0 10px;
      font-family: 'Poppins', sans-serif;
      text-transform: uppercase;
      }
      .slip_head h4{
      font-size: 20px;
      line-height: 25px;
      color: #cd0d19;
      font-weight: 700;
      margin: 0 0 10px;
      font-family: 'Poppins', sans-serif;
      text-transform: uppercase;
      }

      .slip_sec table {
      margin: 70px 0 0;
      }
      .slip_head#head p {
        right: 0;
        width: 100%;
        display:inline-block;
        text-align:right !important;
        vertical-align:middle;
      }
      .slip_head#head p input[type="text"]{ 
      border: 0;
      background-color: #fff;
      font-size: 14px;
      line-height: 20px;
      color: #000000;
      height: 20px;
      margin-bottom: 20px;
      width: 30%;
      padding: 0px 15px;
      border-radius: 0;
      border-bottom: 2px solid #000000;
      float:right !important;

      }
      .main_table   input[type="text"] {
      border: 0;
      background-color: #fff;
      font-size: 14px;
      line-height: 20px;
      color: #000000;
      height: 20px;
      margin-bottom: 20px;
      width: 100%;
      padding: 0px 15px;
      border-radius: 0;
      border-bottom: 2px solid #000000;
      }
      td.custom {width: 90px;}
      td.text {
      width: 180px;}
      td.text.t {
      width: 200px;}
      table.inner_table {
      margin: 0;
      }
      .inner_table  td small {
      display: block;
      margin: 0 auto;
      text-align: center;
      }
      /* .slip_sec table, th, td {
      vertical-align: bottom;
      } */
      .custom{ text-align:center;}

    </style>

</head>
<body>

<?php
  $dt = \Carbon\Carbon::now(new DateTimeZone('Asia/Karachi'))->format('M d, Y - h:m a');
//   $amt = new NumberFormatter( 'en_GB', NumberFormatter::SPELLOUT );
  ?>
 
    <div class="slip_sec">
      <div class="slip_head" id="head">
        <h2 style="border-bottom:1px solid black;width:50%;margin:0 25% 0 25%;text-align:center">LABOUR CONTRACTOR</h2>
        <h1>Tulip Industries (Pvt) Limited</h1>
        <!-- <h2>Pwl 1/84</h2> -->
        <h3>F-237, S.I.T.E., KARACHI</h3>
        <!-- <h4>Phone:32570409,32562367, Fax:32562366</h4> -->
      </div>
      <div class="main_table table-responsive" style="padding:0 20px 0 20px">
        <table style="width:100%;">
          <tr>
            <td style="width:5%">M/s.</td>
            <td style="border-bottom:1px solid;width:90%;"></td>
          </tr>
          <tr>
            <td style="width:5%">C/A</td>
            <td style="border-bottom:1px solid;width:90%;"></td>
          </tr>
        </table>
        <table style="width:100%;">
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



        <table  style="width:100%">
        <tr>
            
            <td  id="date"><strong>Date:</strong> <input type="text"  value='{{ $dt }}' ></td>
        </tr>
          <tr>
           <td   class="text">Recived With thanks form</td>
            <td ><input type="text"></td>
          </tr>

          <tr>
            <td colspan="2"><input type="text"></td>
          </tr>
          <tr>
            <td class="text t">the sun of Rupees</td>
            <td><input type="text"></td>
          </tr>
          <tr>
            <td colspan="2"><input type="text"></td>
          </tr>
          <tr>
            <td colspan="2">
              <table class="inner_table" style="width:100%">
                <tr>
                  <td class="custom">by cheque No</td>
                  <td><input type="text"></td>
                  <td class="custom">dated</td>
                  <td><input type="text"></td>
                  <td class="custom">drawn on</td>
                  <td><input type="text"></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <table class="inner_table" style="width:100%">
                <tr>
                  <td colspan="2">Rs</td>
                  <td ><input type="text"> <small>(subject to realization of cheque)</small></td>
                  <td > </td>
                  <td colspan="2" style="text-align: right; padding:60px 0 0 0;">For Tulip Industries (Pvt) Limited</td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </div>
    </div>
</body>
</html>
