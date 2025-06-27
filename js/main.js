(function ($) {
  "use strict";

  document.addEventListener(
    "DOMContentLoaded",
    function () {
      var today = new Date(),
        year = today.getFullYear(),
        month = today.getMonth(),
        monthTag = [
          "January",
          "February",
          "March",
          "April",
          "May",
          "June",
          "July",
          "August",
          "September",
          "October",
          "November",
          "December",
        ],
        daysArray = ["", "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
        daysArray2 = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
        day = today.getDate(),
        dayName = daysArray[today.getDay()],
        days = document.getElementsByTagName("td"),
        selectedDay,
        setDate,
        daysLen = days.length;
      // options should like '2014-01-01'
      function Calendar(selector, options) {
        this.options = options;
        this.draw();
      }

      Calendar.prototype.draw = function () {
        this.getCookie("selected_day");
        this.getOptions();
        this.drawDays();
        var that = this,
          reset = document.getElementById("reset"),
          pre = document.getElementsByClassName("pre-button"),
          next = document.getElementsByClassName("next-button");

        pre[0].addEventListener("click", function () {
          that.preMonth();
        });
        next[0].addEventListener("click", function () {
          that.nextMonth();
        });
        reset.addEventListener("click", function () {
          that.reset();
        });
        while (daysLen--) {
          days[daysLen].addEventListener("click", function () {
            that.clickDay(this);
          });
        }
      };

      Calendar.prototype.drawHeader = function (e, daytext = "") {
        //

        var headDay = document.getElementsByClassName("head-day"),
          headMonth = document.getElementsByClassName("head-month");

        e ? (headDay[0].innerHTML = e) : (headDay[0].innerHTML = day);

        var showdate = e;

        headMonth[0].innerHTML = daytext
          ? " " +
            daysArray[daytext] +
            ", " +
            showdate +
            " " +
            monthTag[month] +
            " " +
            year
          : " " +
            dayName +
            ", " +
            showdate +
            " " +
            monthTag[month] +
            " " +
            year;
      };

      Calendar.prototype.drawDays = function (
        e,
        monthx = "",
        yearx = "",
        dayx = ""
      ) {
        var searchmonth = GetURLParameter("searchmonth");

        if (searchmonth == "" || searchmonth == null) {
          var sendingmonth = parseInt(month) + 1;
        } else {
          var sendingmonth = searchmonth;
          year = GetURLParameter("searchyear");
          nDays = daysInMonth(sendingmonth, year);
          month = sendingmonth;
        }

        var startDay = new Date(year, month, 1).getDay(),
          nDays = new Date(year, month + 1, 0).getDate(),
          n = startDay;

        // console.log(startDay);
        // console.log(nDays);
        // console.log(n);
        var dayfounddate = 1;

        var error = 0;
        if (!error) {
          jQuery(".message").html("Please Wait...");

          var searchingfor = GetURLParameter("searchingfor");
          var searchingforx = jQuery("#reset").attr("searchingfor");

          if (searchingfor == null) {
            searchingfor = e ? e : searchingforx;
          }
          if (searchingforx == "examdate") {
            jQuery(".applystart").removeClass("active");
            jQuery(".applyend").removeClass("active");
            jQuery(".examdate").addClass("active");
          }

          if (searchingforx == "applystart") {
            jQuery(".examdate").removeClass("active");
            jQuery(".applyend").removeClass("active");
            jQuery(".applystart").addClass("active");
          }

          if (searchingforx == "applyend") {
            jQuery(".applystart").removeClass("active");
            jQuery(".examdate").removeClass("active");
            jQuery(".applyend").addClass("active");
          }

          jQuery(".details").attr("searchingfor", searchingfor);
          jQuery.ajax({
            url: "/ajax.php?brigmonth=true",
            type: "POST",
            data: {
              month: sendingmonth,
              nDays: nDays,
              year: year,
              searchingfor: searchingfor,
            },
            success: function (data) {
              var json = jQuery.parseJSON(data);

              jQuery(".monthexam").html(
                '<div class="monthexamdiv">' + json.monthexam + "</div>"
              );

              Object.keys(json.starview).forEach(function (stars) {
                // key is the div class name
                var getstardaynumber = stars.replace(/[^0-9]/g, "");
                var starnumber = json.starview[stars];
                var startext = "<span class='starto'>";
                var m = 0;
                for (var i = 0; i < starnumber; i++) {
                  if (i <= 1) {
                    startext += "&#9733;";
                  } else {
                    m++;
                  }
                }
                if (m != "0") {
                  startext += "+" + m;
                }
                startext += "</span>";

                jQuery("." + stars).html(startext);
              });

              Object.keys(json.evenArrayCount).forEach(function (key) {
                // key is the div class name
                var getdaynumber = key.replace(/[^0-9]/g, "");

                if (getdaynumber == day) {
                  dayfounddate = 2;
                  if (json.evenArrayCount[key] == "1") {
                    jQuery(".message").html(
                      '<div class="todayexams"> ' +
                        getfinalday(year + "-" + sendingmonth + "-" + day) +
                        " " +
                        day +
                        "/" +
                        sendingmonth +
                        "/" +
                        year +
                        " :: " +
                        json.evenArrayCount[key] +
                        " exam</div>"
                    );
                    jQuery(".todayexamdata").html(json.evenArrayCount[key]);
                    jQuery(".details").html("View Details");
                    jQuery(".details").attr("addexam", "no");
                  } else if (json.evenArrayCount[key] > 1) {
                    jQuery(".message").html(
                      '<div class="todayexams"> ' +
                        getfinalday(year + "-" + sendingmonth + "-" + day) +
                        " " +
                        day +
                        "/" +
                        sendingmonth +
                        "/" +
                        year +
                        " :: " +
                        json.evenArrayCount[key] +
                        " exams</div>"
                    );
                    jQuery(".todayexamdata").html(json.evenArrayCount[key]);
                    jQuery(".details").html("View Details");
                    jQuery(".details").attr("addexam", "no");
                  } else {
                    jQuery(".message").html(
                      '<div class="todayexams">' +
                        getfinalday(year + "-" + sendingmonth + "-" + day) +
                        " " +
                        day +
                        "/" +
                        sendingmonth +
                        "/" +
                        year +
                        " :: 0 exam </div>"
                    );
                    jQuery(".todayexamdata").html(json.evenArrayCount[key]);
                    jQuery(".details").html("Add exam info to help other");
                    jQuery(".details").attr("addexam", "yes");
                  }
                }

                if (searchingfor == "applystart") {
                  jQuery("." + key).html(
                    '<img src="/images/start.png"/> <span class="starx">' +
                      json.evenArrayCount[key] +
                      "</span>"
                  );
                } else if (searchingfor == "applyend") {
                  jQuery("." + key).html(
                    '<img src="/images/end.png"/> <span class="starx">' +
                      json.evenArrayCount[key] +
                      "</span>"
                  );
                } else {
                  jQuery("." + key).html(
                    '<img src="/images/exam.png"/> <span class="starx">' +
                      json.evenArrayCount[key] +
                      "</span>"
                  );
                }

                var calldatevalue =
                  "" + year + "-" + sendingmonth + "-" + day + "";
                jQuery(".details").attr("calldate", calldatevalue);

                if (json.evenArrayCount[key] < 1) {
                  jQuery(".details").html("Add Now");
                }
              });
              if (json.message == 2) {
                jQuery(".message").html(
                  '<div class="todayexams">' +
                    getfinalday(year + "-" + sendingmonth + "-" + day) +
                    " " +
                    day +
                    "/" +
                    sendingmonth +
                    "/" +
                    year +
                    " :: 0 exam</div>"
                );
                jQuery(".details").html("Add exam info to help other");
                jQuery(".details").attr("addexam", "yes");
                var calldatevalue =
                  "" + year + "-" + sendingmonth + "-" + day + "";
                jQuery(".details").attr("calldate", calldatevalue);
              }
              if (dayfounddate == 1) {
                //console.log(startDay);
                jQuery(".message").html(
                  '<div class="todayexams">' +
                    getfinalday(year + "-" + sendingmonth + "-" + day) +
                    " " +
                    day +
                    "/" +
                    sendingmonth +
                    "/" +
                    year +
                    " :: 0 exam</div>"
                );
                jQuery(".details").html("Add exam info to help other");
                jQuery(".details").attr("addexam", "yes");
                var calldatevalue =
                  "" + year + "-" + sendingmonth + "-" + day + "";
                jQuery(".details").attr("calldate", calldatevalue);
              }

              jQuery(".thismonthexam").html(json.uldata);
            },
          });
        }

        for (var k = 0; k < 42; k++) {
          days[k].innerHTML = "";
          days[k].id = "";
          days[k].className = "";
        }

        for (var i = 1; i <= nDays; i++) {
          days[n].innerHTML =
            '<div class="tdalldata"><div class="dateviewa dateview' +
            i +
            '">' +
            i +
            '</div><div class="eventviewall eventview' +
            i +
            '"></div><div class="stardiv starview' +
            i +
            '"></div></div>';
          days[n].id = "datetd date" + i;
          days[n].className = "datetd date" + i;

          n++;
        }

        for (var j = 0; j < 42; j++) {
          if (days[j].innerHTML === "") {
            days[j].id = "disabled";
          } else if (j === day + startDay - 1) {
            if (
              (this.options &&
                month === setDate.getMonth() &&
                year === setDate.getFullYear()) ||
              (!this.options &&
                month === today.getMonth() &&
                year === today.getFullYear())
            ) {
              this.drawHeader(day);
              days[j].id = "today";
              days[j].className = "today date" + day;
            }
          }
          if (selectedDay) {
            if (
              j === selectedDay.getDate() + startDay - 1 &&
              month === selectedDay.getMonth() &&
              year === selectedDay.getFullYear()
            ) {
              days[j].className = "selected";
              this.drawHeader(selectedDay.getDate());
            }
          }
        }
      };
      function GetURLParameter(sParam) {
        var sPageURL = window.location.search.substring(1);
        var sURLVariables = sPageURL.split("&");
        for (var i = 0; i < sURLVariables.length; i++) {
          var sParameterName = sURLVariables[i].split("=");
          if (sParameterName[0] == sParam) {
            return sParameterName[1];
          }
        }
      }

      function daysInMonth(month, year) {
        return new Date(year, month, 0).getDate();
      }
      Calendar.prototype.clickDay = function (o) {
        var selected = document.getElementsByClassName("selected"),
          len = selected.length;

        if (len !== 0) {
          selected[0].className = "";
        }
        o.className = "selected";
        var trimtext = o.innerText;
        //trimtext = trimtext.replace(/[^0-9]/g,'');

        var myArrayTextrecheck = trimtext.split(" ");
        var monthDayExamFound;
        if (myArrayTextrecheck[1] != null) {
          var monthDateFoundArray = myArrayTextrecheck[1].split("\n");
          monthDayExamFound = monthDateFoundArray[0];
        } else {
          monthDayExamFound = 0;
        }

        var monthDateFound = myArrayTextrecheck[0].replace(/[^0-9]/g, "");

        ///console.log(myArrayTextrecheck);
        ////console.log(monthDateFoundArray);

        selectedDay = new Date(year, month, monthDateFound);

        var month1 = month + 1;

        var searchmonth = GetURLParameter("searchmonth");
        if (searchmonth == "" || searchmonth == null) {
        } else {
          month1 = searchmonth;
          year = GetURLParameter("searchyear");
        }

        var selectedForDayName = new Date(
          year + "-" + month1 + "-" + monthDateFound
        );

        this.drawHeader(monthDateFound, selectedForDayName.getDay() + 1);
        this.setCookie("selected_day", 1);

        if (monthDayExamFound == "1") {
          jQuery(".message").html(
            '<div class="todayexams">' +
              getfinalday(year + "-" + month1 + "-" + monthDateFound.trim()) +
              " " +
              monthDateFound.trim() +
              "/" +
              month1 +
              "/" +
              year +
              " :: " +
              monthDayExamFound +
              " exam</div>"
          );
          jQuery(".todayexamdata").html(monthDayExamFound);
          jQuery(".details").html("View Details");
          jQuery(".details").attr("addexam", "no");
        } else if (monthDayExamFound > 1) {
          jQuery(".message").html(
            '<div class="todayexams">' +
              getfinalday(year + "-" + month1 + "-" + monthDateFound.trim()) +
              " " +
              monthDateFound.trim() +
              "/" +
              month1 +
              "/" +
              year +
              " :: " +
              monthDayExamFound +
              " exams</div>"
          );
          jQuery(".todayexamdata").html(monthDayExamFound);
          jQuery(".details").html("View Details");
          jQuery(".details").attr("addexam", "no");
        } else {
          jQuery(".message").html(
            '<div class="todayexams">' +
              getfinalday(year + "-" + month1 + "-" + monthDateFound.trim()) +
              " " +
              monthDateFound +
              "/" +
              month1 +
              "/" +
              year +
              " :: 0 exam</div>"
          );
          jQuery(".todayexamdata").html(monthDayExamFound);
          jQuery(".details").html("Add exam info to help other");
          jQuery(".details").attr("addexam", "yes");
        }

        var calldatevalue = year + "-" + month1 + "-" + monthDateFound + "";
        calldatevalue = calldatevalue.trim();
        jQuery(".details").attr("calldate", calldatevalue);
        var getexamdetailtitle = jQuery(".todayexams").html();
        var getadornot = jQuery(".details").html();
        jQuery(".examdetailtitle").html(getexamdetailtitle);
        jQuery(".addornot").html(getadornot);
        jQuery(".details").trigger("click");
      };

      Calendar.prototype.preMonth = function () {
        if (month < 1) {
          month = 11;
          year = year - 1;
        } else {
          month = month - 1;
        }
        const url = new URL(window.location);
        url.searchParams.set("searchmonth", "");
        window.history.pushState(null, "", url.toString());
        var month1 = month + 1;
        var selectedForDayName = new Date(year + "-" + month1 + "-1");

        this.drawHeader(day, selectedForDayName.getDay() + 1);
        //this.drawHeader(1);
        this.drawDays();
      };

      function getDayName(date = new Date(), locale = "en-US") {
        return date.toLocaleDateString(locale, { weekday: "long" });
      }
      function getfinalday(datefind = "") {
        var findalday = getDayName(new Date(datefind));
        return (findalday = findalday.slice(0, 3));
      }

      //console.log(getfinalday('2023-7-29'));

      Calendar.prototype.nextMonth = function () {
        if (month >= 11) {
          month = 0;
          year = year + 1;
        } else {
          month = month + 1;
        }
        const url = new URL(window.location);
        url.searchParams.set("searchmonth", "");
        window.history.pushState(null, "", url.toString());
        var month1 = month + 1;
        var selectedForDayName = new Date(year + "-" + month1 + "-1");
        var clickday = selectedForDayName.getDay() + 1;
        this.drawHeader(day, clickday);

        //this.drawHeader(1);
        this.drawDays();
      };

      Calendar.prototype.getOptions = function () {
        if (this.options) {
          var sets = this.options.split("-");
          setDate = new Date(sets[0], sets[1] - 1, sets[2]);
          day = setDate.getDate();
          year = setDate.getFullYear();
          month = setDate.getMonth();
        }
      };

      Calendar.prototype.reset = function () {
        var searchingfor = jQuery("#reset").attr("searchingfor");

        month = today.getMonth();
        year = today.getFullYear();

        const url = new URL(window.location);
        url.searchParams.set("searchmonth", "");
        window.history.pushState(null, "", url.toString());

        day = today.getDate();
        this.options = undefined;
        this.drawDays(searchingfor);
      };

      Calendar.prototype.setCookie = function (name, expiredays) {
        if (expiredays) {
          var date = new Date();
          date.setTime(date.getTime() + expiredays * 0);
          var expires = "; expires=" + date.toGMTString();
        } else {
          var expires = "";
        }
        document.cookie = name + "=" + selectedDay + expires + "; path=/";
      };

      Calendar.prototype.getCookie = function (name) {
        if (document.cookie.length) {
          var arrCookie = document.cookie.split(";"),
            nameEQ = name + "=";
          for (var i = 0, cLen = arrCookie.length; i < cLen; i++) {
            var c = arrCookie[i];
            while (c.charAt(0) == " ") {
              c = c.substring(1, c.length);
            }
            if (c.indexOf(nameEQ) === 0) {
              selectedDay = new Date(c.substring(nameEQ.length, c.length));
            }
          }
        }
      };
      var calendar = new Calendar();
    },
    false
  );
})(jQuery);
