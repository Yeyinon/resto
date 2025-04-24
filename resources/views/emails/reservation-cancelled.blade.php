<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Statut de votre réservation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            padding: 40px;
            margin: 0;
        }

        .container {
            background-color: #ffffff;
            max-width: 600px;
            margin: 0 auto;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .header {
            background-color: #e74c3c;
            padding: 30px;
            text-align: center;
            color: white;
        }

        .header img {
            height: 60px;
            margin-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .content {
            padding: 30px;
        }

        .content h2 {
            color: #333;
        }

        .content p {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
        }

        .footer {
            text-align: center;
            padding: 20px;
            font-size: 14px;
            color: #999;
            background-color: #f0f0f0;
        }

        .badge {
            display: inline-block;
            padding: 10px 20px;
            color: white;
            border-radius: 20px;
            font-weight: bold;
            margin: 20px 0;
        }

        .badge-cancelled {
            background-color: #e74c3c;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
        <img src="https://i.postimg.cc/J0GydpJR/resto.png" alt="Logo Mon Resto" style="height: 60px; margin-bottom: 10px;">
            <h1>Réservation Annulée</h1>
        </div>

        <div class="content">
            <h2>Bonjour {{ $reservation->table->restaurant->name ?? 'Cher restaurateur' }},</h2>

            <p>Nous vous informons que la réservation du client <strong>{{ $reservation->client->name }}</strong> prévue le <strong>{{ $formattedDate }}</strong> a été annulée.</p>

            <div class="badge badge-cancelled">Réservation Annulée ❌</div>

            <p>Merci de mettre à jour vos disponibilités en conséquence.</p>

            <p>Merci et à bientôt chez <strong>{{ $reservation->table->restaurant->name }}</strong> !</p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Resto. Tous droits réservés.
        </div>
    </div>

</body>
</html>
