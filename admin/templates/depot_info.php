<?php $app->render('header.php', array('path' => $path, 'app' => $app)); // load ui ?>
<div id="additional-info">
        <div class="row">
            <div class="large-6 columns">
                <h4 class="color-white headings" style=" margin-top:-1.2rem; margin-bottom:1.5rem;">Open Rhizome Deposit - Administration</h2>
                
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
                    <a href="<?= $app->urlFor('dashboard_depot_info'); ?>">
                        <div class="glyph-icon flaticon-speech7" style="color:rgb(23, 199, 85);"></div>
                        <h6 class="text-center">Information / Option sur le depot</h6>
                    </a>
                </div>
            </div>
            <div class="large-6 medium-6 small-6 columns">
                <div class="featured-item">
                    <a href="<?= $app->urlFor('dashboard'); ?>">
                        <div class="glyph-icon flaticon-ball8" style="color:rgb(8, 161, 181);"></div>
                        <h6 class="text-center">Liste des depots connectés</h6>
                    </a>
                </div>
            </div>
        </div>

        <br />

        <div class="row">
            <div class="large-4 columns">
                <div id="sign-up">
                    <h3 class="color-pink">Clé d'accés</h3>
                    <hr />
                    <form method="post" action="<?= $app->urlFor('access_add'); ?>">
                        <label>Clé utilisateur (Clé unique)</label>
                        <input name="key_user" type="text" />
                        <label>Clé d'accés (Clé unique)</label>
                        <input name="key_access" type="text" value="<?= uniqid('',true);?>"/>
                        <button class="blue-btn">AJOUTER - MODIFIER</button>
                    </form>
                </div>
                <br />
                <div class="panel radius">
                  <h5>Mode ouvert / fermé.</h5>
                  <p>Le mode ouvert / fermé permet de filtrer les utilisateurs en écriture dans votre codb-depot. En mode ouvert tous
                    le monde peut ajouter des ressources. Si vous voulez seuleument autoriser certaines personnes à écriré dans votre codb-depot passer
                    le en mode fermé. Il vous suffit alors d'associer la clé utilisateur de la personne choisi avec une clé d'accés. Puis de lui transmettre cette derniere.
                    Il pourra alors écrire dans votre codb-depot.</p>
                </div>
            </div>
            <div class="large-8 columns">
                <div id="sign-up">
                    <h3 class="color-pink">Information sur le depot</h3>
                    <hr />
                    Adresse du depot : <b><?= $depot['DEPOT']['local']; ?></b> <br /><br />
                    Le depot est en mode : 
                    <?php if($depot['OPTION']['open'] == 1){
                        echo 'ouvert <a href="'.$app->urlFor('access_change').'">( Passer le depot en mode fermé ) </a>';
                    }else echo 'fermé <a href="'.$app->urlFor('access_change').'">( Passer le depot en mode ouvert )</a>';
                       
                    ?>
                    <br /><br />
                    Votre depot est en version : <?= $depot['VERSION']['DESCRIPTION']['version']; ?>
                    <br /><br />
                    Nombre de ressource disponible sur le depot :  <?= count(glob('depot/*/*.json')); ?> <br />
                    Nombre de ressource "Attachment" sur le depot :  <?= count(glob('depot/attachment/*.json')); ?> <br />
                    Nombre de ressource "Movie" sur le depot :  <?= count(glob('depot/movie/*.json')); ?> <br />
                    Nombre de ressource "Organisation" sur le depot :  <?= count(glob('depot/organisation/*.json')); ?> <br />
                    Nombre de ressource "People" sur le depot :  <?= count(glob('depot/people/*.json')); ?> <br />
                </div>
                <br />
                <div id="sign-up">
                    <h3 class="color-pink">Liste clés utilisateurs / clés d'accés</h3>
                    <hr />
                    
                    <?php if($access_list == null){
                        echo ' <center>Aucun clé ajouté</center>';
                    }else{
                        echo'
                        
                        <table>
                          <thead>
                            <tr>
                              <th>Clé utilisateur</th>
                              <th>Clé d\'accés</th>
                              <th>Supprimer la clé</th>
                            </tr>
                          </thead>
                          <tbody>';
                        foreach ($access_list as $key => $value) {
                            echo '<tr><td>'.$key.'</td> <td>'.$value.'</td> <td style="text-align:center"><a href="access/'.$key.'">X</a></td></tr>';
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