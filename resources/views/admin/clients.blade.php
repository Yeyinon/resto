@extends('admin.master')
@section('admin')
    <div class="content-wrapper">
        <div class="data-container">
            <!-- En-tête avec effet dégradé -->
            <div class="header-banner">
                <div class="header-content">
                    <h1 class="page-title">Clients</h1>

                    <!-- Fil d'ariane amélioré -->
                    <div class="breadcrumb-modern">
                        <a href="#" class="breadcrumb-item">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                        <i class="fas fa-chevron-right breadcrumb-separator"></i>
                        <span class="breadcrumb-item active">Clients</span>
                    </div>
                </div>
            </div>

            <!-- Carte principale avec effet d'ombre -->
            <div class="data-card">
                <div class="data-header">
                    <div class="header-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="header-text">
                        <h2 class="card-title">Liste des clients</h2>
                        <p class="card-description">Gérez les informations des clients inscrits</p>
                    </div>
                </div>

                <div class="card-divider"></div>

                <div class="table-container">
                    <table class="modern-table" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Yums</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                                <tr>
                                    <td>{{ $client->id }}</td>
                                    <td>{{ $client->name }}</td>
                                    <td>
                                        <div class="yums-badge">
                                            <i class="fas fa-gift"></i> {{ $client->yums }}
                                        </div>
                                    </td>
                                    <td>{{ $client->email }}</td>
                                    <td class="actions-cell">
                                        <button type="button" class="btn-action btn-edit"
                                            onclick="openDetailsModal('{{ $client->id }}')">
                                            <i class="fas fa-edit"></i> Modifier
                                        </button>
                                        <button type="button" class="btn-action btn-delete"
                                            onclick="openDeleteModal('{{ $client->id }}')">
                                            <i class="fas fa-trash-alt"></i> Supprimer
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="card-footer">
                    <div class="update-info">
                        <i class="fas fa-clock"></i> Mis à jour hier à 23:59
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals pour chaque client -->
    @foreach ($clients as $client)
        <!-- Modal Détails -->
        <div class="modal" id="detailsModal_{{ $client->id }}" tabindex="-1" role="dialog"
            aria-labelledby="detailsModalLabel_{{ $client->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modern-modal">
                    <div class="modal-header">
                        <div class="modal-title-container">
                            <div class="modal-icon">
                                <i class="fas fa-user-edit"></i>
                            </div>
                            <h5 class="modal-title" id="detailsModalLabel_{{ $client->id }}">Détails du client</h5>
                        </div>
                        <button class="close" type="button" onclick="closeDetailsModal('{{ $client->id }}')" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="modal-subtitle">Informations sur <strong>{{ $client->name }}</strong></p>

                        <form action="{{ route('client.update') }}" method="POST" class="modern-form">
                            @csrf
                            <input type="hidden" name="id" value="{{ $client->id }}">

                            <div class="form-group">
                                <label for="name_{{ $client->id }}">
                                    <i class="fas fa-signature form-icon"></i> Nom du client
                                </label>
                                <input type="text" id="name_{{ $client->id }}" name="name" class="form-control"
                                    value="{{ $client->name }}">
                            </div>

                            <div class="form-group">
                                <label for="email_{{ $client->id }}">
                                    <i class="fas fa-envelope form-icon"></i> Email du client
                                </label>
                                <input type="email" id="email_{{ $client->id }}" name="email" class="form-control"
                                    value="{{ $client->email }}">
                            </div>

                            <div class="form-group">
                                <label for="yums_{{ $client->id }}">
                                    <i class="fas fa-gift form-icon"></i> Yums
                                </label>
                                <div class="input-with-icon">
                                    <input type="number" id="yums_{{ $client->id }}" name="yums" class="form-control"
                                        value="{{ $client->yums }}">
                                    <div class="input-icon-right">
                                        <i class="fas fa-tags"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="form-action modal-action">
                                <button type="button" class="btn-cancel" onclick="closeDetailsModal('{{ $client->id }}')">
                                    <i class="fas fa-times"></i> Annuler
                                </button>
                                <button type="submit" class="btn-save">
                                    <i class="fas fa-save"></i> Enregistrer
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Suppression -->
        <div class="modal" id="deleteModal_{{ $client->id }}" tabindex="-1" role="dialog"
            aria-labelledby="deleteModalLabel_{{ $client->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modern-modal">
                    <div class="modal-header delete-header">
                        <div class="modal-title-container">
                            <div class="modal-icon delete-icon">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <h5 class="modal-title" id="deleteModalLabel_{{ $client->id }}">Supprimer client</h5>
                        </div>
                        <button class="close" type="button" onclick="closeDeleteModal('{{ $client->id }}')" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="delete-message">Êtes-vous sûr de vouloir supprimer le client
                            <strong>{{ $client->name }}</strong> ? Cette action est irréversible.
                        </p>

                        <div class="form-action modal-action">
                            <button type="button" class="btn-cancel" onclick="closeDeleteModal('{{ $client->id }}')">
                                <i class="fas fa-times"></i> Annuler
                            </button>
                            <form action="{{ route('client.delete') }}" method="POST" class="delete-form">
                                @csrf
                                <input type="hidden" name="id" value="{{ $client->id }}">
                                <button type="submit" class="btn-delete-confirm">
                                    <i class="fas fa-trash-alt"></i> Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <style>
        /* Variables pour les couleurs */
        :root {
            --primary-color: #10b981;
            --primary-dark: #065f46;
            --primary-light: #d1fae5;
            --primary-hover: #059669;
            --text-dark: #064e3b;
            --text-light: #f0fdfa;
            --border-color: #99f6e4;
            --background-light: #f8fffc;
            --shadow-color: rgba(16, 185, 129, 0.15);
            --danger-color: #ef4444;
            --danger-dark: #b91c1c;
            --danger-light: #fee2e2;
            --warning-color: #f59e0b;
            --warning-dark: #b45309;
            --warning-light: #fef3c7;
        }

        /* Styles généraux */
        .content-wrapper {
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }

        .data-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Style de l'en-tête avec dégradé */
        .header-banner {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px var(--shadow-color);
            position: relative;
            overflow: hidden;
        }

        .header-banner::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, transparent 60%);
            transform: rotate(-30deg);
        }

        .header-content {
            position: relative;
            z-index: 1;
        }

        .page-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: white;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Fil d'ariane amélioré */
        .breadcrumb-modern {
            display: flex;
            align-items: center;
            color: white;
            font-size: 1rem;
        }

        .breadcrumb-item {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.2s ease;
        }

        .breadcrumb-item:hover {
            color: white;
            text-decoration: none;
        }

        .breadcrumb-item.active {
            font-weight: 600;
            color: white;
        }

        .breadcrumb-separator {
            margin: 0 12px;
            font-size: 0.8rem;
            opacity: 0.8;
        }

        /* Carte principale */
        .data-card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 8px 20px var(--shadow-color);
            overflow: hidden;
            margin-bottom: 30px;
            position: relative;
            z-index: 1;
        }

        .data-header {
            padding: 25px 30px;
            display: flex;
            align-items: center;
        }

        .header-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            box-shadow: 0 4px 10px var(--shadow-color);
        }

        .header-icon i {
            font-size: 1.5rem;
            color: white;
        }

        .header-text {
            flex: 1;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 5px;
        }

        .card-description {
            color: #6b7280;
            font-size: 0.95rem;
            margin: 0;
        }

        .card-divider {
            height: 1px;
            background: linear-gradient(to right, var(--primary-light), transparent);
        }

        /* Table moderne */
        .table-container {
            padding: 15px 30px;
            overflow-x: auto;
        }

        .modern-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 0;
        }

        .modern-table thead th {
            background-color: #f9fafb;
            color: var(--text-dark);
            font-weight: 600;
            padding: 15px;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #f3f4f6;
            text-align: left;
        }

        .modern-table tbody tr {
            transition: all 0.2s ease;
        }

        .modern-table tbody tr:hover {
            background-color: var(--background-light);
        }

        .modern-table tbody td {
            padding: 15px;
            border-bottom: 1px solid #f3f4f6;
            color: #4b5563;
            vertical-align: middle;
        }

        /* Badge pour les yums */
        .yums-badge {
            display: inline-flex;
            align-items: center;
            background-color: var(--primary-light);
            color: var(--primary-dark);
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.85rem;
        }

        .yums-badge i {
            margin-right: 5px;
            font-size: 0.8rem;
        }

        /* Cellule d'actions */
        .actions-cell {
            display: flex;
            gap: 8px;
        }

        .btn-action {
            border: none;
            border-radius: 6px;
            padding: 8px 12px;
            font-size: 0.85rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-action i {
            margin-right: 5px;
            font-size: 0.85rem;
        }

        .btn-edit {
            background-color: var(--primary-light);
            color: var(--primary-dark);
        }

        .btn-edit:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-delete {
            background-color: var(--danger-light);
            color: var(--danger-dark);
        }

        .btn-delete:hover {
            background-color: var(--danger-color);
            color: white;
        }

        /* Pied de carte */
        .card-footer {
            padding: 15px 30px;
            background-color: #f9fafb;
            border-top: 1px solid #f3f4f6;
        }

        .update-info {
            color: #6b7280;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
        }

        .update-info i {
            margin-right: 8px;
        }

        /* Modification du style des modals */
        .modal {
            display: none;
            position: fixed;
            z-index: 1050;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            /* Supprimer ou modifier cette ligne qui crée le fond noir/sombre */
            background-color: transparent;
            /* Était rgba(0, 0, 0, 0.4) */
            align-items: center;
            justify-content: center;
        }

        /* Ajustements pour que les modals restent visibles sans le fond sombre */
        .modal-dialog {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 90%;
            max-width: 500px;
            margin: 0;
            /* Ajout d'une ombre plus prononcée pour compenser l'absence de fond sombre */
            filter: drop-shadow(0 0 20px rgba(0, 0, 0, 0.2));
        }

        /* Amélioration de la visibilité des modals sans le fond sombre */
        .modal-content {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            background-color: white;
            animation: modalFadeIn 0.3s ease-out;
            position: relative;
            width: 100%;
            border: 1px solid rgba(0, 0, 0, 0.1);
            /* Ajout d'une légère bordure */
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 20px 25px;
            border-bottom: none;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .delete-header {
            background: linear-gradient(135deg, var(--danger-color) 0%, var(--danger-dark) 100%);
        }

        .modal-title-container {
            display: flex;
            align-items: center;
        }

        .modal-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }

        .modal-icon i {
            color: white;
            font-size: 1.2rem;
        }

        .delete-icon {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .modal-title {
            font-weight: 600;
            margin: 0;
            font-size: 1.25rem;
        }

        .modal-body {
            padding: 25px;
        }

        .modal-subtitle {
            color: #6b7280;
            margin-bottom: 20px;
            font-size: 0.95rem;
        }

        .delete-message {
            font-size: 1rem;
            color: #4b5563;
            text-align: center;
            margin: 10px 0 20px;
        }

        .modal-action {
            border-top: 1px solid #f3f4f6;
            padding-top: 20px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        /* Version pour mobile avec dimensions ajustées */
        @media (max-width: 768px) {
            .modal-dialog {
                width: 95%;
                max-width: 450px;
            }
        }

        /* Formulaire dans modal */
        .modern-form .form-group {
            margin-bottom: 20px;
        }

        .modern-form label {
            display: block;
            color: var(--text-dark);
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .form-icon {
            color: var(--primary-color);
            margin-right: 5px;
        }

        .modern-form .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: var(--background-light);
        }

        .modern-form .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px var(--primary-light);
            outline: none;
        }

        .input-with-icon {
            position: relative;
        }

        .input-with-icon .form-control {
            padding-right: 40px;
        }

        .input-icon-right {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-color);
        }

        /* Boutons du modal */
        .btn-cancel {
            background-color: #f3f4f6;
            color: #4b5563;
            border: none;
            border-radius: 8px;
            padding: 10px 16px;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
        }

        .btn-cancel:hover {
            background-color: #e5e7eb;
        }

        .btn-cancel i {
            margin-right: 8px;
        }

        .btn-save {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 16px;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px var(--shadow-color);
        }

        .btn-save i {
            margin-right: 8px;
        }

        .btn-delete-confirm {
            background: linear-gradient(135deg, var(--danger-color) 0%, var(--danger-dark) 100%);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 16px;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
        }

        .btn-delete-confirm:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(239, 68, 68, 0.25);
        }

        .btn-delete-confirm i {
            margin-right: 8px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .data-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .header-icon {
                margin-bottom: 15px;
            }

            .actions-cell {
                flex-direction: column;
                gap: 5px;
            }

            .btn-action {
                width: 100%;
                justify-content: center;
            }

            .modal-dialog {
                margin: 0.5rem;
                width: 95%;
            }
        }
    </style>

    <!-- JavaScript pour contrôler les modals -->
    <script>
        // Fonctions pour gérer les modals sans dépendre de Bootstrap
        function openDetailsModal(clientId) {
            document.getElementById('detailsModal_' + clientId).style.display = 'block';
            document.body.style.overflow = 'hidden'; // Empêche le défilement en arrière-plan
        }

        function closeDetailsModal(clientId) {
            document.getElementById('detailsModal_' + clientId).style.display = 'none';
            document.body.style.overflow = 'auto'; // Réactive le défilement
        }

        function openDeleteModal(clientId) {
            document.getElementById('deleteModal_' + clientId).style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal(clientId) {
            document.getElementById('deleteModal_' + clientId).style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Fermer les modals si l'utilisateur clique en dehors
        window.onclick = function (event) {
            var modals = document.getElementsByClassName('modal');
            for (var i = 0; i < modals.length; i++) {
                if (event.target == modals[i]) {
                    modals[i].style.display = 'none';
                    document.body.style.overflow = 'auto';
                }
            }
        }

        // S'assurer que tous les modals sont fermés au chargement
        document.addEventListener('DOMContentLoaded', function () {
            var modals = document.getElementsByClassName('modal');
            for (var i = 0; i < modals.length; i++) {
                modals[i].style.display = 'none';
            }
        });
    </script>
@endsection