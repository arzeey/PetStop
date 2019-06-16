<?php
require("config.php");

if(isset($_GET["value"])){
    if($_GET["value"]=="name" && isset($_GET["search"])){
        $pet_name = $_GET["search"];
        $search = $conn->query("SELECT * FROM tbl_pets WHERE animal_name LIKE '$pet_name%'");
        $rows=$search->rowCount();
              if($rows>=1){
                while($row=$search->fetch(PDO::FETCH_ASSOC)){
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
                  echo "<h4>No results to display</h4>";
              }

        /* Fetch all of the values of the first column */
        $result = $search->fetchAll(PDO::FETCH_COLUMN, 0);
        $result = array_values($result);
        echo json_encode($result);
    }else{
        $search = $conn->query("SELECT * FROM tbl_pets");
        $rows=$search->rowCount();
              if($rows>=1){
                while($row=$search->fetch(PDO::FETCH_ASSOC)){
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
              }
    }
}else{
    // Default response
    $search = $conn->prepare("SELECT animal_name FROM tbl_pets");
    $search->execute();

    /* Fetch all of the values of the first column */
    $result = $search->fetchAll(PDO::FETCH_COLUMN, 0);
    $result = array_values($result);
    return $result;
}

?>