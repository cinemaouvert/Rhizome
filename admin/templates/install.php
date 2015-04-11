<?php $app->render('header.php', array('path' => $path, 'app' => $app)); // load ui ?>
<div id="additional-info">
        <div class="row">
            <div class="large-12 columns">
                <h2 class="color-white headings text-center">Cinema Open Data Base - Administration</h2>
            </div>
        </div>
    </div>
    

    <div id="why">
        <div class="row">
            <div class="large-12 columns">
                <h2 class="text-center color-pink headings">Installation 1/2</h2>
            </div>
            <div class="row">
                <div class="large-12 columns">
                    <h5 class="color-black" style="text-align:center; line-height: 27px;">
                        Remplissez ce formulaire qui va se charger de créer la configuration de votre codb.
                    </h5>            
                </div>
            </div>
        </div>
    </div>

    <div id="features">
        <div class="row">
            <div class="large-6 large-centered columns">
                <div id="sign-up">
                    <form method="post" action="<?= $app->urlFor('install_done'); ?>">
                        <h3 class="color-pink">Votre administration</h3>
                        <hr />
                        <label>Login de votre administration</label>
                        <input name="login" type="text" />
                        <label>Mot de passe de votre administration</label>
                        <input name="password" type="password" />
                        <button class="blue-btn">LANCER L'INSTALLATION</button>
                    </form>
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