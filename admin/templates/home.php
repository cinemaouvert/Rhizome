<?php $app->render('header.php', array('path' => $path, 'app' => $app)); // load ui ?>
<div id="additional-info">
        <div class="row">
            <div class="large-6 columns">
                <h4 class="color-white headings" style=" margin-top:-1.2rem; margin-bottom:1.5rem;">Cinema Open Data Base - Administration</h2>
                
            </div>
            <div class="large-3 columns">
                <div class=" headings" style=" margin-top:-0.9rem; margin-bottom:1.5rem; text-align:right"><a href="<?= $app->urlFor('logout'); ?>" class="color-white"> Se deconnecter</a></div> 
                
            </div>
        </div>
    </div>

    <div id="features">

        <div class="row">
            <div class="large-6 medium-6 small-6 columns">
                <div class="featured-item">
                    <a href="<?= $app->urlFor('dashboard'); ?>">
                        <div class="glyph-icon flaticon-ball8" style="color:rgb(8, 161, 181);"></div>
                        <h6 class="text-center">Liste des depots connectés</h6>
                    </a>
                </div>
            </div>
            <div class="large-6 medium-6 small-6 columns">
                <div class="featured-item">
                    <a href="<?= $app->urlFor('dashboard_depot_info'); ?>">
                        <div class="glyph-icon flaticon-speech7" style="color:rgb(23, 199, 85);"></div>
                        <h6 class="text-center">Information  / Option sur le depot</h6>
                    </a>
                </div>
            </div>
            
        </div>

        <br />

        <div class="row">
            <div class="large-4 columns">
                <div id="sign-up">
                    <form method="post" action="<?= $app->urlFor('depot_add'); ?>">
                        <h3 class="color-pink">Depots</h3>
                        <hr />
                        <label>Nom du depot (nom unique)</label>
                        <input name="depot_name" type="text" />
                        <label>Adresse http du depot</label>
                        <input name="depot_host" type="text" />
                        <button class="blue-btn">AJOUTER - MODIFIER</button>
                    </form>
                </div>
                <br />
            </div>

            <div class="large-8 columns">
                <div id="sign-up">
                    <h3 class="color-pink">Liste des depots connectés</h3>
                    <hr />
                    <?php 
                    if($resolver_list == null){
                        echo '<center>Aucun depot connectés</center>';
                    }else{
                        echo'<table>
                          <thead>
                            <tr>
                              <th>Nom</th>
                              <th>Adresse du depot</th>
                              <th>Supprimer</th>
                            </tr>
                          </thead>
                          <tbody>';
                            
                        
                        foreach ($resolver_list as $key => $value) {
                            echo '<tr><td>'.$key.'</td> <td>'.$value.'</td> <td style="text-align:center"><a href="resolver/'.$key.'">X</a></td></tr>';
                        } 
                        
                            
                        echo'</tbody>
                        </table>';
                    }
                    
                    ?>
                </div>
            </div>
        </div>
    </div>

    

    
    <footer>
        <div class="row text-center">
            <div class="large-12 columns">
                <a href="http://cinemaouvert.fr/" >Supporté par le Catalogue Ouvert du Cinéma</a>
            </div>
        </div>
    </footer>
<?php $app->render('footer.php', array('path' => $path, 'app' => $app)); // load ui ?>