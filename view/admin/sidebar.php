<!-- sidebar.php -->
<style>
    /* General Reset */
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        display: flex;
        background-color: #f4f6f9;
    }

    /* Sidebar */
    .sidebar {
        width: 250px;
        background-color: #ffffff;
        height: 100vh;
        position: fixed;
        box-shadow: 2px 0px 5px rgba(0, 0, 0, 0.1);
    }

    .sidebar h2 {
        text-align: center;
        padding: 20px 0;
        color: #1565c0;
    }

    .menu-item {
        display: flex;
        align-items: center;
        padding: 15px 20px;
        color: #333;
        text-decoration: none;
        font-size: 16px;
        transition: background 0.3s;
    }

    .menu-item:hover {
        background-color: #f0f0f0;
    }

    .menu-item.active {
        background-color: #1565c0;
        color: white;
    }

    .menu-item i {
        margin-right: 10px;
    }

    /* Content Area */
    .content {
        margin-left: 250px;
        padding: 20px;
        width: calc(100% - 250px);
        background-color: #f4f6f9;
    }

</style>

<div class="sidebar">
    <h2>Menu</h2>
    <a href="dashboard.php" class="menu-item <?= (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'active' : ''; ?>">
        <i class="fas fa-home"></i> Dashboard
    </a>
    <a href="addstaff.php" class="menu-item <?= (basename($_SERVER['PHP_SELF']) == 'addstaff.php') ? 'active' : ''; ?>">
        <i class="fas fa-user-plus"></i> Add Staff
    </a>
    <a href="addEquipment.php" class="menu-item <?= (basename($_SERVER['PHP_SELF']) == 'addEquipment.php') ? 'active' : ''; ?>">
        <i class="fas fa-tools"></i> Add Equipment
    </a>
    <a href="viewbooking.php" class="menu-item <?= (basename($_SERVER['PHP_SELF']) == 'viewbooking.php') ? 'active' : ''; ?>">
        <i class="fas fa-tools"></i> View Booking
    </a>

    <a href="logout.php" class="menu-item">
        <i class="fas fa-sign-out-alt"></i> Log Out
    </a>
</div>
