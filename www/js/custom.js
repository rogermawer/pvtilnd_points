/* this displays db and allows you to click on user name */
        $.ajax({
                type: "POST",
                url: "https://www.rogermawer.com/dev.pvtilnd_points_mobile/showdb.php",
                data: "{}",
                contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                dataType: "json",
                success: function (msg) {
                    $.each(msg, function(i, field){
                        var fname=field.first_name;
                        var lname=field.last_name;
                        var uname=field.user_name;
                        var points=field.points;
                        $("#mainDisplay").append("<tr><td class='value' data-toggle='modal' data-target='#myModal'>" +uname+ "</td><td class='display-points'>" +points+ "</td></tr>");
                        /* if signed in username = username found in DB, put name and points in header. This is the users information. */
                        if (window.localStorage.getItem("username") == uname){
                            $('.point-header').html('<span>' + uname + '</span>' + '<span style="color:#000000">&nbsp;&nbsp;&nbsp;</span><span class="point-header-style">' + points + '</span>');
                        }
                    });
                     /* following must be called within success function otherwise DOM does not find element */
                    $('.value').on('click', function(){
                        var value = $(this).html();
                        /* add receiver name to hidden input box */
                        $('#point-receiver').val(value);
                        /* add name to modal box */
                        $('.modal-title').html('Give ' +value+ ' points?');
                        $( "#dialog" ).dialog();
                    });
                   
                   /* call sort function */
                   $(window).load(sortTable());
  
                }
                
                
            });

        $.ajax({
                url: "https://www.rogermawer.com/dev.pvtilnd_points_mobile/showcomments.php",
                data: "{}",
                contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                dataType: "json",
                success: function (data) {
                    $.each(data, function(i, field){
                        var giver = field.giver;
                        var receiver = field.receiver;
                        var points = field.points;
                        var comment = field.comment;
                        var time = field.time;
                        if (points > 0) {
                            $("#recentAction").append("<tr><td>" +giver+ "</td><td><i style='color:#000' class='fas fa-arrow-right'></i></td><td>" +receiver+ "</td><td><i style='color:#32CD32' class='fas fa-arrow-up'></i></td><td>" +points+ "</td></tr><tr><td colspan='5'><em>'" +comment+ "'</em></td></tr>");
                        }else if (points < 0){
                           $("#recentAction").append("<tr><td>" +giver+ "</td><td><i style='color:#000' class='fas fa-arrow-right'></i></td><td>" +receiver+ "</td><td><i style='color:red' class='fas fa-arrow-down'></i></td><td>" +points+ "</td></tr><tr><td colspan='5'><em>'" +comment+ "'</em></td></tr>");
                        }else{
                            $("#recentAction").append("<tr><td>" +giver+ "</td><td><i style='color:#000' class='fas fa-arrow-right'></i></td><td>" +receiver+ "</td><td><i style='color:#32CD32' class='fas fa-arrow-up'></i></td><td>" +points+ "</td></tr><tr><td colspan='5'><em>'" +comment+ "'</em></td></tr>");
                        }
                        
                        
                    });
                }
        });
                     /* sort table according to point value */
                    function sortTable() {
                      var table, rows, switching, i, x, y, shouldSwitch;
                      table = document.getElementById("mainDisplay");
                      switching = true;
                      /* Make a loop that will continue until
                      no switching has been done: */
                      while (switching) {
                        // Start by saying: no switching is done:
                        switching = false;
                        rows = table.getElementsByTagName("tr");
                        /* Loop through all table rows (except the
                        first, which contains table headers): */
                        for (i = 0; i < (rows.length - 1); i++) {
                          // Start by saying there should be no switching:
                          shouldSwitch = false;
                          /* Get the two elements you want to compare,
                          one from current row and one from the next: */
                          x = rows[i].getElementsByTagName("td")[1];
                          y = rows[i + 1].getElementsByTagName("td")[1];
                          // Check if the two rows should switch place:
                          if (parseInt(x.innerHTML) < parseInt(y.innerHTML)) {
                            // I so, mark as a switch and break the loop:
                            shouldSwitch= true;
                            break;
                          }
                        }
                        if (shouldSwitch) {
                          /* If a switch has been marked, make the switch
                          and mark that a switch has been done: */
                          rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                          switching = true;
                        }
                      }
                    }














    
           