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
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

-- Listage des données de la table cinema.acteur : ~25 rows (environ)
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
	(28, 61);

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

-- Listage des données de la table cinema.casting : ~25 rows (environ)
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
	(68, 28, 34);

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
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=latin1;

-- Listage des données de la table cinema.film : ~10 rows (environ)
INSERT INTO `film` (`id_film`, `titre`, `dateSortie`, `duree`, `synopsis`, `note`, `affiche`, `id_realisateur`) VALUES
	(1, 'Super Mario Bros, le film', '2023-04-05', 92, 'Alors qu’ils tentent de réparer une canalisation souterraine, Mario et son frère Luigi, tous deux plombiers, se retrouvent plongés dans un nouvel univers féerique à travers un mystérieux conduit. Mais lorsque les deux frères sont séparés, Mario s’engage dans une aventure trépidante pour retrouver Luigi.Dans sa quête, il peut compter sur l’aide du champignon Toad, habitant du Royaume Champignon, et les conseils avisés, en matière de techniques de combat, de la Princesse Peach, guerrière déterminée à la tête du Royaume. C’est ainsi que Mario réussit à mobiliser ses propres forces pour aller au bout de sa mission.', 4, 'Super_Mario_Bros_Film.jpg', 1),
	(2, 'À vol d\'oiseaux', '2023-04-05', 57, 'À Vol d’oiseaux rassemble trois courts métrages d’animation délicats, sensibles. Un pur moment de bonheur, aérien, à la fin duquel on se sent pousser des ailes ! Un programme comme une parenthèse de douceur, où les adultes retrouvent leur âme d’enfant, les plus jeunes grandissent dans l’espoir d’une vie bienveillante, où chacun est incité à sortir de sa coquille pour voler de ses propres ailes. ', 3, 'A_vol_d_oiseaux.jpg', 2),
	(3, 'Suzume no Tojimari', '2023-04-12', 122, 'Dans une petite ville paisible de Kyushu, une jeune fille de 17 ans, Suzume, rencontre un homme qui dit voyager à la recherche d’une porte. Décidant de le suivre dans les montagnes, elle découvre une porte délabrée trônant au milieu des ruines, seul vestige ayant survécu au passage du temps. Cédant à une inexplicable impulsion, Suzume tourne la poignée, et d’autres portes s’ouvrent alors aux quatre coins du Japon, laissant passer toutes les catastrophes qu’elles renfermaient. L’homme est formel : toute porte ouverte doit être refermée. Suzume s’est égarée où se trouvent les étoiles, le crépuscule et l’aube, une voûte céleste où tous les temps se confondent. Guidée par des portes nimbées de mystère, elle entame un périple afin de toutes les refermer.', 4, 'Suzume.jpg', 3),
	(4, 'Dragons : L\'Honneur des voleurs', '2023-04-12', 134, 'Un voleur beau gosse et une bande d\'aventuriers improbables entreprennent un casse épique pour récupérer une relique perdue. Les choses tournent mal lorsqu\'ils s\'attirent les foudres des mauvaises personnes. Donjons & Dragons : L\'honneur des voleurs transpose sur grand écran l\'univers riche et l\'esprit ludique du légendaire jeu de rôle à travers une aventure hilarante et pleine d\'action.', 4, 'Donjour_et_Dragon.jpg', 4),
	(5, 'Le Royaume de Naya', '2023-03-29', 99, 'Par-delà les hautes Montagnes Noires se cache un royaume peuplé de créatures fantastiques. Depuis des siècles, elles protègent du monde des hommes une source de vie éternelle aux pouvoirs infinis. Jusqu’au jour où Naya, la nouvelle élue de cette forêt enchantée, rencontre Lucas, un jeune humain égaré dans les montagnes. À l’encontre des règles établies depuis des millénaires, ils vont se revoir, sans prendre garde aux conséquences qui s’abattront sur le royaume. L’aventure ne fait que commencer.', 3, 'Royaume_de_Naya.jpg', 5),
	(6, 'John Wick : Chapitre 4', '2023-03-22', 170, 'John Wick découvre un moyen de vaincre l’organisation criminelle connue sous le nom de la Grande Table. Mais avant de gagner sa liberté, Il doit affronter un nouvel ennemi qui a tissé de puissantes alliances à travers le monde et qui transforme les vieux amis de John en ennemis.', 4, 'John_Wick_4.jpg', 6),
	(7, 'Scream VI', '2023-03-08', 122, 'Après avoir frappé à trois reprises à Woodsboro, après avoir terrorisé le campus de Windsor et les studios d’Hollywood, Ghostface a décidé de sévir dans Big Apple, mais dans une ville aussi grande que New-York personne ne vous entendra crier…', 3, 'Scream_6.jpg', 7),
	(8, 'Creed III', '2023-03-01', 117, 'Idole de la boxe et entouré de sa famille, Adonis Creed n’a plus rien à prouver. Jusqu’au jour où son ami d’enfance, Damian, prodige de la boxe lui aussi, refait surface. A peine sorti de prison, Damian est prêt à tout pour monter sur le ring et reprendre ses droits. Adonis joue alors sa survie, face à un adversaire déterminé à l’anéantir.', 4, 'Creed_3.jpg', 8),
	(9, 'Les Gardiennes de la planète', '2023-02-22', 82, 'Une baleine à bosse s\'est échouée sur un rivage isolé. Alors qu\'un groupe d\'hommes et de femmes organise son sauvetage, nous découvrons l\'histoire extraordinaire des cétacés, citoyens des océans du monde, essentiels à l’écosystème de notre planète depuis plus de 50 millions d’années.', 4, 'Les_Gardiennes_de_la_planete.jpg', 9),
	(68, 'Misanthrope', '2023-04-26', 118, 'Eleanor, une jeune enqu&ecirc;trice au lourd pass&eacute;, est appel&eacute;e sur les lieux d&rsquo;un crime de masse terrible. La police et le FBI lancent une chasse &agrave; l&rsquo;homme sans pr&eacute;c&eacute;dent, mais face au mode op&eacute;ratoire constamment impr&eacute;visible de l&rsquo;assassin, l&rsquo;enqu&ecirc;te pi&eacute;tine. Eleanor, quant &agrave; elle se trouve de plus en plus impliqu&eacute;e dans l&#039;affaire et se rend compte que ses propres d&eacute;mons int&eacute;rieurs peuvent l&rsquo;aider &agrave; cerner l&#039;esprit de ce tueur si singulier&hellip;', 3.9, '646b788fb6b6b6.28655703.jpg', 30);

-- Listage de la structure de table cinema. genre
CREATE TABLE IF NOT EXISTS `genre` (
  `id_genre` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  PRIMARY KEY (`id_genre`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

-- Listage des données de la table cinema.genre : ~15 rows (environ)
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
	(15, 'Romande'),
	(16, 'Biographie');

-- Listage de la structure de table cinema. genre_film
CREATE TABLE IF NOT EXISTS `genre_film` (
  `id_film` int NOT NULL,
  `id_genre` int NOT NULL,
  PRIMARY KEY (`id_film`,`id_genre`),
  KEY `id_genre` (`id_genre`),
  CONSTRAINT `genre_film_ibfk_1` FOREIGN KEY (`id_film`) REFERENCES `film` (`id_film`),
  CONSTRAINT `genre_film_ibfk_2` FOREIGN KEY (`id_genre`) REFERENCES `genre` (`id_genre`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table cinema.genre_film : ~23 rows (environ)
INSERT INTO `genre_film` (`id_film`, `id_genre`) VALUES
	(1, 1),
	(6, 1),
	(1, 2),
	(3, 2),
	(4, 2),
	(5, 2),
	(1, 3),
	(3, 4),
	(8, 4),
	(7, 5),
	(68, 7),
	(4, 8),
	(5, 8),
	(1, 9),
	(2, 9),
	(3, 9),
	(5, 9),
	(9, 10),
	(1, 11),
	(2, 11),
	(5, 11),
	(9, 11),
	(68, 12);

-- Listage de la structure de table cinema. personne
CREATE TABLE IF NOT EXISTS `personne` (
  `id_personne` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(80) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `sexe` varchar(10) NOT NULL,
  `dateNaissance` date DEFAULT NULL,
  PRIMARY KEY (`id_personne`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=latin1;

-- Listage des données de la table cinema.personne : ~33 rows (environ)
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
	(59, 'Woodley', 'Shailene', 'femme', '1991-11-15'),
	(60, 'Mendelsohn', 'Ben', 'homme', '1969-04-03'),
	(61, 'Adepo', 'Jovan', 'homme', '1988-09-06');

-- Listage de la structure de table cinema. realisateur
CREATE TABLE IF NOT EXISTS `realisateur` (
  `id_realisateur` int NOT NULL AUTO_INCREMENT,
  `id_personne` int NOT NULL,
  PRIMARY KEY (`id_realisateur`),
  UNIQUE KEY `id_personne` (`id_personne`),
  CONSTRAINT `realisateur_ibfk_1` FOREIGN KEY (`id_personne`) REFERENCES `personne` (`id_personne`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

-- Listage des données de la table cinema.realisateur : ~10 rows (environ)
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
	(30, 58);

-- Listage de la structure de table cinema. role
CREATE TABLE IF NOT EXISTS `role` (
  `id_role` int NOT NULL AUTO_INCREMENT,
  `role` varchar(50) NOT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;

-- Listage des données de la table cinema.role : ~25 rows (environ)
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
	(34, 'Mackenzie');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
