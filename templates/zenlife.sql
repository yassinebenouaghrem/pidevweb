-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 09 avr. 2021 à 14:15
-- Version du serveur :  10.4.17-MariaDB
-- Version de PHP : 7.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `zenlife`
--

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `ID_Commande` int(11) NOT NULL,
  `ID_Panier` int(11) DEFAULT NULL,
  `ID_Produit` int(11) DEFAULT NULL,
  `Quantitee` int(11) DEFAULT NULL,
  `Prix_U` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`ID_Commande`, `ID_Panier`, `ID_Produit`, `Quantitee`, `Prix_U`) VALUES
(40, 25, 3, 3, 8),
(41, 26, 1, 2, 10),
(42, 27, 3, 1, 8),
(43, 27, 44, 2, 100),
(44, 28, 1, 2, 10),
(47, 30, 44, 2, 100),
(48, 30, 1, 1, 10);

-- --------------------------------------------------------

--
-- Structure de la table `consultation`
--

CREATE TABLE `consultation` (
  `id` int(11) NOT NULL,
  `idtherapeute` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `emplacement` varchar(255) NOT NULL,
  `prix` double NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `consultation`
--

INSERT INTO `consultation` (`id`, `idtherapeute`, `titre`, `description`, `emplacement`, `prix`, `image`) VALUES
(18, 78546523, 'Dr fahd', 'Kinésithérapeute', 'Djerba', 40, 'C:\\Users\\foura\\OneDrive\\Documents\\projetlast\\Projettest\\src\\therapeuteimg\\images.jpg'),
(19, 13412313, 'thérapeute Sami', 'therapeute ', 'Tunis,marsa', 50, 'C:\\Users\\foura\\OneDrive\\Documents\\projetlast\\Projettest\\src\\therapeuteimg\\Karim-Fathi-Berrada-Psychologue-Toulouse-Centre.jpg'),
(20, 13412313, 'thérapeute', 'Acupuncture\nMédecin homéopathe\nPhytothérapeute', 'Tunis,ariana,Rue Abdelhafidh El Mekki ', 65, 'C:\\Users\\foura\\OneDrive\\Documents\\projetlast\\Projettest\\src\\therapeuteimg\\therap1.jpg'),
(21, 13412313, 'thérapeute', 'Langues parlées\nFrançais\nAnglais', 'Tunis,centreville rue de marseille 4', 50, 'C:\\Users\\foura\\OneDrive\\Documents\\projetlast\\Projettest\\src\\therapeuteimg\\4.jpg'),
(27, 78546523, 'thérapeute', 'Langues parlées\nFrançais\nAnglais', 'manouba', 50, 'C:\\Users\\foura\\OneDrive\\Documents\\projetlast\\Projettest\\src\\therapeuteimg\\2.jpg'),
(29, 78546523, 'therapeute', 'un pro thérapeute', 'Tunis,hay el zouhour 4rue de nakhla', 65, 'C:\\Users\\foura\\OneDrive\\Documents\\projetlast\\Projettest\\src\\therapeuteimg\\celine-aubian-psychologue-et-psychotherapeute-tecc_ci3.jpg'),
(32, 78546523, 'Dr sami', 'thépraute adssad', 'Tunis,rue de manga', 62, 'C:\\Users\\foura\\OneDrive\\Documents\\projetlast\\Projettest\\src\\therapeuteimg\\devenir-therapeute-psychopraticien.jpg'),
(46, 78546523, 'dah', 'Langues parlées\nFrançais\nAnglais', 'manouba', 50, 'C:\\Users\\foura\\OneDrive\\Documents\\projetlast\\Projettest\\src\\therapeuteimg\\2.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `evenement`
--

CREATE TABLE `evenement` (
  `id` int(11) NOT NULL,
  `id_organisateur` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `titre` varchar(50) NOT NULL,
  `description` varchar(300) NOT NULL,
  `lieu` varchar(100) NOT NULL,
  `date_event` date NOT NULL,
  `image` varchar(100) NOT NULL,
  `tarif` float NOT NULL,
  `capacite` int(11) NOT NULL,
  `nb_reservation` int(11) NOT NULL,
  `etat` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `evenement`
--

INSERT INTO `evenement` (`id`, `id_organisateur`, `type`, `titre`, `description`, `lieu`, `date_event`, `image`, `tarif`, `capacite`, `nb_reservation`, `etat`) VALUES
(134, 12, 'Sport et fitness', 'Marathon de Sousse', 'Lorem ipsum dolor sit amet, consectetur \ndipiscing elit. Sed vitae interdum erat, s\ned sodales mauris. Aliquam vel erat ultric\nies, tempor ex nec, luctus lorem. \n', 'Sousse', '2021-03-17', 'marathon.jpg', 5, 25, 25, 'effectue'),
(170, 45, 'Conférence', 'sdf', 'dsf', 'dsf', '2021-03-26', 'hatha-yoga.jpg', 46, 4545, 0, 'effectue'),
(171, 456456, 'Cinéma', '6546', '456456', '456456', '2021-03-26', 'cine.jpg', 456, 56, 0, 'effectue'),
(142, 12, 'Randonnée', 'Sortie Ain Drahem', 'Lorem ipsum dolor sit amet, consectetur \nadipiscing elit, sed do eiusmod tempor \nincididunt ut labore et dolore magna aliqua.\n', 'Ain Drahem', '2021-03-26', 'images.jpg', 15, 20, 0, 'effectue'),
(175, 45, 'Conférence', 'bnbhjhbj', 'sdf', 'dsfdsf', '2021-03-28', 'cine.jpg', 12, 12, 0, 'effectue'),
(173, 45, 'Cinéma', 'kp', 'okpkop', 'kopop', '2021-03-22', 'eskander957fcb98-8511-4247-b754-90dd12ca806b.jpg', 5454, 4545, 0, 'effectue'),
(174, 102, 'Randonnée', 'fdg', 'dfgdfg', 'dfgdfg', '2021-03-22', 'eskander957fcb98-8511-4247-b754-90dd12ca806b.jpg', 22, 22, 0, 'effectue'),
(172, 45, 'Cinéma', 'kp', 'okpkop', 'kopop', '2021-03-28', 'eskander957fcb98-8511-4247-b754-90dd12ca806b.jpg', 5454, 4545, 0, 'effectue'),
(123, 23362, 'Conférence', 'conference sur le bien-être', 'Lorem ipsum dolor sit amet, consectetur \nadipiscing elit, sed do eiusmod tempor \nincididunt ut labore et dolore magna aliqua.\n', 'Tunis', '2021-03-14', 'téléchargement .jpg', 30, 50, 6, 'effectue'),
(124, 12, 'Randonnée', 'Sortie Ain Drahem', 'Lorem ipsum dolor sit amet, consectetur \nadipiscing elit, sed do eiusmod tempor \nincididunt ut labore et dolore magna aliqua.\n', 'Ain Drahem', '2021-03-26', 'images.jpg', 15, 20, 6, 'effectue'),
(136, 12, 'Conférence', 'Validation', 'sdfdsfsdfsdf\ndfgd', 'Tunis', '2021-03-13', 'cine.jpg', 15, 20, 4, 'effectue'),
(141, 12, 'Randonnée', 'Sortie Ain Drahem', 'Lorem ipsum dolor sit amet, consectetur \nadipiscing elit, sed do eiusmod tempor \nincididunt ut labore et dolore magna aliqua.\n', 'Ain Drahem', '2021-03-31', 'images.jpg', 15, 25, 4, 'effectue'),
(140, 12, 'Méditation', 'dfgdfg', 'Lorem ipsum dolor sit amet, consectetur \nadipiscing elit, sed do eiusmod tempor \nincididunt ut labore et dolore magna aliqua.\n', 'dfgdfg', '2021-03-20', 'images.jpg', 15, 20, 0, 'effectue'),
(166, 12, 'Musique', 'skandoura', 'waa', 'waaa', '2021-04-11', 'hatha-yoga.jpg', 10, 12, 0, 'en cours'),
(169, 4545, 'Cinéma', 'gjh', 'ghjghj', 'ghjghj', '2021-03-11', 'yoga.jpg', 454, 545, 0, 'effectue'),
(168, 12, 'Conférence', 'amine', 'amine', 'amine', '2021-05-09', 'jogging.jpg', 10, 10, 1, 'en cours'),
(176, 45, 'Cinéma', 'skan', 'knjkjk', 'knjk', '2021-03-31', 'cine.jpg', 4, 4, 8, 'effectue'),
(177, 47, 'Cinéma', 'skan', 'knjkjk', 'knjk', '2021-04-02', 'cine.jpg', 12, 12, 11, 'en cours');

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `etat` varchar(50) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `notifications`
--

INSERT INTO `notifications` (`id`, `etat`, `date`) VALUES
(1, 'non lu', '2021-04-08 19:57:08'),
(2, 'lu', '2021-04-08 20:02:45'),
(3, 'lu', '2021-04-08 20:02:52');

-- --------------------------------------------------------

--
-- Structure de la table `paniers`
--

CREATE TABLE `paniers` (
  `ID_Panier` int(11) NOT NULL,
  `cin` int(11) DEFAULT NULL,
  `Date_C` date DEFAULT NULL,
  `Date_U` date DEFAULT `Date_C`,
  `Status_panier` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `paniers`
--

INSERT INTO `paniers` (`ID_Panier`, `cin`, `Date_C`, `Date_U`, `Status_panier`) VALUES
(25, 26548945, '2021-03-29', '2021-03-29', 'Livrer'),
(26, 26548945, '2021-03-30', '2021-03-30', 'Payer'),
(27, 26548945, '2021-03-30', '2021-03-30', 'Livrer'),
(28, 26548945, '2021-03-30', '2021-03-30', 'Livrer'),
(30, 26548945, '2021-03-31', '2021-03-31', 'Payer');

-- --------------------------------------------------------

--
-- Structure de la table `payments`
--

CREATE TABLE `payments` (
  `ID_Payment` int(11) NOT NULL,
  `ID_Panier` int(11) DEFAULT NULL,
  `Prix_F` double DEFAULT NULL,
  `Mode_payment` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `payments`
--

INSERT INTO `payments` (`ID_Payment`, `ID_Panier`, `Prix_F`, `Mode_payment`) VALUES
(15, 25, 24, 'Carte'),
(16, 26, 20, 'Espece'),
(18, 28, 20, 'Carte'),
(20, 30, 210, 'Espece');

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `ID_Produit` int(11) NOT NULL,
  `Nom` varchar(20) NOT NULL,
  `Quantitee` int(11) NOT NULL,
  `Type` varchar(225) DEFAULT NULL,
  `Image` varchar(225) DEFAULT NULL,
  `Prix` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`ID_Produit`, `Nom`, `Quantitee`, `Type`, `Image`, `Prix`) VALUES
(1, 'Cosmetique', 15, 'cosmo', 'article1.png', 10),
(3, 'Anti-stressant', 2, 'null', 'article2.png', 8),
(44, 'parfum', 49, 'cosmotique', 'article3.png', 100),
(55, 'hjyh', 219, 'hhg', 'article3.png', 789),
(99, 'gel', 100, 'cosmetique', 'article2.png', 25),
(100, 'vuvuhv', 1, 'null', 'article1.png', 12),
(101, 'gvvhiv', 2, 'guvguv', 'article2.png', 1),
(102, 'hvhivhiv', 2, 'hibhibhijb', 'article1.png', 12),
(104, 'jngjon', 4, 'oignojn', 'article2.png', 45);

-- --------------------------------------------------------

--
-- Structure de la table `promotion`
--

CREATE TABLE `promotion` (
  `id` int(11) NOT NULL,
  `idP` int(11) NOT NULL,
  `valP` int(11) NOT NULL,
  `dateD` date NOT NULL,
  `dateF` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `promotion`
--

INSERT INTO `promotion` (`id`, `idP`, `valP`, `dateD`, `dateF`) VALUES
(1, 44, 55, '2021-03-17', '2021-03-25'),
(2, 55, 55, '2021-05-15', '2021-05-30'),
(3, 77, 55, '2021-04-02', '2021-04-04'),
(4, 88, 77, '2021-03-09', '2021-03-19'),
(5, 99, 20, '2021-03-25', '2021-03-28'),
(6, 100, 85, '2021-06-05', '2021-06-06');

-- --------------------------------------------------------

--
-- Structure de la table `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `rating` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `rating`
--

INSERT INTO `rating` (`id`, `email`, `rating`) VALUES
(1, 'yassine.benouaghrem@esprit.tn', 2),
(2, 'fourat.anane@esprit.tn', 2),
(3, 'marouene.saidi@esprit.tn', 2);

-- --------------------------------------------------------

--
-- Structure de la table `reco`
--

CREATE TABLE `reco` (
  `id` int(11) NOT NULL,
  `titre` varchar(30) NOT NULL,
  `description` varchar(300) NOT NULL,
  `ecrivain` varchar(30) NOT NULL,
  `image` varchar(90) NOT NULL,
  `type` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `reco`
--

INSERT INTO `reco` (`id`, `titre`, `description`, `ecrivain`, `image`, `type`) VALUES
(12, 'les cles', 'livre ecrit en 2000', 'natalie dumont', 'livre3.jpg', 'livre'),
(32, 'validation', 'un article ecrit en 2005', 'victor hugo ', 'article2.png', 'article'),
(127, 'naturel', 'livre ecrit en 2010', 'christophe blanc', 'livre2.png', 'livre'),
(22, 'massage', 'livre ecrit en 1970', 'blaise lloris', 'livre1.jpg', 'livre');

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

CREATE TABLE `reservation` (
  `idreservation` int(11) NOT NULL,
  `idconsultation` int(11) DEFAULT NULL,
  `idclient` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `type` varchar(255) NOT NULL,
  `heure` varchar(250) NOT NULL,
  `etat` varchar(250) DEFAULT 'En attente de confirmation',
  `image` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `reservation`
--

INSERT INTO `reservation` (`idreservation`, `idconsultation`, `idclient`, `date`, `type`, `heure`, `etat`, `image`) VALUES
(206, 78546523, 65322107, '2021-05-16', 'en ligne', '11:30', 'En attente de confirmation', 'C:\\Users\\foura\\OneDrive\\Documents\\projetlast\\Projettest\\src\\therapeuteimg\\therap1.jpg'),
(207, 78546523, 65322107, '2021-04-15', 'a domicile', '11:30', 'En attente de confirmation', 'C:\\Users\\foura\\OneDrive\\Documents\\projetlast\\Projettest\\src\\therapeuteimg\\therap1.jpg'),
(208, 78546523, 65322107, '2021-05-07', 'a domicile', '12:00', 'En attente de confirmation', 'C:\\Users\\foura\\OneDrive\\Documents\\projetlast\\Projettest\\src\\therapeuteimg\\Karim-Fathi-Berrada-Psychologue-Toulouse-Centre.jpg'),
(209, 13412313, 65322107, '2021-05-15', 'a domicile', '11:00', 'En attente de confirmation', 'C:\\Users\\foura\\OneDrive\\Documents\\projetlast\\Projettest\\src\\therapeuteimg\\4.jpg'),
(210, 13412313, 26548945, '2021-05-15', 'a domicile', '15:30', 'En attente de confirmation', 'C:\\Users\\foura\\OneDrive\\Documents\\projetlast\\Projettest\\src\\therapeuteimg\\4.jpg'),
(211, 13412313, 26548945, '2021-05-16', 'en ligne', '14:30', 'En attente de confirmation', 'C:\\Users\\foura\\OneDrive\\Documents\\projetlast\\Projettest\\src\\therapeuteimg\\therap1.jpg'),
(212, 13412313, 26548945, '2021-07-13', 'a domicile', '15:00', 'En attente de confirmation', 'C:\\Users\\foura\\OneDrive\\Documents\\projetlast\\Projettest\\src\\therapeuteimg\\celine-aubian-psychologue-et-psychotherapeute-tecc_ci3.jpg'),
(213, 78546523, 26548945, '2021-06-09', 'en ligne', '10:00', 'Confirmé', 'C:\\Users\\foura\\OneDrive\\Documents\\projetlast\\Projettest\\src\\therapeuteimg\\Karim-Fathi-Berrada-Psychologue-Toulouse-Centre.jpg'),
(214, 13412313, 26548945, '2021-05-15', 'a domicile', '15:00', 'En attente de confirmation', 'C:\\Users\\foura\\OneDrive\\Documents\\projetlast\\Projettest\\src\\therapeuteimg\\therap1.jpg'),
(215, 13412313, 26548945, '2021-06-20', 'a domicile', '14:00', 'Confirmé', 'C:\\Users\\foura\\OneDrive\\Documents\\projetlast\\Projettest\\src\\therapeuteimg\\celine-aubian-psychologue-et-psychotherapeute-tecc_ci3.jpg'),
(216, 13412313, 26548945, '2021-07-17', 'a domicile', '12:00', 'En attente de confirmation', 'C:\\Users\\foura\\OneDrive\\Documents\\projetlast\\Projettest\\src\\therapeuteimg\\devenir-therapeute-psychopraticien.jpg'),
(219, 78546523, 26548945, '2021-05-22', 'en ligne', '10:30', 'En attente de confirmation', 'C:\\Users\\foura\\OneDrive\\Documents\\projetlast\\Projettest\\src\\therapeuteimg\\images.jpg'),
(220, 13412313, 26548945, '2021-06-19', 'a domicile', '11:00', 'En attente de confirmation', 'C:\\Users\\foura\\OneDrive\\Documents\\projetlast\\Projettest\\src\\therapeuteimg\\therap1.jpg'),
(221, 78546523, 26548945, '2021-06-26', 'a domicile', '10:00', 'En attente de confirmation', 'C:\\Users\\foura\\OneDrive\\Documents\\projetlast\\Projettest\\src\\therapeuteimg\\therap1.jpg'),
(222, 13412313, 26548945, '2021-04-16', 'a domicile', '11:00', 'En attente de confirmation', 'C:\\Users\\foura\\OneDrive\\Images\\img.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `reservation_event`
--

CREATE TABLE `reservation_event` (
  `id` int(11) NOT NULL,
  `id_organisateur` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `id_event` int(11) NOT NULL,
  `nb_place` int(11) NOT NULL,
  `total` float NOT NULL,
  `mode_paiement` varchar(50) NOT NULL,
  `etat` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `reservation_event`
--

INSERT INTO `reservation_event` (`id`, `id_organisateur`, `id_client`, `id_event`, `nb_place`, `total`, `mode_paiement`, `etat`) VALUES
(17, 12, 7878, 132, 3, 36, 'Sur place ', 'effectue'),
(9, 6545, 12, 123, 3, 300, 'Sur place ', 'effectue'),
(10, 6545, 12, 124, 2, 500, 'En ligne', 'effectue'),
(11, 12, 12, 132, 5, 25, 'Sur place ', 'effectue'),
(8, 23, 133, 134, 25, 100, 'Sur place ', 'effectue'),
(16, 12, 7878, 132, 4, 48, 'Sur place ', 'effectue'),
(12, 12, 12, 125, 3, 45, 'Sur place ', 'effectue'),
(13, 789, 7878, 122, 5, 125, 'Sur place ', 'effectue'),
(14, 12, 7878, 123, 3, 45, 'Sur place ', 'effectue'),
(15, 12, 7878, 124, 4, 60, 'Sur place ', 'effectue'),
(18, 12, 7878, 136, 4, 60, 'Sur place ', 'effectue'),
(19, 12, 7878, 141, 4, 60, 'Sur place ', 'en cours'),
(20, 12, 7878, 168, 1, 10, 'Sur place ', 'en cours'),
(21, 45, 7878, 177, 1, 12, 'Sur place ', 'en cours'),
(22, 45, 7878, 177, 3, 36, 'Sur place ', 'en cours'),
(23, 45, 7878, 177, 3, 36, 'En ligne', 'en cours'),
(24, 45, 7878, 176, 3, 12, 'En ligne', 'en cours'),
(25, 45, 7878, 177, 2, 24, 'Sur place ', 'en cours'),
(26, 45, 7878, 176, 5, 20, 'En ligne', 'en cours'),
(27, 45, 98989898, 177, 2, 24, 'En ligne', 'en cours');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `cin` int(11) NOT NULL,
  `email` varchar(30) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `password` varchar(80) NOT NULL,
  `type` varchar(30) NOT NULL,
  `numtel` int(11) DEFAULT NULL,
  `adresse` varchar(30) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `etat` varchar(30) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `cin`, `email`, `nom`, `prenom`, `password`, `type`, `numtel`, `adresse`, `image`, `etat`) VALUES
(1, 75462318, 'a@esprit.tn', 'aaaa', 'bbbbb', '456c3816494a33a4b404583cc54ffcb7', 'client', NULL, NULL, NULL, 'inscrit'),
(2, 78546523, 'eskander@zenlife.tn', 'aaaaaaaaa', 'eskander', '456c3816494a33a4b404583cc54ffcb7', 'therapeute', 99999999, 'aaaaaaaaaa', NULL, NULL),
(3, 13412313, 'a@esprit.tn', 'aaaa', 'bbbbb', '456c3816494a33a4b404583cc54ffcb7', 'therapeute', NULL, NULL, NULL, NULL),
(4, 98989898, 'yassine.benouaghrem@esprit.tn', 'yassine', 'benouaghrem', '456c3816494a33a4b404583cc54ffcb7', 'client', NULL, NULL, NULL, 'inscrit'),
(5, 58989892, 'ab@zenlife.tn', 'mmmm', 'bbbbb', '3dbe00a167653a1aaee01d93e77e730e', 'therapeute', 12121212, 'aaaaaaaaa', NULL, NULL),
(6, 14768323, 'abc@abc.fr', 'jguirim', 'eskander', '456c3816494a33a4b404583cc54ffcb7', 'client', NULL, NULL, NULL, 'inscrit'),
(7, 65322107, 'rami@esprit.tn', 'rami', 'belkhouja', '25d55ad283aa400af464c76d713c07ad', 'client', NULL, NULL, NULL, 'banned'),
(8, 28653254, 'zenlifezenlife02@gmail.com', 'zenlife', 'zenlife', '456c3816494a33a4b404583cc54ffcb7', 'admin', NULL, NULL, NULL, NULL),
(9, 65322102, 'mohamed@esprit.tn', 'mohamed', 'belkhouja', '25d55ad283aa400af464c76d713c07ad', 'client', NULL, NULL, NULL, 'banned'),
(10, 74174177, 'aaaaaa@', 'aaaa', 'bbbbbbbb', '45e4812014d83dde5666ebdf5a8ed1ed', 'client', NULL, NULL, NULL, 'inscrit'),
(11, 26548945, 'fourat.anane@esprit.tn', 'fourat', 'anane', '456c3816494a33a4b404583cc54ffcb7', 'client', NULL, NULL, NULL, 'inscrit');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`ID_Commande`),
  ADD KEY `fk_pan_com` (`ID_Panier`);

--
-- Index pour la table `consultation`
--
ALTER TABLE `consultation`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `evenement`
--
ALTER TABLE `evenement`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `paniers`
--
ALTER TABLE `paniers`
  ADD PRIMARY KEY (`ID_Panier`);

--
-- Index pour la table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`ID_Payment`),
  ADD KEY `fk_pan_pay` (`ID_Panier`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`ID_Produit`);

--
-- Index pour la table `promotion`
--
ALTER TABLE `promotion`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reco`
--
ALTER TABLE `reco`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`idreservation`);

--
-- Index pour la table `reservation_event`
--
ALTER TABLE `reservation_event`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `ID_Commande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT pour la table `consultation`
--
ALTER TABLE `consultation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT pour la table `evenement`
--
ALTER TABLE `evenement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;

--
-- AUTO_INCREMENT pour la table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `paniers`
--
ALTER TABLE `paniers`
  MODIFY `ID_Panier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `payments`
--
ALTER TABLE `payments`
  MODIFY `ID_Payment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `ID_Produit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT pour la table `promotion`
--
ALTER TABLE `promotion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `reco`
--
ALTER TABLE `reco`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT pour la table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `idreservation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=223;

--
-- AUTO_INCREMENT pour la table `reservation_event`
--
ALTER TABLE `reservation_event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
