
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
    <div class="col">
        <div class="card">
            <div class="card-body" id="player-pool">
            <h5 class="card-title">Player's</h5>
            <ul class="list-group" id="player-pool">
            <?php foreach($data['pool'] as $key => $val ){ ?>
              <li class='list-group-item' data-player-rank-id ='<?php echo $val['id']?>'><b><?php echo $val['name'] ?></li>
            <?php } ?>
            </ul>
            </div>
        </div>
    </div>
  </div>
</div>
<button type="button" class="btn btn-primary" id="Start-Game" data-player-id = "<?php echo $data['me']['id']?>">Start Game</button>
<button type="button" class="btn btn-primary" id="send-message">Send Message</button> 
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>    
<script type="text/javascript">
var conn = new WebSocket('ws://localhost:8083');
var global_id = "<?php echo $data['me']['id']?>";
var session_name = "";
conn.onopen = function(e) {
  console.log("Connection established!");
  getActiveSession();

};

conn.onmessage = function(e) {
  if(e.data =='start'){
    var id = $(this).attr('data-player-id');
    window.location.replace("gamestart?id="+global_id+'&session='+session_name);
  }else if(e.data =='refresh'){
    console.log('pasok refresh');
    refreshPlayerPool();
    
  }
};
// event for button game start
$("#Start-Game").on('click',function(){
  startGame();
    // subscribe(subcriber_name);
});
// event for button send message
$("#send-message").on('click',function(){
    sendMessage('testmessageferdz');
});
function refreshPlayerPool()
{
  $('#player-pool').html('');
  $.ajax({
        url: 'refreshPlayerPool',
        type: 'get',
        dataType: 'json',
        success: function(data){
          var html = '';
          for(var i =0; i < data.length; i++){
            html += "<li class='list-group-item' data-player-rank-id ='"+data[i].id+"'><b>"+data[i].name+"</li>";
          }
          console.log(html);
          $('#player-pool').append(html);
        }
    });
}

function startGame()
{
  console.log('startgmae');
    $.ajax({
        url: 'startSessionGame',
        type: 'get',
        dataType: 'json',
        success: function(data){
          sendMessage('start');
          window.location.replace ("gamestart?id="+global_id+'&session='+session_name);
        }
    });
}
function subscribe(channel) 
{
    conn.send(JSON.stringify({command: "subscribe", channel: channel}));
}

function getActiveSession() { 
    $.ajax({
        url: 'getActiveSession/',
        type: 'GET',
        dataType: 'json',
        success: function(data){
          session_name = data.session_name;
          subscribe(data.session_name);
          sendMessage('refresh');
         
        }
    });
}
function sendMessage(msg) {
  console.log('sendmessage');
  console.log(msg);
  conn.send(JSON.stringify({command: "message", message: msg}));
}

</script>
