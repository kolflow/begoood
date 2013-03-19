

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";



-- --------------------------------------------------------

--
-- Table structure for table `Answer`
--

CREATE TABLE IF NOT EXISTS `Answer` (
  `id-a` int(11) NOT NULL AUTO_INCREMENT,
  `uri-a` varchar(255) NOT NULL,
  `answer-value` varchar(255) NOT NULL,
  PRIMARY KEY (`id-a`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;


--
-- Table structure for table `Assert`
--

CREATE TABLE IF NOT EXISTS `Assert` (
  `id-assert` int(11) NOT NULL AUTO_INCREMENT,
  `uri-assert` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `code` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id-assert`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;


-- --------------------------------------------------------

--
-- Table structure for table `concern`
--

CREATE TABLE IF NOT EXISTS `concern` (
  `id-c` int(11) NOT NULL AUTO_INCREMENT,
  `id-assert` int(11) NOT NULL,
  `id-t` int(11) NOT NULL,
  PRIMARY KEY (`id-c`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;



-- --------------------------------------------------------

--
-- Table structure for table `isComposedOf`
--

CREATE TABLE IF NOT EXISTS `isComposedOf` (
  `id-i` int(11) NOT NULL AUTO_INCREMENT,
  `id-p` int(11) NOT NULL,
  `id-t` int(11) NOT NULL,
  `order` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id-i`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;


-- --------------------------------------------------------

--
-- Table structure for table `Plan`
--

CREATE TABLE IF NOT EXISTS `Plan` (
  `id-p` int(11) NOT NULL AUTO_INCREMENT,
  `uri-p` varchar(255) NOT NULL,
  `label-p` varchar(255) NOT NULL,
  `exec-mod` varchar(255) NOT NULL,
  `stop-mod` varchar(255) NOT NULL,
  PRIMARY KEY (`id-p`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;


-- --------------------------------------------------------

--
-- Table structure for table `Report`
--

CREATE TABLE IF NOT EXISTS `Report` (
  `id-r` int(11) NOT NULL AUTO_INCREMENT,
  `uri-r` varchar(255) NOT NULL,
  `exec-date` date NOT NULL,
  `content` longtext NOT NULL,
  `result` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `id-p` int(11) NOT NULL,
  `id-t` int(11) NOT NULL,
  PRIMARY KEY (`id-r`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;


-- --------------------------------------------------------

--
-- Table structure for table `used`
--

CREATE TABLE IF NOT EXISTS `used` (
  `id-u` int(11) NOT NULL AUTO_INCREMENT,
  `id-t` int(11) NOT NULL,
  `id-a` int(11) NOT NULL,
  `generatedBy` varchar(255) NOT NULL,
  `status-u` set('+','-','?') NOT NULL DEFAULT '?',
  PRIMARY KEY (`id-u`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=51 ;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
