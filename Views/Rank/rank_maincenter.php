<?php use Projet_Web_parcours\Assets\settings\Settings;?>
<?php 
echo'

      <div class="row ">
      <div class="col-12 grid-margin style="margin-bottom: 0; overflow: auto; height: 400px;">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">'.$nomParcour.'</h4>
            <p class="card-description">
            </p>
            <div class="table-responsive">
              <table class="table table-striped">
              <ul class="navbar-nav" >
              <li class="nav-item">
                <form class="nav-link mt-2 mt-md-0 d-lg-flex search">
                  <input type="text" id="searchbar" class="form-control" placeholder="Search parcour">
                </form>
              </li>
            </ul>
                <thead>
                  <tr>
                    <th> Image </th>
                    <th> Joueur </th>
                    <th> Temps </th>
                    <th> Date </th>
                  </tr>
                </thead>
                <tbody id="list">
                ';
                foreach($rankBox as $rank){
                    echo'                  
                    <tr>
                      <td class="py-1">
                        <img src="'.Settings::RACINE.'Assets/Images/faces/'.$rank->user['avatar'].'"/>
                        
                      </td>
                      <td> '.$rank->user["username"].' </td>
                      <td>';
                        if(intval(($rank->compare)/60) == 0){
                          echo strval(($rank->compare)%60).' sec </td>';
                      }elseif((($rank->compare)%60) == 0){
                        echo strval(($rank->compare)%60).' sec </td>';
                      }else{
                        echo strval(intval(($rank->compare)/60)).' min et '.strval(($rank->compare)%60).' sec </td>';
                      }
                      echo '
                      <td>'.$rank->date.'</td>
                    </tr>';
                }
                echo'
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      </div>';
?>