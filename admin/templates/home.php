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
                    <div class="glyph-icon flaticon-ball8" style="color:rgb(8, 161, 181);"></div>
                    <h6 class="text-center">Liste des depots connectés</h6>
                </div>
            </div>
            <div class="large-6 medium-6 small-6 columns">
                <div class="featured-item">
                    <div class="glyph-icon flaticon-speech7" style="color:rgb(23, 199, 85);"></div>
                    <h6 class="text-center">Information sur le depot</h6>
                </div>
            </div>
            
        </div>

        <br />

        <div class="row">
            <div class="large-4 columns">
                <div id="sign-up">
                    <form method="post" action="<?= $app->urlFor('depot_add'); ?>">
                        <h3 class="color-pink">Ajouter un depot</h3>
                        <hr />
                        <label>Nom du depot (nom unique)</label>
                        <input name="depot_name" type="text" />
                        <label>Adresse http du depot</label>
                        <input name="depot_host" type="text" />
                        <button class="blue-btn">AJOUTER</button>
                    </form>
                </div>
                <br />
            </div>

            <div class="large-8 columns">
                <div id="sign-up">
                    <h3 class="color-pink">Liste des depots connectés</h3>
                    <hr />
                    <table>
                      <thead>
                        <tr>
                          <th>Nom</th>
                          <th>Adresse du depot</th>
                          <th>Supprimer</th>
                          <th>Editer</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                    <?php 
                    foreach ($resolver_list as $key => $value) {
                        echo '<tr><td>'.$key.'</td> <td>'.$value.'</td> <td style="text-align:center"><a href="">X</a></td> <td style="text-align:center"><a href="">X</a></td></tr>';
                    } 
                    ?>
                        
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    

    
    <footer>
        <div class="row text-center">
            <div class="large-12 columns">
                <a href="" >Supporté par le Catalogue Ouvert du Cinéma</a>
            </div>
        </div>
    </footer>
<?php $app->render('footer.php', array('path' => $path, 'app' => $app)); // load ui ?>