-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour cinema
CREATE DATABASE IF NOT EXISTS `cinema` /*!40100 DEFAULT CHARACTER SET latin1 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `cinema`;

-- Listage de la structure de table cinema. acteur
CREATE TABLE IF NOT EXISTS `acteur` (
  `id_acteur` int NOT NULL AUTO_INCREMENT,
  `id_personne` int NOT NULL,
  PRIMARY KEY (`id_acteur`),
  UNIQUE KEY `id_personne` (`id_personne`),
  CONSTRAINT `acteur_ibfk_1` FOREIGN KEY (`id_personne`) REFERENCES `personne` (`id_personne`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=latin1;

-- Listage des données de la table cinema.acteur : ~16 rows (environ)
INSERT INTO `acteur` (`id_acteur`, `id_personne`) VALUES
	(1, 2),
	(2, 3),
	(3, 4),
	(4, 5),
	(5, 7),
	(6, 8),
	(7, 10),
	(8, 11),
	(9, 12),
	(10, 13),
	(11, 14),
	(12, 15),
	(13, 17),
	(14, 19),
	(15, 21),
	(16, 22),
	(17, 23),
	(18, 24),
	(19, 25),
	(20, 27),
	(21, 28),
	(22, 29),
	(26, 59),
	(27, 60),
	(28, 61),
	(31, 67),
	(32, 68),
	(33, 69),
	(34, 71),
	(35, 72),
	(36, 74),
	(37, 75),
	(38, 77),
	(39, 78),
	(40, 80),
	(41, 81),
	(42, 83),
	(43, 84),
	(44, 86),
	(45, 87),
	(46, 88),
	(47, 89),
	(48, 91),
	(49, 92),
	(50, 93),
	(51, 94),
	(52, 96),
	(53, 97);

-- Listage de la structure de table cinema. casting
CREATE TABLE IF NOT EXISTS `casting` (
  `id_film` int NOT NULL,
  `id_acteur` int NOT NULL,
  `id_role` int NOT NULL,
  PRIMARY KEY (`id_film`,`id_acteur`,`id_role`),
  KEY `id_acteur` (`id_acteur`),
  KEY `id_role` (`id_role`),
  CONSTRAINT `casting_ibfk_1` FOREIGN KEY (`id_film`) REFERENCES `film` (`id_film`),
  CONSTRAINT `casting_ibfk_2` FOREIGN KEY (`id_acteur`) REFERENCES `acteur` (`id_acteur`),
  CONSTRAINT `casting_ibfk_3` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table cinema.casting : ~48 rows (environ)
INSERT INTO `casting` (`id_film`, `id_acteur`, `id_role`) VALUES
	(1, 1, 1),
	(1, 2, 2),
	(1, 3, 3),
	(2, 4, 4),
	(3, 5, 5),
	(3, 6, 6),
	(4, 7, 7),
	(4, 8, 8),
	(4, 9, 9),
	(4, 10, 10),
	(4, 11, 11),
	(4, 12, 12),
	(5, 13, 13),
	(6, 14, 14),
	(7, 15, 15),
	(7, 16, 16),
	(7, 17, 17),
	(7, 18, 18),
	(8, 19, 19),
	(9, 20, 20),
	(1, 21, 21),
	(3, 22, 22),
	(68, 26, 32),
	(68, 27, 33),
	(68, 28, 34),
	(81, 31, 47),
	(81, 32, 48),
	(81, 33, 49),
	(82, 34, 50),
	(82, 35, 51),
	(83, 36, 52),
	(83, 37, 53),
	(84, 38, 54),
	(84, 39, 55),
	(85, 40, 56),
	(85, 41, 57),
	(86, 42, 58),
	(86, 43, 59),
	(87, 44, 60),
	(87, 45, 61),
	(88, 46, 62),
	(88, 47, 63),
	(89, 48, 64),
	(89, 49, 65),
	(90, 50, 66),
	(90, 51, 67),
	(91, 52, 68),
	(91, 53, 69);

-- Listage de la structure de table cinema. film
CREATE TABLE IF NOT EXISTS `film` (
  `id_film` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `dateSortie` date NOT NULL,
  `duree` int NOT NULL,
  `synopsis` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `note` float NOT NULL,
  `affiche` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `id_realisateur` int NOT NULL,
  PRIMARY KEY (`id_film`),
  UNIQUE KEY `titre` (`titre`),
  KEY `id_realisateur` (`id_realisateur`),
  CONSTRAINT `film_ibfk_1` FOREIGN KEY (`id_realisateur`) REFERENCES `realisateur` (`id_realisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=latin1;

-- Listage des données de la table cinema.film : ~21 rows (environ)
INSERT INTO `film` (`id_film`, `titre`, `dateSortie`, `duree`, `synopsis`, `note`, `affiche`, `id_realisateur`) VALUES
	(1, 'Super Mario Bros, le film', '2023-04-05', 92, 'Alors qu&rsquo;ils tentent de r&eacute;parer une canalisation souterraine, Mario et son fr&egrave;re Luigi, tous deux plombiers, se retrouvent plong&eacute;s dans un nouvel univers f&eacute;erique &agrave; travers un myst&eacute;rieux conduit. Mais lorsque les deux fr&egrave;res sont s&eacute;par&eacute;s, Mario s&rsquo;engage dans une aventure tr&eacute;pidante pour retrouver Luigi.Dans sa qu&ecirc;te, il peut compter sur l&rsquo;aide du champignon Toad, habitant du Royaume Champignon, et les conseils avis&eacute;s, en mati&egrave;re de techniques de combat, de la Princesse Peach, guerri&egrave;re d&eacute;termin&eacute;e &agrave; la t&ecirc;te du Royaume. C&rsquo;est ainsi que Mario r&eacute;ussit &agrave; mobiliser ses propres forces pour aller au bout de sa mission.', 4, '6470a5ea617209.21185750.jpg', 1),
	(2, 'À vol d\'oiseaux', '2023-04-05', 57, 'À Vol d’oiseaux rassemble trois courts métrages d’animation délicats, sensibles. Un pur moment de bonheur, aérien, à la fin duquel on se sent pousser des ailes ! Un programme comme une parenthèse de douceur, où les adultes retrouvent leur âme d’enfant, les plus jeunes grandissent dans l’espoir d’une vie bienveillante, où chacun est incité à sortir de sa coquille pour voler de ses propres ailes. ', 3, 'A_vol_d_oiseaux.jpg', 2),
	(3, 'Suzume no Tojimari', '2023-04-12', 122, 'Dans une petite ville paisible de Kyushu, une jeune fille de 17 ans, Suzume, rencontre un homme qui dit voyager à la recherche d’une porte. Décidant de le suivre dans les montagnes, elle découvre une porte délabrée trônant au milieu des ruines, seul vestige ayant survécu au passage du temps. Cédant à une inexplicable impulsion, Suzume tourne la poignée, et d’autres portes s’ouvrent alors aux quatre coins du Japon, laissant passer toutes les catastrophes qu’elles renfermaient. L’homme est formel : toute porte ouverte doit être refermée. Suzume s’est égarée où se trouvent les étoiles, le crépuscule et l’aube, une voûte céleste où tous les temps se confondent. Guidée par des portes nimbées de mystère, elle entame un périple afin de toutes les refermer.', 4, 'Suzume.jpg', 3),
	(4, 'Dragons : L\'Honneur des voleurs', '2023-04-12', 134, 'Un voleur beau gosse et une bande d\'aventuriers improbables entreprennent un casse épique pour récupérer une relique perdue. Les choses tournent mal lorsqu\'ils s\'attirent les foudres des mauvaises personnes. Donjons & Dragons : L\'honneur des voleurs transpose sur grand écran l\'univers riche et l\'esprit ludique du légendaire jeu de rôle à travers une aventure hilarante et pleine d\'action.', 4, 'Donjour_et_Dragon.jpg', 4),
	(5, 'Le Royaume de Naya', '2023-03-29', 99, 'Par-delà les hautes Montagnes Noires se cache un royaume peuplé de créatures fantastiques. Depuis des siècles, elles protègent du monde des hommes une source de vie éternelle aux pouvoirs infinis. Jusqu’au jour où Naya, la nouvelle élue de cette forêt enchantée, rencontre Lucas, un jeune humain égaré dans les montagnes. À l’encontre des règles établies depuis des millénaires, ils vont se revoir, sans prendre garde aux conséquences qui s’abattront sur le royaume. L’aventure ne fait que commencer.', 3, 'Royaume_de_Naya.jpg', 5),
	(6, 'John Wick : Chapitre 4', '2023-03-22', 170, 'John Wick découvre un moyen de vaincre l’organisation criminelle connue sous le nom de la Grande Table. Mais avant de gagner sa liberté, Il doit affronter un nouvel ennemi qui a tissé de puissantes alliances à travers le monde et qui transforme les vieux amis de John en ennemis.', 4, 'John_Wick_4.jpg', 6),
	(7, 'Scream VI', '2023-03-08', 122, 'Apr&egrave;s avoir frapp&eacute; &agrave; trois reprises &agrave; Woodsboro, apr&egrave;s avoir terroris&eacute; le campus de Windsor et les studios d&rsquo;Hollywood, Ghostface a d&eacute;cid&eacute; de s&eacute;vir dans Big Apple, mais dans une ville aussi grande que New-York personne ne vous entendra crier&hellip;', 3, '6470a60aa07b37.51429984.jpg', 7),
	(8, 'Creed III', '2023-03-01', 117, 'Idole de la boxe et entouré de sa famille, Adonis Creed n’a plus rien à prouver. Jusqu’au jour où son ami d’enfance, Damian, prodige de la boxe lui aussi, refait surface. A peine sorti de prison, Damian est prêt à tout pour monter sur le ring et reprendre ses droits. Adonis joue alors sa survie, face à un adversaire déterminé à l’anéantir.', 4, 'Creed_3.jpg', 8),
	(9, 'Les Gardiennes de la planète', '2023-02-22', 82, 'Une baleine à bosse s\'est échouée sur un rivage isolé. Alors qu\'un groupe d\'hommes et de femmes organise son sauvetage, nous découvrons l\'histoire extraordinaire des cétacés, citoyens des océans du monde, essentiels à l’écosystème de notre planète depuis plus de 50 millions d’années.', 4, 'Les_Gardiennes_de_la_planete.jpg', 9),
	(68, 'Misanthrope', '2023-04-26', 118, 'Eleanor, une jeune enqu&ecirc;trice au lourd pass&eacute;, est appel&eacute;e sur les lieux d&rsquo;un crime de masse terrible. La police et le FBI lancent une chasse &agrave; l&rsquo;homme sans pr&eacute;c&eacute;dent, mais face au mode op&eacute;ratoire constamment impr&eacute;visible de l&rsquo;assassin, l&rsquo;enqu&ecirc;te pi&eacute;tine. Eleanor, quant &agrave; elle se trouve de plus en plus impliqu&eacute;e dans l&#039;affaire et se rend compte que ses propres d&eacute;mons int&eacute;rieurs peuvent l&rsquo;aider &agrave; cerner l&#039;esprit de ce tueur si singulier&hellip;', 3.9, '646b788fb6b6b6.28655703.jpg', 30),
	(81, 'Forrest Gump', '2015-10-28', 140, 'Quelques d&eacute;cennies d&#039;histoire am&eacute;ricaine, des ann&eacute;es 1940 &agrave; la fin du XX&egrave;me si&egrave;cle, &agrave; travers le regard et l&#039;&eacute;trange odyss&eacute;e d&#039;un homme simple et pur, Forrest Gump.', 4.6, '647747441e31c6.31478253.jpg', 33),
	(82, 'La La Land', '2017-01-25', 128, 'Au c&oelig;ur de Los Angeles, une actrice en devenir pr&eacute;nomm&eacute;e Mia sert des caf&eacute;s entre deux auditions.  De son c&ocirc;t&eacute;, Sebastian, passionn&eacute; de jazz, joue du piano dans des clubs miteux pour assurer sa subsistance.  Tous deux sont bien loin de la vie r&ecirc;v&eacute;e &agrave; laquelle ils aspirent&hellip; Le destin va r&eacute;unir ces doux r&ecirc;veurs, mais leur coup de foudre r&eacute;sistera-t-il aux tentations, aux d&eacute;ceptions, et &agrave; la vie tr&eacute;pidante d&rsquo;Hollywood ?', 4.2, '6477645194cd73.48443591.jpg', 34),
	(83, 'Inception', '2010-07-21', 148, 'Dom Cobb est un voleur exp&eacute;riment&eacute; &ndash; le meilleur qui soit dans l&rsquo;art p&eacute;rilleux de l&rsquo;extraction : sa sp&eacute;cialit&eacute; consiste &agrave; s&rsquo;approprier les secrets les plus pr&eacute;cieux d&rsquo;un individu, enfouis au plus profond de son subconscient, pendant qu&rsquo;il r&ecirc;ve et que son esprit est particuli&egrave;rement vuln&eacute;rable. Tr&egrave;s recherch&eacute; pour ses talents dans l&rsquo;univers trouble de l&rsquo;espionnage industriel, Cobb est aussi devenu un fugitif traqu&eacute; dans le monde entier qui a perdu tout ce qui lui est cher. Mais une ultime mission pourrait lui permettre de retrouver sa vie d&rsquo;avant &ndash; &agrave; condition qu&rsquo;il puisse accomplir l&rsquo;impossible : l&rsquo;inception. Au lieu de subtiliser un r&ecirc;ve, Cobb et son &eacute;quipe doivent faire l&rsquo;inverse : implanter une id&eacute;e dans l&rsquo;esprit d&rsquo;un individu. S&rsquo;ils y parviennent, il pourrait s&rsquo;agir du crime parfait. Et pourtant, aussi m&eacute;thodiques et dou&eacute;s soient-ils, rien n&rsquo;aurait pu pr&eacute;parer Cobb et ses partenaires &agrave; un ennemi redoutable qui semble avoir syst&eacute;matiquement un coup d&rsquo;avance sur eux. Un ennemi dont seul Cobb aurait pu soup&ccedil;onner l&rsquo;existence.', 4.5, '647764dbe65575.61666940.jpg', 35),
	(84, 'Les Mis&eacute;rables', '2019-11-20', 102, 'St&eacute;phane, tout juste arriv&eacute; de Cherbourg, int&egrave;gre la Brigade Anti-Criminalit&eacute; de Montfermeil, dans le 93. Il va faire la rencontre de ses nouveaux co&eacute;quipiers, Chris et Gwada, deux &quot;Bacqueux&quot; d&rsquo;exp&eacute;rience. Il d&eacute;couvre rapidement les tensions entre les diff&eacute;rents groupes du quartier. Alors qu&rsquo;ils se trouvent d&eacute;bord&eacute;s lors d&rsquo;une interpellation, un drone filme leurs moindres faits et gestes...', 4, '64776592b6cc95.72411867.jpg', 36),
	(85, 'Le Roi Lion', '2019-07-17', 118, 'Au fond de la savane africaine, tous les animaux c&eacute;l&egrave;brent la naissance de Simba, leur futur roi. Les mois passent. Simba idol&acirc;tre son p&egrave;re, le roi Mufasa, qui prend &agrave; c&oelig;ur de lui faire comprendre les enjeux de sa royale destin&eacute;e. Mais tout le monde ne semble pas de cet avis. Scar, le fr&egrave;re de Mufasa, l&#039;ancien h&eacute;ritier du tr&ocirc;ne, a ses propres plans. La bataille pour la prise de contr&ocirc;le de la Terre des Lions est ravag&eacute;e par la trahison, la trag&eacute;die et le drame, ce qui finit par entra&icirc;ner l&#039;exil de Simba. Avec l&#039;aide de deux nouveaux amis, Timon et Pumbaa, le jeune lion va devoir trouver comment grandir et reprendre ce qui lui revient de droit&hellip;', 4.1, '6477664296ba36.22198510.jpg', 37),
	(86, 'Pulp Fiction', '1994-10-26', 154, 'L&#039;odyss&eacute;e sanglante et burlesque de petits malfrats dans la jungle de Hollywood &agrave; travers trois histoires qui s&#039;entrem&ecirc;lent.', 4.5, '647766d23a0bd6.00997525.jpg', 38),
	(87, 'Le Discours d&#039;un Roi', '2011-02-02', 118, 'D&rsquo;apr&egrave;s l&rsquo;histoire vraie et m&eacute;connue du p&egrave;re de l&rsquo;actuelle Reine Elisabeth, qui va devenir, contraint et forc&eacute;, le Roi George VI, suite &agrave; l&rsquo;abdication de son fr&egrave;re Edouard VIII. D&rsquo;apparence fragile, incapable de s&rsquo;exprimer en public, consid&eacute;r&eacute; par certains comme inapte &agrave; la fonction, George VI tentera de surmonter son handicap gr&acirc;ce au soutien ind&eacute;fectible de sa femme et d&rsquo;affronter ses peurs avec l&rsquo;aide d&rsquo;un th&eacute;rapeute du langage aux m&eacute;thodes peu conventionnelles. Il devra vaincre son b&eacute;gaiement pour assumer pleinement son r&ocirc;le, et faire de son empire le premier rempart contre l&rsquo;Allemagne nazie.', 4.3, '64776756b40e81.48145451.jpg', 39),
	(88, 'Interstellar', '2014-11-05', 169, 'Le film raconte les aventures d&rsquo;un groupe d&rsquo;explorateurs qui utilisent une faille r&eacute;cemment d&eacute;couverte dans l&rsquo;espace-temps afin de repousser les limites humaines et partir &agrave; la conqu&ecirc;te des distances astronomiques dans un voyage interstellaire. ', 4.5, '647767f15b8a00.37764643.jpg', 35),
	(89, 'Le Fabuleux Destin d&#039;Am&eacute;lie Poulain', '2001-04-25', 120, 'Am&eacute;lie, une jeune serveuse dans un bar de Montmartre, passe son temps &agrave; observer les gens et &agrave; laisser son imagination divaguer. Elle s&#039;est fix&eacute; un but : faire le bien de ceux qui l&#039;entourent. Elle invente alors des stratag&egrave;mes pour intervenir incognito dans leur existence. Le chemin d&#039;Am&eacute;lie est jalonn&eacute; de rencontres : Georgette, la buraliste hypocondriaque ; Lucien, le commis d&#039;&eacute;picerie ; Madeleine Wallace, la concierge port&eacute;e sur le porto et les chiens empaill&eacute;s ; Raymond Dufayel alias &quot;l&#039;homme de verre&quot;, son voisin qui ne vit qu&#039;&agrave; travers une reproduction d&#039;un tableau de Renoir. Cette qu&ecirc;te du bonheur am&egrave;ne Am&eacute;lie &agrave; faire la connaissance de Nino Quincampoix, un &eacute;trange &quot;prince charmant&quot;. Celui-ci partage son temps entre un train fant&ocirc;me et un sex-shop, et cherche &agrave; identifier un inconnu dont la photo r&eacute;appara&icirc;t sans cesse dans plusieurs cabines de Photomaton.', 3.9, '647768543d2662.95617781.jpg', 40),
	(90, 'Django Unchained', '2013-01-16', 164, 'Dans le sud des &Eacute;tats-Unis, deux ans avant la guerre de S&eacute;cession, le Dr King Schultz, un chasseur de primes allemand, fait l&rsquo;acquisition de Django, un esclave qui peut l&rsquo;aider &agrave; traquer les fr&egrave;res Brittle, les meurtriers qu&rsquo;il recherche. Schultz promet &agrave; Django de lui rendre sa libert&eacute; lorsqu&rsquo;il aura captur&eacute; les Brittle &ndash; morts ou vifs. Alors que les deux hommes pistent les dangereux criminels, Django n&rsquo;oublie pas que son seul but est de retrouver Broomhilda, sa femme, dont il fut s&eacute;par&eacute; &agrave; cause du commerce des esclaves&hellip; Lorsque Django et Schultz arrivent dans l&rsquo;immense plantation du puissant Calvin Candie, ils &eacute;veillent les soup&ccedil;ons de Stephen, un esclave qui sert Candie et a toute sa confiance. Le moindre de leurs mouvements est d&eacute;sormais &eacute;pi&eacute; par une dangereuse organisation de plus en plus proche&hellip; Si Django et Schultz veulent esp&eacute;rer s&rsquo;enfuir avec Broomhilda, ils vont devoir choisir entre l&rsquo;ind&eacute;pendance et la solidarit&eacute;, entre le sacrifice et la survie&hellip;', 4.5, '647768b09928a6.72433817.jpg', 38),
	(91, 'Le Voyage de Chihiro', '2002-04-10', 125, 'Chihiro, une fillette de 10 ans, est en route vers sa nouvelle demeure en compagnie de ses parents. Au cours du voyage, la famille fait une halte dans un parc &agrave; th&egrave;me qui leur para&icirc;t d&eacute;labr&eacute;. Lors de la visite, les parents s&rsquo;arr&ecirc;tent dans un des b&acirc;timents pour d&eacute;guster quelques mets tr&egrave;s app&eacute;tissants, apparus comme par enchantement. H&eacute;las cette nourriture les transforme en porcs. Prise de panique, Chihiro s&rsquo;enfuit et se retrouve seule dans cet univers fantasmagorique ; elle rencontre alors l&rsquo;&eacute;nigmatique Haku, son seul alli&eacute; dans cette terrible &eacute;preuve...', 4.4, '6477691c776e34.90928145.jpg', 41);

-- Listage de la structure de table cinema. genre
CREATE TABLE IF NOT EXISTS `genre` (
  `id_genre` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  PRIMARY KEY (`id_genre`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;

-- Listage des données de la table cinema.genre : ~19 rows (environ)
INSERT INTO `genre` (`id_genre`, `nom`) VALUES
	(1, 'Action'),
	(2, 'Aventure'),
	(3, 'Comédie'),
	(4, 'Drame'),
	(5, 'Epouvante-horreur'),
	(6, 'Science-fiction'),
	(7, 'Thriller'),
	(8, 'Fantastique'),
	(9, 'Animation'),
	(10, 'Documentaire'),
	(11, 'Famille'),
	(12, 'Policier'),
	(14, 'Apocalyptique'),
	(15, 'Romance'),
	(16, 'Biographie'),
	(40, 'Com&eacute;die musicale'),
	(41, 'Biopic'),
	(42, 'Historique'),
	(43, 'Western');

-- Listage de la structure de table cinema. genre_film
CREATE TABLE IF NOT EXISTS `genre_film` (
  `id_film` int NOT NULL,
  `id_genre` int NOT NULL,
  PRIMARY KEY (`id_film`,`id_genre`),
  KEY `id_genre` (`id_genre`),
  CONSTRAINT `genre_film_ibfk_1` FOREIGN KEY (`id_film`) REFERENCES `film` (`id_film`),
  CONSTRAINT `genre_film_ibfk_2` FOREIGN KEY (`id_genre`) REFERENCES `genre` (`id_genre`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table cinema.genre_film : ~50 rows (environ)
INSERT INTO `genre_film` (`id_film`, `id_genre`) VALUES
	(1, 1),
	(6, 1),
	(1, 2),
	(3, 2),
	(4, 2),
	(5, 2),
	(85, 2),
	(91, 2),
	(1, 3),
	(81, 3),
	(89, 3),
	(3, 4),
	(8, 4),
	(81, 4),
	(82, 4),
	(84, 4),
	(87, 4),
	(88, 4),
	(7, 5),
	(83, 6),
	(88, 6),
	(68, 7),
	(86, 7),
	(4, 8),
	(5, 8),
	(89, 8),
	(91, 8),
	(1, 9),
	(2, 9),
	(3, 9),
	(5, 9),
	(85, 9),
	(91, 9),
	(9, 10),
	(1, 11),
	(2, 11),
	(5, 11),
	(9, 11),
	(83, 11),
	(85, 11),
	(68, 12),
	(84, 12),
	(86, 12),
	(81, 15),
	(82, 15),
	(89, 15),
	(82, 40),
	(87, 41),
	(87, 42),
	(90, 43);

-- Listage de la structure de table cinema. personne
CREATE TABLE IF NOT EXISTS `personne` (
  `id_personne` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(80) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `sexe` varchar(10) NOT NULL,
  `dateNaissance` date DEFAULT NULL,
  PRIMARY KEY (`id_personne`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=latin1;

-- Listage des données de la table cinema.personne : ~65 rows (environ)
INSERT INTO `personne` (`id_personne`, `nom`, `prenom`, `sexe`, `dateNaissance`) VALUES
	(1, 'Horvath', 'Aaron ', 'H', '1980-08-19'),
	(2, 'Pratt', 'Chris', 'H', '1979-06-21'),
	(3, 'Taylor-Joy', 'Anya', 'F', '1996-04-16'),
	(4, 'Day', 'Charlie ', 'H', '1976-02-09'),
	(5, 'Belin', 'Charlie', 'F', '1990-01-20'),
	(6, 'Shinkai ', 'Makoto ', 'H', '1973-02-09'),
	(7, 'Hara', 'Nanoka', 'F', '2003-08-26'),
	(8, 'Hokuto', 'Matsumura', 'H', '1995-06-18'),
	(9, 'Goldstein', 'Jonathan', 'H', '1968-09-02'),
	(10, 'Lillis', 'Sophia', 'F', '2002-02-13'),
	(11, 'Pine', 'Chris', 'H', '1980-08-26'),
	(12, 'Rodriguez', 'Michelle', 'F', '1978-07-12'),
	(13, 'Smith', 'Justice', 'H', '1995-08-30'),
	(14, 'Page', 'Regé-Jean', 'H', '1988-04-27'),
	(15, 'Grant', 'Hugh', 'H', '1960-09-09'),
	(16, 'Malamuzh', 'Oleh', 'H', '1978-05-05'),
	(17, 'Denysenko', 'Nataliia', 'F', '1989-12-17'),
	(18, 'Stahelski', 'Chad', 'H', '1968-09-20'),
	(19, 'Reeves', 'Keanu', 'H', '1964-09-02'),
	(20, 'Bettinelli-Olpin', 'Matt', 'H', '1978-02-19'),
	(21, 'Barrera', 'Melissa', 'F', '1990-07-04'),
	(22, 'Ortega', 'Jenna', 'F', '2002-09-27'),
	(23, 'Cox', 'Courteney', 'F', '1964-06-15'),
	(24, 'L. Jackson', 'Roger', 'H', '1958-07-13'),
	(25, 'B. Jordan', 'Michael', 'H', '1987-02-09'),
	(26, 'Lièvre', 'Jean-Albert', 'H', '1961-08-15'),
	(27, 'Dujardin', 'Jean', 'H', '1972-06-19'),
	(28, 'Black', 'Jack', 'H', '1969-08-28'),
	(29, 'Yamane', 'Ann', 'F', '1997-02-03'),
	(58, 'Szifron', 'Dami&aacute;n', 'H', '1975-07-09'),
	(59, 'Woodley', 'Shailene', 'F', '1991-11-15'),
	(60, 'Mendelsohn', 'Ben', 'H', '1969-04-03'),
	(61, 'Adepo', 'Jovan', 'H', '1988-09-06'),
	(66, 'Zemeckis', 'Robert', 'H', '1952-05-14'),
	(67, 'Hanks', 'Tom', 'H', '1956-07-09'),
	(68, 'Sinise', 'Gary', 'H', '1955-03-17'),
	(69, 'Wright', 'Robin', 'F', '1966-04-08'),
	(70, 'Chazelle', 'Damien', 'H', '1985-01-19'),
	(71, 'Stone', 'Emma', 'F', '1988-11-06'),
	(72, 'Gosling', 'Ryan', 'H', '1980-11-12'),
	(73, 'Nolan', 'Christopher', 'H', '1970-07-30'),
	(74, 'DiCaprio', 'Leonardo', 'H', '1974-11-11'),
	(75, 'Cotillard', 'Marion', 'F', '1975-09-30'),
	(76, 'Ly', 'Ladj', 'H', '1978-06-27'),
	(77, 'Bonnard', 'Damien', 'H', '1981-03-23'),
	(78, 'Zonga', 'Alexis', 'H', '1992-06-06'),
	(79, 'Favreau', 'Jon', 'H', '1966-10-19'),
	(80, 'Ejiofor', 'Chiwetel', 'H', '1977-07-10'),
	(81, 'Glover', 'Donald', 'H', '1983-09-25'),
	(82, 'Tarantino', 'Quentin', 'H', '1963-03-27'),
	(83, 'Travolta', 'John', 'H', '1954-02-18'),
	(84, 'Thurman', 'Uma', 'F', '1970-04-29'),
	(85, 'Hooper', 'Tom', 'H', '1972-01-01'),
	(86, 'Firth', 'Colin', 'H', '1960-09-10'),
	(87, 'Bonham Carter', 'Helena', 'F', '1966-05-26'),
	(88, 'McConaughey', 'Matthew', 'H', '1969-11-04'),
	(89, 'Hathaway', 'Anne', 'F', '1982-11-12'),
	(90, 'Jeunet', 'Jean-Pierre', 'H', '1953-09-30'),
	(91, 'Tautou', 'Audrey', 'F', '1976-08-09'),
	(92, 'Kassovitz', 'Mathieu', 'H', '1967-08-30'),
	(93, 'Foxx', 'Jamie', 'H', '1967-12-13'),
	(94, 'Waltz', 'Christoph', 'H', '1956-10-04'),
	(95, 'Miyazaki', 'Hayao', 'H', '1941-01-05'),
	(96, 'Hisakawa', 'Aya', 'F', '1968-11-12'),
	(97, 'Natsuki', 'Rumi', 'F', '0973-01-21');

-- Listage de la structure de table cinema. realisateur
CREATE TABLE IF NOT EXISTS `realisateur` (
  `id_realisateur` int NOT NULL AUTO_INCREMENT,
  `id_personne` int NOT NULL,
  PRIMARY KEY (`id_realisateur`),
  UNIQUE KEY `id_personne` (`id_personne`),
  CONSTRAINT `realisateur_ibfk_1` FOREIGN KEY (`id_personne`) REFERENCES `personne` (`id_personne`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

-- Listage des données de la table cinema.realisateur : ~19 rows (environ)
INSERT INTO `realisateur` (`id_realisateur`, `id_personne`) VALUES
	(1, 1),
	(2, 5),
	(3, 6),
	(4, 9),
	(5, 16),
	(6, 18),
	(7, 20),
	(8, 25),
	(9, 26),
	(30, 58),
	(33, 66),
	(34, 70),
	(35, 73),
	(36, 76),
	(37, 79),
	(38, 82),
	(39, 85),
	(40, 90),
	(41, 95);

-- Listage de la structure de table cinema. role
CREATE TABLE IF NOT EXISTS `role` (
  `id_role` int NOT NULL AUTO_INCREMENT,
  `role` varchar(50) NOT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=latin1;

-- Listage des données de la table cinema.role : ~48 rows (environ)
INSERT INTO `role` (`id_role`, `role`) VALUES
	(1, 'Mario'),
	(2, 'Princesse Peach'),
	(3, 'Luigi'),
	(4, 'Ellie'),
	(5, 'Suzume Iwato'),
	(6, 'Souta Munakata'),
	(7, 'Doric, la druidesse'),
	(8, 'Edgin Darvis, le barde'),
	(9, 'Holga Kilgore, la barbare'),
	(10, 'Simon Aumar, le sorcier'),
	(11, 'Xenk Yendar, le paladin'),
	(12, 'Forge Fitzwilliam'),
	(13, 'Mavka'),
	(14, 'John Wick'),
	(15, 'Sam Carpenter'),
	(16, 'Tara Carpenter'),
	(17, 'Gale Weathers-Riley'),
	(18, 'Ghostface'),
	(19, 'Adonis Johnson Creed'),
	(20, 'Voix Off'),
	(21, 'Bowser'),
	(22, 'Daijin'),
	(32, 'Eleonor'),
	(33, 'Lammark'),
	(34, 'Mackenzie'),
	(47, 'Forrest Gump'),
	(48, 'Lieutenant Daniel Taylor'),
	(49, 'Jenny'),
	(50, 'Mia'),
	(51, 'Sebastian'),
	(52, 'Dom Cobb'),
	(53, 'Mal Cobb'),
	(54, 'St&eacute;phane'),
	(55, 'Issa'),
	(56, 'Scar (voix)'),
	(57, 'Simba (voix)'),
	(58, 'Vincent Vega'),
	(59, 'Mia Wallace'),
	(60, 'Roi George VI'),
	(61, 'Reine Elizabeth'),
	(62, 'Cooper'),
	(63, 'Amelia Brand'),
	(64, 'Am&eacute;lie Poulain'),
	(65, 'Nino Quincampoix'),
	(66, 'Django'),
	(67, 'Dr. King Schultz'),
	(68, 'Chihiro (voix)'),
	(69, 'Yubaba / Zeniba (voix)');

-- Listage de la structure de table cinema. users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email` varchar(80) NOT NULL,
  `admin` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Listage des données de la table cinema.users : ~1 rows (environ)
INSERT INTO `users` (`id`, `username`, `password`, `email`, `admin`) VALUES
	(10, 'admin', '$2y$10$zjxQVvFDuLEz9.VCOCDU1O3WF9RbyxExC9pT3imvHlLdhZ6cyvpOe', 'admin@gmail.com', 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
