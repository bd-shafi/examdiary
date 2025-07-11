<?php
include_once('jobinput.php');
exit;
include_once('userdata.php');
$jid = $conn->real_escape_string($_GET['jid']);



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Job Search</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
        integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" href="css/custom.css?v=<?php echo rand(1,100); ?>">
    <style>
    .disabledivwishlist {
        opacity: .2;
        pointer-events: none;
    }

    .desifield {
        margin-bottom: 10px;
        border: 1px solid #ccc;
        padding: 5px;
    }

    .form-control::placeholder {
        /* Chrome, Firefox, Opera, Safari 10.1+ */
        color: #cccccc94;
        opacity: 1;
        /* Firefox */
    }

    .form-control:-ms-input-placeholder {
        /* Internet Explorer 10-11 */
        color: #cccccc94;
    }

    .form-control::-ms-input-placeholder {
        /* Microsoft Edge */
        color: #cccccc94;
    }

    .jobdegi {
        background-color: #aed9d5;
        margin-bottom: 5px;
    }
    </style>
    <?php   include_once('facebook.php');   ?>
</head>

<body>

    <div class="container mt-3">


        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $foldername; ?>/">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/?searchingfor=applystart">Apply Start</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/?searchingfor=applyend">Apply End</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="/?searchingfor=examdate">Exam Date</a>
            </li>
        </ul>
        <h2>Job Search</h2>
        <?php
 $sqlrow = "SELECT * FROM examdata where id='$jid' limit 1";
       
		$result = mysqli_query($conn, $sqlrow);
		$row = mysqli_fetch_array($result);
	 
		 $otherusers = $row['otherusers'];
		 ?>




        <form class="examaddform" action="" class="" id="examaddform" onsubmit="return examaddform();">

            <div class="form-group">
                <label for="phone">Your Phone: <span class="mustrequired">*</span></label>
                <input required type="number" class="form-control" placeholder="" id="phone" name="phone"
                    value="<?php echo $row['phone']; ?>">
            </div>


            <div class="form-group">
                <label for="email">Your Email address: <span class="mustrequired">*</span></label>
                <input required type="email" class="form-control" placeholder="" id="email" name="email"
                    value="<?php echo $row['email']; ?>">
            </div>

            <div class="form-group">
                <label for="organization">Organization: <span class="mustrequired">*</span></label>
                <input required type="text" class="form-control" placeholder="" id="organization" name="organization"
                    value="<?php echo $row['organization']; ?>">
            </div>


            <div class="form-group">
                <label for="applyby">Apply By: <span class="mustrequired">*</span></label></br>
                <div class="form-check-inline">
                    <label class="form-check-label">
                        <input type="radio" <?php echo $row['applyby']=='teletalk' ?'checked':''; ?>
                            class="form-check-input applyby" name="applyby" value="teletalk" required>Teletalk
                    </label>
                </div>
                <div class="form-check-inline">
                    <label class="form-check-label">
                        <input type="radio" <?php echo $row['applyby']=='bank' ?'checked':''; ?>
                            class="form-check-input applyby" name="applyby" value="bank" required>Bank
                    </label>
                </div>

                <div class="form-check-inline ">
                    <label class="form-check-label">
                        <input required type="radio" <?php echo $row['applyby']=='other' ?'checked':''; ?>
                            class="form-check-input applyby" name="applyby" value="other" required>Other
                    </label>
                </div>
                <div class="form-check-inline">
                    <label class="form-check-label">
                        <input type="radio" <?php echo $row['applyby']=='unknown' ?'checked':''; ?>
                            class="form-check-input applyby" name="applyby" value="unknown" required>Skip
                    </label>
                </div>
                <script>
                jQuery('.applyby').change(function() {
                    var rvalue = jQuery(this).val();
                    jQuery('.codeorlinkdiv').css('display', 'block');

                    if (rvalue == 'teletalk') {
                        jQuery('.applybyhtml').html(
                            'Teletalk Code: <span class="mustrequired">*</span> (Example: BCS)');
                        /// jQuery('.codeorlink').attr("type","text");
                        jQuery('.codeorlink').attr("placeholder", "BCS");
                    } else if (rvalue == 'bank') {
                        jQuery('.applybyhtml').html(
                            'Bank Job ID: <span class="mustrequired">*</span> (Example: 10148)');
                        /// jQuery('.codeorlink').attr("type","number");
                        jQuery('.codeorlink').attr("placeholder", "10148");
                    } else if (rvalue == 'unknown') {

                        jQuery('.codeorlinkdiv').css('display', 'none');
                    } else {
                        jQuery('.applybyhtml').html(
                            'Please Enter Apply Link: <span class="mustrequired">*</span> (Example: www.bdjobs.com)'
                            );
                        ///jQuery('.codeorlink').attr("type","text");
                        jQuery('.codeorlink').attr("placeholder", "www.bdjobs.com");
                    }
                });
                </script>
            </div>

            <div class="form-group codeorlinkdiv">
                <label for="codeorlink" class="applybyhtml">Teletalk Code:</label>
                <input type="text" class="form-control codeorlink" placeholder="" id="codeorlink" name="codeorlink"
                    value="<?php echo $row['shortcode']; ?>">
            </div>



            <div class="form-group applystartshow">
                <label for="applystart">Apply Start: </label>
                <input type="date" class="form-control" placeholder="" id="applystart" name="applystart"
                    value="<?php echo $row['applystart']; ?>">
            </div>


            <div class="form-group applyendshow">
                <label for="applyend">Apply End: </label>
                <input type="date" class="form-control" placeholder="" id="applyend" name="applyend"
                    value="<?php echo $row['applyend']; ?>">
            </div>









            <div class="alldesignation">
                <label for="examdate">Exam Date :</label>
                <?php
 $getalldesignation = $row['examdateall'];
 
if($getalldesignation == NULL || $getalldesignation == 'null'){
    $getalldesignationdecode = explode(',', $row['designation']);
}else{
    $getalldesignationdecode = json_decode($getalldesignation, true);
}

$c=0;
foreach($getalldesignationdecode as $index=>$ddata){
    
    $uniqid=uniqid();
$c++;

 
?>






                <div class="form-group desifield forremove<?php echo $c; ?>">
                    <div class="row">

                        <div class="col">
                            <input type="text" class="form-control jobdegi" placeholder=""
                                name="examdateset[designations][]"
                                value="<?php echo is_array($ddata) ? $ddata['designations'] : $ddata; ?>">
                        </div>


                        <div class="row">
                            <div class="col">
                                <input type="datetime-local" class="form-control" placeholder=""
                                    name="examdateset[examdates][]"
                                    value="<?php echo $ddata['date'].' '.$ddata['time']; ?>">
                                <input type="hidden" class="form-control" placeholder="Enter uniqid"
                                    name="examdateset[uniqid][]"
                                    value="<?php echo $ddata['uniqid']? $ddata['uniqid']: $uniqid; ?>">
                            </div>


                            <div class="col">
                                <select class="form-control" id="examtypes" name="examdateset[examtypes][]">
                                    <option <?php echo $ddata['examtype'] =='Preliminary' ? 'selected':'' ; ?>
                                        value="Preliminary">Preliminary</option>

                                    <option <?php echo $ddata['examtype'] =='Unknown' ? 'selected':'' ; ?>
                                        value="Unknown">Unknown</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <input type="datetime-local" class="form-control" placeholder=""
                                    name="examdateset[examdatesw][]"
                                    value="<?php echo $ddata['datew'].' '.$ddata['timew']; ?>">
                            </div>



                            <div class="col">
                                <select class="form-control" id="examtypesw" name="examdateset[examtypesw][]">
                                    <option <?php echo $ddata['examtypew'] =='Written' ? 'selected':'' ; ?>
                                        value="Written">Written</option>

                                    <option <?php echo $ddata['examtypew'] =='Unknown' ? 'selected':'' ; ?>
                                        value="Unknown">Unknown</option>
                                </select>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col">
                                <input type="datetime-local" class="form-control" placeholder=""
                                    name="examdateset[examdatesp][]"
                                    value="<?php echo $ddata['datep'].' '.$ddata['timep']; ?>">
                            </div>



                            <div class="col">
                                <select class="form-control" id="examtypesp" name="examdateset[examtypesp][]">
                                    <option <?php echo $ddata['examtypep'] =='Practical' ? 'selected':'' ; ?>
                                        value="Practical">Practical</option>

                                    <option <?php echo $ddata['examtypep'] =='Unknown' ? 'selected':'' ; ?>
                                        value="Unknown">Unknown</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <input type="datetime-local" class="form-control" placeholder=""
                                    name="examdateset[examdatesv][]"
                                    value="<?php echo $ddata['datev'].' '.$ddata['timev']; ?>">
                            </div>



                            <div class="col">
                                <select class="form-control" id="examtypesv" name="examdateset[examtypesv][]">
                                    <option <?php echo $ddata['examtypev'] =='Viva' ? 'selected':'' ; ?> value="Viva">
                                        Viva</option>

                                    <option <?php echo $ddata['examtypev'] =='Unknown' ? 'selected':'' ; ?>
                                        value="Unknown">Unknown</option>
                                </select>
                            </div>
                        </div>





                    </div>
                    <a onclick="removeFun(<?php echo $c; ?>)" class="removemore">Remove-</a>
                </div>




                <?php } ?>
            </div>





            <div class="col-12 mx-auto text-center">
                <div class="addmore btn btn-info mx-auto"> Add+</div>
            </div>
            <script>
            var i = <?php echo $c; ?>;
            jQuery(".addmore").click(function() {
                if (confirm("Are you sure you want to add more post?")) {
                    i++;
                    jQuery('.alldesignation').append('<div class="form-group desifield forremove' + i +
                        '"><div class="row"><div class="col"><input type="text" class="jobdegi form-control" placeholder="" name="examdateset[designations][]" value=""></div><div class="row"><div class="col"><input type="datetime-local" class="form-control" placeholder="" name="examdateset[examdates][]"></div><div class="col"><select class="form-control" id="examtypes" name="examdateset[examtypes][]"><option value="Preliminary">Preliminary</option><option value="Unknown">Unknown</option></select></div></div><div class="row"><div class="col"><input type="datetime-local" class="form-control" placeholder="" name="examdateset[examdatesw][]"></div><div class="col"><select class="form-control" id="examtypesw" name="examdateset[examtypesw][]"><option value="Written">Written</option><option value="Unknown">Unknown</option></select></div></div><div class="row"><div class="col"><input type="datetime-local" class="form-control" placeholder="" name="examdateset[examdatesp][]"></div><div class="col"><select class="form-control" id="examtypesp" name="examdateset[examtypesp][]"><option value="Practical">Practical</option><option value="Unknown">Unknown</option></select></div></div><div class="row"><div class="col"><input type="datetime-local" class="form-control" placeholder="" name="examdateset[examdatesv][]"></div><div class="col"><select class="form-control" id="examtypesv" name="examdateset[examtypesv][]"><option value="Viva">Viva</option><option value="Unknown">Unknown</option></select></div></div></div><a onClick="removeFun(' +
                        i + ')" class="removemore">Remove-</a></div>');
                }

            });
            </script>

            <script>
            function removeFun(e) {

                if (confirm("Are you sure you want to remove this post?")) {
                    jQuery('.forremove' + e).remove();
                }
            }
            </script>










            <div class="form-group">
                <label for="examlocation">Exam Location:</label>
                <input type="text" class="form-control" placeholder="" id="examlocation" name="examlocation"
                    value="<?php echo $row['examlocation']; ?>">
                <input type="hidden" class="form-control" placeholder="" id="jid" name="jid"
                    value="<?php echo $jid; ?>">
            </div>


            <div class="form-group">
                <label for="details">More Info:</label>
                <textarea class="form-control" rows="3" id="details"
                    name="details"><?php echo $row['details']; ?></textarea>
            </div>






            <div class="form-group form-check">
                <label class="form-check-label">
                    <input class="form-check-input" <?php echo $row['notifyme']=='1' ?'checked':''; ?> type="checkbox"
                        name="notifyme" value="1"> Notify Me
                </label>
            </div>

            <div class="form-group form-check">
                <label class="form-check-label">
                    <input required class="form-check-input" type="checkbox"> The information is true.
                </label>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Update</button>
        </form>
        <div class="successmessage"></div>
        <script>
        //createhides
        function examaddform() {

            //console.log("submit event");
            var fd = new FormData(document.getElementById("examaddform"));


            var error = 0;

            if (!error) {

                jQuery('.successmessage').html(
                    '<div class="spinner-border text-info" role="status"> <span class="visually-hidden">Loading...</span></div>'
                    );

                jQuery.ajax({
                    url: "<?php echo $foldername; ?>/ajax.php?editexam=true",
                    type: "POST",
                    data: fd,
                    enctype: 'multipart/form-data',
                    success: function(data) {



                        ///var json = jQuery.parseJSON(data);
                        /// var message = json.message;
                        jQuery('.successmessage').html(data);
                        ///jQuery('.successmessage').html(message); 

                        ///document.getElementById("examaddform").reset();





                    },
                    processData: false, // tell jQuery not to process the data
                    contentType: false // tell jQuery not to set contentType
                });
            }
            return false;
        };
        </script>



    </div>

</body>

</html>