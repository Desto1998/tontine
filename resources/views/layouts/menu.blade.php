<!-- need to remove -->

<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link {{ Route::is('home') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Tableau de bord</p>
    </a>
</li>
<li class="nav-header">COTISATION ET CAISSE</li>
<li class="nav-item">
    <a href="{{ route('meeting.index') }}" class="nav-link">
        <i class="nav-icon fa fa-store"></i>
        <p>
            Séances
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('meeting.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Gestions des Séances</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('meeting.create') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Ajouter une Séance</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('loan.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Gestion des prèts</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fa fa-plus-square"></i>
        <p>
            Sessions
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('sessions.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Gestion des sessions</p>
            </a>
        </li>
{{--        <li class="nav-item">--}}
{{--            <a href="{{ route('') }}" class="nav-link">--}}
{{--                <i class="far fa-circle nav-icon"></i>--}}
{{--                <p>Ajouter une session</p>--}}
{{--            </a>--}}
{{--        </li>--}}
    </ul>
</li>
<li class="nav-item">
    <a href="{{ route('contribution.index') }}" class="nav-link">
        <i class="nav-icon fa fa-handshake"></i>
        <p>
            Cotisations
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('contribution.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Cotisations</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('sanction.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Sansions</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item">
    <a href="" class="nav-link">
        <i class="nav-icon fa fa-dollar-sign"></i>
        <p>
            Caisses
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('fund.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Fonds</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Caisse</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-header">RESOURCES</li>
<li class="nav-item">
    <a href="{{ route('members.index') }}" class="nav-link">
        <i class="nav-icon fas fa-users"></i>
        <p>Membres</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('association.detail') }}" class="nav-link">
        <i class="nav-icon fas fa-house-user"></i>
        <p>Mon association</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('admin.associations.index') }}" class="nav-link">
        <i class="nav-icon fa fa-house-user"></i>
        <p>
            Associations
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('admin.associations.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Associations</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('members.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Membres</p>
            </a>
        </li>
    </ul>
</li>
@if(\App\Models\UserRole::checkRole('Administrateur') || \App\Models\UserPermission::checkPermission('user-list') || Auth::user()->is_admin)
    <li class="nav-header">APPLICATION</li>

    <li class="nav-item">
        <a href="{{ route('admin.user.all') }}" class="nav-link">
            <i class="nav-icon fa fa-users"></i>
            <p>
                Utilisateurs
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('admin.user.all') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Gestion des utilisateurs</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.user.create') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Ajouter un utilisateur</p>
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.logs.all') }}" class="nav-link">
            <i class="nav-icon fa fa-cogs"></i>
            <p>
                System
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('admin.logs.all') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Journal</p>
                </a>
            </li>
            <li class="nav-item" title="En vidant le cache vous rendez l'application plus rapide">
                <a href="{{ route('app.clear') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Vider le cache</p>
                </a>
            </li>
        </ul>
    </li>
@endif
<!-- Sidebar user (optional) -->
<div class="user-panel mt-3 pb-3 mb-3 d-flex">
    {{--            @if (\Illuminate\Support\Facades\Auth::user()->profilePicturePath)--}}
    <div class="image">
        <img src="{{ !empty($user->profilePicturePath) ? asset('images/profil/' . $user->profilePicturePath) : asset('images/profil/user_img.jpg') }}" class="img-circle elevation-2" alt="{{ trans('messages.user_image') }}">
    </div>
    {{--            @endif--}}
    <div class="info">
        <a href="{{ route('user.profile', Auth::id()) }}" class="d-block">{{ \Illuminate\Support\Facades\Auth::user()->first_name }} {{ \Illuminate\Support\Facades\Auth::user()->first_name }}</a>
    </div>
</div>
