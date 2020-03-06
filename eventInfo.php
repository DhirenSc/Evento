<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<link rel="stylesheet" type="text/css" href="navbar-top-fixed.css">

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
    </ul>
  </div>
</nav>

<div class="container">
  <div class="row justify-content-center" id="sessions"></div>
</div>

<script>
  $.ajax({
    url:'http://serenity.ist.rit.edu/~dc6288/EMS/api.php?method=getSessions&id='+<?php echo $_GET['id']?>,
    success: function(content){
      console.log(JSON.parse(content));
      let htmlContent = $(`<table class="table table-hover">
      <thead>
      <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Start Date</th>
      <th scope="col">End Date</th>
      <th scope="col">Number Allowed</th>
      </tr>
      </thead><tbody>`);
      $.each(JSON.parse(content), function(index, obj){
        let myStartDate = moment(obj.startdate, "YYYY-MM-DD h:mm:ss").format("lll");
        let myEndDate = moment(obj.enddate, "YYYY-MM-DD h:mm:ss").format("lll");
        let mySession = $(
            `<tr>
            <th scope="row">${index+1}</th>
            <td>${obj.name}</td>
            <td>${myStartDate}</td>
            <td>${myEndDate}</td>
            <td>${obj.numberallowed}</td>`);
        mySession.appendTo(htmlContent);
      });

      $("</tbody></table>").appendTo(htmlContent);
      htmlContent.appendTo("#sessions");
    }
  });
  </script>