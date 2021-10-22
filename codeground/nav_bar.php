
<?php
if (!defined('noob')) {
    exit('<h!>Invalid page request</h1>');
}
?>

<nav class="nb navbar sticky-top navbar-expand-lg navbar-dark bg-dark fub">

    <a class="navbar-brand mr-auto font-weight-bold" href="../index.php">
        <span class="text-success">Noobs</span>
        <span> Codeware</span>
    </a>

    <a href="javascript:void(0)" class="navbar-brand mt-1 text-light text-lg d-block d-lg-none mr-1" data-toggle="collapse" data-target="#nbcollapse">
        <span class="text-success h4 font-weight-bold"><i class="fas fa-code fa-1x"></i></span>
    </a>

    <div class="collapse navbar-collapse" id="nbcollapse">
        <ul class="navbar-nav mx-auto">
            <li class="nav-item ni px-2 px-lg-0 mx-lg-3">
                <a class="nav-link text-white" href="../problem"><i class="fas fa-code-branch"></i> Problem</a>
            </li>
            <li class="nav-item ni px-2 px-lg-0 mx-lg-3">
                <a class="nav-link text-white" href="../contest"><i class="fas fa-trophy"></i> Contest</a>
            </li>
            <li class="nav-item ni px-2 px-lg-0 mx-lg-3">
                <a class="nav-link text-white" href="../tutorial"><i class="fas fa-book"></i> Tutorial</a>
            </li>
            <li class="nav-item ni px-2 px-lg-0 mx-lg-3">
                <a class="nav-link text-white" href="../submission"><i class="fas fa-file-export"></i> Submission</a>
            </li>
            <li class="nav-item ni px-2 px-lg-0 mx-lg-3">
                <a class="nav-link text-white" href="../codeground"><i class="fas fa-cogs text-success"></i> Compile</a>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item">
                <button class="my-1 my-lg-0 btn btn-secondary btn-sm text-white dropdown-toggle" data-toggle="dropdown">
                    <?php echo $_SESSION['Username']; ?>
                </button>
                <div class="dropdown-menu dropdown-menu-right mr-1 shadow shadow-lg px-3 round-s">
                    <a class="dropdown-item session_menu" href="../profile.php?user=<?php echo $_SESSION['Username']; ?>"><i class="far fa-user-circle"></i> Profile</a>
                    <a class="dropdown-item session_menu" href="setting.php"><i class="fas fa-cog"></i> Setting</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item session_menu" href="../todo.php"><i class="fas fa-th-list"></i> Todo List</a>
                    <a class="dropdown-item session_menu" href="../oj-stats/index.php?user=<?php echo $_SESSION['Username']; ?>"><i class="fas fa-wave-square"></i> CF_Uva Stats</a>
                    <div class="dropdown-divider"></div>
                    <?php if ($_SESSION['Role'] == 1) { ?>
                    <a class="dropdown-item session_menu" href="../admin/index.php?id=p"><i class="fas fa-user-shield"></i> Admin Panel</a>
                    <?php } ?>
                    <a class="dropdown-item session_menu" href="../author/index.php?id=p"><i class="fas fa-users-cog"></i> Author Dashboard</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item log_out" href="../logout.php"><i class="fas fa-sign-out-alt"></i> Log out</a>
                </div>
            </li>
        </ul>
    </div>
</nav>