<aside>
    <nav class="sidenav">
        <ul class="links">
            <a id="myprofile" href="<?= base_url('/user/setting') ?>">
                <i class="fa-solid fa-user"></i>
                <p>My Profile</p>
            </a>

            <a id="manageOrders" href="<?= base_url('/user/manage_orders') ?>">
                <i class="fa-solid fa-box"></i>
                <p>My Orders</p>
            </a>

            <a id="myDesign" href="<?= base_url('user/myDesign') ?>">
                <i class="fa-solid fa-paint-brush"></i>
                <p>My Design</p>
            </a>
        </ul>   

        <a id="logout" href="<?= base_url('/user/logout') ?>">
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
            <p>Logout</p>
        </a>
    </nav>
</aside>
