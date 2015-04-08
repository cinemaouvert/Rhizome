<?php $app->render('header.php', array('path' => $path, 'app' => $app)); // load ui ?>
<div id="additional-info">
        <div class="row">
            <div class="large-12 columns">
                <h2 class="color-white headings text-center">Cinema Open Data Base - Administration</h2>
            </div>
        </div>
    </div>
    <div id="features">
        <div class="row">
            <div class="large-6 large-centered columns">
                <div id="sign-up">
                    <form method="post">
                        <h3 class="color-pink">Votre administration</h3>
                        <hr />
                        <label>Login</label>
                        <input name="login" type="text" />
                        <label>Mot de passe</label>
                        <input name="password" type="password" />
                        <button class="blue-btn">SE CONNECTER</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="why">
        <div class="row">
            <div class="large-12 columns">
                <h2 class="text-center color-pink headings">C'est quoi le Cinema Open Data Base ?</h2>
            </div>

            <div class="row">
                <div class="large-12 columns">
                    <h5 class="color-black" style="text-align:justify; line-height: 27px;">Le CODB est une base de données de stockages d'informations relatives à des oeuvres audiovisuelles.
                    Le but est de fournir une architecture décentralisée et simple d'accès aux détenteurs de droits, aux diffuseurs et enthousiastes pour répertorier les informations relatives à des oeuvres audiovisuelles sous licence libre ou indépendantes.</h5>            
                </div>
            </div>

            <br /><br /><br />

            <div class="large-4 columns" style="padding: 0px;">
                <div class="why-item border-right border-bottom">
                    <div class="glyph-icon flaticon-gift7" style="color:rgb(8, 161, 181);"></div>
                    <h4>Gratuit</h4>
                    <div>
                        Le Cinema Open Data Base - Depot est gratuit. <br /><br /><br />
                    </div>
                </div>
            </div>
            <div class="large-4 columns" style="padding: 0px;">
                <div class="why-item  border-right border-bottom">
                    <div class="glyph-icon flaticon-tray2" style="color:rgb(23, 199, 85);"></div>
                    <h4>Initié et maintenu</h4>
                    <div>
                        Vous pouvez soutenir l'association Catalogue Ouvert du Cinéma afin qu'elle puisse continuer leurs actions.
                    </div>
                    
                </div>
            </div>
            <div class="large-4 columns" style="padding: 0px;">
                <div class="why-item border-bottom ">
                    <div class="glyph-icon flaticon-boat5"></div>
                    <h4>Ouvert</h4>
                    <div>
                        Vous pouvez apporter votre aide dans le développement du CODB via GitHub. <br /><br />
                    </div>
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