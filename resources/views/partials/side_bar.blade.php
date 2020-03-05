<!-- Sidebar Holder -->
<nav id="sidebar">
    <div class="sidebar-header">
        <h1>
            {{-- <a href="#">{{ config('app.name') }}</a>--}}
        </h1>
        <span>M</span>
    </div>
    <img src="{{ asset('admin/images/logo.jpg') }}" class="profile-bg img-fluid" style="width: 100%">
    <ul class="list-unstyled components">
        <li class="active">
            <a href="{{ route('admin.dashboard') }}">
                <i class="fas fa-th-large"></i>
                Tableau de bord
            </a>
        </li>
        @can('update', \App\User::class)
        {{--@can('changeOwner')--}}
        <li>
            <a href="#usersSubmenu" data-toggle="collapse" aria-expanded="false">
                <i class="fas fa-users"></i>
                Utilisateurs
                <i class="fas fa-angle-down fa-pull-right"></i>
            </a>
            <ul class="collapse list-unstyled" id="usersSubmenu">
                <li>
                    <a href="{{ route('users.index') }}">
                        <i class="fas fa-list-ul"></i>
                        Liste des utlisateurs
                    </a>
                </li>
                <li>
                    <a href="{{ route('roles.index') }}">
                        <i class="fas fa-list-ul"></i>
                        Roles
                    </a>
                </li>
            </ul>
        </li>
        {{--@endcan--}}
        @endcan
        @can('update', \App\Patient::class)
        <li>
            <a href="#patientsSubmenu" data-toggle="collapse" aria-expanded="false">
                <i class="fas fa-users"></i>
                Patients
                <i class="fas fa-angle-down fa-pull-right"></i>
            </a>
            <ul class="collapse list-unstyled" id="patientsSubmenu">
                <li>
                    <a href="{{ route('patients.index') }}">
                        <i class="fas fa-list-ul"></i>
                        Liste des patients
                    </a>
                </li>
                <!-- 
                    @can('show', \App\User::class)
                    <li>
                        <a href="{{ route('examens.index') }}">
                            <i class="fas fa-search"></i>
                            Examens medicaux
                        </a>
                    </li>
                    @endcan
                -->
                @can('anesthesiste', \App\Patient::class)
                <li>
                    <a href="{{ route('produits.anesthesiste') }}">
                        <i class="fas fa-list-ul"></i>
                        Produits anesthésiste
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        <!--
            @can('view', \App\User::class)
            <li>
                <a href="{{-- route('clients.index') --}}">
                    <i class="fas fa-list-ul"></i>
                    Clients Externes
                </a>
            </li>
            @endcan
        -->


        @endcan
        <!-- @can('create', \App\Produit::class)
        <li>
            <a href="#pageSubmenu1" data-toggle="collapse" aria-expanded="false">
                @can('print', \App\Produit::class)
                <i class="far fa-file"></i>
                Gestion des produits
                <i class="fas fa-angle-down fa-pull-right"></i>
                @endcan
            </a>
            @can('print', \App\Produit::class)
            <ul class="collapse list-unstyled" id="pageSubmenu1">
                <li>
                    <a href="{{ route('produits.index') }}">
                        <i class="fas fa-list-ul"></i>
                        Produits en stock
                    </a>
                </li>
                @endcan
                <li>
                    <a href="{{ route('produits.pharmaceutique') }}">
                        <i class="fab fa-python"></i>
                        Produits pharmaceutiques
                    </a>
                </li>
                @can('print', \App\Produit::class)
                <li>
                    <a href="{{ route('materiels.pharmaceutique') }}">
                        <i class="fas fa-cogs"></i>
                        Produit matériels
                    </a>
                </li>
                @endcan
                <li>
                    <a href="{{ route('produits.anesthesiste') }}">
                        <i class="fas fa-list-ul"></i>
                        Produits anesthésiste
                    </a>
                </li>
            </ul>
        </li>
        @endcan -->
        @can('create', \App\chambre::class)
        <li>
            <a href="{{ route('chambres.index') }}">
                <i class="fas fa-bed"></i>
                Chambres
            </a>
        </li>
        @endcan
        @can('view', \App\Event::class)
        <li>
            <a href="{{ route('events.index') }}">
                <i class="far fa-calendar-times"></i>
                Rendez-vous
            </a>
        </li>
        @endcan
        @can('create', \App\Fiche::class)
        <li>
            <a href="{{ route('fiches.index') }}">
                <i class="fas fa-list-ul"></i>
                Fiches de satisfaction
            </a>
        </li>
        @endcan
        @can('view', \App\User::class)
        <li>
            <a href="{{ route('factures.consultation') }}">
                <i class="fas fa-list-ul"></i>
                Facture
            </a>
        </li>
        @endcan

        @can('view', \App\Devi::class)
        <li>
            <a href="{{ route('devis.index') }}">
                <i class="fas fa-book"></i>
                Devis
            </a>
        </li>
        @endcan
        <br>
        <br>
        <br>
        <br>
        <br>
    </ul>
</nav>