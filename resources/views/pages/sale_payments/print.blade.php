<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="/assets/css/print_plan.css" rel="stylesheet" type="text/css">

    <title>Квитанция</title>
    <link rel="stylesheet" href="/assets/plugins/print-js/print.min.css">
    <script src="/assets/plugins/print-js/print.min.js"></script>
</head>

<body>
    <div class="print-div" id="print-div">
        <h3 style="font-size: 20px; margin-top: 10px; margin-bottom: 10px;">
            Taxiatosh TRIO MCHJ тулов квитанцияси
        </h3>

        <table>
            <tr>
                <td style="width: 50%; text-align: left;"><b>Сана</b></td>
                <td style="width: 50%; text-align: left;">{{ $sale_payment->created_at->format('d.m.Y') }}</td>
            </tr>
            <tr>
                <td style="width: 50%; text-align: left;"><b>Кассир</b></td>
                <td style="width: 50%; text-align: left;">{{ $sale_payment->user->fullname }}</td>
            </tr>
            <tr>
                <td style="width: 50%; text-align: left;"><b>Сумма</b></td>
                <td style="width: 50%; text-align: left;">{{ nf($sale_payment->amount) }}</td>
            </tr>
            <tr>
                <td style="width: 50%; text-align: left;"><b>ФИО</b></td>
                <td style="width: 50%; text-align: left;">{{ $sale_payment->customer->full_name }}</td>
            </tr>
        </table>

        <p>
            <b>Ташрифингиздан мамнумиз ! Кейинги туловни вактида амалга оширишни унутманг !</b>
        </p>

        <div style="text-align: center; padding: 50px; border: 1px solid #000; margin: 10px;">


        </div>

        <p>
            <b>Квитанция</b>
        </p>

        <table>
            <tr>
                <td style="width: 50%; text-align: left;"><b>Сана</b></td>
                <td style="width: 50%; text-align: left;">{{ $sale_payment->created_at->format('d.m.Y') }}</td>
            </tr>
            <tr>
                <td style="width: 50%; text-align: left;"><b>Кассир</b></td>
                <td style="width: 50%; text-align: left;">{{ $sale_payment->user->fullname }}</td>
            </tr>
            <tr>
                <td style="width: 50%; text-align: left;"><b>Сумма</b></td>
                <td style="width: 50%; text-align: left;">{{ nf($sale_payment->amount) }}</td>
            </tr>
            <tr>
                <td style="width: 50%; text-align: left;"><b>ФИО</b></td>
                <td style="width: 50%; text-align: left;">{{ $sale_payment->customer->full_name }}</td>
            </tr>
        </table>


    </div>
    <script>
        function printDiv() {
            printJS({
                printable: 'print-div',
                type: 'html',
                css: [
                    '/assets/css/print_plan.css',
                ],
            })
        }
        printDiv();
    </script>
</body>

</html>
