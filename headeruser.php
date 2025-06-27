<?php
        if($_COOKIE['exid'] == NULL){
            ?>

<a class="dropdown-item login" href="#" data-toggle="modal" data-target="#loginform" href="#">Login</a>
<?php
        }else{
            ?>
<a class="dropdown-item" href="javascript: void(0)"><?php echo $displayname; ?></a>
<a class="dropdown-item" href="javascript: void(0)"><?php echo $hidephone; ?></a>
<a class="dropdown-item" href="javascript: void(0)"><?php echo $email; ?></a>
<a class="dropdown-item" href="<?php echo $foldername; ?>/logout.php">

    Log out

</a>
<?php
        }
        ?>