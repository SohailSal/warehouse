<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Bin Card Report</title>
</head>

<body>

    <?php
    $dt = \Carbon\Carbon::now(new DateTimeZone('Asia/Karachi'))->format('M d, Y - h:m a');
    $amt = new NumberFormatter('en_GB', NumberFormatter::SPELLOUT);
    ?>


    <div class="information">

        <div style="width:100%; text-align:center;line-height:normal;">
            <p>
                <span style="font-size: 30px;   font-weight: bold;">TULIP INDUSTRIES (PVT) LTD</span>
                <br />
                PWL-01/84
                <br />
                <span style="font-size: 20px; ">Bin Card Detail Report</span>

            </p>
        </div>
        <div>
            <table style="width: 100%;">
                <tr>
                    <td style="width:15%; font-size:16px;">
                        Bond No.
                    </td>
                    <td style="width:35%; font-size:15px; font-weight: bold; border-bottom: 1px solid black;">
                        {{ $file[0]['bond_no'] }}</td>

                    </td>
                    <td style="width:15%; font-size:15px; text-align:center;"> file No. </td>
                    <td style="width:35%;font-size:15px; font-weight: bold; border-bottom: 1px solid black;">
                        {{ $file[0]['file_no'] }}</td>

                </tr>


                <tr>
                    <td style="width:15%;font-size:15px;">
                        Date.
                    </td>
                    <td style="width:35%; font-size:15px; font-weight: bold; border-bottom: 1px solid black;">
                        {{ $file[0]['date']}}</td>
                    <td style="width:15%; text-align:center; font-size:15px;">
                        S.S.
                    </td>
                    <td style="width:35%; font-weight: bold;font-size:15px; border-bottom: 1px solid black;">
                        {{$file[0]['s.s']}}</td>
                </tr>

                <tr>
                    <td style="width:15%; font-size:15px;">
                        IGM No.
                    </td>
                    <td style="width:35%; font-size:15px; font-weight: bold; border-bottom: 1px solid black;">
                        {{ $file[0]['igm_no'] }}</td>
                    <td style="width:15%; font-size:15px;  text-align:center;">
                        Index No.
                    </td>
                    <td style="width:35%; font-size:15px; font-weight:bold; border-bottom: 1px solid black;">
                        {{ $file[0]['index_no'] }}</td>
                </tr>
                <tr>

            </table>
            <br />
            <table style="width: 100%;">
                <tr>
                    <td style="width:18%; font-size:15px;">
                        Marks:-
                    </td>
                    <td style="width:82%; font-size:15px; font-weight: bold; border-bottom: 1px solid black;">
                        </td>
                </tr>

                <tr>
                    <td style="width:18%; font-size:15px;">Importer Name. </td>
                    <td style="width:82%; font-size:15px; font-weight: bold; border-bottom: 1px solid black;">
                        {{ $file[0]['importer_id'] }}</td>
                </tr>

                <tr>
                    <td style="width:18%;font-size:15px;">
                        Client Name.
                    </td>
                    <td style="width:82%; font-size:15px; font-weight: bold; border-bottom: 1px solid black;">
                        {{ $file[0]['client_id'] }}</td>
                </tr>

                <tr>
                    <td style="width:18%; font-size:15px;">
                        Agent.
                    </td>
                    <td style="width:82%; font-size:15px; font-weight: bold; border-bottom: 1px solid black;">
                        {{ $file[0]['agent_id'] }}</td>
                </tr>

                <tr>
                    <td style="width:18%; font-size:15px;">
                        Description.
                    </td>
                    <td style="width:82%; font-size:15px; font-weight: bold; border-bottom: 1px solid black;">
                        {{ $file[0]['desc'] }}</td>
                </tr>
            </table>
            <br />
            <table style="width: 100%;">
                <tr>
                    <td style="width:15%;">
                        Quantity:-
                    </td>
                    <td style="width:35%; font-weight: bold; border-bottom: 1px solid black;">{{ $file[0]['qty'] }}</td>
                    <td style="width:15%; text-align:center;">Signature. </td>
                    <td style="width:35%; font-weight: bold; border-bottom: 1px solid black;"></td>
                </tr>

                <tr>
                    <td style="width:15%; ">
                        Stored On.
                    </td>
                    <td style="width:35%; font-weight: bold; border-bottom: 1px solid black;">{{ $file[0]['date'] }}</td>

                    <td style="width:15%;text-align:center;">
                        CODE. </td>
                    <td style="width:35%; font-weight: bold; border-bottom: 1px solid black;">{{ $file[0]['file_code'] }}</td>
                </tr>
            </table>
        </div>

        <br />

        <div class="information">
            <table width="100%" style="border-collapse: collapse; border: 1px solid black;">
                <thead Style="background-color: #a8b3b8;">
           
                    <tr>
                        <th
                            style="width: 5%;  font-size: 15px; border-collapse: collapse;  border: 1px solid black; padding: 15px 0px 15px 0px; ">
                            <strong>S.No</strong>
                        </th>

                        <th
                            style="width: 12%;   font-size: 15px; border-collapse: collapse;  border: 1px solid black; padding: 15px 0px 15px 0px; ">
                            <strong>Removal date</strong>
                        </th>
                        <th
                            style="width: 25%; solid black;    font-size: 15px; border: 1px solid black; padding: 15px 0px 15px 0px;">
                            <strong>Items </strong>
                        </th>
                        <th
                            style="width: 10%; border-collapse: collapse;   font-size: 15px;  border: 1px solid black; padding: 15px 0px 15px 0px;">
                            <strong>Qty Removed</strong>
                        </th>
                        <th
                            style="width: 10%; border-collapse: collapse;  font-size: 15px;  border: 1px solid black; padding: 15px 0px 15px 0px;">
                            <strong>Balance</strong>
                        </th>
                        <th
                            style="width: 12%;border:2px; solid black;    font-size: 15px; border: 1px solid black; padding: 15px 0px 15px 0px;">
                            <strong>Initial Officer</strong>
                        </th>

                        <th
                            style="width: 10%; solid black;   font-size: 15px;  border: 1px solid black; padding: 15px 0px 15px 0px; ">
                            <strong>Vehicle No.</strong>
                        </th>
                        <th
                            style="width: 16%; solid black;   font-size: 15px;  border: 1px solid black; padding: 15px 0px 15px 0px;">
                            <strong>Remarks</strong>
                        </th>

                    </tr>
       
                </thead>

                <tbody>

                    <?php $number = 1;
                  
                    ?>



{{ $balance = 0; }}
@foreach ($data as $item)
    {{ $balance += $item['qty']; }}

                    <tr style="">
                        <td style="width: 5%; font-size: 12px; text-align: center; border-collapse: collapse;  border: 1px solid black;
                        padding: 15px 0px 15px 0px;">
                            {{ $number }}
                        </td>
                        <td style="width: 12%; font-size: 12px; text-align: center; border-collapse: collapse;  border: 1px solid black;
                padding: 15px 0px 15px 0px; ">
                            {{ $item['date'] }}
                        </td>

                        <td style="width: 25%; font-size: 12px; text-align: center; border-collapse: collapse;  border: 1px solid black;
                padding: 15px 0px 15px 0px; ">
                            {{ $item['item'] }}
                        </td>

                        <td style="width: %10; font-size: 12px; text-align: center; border-collapse: collapse;  border: 1px solid black;
                padding: 15px 0px 15px 0px; ">
                            {{ $item['qty'] }}
                        </td>


                        <td style="width: 10%;font-size: 12px; text-align: center; border-collapse: collapse;  border: 1px solid black;
                padding: 15px 0px 15px 0px; ">
                    
                          {{ $item['t_qty'] - $balance }}
                        </td>
                        <td style="width: 12%; font-size: 12px; text-align: center; border-collapse: collapse;  border: 1px solid black;
                padding: 15px 0px 15px 0px; ">
                            {{ 'sign' }}
                        </td>
                        <td style="width: 10%; font-size: 12px; text-align: center; border-collapse: collapse;  border: 1px solid black; 
                    padding: 15px 0px 15px 0px;">
                            {{  $item['vehicle_no']  }}
                        </td>
                        <td style="width: 16%; font-size: 12px; text-align: center; border-collapse: collapse;  border: 1px solid black;
                padding: 15px 0px 15px 0px; ">

                            {{ 'HEllow Thanks' }}
                        </td>
                        <?php $number++; ?>
                    </tr>
     @endforeach

                </tbody>


            </table>
        </div>
</body>

</html>
