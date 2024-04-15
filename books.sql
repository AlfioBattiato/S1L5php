-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2024 at 05:43 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `books`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` smallint(100) UNSIGNED NOT NULL,
  `titolo` varchar(60) NOT NULL,
  `autore` varchar(50) NOT NULL,
  `anno_pubblicazione` date NOT NULL,
  `genere` varchar(50) NOT NULL,
  `img` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `titolo`, `autore`, `anno_pubblicazione`, `genere`, `img`) VALUES
(1, 'Terre perdute', 'Lucy', '2024-04-04', 'Narrativa', 'https://cs.ilgiardinodeilibri.it/cop/t/w500/terre-perdute-lucy-cavendish-libro.jpg?_=1704280293'),
(3, 'L\'Attenzione', 'Salvatore Brizzi', '2022-02-02', 'Fantasy', 'https://cs.ilgiardinodeilibri.it/cop/a/w500/attenzione-quaderni-lavoro-se-salvatore-brizzi.jpg?_=1671726774'),
(4, 'Cuore nascosto', ' Ferzan Ozpetek', '2024-04-28', 'romanzo', 'https://www.lafeltrinelli.it/images/9788804745853_0_536_0_75.jpg'),
(5, 'Trudy', 'Massimo Carlotto', '2024-01-25', 'romanzo', 'https://www.lafeltrinelli.it/images/9788806260255_0_536_0_75.jpg'),
(6, 'Un animale selvaggio', 'Joël', '2024-03-25', 'Narrativa', 'https://www.mondadoristore.it/img/Un-animale-selvaggio-Jol-Dicker/ea978883461702/BL/BL/01/NZO/?tit=Un+animale+selvaggio&aut=Jo%C3%ABl+Dicker'),
(7, ' Domani, domani', 'Francesca Giannone', '2024-06-18', 'Narrativa', 'https://www.mondadoristore.it/img/Domani-domani-Francesca-Giannone/ea978884293490/BL/BL/01/NZO/?tit=Domani%2C+domani&aut=Francesca+Giannone'),
(8, ' Leggi un estratto Noi due ci apparteniamo', 'Roberto Saviano', '2024-04-16', ' Reportage e raccolte giornalistiche', 'https://www.mondadoristore.it/img/Noi-due-ci-apparteniamo-Roberto-Saviano/ea979122250004/BL/BL/12/NZO/?tit=Noi+due+ci+apparteniamo.+Sesso%2C+amore%2C+violenza%2C+tradimento+nella+vita+dei+boss&aut=Roberto+Saviano'),
(9, 'Damsel', 'Skye Evelyn', '2024-03-05', 'Narrativa ragazzi', 'https://www.mondadoristore.it/img/Damsel-Skye-Evelyn/ea978881718219/BL/BL/64/NZO/?tit=Damsel&aut=Skye+Evelyn'),
(11, 'Come se tutto fosse un miracolo', 'Daniel Lumera', '2024-04-02', 'Salute Benessere', 'https://www.mondadoristore.it/img/Come-se-tutto-fosse-miracolo-Daniel-Lumera/ea978880479095/BL/BL/63/NZO/?tit=Come+se+tutto+fosse+un+miracolo.+Un+cammino+per+riconquistare+leggerezza%2C+felicit%C3%A0+e+meraviglia&aut=Daniel+Lumera'),
(12, 'Life. La mia storia nella Storia', 'HarperCollins Italia', '2024-02-02', 'Religione-Spiritualità', 'https://www.mondadoristore.it/img/Life-mia-storia-nella-Storia-Fabio-Marchese-Ragona-Papa-Francesco-Jorge-Mario-Bergoglio/ea979125985322/BL/BL/01/NZO/?tit=Life.+La+mia+storia+nella+Storia&aut=Papa+Francesco+%28Jorge+Mario+Bergoglio%29'),
(13, 'Belladonna', 'Adalyn Grace', '2024-04-07', 'romanzo', 'https://www.mondadoristore.it/img/Belladonna-Adalyn-Grace/ea978881718120/BL/BL/64/NZO/?tit=Belladonna&aut=Adalyn+Grace'),
(14, 'In nome della libertà. La forza delle idee di Silvio Berlusc', 'Paolo', '2024-04-09', 'Politica', 'https://www.mondadoristore.it/img/nome-liberta-forza-idee-Paolo-Del-Debbio/ea978885669622/BL/BL/12/NZO/?tit=In+nome+della+libert%C3%A0.+La+forza+delle+idee+di+Silvio+Berlusconi&aut=Paolo+Del+Debbio');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` smallint(100) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
