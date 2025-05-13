@extends('restaurant.master')
@section('restaurant')
    <div class="content-wrapper">
        <div class="tables-container">
            <!-- En-tête avec effet dégradé -->
            <div class="header-banner">
                <div class="header-content">
                    <h1 class="profile-title">Gestion des Tables</h1>
                    
                    <!-- Fil d'ariane amélioré -->
                    <div class="breadcrumb-modern">
                        <a href="{{ route('restaurant.dashboard') }}" class="breadcrumb-item">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                        <i class="fas fa-chevron-right breadcrumb-separator"></i>
                        <span class="breadcrumb-item active">Tables</span>
                    </div>
                </div>
            </div>

            <!-- Carte principale des tables avec effet d'ombre -->
            <div class="tables-card">
                <div class="tables-header">
                    <div class="tables-icon-container">
                        <div class="tables-icon-circle">
                            <i class="fas fa-utensils"></i>
                        </div>
                    </div>
                    <h2 class="tables-subtitle">Liste des Tables</h2>
                    <p class="tables-description">Gérez les tables de votre restaurant</p>
                </div>

                <div class="tables-divider"></div>
                
                <div class="tables-action">
                    <button class="btn-add" onclick="window.location.href='{{ route('restaurant.table.create') }}'">
                        <i class="fas fa-plus"></i> Ajouter une table
                    </button>
                </div>
                
                <div class="table-responsive">
                    <table class="data-table" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Numéro de table</th>
                                <th>Statut</th>
                                <th>Emplacement</th>
                                <th>Numéro d'invité</th>
                                <th>Contrôle</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (Auth::guard('restaurant')->user()->tables as $table)
                                <tr>
                                    <td>{{ $table->number }}</td>
                                    <td>
                                        <span class="status-badge {{ $table->status == 'Disponible' ? 'available' : 'unavailable' }}">
                                            {{ $table->status }}
                                        </span>
                                    </td>
                                    <td>{{ $table->location }}</td>
                                    <td>{{ $table->guest_number }}</td>
                                    <td class="actions-cell">
                                        <button type="button" class="btn-action edit" onclick="openEditModal('{{ $table->id }}')">
                                            <i class="fas fa-edit"></i> Modifier
                                        </button>
                                        <button type="button" class="btn-action delete" onclick="openDeleteModal('{{ $table->id }}')">
                                            <i class="fas fa-trash-alt"></i> Supprimer
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="card-footer">
                    <i class="fas fa-clock"></i> Dernière mise à jour: hier à 23:59
                </div>
            </div>
        </div>
    </div>

    <!-- Modals pour chaque table -->
    @foreach (Auth::guard('restaurant')->user()->tables as $table)
        <!-- Modal de modification -->
        <div class="modal" id="editModal_{{ $table->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel_{{ $table->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel_{{ $table->id }}">
                            <i class="fas fa-edit modal-icon"></i> Modifier la Table
                        </h5>
                        <button type="button" class="close" onclick="closeEditModal('{{ $table->id }}')" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="modal-description">Modification de la table numéro <strong>{{ $table->number }}</strong></p>
                        
                        <form action="{{ route('table.update') }}" method="POST" class="modal-form">
                            @csrf
                            <div class="form-group">
                                <label for="number_{{ $table->id }}">
                                    <i class="fas fa-hashtag form-icon"></i> Numéro de table
                                </label>
                                <input type="number" id="number_{{ $table->id }}" name="number" class="form-control" value="{{ $table->number }}">
                            </div>
                            
                            <div class="form-group">
                                <label for="status_{{ $table->id }}">
                                    <i class="fas fa-toggle-on form-icon"></i> Statut
                                </label>
                                <select class="form-control" id="status_{{ $table->id }}" name="status">
                                    <option value="Disponible" {{ $table->status == "Disponible" ? "selected" : "" }}>Disponible</option>
                                    <option value="Indisponible" {{ $table->status == "Indisponible" ? "selected" : "" }}>Indisponible</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="location_{{ $table->id }}">
                                    <i class="fas fa-map-marker-alt form-icon"></i> Emplacement
                                </label>
                                <select class="form-control" id="location_{{ $table->id }}" name="location">
                                    <option value="Sur la terrasse" {{ $table->location == "Sur la terrasse" ? "selected" : "" }}>Sur la terrasse</option>
                                    <option value="A l'intérieur" {{ $table->location == "A l'intérieur" ? "selected" : "" }}>A l'intérieur</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="guest_number_{{ $table->id }}">
                                    <i class="fas fa-users form-icon"></i> Nombre d'invités
                                </label>
                                <input type="number" id="guest_number_{{ $table->id }}" name="guest_number" class="form-control" value="{{ $table->guest_number }}">
                            </div>
                            
                            <input type="hidden" name="id" value="{{ $table->id }}">
                            
                            <div class="form-action modal-action">
                                <button type="button" class="btn-cancel" onclick="closeEditModal('{{ $table->id }}')">
                                    <i class="fas fa-times"></i> Annuler
                                </button>
                                <button type="submit" class="btn-save">
                                    <i class="fas fa-check"></i> Enregistrer
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal de suppression -->
        <div class="modal" id="deleteModal_{{ $table->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel_{{ $table->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header delete-header">
                        <h5 class="modal-title" id="deleteModalLabel_{{ $table->id }}">
                            <i class="fas fa-exclamation-triangle modal-icon"></i> Confirmation de suppression
                        </h5>
                        <button type="button" class="close" onclick="closeDeleteModal('{{ $table->id }}')" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="delete-message">Êtes-vous sûr de vouloir supprimer la table numéro <strong>{{ $table->number }}</strong> ?</p>
                        <p class="delete-warning">Cette action est irréversible.</p>
                        
                        <div class="form-action modal-action">
                            <button type="button" class="btn-cancel" onclick="closeDeleteModal('{{ $table->id }}')">
                                <i class="fas fa-times"></i> Annuler
                            </button>
                            <form action="{{ route('table.delete') }}" method="POST" class="delete-form">
                                @csrf
                                <input type="hidden" name="id" value="{{ $table->id }}">
                                <button type="submit" class="btn-delete">
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
            --table-header: #f1f5f9;
            --table-border: #e2e8f0;
            --table-hover: #f8fafc;
        }

        /* Styles généraux */
        .content-wrapper {
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        
        .tables-container {
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
            background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 60%);
            transform: rotate(-30deg);
        }
        
        .header-content {
            position: relative;
            z-index: 1;
        }
        
        .profile-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: white;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* Fil d'ariane amélioré */
        .breadcrumb-modern {
            display: flex;
            align-items: center;
            color: white;
            font-size: 1rem;
        }
        
        .breadcrumb-item {
            color: rgba(255,255,255,0.9);
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

        /* Carte principale des tables */
        .tables-card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 8px 20px var(--shadow-color);
            padding: 30px;
            margin-bottom: 30px;
            position: relative;
            z-index: 1;
        }
        
        .tables-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .tables-icon-container {
            margin-bottom: 15px;
        }
        
        .tables-icon-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px var(--shadow-color);
        }
        
        .tables-icon-circle i {
            font-size: 2rem;
            color: white;
        }
        
        .tables-subtitle {
            font-size: 1.6rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 5px;
        }
        
        .tables-description {
            color: #6b7280;
            font-size: 0.95rem;
        }
        
        .tables-divider {
            height: 1px;
            background: linear-gradient(to right, transparent, var(--primary-light), transparent);
            margin: 15px 0 30px;
        }

        /* Bouton d'ajout */
        .tables-action {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }
        
        .btn-add {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px 20px;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 10px var(--shadow-color);
        }
        
        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px var(--shadow-color);
            background: linear-gradient(135deg, var(--primary-hover) 0%, var(--primary-dark) 100%);
        }
        
        .btn-add i {
            margin-right: 8px;
        }

        /* Style du tableau */
        .table-responsive {
            margin-bottom: 20px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.95rem;
        }
        
        .data-table thead {
            background-color: var(--table-header);
        }
        
        .data-table th {
            color: var(--text-dark);
            font-weight: 600;
            padding: 15px;
            text-align: left;
            border-bottom: 2px solid var(--primary-light);
        }
        
        .data-table td {
            padding: 15px;
            border-bottom: 1px solid var(--table-border);
            vertical-align: middle;
        }
        
        .data-table tbody tr:hover {
            background-color: var(--table-hover);
        }
        
        /* Badges de statut */
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .status-badge.available {
            background-color: var(--primary-light);
            color: var(--primary-dark);
        }
        
        .status-badge.unavailable {
            background-color: var(--danger-light);
            color: var(--danger-dark);
        }

        /* Boutons d'action */
        .actions-cell {
            display: flex;
            gap: 10px;
        }
        
        .btn-action {
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 0.85rem;
            border: none;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .btn-action i {
            margin-right: 5px;
        }
        
        .btn-action.edit {
            background-color: var(--primary-light);
            color: var(--primary-dark);
        }
        
        .btn-action.edit:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        .btn-action.delete {
            background-color: var(--danger-light);
            color: var(--danger-dark);
        }
        
        .btn-action.delete:hover {
            background-color: var(--danger-color);
            color: white;
        }

        /* Footer de la carte */
        .card-footer {
            margin-top: 20px;
            padding-top: 15px;
            color: #6b7280;
            font-size: 0.85rem;
            border-top: 1px solid var(--table-border);
        }
        
        .card-footer i {
            margin-right: 5px;
        }

        /* Styles des modals */
        .modal {
            display: none;
            position: fixed;
            z-index: 1050;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        
        .modal-content {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            background-color: white;
            margin: 10% auto;
            width: 90%;
            max-width: 500px;
            position: relative;
            animation: modalFadeIn 0.3s ease-out;
        }
        
        @keyframes modalFadeIn {
            from {opacity: 0; transform: translateY(-30px);}
            to {opacity: 1; transform: translateY(0);}
        }
        
        .modal-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 15px 20px;
            border-bottom: none;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .modal-header.delete-header {
            background: linear-gradient(135deg, var(--danger-color) 0%, var(--danger-dark) 100%);
        }
        
        .modal-title {
            font-weight: 600;
            display: flex;
            align-items: center;
            margin: 0;
        }
        
        .modal-icon {
            margin-right: 10px;
            font-size: 1.2rem;
        }
        
        .modal-header .close {
            color: white;
            opacity: 0.8;
            text-shadow: none;
            transition: all 0.2s ease;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0;
            margin: 0;
        }
        
        .modal-header .close:hover {
            opacity: 1;
        }
        
        .modal-body {
            padding: 20px;
        }
        
        .modal-description {
            color: #6b7280;
            margin-bottom: 20px;
        }
        
        .delete-message {
            font-size: 1.1rem;
            text-align: center;
            margin-bottom: 10px;
        }
        
        .delete-warning {
            color: var(--danger-color);
            text-align: center;
            font-size: 0.9rem;
            margin-bottom: 25px;
        }
        
        /* Formulaire dans modal */
        .modal-form .form-group {
            margin-bottom: 20px;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: var(--background-light);
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px var(--primary-light);
            outline: none;
        }
        
        .form-icon {
            color: var(--primary-color);
            margin-right: 5px;
        }
        
        .modal-action {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }
        
        .btn-cancel {
            background-color: #e5e7eb;
            color: #4b5563;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
        }
        
        .btn-cancel:hover {
            background-color: #d1d5db;
        }
        
        .btn-save {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
        }
        
        .btn-save:hover {
            background: linear-gradient(135deg, var(--primary-hover) 0%, var(--primary-dark) 100%);
        }
        
        .btn-delete {
            background: linear-gradient(135deg, var(--danger-color) 0%, var(--danger-dark) 100%);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
        }
        
        .btn-delete:hover {
            background: linear-gradient(135deg, #f87171, var(--danger-dark) 100%);
        }
        
        .btn-cancel i, .btn-save i, .btn-delete i {
            margin-right: 8px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .actions-cell {
                flex-direction: column;
                gap: 5px;
            }
            
            .tables-action {
                justify-content: center;
            }
            
            .header-banner {
                padding: 20px;
            }
            
            .profile-title {
                font-size: 1.8rem;
            }
            
            .modal-content {
                width: 95%;
                margin: 15% auto;
            }
        }
    </style>

    <!-- JavaScript corrigé pour contrôler les modals -->
    <script>
        // Fonctions pour gérer les modals sans dépendre de Bootstrap
        function openEditModal(tableId) {
            document.getElementById('editModal_' + tableId).style.display = 'block';
            document.body.style.overflow = 'hidden'; // Empêche le défilement en arrière-plan
        }
        
        function closeEditModal(tableId) {
            document.getElementById('editModal_' + tableId).style.display = 'none';
            document.body.style.overflow = 'auto'; // Réactive le défilement
        }
        
        function openDeleteModal(tableId) {
            document.getElementById('deleteModal_' + tableId).style.display = 'block';
            document.body.style.overflow = 'hidden';
        }
        
        function closeDeleteModal(tableId) {
            document.getElementById('deleteModal_' + tableId).style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        // Fermer les modals si l'utilisateur clique en dehors
        window.onclick = function(event) {
            var allModals = document.getElementsByClassName('modal');
            for (var i = 0; i < allModals.length; i++) {
                if (event.target == allModals[i]) {
                    allModals[i].style.display = 'none';
                    document.body.style.overflow = 'auto';
                }
            }
        }
        
        // S'assurer que tous les modals sont fermés au chargement
        document.addEventListener('DOMContentLoaded', function() {
            var allModals = document.getElementsByClassName('modal');
            for (var i = 0; i < allModals.length; i++) {
                allModals[i].style.display = 'none';
            }
        });
    </script>
@endsection