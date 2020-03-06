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
<link rel="stylesheet" type="text/css" href="navbar-top-fixed.css">

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
      <li class="nav-item active">
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

<!--Edit Venue modal-->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Edit Venue</h5>
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
            <label for="inputCapacity" class="col-sm-3 col-form-label">Capacity</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="inputCapacity">
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
  <div class="row justify-content-center" id="venues"></div>
</div>

<script>
  $.ajax({
    url:'http://serenity.ist.rit.edu/~dc6288/EMS/api.php?method=getVenues',
    success: function(content){
      console.log(JSON.parse(content));
      
      let htmlContent = $(`<table class="table table-hover">
      <thead>
      <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Capacity</th>
      <th scope="col">Action</th>
      </tr>
      </thead><tbody>`);
      
      $.each(JSON.parse(content), function(index, obj){
        let myVenue = $(
            `<tr>
            <th scope="row">${index+1}</th>
            <td venueId="${obj.idvenue}">${obj.name}</td>
            <td>${obj.capacity}</td>
            <td>
            <button type="button" class="btn btn-primary edit-venue">Edit</button>
            <button type="button" class="btn btn-danger delete-venue">Delete</button>
            </td>`);
        myVenue.appendTo(htmlContent);
      });

      $("</tbody></table>").appendTo(htmlContent);
      htmlContent.appendTo("#venues");

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
      
      let currentName, currentCapacity, venueId;
      $( ".edit-venue" ).click(function() {
          $('#exampleModalCenter').modal('show'); 
          let tds = $(this).closest('tr').children('td');
          venueId = tds[0].attributes.venueId.value;
          currentName = tds[0].textContent;
          currentCapacity = tds[1].textContent;
          $("#inputName").val(currentName);
          $("#inputCapacity").val(currentCapacity);
      });

      $(".save-change").click(function(){
        let name = $("#inputName").val();
        let capacity = $("#inputCapacity").val();
        if(!(name == currentName && capacity == currentCapacity)){
            $.ajax({
            url:'http://serenity.ist.rit.edu/~dc6288/EMS/api.php?method=updateVenue',
            type: "POST",
            data: {venueId, name, capacity},
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

      $(".delete-venue" ).click(function() { 
          let tds = $(this).closest('tr').children('td');
          let venueId = tds[0].attributes.venueId.value;
          $.confirm({
              title: 'Alert!',
              content: 'Do you really want to delete this venue ?',
              buttons: {
                  Confirm: function () {
                    $.ajax({
                        url:'http://serenity.ist.rit.edu/~dc6288/EMS/api.php?method=deleteVenue',
                        type: "POST",
                        data: {venueId},
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
                                    content: 'Delete Unsuccessful! First delete the event associated with this venue and then try deleting it',
                                });
                            }
                        }
                    }); // Ajax close      
                  } // Confirm close
                } //Buttons close
            });
      });
    }
  });
  </script>