<nav class="nav side-menu-nav flex-column">
    <li class="nav-item side-menu-nav-link">
        <a class="nav-link {{($activePage == 'dashboard') ? 'active' : ''}}" href="/host/dashboard" data-menu-link="dashboard">
            <span class="side-menu-icon"><i class="fa-solid fa-dashboard fa-lg"></i></span>
            <span class="nav-item-link">Dashboard</span>
        </a>
    </li>
    <li class="nav-item side-menu-nav-link">
        <a class="nav-link {{($activePage == 'properties') ? 'active' : ''}}" href="/host/properties" data-menu-link="properties">
            <span class="side-menu-icon"><i class="fa-solid fa-house-flag fa-lg"></i></span>
            <span class="nav-item-link">Proprietăți</span>
        </a>
    </li>
    <li class="nav-item side-menu-nav-link">
        <a class="nav-link {{($activePage == 'bookings') ? 'active' : ''}}" href="/host/bookings" data-menu-link="bookings">
            <span class="side-menu-icon"><i class="fa-solid fa-calendar-days fa-lg"></i></span>
            <span class="nav-item-link">Cereri</span>
        </a>
    </li>
    <li class="nav-item side-menu-nav-link">
        <a class="nav-link {{($activePage == 'profile') ? 'active' : ''}}" href="/host/profile" data-menu-link="profile">
            <span class="side-menu-icon"><i class="fa-solid fa-address-card fa-lg"></i></span>
            <span class="nav-item-link">Profil</span>
        </a>
    </li>
    <li class="nav-item side-menu-nav-link">
        <a class="nav-link {{($activePage == 'account') ? 'active' : ''}}" href="/host/account" data-menu-link="account">
            <span class="side-menu-icon"><i class="fa-solid fa-receipt fa-lg"></i></span>
            <span class="nav-item-link">Cont</span>
        </a>
    </li>
    <li class="nav-item side-menu-nav-link">
        <a class="nav-link" href="/logout">
            <span class="side-menu-icon"><i class="fa-solid fa-right-from-bracket fa-lg"></i></span>
            <span class="nav-item-link">Ieșire cont</span>
        </a>
    </li>
</nav>
