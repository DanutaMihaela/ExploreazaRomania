<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">
            <img src="/assets/images/cabins.jpg" class="header-logo" style="border-radius:50%">
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
                    <a class="nav-link header-menu-item justify-content-center" href="contact">
                        <span><i class="fa-solid fa-address-book fa-xl"></i></span>
                        <span class="nav-item-link">Contact</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link header-menu-item justify-content-center" data-bs-toggle="modal" data-bs-target="#loginModal">
                        <span><i class="fa-solid fa-right-to-bracket fa-xl"></i></span>
                        <span class="nav-item-link">Login</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link header-menu-item justify-content-center" data-bs-toggle="modal" data-bs-target="#registerModal">
                        <span><i class="fa-solid fa-user-plus fa-xl"></i></span>
                        <span class="nav-item-link">Register</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
@include('modals.login')
@include('modals.register')