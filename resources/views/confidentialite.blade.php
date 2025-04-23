@extends('client.master')

@section('client')
<title>Resto- Confidentialité</title>
<div class="container py-5">
    <div class="bg-white shadow rounded p-4 md:p-6">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6">Clause de Confidentialité – Resto.com</h1>

        <section class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-700 mb-2">1. Collecte des données personnelles</h2>
            <p class="text-sm md:text-base text-gray-600">
                Lors de votre utilisation de notre application, nous collectons plusieurs types de données personnelles :
            </p>
            <ul class="list-disc list-inside text-sm md:text-base text-gray-600 mt-2">
                <li>Données d'identification : nom, prénom, e-mail, numéro de téléphone, photo de profil (facultative).</li>
                <li>Informations de connexion : adresse IP, type de navigateur, système d’exploitation, appareil utilisé.</li>
                <li>Données de réservation et de commande : restaurants visités, horaires, plats commandés, commentaires.</li>
                <li>Informations de paiement (via des services tiers sécurisés).</li>
                <li>Données de localisation (avec votre autorisation explicite).</li>
            </ul>
        </section>

        <section class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-700 mb-2">2. Utilisation des données collectées</h2>
            <p class="text-sm md:text-base text-gray-600">
                Ces données sont utilisées pour :
            </p>
            <ul class="list-disc list-inside text-sm md:text-base text-gray-600 mt-2">
                <li>Permettre la gestion et le suivi de vos réservations ou commandes.</li>
                <li>Offrir une expérience personnalisée en fonction de vos préférences.</li>
                <li>Assurer la sécurité, la détection de fraude et le bon fonctionnement de la plateforme.</li>
                <li>Analyser l’utilisation de nos services pour améliorer l’ergonomie et les fonctionnalités.</li>
                <li>Vous envoyer des notifications pertinentes (avec votre consentement).</li>
            </ul>
        </section>

        <section class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-700 mb-2">3. Conservation des données</h2>
            <p class="text-sm md:text-base text-gray-600">
                Vos données sont conservées pendant une durée strictement nécessaire à la finalité de leur traitement. Cela peut varier selon les obligations légales, contractuelles ou fiscales. Les données inactives sont archivées puis supprimées après un délai raisonnable.
            </p>
        </section>

        <section class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-700 mb-2">4. Partage des données</h2>
            <p class="text-sm md:text-base text-gray-600">
                Resto.com ne vend pas vos données. Toutefois, nous pouvons les partager avec :
            </p>
            <ul class="list-disc list-inside text-sm md:text-base text-gray-600 mt-2">
                <li>Nos prestataires techniques (hébergeurs, services de paiement).</li>
                <li>Les restaurants partenaires uniquement pour la gestion des commandes.</li>
                <li>Les autorités compétentes si la loi l'exige.</li>
            </ul>
        </section>

        <section class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-700 mb-2">5. Droits des utilisateurs</h2>
            <p class="text-sm md:text-base text-gray-600">
                Vous avez, à tout moment, le droit :
            </p>
            <ul class="list-disc list-inside text-sm md:text-base text-gray-600 mt-2">
                <li>D’accéder à vos données personnelles.</li>
                <li>De les rectifier, les supprimer ou les limiter.</li>
                <li>De vous opposer à leur traitement.</li>
                <li>De demander leur portabilité.</li>
            </ul>
            <p class="text-sm md:text-base text-gray-600 mt-2">
                Pour exercer ces droits : <a href="mailto:restorant.application@gmail.com" class="text-blue-600 underline">restorant.application@gmail.com</a>
            </p>
        </section>

        <section class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-700 mb-2">6. Sécurité des données</h2>
            <p class="text-sm md:text-base text-gray-600">
                Nous mettons en œuvre des mesures de sécurité conformes aux standards du marché : chiffrement des données, pare-feu, accès restreint, audit régulier. Néanmoins, aucun système n’est inviolable, nous vous encourageons à choisir des mots de passe forts et à rester vigilants.
            </p>
        </section>

        <section class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-700 mb-2">7. Cookies & traceurs</h2>
            <p class="text-sm md:text-base text-gray-600">
                Nous utilisons des cookies pour améliorer votre expérience utilisateur, analyser notre trafic et proposer des contenus personnalisés. Vous pouvez les gérer via les paramètres de votre navigateur ou via notre bannière de consentement.
            </p>
        </section>

        <section class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-700 mb-2">8. Transfert hors de l’Union Européenne</h2>
            <p class="text-sm md:text-base text-gray-600">
                Dans certains cas, vos données peuvent être transférées hors de l’UE (ex : services cloud). Dans ce cas, nous nous assurons que le pays offre un niveau de protection adéquat ou nous utilisons des clauses contractuelles types validées par la Commission européenne.
            </p>
        </section>

        <section class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-700 mb-2">9. Modifications de la politique</h2>
            <p class="text-sm md:text-base text-gray-600">
                Cette politique peut évoluer. Toute modification majeure sera signalée sur la plateforme. Date de dernière mise à jour : {{ date('d/m/Y') }}.
            </p>
        </section>

        <section class="mb-6 border-t border-gray-200 pt-4">
            <h2 class="text-xl font-bold text-gray-800 mb-2">10. Conditions spécifiques aux restaurants partenaires</h2>
            <p class="text-sm md:text-base text-gray-600">
                En rejoignant notre plateforme, les restaurants acceptent d'être visibles auprès des clients via notre système de réservation et de commande en ligne. Les données des clients leur sont transmises uniquement dans le cadre des commandes passées dans leur établissement.
            </p>
            <p class="text-sm md:text-base text-gray-600 mt-2">
                En outre, Resto.com se réserve le droit de prélever automatiquement un pourcentage sur chaque commande client effectuée via la plateforme. Ce montant est prélevé à la source et ne nécessite aucune intervention du restaurant. Le pourcentage est défini dans le contrat de partenariat signé lors de l’inscription.
            </p>
        </section>

    </div>
</div>
@endsection
