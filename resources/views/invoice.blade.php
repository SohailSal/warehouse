<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Client Branches Report</title>
</head>
<body>

<?php
  $dt = \Carbon\Carbon::now(new DateTimeZone('Asia/Karachi'))->format('M d, Y - h:m a');
  $amt = new NumberFormatter( 'en_GB', NumberFormatter::SPELLOUT );
  ?>


<div class="information">

<div style="width:100%; text-align:center;line-height:normal;">
   <p>
   <span style="font-size: 30px;   font-weight: bold;" >TULIP INDUSTIRIES (PVT.) LTD.</span>
   <br/>
        PUBLIC BONDED WAREHOUSE PWL-01/84
        <br/>
        BILL & SALE TAX INVOICE
        <br/>
        Phone: (021) 32570409 - 32562367 <t/> Fax: 92-21-32562366
        <br/>
        NTN: 0712486-4 <t/>  Sale Tax No: S0712486-4
        <br />
</p>
</div>
    <div>
    <table style="width: 100%;">
        @foreach ($invoices as $invoice)

        <tr>   
        <td style="width:15%;">
                Bill No:  
            </td>
            <td style="width:35%;" ><strong>{{ $delivery->id}}</strong></td>  
            
        </td >
        <td style="width:15%;">
            <td style="width:35%; text-align:center;"> <strong><span style="font-size: 14px; ">F-237 S.I.T.E.,<br/>
                    KARACHI-75700<br/>
                    PAKISTAN <br/><br/></span></strong></td>
        </tr>
        
        <tr>
        <td style="width:15%;">
                Importer Name: 
            </td>
            <td style="width:35%; font-weight: bold; border-bottom: 1px solid black;">{{$invoice['importer']}}</td> 
            <td style="width:15%;">
                Date:
            </td >
            <td  style="width:35%; font-weight: bold; border-bottom: 1px solid black;">{{$delivery->date}}</td></td>
           
           
        </tr>

        <tr>
            <td style="width:15%;">            
               NTN No: 
            </td>
            <td style="width:35%; font-weight: bold; border-bottom: 1px solid black;">{{$invoice['stn_no']}}</td>
            <td style="width:15%;">
                File Number: 
            </td>
            <td style="width:35%; font-weight: bold; border-bottom: 1px solid black;" >{{ $invoice['file_no']}}</td>
           
           
        </tr>

        <tr>
            <td style="width:15%;">            
                Sale Tax Number: 
            </td>
            <td style="width:35%; font-weight: bold; border-bottom: 1px solid black;">{{$invoice['stn_no']}}</td>
            <td style="width:15%;">            
                L\C Number: 
            </td>
            <td style="width:35%; font-weight:bold; border-bottom: 1px solid black;">{{$invoice['lc_no']}}</td> 
        </tr>

        <tr>        
            <td style="width:15%;">
                Clearing Agent: 
            </td>
            <td style=" width:35%; font-weight:bold; border-bottom: 1px solid black;"> {{$invoice['agent']}}</td>
            <td style="width:15%;">            
                Bond No: 
            </td>
            <td style="width:35%; font-weight:bold; border-bottom: 1px solid black;">{{$invoice['bond_no']}}</td> 
        </tr>

    </table>
</div>

<br />

<div class="information">
    <table width="100%" style="border-collapse: collapse; border: 1px solid black;">
            <thead Style="background-color: #a8b3b8;">
            </style>>
        <tr>
            <th style="width: 5%; border-collapse: collapse;  border: 1px solid black; ">
                <strong>S.No</strong>
            </th>
            <th style="width: 10%; border-collapse: collapse;   border: 1px solid black;">
                <strong>Qty</strong>
            </th>
            <th style="width: 25%; border-collapse: collapse;  border: 1px solid black;">
                <strong>Discription</strong>
            </th>
            <th style="width: 15%;border:2px; solid black;   border: 1px solid black;">
                <strong>Rate of Warehousing Charges Per Month</strong>
            </th>
            <th style="width: 15%; solid black;   border: 1px solid black;">
                <strong>Period</strong>
            </th>
            <th style="width: 15%; solid black;   border: 1px solid black;">
                <strong>Value Excluding Sale Tax</strong>
            </th>
            <th style="width: 10%; solid black;   border: 1px solid black;">
                <strong>Amount of Sale Tax @ </strong>
            </th>
            <th style="width:15%; solid black;  border: 1px solid black;">
                <strong>Value Including of Sale Tax</strong>
            </th>
        </tr>
        
            </thead>
            <tbody>

<?php $number = 1; ?>


<tr style="">
    <td style="width:5%; text-align: center; border-collapse: collapse;  border: 1px solid black; padding: 50px 0px 240px 0px;" >
         {{ $number }}
    </td>
    <td style="width: 10%; text-align: center; border-collapse: collapse;  border: 1px solid black; padding: 50px 0px 240px 0px;">
          {{$invoice['qty']}}
    </td>

    <td style="width: 25%; text-align: center; border-collapse: collapse;  border: 1px solid black; padding: 50px 0px 240px 0px;">
          {{$invoice['description']}}
    </td>

    <td style="width: %15;text-align: center; border-collapse: collapse;  border: 1px solid black; padding: 50px 0px 240px 0px;">
          {{$invoice['amount']}}
    </td>

    <td style="width: 15%; text-align: center; border-collapse: collapse;  border: 1px solid black; padding: 50px 0px 240px 0px;">
          {{$invoice['date_bond']}}
    </td>
    <td style="width: 15%; text-align: center; border-collapse: collapse;  border: 1px solid black; padding: 50px 0px 240px 0px;">
          {{$invoice['amount']}}
              </td>
          <td style="width: 10%; text-align: center; border-collapse: collapse;  border: 1px solid black; padding: 50px 0px 240px 0px;">
          {{$invoice['s_tax']}}
    </td>
    <td style="width: 15%; text-align: center; border-collapse: collapse;  border: 1px solid black; padding: 50px 0px 240px 0px;">
    
          {{$invoice['amount'] + $invoice['s_tax']}}
    </td>
     <?php $number++; ?>
    </tr>
    </tbody>
    
</table>
<p style="width: 100%; text-align:right; font-size: 12px" >E.&.O.E</p>
<p style="width:100%">        
    <strong>Rupees in Word : {{ucwords($amt->format($invoice['amount'] + $invoice['s_tax'])) }} only.</strong></td>
        </p>
    @endforeach
<br/>
                <h5 style="text-decoration: overline; width: 90%; text-align:right;">
                for TULIP INDUSTIRIES (PVT.) LTD.
                </h5>
</div>
</body>
</html>
