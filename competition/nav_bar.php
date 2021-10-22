
<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark py-0">

    <a href="javascript:void(0)" class="navbar-brand mt-1 text-light text-lg d-block d-lg-none mr-2" data-toggle="collapse" data-target="#nbcollapse">
        <span class="text-white h4"><b><i class="fas fa-code fa-1x"></i></b></span>
    </a>

    <a class="navbar-brand mr-auto ml-1" href="../index.php"><b><span class="text-success">Noobs</span><span> Codeware</span></b></a>

    <div class="collapse navbar-collapse" id="nbcollapse">
        <ul class="navbar-nav mx-auto">
            <li class="nav-item mx-3 mt-3 mt-lg-0"><a class="nav-link text-white" href="../problem"><span class="nlt"><i class="fas fa-code-branch"></i> Problem</span></a></li>
            <li class="nav-item mx-3"><a class="nav-link text-white" href="../contest"><span class="nlt"><i class="fas fa-award"></i> Compete</span></a></li>
            <li class="nav-item mx-3"><a class="nav-link text-white" href="../tutorial"><span class="nlt"><i class="fas fa-book"></i> Tutorial</span></a></li>
            <li class="nav-item mx-3"><a class="nav-link text-success" href="../status"><span class="nlt"><i class="fas fa-file-export"></i> Submission</span></a></li>
            <li class="nav-item mx-3"><a class="nav-link text-white" href="../rank.php"><span class="nlt"><i class="fas fa-list-ol"></i> Leaderboard</span></a></li>
            <li class="nav-item mx-3"><a class="nav-link text-white" href="../codeground"><span class="nlt"><i class="fas fa-cogs"></i> Compile</span></a></li>
        </ul>
    </div>

    <div class="navbar ml-auto">
        <div class="nav-item">
            <a class="navbar-brand text-white" href="javascript:void(0)" data-toggle="dropdown" onclick="rmv_not_cnt()"><span class="h4"><i class="far fa-bell"></i></span></a><span class="badge badge-notify"></span>
            <div id="noti-dropdown" class="dropdown-menu dropdown-menu-right shadow-lg bg-light noti">
                <div class="text-success mb-2 my-0 py-1 h5 text-white text-center"><b>Notifications</b></div>
                <div class="noti_content h6 mx-1">

                </div>
                <hr>
                <div class="text-center"><a href="">show all</a></div>
            </div>
        </div>

        <div class="nav-item">
            <a class="text-white" href="javascript:void(0)" data-toggle="dropdown"><img class="rounded-circle" style="width: 40px; height: 40px;" src="../uploads/user/profile_picture/<?php echo $_SESSION['Profile_Picture']; ?>" alt=""></a>
            <div class="dropdown-menu dropdown-menu-right shadow-lg" style="width: 300px; border-radius: 10px; color: rgb(25, 96, 16);">
                <div class="row p-2 justify-content-center">
                    <div class="mx-1 col-5 bg-light shadow-lg text-center"><a class="session_menu" href="../profile.php?user=<?php echo $_SESSION['Username']; ?>"><i class="far fa-user-circle fa-3x"></i><br>Profile</a></div>
                    <div class="mx-1 col-5 bg-light shadow-lg text-center"><a class="session_menu" href="../todo.php"><i class="fas fa-list-ul fa-3x"></i><br>Todo List</a></div>
                </div>
                <div class="row p-2 justify-content-center">
                    <div class="mx-1 col-5 bg-light shadow-lg text-center p-1"><a class="session_menu" href="../oj-stats/index.php?user=<?php echo $_SESSION['Username']; ?>"><i class="fas fa-wave-square fa-3x"></i></i><br>CF_UVa</a></div>
                    <?php if ($_SESSION['Role'] == 0) { ?>
                        <div class="mx-1 col-5 bg-light shadow-lg text-center p-1"><a class="session_menu" href="../user-panel"><i class="fas fa-users-cog fa-3x"></i></i><br>User Panel</a></div>
                    <?php } else { ?>
                        <div class="mx-1 col-5 bg-light shadow-lg text-center p-1"><a class="session_menu" href="../admin"><i class="fas fa-user-shield fa-3x"></i></i></i><br>Admin Panel</a></div>
                    <?php } ?>
                </div>
                <div class="text-center">
                    <a class="log_out nav-link rounded-pill" href="../logout.php"><i class="fas fa-sign-out-alt"></i> <b>Log Out</b></a>
                </div>
            </div>
        </div>
    </div>
</nav>