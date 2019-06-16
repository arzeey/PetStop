<?php
// Require some essential files
require("php/config.php");
$data = include("php/filter.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Petstop Home</title>
  <link rel="shortcut icon" href="img/logo.png">
  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
</head>

<!-- Body Start -->
<body>
  <!-- Top Nav -->
  <nav class="orange darken-4" role="navigation">
    <div class="nav-wrapper container "><a id="logo-container" href="index.php" alt="Petstop Logo" class="brand-logo"><img width="30px" src="img/logo.png" alt=""></a>
    <h5 class="left"><b>PET</b>STOP</h5>
      <ul class="right hide-on-med-and-down">
        <li class="flow-text">Your one stop to a perfect <b class="cyan-text text-lighten-3">life companion</b></li>
      </ul>
      <!-- Side Nav Mobile -->
      <div id="nav-mobile" class="sidenav searchnav">
          <h4 class="header orange-text">Search</h4>
          <form id="search_form" action="index.php" method="POST">
              <div>
                  <input list="pet_name" id="search_input" name="search" type="text" class="validate" placeholder="Pet Name" autocomplete="off">
                  <datalist id="pet_name">
                    <?php 
                      foreach($data as $name){
                        if($name != ''){
                          echo "<option value='$name'>$name</option>";
                        }
                      }
                    ?>
                  </datalist>
                  <!-- Submit Button -->
                  <button class="btn waves-effect waves-light btn-large center-align" type="submit" name="submit" value="search">Apply Filter/Search
                  </button>
                        
              </div>
                  <?php
                    $result=$conn->query("SELECT DISTINCT animal_type FROM tbl_pets");
                    $rows=$result->rowCount();
                    if($rows>=1){
                      echo '<h5 class="cyan-text">Animal Type</h5>';
                      while($row=$result->fetch(PDO::FETCH_ASSOC)){
                        echo '<label>
                                <input type="checkbox" name="type[]" value="'.$row["animal_type"].'" />
                                <span>'.$row["animal_type"].'</span>
                              </label><br>';
                      }
                    }

                    $result=$conn->query("SELECT DISTINCT animal_gender FROM tbl_pets");
                    $rows=$result->rowCount();
                    if($rows>=1){
                      echo '<h5 class="cyan-text">Gender</h5>';
                      while($row=$result->fetch(PDO::FETCH_ASSOC)){
                        echo '<label>
                                <input type="checkbox" name="gender[]" value="'.$row["animal_gender"].'" />
                                <span>'.$row["animal_gender"].'</span>
                              </label><br>';
                      }
                    }

                    $result=$conn->query("SELECT DISTINCT animal_color FROM tbl_pets");
                    $rows=$result->rowCount();
                    if($rows>=1){
                      echo '<h5 class="cyan-text">Color</h5>';
                      while($row=$result->fetch(PDO::FETCH_ASSOC)){
                        echo '<label>
                                <input type="checkbox" name="color[]" value="'.$row["animal_color"].'" />
                                <span>'.$row["animal_color"].'</span>
                              </label><br>';
                      }
                    }
                  ?>
              </form>
      </div>
      <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
    </div>
  </nav>

  <!-- Petstop Content Start -->
  <section>
    <div class="container">
      <div class="row">
        <!-- Side Navigation -->
        <div class="col hide-on-med-and-down l3 xl3">
            <div >
              <h3 class="header orange-text">Search</h3>
              <form id="search_form" action="index.php" method="POST">
              <div class="input-field">
                  <input list="pet_name" id="search_input" type="text" class="validate" autocomplete="off">
                  <label for="search_input">Pet Name</label>
                  <!-- Submit Button -->
                  <button class="btn waves-effect waves-light btn-large center-align" type="submit" name="submit" value="search">Apply Filter/Search
                  </button>
                        
              </div>
                  <?php
                    $result=$conn->query("SELECT DISTINCT animal_type FROM tbl_pets");
                    $rows=$result->rowCount();
                    if($rows>=1){
                      echo '<h5 class="cyan-text">Animal Type</h5>';
                      while($row=$result->fetch(PDO::FETCH_ASSOC)){
                        echo '<label>
                                <input type="checkbox" name="type[]" value="'.$row["animal_type"].'" />
                                <span>'.$row["animal_type"].'</span>
                              </label><br>';
                      }
                    }

                    $result=$conn->query("SELECT DISTINCT animal_gender FROM tbl_pets");
                    $rows=$result->rowCount();
                    if($rows>=1){
                      echo '<h5 class="cyan-text">Gender</h5>';
                      while($row=$result->fetch(PDO::FETCH_ASSOC)){
                        echo '<label>
                                <input type="checkbox" name="gender[]" value="'.$row["animal_gender"].'" />
                                <span>'.$row["animal_gender"].'</span>
                              </label><br>';
                      }
                    }

                    $result=$conn->query("SELECT DISTINCT animal_color FROM tbl_pets");
                    $rows=$result->rowCount();
                    if($rows>=1){
                      echo '<h5 class="cyan-text">Color</h5>';
                      while($row=$result->fetch(PDO::FETCH_ASSOC)){
                        echo '<label>
                                <input type="checkbox" name="color[]" value="'.$row["animal_color"].'" />
                                <span>'.$row["animal_color"].'</span>
                              </label><br>';
                      }
                    }
                  ?>
              </form>
            </div>
        </div>
        <!-- Pet Content Here -->
        <div class="col s12 m12 l9 xl9">
          <h3 class="header orange-text">Companions for Life.</h3>
          <!-- Animal Content goes here -->
          <div class="row animals">
            <!-- Animal cards -->
            
            <?php
              // Listen for some queries in the URL
              $search = "";
              if(isset($_POST["submit"])){
                // Check if filter includes animal_type
                if(isset($_POST["type"])){
                  // Assign type to array
                  $type = $_POST["type"];
                  // Iterate through array
                  foreach($type as $animal_type){
                    // Add OR if the search query isn't empty
                    if($search != ""){
                      $search = $search.' AND  ';

                    }
                    // Sanitize for SQL Injection
                    $animal_type = filter_var($animal_type, FILTER_SANITIZE_SPECIAL_CHARS);
                    $search = $search."animal_type = '$animal_type'";
                  }
                }
                if(isset($_POST["gender"])){
                  $gender = $_POST["gender"];
                  foreach($gender as $animal_gender){
                    if($search != ""){
                      $search = $search.' AND ';

                    }
                    $animal_gender = filter_var($animal_gender, FILTER_SANITIZE_SPECIAL_CHARS);
                    $search = $search."animal_gender = '$animal_gender'";
                  }
                }
                if(isset($_POST["color"])){
                  $color = $_POST["color"];
                  foreach($color as $animal_color){
                    if($search != ""){
                      $search = $search.' AND ';

                    }
                    $animal_color = filter_var($animal_color, FILTER_SANITIZE_SPECIAL_CHARS);
                    $search = $search."animal_color = '$animal_color'";
                  }
                }
              }
              $query = "";
              // If search isn't empty
              if($search != ""){
                $query = "SELECT * FROM tbl_pets WHERE $search";
              }else{
                $query = "SELECT * FROM tbl_pets";
              }

              // Search for the filtered values or show all the values
              $result=$conn->query($query);
              $rows=$result->rowCount();
              if($rows>=1){
                // If search isn't empty
                if($search != ""){
                  echo "<h5 class='search_val'>Your search returned $rows results</h5>";
                }else{
                  echo "<h5 class='search_val'>$rows total adorable pets, ready for a new home</h5>";
                }
                // Display the animal cards
                while($row=$result->fetch(PDO::FETCH_ASSOC)){
                  $name = $row["animal_name"]? $row["animal_name"] : $row["animal_type"];
                  echo '<div class="col s12 m4 l4 xl3">
                          <div class="card hoverable">
                            <div class="card-image waves-effect waves-block waves-light">
                              <div class="bg_img activator" style="background: url(\''.$row["animal_img"].'\');"></div>
                            </div>
                            <div class="card-content">
                              <span class="card-title activator grey-text text-darken-4">'.$name.'<i class="material-icons right">more_vert</i></span>
                              <p>'.$row["animal_breed"].'</p>
                            </div>
                            <div class="card-reveal">
                              <span class="card-title grey-text text-darken-4">Meet you new companion!<i class="material-icons right">close</i></span>
                              <p>Name/Type: '.$name.'</p>
                              <p>Breed: '.$row["animal_breed"].'</p>
                              <p>Color: '.$row["animal_color"].'</p>
                              <p>Address: '.$row["animal_address"].'</p>
                            </div>
                          </div>      
                        </div>';
                }
              }else{
                echo "<h4 class='search_val'>No results to display</h4>";
              }
            ?>

          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer Start -->
  <footer class="page-footer white-text orange darken-2">
    <div class="container">
      <div class="row">
        <div class="col l6 s12">
          <h5>PetStop - Your one stop shop to a life companion</h5>
          <p>Made by Christian Alec R. Gariando</p>


        </div>
        <div class="col l3 s12">
          <h5>Visit my socials</h5>
          <ul>
            <li><a class="orange-text text-lighten-4" target='_blank' href="https://www.facebook.com/statiickz">Facebook</a></li>
            <li><a class="orange-text text-lighten-4" target='_blank' href="https://www.instagram.com/_renz.c/?hl=en">Instagram</a></li>
            <li><a class="orange-text text-lighten-4" target='_blank' href="https://www.linkedin.com/in/cgariando/">LinkedIn</a></li>
          </ul>
        </div>
        <div class="col l3 s12">
          <h5>References</h5>
          <ul>
            <li><a class="orange-text text-lighten-4" target='_blank' href="https://cataas.com">Cat Picture Generator</a></li>
            <li><a class="orange-text text-lighten-4" target='_blank' href="http://www.placepuppy.net/">Dog Picture Generator</a></li>
            <li><a class="orange-text text-lighten-4" target='_blank' href="https://docs.google.com/spreadsheets/d/1AIRtFr5rwZNALvOXQuouEqm-gsGU0zCAdtpna9Qx9Lw/edit#gid=1221594390">Pet Dataset - Provided by Google</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="footer-copyright">
      <div class="container">
        <div class="row">
          <div class="col s12 m6 l6 xl6">
          <div>Template made by <a class="orange-text text-lighten-3" href="http://materializecss.com">Materialize</a></div>
          <div>Icons made by <a class="orange-text text-lighten-4" href="https://www.freepik.com/" title="Freepik">Freepik</a> from <a class="orange-text text-lighten-4" href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a> is licensed by <a class="orange-text text-lighten-4" href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>
          </div>
        </div>
      
      
      </div>
    </div>
  </footer>


  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>

  </body>
</html>

<!-- Ajax Scripts -->

<script>
$(document).on("keyup", "#search_input", function() {
  var bar = $(this).val();
  $(".animals").html('');
  if(bar!=''){
    $.ajax({
    url:"php/filter.php?value=name&search="+bar,
      success:function(results){
        $(".animals").html(results);
      }
    });
  }else{
    $.ajax({
    url:"php/filter.php?value=name",
      success:function(results){
        $(".animals").html(results);
      }
    });
  }
});
$(document).ready(function(){
  
});
</script>