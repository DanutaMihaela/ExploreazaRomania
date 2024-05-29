<nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="/">
        <img src="/assets/images/cabins.jpg" class="header-logo">
    </a>
    <button class="navbar-toggler px-2 py-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false"><i class="fa-solid fa-bars fa-xl"></i></button>
    <div class="collapse navbar-collapse justify-content-end text-center" id="navbarToggler">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link header-menu-item justify-content-center text-center" href="/">
                    <span><i class="fa-solid fa-house fa-xl"></i></span>
                    <span class="nav-item-link">Acasă</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link header-menu-item justify-content-center" href="{{'/' . $userType . '/dashboard'}}">
                    <span><i class="fa-solid fa-user fa-xl"></i></span>
                    <span class="nav-item-link">{{$user->firstName}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link header-menu-item justify-content-center" href="../logout">
                    <span><i class="fa-solid fa-right-from-bracket fa-xl"></i></span>
                    <span class="nav-item-link">LogOut</span>
                </a>
            </li>
        </ul>
    </div>
</nav>