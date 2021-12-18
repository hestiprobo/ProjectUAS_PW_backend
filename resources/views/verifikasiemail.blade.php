
@can('semiuser')
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="{{url('/css/w3.css')}}">
        <title>Perhatian</title>
    </head>
    <body>
        <div class="w3-panel w3-pale-blue w3-border">
            <h3>Perhatian!</h3>
            <p>Verifikasi Email Terlebih dahulu Untuk Mengakses Lebih!</p>
            <p>Silahkan Cek Emailmu.</p>
        </div>
    </body>
</html>
@elsecan('user')
<meta content="0; url=/home" http-equiv="refresh">
@endcan