<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status de votre réservation</title>
</head>
<body>
    <h2>Bonjour {{ $reservation->client->name }}</h2>

    @if($status == 'approved')
        <p>Nous avons le plaisir de vous informer que votre réservation pour le <strong>{{ $reservation->reservation_time }}</strong> a été confirmée.</p>
    @else
        <p>Nous regrettons de vous informer que votre réservation pour le <strong>{{ $reservation->reservation_time }}</strong> a été refusée.</p>
        <p><strong>Motif du refus :</strong> {{ $reason }}</p>
    @endif

    <p>Merci de votre compréhension et à bientôt !</p>
</body>
</html>
