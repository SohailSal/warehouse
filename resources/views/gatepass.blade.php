<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Gate Pass Report</title>
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
                <span style="font-size: 22px; font:bold; background-color: black;
                color: white; "> DAILY EXBOND REPORT </span>
                <br />
                <span style="font-size: 20px;">GATE PASS</span>
            </p>
        </div>
        <div>
            <table style="width: 100%;">
                <tr>
                    <td style="width:15%; font-size:16px;"></td>
                    <td></td>
                    <td style="width:15%; font-size:15px; text-align:center;"> DATED : </td>
                    <td style="width:35%;font-size:15px; font-weight: bold; border-bottom: 1px solid black;">
                    {{ $dt }}</td>
                </tr>
            </table>
        </div>

        <br />

        <div class="information">
            <table width="100%" style="border-collapse: collapse; border: 1px solid black;">
                <thead Style="background-color: #a8b3b8;">

                    <tr>
                        <th
                            style="width: 5%;  font-size: 13px; border-collapse: collapse;  border: 1px solid black; padding: 15px 0px 15px 0px; ">
                            <strong>S.NO</strong>
                        </th>

                        <th
                            style="width: 15%;   font-size: 13px; border-collapse: collapse;  border: 1px solid black; padding: 15px 0px 15px 0px; ">
                            <strong>GATE PASS</strong>
                        </th>
                        <th
                            style="width: 10%; solid black; font-size: 13px; border: 1px solid black; padding: 15px 0px 15px 0px;">
                            <strong>BOND NO.</strong>
                        </th>
                        <th
                            style="width: 10%; border-collapse: collapse;   font-size: 13px;  border: 1px solid black; padding: 15px 0px 15px 0px;">
                            <strong>FILE NO.</strong>
                        </th>
                        <th
                            style="width: 20%; border-collapse: collapse;  font-size: 13px;  border: 1px solid black; padding: 15px 0px 15px 0px;">
                            <strong>PARTY NAME</strong>
                        </th>
                        <th
                            style="width: 20%;border:2px; solid black;    font-size: 13px; border: 1px solid black; padding: 15px 0px 15px 0px;">
                            <strong>DESCRITION</strong>
                        </th>

                        <th
                            style="width: 10%; solid black;   font-size: 13px;  border: 1px solid black; padding: 15px 0px 15px 0px; ">
                            <strong>QUANTITY</strong>
                        </th>
                        <th
                            style="width: 10%; solid black;   font-size: 13px;  border: 1px solid black; padding: 15px 0px 15px 0px;">
                            <strong>VEHICLE</strong>
                        </th>

                    </tr>

                </thead>

                <tbody>
                    <?php $number = 1;?>
                        {{-- { $balance = 0; }} --}}
                        {{-- @foreach ($data as $item) --}}
                        {{-- {{ $balance += $item['qty']; }} --}}

                    <tr style="">
                        <td style="width: 5%; font-size: 12px; text-align: center; border-collapse: collapse;  border: 1px solid black;
                            padding: 15px 0px 15px 0px;">
                                {{ $number }}
                        </td>
                        <td style="width: 15%; font-size: 12px; text-align: center; border-collapse: collapse;  border: 1px solid black;
                            padding: 15px 0px 15px 0px; ">
                                    {{ 'Gate Pass' }}
                        </td>

                        <td style="width: 10%; font-size: 12px; text-align: center; border-collapse: collapse;  border: 1px solid black;
                            padding: 15px 0px 15px 0px; ">
                                    {{ '0123456789' }}
                        </td>

                        <td style="width: %10; font-size: 12px; text-align: center; border-collapse: collapse;  border: 1px solid black;
                            padding: 15px 0px 15px 0px; ">
                                    {{ '240-AJ' }}
                        </td>


                        <td style="width: 20%;font-size: 12px; text-align: center; border-collapse: collapse;  border: 1px solid black;
                            padding: 15px 0px 15px 0px; ">

                                {{ 'NHK COMPANY' }}
                        </td>
                        <td style="width: 20%; font-size: 12px; text-align: center; border-collapse: collapse;  border: 1px solid black;
                            padding: 15px 0px 15px 0px; ">
                                    {{ 'Tracmax tyre' }}
                        </td>
                        <td style="width: 10%; font-size: 12px; text-align: center; border-collapse: collapse;  border: 1px solid black;
                            padding: 15px 0px 15px 0px;">
                                    {{  20  }}
                        </td>
                        <td style="width: 10%; font-size: 12px; text-align: center; border-collapse: collapse;  border: 1px solid black;
                            padding: 15px 0px 15px 0px; ">

                                    {{ 'Kab-45' }}
                        </td>
                                <?php $number++; ?>
                    </tr>

                    <tr style="">
                        <td style="width: 5%; font-size: 12px; text-align: center; border-collapse: collapse;  border: 1px solid black;
                            padding: 15px 0px 15px 0px;">
                                {{ $number }}
                        </td>
                        <td style="width: 15%; font-size: 12px; text-align: center; border-collapse: collapse;  border: 1px solid black;
                            padding: 15px 0px 15px 0px; ">
                                    {{ 'Gate Pass' }}
                        </td>

                        <td style="width: 10%; font-size: 12px; text-align: center; border-collapse: collapse;  border: 1px solid black;
                            padding: 15px 0px 15px 0px; ">
                                    {{ '0123456789' }}
                        </td>

                        <td style="width: %10; font-size: 12px; text-align: center; border-collapse: collapse;  border: 1px solid black;
                            padding: 15px 0px 15px 0px; ">
                                    {{ '240-AJ' }}
                        </td>


                        <td style="width: 20%;font-size: 12px; text-align: center; border-collapse: collapse;  border: 1px solid black;
                            padding: 15px 0px 15px 0px; ">

                                {{ 'NHK COMPANY' }}
                        </td>
                        <td style="width: 20%; font-size: 12px; text-align: center; border-collapse: collapse;  border: 1px solid black;
                            padding: 15px 0px 15px 0px; ">
                                    {{ 'Tracmax tyre' }}
                        </td>
                        <td style="width: 10%; font-size: 12px; text-align: center; border-collapse: collapse;  border: 1px solid black;
                            padding: 15px 0px 15px 0px;">
                                    {{  30  }}
                        </td>
                        <td style="width: 10%; font-size: 12px; text-align: center; border-collapse: collapse;  border: 1px solid black;
                            padding: 15px 0px 15px 0px; ">

                                    {{ 'Kab-45' }}
                        </td>
                                <?php $number++; ?>
                    </tr>

                    <tr style="">
                        <td style="width: 5%; font-size: 12px; text-align: center; border-collapse: collapse;  border: 1px solid black;
                            padding: 15px 0px 15px 0px;">
                                {{ $number }}
                        </td>
                        <td style="width: 15%; font-size: 12px; text-align: center; border-collapse: collapse;  border: 1px solid black;
                            padding: 15px 0px 15px 0px; ">
                                    {{ 'Gate Pass' }}
                        </td>

                        <td style="width: 10%; font-size: 12px; text-align: center; border-collapse: collapse;  border: 1px solid black;
                            padding: 15px 0px 15px 0px; ">
                                    {{ '0123456789' }}
                        </td>

                        <td style="width: %10; font-size: 12px; text-align: center; border-collapse: collapse;  border: 1px solid black;
                            padding: 15px 0px 15px 0px; ">
                                    {{ '240-AJ' }}
                        </td>


                        <td style="width: 20%;font-size: 12px; text-align: center; border-collapse: collapse;  border: 1px solid black;
                            padding: 15px 0px 15px 0px; ">

                                {{ 'NHK COMPANY' }}
                        </td>
                        <td style="width: 20%; font-size: 12px; text-align: center; border-collapse: collapse;  border: 1px solid black;
                            padding: 15px 0px 15px 0px; ">
                                    {{ 'Tracmax tyre' }}
                        </td>
                        <td style="width: 10%; font-size: 12px; text-align: center; border-collapse: collapse;  border: 1px solid black;
                            padding: 15px 0px 15px 0px;">
                                    {{  50  }}
                        </td>
                        <td style="width: 10%; font-size: 12px; text-align: center; border-collapse: collapse;  border: 1px solid black;
                            padding: 15px 0px 15px 0px; ">

                                    {{ 'Kab-45' }}
                        </td>
                                <?php $number++; ?>
                    </tr>

                    <tr style="">
                        <td style="width: 5%; font-size: 12px; text-align: center; border-collapse: collapse;  border: 1px solid black;
                            padding: 15px 0px 15px 0px;">
                                {{ $number }}
                        </td>
                        <td style="width: 15%; font-size: 12px; text-align: center; border-collapse: collapse;  border: 1px solid black;
                            padding: 15px 0px 15px 0px; ">
                                    {{ 'Gate Pass' }}
                        </td>

                        <td style="width: 10%; font-size: 12px; text-align: center; border-collapse: collapse;  border: 1px solid black;
                            padding: 15px 0px 15px 0px; ">
                                    {{ '0123456789' }}
                        </td>

                        <td style="width: %10; font-size: 12px; text-align: center; border-collapse: collapse;  border: 1px solid black;
                            padding: 15px 0px 15px 0px; ">
                                    {{ '240-AJ' }}
                        </td>


                        <td style="width: 20%;font-size: 12px; text-align: center; border-collapse: collapse;  border: 1px solid black;
                            padding: 15px 0px 15px 0px; ">

                                {{ 'NHK COMPANY' }}
                        </td>
                        <td style="width: 20%; font-size: 12px; text-align: center; border-collapse: collapse;  border: 1px solid black;
                            padding: 15px 0px 15px 0px; ">
                                    {{ 'Tracmax tyre' }}
                        </td>
                        <td style="width: 10%; font-size: 12px; text-align: center; border-collapse: collapse;  border: 1px solid black;
                            padding: 15px 0px 15px 0px;">
                                    {{  100  }}
                        </td>
                        <td style="width: 10%; font-size: 12px; text-align: center; border-collapse: collapse;  border: 1px solid black;
                            padding: 15px 0px 15px 0px; ">

                                    {{ 'Kab-45' }}
                        </td>
                                <?php $number++; ?>
                    </tr>
                            {{-- @endforeach --}}

                </tbody>


            </table>
        </div>
</body>

</html>
