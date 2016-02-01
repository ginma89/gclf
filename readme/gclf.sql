-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mer 13 Janvier 2016 à 16:32
-- Version du serveur :  10.1.8-MariaDB
-- Version de PHP :  5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `gclf`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE `categorie` (
  `cat_id` int(10) UNSIGNED NOT NULL,
  `cat_nom` varchar(32) DEFAULT NULL,
  `cat_created` datetime DEFAULT NULL,
  `cat_updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `categorie`
--

INSERT INTO `categorie` (`cat_id`, `cat_nom`, `cat_created`, `cat_updated`) VALUES
(1, 'Aventure', '2016-01-13 00:00:00', '2016-01-13 09:24:51'),
(2, 'Thriller', '2016-01-13 00:00:00', '2016-01-13 09:07:11'),
(3, 'Science-Fiction', '2016-01-13 09:00:29', '2016-01-13 09:15:09'),
(4, 'Biopic', '2016-01-13 09:06:35', '2016-01-13 09:06:35'),
(5, 'Comédie', '2016-01-13 09:12:33', '2016-01-13 09:13:07'),
(6, 'Action', '2016-01-13 09:25:03', '2016-01-13 11:19:12'),
(7, 'Drame', '2016-01-13 09:25:06', '2016-01-13 11:19:20'),
(8, 'Policier', '2016-01-13 09:25:07', '2016-01-13 11:19:56'),
(9, 'Western', '2016-01-13 09:25:08', '2016-01-13 11:20:50'),
(10, 'Horreur', '2016-01-13 15:42:50', '2016-01-13 15:42:50');

-- --------------------------------------------------------

--
-- Structure de la table `film`
--

DROP TABLE IF EXISTS `film`;
CREATE TABLE `film` (
  `fil_id` int(10) UNSIGNED NOT NULL,
  `sup_id` int(10) UNSIGNED NOT NULL,
  `cat_id` int(10) UNSIGNED NOT NULL,
  `fil_titre` varchar(128) DEFAULT NULL,
  `fil_filename` varchar(255) DEFAULT NULL,
  `fil_annee` smallint(5) UNSIGNED DEFAULT NULL,
  `fil_affiche` varchar(255) DEFAULT NULL,
  `fil_synopsis` text,
  `fil_acteurs` text,
  `fil_description` text,
  `fil_created` datetime DEFAULT NULL,
  `fil_updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `film`
--

INSERT INTO `film` (`fil_id`, `sup_id`, `cat_id`, `fil_titre`, `fil_filename`, `fil_annee`, `fil_affiche`, `fil_synopsis`, `fil_acteurs`, `fil_description`, `fil_created`, `fil_updated`) VALUES
(6, 1, 3, 'The Matrix', 'fichier.avi', 1999, 'http://ia.media-imdb.com/images/M/MV5BMTkxNDYxOTA4M15BMl5BanBnXkFtZTgwNTk0NzQxMTE@._V1_SX300.jpg', 'A computer hacker learns from mysterious rebels about the true nature of his reality and his role in the war against its controllers.', 'Keanu Reeves, Laurence Fishburne, Carrie-Anne Moss, Hugo Weaving', 'A computer hacker learns from mysterious rebels about the true nature of his reality and his role in the war against its controllers.', NULL, NULL),
(7, 3, 3, 'Gravity', 'fichier.avi', 2013, 'http://ia.media-imdb.com/images/M/MV5BNjE5MzYwMzYxMF5BMl5BanBnXkFtZTcwOTk4MTk0OQ@@._V1_SX300.jpg', 'A medical engineer and an astronaut work together to survive after an accident leaves them adrift in space.', 'Sandra Bullock, George Clooney, Ed Harris, Orto Ignatiussen', 'A medical engineer and an astronaut work together to survive after an accident leaves them adrift in space.', NULL, NULL),
(8, 2, 1, 'Indiana Jones and the Last Crusade', 'fichier.avi', 1989, 'http://ia.media-imdb.com/images/M/MV5BMTQxMTUyODg2OF5BMl5BanBnXkFtZTcwNDM2MjAxNA@@._V1_SX300.jpg', 'When Dr. Henry Jones Sr. suddenly goes missing while pursuing the Holy Grail, eminent archaeologist Indiana Jones must follow in his father''s footsteps and stop the Nazis.', 'Harrison Ford, Sean Connery, Denholm Elliott, Alison Doody', 'When Dr. Henry Jones Sr. suddenly goes missing while pursuing the Holy Grail, eminent archaeologist Indiana Jones must follow in his father''s footsteps and stop the Nazis.', NULL, NULL),
(9, 2, 1, 'Indiana Jones and the Kingdom of the Crystal Skull', 'fichier.avi', 2008, 'http://ia.media-imdb.com/images/M/MV5BMTIxNDUxNzcyMl5BMl5BanBnXkFtZTcwNTgwOTI3MQ@@._V1_SX300.jpg', 'Famed archaeologist/adventurer Dr. Henry "Indiana" Jones is called back into action when he becomes entangled in a Soviet plot to uncover the secret behind mysterious artifacts known as the Crystal Skulls.', 'Harrison Ford, Cate Blanchett, Karen Allen, Shia LaBeouf', 'Famed archaeologist/adventurer Dr. Henry "Indiana" Jones is called back into action when he becomes entangled in a Soviet plot to uncover the secret behind mysterious artifacts known as the Crystal Skulls.', NULL, NULL),
(10, 2, 5, 'Le placard', 'fichier.avi', 2015, 'N/A', 'N/A', 'Elie Semoun, Laurent Gamelon, Philippe Magnan, Zoé Félix', 'N/A', NULL, NULL),
(11, 2, 1, 'Star Wars: Episode IV - A New Hope', 'fichier.avi', 1977, 'http://ia.media-imdb.com/images/M/MV5BMTU4NTczODkwM15BMl5BanBnXkFtZTcwMzEyMTIyMw@@._V1_SX300.jpg', 'Luke Skywalker joins forces with a Jedi Knight, a cocky pilot, a wookiee and two droids to save the universe from the Empire''s world-destroying battle-station, while also attempting to rescue Princess Leia from the evil Darth Vader.', 'Mark Hamill, Harrison Ford, Carrie Fisher, Peter Cushing', 'Luke Skywalker joins forces with a Jedi Knight, a cocky pilot, a wookiee and two droids to save the universe from the Empire''s world-destroying battle-station, while also attempting to rescue Princess Leia from the evil Darth Vader.', NULL, NULL),
(12, 2, 1, 'Star Wars: Episode V - The Empire Strikes Back', 'fichier.avi', 1980, 'http://ia.media-imdb.com/images/M/MV5BMjE2MzQwMTgxN15BMl5BanBnXkFtZTcwMDQzNjk2OQ@@._V1_SX300.jpg', 'After the rebels have been brutally overpowered by the Empire on their newly established base, Luke Skywalker takes advanced Jedi training with Master Yoda, while his friends are pursued by Darth Vader as part of his plan to capture Luke.', 'Mark Hamill, Harrison Ford, Carrie Fisher, Billy Dee Williams', 'After the rebels have been brutally overpowered by the Empire on their newly established base, Luke Skywalker takes advanced Jedi training with Master Yoda, while his friends are pursued by Darth Vader as part of his plan to capture Luke.', NULL, NULL),
(13, 2, 1, 'Star Wars: Episode VI - Return of the Jedi', 'fichier.avi', 1983, 'http://ia.media-imdb.com/images/M/MV5BMTQ0MzI1NjYwOF5BMl5BanBnXkFtZTgwODU3NDU2MTE@._V1._CR93,97,1209,1861_SX89_AL_.jpg_V1_SX300.jpg', 'After rescuing Han Solo from the palace of Jabba the Hutt, the rebels attempt to destroy the second Death Star, while Luke struggles to make Vader return from the dark side of the Force.', 'Mark Hamill, Harrison Ford, Carrie Fisher, Billy Dee Williams', 'After rescuing Han Solo from the palace of Jabba the Hutt, the rebels attempt to destroy the second Death Star, while Luke struggles to make Vader return from the dark side of the Force.', NULL, NULL),
(14, 2, 1, 'Star Wars: Episode I - The Phantom Menace', 'fichier.avi', 1999, 'http://ia.media-imdb.com/images/M/MV5BMTQ4NjEwNDA2Nl5BMl5BanBnXkFtZTcwNDUyNDQzNw@@._V1_SX300.jpg', 'Two Jedi Knights escape a hostile blockade to find allies and come across a young boy who may bring balance to the Force, but the long dormant Sith resurface to reclaim their old glory.', 'Liam Neeson, Ewan McGregor, Natalie Portman, Jake Lloyd', 'Two Jedi Knights escape a hostile blockade to find allies and come across a young boy who may bring balance to the Force, but the long dormant Sith resurface to reclaim their old glory.', NULL, NULL),
(15, 2, 1, 'Star Wars: Episode III - Revenge of the Sith', 'fichier.avi', 2005, 'http://ia.media-imdb.com/images/M/MV5BNTc4MTc3NTQ5OF5BMl5BanBnXkFtZTcwOTg0NjI4NA@@._V1_SX300.jpg', 'Three years after the onset of the Clone Wars; the noble Jedi Knights are spread out across the galaxy leading a massive clone army in the war against the Separatists. After Chancellor ...', 'Ewan McGregor, Natalie Portman, Hayden Christensen, Ian McDiarmid', 'Three years after the onset of the Clone Wars; the noble Jedi Knights are spread out across the galaxy leading a massive clone army in the war against the Separatists. After Chancellor ...', NULL, NULL),
(16, 2, 1, 'Star Wars: Episode II - Attack of the Clones', 'fichier.avi', 2002, 'http://ia.media-imdb.com/images/M/MV5BMTY5MjI5NTIwNl5BMl5BanBnXkFtZTYwMTM1Njg2._V1_SX300.jpg', 'Ten years after initially meeting, Anakin Skywalker shares a forbidden romance with Padmé, while Obi-Wan investigates an assassination attempt on the Senator and discovers a secret clone army crafted for the Jedi.', 'Ewan McGregor, Natalie Portman, Hayden Christensen, Christopher Lee', 'Ten years after initially meeting, Anakin Skywalker shares a forbidden romance with Padmé, while Obi-Wan investigates an assassination attempt on the Senator and discovers a secret clone army crafted for the Jedi.', NULL, NULL),
(17, 2, 5, 'Ted', 'fichier.avi', 2012, 'http://ia.media-imdb.com/images/M/MV5BMTQ1OTU0ODcxMV5BMl5BanBnXkFtZTcwOTMxNTUwOA@@._V1_SX300.jpg', 'From the creator of Family Guy comes a movie about John Bennett, whose wish of bringing his teddy bear to life came true. Now, John must decide between keeping the relationship with the teddy bear or his girlfriend, Lori.', 'Mark Wahlberg, Mila Kunis, Seth MacFarlane, Joel McHale', 'From the creator of Family Guy comes a movie about John Bennett, whose wish of bringing his teddy bear to life came true. Now, John must decide between keeping the relationship with the teddy bear or his girlfriend, Lori.', NULL, NULL),
(18, 2, 5, 'Ted 2', 'fichier.avi', 2015, 'http://ia.media-imdb.com/images/M/MV5BMjEwMDg3MDk1NF5BMl5BanBnXkFtZTgwNjYyODA1NTE@._V1_SX300.jpg', 'Newlywed couple Ted and Tami-Lynn want to have a baby, but in order to qualify to be a parent, Ted will have to prove he''s a person in a court of law.', 'Mark Wahlberg, Seth MacFarlane, Amanda Seyfried, Jessica Barth', 'Newlywed couple Ted and Tami-Lynn want to have a baby, but in order to qualify to be a parent, Ted will have to prove he''s a person in a court of law.', NULL, NULL),
(19, 2, 10, 'The Ring', 'fichier.avi', 2002, 'http://ia.media-imdb.com/images/M/MV5BNDA2NTg2NjE4Ml5BMl5BanBnXkFtZTYwMjYxMDg5._V1_SX300.jpg', 'A journalist must investigate a mysterious videotape which seems to cause the death of anyone in a week of viewing it.', 'Naomi Watts, Martin Henderson, David Dorfman, Brian Cox', 'A journalist must investigate a mysterious videotape which seems to cause the death of anyone in a week of viewing it.', NULL, NULL),
(20, 2, 5, 'Final Destination', 'fichier.avi', 2000, 'http://ia.media-imdb.com/images/M/MV5BMTU4OTI4OTI4OF5BMl5BanBnXkFtZTgwMDA1MzkyMTE@._V1_SX300.jpg', 'After a teenager has a terrifying vision of him and his friends dying in a plane crash, he prevents the accident only to have Death hunt them down, one by one.', 'Devon Sawa, Ali Larter, Kerr Smith, Kristen Cloke', 'After a teenager has a terrifying vision of him and his friends dying in a plane crash, he prevents the accident only to have Death hunt them down, one by one.', NULL, NULL),
(21, 2, 5, 'Final Destination 2', 'fichier.avi', 2003, 'http://ia.media-imdb.com/images/M/MV5BMjEwMDc5MDg1NV5BMl5BanBnXkFtZTYwNzIzMTg5._V1_SX300.jpg', 'When Kimberly has a violent premonition of a highway pileup she blocks the freeway, keeping a few others meant to die, safe...Or are they? The survivors mysteriously start dying and it''s up to Kimberly to stop it before she''s next.', 'Ali Larter, A.J. Cook, Michael Landes, David Paetkau', 'When Kimberly has a violent premonition of a highway pileup she blocks the freeway, keeping a few others meant to die, safe...Or are they? The survivors mysteriously start dying and it''s up to Kimberly to stop it before she''s next.', NULL, NULL),
(22, 2, 5, 'Final Destination 3', 'fichier.avi', 2006, 'http://ia.media-imdb.com/images/M/MV5BMTg2MzI0MzczOF5BMl5BanBnXkFtZTcwNzAyODExMw@@._V1_SX300.jpg', 'In this third installment of the Final Destination series, a student''s premonition of a deadly rollercoaster ride saves her life and a lucky few, but not from death itself which seeks out those who escaped their fate.', 'Mary Elizabeth Winstead, Ryan Merriman, Kris Lemche, Alexz Johnson', 'In this third installment of the Final Destination series, a student''s premonition of a deadly rollercoaster ride saves her life and a lucky few, but not from death itself which seeks out those who escaped their fate.', NULL, NULL),
(23, 2, 5, 'Final Destination 5', 'fichier.avi', 2011, 'http://ia.media-imdb.com/images/M/MV5BMTgyOTExNDc1M15BMl5BanBnXkFtZTcwMDA0MTA4NQ@@._V1_SX300.jpg', 'Survivors of a suspension-bridge collapse learn there''s no way you can cheat Death.', 'Nicholas D''Agosto, Emma Bell, Miles Fisher, Ellen Wroe', 'Survivors of a suspension-bridge collapse learn there''s no way you can cheat Death.', NULL, NULL),
(24, 2, 7, 'Gran Torino', 'fichier.avi', 2008, 'http://ia.media-imdb.com/images/M/MV5BMTQyMTczMTAxMl5BMl5BanBnXkFtZTcwOTc1ODE0Mg@@._V1_SX300.jpg', 'Disgruntled Korean War veteran Walt Kowalski sets out to reform his neighbor, a Hmong teenager who tried to steal Kowalski''s prized possession: a 1972 Gran Torino.', 'Clint Eastwood, Christopher Carley, Bee Vang, Ahney Her', 'Disgruntled Korean War veteran Walt Kowalski sets out to reform his neighbor, a Hmong teenager who tried to steal Kowalski''s prized possession: a 1972 Gran Torino.', NULL, NULL),
(25, 2, 7, 'Million Dollar Baby', 'fichier.avi', 2004, 'http://ia.media-imdb.com/images/M/MV5BMTkxNzA1NDQxOV5BMl5BanBnXkFtZTcwNTkyMTIzMw@@._V1_SX300.jpg', 'A determined woman works with a hardened boxing trainer to become a professional.', 'Clint Eastwood, Hilary Swank, Morgan Freeman, Jay Baruchel', 'A determined woman works with a hardened boxing trainer to become a professional.', NULL, NULL),
(26, 2, 6, 'Inception', 'fichier.avi', 2010, 'http://ia.media-imdb.com/images/M/MV5BMjAxMzY3NjcxNF5BMl5BanBnXkFtZTcwNTI5OTM0Mw@@._V1_SX300.jpg', 'A thief who steals corporate secrets through use of the dream-sharing technology is given the inverse task of planting an idea into the mind of a CEO.', 'Leonardo DiCaprio, Joseph Gordon-Levitt, Ellen Page, Tom Hardy', 'A thief who steals corporate secrets through use of the dream-sharing technology is given the inverse task of planting an idea into the mind of a CEO.', NULL, NULL),
(27, 2, 1, 'Frozen', 'fichier.avi', 2013, 'http://ia.media-imdb.com/images/M/MV5BMTQ1MjQwMTE5OF5BMl5BanBnXkFtZTgwNjk3MTcyMDE@._V1_SX300.jpg', 'When the newly crowned Queen Elsa accidentally uses her power to turn things into ice to curse her home in infinite winter, her sister, Anna, teams up with a mountain man, his playful reindeer, and a snowman to change the weather condition.', 'Kristen Bell, Idina Menzel, Jonathan Groff, Josh Gad', 'When the newly crowned Queen Elsa accidentally uses her power to turn things into ice to curse her home in infinite winter, her sister, Anna, teams up with a mountain man, his playful reindeer, and a snowman to change the weather condition.', NULL, NULL),
(28, 2, 5, 'Monsters, Inc.', 'fichier.avi', 2001, 'http://ia.media-imdb.com/images/M/MV5BMTY1NTI0ODUyOF5BMl5BanBnXkFtZTgwNTEyNjQ0MDE@._V1_SX300.jpg', 'In order to power the city, monsters have to scare children so that they scream. However, the children are toxic to the monsters, and after a child gets through, two monsters realize things may not be what they think.', 'John Goodman, Billy Crystal, Mary Gibbs, Steve Buscemi', 'In order to power the city, monsters have to scare children so that they scream. However, the children are toxic to the monsters, and after a child gets through, two monsters realize things may not be what they think.', NULL, NULL),
(29, 2, 5, 'Monsters University', 'fichier.avi', 2013, 'http://ia.media-imdb.com/images/M/MV5BMTUyODgwMDU3M15BMl5BanBnXkFtZTcwOTM4MjcxOQ@@._V1_SX300.jpg', 'A look at the relationship between Mike and Sulley during their days at Monsters University -- when they weren''t necessarily the best of friends.', 'Billy Crystal, John Goodman, Steve Buscemi, Helen Mirren', 'A look at the relationship between Mike and Sulley during their days at Monsters University -- when they weren''t necessarily the best of friends.', NULL, NULL),
(30, 2, 7, 'Casablanca', 'fichier.avi', 1942, 'http://ia.media-imdb.com/images/M/MV5BMjQwNDYyNTk2N15BMl5BanBnXkFtZTgwMjQ0OTMyMjE@._V1_SX300.jpg', 'Set in Casablanca, Morocco during the early days of World War II: An American expatriate meets a former lover, with unforeseen complications.', 'Humphrey Bogart, Ingrid Bergman, Paul Henreid, Claude Rains', 'Set in Casablanca, Morocco during the early days of World War II: An American expatriate meets a former lover, with unforeseen complications.', NULL, NULL),
(31, 2, 5, 'The Dictator', 'fichier.avi', 2012, 'http://ia.media-imdb.com/images/M/MV5BMjA4NjEyOTc4NV5BMl5BanBnXkFtZTcwODYzMjk2Nw@@._V1_SX300.jpg', 'The heroic story of a dictator who risked his life to ensure that democracy would never come to the country he so lovingly oppressed.', 'Sacha Baron Cohen, Sayed Badreya, Rocky Citron, Liam Campora', 'The heroic story of a dictator who risked his life to ensure that democracy would never come to the country he so lovingly oppressed.', NULL, NULL),
(32, 2, 5, 'The Great Dictator', 'fichier.avi', 1940, 'http://ia.media-imdb.com/images/M/MV5BMTQ5NDAwMDgzOV5BMl5BanBnXkFtZTgwNDI2MjA0MjE@._V1_SX300.jpg', 'Dictator Adenoid Hynkel tries to expand his empire while a poor Jewish barber tries to avoid persecution from Hynkel''s regime.', 'Charles Chaplin, Jack Oakie, Reginald Gardiner, Henry Daniell', 'Dictator Adenoid Hynkel tries to expand his empire while a poor Jewish barber tries to avoid persecution from Hynkel''s regime.', NULL, NULL),
(33, 2, 5, 'Ace Ventura: Pet Detective', 'fichier.avi', 1994, 'http://ia.media-imdb.com/images/M/MV5BMjAzNTI0ODUxOF5BMl5BanBnXkFtZTgwNTQxNzQxMTE@._V1_SX300.jpg', 'A goofy detective specializing in animals goes in search of a missing dolphin mascot of a football team.', 'Jim Carrey, Courteney Cox, Sean Young, Tone Loc', 'A goofy detective specializing in animals goes in search of a missing dolphin mascot of a football team.', NULL, NULL),
(34, 2, 5, 'Ace Ventura: When Nature Calls', 'fichier.avi', 1995, 'http://ia.media-imdb.com/images/M/MV5BNzMzODY1ODAzNl5BMl5BanBnXkFtZTYwODEzNjE5._V1_SX300.jpg', 'Ace Ventura, Pet Detective, returns from a spiritual quest to investigate the disappearance of a rare white bat, the sacred animal of a tribe in Africa.', 'Jim Carrey, Ian McNeice, Simon Callow, Maynard Eziashi', 'Ace Ventura, Pet Detective, returns from a spiritual quest to investigate the disappearance of a rare white bat, the sacred animal of a tribe in Africa.', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `support`
--

DROP TABLE IF EXISTS `support`;
CREATE TABLE `support` (
  `sup_id` int(10) UNSIGNED NOT NULL,
  `sup_nom` varchar(64) DEFAULT NULL,
  `sup_created` datetime DEFAULT NULL,
  `sup_updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `support`
--

INSERT INTO `support` (`sup_id`, `sup_nom`, `sup_created`, `sup_updated`) VALUES
(1, 'USB 4 Go PARIS', '2016-01-13 00:00:00', '2016-01-13 00:00:00'),
(2, 'HD externe Western Digital', '2016-01-13 00:00:00', '2016-01-13 00:00:00'),
(3, 'USB 64 Go', '2016-01-13 00:00:00', '2016-01-13 00:00:00');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`cat_id`);

--
-- Index pour la table `film`
--
ALTER TABLE `film`
  ADD PRIMARY KEY (`fil_id`),
  ADD KEY `film_FKIndex1` (`cat_id`),
  ADD KEY `film_FKIndex2` (`sup_id`);

--
-- Index pour la table `support`
--
ALTER TABLE `support`
  ADD PRIMARY KEY (`sup_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `cat_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `film`
--
ALTER TABLE `film`
  MODIFY `fil_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT pour la table `support`
--
ALTER TABLE `support`
  MODIFY `sup_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
