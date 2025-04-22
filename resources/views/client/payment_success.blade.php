@extends('client.master')

@section('client')
<div class="container py-5 text-center">
    <h1 class="text-success mb-3">✅ Paiement réussi !</h1>
    <p>Merci pour votre commande.</p>
    <a href="{{ route('home') }}" class="btn btn-primary mt-3">Retour à l’accueil</a>
</div>
@endsection
