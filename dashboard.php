<?php session_start();
if(!isset($_SESSION['loggedIn'])){
  header("Location: login.php");
}
?>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<link rel="stylesheet" type="text/css" href="navbar-top-fixed.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
  <a class="navbar-brand" href="#">Evento</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarCollapse">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
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
      <li class="nav-item">
        <a class="nav-link" href="allSessions.php">Sessions</a>
      </li>
      <button type="button" class="btn btn-primary logout">Logout</button> 
    </ul>
  </div>
</nav>

<!--Edit event modal-->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Edit Event</h5>
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
            <label for="inputNA" class="col-sm-3 col-form-label">No. Allowed</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="inputNA">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputVenue" class="col-sm-3 col-form-label">Venue</label>
            <div class="col-sm-9">
            <select class="custom-select venue-select">
              <option selected disabled>Open this select menu</option>
            </select>
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
<div class="container">
  <div class="row justify-content-center" id="events"></div>
</div>

  <script>
  $.ajax({
    url:'http://serenity.ist.rit.edu/~dc6288/EMS/api.php?method=getEvents<?php if($_SESSION['role'] != "admin"){echo "&username=".$_SESSION['username'];} ?>',
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
      if(JSON.parse(content).length > 0){
        $.each(JSON.parse(content), function(index, obj){
        let myCol = $(`<div class="col-md-4 myCard" index="${index}"></div>`);
        let myStartDate = moment(obj.datestart, "YYYY-MM-DD hh:mm:ss").format("lll");
        let myEndDate = moment(obj.dateend, "YYYY-MM-DD hh:mm:ss").format("lll");
        let myCard = $(`<div class="card">
            <img src="https://blogmedia.evbstatic.com/wp-content/uploads/wpmulti/sites/3/2016/12/16131147/future-phone-mobile-live-events-technology-trends.png" class="card-img-top" alt="#">
            <div class="card-body">
              <h5 class="card-title" eventId="${obj.idevent}">${obj.name}</h5>
              <p class="card-text">${myStartDate} - ${myEndDate}</p>
              <p class="card-text">Number Allowed - ${obj.numberallowed}</p>
              <p class="card-text">Venue - ${obj.venue}</p>
              <div class="btn-group btn-block justify-content-center" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-info view-event">View</button>
                <?php if($_SESSION['role'] == "admin"){ ?> 
                <button type="button" class="btn btn-primary edit-event">Edit</button>
                <button type="button" class="btn btn-danger delete-event">Delete</button>
                <?php }?>
              </div>
            </div>
          </div>`);
        myCard.appendTo(myCol);
        myCol.appendTo('#events');
      });
      $(".view-event").click(function(){
        let myEvent = $(this).closest('.myCard');
        let eventIndex = myEvent[0].attributes.index.value;
        let eventData = JSON.parse(content)[eventIndex];
        eventId = eventData['idevent'];
        window.location.href = "http://serenity.ist.rit.edu/~dc6288/EMS/eventInfo.php?id="+eventId;
      });
      let currentName, currentSD, currentED, currentNA, eventId, venueName;
      $(".edit-event").click(function() {
        let myEvent = $(this).closest('.myCard');
        let eventIndex = myEvent[0].attributes.index.value;
        let eventData = JSON.parse(content)[eventIndex];
        $('#exampleModalCenter').modal('show');
        eventId = eventData['idevent'];
        currentName = eventData['name'];
        currentSD = moment(eventData['datestart'], "YYYY-MM-DD hh:mm:ss").format("lll");
        currentED = moment(eventData['dateend'], "YYYY-MM-DD hh:mm:ss").format("lll");
        currentNA = eventData['numberallowed'];
        venueName = eventData['venue'];
        $("#inputName").val(currentName);
        $("#inputStartDate").val(currentSD);
        $("#inputEndDate").val(currentED);
        $("#inputNA").val(currentNA);
        if($('.venue-select option').length == 1){
          $.ajax({
            url:'http://serenity.ist.rit.edu/~dc6288/EMS/api.php?method=getVenues',
            success: function(content){
              $.each(JSON.parse(content), function(index, obj){
                let myOption;
                if(eventData['venue'] == obj.name){
                  myOption = $(`<option selected value="${obj.name}" id="${obj.idvenue}">${obj.name}</option>`)
                }
                else{
                  myOption = $(`<option value="${obj.name}" id="${obj.idvenue}">${obj.name}</option>`);
                }
                myOption.appendTo(".venue-select");
              });
            }
          });
        }
      });

      $('.save-change').click(function(){
        let name = $("#inputName").val();
        let startdate = $("#inputStartDate").val();
        let enddate = $("#inputEndDate").val();
        let numberallowed = $("#inputNA").val();
        let vName = $(".venue-select").children("option:selected").val();
        if(!(name == currentName && startdate == currentSD && enddate == currentED && numberallowed == currentNA && vName == venueName)){
          startdate = moment(startdate, "lll").format("YYYY-MM-DD hh:mm:ss");
          enddate = moment(enddate, "lll").format("YYYY-MM-DD hh:mm:ss");
          $.ajax({
            url:'http://serenity.ist.rit.edu/~dc6288/EMS/api.php?method=updateEvent',
            type: "POST",
            data: {eventId, name, startdate, enddate, numberallowed, vName},
            success: function(content){
              if(content == 1){
                $('#exampleModalCenter').modal('hide');
                $.confirm({
                  title: "Alert!",
                  content: "Edit Successful!",
                  buttons: {
                    Ok: function(){
                      location.reload(true);
                    }
                  }
                });
              }
              else{
                $('#exampleModalCenter').modal('hide');
                $.alert({
                  title: "Alert!",
                  content: "Edit Unsuccessful!",
                });
              }
            }
          });
        }
        else{
          $('#exampleModalCenter').modal('hide');
          $.alert({
            title: "Alert!",
            content: "No Change in data",
          })
        }
      });

      $(".delete-event").click(function(){
        let myEvent = $(this).closest('.myCard');
        let eventIndex = myEvent[0].attributes.index.value;
        let eventData = JSON.parse(content)[eventIndex];
        let eventId = eventData['idevent'];
        $.confirm({
          title: "Alert!",
          content: 'Do you really want to delete this event ? Its related sessions will also be deleted.',
          buttons: {
            Confirm: function() {
              $.ajax({
                url: 'http://serenity.ist.rit.edu/~dc6288/EMS/api.php?method=deleteEvent',
                type: "POST",
                data: {eventId},
                success: function(content){
                  if(content == 1){
                    $.confirm({
                      title: "Alert!",
                      content: "Delete Successful!",
                      buttons: {
                        Ok: function(){
                          location.reload(true);
                        }
                      }
                    });
                  }
                  else{
                    $.alert({
                      title: 'Alert!',
                      content: 'Delete Unsuccessful!',
                    })
                  }
                }
              });
            }
          }
        })
      });
      }
      else{
        $(`<h2>No Events registered</h2>`).appendTo("#events");
      }
    }
  });
  </script>

