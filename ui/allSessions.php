<?php session_start();
if(!isset($_SESSION['loggedIn'])){
  header("Location: login.php");
}
?>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/navbar-top-fixed.css">
<link rel="stylesheet" type="text/css" href="lib/pickadate/css/classic.css">
<link rel="stylesheet" type="text/css" href="lib/pickadate/css/classic.date.css">
<link rel="stylesheet" type="text/css" href="lib/pickadate/css/classic.time.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="lib/pickadate/js/picker.js"></script>
<script src="lib/pickadate/js/picker.date.js"></script>
<script src="lib/pickadate/js/picker.time.js"></script>

<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
  <a class="navbar-brand" href="#">Evento</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarCollapse">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="dashboard.php">Events</a>
      </li>
      <?php if($_SESSION['role'] == "admin"){ ?>
      <li class="nav-item">
        <a class="nav-link" href="allAttendees.php">Attendees</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="allVenues.php">Venues</a>
      </li>
      <?php }?>
      <li class="nav-item active">
        <a class="nav-link" href="allSessions.php">Sessions</a>
      </li> 
    </ul>
    <button type="button" class="btn btn-primary logout">Logout</button>
  </div>
</nav>

<!--Edit session modal-->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Edit Session</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group row">
            <label for="inputName" class="col-sm-3 col-form-label">Name</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="inputName">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputStartDate" class="col-sm-3 col-form-label">Start-Date</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="inputStartDate">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputEndDate" class="col-sm-3 col-form-label">End-Date</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="inputEndDate">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputNA" class="col-sm-3 col-form-label">Number Allowed</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="inputNA">
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary save-change">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!--Add session modal-->
<div class="modal fade" id="addSessionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Add Session</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group row">
            <label for="inputAddSessionName" class="col-sm-3 col-form-label">Name</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="inputAddSessionName" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputAddSessionStartDate" class="col-sm-3 col-form-label">Start-Date</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="inputAddSessionStartDate" placeholder="Pick a date">
            </div>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="inputAddSessionStartTime" placeholder="Pick a time">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputAddSessionEndDate" class="col-sm-3 col-form-label">End-Date</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="inputAddSessionEndDate" placeholder="Pick a date">
            </div>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="inputAddSessionEndTime" placeholder="Pick a time">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputAddSessionNA" class="col-sm-3 col-form-label">No. Allowed</label>
            <div class="col-sm-9">
                <input type="number" class="form-control" id="inputAddSessionNA">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputAddEvent" class="col-sm-3 col-form-label">Event</label>
            <div class="col-sm-9">
            <select class="custom-select add-event-select">
              <option selected disabled>Open this select menu</option>
            </select>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary add-session-modal-btn">Add</button>
      </div>
    </div>
  </div>
</div>

<div class="container">
  <div class="row justify-content-center">
    <h2>Session</h2><br/>
  </div>
  <?php if($_SESSION['role'] == "admin" || $_SESSION['role'] == "event manager"){ ?>
  <div class="row">
    <button type="button" class="btn btn-primary btn-block add-session">Add New Session</button>
  </div>
  <?php } ?>
  <br/>
  <div class="row justify-content-center" id="sessions"></div>
</div>

<script>
  $.ajax({
    url:'http://serenity.ist.rit.edu/~dc6288/EMS/api/api.php?method=getSessions<?php if(isset($_GET['id'])){echo "&id=".$_GET['id'];} else if($_SESSION['role'] == 'event manager'){echo "&manager=".$_SESSION['username'];} else if($_SESSION['role'] != "admin"){echo "&username=".$_SESSION['username'];} ?>',
    success: function(content){
      console.log(JSON.parse(content));
      $(".logout").click(function(){
        $.ajax({
          url:"http://serenity.ist.rit.edu/~dc6288/EMS/logout.php",
          success: function(content){
            if(content == "LoggedOut"){
              console.log("LOGGED OUT");
              window.location.href = "http://serenity.ist.rit.edu/~dc6288/EMS/login.php";
            }
          }
        });
      });

      $( ".add-session" ).click(function() {
        $('#addSessionModal').modal('show'); 
        $.ajax({
          url:'http://serenity.ist.rit.edu/~dc6288/EMS/api/api.php?method=getEvents<?php if($_SESSION['role'] == 'event manager'){echo "&username=".$_SESSION['username'];}?>',
          success: function(content){
            $.each(JSON.parse(content), function(index, obj){
              let myOption;
              myOption = $(`<option value="${obj.name}" id="${obj.idevent}">${obj.name}</option>`);
              myOption.appendTo(".add-event-select");
            });
          }
        });
        $('#inputAddSessionStartDate').pickadate();
        $('#inputAddSessionStartTime').pickatime();
        $('#inputAddSessionEndDate').pickadate();
        $('#inputAddSessionEndTime').pickatime();
      });

      $(".add-session-modal-btn").click(function(){
        let name = $("#inputAddSessionName").val();
        let startdate = $("#inputAddSessionStartDate").val();
        let starttime = $("#inputAddSessionStartTime").val();
        let enddate = $("#inputAddSessionEndDate").val();
        let endtime = $("#inputAddSessionEndTime").val();
        let numberallowed = $("#inputAddSessionNA").val();
        let eName = $(".add-event-select").children("option:selected").val();
        //START 11 March, 2020 TIME 3:00 PM
        startSessionDate = moment(startdate+" "+starttime, "DD MMMM, YYYY h:mm a").format("YYYY-MM-DD HH:mm:ss");
        endSessionDate = moment(enddate+" "+endtime, "DD MMMM, YYYY h:mm a").format("YYYY-MM-DD HH:mm:ss");
        if(name !== "" && startSessionDate !== "Invalid date" && endSessionDate !== "Invalid date" && numberallowed !== "" && eName !== "Open this select menu"){
          $.ajax({
            url:'http://serenity.ist.rit.edu/~dc6288/EMS/api/api.php?method=addSession',
            type: "POST",
            data: {name, startSessionDate, endSessionDate, numberallowed, eName},
            success: function(content){
              if(content == 1){
                $('#addSessionModal').modal('hide');
                $.confirm({
                  title: "Alert!",
                  content: "Add Successful!",
                  buttons: {
                    Ok: function(){
                      location.reload(true);
                    }
                  }
                });
              }
              else{
                $('#addSessionModal').modal('hide');
                $.alert({
                  title: "Alert!",
                  content: "Add Unsuccessful!",
                });
              }
            }
          });
        }
        else{
          $('#addSessionModal').modal('hide');
          $.alert({
            title: "Alert!",
            content: "Invalid Data. Add Unsuccessful!",
          })
        }
      });

      if(JSON.parse(content).length > 0){
          let htmlContent = $(`<table class="table table-hover">
        <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Start Date</th>
        <th scope="col">End Date</th>
        <th scope="col">Number Allowed</th>
        <th scope="col">Event Name</th>
        <th scope="col">Action</th>
        </tr>
        </thead><tbody>`);
        
        $.each(JSON.parse(content), function(index, obj){
          let myStartDate = moment(obj.startdate, "YYYY-MM-DD h:mm:ss").format("lll");
          let myEndDate = moment(obj.enddate, "YYYY-MM-DD h:mm:ss").format("lll");
          let mySession = $(
              `<tr>
              <th scope="row">${index+1}</th>
              <td sessionId="${obj.idsession}">${obj.name}</td>
              <td>${myStartDate}</td>
              <td>${myEndDate}</td>
              <td>${obj.numberallowed}</td>
              <td>${obj.event}</td>
              <td>
              <?php if($_SESSION['role'] == "admin" || $_SESSION['role'] == "event manager"){ ?>
              <button type="button" class="btn btn-primary edit-session">Edit</button>
              <button type="button" class="btn btn-danger delete-session">Delete</button>
              <?php } ?>
              </td>`);
          mySession.appendTo(htmlContent);
        });

        $("</tbody></table>").appendTo(htmlContent);
        htmlContent.appendTo("#sessions");

        $(".logout").click(function(){
          $.ajax({
            url:"http://serenity.ist.rit.edu/~dc6288/EMS/logout.php",
            success: function(content){
              if(content == "LoggedOut"){
                console.log("LOGGED OUT");
                window.location.href = "http://serenity.ist.rit.edu/~dc6288/EMS/login.php";
              }
            }
          });
        });
        
        let currentName, currentSD, currentED, currentNA, sessionId, eventName;
        $( ".edit-session" ).click(function() {
          $('#exampleModalCenter').modal('show'); 
          let tds = $(this).closest('tr').children('td');
          sessionId = tds[0].attributes.sessionId.value;
          currentName = tds[0].textContent;
          currentSD = tds[1].textContent;
          currentED = tds[2].textContent;
          currentNA = tds[3].textContent;
          eventName = tds[4].textContent;
          $("#inputName").val(currentName);
          $("#inputStartDate").val(currentSD);
          $("#inputEndDate").val(currentED);
          $("#inputNA").val(currentNA);
        });

        $(".save-change").click(function(){
          let name = $("#inputName").val();
          let startdate = $("#inputStartDate").val();
          let enddate = $("#inputEndDate").val();
          let numberallowed = $("#inputNA").val();
          if(!(name == currentName && startdate == currentSD && enddate == currentED && numberallowed == currentNA)){
            startdate = moment(startdate, "lll").format("YYYY-MM-DD hh:mm:ss");
            enddate = moment(enddate, "lll").format("YYYY-MM-DD hh:mm:ss");
            $.ajax({
              url:'http://serenity.ist.rit.edu/~dc6288/EMS/api/api.php?method=updateSession',
              type: "POST",
              data: {sessionId, name, startdate, enddate, numberallowed, eventName},
              success: function(content){
                if(content == 1){
                  $('#exampleModalCenter').modal('hide');
                  $.confirm({
                    title: 'Alert!',
                    content: 'Edit Successful!',
                    buttons: {
                        Ok: function () {
                            location.reload(true);
                        }
                    }
                  });
                }
                else{
                  $('#exampleModalCenter').modal('hide');
                  $.alert({
                      title: 'Alert!',
                      content: 'Edit Unsuccessful!',
                  });
                }
              }
            });
          }
          else{
            $('#exampleModalCenter').modal('hide');
            $.alert({
                title: 'Alert!',
                content: 'No Change in data',
            });
          }
        });

        $(".delete-session" ).click(function() { 
        let tds = $(this).closest('tr').children('td');
        let sessionId = tds[0].attributes.sessionId.value;
        $.confirm({
            title: 'Alert!',
            content: 'Do you really want to delete this session ?',
            buttons: {
              Confirm: function () {
                $.ajax({
                  url:'http://serenity.ist.rit.edu/~dc6288/EMS/api/api.php?method=deleteSession',
                  type: "POST",
                  data: {sessionId},
                  success: function(content){
                    if(content == 1){
                      $.confirm({
                        title: 'Alert!',
                        content: 'Delete Successful!',
                        buttons: {
                            Ok: function () {
                                location.reload(true);
                            }
                        }
                      });
                    }
                    else{
                      $.alert({
                        title: 'Alert!',
                        content: 'Delete Unsuccessful!',
                      });
                    }
                  }
                }); // Ajax close      
              } // Confirm close
            } //Buttons close
          });
        });
      }
      else{
        $(`<h2>No Sessions registered</h2>`).appendTo("#sessions");
      }
    }
  });
  </script>