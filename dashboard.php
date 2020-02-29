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
        <a class="nav-link" href="#">Events</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Registrations</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Attendees</a>
      </li>
    </ul>
  </div>
</nav>

<div class="container">
  <div class="row justify-content-center" id="events"></div>
</div>

  <script>
  $.ajax({
    url:'http://serenity.ist.rit.edu/~dc6288/Evento/api/getEvents',
    success: function(content){
      console.log(JSON.parse(content));
      $.each(JSON.parse(content), function(index, obj){
        let myCol = $(`<div class="col-md-3"></div>`);
        let myStartDate = moment(obj.datestart, "YYYY-MM-DD h:mm:ss").format("lll");
        let myEndDate = moment(obj.dateend, "YYYY-MM-DD h:mm:ss").format("lll");
        let myCard = $(`<div class="card">
            <img src="https://blogmedia.evbstatic.com/wp-content/uploads/wpmulti/sites/3/2016/12/16131147/future-phone-mobile-live-events-technology-trends.png" class="card-img-top" alt="#">
            <div class="card-body">
              <h5 class="card-title">${obj.name}</h5>
              <p class="card-text">${myStartDate} - ${myEndDate}</p>
              <p class="card-text">Venue - ${obj.venue}</p>
              <a href="#" class="btn btn-primary">Veiw Event</a>
            </div>
          </div>`);
        myCard.appendTo(myCol);
        myCol.appendTo('#events');
      });
    }
  })
  </script>

