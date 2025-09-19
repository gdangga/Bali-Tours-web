<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Alamat Email Anda</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            color: #333333;
        }
        .container {
            background-color: #ffffff;
            max-width: 600px;
            margin: 0 auto;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 1px solid #dddddd;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #c2410c; /* Warna Oranye Gelap */
            margin: 0;
        }
        .content p {
            line-height: 1.6;
        }
        .button-container {
            text-align: center;
            margin: 30px 0;
        }
        .button {
            background-color: #f97316; /* Warna Oranye Utama */
            color: #ffffff;
            padding: 15px 25px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            display: inline-block;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #888888;
        }
        .footer p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Satu Langkah Lagi!</h1>
        </div>
        <div class="content">
            <p>Halo,</p>
            <p>Terima kasih telah mendaftar di TourBooking. Silakan klik tombol di bawah ini untuk mengaktifkan akun Anda dan mulai merencanakan petualangan impian Anda.</p>
            
            <div class="button-container">
                {{-- Laravel akan secara otomatis menyediakan variabel $url ini --}}
                <a href="{{ $url }}" class="button">Aktifkan Akun Saya</a>
            </div>
            
            <p>Jika Anda kesulitan mengklik tombol "Aktifkan Akun Saya", salin dan tempel URL di bawah ini ke browser web Anda:</p>
            <p><a href="{{ $url }}" style="word-break: break-all;">{{ $url }}</a></p>
            <br>
            <p>Terima kasih,<br>Tim TourBooking</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} TourBooking. All Rights Reserved.</p>
            <p>Jika Anda tidak mendaftar untuk akun ini, Anda dapat mengabaikan email ini.</p>
        </div>
    </div>
</body>
</html>