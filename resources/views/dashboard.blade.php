<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DashBoard ASVZ</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <header class="header">
        <div class="header-box logo-box">
            <img src="{{ asset('images/ASVZ_logo.png') }}" alt="Logo" class="logo">
        </div>
        <div class="header-box text-box">
            <div class="header-text">Dashboard</div>
        </div>
        <div class="header-box empty-box"></div> <!-- Empty box to maintain grid structure -->
    </header>

    <div class="container">
        <div class="box left-box">
            Left Box (1/3)
        </div>
        <div class="box right-box">
            Right Box (2/3)
        </div>
    </div>
</body>
</html>
