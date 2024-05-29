<nav class="nav side-menu-nav flex-column">
    <li class="nav-item side-menu-nav-link">
        <a class="nav-link {{($activePage == 'dashboard') ? 'active' : ''}}" href="/tourist/dashboard" data-menu-link="dashboard">
            <span class="side-menu-icon"><i class="fa-solid fa-gauge fa-lg
                "></i></span>
            <span class="nav-item-link">Dashboard</span>
        </a>
    </li>
    <li class="nav-item side-menu-nav-link">
        <a class="nav-link {{($activePage == 'bookings') ? 'active' : ''}}" href="/tourist/bookings" data-menu-link="bookings">
            <span class="side-menu-icon"><i class="fa-solid fa-book fa-lg"></i></span>
            <span class="nav-item-link">Sejururi</span>
        </a>
    </li>
    <li class="nav-item side-menu-nav-link">
        <a class="nav-link {{($activePage == 'favourites') ? 'active' : ''}}" href="/tourist/favourites" data-menu-link="favourites">
            <span class="side-menu-icon"><i class="fa-solid fa-heart fa-lg"></i></span>
            <span class="nav-item-link">Preferate</span>
        </a>
    </li>
    <li class="nav-item side-menu-nav-link">
        <a class="nav-link {{($activePage == 'searches') ? 'active' : ''}}" href="/tourist/searches" data-menu-link="searches">
            <span class="side-menu-icon"><i class="fa-solid fa-magnifying-glass fa-lg"></i></span>
            <span class="nav-item-link">Căutari recente</span>
        </a>
    </li>
    <li class="nav-item side-menu-nav-link">
        <a class="nav-link {{($activePage == 'reviews') ? 'active' : ''}}" href="/tourist/reviews" data-menu-link="reviews">
            <span class="side-menu-icon"><i class="fa-solid fa-thumbs-up fa-lg"></i></span>
            <span class="nav-item-link">Review-uri</span>
        </a>
    </li>
    <li class="nav-item side-menu-nav-link">
        <a class="nav-link {{($activePage == 'profile') ? 'active' : ''}}" href="/tourist/profile" data-menu-link="profile">
            <span class="side-menu-icon"><i class="fa-solid fa-address-card fa-lg"></i></span>
            <span class="nav-item-link">Profil</span>
        </a>
    </li>
    <li class="nav-item side-menu-nav-link">
        <a class="nav-link" href="/logout">
            <span class="side-menu-icon"><i class="fa-solid fa-right-from-bracket fa-lg"></i></span>
            <span class="nav-item-link">Ieșire cont</span>
        </a>
    </li>
</nav>
