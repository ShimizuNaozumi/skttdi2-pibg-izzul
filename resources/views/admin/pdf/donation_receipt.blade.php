<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$donation_invoiceno}}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 70%;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #343a40;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header img {
            width: 80px;
            margin-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            color: #343a40;
        }
        .header p {
            margin: 0;
            font-size: 14px;
            color: #6c757d;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #dee2e6;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            font-size: 16px;
            color: #343a40;
        }
        td {
            font-size: 14px;
            color: #495057;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{public_path('/dist/img/logo.png')}}" alt="">
            <h1>Resit Pembayaran</h1>
            <p>{{$donation_invoiceno}}</p>
        </div>
        <table>
            <thead>
                <tr>
                    <th colspan="2">Butiran Penyumbang</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Nama</td>
                    <td>{{$donor_name}}</td>
                </tr>
                <tr>
                    <td>E-mel</td>
                    <td>{{$donor_email}}</td>
                </tr>
                <tr>
                    <td>No. Telefon</td>
                    <td>{{$donor_notel}}</td>
                </tr>
            </tbody>
        </table>
        <table>
            <thead>
                <tr>
                    <th colspan="2">Butiran Sumbangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Nama Sumbangan</td>
                    <td>{{$donation_name}}</td>
                </tr>
                <tr>
                    <td>Tarikh Sumbangan</td>
                    <td>{{$donation_date}}</td>
                </tr>
                <tr>
                    <td>Jumlah Sumbangan</td>
                    <td><b>RM {{$donation_amount}}</b></td>
                </tr>
            </tbody>
        </table>
        <div class="footer">
            <p>Terima kasih atas sumbangan anda!</p>
        </div>
    </div>
</body>
</html>
