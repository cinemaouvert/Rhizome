# Rhizome

Qu'est ce que Open Rhizome Deposit ? 
---------------------

Open Rhizome Deposit dit "Rhizome" est une base de données de stockage d'informations relatives à des oeuvres audiovisuelles. Le but est de fournir une architecture décentralisée et simple d'accès aux détenteurs de droits, aux diffuseurs et enthousiastes pour répertorier les informations relatives à des oeuvres audiovisuelles sous licence libre ou indépendantes.

Installation :

Copier/coller Rhizome dans votre dossier ftp. Vérifier vos autorisations chmod. Si vous avez un problème.
Rendez vous via votre navigateur http://adresse.depot/config/ pour valider l'installation de votre dépôt Rhizome.

Pour ajouter des films vous pouvez soit, installer le client codb https://github.com/cinemaouvert/Cinema-Open-Data-Base/releases/tag/0.1. Soit passer par notre interface via http://catalogue.cinemaouvert.fr/#!/


L'api ce decomposse de cette maniere :

Pour appeler une ressource sur Rhizome, il faut passer par un appel http ( GET, POST, PUT, DELETE).

Certaines informations sont requis pour pouvoir modifier une ressource, pour en supprimer, ou bien pour en ajouter.

Informations relatifs à l'utisateur.
La clé utilisateur : _api_key_user : C'est l'identifiant d'un utilisateur.
Clé signature utilisateur : _api_key_password : C'est la signature d'un utilisateur. Cette information ne doit jamais être publique.

Information relatifs au depot Rhizome.
Il existe actuellement deux etats principal pour un depot rhizome. 
Il est peut être soit, en mode ouvert, et bénéficier de l'ajout de toutes personnes souhaitant contribuer.
Ou bien il peut etre, en mode fermé, dans ce cas, seul les utilisateurs avec un clé de depot, peuvent contribuer.

Clé du depot : _api_key_access : C'est la clé d'accés fournit par le depot attaché à _api_key_user.


Rhyzome fonctionne comme un systeme d'api :

Les fonctions disponibles via l'api de Rhyzome sont nombreuses. Elle sont decouper en section.

Fonction à propos du depot:
Les fonctions depot, sont relatif au information sur le depot.
GET			/depot/                           // affiche information du depot.
GET			/depot/version/                   // affiche version du depot.
GET			/depot/option/                    // affiche option du depot.
GET			/depot/resolver/                  // affiche tous les depots qui sont connecté à ce depot.
GET			/depot/resource/:resource/        // affiche les champs d'une ressource.

Fonction à propos de écho :
Les fonctions écho sont relative au fichier attaché à des ressources. Qui sont considéré comme des ressources spécial.
GET			/echo/attachment/id/:id/           // Genere une resource attachment par rapport à son id.

Fonction à propos de résolver:
Les fonctions du résolver sont relative au contenu du depot, et des depots qui sont connecté au depot principal.
GET			/resolver/:resource/     								// affiche  les 20 dernieres ressource d'un type du resolver
GET			/resolver/:resource/o/:p_index_first/:p_index_last     	// affiche les ressources d'un type du resolver via un offset
GET			/resolver/:resource/key/:key/             		  		// affiche toutes les ressource d'un type par clé utilisateur du resolver


Fonction à propos de resource :
GET			/resource/:resource/             		 			   	  	// affiche une liste de ressource du depot (20 dernieres ressource)
GET			/resource/:resource/o/:p_index_first/:p_index_last       	// affiche une liste de ressource du depot via un offset ( écart de 20 maximum )
GET			/resource/:resource/key/:key/       	 			        // affiche une liste de ressource sur le depot via une clé utilisateur
GET			/resource/:resource/id/:id/             			  	    // affiche une resource sur le depot via son id
GET			/resource/:resource/history/id/:id          	            // affiche une resource sur le depot via son id AVEC l'historique d'édition
GET			/resource/:resource/search/:search/:value                   // affiche une liste de resource via une recherche sur le depot
POST		/resource/:resource/             		 			   	  	// ajouter une ressource dans le depot
PUT			/resource/:resource/id/:id              		 	   	  	// editer une ressource dans le depot
DELETE		/resource/:resource/id/:id              		 	  	  	// supprimer une ressource dans le depot
=======
>>>>>>> origin/master
>>>>>>> Stashed changes
