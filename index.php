<?php
echo 'hi dear';
include_once('connection.php');
include_once('userdata.php');
$searchmonth = $conn->real_escape_string($_GET['searchmonth']);
        $searchyear = $conn->real_escape_string($_GET['searchyear']);
        $searchingfor = $conn->real_escape_string($_GET['searchingfor']);
$bs='-';
?>
<!doctype html>
<html lang="en">

<head>
    <title>
        Exam Calendar
    </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="images/examcalendar-website-favicon-color.svg" sizes="any" type="image/svg+xml">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="css/style.css?v=<?php echo rand(1,100); ?>">
    <link rel="stylesheet" href="css/custom.css?v=<?php echo rand(1,100); ?>">
    <style>

    </style>
    <?php   include_once('facebook.php');   ?>
</head>

<body>


    <a class="fixdcustom" href="<?php echo $foldername; ?>/jobinput.php"
        style="color:blue;  transform: rotate(270deg); font-size:.9em;">Add Circilar & Manage</a>


    <section class="ftco-section">
        <div class="container">
            <style>
            .menume {
                position: relative;
            }

            .loveme {
                position: absolute;
                right: 25px;
                top: 20px;
                font-size: 1.4em;
                color: red;
                cursor: pointer;
            }
            </style>
            <div class="row justify-content-center menume">
                <div class="col-md-6 text-center ">
                    <div class="digital-clock" style="display:none;">00:00:00</div>
                    <img width="200" height="70" class="img-responsive"
                        src="<?php echo $foldername; ?>/images/logo-no-background.svg" alt="ExamCalendar Logo" />
                </div>
                <i data<?php echo $bs; ?>backdrop="static" data<?php echo $bs; ?>keyboard="false"
                    data<?php echo $bs; ?>toggle="modal" data<?php echo $bs; ?>target="#loveme"
                    class="fa fa-heart loveme" aria-hidden="true"></i>
            </div>






            <?php include_once('header.php'); ?>








            <div class="row showgif">
                <div class="col-md-12">
                    <div class="elegant-calencar d-md-flex">
                        <div class="wrap-header d-flex align-items-center">
                            <p id="reset" searchingfor="<?php echo $searchingfor? $searchingfor: 'examdateall'; ?>"
                                searchmonth="<?php echo $searchmonth; ?>" searchyear="<?php echo $searchyear; ?>">reset
                            </p>

                            <div id="header" class="p-0">
                                <div searchmonth="<?php echo $searchmonth; ?>" searchyear="<?php echo $searchyear; ?>"
                                    class="pre-button d-flex align-items-center justify-content-center"><i
                                        class="fa fa-chevron-left"></i></div>


                                <div class="head-info">
                                    <div class="monthexam"></div>
                                    <div class="head-day floatleft" style="display:none;"></div>

                                    <div class="row">
                                        <div class="message "></div>

                                        <div class="head-month " style="display:none;"></div>

                                    </div>



                                    <div class="details btn btn-info btn-sm" calldate="" addexam="" searchingfor=""
                                        data-toggle="modal" data-target="#viewDetails">View Details</div>
                                </div>



                                <div searchmonth="<?php echo $searchmonth; ?>" searchyear="<?php echo $searchyear; ?>"
                                    class="next-button d-flex align-items-center justify-content-center"><i
                                        class="fa fa-chevron-right"></i></div>
                            </div>
                        </div>

                        <div class="calendar-wrap">
                            <form class="form-inline" action="">
                                <div class="form-row forrow">
                                    <div class="col">
                                        <select class="form-control smalltext smalltextmonth" id="searchmonth"
                                            name="searchmonth" required>
                                            <option value="">Month</option>
                                            <?php
	$months = array(
	1 => 'Jan.', 
	2 => 'Feb.', 
	3 => 'Mar.', 
	4 => 'Apr.', 
	5 => 'May', 
	6 => 'Jun.', 
	7 => 'Jul.', 
	8 => 'Aug.', 
	9 => 'Sep.', 
	10 => 'Oct.', 
	11 => 'Nov.', 
	12 => 'Dec.');
	for($i=1; $i<=12; $i++){?>
                                            <option <?php echo $searchmonth==$i? 'selected':''; ?>
                                                value="<?php echo $i ?>"><?php echo $i.' '.$months[$i] ?></option>
                                            <?php }
	?>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <select class="form-control smalltext smalltextyear" id="searchyear"
                                            name="searchyear" required>
                                            <option value="">Year</option>
                                            <?php
	for($i=2021; $i<=2050; $i++){?>
                                            <option <?php echo $searchyear==$i? 'selected':''; ?>
                                                value="<?php echo $i ?>"><?php echo $i ?></option>
                                            <?php }
	?>

                                        </select>
                                    </div>
                                    <div class="col">
                                        <select class="form-control smalltext smalltexttype " id="searchingfor"
                                            name="searchingfor" required>


                                            <option <?php echo $searchingfor=='applyend'? 'selected':''; ?>
                                                value="applyend">Apply End</option>
                                            <option <?php echo $searchingfor=='applystart'? 'selected':''; ?>
                                                value="applystart">Apply Start</option>
                                            <option <?php echo $searchingfor=='examdate'? 'selected':''; ?>
                                                value="examdate">Exam Day</option>


                                        </select>
                                    </div>
                                    <div class="col">
                                        <button type="submit" class="btn btn-primary btn-sm">Search</button>
                                    </div>
                                </div>
                            </form>


                            <table id="calendar">



                                <thead>
                                    <tr>
                                        <th>Sun</th>
                                        <th>Mon</th>
                                        <th>Tue</th>
                                        <th>Wed</th>
                                        <th>Thu</th>
                                        <th>Fri</th>
                                        <th>Sat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td id="date13"></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                            <a target="_blank" href="<?php echo $foldername; ?>/jobinput.php"
                                class="addexambutton btn btn-success btn-sm" calldate="" addexam="yes">
                                <i class='fa fa-plus' aria-hidden='true'></i> Add circular for you and other
                            </a>
                            <div class="sitebranding">Welcome to www.examcalendar.com</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>











        <div class="container">
            <div class="" style="margin-top:20px;"></div>
            <div class="monthexam btn btn-danger" style=""> </div>
            <div class="thismonthexam" style=""></div>
        </div>
    </section>


    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js?v=<?php echo rand(1,100); ?>"></script>
    <script>
    $(document).ready(function() {
        clockUpdate();
        setInterval(clockUpdate, 1000);
    })

    function clockUpdate() {
        var date = new Date();
        // $('.digital-clock').css({'color': '#fff', 'text-shadow': '0 0 6px #ff0'});
        function addZero(x) {
            if (x < 10) {
                return x = '0' + x;
            } else {
                return x;
            }
        }

        function twelveHour(x) {
            if (x > 12) {
                return x = x - 12;
            } else if (x == 0) {
                return x = 12;
            } else {
                return x;
            }
        }

        var h = addZero(twelveHour(date.getHours()));
        var m = addZero(date.getMinutes());
        var s = addZero(date.getSeconds());
        var ampm = h >= 12 ? 'PM' : 'AM';

        $('.digital-clock').text(h + ':' + m + ':' + s)
    }
    </script>


    <!-- The Modal -->
    <div class="modal" id="viewDetails" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">
                        <div class="examdetailtitle"></div>
                        <div class="addornot"></div>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">

                    <div class="ajaxcall">









                    </div>


                    <script>
                    jQuery(".addexambutton").click(function() {
                        jQuery('.examaddform').css("display", "block");
                        jQuery('.ajaxcall').html('');
                    });
                    ///// detail button click
                    jQuery(".details").click(function() {
                        var calldate = jQuery(this).attr('calldate');
                        var addexam = jQuery(this).attr('addexam');
                        var searchingfor = jQuery(this).attr('searchingfor');

                        var error = 0;
                        var dateAr = calldate.split('-');
                        var newDate = dateAr[2] + '-' + dateAr[1] + '-' + dateAr[0];
                        //jQuery('.examdetailtitle').html(newDate);
                        jQuery('.examaddform').css("display", "none");
                        if (addexam == 'yes') {
                            error = 1;
                            jQuery('.examaddform').css("display", "block");
                            jQuery('.ajaxcall').html('');
                        }

                        if (!error) {

                            jQuery('.ajaxcall').html('<div class="spinner-border text-warning"></div>');

                            jQuery.ajax({
                                url: "<?php echo $foldername; ?>/ajax.php?bringexamlist=true",
                                type: "POST",
                                data: {
                                    calldate: calldate,
                                    searchingfor: searchingfor
                                },
                                success: function(data) {

                                    jQuery('.ajaxcall').html(data);





                                },

                            });
                        }


                    });
                    </script>

                    <div class="">
                        <a target="_blank" href="<?php echo $foldername; ?>/jobinput.php"
                            class="addexambutton btn btn-success btn-sm" calldate="" addexam="yes">
                            <i class='fa fa-plus' aria-hidden='true'></i> Add circular for you and other
                        </a>
                    </div>








                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
    <?php
include_once('loginregister.php');
?>
    <script>
    jQuery('.resetclick').click(function() {
        //
        var sendaction = jQuery(this).attr('sendaction');
        jQuery('#reset').attr("searchingfor", sendaction);
        const url = new URL(window.location);
        url.searchParams.set('searchingfor', sendaction);

        window.history.pushState(null, '', url.toString());

        jQuery("#reset").trigger("click");
    });
    //
    </script>


    <?php
if (isset($_GET['addexam']) && $_GET['addexam'] == 'true') {
?>
    <script>
    jQuery(".addexambutton").trigger("click");
    </script>
    <?php
}
?>



    <?php
include_once('footer.php'); ?>