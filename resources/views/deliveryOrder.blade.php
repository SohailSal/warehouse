<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delivery</title>
</head>
<body>

<?php
  $dt = \Carbon\Carbon::now(new DateTimeZone('Asia/Karachi'))->format('M d, Y - h:m a');
  $amt = new NumberFormatter( 'en_GB', NumberFormatter::SPELLOUT );
//   dd($delivery[0]['code']);
  ?>

<div class="information">

<div style="width:100%; text-align:center;line-height:normal;">
   <p>
   <span style="font-size: 30px;font-weight: bold;">TULIP INDUSTIRIES (PVT) LTD</span>
   <br/>
        F-237,S.I.T.E., Karachi.
        <!-- PUBLIC BONDED WAREHOUSE PWL-01/84 -->
        <br/>
        <span style="font-size: 20px;font-weight: bold; border-bottom:2px solid black">DELIVERY ORDER</span>
        <!-- BILL & SALE TAX INVOICE -->
        <!-- <br/>
        Phone: (021) 32570409 - 32562367 <t/> Fax: 92-21-32562366
        <br/>
        NTN: 0712486-4 <t/>  Sale Tax No: S0712486-4 -->
</p>
</div>
    
<table style="width: 100%;">
    <tr>
        <td style="width:15%;text-align:left;">
            Code : 
        </td>
        <td style="width:35%;text-align:left;border-bottom: 1px solid black">
            {{ $delivery[0]['code'] }}
        </td>
        <td style="width:15%;text-align:right;">
            No of Pkgs. 
        </td>
        <td style="width:35%;text-align:center;border-bottom: 1px solid black">
            {{ $delivery[0]['no_of_pkgs'] }}
        </td>
    </tr>
</table>

<table style="width: 100%">
    <tr>
        <td style="width:15%;text-align:left;">
            Importer : 
        </td>
        <td style="width:85%;text-align:left;border-bottom: 1px solid black">
            {{ $delivery[0]['importer'] }}
        </td>
    </tr>
    <tr>
        <td style="width:21%;text-align:left;">
            <!-- Description of Goods :  -->
            Goods Description : 
        </td>
        <td style="width:85%;text-align:left;border-bottom: 1px solid black">
            {{ $delivery[0]['descrip'] }}
        </td>
    </tr>

</table>
<table style="width: 100%;">
    <tr>
        <td style="width:15%;text-align:left;">
            IB No : 
        </td>
        <td style="width:35%;text-align:left;border-bottom: 1px solid black">
            Don't know
        </td>
        <td style="width:15%;text-align:right;">
            EB No. : 
        </td>
        <td style="width:35%;text-align:center;border-bottom: 1px solid black">
            Don't know
        </td>
    </tr>
    <tr>
        <td style="text-align:left;">
            File No. :
        </td>
        <td style="width:35%;text-align:left;border-bottom: 1px solid black">
            {{ $delivery[0]['file_no'] }}
        </td>
        <td style="text-align:right;">
            Index : 
        </td>
        <td style="width:35%;text-align:left;border-bottom: 1px solid black">
            {{ $delivery[0]['index'] }}
        </td>
    </tr>

</table>

<table style="width: 100%;">
    <tr>
        <td style="width: 15%;text-align:left;">
            Cash No. : 
        </td>
        <td style="width:21%;text-align:left;border-bottom: 1px solid black">
        </td>
        <td style="width: 15%;text-align:right;">
            Balance : 
        </td>
        <td style="width:21%;text-align:left;border-bottom: 1px solid black">
        </td>
        <td style="width: 15%;text-align:right;">
            Time : 
        </td>
        <td style="width:21%;text-align:left;border-bottom: 1px solid black">
        </td>
    </tr> 
</table>

<table style="width:100%;">
    <tr>
        <td style="text-align:left;">
            Vehicle No. : 
        </td>
        <td style="width:35%;text-align:left;border-bottom: 1px solid black">
            {{ $delivery[0]['vehicle_no'] }}
        </td>
        <td style="text-align:right;">
            Quantity : 
        </td>
        <td style="width:35%;text-align:left;border-bottom: 1px solid black">
            {{ $delivery[0]['quantity'] }}
        </td>
    </tr>
</table>



<!-- <table style="width: 100%;">
    <tr>
        <td style="width:15%;text-align:left;">
            Code : 
        </td>
        <td style="width:35%;text-align:left;border-bottom: 1px solid black">
            {{ $delivery[0]['code'] }}
        </td>
        <td style="width:15%;text-align:right;">
            No of Pkgs. 
        </td>
        <td style="width:35%;text-align:center;border-bottom: 1px solid black">
            {{ $delivery[0]['no_of_pkgs'] }}
        </td>
    </tr>
    <tr>
        <td style="width:100%;text-align:left;">
            Importer : 
        </td>
        <td style="width:100%;text-align:left;border-bottom: 1px solid black">
        </td>
        <td style="width:100%;text-align:left;border-bottom: 1px solid black">
        </td>
        <td style="width:100%;text-align:left;border-bottom: 1px solid black">
        </td>
        
    </tr>

    <tr>
        <td style="width:15%;text-align:left;">
            Description of Goods : 
        </td>
        <td style="width:35%;text-align:left;border-bottom: 1px solid black">
            {{ $delivery[0]['descrip'] }}
        </td>
        <td style="width:10%;text-align:left;border-bottom: 1px solid black">
        </td>
        <td style="width:35%;text-align:left;border-bottom: 1px solid black">
        </td>
    </tr>


    <tr>
        <td style="text-align:left;">
            IB No. : 
        </td>
        <td style="width:100%;text-align:left;border-bottom: 1px solid black">
        </td>
        <td style="text-align:right;">
            EB No. : 
        </td>
        <td style="width:100%;text-align:left;border-bottom: 1px solid black">
        </td>
    </tr>

    <tr>
        <td style="text-align:left;">
            File No. :
        </td>
        <td style="width:100%;text-align:left;border-bottom: 1px solid black">
            {{ $delivery[0]['file_no'] }}
        </td>
        <td style="text-align:right;">
            Index : 
        </td>
        <td style="width:100%;text-align:left;border-bottom: 1px solid black">
            {{ $delivery[0]['index'] }}
        </td>
    </tr>


    <tr>
        <td style="text-align:left;">
            Cash No. : 
        </td>
        <td style="width:100%;text-align:left;border-bottom: 1px solid black">
        </td>
        <td style="text-align:left;">
            Balance : 
        </td>
        <td style="width:100%;text-align:left;border-bottom: 1px solid black">
        </td>
        <td style="text-align:left;">
            Time : 
        </td>
        <td style="width:100%;text-align:left;border-bottom: 1px solid black">
        </td>
    </tr>   

    <tr>
        <td style="text-align:left;">
            Vehicle No. : 
        </td>
        <td style="width:100%;text-align:left;border-bottom: 1px solid black">
            {{ $delivery[0]['vehicle_no'] }}
        </td>
        <td style="text-align:right;">
            Quantity : 
        </td>
        <td style="width:100%;text-align:left;border-bottom: 1px solid black">
            {{ $delivery[0]['quantity'] }}
        </td>
    </tr>

    </table>

 -->
</div>

<div class="information">
<h3>Items</h3>
<table style="width: 80%;">
    {{ $i = 1; }}
    @foreach ($items as $item)
 
    <tr>
        <td style="width:4%;">{{ $i }}</td>
        <td style="width:8%;">Item :</td>
        <td style="width:25%;text-align:left;border-bottom: 1px solid black">{{$item['item']}}</td>
        <td style="width:15%;text-align:right">Quantity :</td>
        <td style="width:25%;text-align:center;border-bottom: 1px solid black">{{$item['quantity']}}</td>
    </tr>
    {{ $i++ }}
    @endforeach
</table>
<br />
<br />
    <h5 style="text-decoration: overline;font-style:italic; width: 90%; text-align:right;">
        Signature
    </h5>
</div>
</body>
</html>
