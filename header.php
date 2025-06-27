<div class="row showgif">
				<div class="col-md-12">
				     <ul class="nav justify-content-center menulink">
  
    <?php
    $searchingfor = $_GET['searchingfor'];
    ?>
    
	
	
	
	
	
	<li class="nav-item dropdown" style="display:none;">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
          <?php
          $sqlstring ='';
          $classapplystart= '';
          $classapplyend ='';
          $classexamdate ='';
          if($searchingfor == 'applystart'){
        $sqlstring = " Apply Start ";
        $classapplystart = 'active';
        
    }else if($searchingfor == 'applyend'){
        $sqlstring = " Apply End ";
        $classapplyend = 'active';
      
    }else{
         $sqlstring = " Exam Day";
         $classexamdate ='active';
         
    }
    echo $sqlstring;
    ?>
        
      </a>
      <div class="dropdown-menu">
        <a class="dropdown-item <?php echo $classexamdate; ?>" href="?searchingfor=examdate">Exam Day</a>
        <a class="dropdown-item <?php echo $classapplystart; ?> " href="?searchingfor=applystart">Apply Start</a>
        <a class="dropdown-item <?php echo $classapplyend; ?>" href="?searchingfor=applyend">Apply End</a>
      </div>
    </li>
	
	
	
	
	
	
	<?php include_once('headermenu.php'); ?>
	
	
	
	
    
 
       
       
    

    
    

  </ul>
				    </div>
				    </div>
				    