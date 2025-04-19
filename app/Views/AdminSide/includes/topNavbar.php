<nav class="top-navbar">
    <i class='bx bx-menu' ></i>
    <form action="#">
        <div class="form-input">
            <button type="submit" class="search-btn"><i class='bx bx-submit' disabled></i></button>
        </div>
    </form>
    <label for="switch-mode" class='text'>Theme</label>
    <input type="checkbox" id="switch-mode" hidden>
    <label for="switch-mode" class="switch-mode"></label>
    
    <div class="notification-container">
        <button id="notificationBell" class="notification-bell">
            🔔 <span id="notificationCount" class="notification-count">0</span>
        </button>
        <div id="notificationDropdown" class="notification-dropdown hidden">
            <ul id="notificationList"></ul>
        </div>
    </div>

    <!--<button class="notification open-modal1">
        <i class='bx bxs-bell' ></i>
        <span class="num">8</span>
    </button>-->
</nav>
