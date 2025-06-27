<?php

// 
/// step 1 // https://examcalendar.com/cron.php
// cron to collet data from http://vas.teletalk.com.bd/clientLivejobs.php 

/// step 2 https://examcalendar.com/cron2.php
// cron2 to colect data from https://alljobs.teletalk.com.bd/bn/jobs/organization/list/jobs to examdatapre table

/// step 3 https://examcalendar.com/cron3.php
// cron3 to collect data from  examdatapre dbtable which data was collected by step 2 // every time called collect one organization job data to examdatapre table // set status=0 if need to call again

/// step 3.1
// cron3 to collect data from https://alljobs.teletalk.com.bd/bn/jobs/organization/wis/jobs/'.$jobid // here $jobid is collected from  examdatapre dbtable (data was collected by step 2)

/// step 4
// cron to transfer data from subtabletomaintable.php  examdatapre to examdata table // set addedtomaintable ='0' and cron='1'