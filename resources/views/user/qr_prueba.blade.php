<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>QR de prueba</title>
</head>
<body>
   <img src="data:image/png;base64, {!! base64_encode(QrCode::format('svg')->merge(asset('img/bg_qr.jpg'), .3, true)->size(200)->generate('https://ciberpaz.gov.co/')) !!} ">
   <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->merge(asset('img/bg_qr.jpg'), .3, true)->size(200)->color(255, 0, 0, 75)->backgroundColor(255, 255, 0, 25)->style('round')->eye('circle')->generate('https://ciberpaz.gov.co/')) !!} ">
</body>
</html>