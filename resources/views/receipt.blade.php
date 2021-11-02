<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Receipt</title>
</head>

<body>

    <?php
    $dt = \Carbon\Carbon::now(new DateTimeZone('Asia/Karachi'))->format('M d, Y - h:m a');
    $amt = new NumberFormatter('en_GB', NumberFormatter::SPELLOUT);
    ?>


    <div class="information">
        <div style="width:100%; text-align:center;line-height:normal;">
            <p>
                <span style="font-size: 30px;   font-weight: bold;">TULIP INDUSTIRIES (PVT) LIMITED
                    <br />
                    PWL 1/84

                </span>
                <br />
                <span style="font-size: 20px;   font-weight: bold;">
                    F-237,S.I.T.E., Karachi.
                    <br />
                    Phone: (021) 32570409 - 32562367
                    <t /> Fax: 92-21-32562366
                    <br />
                </span>
            </p>
        </div>
        <div style="widht:100%;display:block;background-color:red;justify-content:right;display:flex;">
            <p style="width:20%;display:flex;background-color:blue;">Date : </p>
            <p style="width:20%; display:flex;border-bottom:1px solid;background-color:green;">dsfs</p>

        </div>

        <div>
            <p>
                <span style="display:inline-block;widht:50px">Received</span> with thanks from <span
                    style="border-bottom:1px solid black;width:40%;display:inline-block"></span>
            </p>
        </div>

        <br />
        <div>
            <h4 style="float:left">Rs.</h4><span style="width:30%;border-bottom:1x solid black;></span>
            <span style=" width:30%;border-bottom:1x solid black;></span>
        </div>
        <br />
        <h5 style=" text-decoration: overline; width: 50%; text-align:left;float:left;">
            (Subject to realization of cheque)
        </h5>
        <h5 style="text-decoration: overline; width: 50%; text-align:right;float:right">
            FOR TULIP INDUSTIRIES (PVT) LTD
        </h5>
    </div>
</body>

</html>
