-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 13, 2013 at 02:33 PM
-- Server version: 5.5.28
-- PHP Version: 5.4.6-1ubuntu1.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `SysTestNonReg`
--

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
-- Dumping data for table `Answer`
--

INSERT INTO `Answer` (`id-a`, `uri-a`, `answer-value`) VALUES
(1, 'http://localhost/StgeV2/answers/1', '1'),
(2, 'http://localhost/StgeV2/answers/2', '2'),
(3, 'http://localhost/StgeV2/answers/3', '3'),
(4, 'http://localhost/StgeV2/answers/4', '4'),
(5, 'http://localhost/StgeV2/answers/5', '5'),
(6, 'http://localhost/StgeV2/answers/6', '6'),
(7, 'http://localhost/StgeV2/answers/7', '7'),
(8, 'http://localhost/StgeV2/answers/8', '8'),
(9, 'http://localhost/StgeV2/answers/9', '9'),
(10, 'http://localhost/StgeV2/answers/10', '10'),
(11, 'http://localhost/StgeV2/answers/11', '11'),
(12, 'http://localhost/StgeV2/answers/12', '12'),
(13, 'http://localhost/StgeV2/answers/13', '13'),
(14, 'http://localhost/StgeV2/answers/14', '14'),
(15, 'http://localhost/StgeV2/answers/15', '15'),
(16, 'http://localhost/StgeV2/answers/16', '16'),
(17, 'http://localhost/StgeV2/answers/17', '17'),
(18, 'http://localhost/StgeV2/answers/18', '18'),
(19, 'http://localhost/StgeV2/answers/19', '19'),
(20, 'http://localhost/StgeV2/answers/20', '20');

-- --------------------------------------------------------

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

--
-- Dumping data for table `Assert`
--

INSERT INTO `Assert` (`id-assert`, `uri-assert`, `label`, `code`) VALUES
(1, 'http://localhost/StgeV2/asserts/1', 'Rp inclus R => Toutes les reponses positives inclus dans R ', '<?xml version="1.0" encoding="UTF-8"?>\r\n  <!DOCTYPE assertion SYSTEM "assertion.dtd">\r\n  <assertion>\r\n  <eq>\r\n  <card>\r\n  <intersect>\r\n  <Rp/><R/>\r\n  </intersect>\r\n  </card>\r\n  <card><Rp/></card>\r\n  </eq>\r\n  </assertion>'),
(2, 'http://localhost/StgeV2/asserts/2', '| Rp inter R | > 2 | Rn inter R | => Toutes les reponses positives inclus dans R sont stictement superieur a deux fois le nombre de reponses negatives dans R   ', '<?xml version="1.0" encoding="UTF-8"?>\n<!DOCTYPE assertion SYSTEM "assertion.dtd">\n<assertion>\n    <gt>\n        <card>\n            <intersect>\n                <Rp/><R/>\n            </intersect>\n        </card>\n        <times>\n            <number>2</number>\n            <card>\n                <intersect>\n                    <Rn/><R/>\n                </intersect>\n            </card>\n        </times>\n    </gt>\n</assertion>\n'),
(3, 'http://localhost/StgeV2/asserts/3', '| Rp inter R | >= | Rn inter R | => Le nombre de reponse positives dans R et superieur ou egal au nombre de reponses negatives dans R   ', '<?xml version="1.0" encoding="UTF-8"?>\n<!DOCTYPE assertion SYSTEM "assertion.dtd">\n<assertion>\n    <ge>\n        <card>\n            <intersect>\n                <Rp/><R/>\n            </intersect>\n        </card>\n        <card>\n            <intersect>\n                <Rn/><R/>\n            </intersect>\n        </card>\n    </ge>\n</assertion>\n'),
(4, 'http://localhost/StgeV2/asserts/4', '| Rp | = 4 => Le nombre de reponse positives est egal a 4', '<?xml version="1.0" encoding="UTF-8"?>\n<!DOCTYPE assertion SYSTEM "assertion.dtd">\n<assertion>\n    <eq>\n        <card>\n            <Rp/>\n        </card>\n        <number>4</number>\n    </eq>\n</assertion>\n'),
(5, 'http://localhost/StgeV2/asserts/5', '| Rp inter R | = 4 => Le nombre de reponse positives de R est egal a 4', '<?xml version="1.0" encoding="UTF-8"?>\n<!DOCTYPE assertion SYSTEM "assertion.dtd">\n<assertion>\n    <eq>\n        <card>\n            <intersect>\n                <Rp/><R/>\n            </intersect>\n        </card>\n        <number>4</number>\n    </eq>\n</assertion>\n'),
(6, 'http://localhost/StgeV2/asserts/6', '5 inclus R => 1 est inclus dans R', '<?xml version="1.0" encoding="UTF-8"?>\n<!DOCTYPE assertion SYSTEM "assertion.dtd">\n<assertion>\n    <neq>\n        <card>\n            <R/>\n        </card>\n        <number>5</number>\n    </neq>\n</assertion>\n');

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

--
-- Dumping data for table `concern`
--

INSERT INTO `concern` (`id-c`, `id-assert`, `id-t`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3);

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

--
-- Dumping data for table `isComposedOf`
--

INSERT INTO `isComposedOf` (`id-i`, `id-p`, `id-t`, `order`) VALUES
(1, 1, 1, '1'),
(2, 1, 2, '2'),
(3, 1, 3, '3'),
(5, 2, 2, '1'),
(6, 2, 3, '2');

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

--
-- Dumping data for table `Plan`
--

INSERT INTO `Plan` (`id-p`, `uri-p`, `label-p`, `exec-mod`, `stop-mod`) VALUES
(1, 'http://localhost/StgeV2/plans', 'plan de test des programmes aléatoires', '1', ''),
(2, 'localhost/sysTestNonReg/plans/2', 'plan de test des programmes aléatoires', '1', '');

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

--
-- Dumping data for table `Report`
--

INSERT INTO `Report` (`id-r`, `uri-r`, `exec-date`, `content`, `result`, `type`, `id-p`, `id-t`) VALUES
(1, 'localhost/SysTestNonReg/reports/1', '2013-01-28', '{"R+":["1","3","5","7"],"R-":["2","4","6","8","9","10"],"Ru":["11","12","13","14","15","16","17","18","19","20"],"R":[1,3,5,7],"asserts":["<?xml version=\\"1.0\\" encoding=\\"UTF-8\\"?>\\r\\n  <!DOCTYPE assertion SYSTEM \\"assertion.dtd\\">\\r\\n  <assertion>\\r\\n  <eq>\\r\\n  <card>\\r\\n  <intersect>\\r\\n  <Rp/><R/>\\r\\n  </intersect>\\r\\n  </card>\\r\\n  <card><Rp/></card>\\r\\n  </eq>\\r\\n  </assertion>"],"results":[true]}', '1', 1, 0, 1),
(2, 'localhost/SysTestNonReg/reports/2', '2013-01-28', '{"R+":["1","3","5","7"],"R-":["2","4","6","8","9","10"],"Ru":["11","12","13","14","15","16","17","18","19","20"],"R":[1,3,5,7],"asserts":["<?xml version=\\"1.0\\" encoding=\\"UTF-8\\"?>\\r\\n  <!DOCTYPE assertion SYSTEM \\"assertion.dtd\\">\\r\\n  <assertion>\\r\\n  <eq>\\r\\n  <card>\\r\\n  <intersect>\\r\\n  <Rp/><R/>\\r\\n  </intersect>\\r\\n  </card>\\r\\n  <card><Rp/></card>\\r\\n  </eq>\\r\\n  </assertion>"],"results":[true]}', '1', 1, 0, 1),
(3, 'localhost/SysTestNonReg/reports/3', '2013-01-28', '{"R+":["1","3","5","7"],"R-":["2","4","6","8","9","10"],"Ru":["11","12","13","14","15","16","17","18","19","20"],"R":[8,8,6,12,6,15,13],"asserts":["<?xml version=\\"1.0\\" encoding=\\"UTF-8\\"?>\\r\\n  <!DOCTYPE assertion SYSTEM \\"assertion.dtd\\">\\r\\n  <assertion>\\r\\n  <eq>\\r\\n  <card>\\r\\n  <intersect>\\r\\n  <Rp/><R/>\\r\\n  </intersect>\\r\\n  </card>\\r\\n  <card><Rp/></card>\\r\\n  </eq>\\r\\n  </assertion>"],"results":[false]}', '', 1, 1, 1),
(4, 'localhost/SysTestNonReg/reports/4', '2013-01-28', '{"R+":["1","3","5","7"],"R-":["2","4","6","8","9","10"],"Ru":["11","12","13","14","15","16","17","18","19","20"],"R":[1,3,5,7,9],"asserts":["<?xml version=\\"1.0\\" encoding=\\"UTF-8\\"?>\\r\\n  <!DOCTYPE assertion SYSTEM \\"assertion.dtd\\">\\r\\n  <assertion>\\r\\n  <eq>\\r\\n  <card>\\r\\n  <intersect>\\r\\n  <Rp/><R/>\\r\\n  </intersect>\\r\\n  </card>\\r\\n  <card><Rp/></card>\\r\\n  </eq>\\r\\n  </assertion>"],"results":[true]}', '1', 1, 1, 1),
(5, 'localhost/SysTestNonReg/reports/5', '2013-01-28', '{"R+":["1","3","5","7"],"R-":["2","4","6","8","9","10"],"Ru":["11","12","13","14","15","16","17","18","19","20"],"R":[1,3,5,7],"asserts":["<?xml version=\\"1.0\\" encoding=\\"UTF-8\\"?>\\r\\n  <!DOCTYPE assertion SYSTEM \\"assertion.dtd\\">\\r\\n  <assertion>\\r\\n  <eq>\\r\\n  <card>\\r\\n  <intersect>\\r\\n  <Rp/><R/>\\r\\n  </intersect>\\r\\n  </card>\\r\\n  <card><Rp/></card>\\r\\n  </eq>\\r\\n  </assertion>"],"results":[true]}', '1', 1, 1, 1),
(6, 'localhost/SysTestNonReg/reports/6', '2013-01-28', '{"R+":["1","3","5","7"],"R-":["2","4","6","8","9","10"],"Ru":["11","12","13","14","15","16","17","18","19","20"],"R":[5,11,8,15,10],"asserts":["<?xml version=\\"1.0\\" encoding=\\"UTF-8\\"?>\\r\\n  <!DOCTYPE assertion SYSTEM \\"assertion.dtd\\">\\r\\n  <assertion>\\r\\n  <eq>\\r\\n  <card>\\r\\n  <intersect>\\r\\n  <Rp/><R/>\\r\\n  </intersect>\\r\\n  </card>\\r\\n  <card><Rp/></card>\\r\\n  </eq>\\r\\n  </assertion>"],"results":[false]}', '', 1, 1, 1),
(7, 'localhost/SysTestNonReg/reports/7', '2013-01-28', '{"R+":["1","3","5","7"],"R-":["2","4","6","8","9","10"],"Ru":["11","12","13","14","15","16","17","18","19","20"],"R":[1,17,20,4,20],"asserts":["<?xml version=\\"1.0\\" encoding=\\"UTF-8\\"?>\\r\\n  <!DOCTYPE assertion SYSTEM \\"assertion.dtd\\">\\r\\n  <assertion>\\r\\n  <eq>\\r\\n  <card>\\r\\n  <intersect>\\r\\n  <Rp/><R/>\\r\\n  </intersect>\\r\\n  </card>\\r\\n  <card><Rp/></card>\\r\\n  </eq>\\r\\n  </assertion>"],"results":[false]}', '', 1, 1, 1),
(8, 'localhost/SysTestNonReg/reports/8', '2013-01-28', '{"R+":["1","3","5","7","9"],"R-":["2","4","6","8","10"],"Ru":["11","12","13","14","15","16","17","18","19","20"],"R":[1,3,5,7,9],"asserts":["<?xml version=\\"1.0\\" encoding=\\"UTF-8\\"?>\\n<!DOCTYPE assertion SYSTEM \\"assertion.dtd\\">\\n<assertion>\\n    <gt>\\n        <card>\\n            <intersect>\\n                <Rp/><R/>\\n            </intersect>\\n        </card>\\n        <times>\\n            <number>2</number>\\n            <card>\\n                <intersect>\\n                    <Rn/><R/>\\n                </intersect>\\n            </card>\\n        </times>\\n    </gt>\\n</assertion>\\n"],"results":[true]}', '1', 1, 1, 2),
(9, 'localhost/SysTestNonReg/reports/9', '2013-01-28', '{"R+":["1","3","5","7"],"R-":["2","4","6","8","9","10"],"Ru":["11","12","13","14","15","16","17","18","19","20"],"R":[9,6,5,6,3],"asserts":["<?xml version=\\"1.0\\" encoding=\\"UTF-8\\"?>\\r\\n  <!DOCTYPE assertion SYSTEM \\"assertion.dtd\\">\\r\\n  <assertion>\\r\\n  <eq>\\r\\n  <card>\\r\\n  <intersect>\\r\\n  <Rp/><R/>\\r\\n  </intersect>\\r\\n  </card>\\r\\n  <card><Rp/></card>\\r\\n  </eq>\\r\\n  </assertion>"],"results":[false]}', '', 1, 1, 1),
(10, 'localhost/SysTestNonReg/reports/10', '2013-01-28', '{"R+":["1","3","5","7","9"],"R-":["2","4","6","8","10"],"Ru":["11","12","13","14","15","16","17","18","19","20"],"R":[1,3,5,7,9],"asserts":["<?xml version=\\"1.0\\" encoding=\\"UTF-8\\"?>\\n<!DOCTYPE assertion SYSTEM \\"assertion.dtd\\">\\n<assertion>\\n    <gt>\\n        <card>\\n            <intersect>\\n                <Rp/><R/>\\n            </intersect>\\n        </card>\\n        <times>\\n            <number>2</number>\\n            <card>\\n                <intersect>\\n                    <Rn/><R/>\\n                </intersect>\\n            </card>\\n        </times>\\n    </gt>\\n</assertion>\\n"],"results":[true]}', '1', 1, 1, 2),
(11, 'localhost/SysTestNonReg/reports/11', '2013-01-28', '1: {"R+":["1","3","5","7"],"R-":["2","4","6","8","9","10"],"Ru":["11","12","13","14","15","16","17","18","19","20"],"R":[9,6,5,6,3],"asserts":["<?xml version=\\"1.0\\" encoding=\\"UTF-8\\"?>\\r\\n  <!DOCTYPE assertion SYSTEM \\"assertion.dtd\\">\\r\\n  <assertion>\\r\\n  <eq>\\r\\n  <card>\\r\\n  <intersect>\\r\\n  <Rp/><R/>\\r\\n  </intersect>\\r\\n  </card>\\r\\n  <card><Rp/></card>\\r\\n  </eq>\\r\\n  </assertion>"],"results":[false]}\n2: {"R+":["1","3","5","7","9"],"R-":["2","4","6","8","10"],"Ru":["11","12","13","14","15","16","17","18","19","20"],"R":[1,3,5,7,9],"asserts":["<?xml version=\\"1.0\\" encoding=\\"UTF-8\\"?>\\n<!DOCTYPE assertion SYSTEM \\"assertion.dtd\\">\\n<assertion>\\n    <gt>\\n        <card>\\n            <intersect>\\n                <Rp/><R/>\\n            </intersect>\\n        </card>\\n        <times>\\n            <number>2</number>\\n            <card>\\n                <intersect>\\n                    <Rn/><R/>\\n                </intersect>\\n            </card>\\n        </times>\\n    </gt>\\n</assertion>\\n"],"results":[true]}\n', '', 0, 1, 0),
(12, 'localhost/SysTestNonReg/reports/12', '2013-01-28', '{"R+":["1","3","5","7"],"R-":["2","4","6","8","9","10"],"Ru":["11","12","13","14","15","16","17","18","19","20"],"R":[20,11,6,9,15,17],"asserts":["<?xml version=\\"1.0\\" encoding=\\"UTF-8\\"?>\\r\\n  <!DOCTYPE assertion SYSTEM \\"assertion.dtd\\">\\r\\n  <assertion>\\r\\n  <eq>\\r\\n  <card>\\r\\n  <intersect>\\r\\n  <Rp/><R/>\\r\\n  </intersect>\\r\\n  </card>\\r\\n  <card><Rp/></card>\\r\\n  </eq>\\r\\n  </assertion>"],"results":[false]}', '', 1, 2, 1),
(13, 'localhost/SysTestNonReg/reports/13', '2013-01-28', '{"R+":["1","3","5","7","9"],"R-":["2","4","6","8","10"],"Ru":["11","12","13","14","15","16","17","18","19","20"],"R":[18,5,17,18,15],"asserts":["<?xml version=\\"1.0\\" encoding=\\"UTF-8\\"?>\\n<!DOCTYPE assertion SYSTEM \\"assertion.dtd\\">\\n<assertion>\\n    <gt>\\n        <card>\\n            <intersect>\\n                <Rp/><R/>\\n            </intersect>\\n        </card>\\n        <times>\\n            <number>2</number>\\n            <card>\\n                <intersect>\\n                    <Rn/><R/>\\n                </intersect>\\n            </card>\\n        </times>\\n    </gt>\\n</assertion>\\n"],"results":[true]}', '1', 1, 2, 2),
(14, 'localhost/SysTestNonReg/reports/14', '2013-01-28', '{"R+":["1","3","5","7"],"R-":["2","4","6","8","9","10"],"Ru":["11","12","13","14","15","16","17","18","19","20"],"R":[1,3,5,7,9],"asserts":["<?xml version=\\"1.0\\" encoding=\\"UTF-8\\"?>\\r\\n  <!DOCTYPE assertion SYSTEM \\"assertion.dtd\\">\\r\\n  <assertion>\\r\\n  <eq>\\r\\n  <card>\\r\\n  <intersect>\\r\\n  <Rp/><R/>\\r\\n  </intersect>\\r\\n  </card>\\r\\n  <card><Rp/></card>\\r\\n  </eq>\\r\\n  </assertion>"],"results":[true]}', '1', 1, 2, 1),
(15, 'localhost/SysTestNonReg/reports/15', '2013-01-28', '{"R+":["1","3","5","7","9"],"R-":["2","4","6","8","10"],"Ru":["11","12","13","14","15","16","17","18","19","20"],"R":[1,3,5,7],"asserts":["<?xml version=\\"1.0\\" encoding=\\"UTF-8\\"?>\\n<!DOCTYPE assertion SYSTEM \\"assertion.dtd\\">\\n<assertion>\\n    <gt>\\n        <card>\\n            <intersect>\\n                <Rp/><R/>\\n            </intersect>\\n        </card>\\n        <times>\\n            <number>2</number>\\n            <card>\\n                <intersect>\\n                    <Rn/><R/>\\n                </intersect>\\n            </card>\\n        </times>\\n    </gt>\\n</assertion>\\n"],"results":[true]}', '1', 1, 2, 2),
(16, 'localhost/SysTestNonReg/reports/16', '2013-01-28', '{"R+":["1","3","5","7"],"R-":["2","4","6","8","9","10"],"Ru":["11","12","13","14","15","16","17","18","19","20"],"R":[1,3,5,7],"asserts":["<?xml version=\\"1.0\\" encoding=\\"UTF-8\\"?>\\r\\n  <!DOCTYPE assertion SYSTEM \\"assertion.dtd\\">\\r\\n  <assertion>\\r\\n  <eq>\\r\\n  <card>\\r\\n  <intersect>\\r\\n  <Rp/><R/>\\r\\n  </intersect>\\r\\n  </card>\\r\\n  <card><Rp/></card>\\r\\n  </eq>\\r\\n  </assertion>"],"results":[true]}', '1', 1, 2, 1),
(17, 'localhost/SysTestNonReg/reports/17', '2013-01-28', '{"R+":["1","3","5","7","9"],"R-":["2","4","6","8","10"],"Ru":["11","12","13","14","15","16","17","18","19","20"],"R":[1,3,5,7],"asserts":["<?xml version=\\"1.0\\" encoding=\\"UTF-8\\"?>\\n<!DOCTYPE assertion SYSTEM \\"assertion.dtd\\">\\n<assertion>\\n    <gt>\\n        <card>\\n            <intersect>\\n                <Rp/><R/>\\n            </intersect>\\n        </card>\\n        <times>\\n            <number>2</number>\\n            <card>\\n                <intersect>\\n                    <Rn/><R/>\\n                </intersect>\\n            </card>\\n        </times>\\n    </gt>\\n</assertion>\\n"],"results":[true]}', '1', 1, 2, 2),
(18, 'localhost/SysTestNonReg/reports/18', '2013-01-28', '{"R+":["1","3","5","7"],"R-":["2","4","6","8","9","10"],"Ru":["11","12","13","14","15","16","17","18","19","20"],"R":[1,3,5,7],"asserts":["<?xml version=\\"1.0\\" encoding=\\"UTF-8\\"?>\\r\\n  <!DOCTYPE assertion SYSTEM \\"assertion.dtd\\">\\r\\n  <assertion>\\r\\n  <eq>\\r\\n  <card>\\r\\n  <intersect>\\r\\n  <Rp/><R/>\\r\\n  </intersect>\\r\\n  </card>\\r\\n  <card><Rp/></card>\\r\\n  </eq>\\r\\n  </assertion>"],"results":[true]}', '1', 1, 2, 1),
(19, 'localhost/SysTestNonReg/reports/19', '2013-01-28', '{"R+":["1","3","5","7","9"],"R-":["2","4","6","8","10"],"Ru":["11","12","13","14","15","16","17","18","19","20"],"R":[1,3,5,7],"asserts":["<?xml version=\\"1.0\\" encoding=\\"UTF-8\\"?>\\n<!DOCTYPE assertion SYSTEM \\"assertion.dtd\\">\\n<assertion>\\n    <gt>\\n        <card>\\n            <intersect>\\n                <Rp/><R/>\\n            </intersect>\\n        </card>\\n        <times>\\n            <number>2</number>\\n            <card>\\n                <intersect>\\n                    <Rn/><R/>\\n                </intersect>\\n            </card>\\n        </times>\\n    </gt>\\n</assertion>\\n"],"results":[true]}', '1', 1, 2, 2),
(20, 'localhost/SysTestNonReg/reports/20', '2013-01-28', '{"R+":["1","3","5","7"],"R-":["2","4","6","8","9","10"],"Ru":["11","12","13","14","15","16","17","18","19","20"],"R":[14,19,3,1],"asserts":["<?xml version=\\"1.0\\" encoding=\\"UTF-8\\"?>\\r\\n  <!DOCTYPE assertion SYSTEM \\"assertion.dtd\\">\\r\\n  <assertion>\\r\\n  <eq>\\r\\n  <card>\\r\\n  <intersect>\\r\\n  <Rp/><R/>\\r\\n  </intersect>\\r\\n  </card>\\r\\n  <card><Rp/></card>\\r\\n  </eq>\\r\\n  </assertion>"],"results":[false]}', '', 1, 2, 1),
(21, 'localhost/SysTestNonReg/reports/21', '2013-01-28', '{"R+":["1","3","5","7","9"],"R-":["2","4","6","8","10"],"Ru":["11","12","13","14","15","16","17","18","19","20"],"R":[1,3,5,7],"asserts":["<?xml version=\\"1.0\\" encoding=\\"UTF-8\\"?>\\n<!DOCTYPE assertion SYSTEM \\"assertion.dtd\\">\\n<assertion>\\n    <gt>\\n        <card>\\n            <intersect>\\n                <Rp/><R/>\\n            </intersect>\\n        </card>\\n        <times>\\n            <number>2</number>\\n            <card>\\n                <intersect>\\n                    <Rn/><R/>\\n                </intersect>\\n            </card>\\n        </times>\\n    </gt>\\n</assertion>\\n"],"results":[true]}', '1', 1, 2, 2),
(22, 'localhost/SysTestNonReg/reports/22', '2013-01-28', '{"R+":["2","4","6","8","10"],"R-":["1","3","5","7","9"],"Ru":[],"R":[1,3,5,7],"asserts":["<?xml version=\\"1.0\\" encoding=\\"UTF-8\\"?>\\n<!DOCTYPE assertion SYSTEM \\"assertion.dtd\\">\\n<assertion>\\n    <ge>\\n        <card>\\n            <intersect>\\n                <Rp/><R/>\\n            </intersect>\\n        </card>\\n        <card>\\n            <intersect>\\n                <Rn/><R/>\\n            </intersect>\\n        </card>\\n    </ge>\\n</assertion>\\n"],"results":[false]}', '', 1, 2, 3),
(23, 'localhost/SysTestNonReg/reports/23', '2013-01-28', '1: {"R+":["1","3","5","7"],"R-":["2","4","6","8","9","10"],"Ru":["11","12","13","14","15","16","17","18","19","20"],"R":[14,19,3,1],"asserts":["<?xml version=\\"1.0\\" encoding=\\"UTF-8\\"?>\\r\\n  <!DOCTYPE assertion SYSTEM \\"assertion.dtd\\">\\r\\n  <assertion>\\r\\n  <eq>\\r\\n  <card>\\r\\n  <intersect>\\r\\n  <Rp/><R/>\\r\\n  </intersect>\\r\\n  </card>\\r\\n  <card><Rp/></card>\\r\\n  </eq>\\r\\n  </assertion>"],"results":[false]}\n2: {"R+":["1","3","5","7","9"],"R-":["2","4","6","8","10"],"Ru":["11","12","13","14","15","16","17","18","19","20"],"R":[1,3,5,7],"asserts":["<?xml version=\\"1.0\\" encoding=\\"UTF-8\\"?>\\n<!DOCTYPE assertion SYSTEM \\"assertion.dtd\\">\\n<assertion>\\n    <gt>\\n        <card>\\n            <intersect>\\n                <Rp/><R/>\\n            </intersect>\\n        </card>\\n        <times>\\n            <number>2</number>\\n            <card>\\n                <intersect>\\n                    <Rn/><R/>\\n                </intersect>\\n            </card>\\n        </times>\\n    </gt>\\n</assertion>\\n"],"results":[true]}\n3: {"R+":["2","4","6","8","10"],"R-":["1","3","5","7","9"],"Ru":[],"R":[1,3,5,7],"asserts":["<?xml version=\\"1.0\\" encoding=\\"UTF-8\\"?>\\n<!DOCTYPE assertion SYSTEM \\"assertion.dtd\\">\\n<assertion>\\n    <ge>\\n        <card>\\n            <intersect>\\n                <Rp/><R/>\\n            </intersect>\\n        </card>\\n        <card>\\n            <intersect>\\n                <Rn/><R/>\\n            </intersect>\\n        </card>\\n    </ge>\\n</assertion>\\n"],"results":[false]}\n', '', 0, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `Test`
--

CREATE TABLE IF NOT EXISTS `Test` (
  `id-t` int(11) NOT NULL AUTO_INCREMENT,
  `uri-t` varchar(255) DEFAULT '$id-t',
  `label-t` varchar(255) NOT NULL,
  `status-t` set('actif','inactif') DEFAULT 'inactif',
  `label-q` varchar(255) NOT NULL,
  `uri-q` varchar(255) NOT NULL,
  PRIMARY KEY (`id-t`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `Test`
--

INSERT INTO `Test` (`id-t`, `uri-t`, `label-t`, `status-t`, `label-q`, `uri-q`) VALUES
(1, 'http://localhost/StgeV2/tests/1', 'Les nombres premiers inférieurs ou egal à 20', 'actif', 'programme de test aléatoire', 'localhost/QueryTest/'),
(2, 'http://localhost/StgeV2/tests/2', 'Les nombres impairs inferieur ou egal a 20', 'actif', 'programme de test aléatoire', 'localhost/QueryTest/'),
(3, 'localhost/sysTestNonReg/tests/3', 'Les nombres pairs inferieur ou egal a 20', 'actif', 'programme de test aléatoire', 'localhost/QueryTest/');

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

--
-- Dumping data for table `used`
--

INSERT INTO `used` (`id-u`, `id-t`, `id-a`, `generatedBy`, `status-u`) VALUES
(1, 1, 1, 'admin', '+'),
(2, 2, 1, 'admin', '+'),
(3, 1, 2, 'admin', '-'),
(4, 2, 2, 'admin', '-'),
(5, 1, 3, 'juliette', '+'),
(6, 2, 3, ' ', '+'),
(7, 1, 4, ' ', '-'),
(8, 2, 4, ' ', '-'),
(9, 1, 5, 'juliette', '+'),
(10, 2, 5, 'Admin', '+'),
(11, 1, 6, 'Admin', '-'),
(12, 2, 6, '', '-'),
(13, 1, 7, '', '+'),
(14, 2, 7, '', '+'),
(15, 1, 8, '', '-'),
(16, 2, 8, '', '-'),
(17, 1, 9, '', '-'),
(18, 2, 9, '', '+'),
(19, 1, 10, '', '-'),
(20, 2, 10, '', '-'),
(21, 1, 11, '', '?'),
(22, 1, 12, '', '?'),
(23, 1, 13, '', '?'),
(24, 1, 14, '', '?'),
(25, 1, 15, '', '?'),
(26, 1, 16, '', '?'),
(27, 1, 17, '', '?'),
(28, 1, 18, '', '?'),
(29, 1, 19, '', '?'),
(30, 1, 20, '', '?'),
(31, 2, 11, '', '?'),
(32, 2, 12, '', '?'),
(33, 2, 13, '', '?'),
(34, 2, 14, '', '?'),
(35, 2, 15, '', '?'),
(36, 2, 16, '', '?'),
(37, 2, 17, '', '?'),
(38, 2, 18, '', '?'),
(39, 2, 19, '', '?'),
(40, 2, 20, '', '?'),
(41, 3, 1, 'Laura', '-'),
(42, 3, 2, 'Laura', '+'),
(43, 3, 3, 'Laura', '-'),
(44, 3, 4, 'Laura', '+'),
(45, 3, 5, 'Laura', '-'),
(46, 3, 6, 'Laura', '+'),
(47, 3, 7, 'Laura', '-'),
(48, 3, 8, 'Laura', '+'),
(49, 3, 9, 'Laura', '-'),
(50, 3, 10, 'Laura', '+');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
