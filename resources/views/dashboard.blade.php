<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DashBoard ASVZ</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        <div class="header-box empty-box"></div>
    </header>

    <div class="container">
        <div class="box left-box">
            <div class="messages">
                <h2>Activities</h2>
                @if ($messages->isEmpty())
                    <p>No messages found.</p>
                @else
                    <ul>
                        <li class="message-item">
                            <span class="message-text">Sondepomp:</span>
                            <span class="message-time" style="color: black;">Tijd</span>
                        </li>
                        @foreach ($messages as $message)
                            <li class="message-item">
                                <span class="message-text">{{ $message->name }}</span>
                                <span class="message-time">{{ $message->created_at->format('Y-m-d H:i') }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
        <div class="box right-box">
            <canvas id="myChart" class="ActivitiesChart"></canvas>
        </div>
    </div>

    <script>
        // Functie om gegevens op te halen
        function fetchMessages() {
            // Hier gebruik je de juiste endpoint om de data op te halen
            fetch('/chart-data') 
                .then(response => response.json())
                .then(data => {
                    // Initialiseer de Chart met de opgehaalde data
                    const ctx = document.getElementById('myChart').getContext('2d');
                    const myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: data.labels, // Data labels
                            datasets: [{
                                label: 'Messages per Day',
                                data: data.counts, // Data counts
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1,
                                hoverBackgroundColor: 'rgba(255, 99, 132, 0.2)',
                                hoverBorderColor: 'rgba(255, 159, 64, 1)',
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Number of Messages'
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Dates'
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top'
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            let label = context.dataset.label || '';
                                            if (label) {
                                                label += ': ';
                                            }
                                            label += context.parsed.y; // Laat y-waarde zien in de tooltip
                                            return label;
                                        }
                                    }
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error('Error fetching chart data:', error));
        }

        // Roep de functie op om gegevens te laden bij het laden van de pagina
        document.addEventListener('DOMContentLoaded', fetchMessages);
    </script>
</body>
</html>
