# Rallye Lecture
### Travail réalisé en PPE, 2ème année de BTS SIO


## Le contexte du Rallye Lecture

## Code Igniter


## La base de données
Le projet nécessite le stockage de nombreuses informations (livres, auteurs, utilisateurs...).
Pour réaliser la base de données, nous utiliserons le SGBDR MySQL. Celle-ci sera accessible en localhost.
La base de données s'organise comme ceci :<br>
![diagrammeBDD_1](https://github.com/VirgileJallonPeriaux/PPE_RallyeLecture/blob/master/CapturesEcran/wkbRallyeLecture.PNG)


## La bibliothèque Aauth
Disponible [ici](https://github.com/emreakay/CodeIgniter-Aauth), la bibliothèque **Aauth** permet la gestion des autorisations des utilisateurs.
Celle-ci est destinée à simplifier les opérations telles que la gestion des permissions, la création d'utilisateurs...
Au delà de ces fonctionnalités assez simples, la bibliothèque propose aussi des fonctionnalités un peu plus avancées comme la gestion de groupes et l'envoi de messages privés entre utilisateurs.
Le bon fonctionnement de cette bibliothèque nécessite la création de tables supplémentaires dans la base de données du projet RallyeLecture.
L'execution du script (SQL) de création, fourni avec la bibliothèque, crée les tables suivantes :<br>
![diagrammeBDD_2](https://github.com/VirgileJallonPeriaux/PPE_RallyeLecture/blob/master/CapturesEcran/wkbRallyeLecture_2.PNG)
