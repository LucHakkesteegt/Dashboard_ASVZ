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
            <div class="messages">
                <h2>Actions</h2>
                @if ($messages->isEmpty())
                    <p>No messages found.</p>
                @else
                    <ul>
                        @foreach ($messages as $message)
                            <li class="message-item">
                                <span class="message-text">{{ $message->name }}</span>
                                <span class="message-time">{{ $message->created_at->format('Y-m-d H:i') }}</span> <!-- Format as desired -->
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
        <div class="box right-box">
            Right Box (2/3)
        </div>
    </div>
</body>
</html>
