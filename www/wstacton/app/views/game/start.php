
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Signin Template · Bootstrap v5.0</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <meta name="theme-color" content="#7952b3">

    </head>
<body class="text-center">
<div class="container">
  <div class="row align-items-start">
  <p id="game-duration"></p>
    <div class="col">
        <div class="card" style="height:400px">
          <div class="card-header">
            Players Ranking
          </div>
          <div class="overflow-auto">
            <ul class="list-group" id="player-points">
              <?php foreach($data['ranking'] as $key => $val){ ?>
                <li class="list-group-item curse" data-player-rank-id ="<?php echo $val['id']?>" data-bs-toggle="modal" data-bs-target="#exampleModal"><b><?php echo $val['name'] ?></b> -> <b>Points:</b> <?php echo $val['points']?>
               </li>
              <?php } ?>
            </ul>
          </div>
        </div>
    </div>
    <div class="col">
        <div class="card" style="height:400px">
          <div class="card-header">
            Events
          </div>
          <div class="card-body">
            <div class="overflow-auto">
              <ul class="list-group" id="player-transaction">
                <?php foreach($data['transaction'] as $key => $val){ ?>
                  <li class="list-group-item"><b>Player: <?php echo $val['player'] ?> - Event: <?php echo $val['description'] ?>
                </li>
                <?php } ?>
              </ul>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>
<button type="button" class="btn btn-primary" id="gain-points" data-player-id = "<?php echo $data['player']['id']?>">Gain Points</button>
</body>
</html>
<!----modal for points deduction---->
<div class="modal" id="exampleModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Curse Player</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to use curse?.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary" id="confirm">Yes </button>
      </div>
    </div>
  </div>
</div>
<!----end modal for points deduction---->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>    
<script type="text/javascript">
var conn = new WebSocket('ws://localhost:8083');
var global_id = "<?php echo $_GET['id']?>";
var global_channel = '';
var countDown = "<?php echo $data['ranking'][0]['gamestart_time']?>";
var curse_id = 0;
conn.onopen = function(e) {
  console.log("Connection established!");
  getPlayerSession();
};

conn.onmessage = function(e) {
  if(e.data == 'reload'){
    reloadPoints();
    reloadTransaction();
  }
};

$("#send-message").on('click',function(){
    sendMessage('testmessageferdz');
});

$("#gain-points").on('click',function(){
    gainPoints();
});

$(".curse").on('click',function(){
  var id = $(this).attr('data-player-rank-id');
  curse_id = id;
});
$("#confirm").on('click',function(){
  cursePlayer();
  $('#exampleModal').modal('hide');
});

function getPlayerSession()
{
    $.ajax({
        url: 'getPlayerSession/',
        data:'id='+global_id,
        type: 'GET',
        dataType: 'json',
        success: function(data){
          global_channel = data.session_name
          subscribe(data.session_name);
        }
    });
}
function reloadTransaction()
{

  $.ajax({
        url: 'reLoadTransaction',
        data:'session='+global_channel,
        type: 'GET',
        dataType: 'json',
        beforeSend: function(){
          $('#player-transaction').empty();
        },
        success: function(data){
          subscribe(data.session_name);
          var html = '';
          console.log(data);
          for(var i =0; i < data.length; i++){
              html +="<li class='list-group-item'><b>Events: "+ data[i].description;
          
          }
          $('#player-transaction').append(html);
        }
    });
}

function reloadPoints()
{

  $.ajax({
        url: 'reloadPoints',
        data:'session='+global_channel,
        type: 'GET',
        dataType: 'json',
        beforeSend: function(){
          $('#player-points').empty();
        },
        success: function(data){
          subscribe(data.session_name);
          var html = '';
          console.log(data);
          for(var i =0; i < data.length; i++){
              html +="<li class='list-group-item curse' data-player-rank-id ="+ data[i].id+"><b>"+ data[i].name+"</b> -> <b>Points:</b> "+ data[i].points;
          
          }
          $('#player-points').append(html);
        }
    });
}
function gainPoints()
{
  $.ajax({
        url: 'gainPoints',
        data:'id='+global_id,
        type: 'POST',
        dataType: 'json',
        success: function(data){
          alert(data);
          sendMessage('reload');
          reloadPoints();
        }
    });
}
function cursePlayer()
{
  $.ajax({
        url: 'cursePlayer',
        data:'id='+curse_id+'&curser_id='+global_id,
        type: 'POST',
        dataType: 'json',
        success: function(data){
          alert(data);
          sendMessage('reload');
          reloadPoints();
        }
    });
}
function subscribe(channel) 
{
    conn.send(JSON.stringify({command: "subscribe", channel: channel}));
    global_channel = channel;
}

function sendMessage(msg) {
  console.log('sendmessage');
  console.log(msg);
  console.log(global_channel)
    conn.send(JSON.stringify({command: "message", message: msg,channel:global_channel}));
}

// Set the date we're counting down to
var countDownDate = new Date(countDown).getTime()+600000;

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();
    
  // Find the distance between now and the count down date
  var distance = countDownDate - now;
    
  // Time calculations for days, hours, minutes and seconds
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
  // Output the result in an element with id="demo"
  document.getElementById("game-duration").innerHTML = 'Game Duration: '+minutes + "m " + seconds + "s ";
    
  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(x);
    window.location.replace("gameend?session="+global_channel);
  }
}, 1000);
</script>
