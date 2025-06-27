<li class="nav-item">

    <a class="nav-link resetclick applystart <?php echo $classapplystart; ?> " sendaction="applystart"
        href="javascript: void(0)">Apply Start</a>
</li>

<li class="nav-item">

    <a class="nav-link resetclick applyend <?php echo $classapplyend; ?>" sendaction="applyend"
        href="javascript: void(0)">Apply End</a>
</li>
<li class="nav-item">

    <a class="nav-link resetclick examdate <?php echo $classexamdate; ?>" sendaction="examdate"
        href="javascript: void(0)">Exam Day</a>
</li>

<li class="nav-item">

    <a class="nav-link  " sendaction="examdate" href="<?php echo $foldername; ?>/search.php">
        <i class='fa fa-search' aria-hidden='true'></i>
    </a>
</li>


<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
        <i class='fa fa-user' aria-hidden='true'></i>
    </a>
    <div class="dropdown-menu dropdown-menu-right">
        <a class="dropdown-item" href="<?php echo $foldername; ?>/dashboard.php">Dashboard</a>
        <?php include_once('headeruser.php'); ?>

    </div>
</li>