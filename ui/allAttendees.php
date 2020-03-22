<?php session_start();
if(!isset($_SESSION['loggedIn'])){
  header("Location: ../login.php");
}
?>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/navbar-top-fixed.css">

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
      <li class="nav-item active">
        <a class="nav-link" href="allAttendees.php">Attendees</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="allVenues.php">Venues</a>
      </li>
      <?php }?>
      <li class="nav-item">
        <a class="nav-link" href="allSessions.php">Sessions</a>
      </li> 
    </ul>
    <button type="button" class="btn btn-primary logout">Logout</button>
  </div>
</nav>

<!--Edit User modal-->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Edit User</h5>
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
            <label for="inputPassword" class="col-sm-3 col-form-label">Password</label>
            <div class="col-sm-9">
                <input type="password" class="form-control" id="inputPassword">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputRole" class="col-sm-3 col-form-label">Role</label>
            <div class="col-sm-9">
              <select class="custom-select role-select">
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

<!--Add attendee modal-->
<div class="modal fade" id="addAttendeeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Add Attendee</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group row">
          <label for="inputAddAttendeeName" class="col-sm-3 col-form-label">Name</label>
          <div class="col-sm-9">
              <input type="text" class="form-control" id="inputAddAttendeeName" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="inputAddAttendeePassword" class="col-sm-3 col-form-label">Password</label>
          <div class="col-sm-9">
              <input type="password" class="form-control" id="inputAddAttendeePassword">
          </div>
        </div>
        <div class="form-group row">
          <label for="inputAddAttendeeRole" class="col-sm-3 col-form-label">Role</label>
          <div class="col-sm-9">
            <select class="custom-select role-add-attendee-select">
                <option selected disabled>Open this select menu</option>
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary add-attendee-modal-btn">Add</button>
      </div>
    </div>
  </div>
</div>

<div class="container attendee-container">
  <div class="row justify-content-center">
    <h2>Attendees</h2><br/>
  </div>
  <div class="row">
    <button type="button" class="btn btn-primary btn-block add-attendee">Add New Attendee</button>
  </div>
  <br/>
  <div class="row justify-content-center" id="users"></div>
</div>

<script>
  $.ajax({
    url:'http://serenity.ist.rit.edu/~dc6288/EMS/api/api.php?method=getUsers',
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

      $(".add-attendee" ).click(function() {
        $('#addAttendeeModal').modal('show'); 
        
        if($('.role-add-attendee-select option').length == 1){
          $.ajax({
              url:'http://serenity.ist.rit.edu/~dc6288/EMS/api/api.php?method=getRoles',
              success: function(content){
                $.each(JSON.parse(content), function(index, obj){
                let myOption = $(`<option value="${obj.name}" id="${obj.idrole}">${obj.name}</option>`);
                myOption.appendTo(".role-add-attendee-select");
                });
              }
          });
        }
      });

      $(".add-attendee-modal-btn").click(function(){
        let name = $("#inputAddAttendeeName").val();
        let password = $("#inputAddAttendeePassword").val();
        let role = $(".role-add-attendee-select").children("option:selected").val();
        if(name !== "" && role !== "Open this select menu" && password !== ""){
          $.ajax({
            url:'http://serenity.ist.rit.edu/~dc6288/EMS/api/api.php?method=addUser',
            type: "POST",
            data: {name, password, role},
            success: function(content){
              if(content == 1){
                  $('#addAttendeeModal').modal('hide');
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
                  $('#addAttendeeModal').modal('hide');
                  $.alert({
                      title: 'Alert!',
                      content: 'Edit Unsuccessful!',
                  });
              }
            }
          });
        }
        else{
          $('#addAttendeeModal').modal('hide');
          $.alert({
              title: 'Alert!',
              content: 'No Change in data',
          });
        }
      });
      
      let htmlContent = $(`<table class="table table-hover">
      <thead>
      <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Role</th>
      <th scope="col">Action</th>
      </tr>
      </thead><tbody>`);
      
      $.each(JSON.parse(content), function(index, obj){
        let myUser = $(
            `<tr>
            <th scope="row">${index+1}</th>
            <td userId="${obj.idattendee}">${obj.name}</td>
            <td>${obj.role}</td>
            <td>
            <button type="button" class="btn btn-primary edit-user">Edit</button>
            <button type="button" class="btn btn-danger delete-user">Delete</button>
            </td>`);
        myUser.appendTo(htmlContent);
      });
      $("</tbody></table>").appendTo(htmlContent);
      htmlContent.appendTo("#users");

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
      
      let currentName, currentRole, attendeeId, currentPassword;
      $(".edit-user" ).click(function() {
          $('#exampleModalCenter').modal('show'); 
          let tds = $(this).closest('tr').children('td');
          attendeeId = tds[0].attributes.userId.value;
          currentName = tds[0].textContent;
          currentRole = tds[1].textContent;
          currentPassword = "";
          $("#inputName").val(currentName);
          $("#inputPassword").val(currentPassword);
          $("#inputRole").val(currentRole);
          if($('.role-select option').length == 1){
            $.ajax({
                url:'http://serenity.ist.rit.edu/~dc6288/EMS/api/api.php?method=getRoles',
                success: function(content){
                    $.each(JSON.parse(content), function(index, obj){
                    let myOption;
                    if(currentRole == obj.name){
                        myOption = $(`<option selected value="${obj.name}" id="${obj.idrole}">${obj.name}</option>`)
                    }
                    else{
                        myOption = $(`<option value="${obj.name}" id="${obj.idrole}">${obj.name}</option>`);
                    }
                    myOption.appendTo(".role-select");
                    });
                }
            });
        }
        });

      $(".save-change").click(function(){
        let name = $("#inputName").val();
        let password = $("#inputPassword").val();
        let role = $(".role-select").children("option:selected").val();
        if(!(name == currentName && role == currentRole && password == currentPassword)){
            $.ajax({
            url:'http://serenity.ist.rit.edu/~dc6288/EMS/api/api.php?method=updateUser',
            type: "POST",
            data: {attendeeId, name, password, role},
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

      $(".delete-user" ).click(function() { 
          let tds = $(this).closest('tr').children('td');
          let attendeeId = tds[0].attributes.userId.value;
          $.confirm({
              title: 'Alert!',
              content: 'Do you really want to delete this user ?',
              buttons: {
                  Confirm: function () {
                    $.ajax({
                        url:'http://serenity.ist.rit.edu/~dc6288/EMS/api/api.php?method=deleteUser',
                        type: "POST",
                        data: {attendeeId},
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
                                    content: "Delete Unsuccessful! Maybe you don't have the rights to delete it",
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