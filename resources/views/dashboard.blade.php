<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DashBoard ASVZ</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header class="header">
        <div class="header-box logo-box">
            <img src="{{ asset('images/ASVZ_logo.png') }}" alt="Logo" class="logo">
        </div>
        <div class="header-box text-box">
            <div class="header-text">Dashboard</div>
        </div>
        <div class="header-box logout-box">
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-link">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
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
                            <span class="message-text" style="font-weight: bold;">Sondepomp:</span>
                            <span class="message-time" style="color: black; font-weight: bold;">Tijd:</span>
                        </li>
                        @foreach ($messages as $message)
                            <li class="message-item">
                                <i class="fas fa-tools icon-space"></i>
                                <span class="message-text">{{ $message->name }}</span>
                                <!-- Pass the date in ISO format to JavaScript as a data attribute -->
                                <span class="message-time" data-date="{{ $message->created_at }}">{{ $message->created_at->format('Y-m-d H:i') }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
        <div class="box right-box">
            <canvas id="myChart" class="ActivitiesChart" width="80" height="40"></canvas>
            <div class="button-container"> <!-- Container for the buttons -->
                <button id="prevWeekBtn">Previous Week</button>
                <button id="nextWeekBtn">Next Week</button>
            </div>
        </div>
    </div>

    <script>
        let weekShift = 0; // Variabele om de week te verschuiven
        let myChart; // Variabele om de chart instance op te slaan

        // Functie om gegevens op te halen
        function fetchMessages() {
            fetch(`/chart-data?weekShift=${weekShift}`) // Haal gegevens op van de route /chart-data 
                .then(response => response.json()) // Zet de response om naar JSON format
                .then(data => { // Gebruik de data om een grafiek te maken
                    const ctx = document.getElementById('myChart').getContext('2d'); // Selecteer de canvas om de grafiek in te tekenen
                    
                    // Als er al een chart bestaat, vernietig deze
                    if (myChart) {
                        myChart.destroy(); // Vernietig de bestaande chart
                    }

                    // Maak een nieuwe Chart
                    myChart = new Chart(ctx, { // Maak een nieuwe Chart
                        type: 'bar', // Type grafiek
                        data: { // Data voor de grafiek
                            labels: data.labels, // Data labels
                            datasets: [{ 
                                label: 'Messages per Day', // Legenda
                                data: data.counts, // Data waarden
                                backgroundColor: '#b0cc0c',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1,
                                hoverBackgroundColor: '#def758',
                                hoverBorderColor: 'rgba(255, 159, 64, 1)',
                            }]
                        },
                        options: { // Opties voor de grafiek
                            scales: { // Schalen
                                y: { // Y-as
                                    beginAtZero: true, // Begin bij 0
                                    title: { 
                                        display: true, 
                                        text: 'Number of Messages' 
                                    }
                                },
                                x: { // X-as
                                    title: {
                                        display: true,
                                        text: 'Dates'
                                    }
                                }
                            },
                            plugins: {
                                legend: { // Legenda instellingen
                                    display: true,
                                    position: 'top'
                                },
                                tooltip: {
                                    callbacks: { // Tooltip instellingen
                                        label: function(context) { // Functie om de tooltip te tonen
                                            let label = context.dataset.label || ''; // Laat legenda zien in de tooltip
                                            if (label) { // Als er een legenda is
                                                label += ': '; // Voeg dubbele punt toe
                                            }
                                            label += context.parsed.y; // Laat y-waarde zien in de tooltip
                                            return label; // Geef de tooltip terug
                                        }
                                    }
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error('Error fetching chart data:', error)); // Toon een error als het ophalen van gegevens mislukt
            }

            // Event listeners voor de knoppen
            document.getElementById('prevWeekBtn').addEventListener('click', function() {
                weekShift -= 1; // Verschuif de week naar vorige week
                fetchMessages(); // Haal de gegevens opnieuw op
            });

            document.getElementById('nextWeekBtn').addEventListener('click', function() {
                weekShift += 1; // Verschuif de week naar volgende week
                fetchMessages(); // Haal de gegevens opnieuw op
            });

            // Roep de functie op om gegevens te laden bij het laden van de pagina
            document.addEventListener('DOMContentLoaded', fetchMessages); 

            document.addEventListener('DOMContentLoaded', () => {
                // Selecteer alle elementen met de 'data-date' attribuut
                const dateElements = document.querySelectorAll('.message-time[data-date]');
                
                dateElements.forEach(element => {
                    // Haal de ruwe datum op uit het data attribuut
                    const date = new Date(element.getAttribute('data-date'));
                    
                    // Formatteer de datum in het Nederlands
                    const formattedDate = date.toLocaleString('nl-NL', {
                        weekday: 'short', 
                        month: 'short', 
                        day: 'numeric', 
                        hour: '2-digit', 
                        minute: '2-digit'
                    });

                    // Update de tekstinhoud van het element met de geformatteerde datum
                    element.textContent = formattedDate;
                });
            });
    </script>
</body>
</html>
