<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
  // Continue in the page if the session is active
}

else {
    $_SESSION['loggedin'] = false;
    $_SESSION['username'] = "";
    $_SESSION['sdv_ip'] = "";
    echo "Inicia Sesion para acceder a este contenido.<br>";
    echo "<br><a href='login.html'>Login</a>";
    echo "<br><br><a href='index.html'>Registrarme</a>";
    header('Location: login.php');
    exit;
}

$now = time();

if($now > $_SESSION['expire']) {
    session_destroy();
    header('Location: login.html');
    echo "Tu sesion a expirado, <a href='login.html'>Inicia Sesion</a>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<title>SDV UN: Navegación</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<script src="libs/easeljs.js"></script>
<script src="libs/eventemitter2.min.js"></script>
<script src="libs/roslib.js"></script>
<script src="libs/nav2d.js"></script>
<script src="libs/ros2d.js"></script>
<script src="libs/keyboardteleop.js"></script>
<script src="libs/jquery.min.js"></script>
<script src="libs/jquery.animate-colors-min.js"></script>
<script src="libs/animation.js"></script>

<link rel="stylesheet" href="ui/icon.css">
<link rel="stylesheet" href="ui/w3-theme-black.css">
<link rel="stylesheet" href="ui/Roboto.css">
<link rel="stylesheet" href="ui/font-awesome.min.css">
<link rel="stylesheet" href="ui/w3.css">
<link rel="stylesheet" href="ui/w3-theme-black.css">
<link rel="stylesheet" href="ui/Roboto.css">

<link href="favicon.ico" rel="icon" type="image/x-icon" />


<style>
html,body,h1,h2,h3,h4,h5,h6 {font-family: "Roboto", sans-serif;}
.w3-sidebar {
  z-index: 3;
  width: 250px;
  top: 43px;
  bottom: 0;
  height: inherit;
}
</style>

<!-- Body -->
<body onload="init()">

<!-- Navbar -->
<div class="w3-top">
  <div class="w3-bar w3-theme w3-top w3-left-align w3-large">
    <a class="w3-bar-item w3-button w3-right w3-hide-large w3-hover-white w3-large" href="javascript:void(0)" onclick="w3_open()"><i class="fa fa-bars"></i></a>
    <a id="emergency_stop_button" class="w3-bar-item w3-button w3-right w3-hover-orange">Parar</a>
    <a href="index.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">SDV UN</a>
    <a href="map_view.php" class="w3-bar-item w3-button w3-theme-l1" id="user_login"></a>
    <a href="help.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Ayuda</a>
  </div>
</div>

<!-- Sidebar -->
<nav class="w3-sidebar w3-bar-block w3-collapse w3-large w3-theme-l5 w3-animate-left" id="mySidebar">
    <a href="javascript:void(0)" onclick="w3_close()" class="w3-right w3-xlarge w3-padding-large w3-hover-black w3-hide-large" title="Close Menu">
    <i class="fa fa-remove"></i>
    </a>
    <h4 class="w3-bar-item"><b>Menu</b></h4>
    <a class="w3-bar-item w3-button w3-hover-black" href="login.php" id="user_login_sidebar">Acceder</a>
    <a class="w3-bar-item w3-button w3-hover-black" href="help.php" id="help_sidebar">Ayuda</a>
    <!-- Here is the Close Session link, that is only visible when there is a session opened -->
</nav>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- Main content: shift it to the right by 250 pixels when the sidebar is visible -->
<div class="w3-main" style="margin-left:250px">

  <!-- Page title-->
  <div class="w3-container" style="margin-top:50px">
    <div class="w3-twothird w3-container">
      <h3 class="w3-text-teal">Navegación por el Laboratorio</h3>
    </div>
  </div>

  <!-- Row of elements: This divdistributes the elements in 2/3 and 1/3 spaces-->
  <div class="w3-row">

    <!-- Map, log and bottom view buttons-->
    <div class="w3-twothird w3-container " style="margin-bottom:16px">
      <div id="card-map" class="w3-card-4">
        <div id="map"></div>
      </div>
      <!-- Feedback zone of conection events-->
      <div id="feedback_div">
        <p id=feedback>Esperando conexión</p>
      </div>
      <!-- Zoom and shift buttons of the map-->
      <div class="w3-bar">        
        <button class="w3-bar-item w3-button w3-teal" id="zoom_in" onclick="zoomInMap()">
          <i class="material-icons">zoom_in</i>
        </button>
        <button class="w3-bar-item w3-button w3-teal" id="zoom_out" onclick="zoomOutMap()">
          <i class="material-icons">zoom_out</i>
        </button>
        <button class="w3-bar-item w3-button w3-teal" id="shift_up" onclick="shiftUpMap()">
          <i class="material-icons">arrow_upward</i>
        </button>
        <button class="w3-bar-item w3-button w3-teal" id="shift_down" onclick="shiftDownMap()">
          <i class="material-icons">arrow_downward</i>
        </button>
        <button class="w3-bar-item w3-button w3-teal" id="shift_left" onclick="shiftLeftMap()">
          <i class="material-icons">arrow_back</i>
        </button>
        <button class="w3-bar-item w3-button w3-teal" id="shift_right" onclick="shiftRightMap()">
          <i class="material-icons">arrow_forward</i>
        </button>
      </div>
    
    <!-- TwoThird Container end -->
    </div>

    <!-- Information and comand buttons-->
    <div class="w3-third w3-container">

      <!-- Actual Location Panel-->
      <fieldset id="pred_location" style="margin-bottom:16px">
          <legend>Posición actual del SDV</legend>
          <div id="actual_loc"></div>
      </fieldset>

      <!-- Predefined Location Panel-->
      <fieldset id="pred_location" style="margin-bottom:16px">
        <legend>Enviar SDV a posición predefinida</legend>
        <div class="controlgroup">
          <select id="location_select">
              <option value=1>Celda Industrial</option>
              <option value=2>Celda de Prototipado</option>
              <option value=3>Celda Experimental</option>
              <option value=4>Home</option>
              <option value=5>Centro de estudio</option>
          </select>
          <button id="send_selected_location" type="button">Enviar</button>
        </div>
      </fieldset>

      <!-- User Defined Location Panel -->      
      <fieldset id="user_location" style="margin-bottom:16px">
        <legend>SDV a posición distinta</legend>
        <table>
          <tr>
            <td>X: </td>
            <td>
              <input id="x_position" type="text" size="5"><br>
            </td>
          </tr>
          <tr>
            <td>Y: </td>
            <td>
                <input id="y_position" type="text" size="5"><br>
            </td>
          </tr>
          <tr>
            <td>W: </td>
            <td>
                <input id="w_orientation" type="text" size="5"><br>
            </td>
          </tr>
          <tr>
            <td></td>
            <td>
                <button id="send_user_defined_location" type="button">Enviar</button>
            </td>
          </tr>
        </table>

      </fieldset>
      
      <!-- Manual Operation Panel -->
      <fieldset id="manual_operation" style="margin-bottom:16px">
        <legend>Operación manual por teclado</legend>
        <table>
          <tr>
            <td></td>
            <td><button id="key_up"><i class="material-icons">arrow_upward</i></button></td>
            <td></td>
          </tr>
          <tr>
            <td><button id="key_left"><i class="material-icons">arrow_back</i></td>
            <td><button id="key_down"><i class="material-icons">arrow_downward</i></td>
            <td><button id="key_right"><i class="material-icons">arrow_forward</i></td>
          </tr>
        </table>
        <input type="checkbox" id="teleop_enable" value="true">Activar teleoperación<br>
      </fieldset>

    <!-- Third Container End-->
    </div>

  <!-- Row End-->
  </div>

  <!-- Footer: this place contains the UNAL logo and name of the department-->
  <footer id="Footer">
    <div class="w3-container w3-theme-l2 w3-padding-16 ">
        <img src="unal_logo_white.png" width=150/>
    </div>

    <div class="w3-container w3-theme-l1 w3-padding-8">
      <p>Departamento de ingeniería mecánica y mecatrónica</p>
    </div>
  </footer>

<!-- END MAIN -->
</div>

<!--/////////////////////////////////////////////////////////////////////////-->
<!-- JAVASCRIPT Code-->
<script>

////////////////////////////////////////////////////////////////////////////////
// GUI and animations

// Get the Sidebar
var mySidebar = document.getElementById("mySidebar");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidebar, and add overlay effect
function w3_open() {
  if (mySidebar.style.display === 'block') {
    mySidebar.style.display = 'none';
    overlayBg.style.display = "none";
  } else {
    mySidebar.style.display = 'block';
    overlayBg.style.display = "block";
  }
}

// Close the sidebar with the close button
function w3_close() {
  mySidebar.style.display = "none";
  overlayBg.style.display = "none";
}

////////////////////////////////////////////////////////////////////////////////
// ROS Map Navigation

var viewer;
var zoomSteps = 0;
var verticalShiftSteps = 0;
var horizontalShiftSteps = 0;
var conectionStatus = 0; // 0: no intentado, 1: exitosa, 2: erronea
var sdv_ip = "";

// Zoom-in the map
function zoomInMap(){
  viewer.scene.scaleX *= 1.1
  viewer.scene.scaleY *= 1.1
  zoomSteps += 1
}

// Zoom-out the map
function zoomOutMap(){
  viewer.scene.scaleX *= (1/1.1);
  viewer.scene.scaleY *= (1/1.1);
  zoomSteps += -1;
}

// Shift up the map
function shiftUpMap(){
  viewer.shift(0, -1);
  verticalShiftSteps += -1;
}

// Shift down the map
function shiftDownMap(){
  viewer.shift(0, 1);
  verticalShiftSteps += 1;
}

// Shift right the map
function shiftRightMap(){
  viewer.shift(-1, 0);
  horizontalShiftSteps += -1;
}

// Shift left the map
function shiftLeftMap(){
  viewer.shift(1, 0);
  horizontalShiftSteps += 1;
}

/*
  This function contains all the ROS functions used in this page. These functions 
  only works if the page has been loaded.
*/
function init() {
    
    // Verify if some session is active and change the link and name of the login link
    var loggedin = "<?php echo $_SESSION['loggedin']; ?>";
    if (loggedin == "1") {
        $("#user_login").text("<?php echo $_SESSION['username']; ?>");
        $("#user_login").attr("href", "map_view.php");
        $("#user_login_sidebar").text("<?php echo $_SESSION['username']; ?>");
        $("#user_login_sidebar").attr("href", "map_view.php");
        $("#help_sidebar").after('<a class="w3-bar-item w3-button w3-hover-black" href="logout.php">Cerrar Sesión</a>');
    } else {
        $("#user_login").text("Acceder");
    }

  //////////////////////////////////////////////////////////////////////////////
  // ROS Conection

  // Loading sdv_ip from PHP session variable
  sdv_ip = "<?php echo $_SESSION['sdv_ip']; ?>";

  // Object that manages the ROS Websocket Server Comunication
  var rbServer = new ROSLIB.Ros({
      url : 'ws://' + sdv_ip + ':9090'
  });
  
  // Function that is invoked when the ROSBridge connection is successful
  rbServer.on('connection', function() {
      // Writes a message in the feedback place.
      $("#feedback").text ("Conectado al servidor websocket del SDV");
      conectionStatus = 1;
  });

  // Function that is invoked when the ROSBridge connection is incorrect
  rbServer.on('error', function(error) {
      // Writes a message in the feedback place.
      $("#feedback").text("Error en la conexión con el servidor websocket del SDV");
      conectionStatus = 2;
      redAlert("#feedback" , false);
  });

  // Function that is invoked when the ROSBridge connection was closed
  rbServer.on('close', function() {
    if(conectionStatus == 1){
      // Writes a message in the feedback place.
      $("#feedback").text("Conexión cerrada");
    }
    });

  //////////////////////////////////////////////////////////////////////////////
  // ROS Map View

  /* 
  viewer: Object that contains the map, loaded from the SDV. Is placed in the
  map div (html document)
  */

  var w = document.getElementById("map").offsetWidth;
  viewer = new ROS2D.Viewer({
      divID : 'map',
      width : w,
      height : w,
      background : '#ffffff',
      continuous : true
  });
  
  /* 
  nav: Navigation object, placed in the viewer object. This object draws the 
  map and the SDV in the actual location.
  */
  var nav = NAV2D.OccupancyGridClientNav({
      ros : rbServer,
      rootObject : viewer.scene,
      viewer : viewer,
      serverName : '/move_base',
      //serverName : '/sdvun3/move_base',
      withOrientation : true,
      // topic (optional) - the map topic to listen to
      //topic : "/sdvun3/map",
  });


  //////////////////////////////////////////////////////////////////////////////
  // Emergency Stop Button

  /*
  cancelTopic: it creates a topic object as roslibjs defines. This topic allows
  cancel the last comand sent to the SDV.
  */
  var cancelTopic = new ROSLIB.Topic({
      ros : rbServer,
      name : '/move_base/cancel',
      //name : '/sdvun3/move_base/cancel',
      messageType : 'actionlib_msgs/GoalID'
  });

  /*
  pubCancelMessage: this function sends the canceltopic messages. This function
  have to be invoked whe the Emergency Stop Button is clicked.
  */
  function pubCancelMessage(){
    var msg = new ROSLIB.Message({
      stamp : {
        secs : 0,
        nsecs : 0
      },
      id : ""
    });
    cancelTopic.publish(msg);
  }

  // CSS style for Emergency Stop Button.
  $("a#emergency_stop_button").css("background-color","#FF0000");

  // Bindind the Emergency Stop Button with pubCancelMessage function.
  $("a#emergency_stop_button").click(pubCancelMessage);

  //////////////////////////////////////////////////////////////////////////////
  // Predefined Location Panel

  /*
  send2locationTopic: it creates a topic object as roslibjs defines. This object
  sends 'geometry_msgs/PoseStamped' that indicates to the SDV where to go.
  */
  var send2locationTopic = new ROSLIB.Topic({
      ros : rbServer,
      name : '/move_base_simple/goal',
      //name : '/sdvun3/move_base_simple/goal',
      messageType : 'geometry_msgs/PoseStamped'
  });

  /*
  poseStamped: this object contains the PoseStamped message structure. All the 
  values are equal to zero. To use this message, it is necesary to set the correct
  values.
  */
  var poseStamped = new ROSLIB.Message({
    header : {
      seq : 0,
      stamp : {
        secs : 0,
        nsecs : 0
      },
      frame_id : 'map'
    },
    pose : {
      position : {
          x : 0.0,
          y : 0.0,
          z : 0.0
      },
      orientation : {
          x : 0.0,
          y : 0.0,
          z : 0.0
      }
    }
  });

  /*
  pubLocationFromSelectedItem: this function:
    - Takes the selected item from "location_selected"
    - Configure the values according to the selected item
    - Publish the message in send2locationTopic.
  */
  function pubLocationFromSelectedItem() {

    // Text from the selected item
    var e = document.getElementById("location_select");
    var selectedItem = e.options[e.selectedIndex].text;

    // Sets the values of position and orientation
    switch(selectedItem){
      case "Celda Experimental":
        poseStamped.pose.position.x = 0.8
        poseStamped.pose.position.y = 5.8
        poseStamped.pose.orientation.z = 0.0
        poseStamped.pose.orientation.w = 0.1
        break
      case "Celda de Prototipado":
        poseStamped.pose.position.x = 0.7067
        poseStamped.pose.position.y = -2.9218
        poseStamped.pose.orientation.z = 0.69
        poseStamped.pose.orientation.w = 0.715
        break
      case "Celda Industrial":
        poseStamped.pose.position.x = 6.76584243774
        poseStamped.pose.position.y = 3.13956570625
        poseStamped.pose.orientation.z = 1.0
        poseStamped.pose.orientation.w = 0.0
        break
      case "Home":
        poseStamped.pose.position.x = 0
        poseStamped.pose.position.y = 0
        poseStamped.pose.orientation.z = 0.0
        poseStamped.pose.orientation.w = 1.0
        break
      case "Centro de estudio":
        poseStamped.pose.position.x = 2.68
        poseStamped.pose.position.y = 2.99
        poseStamped.pose.orientation.z = 0.0
        poseStamped.pose.orientation.w = 0.999
        break
      default:
    }

    // Publish the message.
    send2locationTopic.publish(poseStamped);
  }

  /*
  Bindind the "pubLocationFromSelectedItem" function with "send_selected_location"
  button.
  */
  $("button#send_selected_location").click(pubLocationFromSelectedItem);

  //////////////////////////////////////////////////////////////////////////////
  // User Defined Location Panel

  /*
    pubMessageFromInput: This function:
      - Takes values of inputs
      - Verifies if these values are correct
      - Sends the message
  */
  function pubMessageFromInput() {

    // Reading the values
    var x = parseFloat($("input#x_position").val());
    var y = parseFloat($("input#y_position").val());
    var w = parseFloat($("input#w_orientation").val());
    
    // Checking values
    if(isNaN(x) || isNaN(y) || isNaN(w)){
      // Alert Animation in the button
      redAlert("button#send_user_defined_location", true);
      // Return if at least one value is NaN
      return;
    }

    // Setting Values
    poseStamped.pose.position.x = x;
    poseStamped.pose.position.y = y;
    poseStamped.pose.orientation.z = 0.0;
    poseStamped.pose.orientation.w = w;

    // Publish the message.
    send2locationTopic.publish(poseStamped);
  }

  /*
  Bindind the "pubMessageFromInput" function with "send_user_defined_location"
  button.
  */
  $("button#send_user_defined_location").click(pubMessageFromInput);

  //////////////////////////////////////////////////////////////////////////////
  // Actual Location Panel

  /*
  actualLocationTopic: it creates a topic object as roslibjs defines. This object
  sends manages ''
  */
  var actualLocationTopic = new ROSLIB.Topic({
      ros : rbServer,
      //name : '/odom',
      //name : '/sdvun3/scanmatch_odom',
      name : '/scanmatch_odom',
      messageType : 'nav_msgs/Odometry'
  });

  // Subscribes the object for listening to the topic.
  actualLocationTopic.subscribe(function(message) {
    var jsonX = JSON.parse(JSON.stringify(message))
    var x = jsonX["pose"]["pose"]["position"]["x"];
    var y = jsonX["pose"]["pose"]["position"]["y"];
    var z = jsonX["pose"]["pose"]["position"]["z"];
    var w = jsonX["pose"]["pose"]["orientation"]["w"];

    var text = "";
    text += "X: " + x.toFixed(2) + "\n";
    text += "Y: " + y.toFixed(2) + "\n";
    text += "Z: " + z.toFixed(2) + "\n";
    text += "W: " + w.toFixed(2) + "\n";

    $("div#actual_loc").text(text);
  });

  //////////////////////////////////////////////////////////////////////////////
  // Keyboard Teleop

  /*
  teleop: This object captures pressed keys and sends geometry_msgs/Twist. Also,
  detects pressed buttons, and generate the same events that a pressed key.
  */
  var teleop  = new KEYBOARDTELEOP.Teleop({
    ros : rbServer,
    //topic : '/turtle1/cmd_vel'
    topic : '/cmd_vel_mux/input/teleop',
    keyUp : document.getElementById("key_up"),
    keyDown : document.getElementById("key_down"),
    keyLeft : document.getElementById("key_left"),
    keyRight : document.getElementById("key_right"),
  });
  teleop.scale = 0.5;
  teleop.enable = $("#teleop_enable").is(":checked");

  // Binding event to the checkbox
  $("#teleop_enable").change(function(){
    teleop.enable = $(this).is(":checked");
  });



// Fin de init
}

</script>

</body>
</html>