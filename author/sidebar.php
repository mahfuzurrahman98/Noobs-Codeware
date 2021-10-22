<section class="bg-primary sticky-top">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark navbar-offcanvas">

        <a href="javascript:void(0)" id="navToggle">
            <span class="text-white h4"><b><i class="fas fa-code fa-1x"></i></b></span>
        </a>
        <a class="navbar-brand mx-auto" href="index.php">
            <span class="text-white"><b><span class="text-success">Admin </span>Panel</b></span>
        </a>

        <div class="navbar-collapse offcanvas-collapse">
            <ul class="navbar-nav ml-3 mr-auto mb-5">
                <li class="nav-item mt-3"><a class="nav-link text-white" href="index.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="../index.php">Homepage</a></li>
                <li><hr color=white></li>

                <li class="nav-item mt-3"><a class="nav-link text-white" href="problem/add.php">Set Problem</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="problem/index.php">Manage Problems</a></li>
                <li><hr color=white></li>

                <li class="nav-item mt-3"><a class="nav-link text-white" href="contest/add.php">Contest Section</a></li>
                <li><hr color=white></li>

                <li class="nav-item mt-3"><a class="nav-link text-white" href="tutorial/add.php">Publish Tutorial</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="tutorial/index.php">Manage Tutorials</a></li>
                <li><hr color=white></li>

                <li class="nav-item mt-3"><a class="nav-link text-white" href="announcement/add.php">Post Announcement</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="announcement/index.php">Manage Announcements</a></li>
                <li><hr color=white></li>

                <li class="nav-item mt-5">                
                    <a class="navbar-brand mx-auto" href="../profile.php?user=<?php echo $_SESSION['Username']; ?>">
                        <img src="../uploads/user/profile_picture/<?php echo $_SESSION['Profile_Picture']; ?>" alt="Logo" style="width: 45px;" class="rounded-circle">
                        <span class="text-white ml-2"><?php echo $_SESSION['Username']; ?></span>
                    </a>
                </li>
                <li class="nav-item"><a class="nav-link text-white" href="admin">Admin Panel</a></li>
                <li class="nav-item mb-3"><a class="nav-link text-white" href="../logout.php">Log Out</a></li>
            </ul>
        </div>

        <a href="javascript:void(0)">
            <span class="text-success h4"><b><i class="fas fa-bell fa-1x"></i></b></span>
        </a>
    </nav>

</section>