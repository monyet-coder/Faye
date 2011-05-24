-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 23, 2011 at 07:43 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `fork`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `categoryID` int(11) NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(255) NOT NULL,
  PRIMARY KEY (`categoryID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`categoryID`, `categoryName`) VALUES
(1, 'Category 1'),
(2, 'Category 2');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `productID` int(11) NOT NULL AUTO_INCREMENT,
  `categoryID` int(11) NOT NULL,
  `productName` varchar(255) NOT NULL,
  `productPrice` int(11) NOT NULL,
  `productDescription` varchar(255) NOT NULL,
  `productStock` int(11) NOT NULL,
  `productPicture` varchar(255) NOT NULL,
  PRIMARY KEY (`productID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=402 ;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productID`, `categoryID`, `productName`, `productPrice`, `productDescription`, `productStock`, `productPicture`) VALUES
(1, 2, 'Product 1', 105000, 'The first product, EVER !', 10, ''),
(2, 1, '947e10e1e62d88f0b56d0da67ad929ce', 100000, '', 0, ''),
(3, 1, 'eceba74b352c3466887520fbf1830327', 100000, '', 0, ''),
(4, 1, '34a3ae123003c048e1c7961c00a93012', 100000, '', 0, ''),
(5, 1, 'f7657f422e3fc73f5091c394079ccd81', 100000, '', 0, ''),
(6, 1, '2db0cae963afeaadf68ef9f24b882d72', 100000, '', 0, ''),
(7, 1, '1a33e02465b2edda2b887d2b23fd63c1', 100000, '', 0, ''),
(8, 1, 'eca924ebee4d5ee47182d39396d14592', 100000, '', 0, ''),
(9, 1, 'd1b00de3ac5960222de84c84bc5296d0', 100000, '', 0, ''),
(10, 1, 'cabfaf4b4ee96a879f8bda8fef88b704', 100000, '', 0, ''),
(11, 1, '6d8d17ac655eb7fe671419dad1539e4a', 100000, '', 0, ''),
(12, 1, '417ad7cce06ae8e96ffe9e82552f7cd0', 100000, '', 0, ''),
(13, 1, 'd98dabe74b0e1890cdf8e9a38e6a1b52', 100000, '', 0, ''),
(14, 1, '9018aee1e2c66c8addeabe7a73b1a420', 100000, '', 0, ''),
(15, 1, 'e740bce7f4593d91c11f8936638a302b', 100000, '', 0, ''),
(16, 1, '866e416001064a82e2cb090da273e610', 100000, '', 0, ''),
(17, 1, '288dd097d22b0ec4c8c94c7c3228d28d', 100000, '', 0, ''),
(18, 1, '493f51aac34ff629685a6eeb7955db0a', 100000, '', 0, ''),
(19, 1, '9675d6373554c7b769d8c6f89a4bcf41', 100000, '', 0, ''),
(20, 1, 'f1b208bac97115dd69e1059a7a74a654', 100000, '', 0, ''),
(21, 1, 'c7701435e1dbb1e86c4b2c2ac5559017', 100000, '', 0, ''),
(22, 1, '65935967e38a2844dc8394f6e7050d10', 100000, '', 0, ''),
(23, 1, 'a6f625d7eab8b960bcee81cc9b5b95bd', 100000, '', 0, ''),
(24, 1, '411dafce18f63426619d7382714e5456', 100000, '', 0, ''),
(25, 1, '19f219c8f0b8a8083d8f24986118187f', 100000, '', 0, ''),
(26, 1, '9758fdb431d1ca39d383d531b0fe4d40', 100000, '', 0, ''),
(27, 1, '92272980b9cfdee992f51441094a755c', 100000, '', 0, ''),
(28, 1, 'fa240a03ddd63bc0e6d4e03ec86ff7b7', 100000, '', 0, ''),
(29, 1, '6f97087c12325d923aecef7e55c62f90', 100000, '', 0, ''),
(30, 1, '6695a2fa12666e95eed2ac8e70eb65c7', 100000, '', 0, ''),
(31, 1, '0bbfc141319bd40236a07cdb356e3750', 100000, '', 0, ''),
(32, 1, '449c4535183a5db1a5bc56c82c7c30ce', 100000, '', 0, ''),
(33, 1, 'b3154ce872464931c3ecde458599a5ce', 100000, '', 0, ''),
(34, 1, 'f2cbd4ff6a7b7f3f3b30441518573ef2', 100000, '', 0, ''),
(35, 1, '8d05c641be12037378c6d33930a0f687', 100000, '', 0, ''),
(36, 1, '07ff526c5c7553ee097821a00327fa44', 100000, '', 0, ''),
(37, 1, '3a325e1f5f19a27487f69ebcaa031e38', 100000, '', 0, ''),
(38, 1, '16992bd4104a0297f77e38de138a5a05', 100000, '', 0, ''),
(39, 1, '80372235b7cbda1553d9da31ad942882', 100000, '', 0, ''),
(40, 1, '7b769c32c07e7208d3c36548e699f69a', 100000, '', 0, ''),
(41, 1, 'e8a8806a1e7ca4257da8dea3d751d7af', 100000, '', 0, ''),
(42, 1, 'a34a42eef47dcae7743ab3ff93136342', 100000, '', 0, ''),
(43, 1, '94eb2cb97513114a8e3441adadcee623', 100000, '', 0, ''),
(44, 1, '0237fa8bb510623fc585f06e384bf77a', 100000, '', 0, ''),
(45, 1, 'f20f8d2b080d60be75ff86361eb7245a', 100000, '', 0, ''),
(46, 1, 'e315dcb6f054f425b0350167616e8261', 100000, '', 0, ''),
(47, 1, 'dd6b59c338aea3703315eccaec026a18', 100000, '', 0, ''),
(48, 1, '58c0b6e14d55e10ba1e39a2455be7dfc', 100000, '', 0, ''),
(49, 1, 'e72ae7e2b5eefbf177bb62255c936e0d', 100000, '', 0, ''),
(50, 1, '0c14bc97cd33f2f00b55d5aba51bc46d', 100000, '', 0, ''),
(51, 1, 'f072103c97a8824943fd34c275737414', 100000, '', 0, ''),
(52, 1, '319586b8fe29ce91587697c8c4feeff8', 100000, '', 0, ''),
(53, 1, '31e98fcbd653398d4171bc4b9a91fd7b', 100000, '', 0, ''),
(54, 1, '198d469e49182423ef943ddbef847ff0', 100000, '', 0, ''),
(55, 1, '4aa1c4bfab40a67a0f4683d068e09314', 100000, '', 0, ''),
(56, 1, 'fc91ed0108b9e8783f9930cb96494a78', 100000, '', 0, ''),
(57, 1, '2116067e8b3089ce5aa883e6a752957b', 100000, '', 0, ''),
(58, 1, '8aef70a1fba9dd684a96286d267eb108', 100000, '', 0, ''),
(59, 1, 'dafcd50257bf7393b0c7da08ec06e7a6', 100000, '', 0, ''),
(60, 1, 'd4d43dd46b66328cabbea8be3d90f0c8', 100000, '', 0, ''),
(61, 1, '4000964d09c5f5f7c51b019d2668b1f4', 100000, '', 0, ''),
(62, 1, 'f6d38db7a3a88e0cc129b9c907c89193', 100000, '', 0, ''),
(63, 1, '128fd8d842f4bcddf2d6d7bce78b6410', 100000, '', 0, ''),
(64, 1, 'b0b7136786228b8659230b6e397ce605', 100000, '', 0, ''),
(65, 1, '18dcdfc65e959c09c5d06c6217052e12', 100000, '', 0, ''),
(66, 1, '7edfbbfa589863ea95600a4fc61e5a79', 100000, '', 0, ''),
(67, 1, 'd9ae760ccdf1ca32381c2d74191fc2ea', 100000, '', 0, ''),
(68, 1, '9ef6a2f3ce5a1fab6d5c2aa4a2ab3766', 100000, '', 0, ''),
(69, 1, '737f6bc37a2a49d294f7af73bbb3cdc0', 100000, '', 0, ''),
(70, 1, '5f1c8d512d503523ce4f9c1c32fcf6be', 100000, '', 0, ''),
(71, 1, '1a239a0338be4438b0e9c4dad974f8e4', 100000, '', 0, ''),
(72, 1, 'c9791bb847e8062f0aa1a4f8ca9e835b', 100000, '', 0, ''),
(73, 1, '69293f129068c76d0fe515c825c8e9b2', 100000, '', 0, ''),
(74, 1, 'a580ca7a4e38c2ec84435882226489d3', 100000, '', 0, ''),
(75, 1, '51d8e7a417bb9356aba24521328bcc9c', 100000, '', 0, ''),
(76, 1, 'fe0e201848e1e74375ee5258de3f0763', 100000, '', 0, ''),
(77, 1, 'ea3a6de09f1d76cfbe3888bc32ba9a3f', 100000, '', 0, ''),
(78, 1, 'fcf7ebcfc6bbe85f7f10f884bb48b6fb', 100000, '', 0, ''),
(79, 1, '7a0f24bf87a20d873a696bc22105a17f', 100000, '', 0, ''),
(80, 1, '8ad67ff5b72debeab57f4a8d1368318b', 100000, '', 0, ''),
(81, 1, '4aa018ed2acd366be5923a5ad1a74e10', 100000, '', 0, ''),
(82, 1, '5459aa0bda629fec164ab7922c9adbbe', 100000, '', 0, ''),
(83, 1, 'ddd5d4fca3acb6355ba42c7c2b15a83b', 100000, '', 0, ''),
(84, 1, '1da5257e5e2ca6f5343bce28dfd74477', 100000, '', 0, ''),
(85, 1, 'a019af2f23544f393d63775ada0bdfaa', 100000, '', 0, ''),
(86, 1, '903fe17accf2d7425265c3a521d20c48', 100000, '', 0, ''),
(87, 1, '5435a67b68410976f1463aaa5cd17aa7', 100000, '', 0, ''),
(88, 1, '1b8aa74d2b18e775646b4aba1fdfcf24', 100000, '', 0, ''),
(89, 1, 'a36a84fae7680a837193a2dca18375be', 100000, '', 0, ''),
(90, 1, 'dca1e7ec4c5e7545479b2a4a8078eaa0', 100000, '', 0, ''),
(91, 1, '5e7923aae7aac17e696acc3011042858', 100000, '', 0, ''),
(92, 1, 'bb71c19cd2e6c9d4d085b1112e60049a', 100000, '', 0, ''),
(93, 1, '4c47f4e115e5b7b3c35b30496d0d819d', 100000, '', 0, ''),
(94, 1, '5852160ddc128aa931f967bd21ca187c', 100000, '', 0, ''),
(95, 1, 'df027629e023acfec41353cfccf5d950', 100000, '', 0, ''),
(96, 1, 'c586ce3d152e63efde1f84b2ef5204d6', 100000, '', 0, ''),
(97, 1, 'f90dcd0a97cbfe54d4ed7fd64475759a', 100000, '', 0, ''),
(98, 1, '6d7fb791f5c62a15ca8805e7e92531e0', 100000, '', 0, ''),
(99, 1, '925cfc9e7aafd894ae31804ac4de63a3', 100000, '', 0, ''),
(100, 1, '1281d98c24f786e559731683caf952c4', 100000, '', 0, ''),
(101, 1, 'df54b130b1ef12ce628c5e62028df923', 100000, '', 0, ''),
(102, 1, '91ac22b700372b4914d7405624e7fbf6', 100000, '', 0, ''),
(103, 1, 'f8b9f2b9f1bbd5e76d3b2be56ce90e47', 100000, '', 0, ''),
(104, 1, '59dda39ec143c73ea5a6e485fd96079f', 100000, '', 0, ''),
(105, 1, 'cc346e2fae96cb8cc60fcf36382de821', 100000, '', 0, ''),
(106, 1, '1c8140caa0c874c60b9a3087f46648e7', 100000, '', 0, ''),
(107, 1, '19f2742c242f7b16cabbfa8f4f6dfeb5', 100000, '', 0, ''),
(108, 1, '9a23a338072cda23c87fdb223d3f9c0f', 100000, '', 0, ''),
(109, 1, 'e25ddb1bfa942eb62ca20336933de8e1', 100000, '', 0, ''),
(110, 1, '26f0a6462e4d957937caf11c2c78d75b', 100000, '', 0, ''),
(111, 1, 'd880edea424910200b15ec223f904f77', 100000, '', 0, ''),
(112, 1, '51832887ab582c7de88051234d2957fc', 100000, '', 0, ''),
(113, 1, '00f9f03eb129856d4aa23c1ee873782c', 100000, '', 0, ''),
(114, 1, 'd0d94f7151a55998457eb088d744f4fa', 100000, '', 0, ''),
(115, 1, '2224647749596b59f328f8768dd04d93', 100000, '', 0, ''),
(116, 1, 'e3f60fd252c5a8e2f508e1c2b190b36d', 100000, '', 0, ''),
(117, 1, '6f3a9836261a996bde498e4da8113258', 100000, '', 0, ''),
(118, 1, '2d7246e6b7c5c46f8a86ef7988d75ff8', 100000, '', 0, ''),
(119, 1, '346b9d868efa9d24d81f034cef330548', 100000, '', 0, ''),
(120, 1, '2feacce8a875770345558e62b943cfc8', 100000, '', 0, ''),
(121, 1, '4cd83815a0238e1078a1a1f11e50214b', 100000, '', 0, ''),
(122, 1, 'fd87deeab63c2f972dd23fde3f71cfd5', 100000, '', 0, ''),
(123, 1, '839bbd094a24b1f4fbf4c672ff3bf07f', 100000, '', 0, ''),
(124, 1, 'd52f1d6b0d7871357fb30e6391e4aa81', 100000, '', 0, ''),
(125, 1, 'c83d783734f04ef58912c4b470b70605', 100000, '', 0, ''),
(126, 1, '52f52444ea1965c10f0ee35c123ca8f9', 100000, '', 0, ''),
(127, 1, '978fce90f09d71b76744e50ce290a062', 100000, '', 0, ''),
(128, 1, '6fee8b06ac5fc1b1db894a98e6b98dec', 100000, '', 0, ''),
(129, 1, '3edfa999fb5edafe169162a27f18f522', 100000, '', 0, ''),
(130, 1, 'a66caa65d6d608939d28b03cd7dbf001', 100000, '', 0, ''),
(131, 1, '8de98c58191b8b9d4244218da499ac38', 100000, '', 0, ''),
(132, 1, '7fc51b192e6a3b5003b248781721769c', 100000, '', 0, ''),
(133, 1, '27b0b3102d5342d068245a90ecafbd7c', 100000, '', 0, ''),
(134, 1, '94dc71e748f853b295cdebd767e6996b', 100000, '', 0, ''),
(135, 1, '2a3bce563a34aac057d04f9377339f7c', 100000, '', 0, ''),
(136, 1, 'f7070cb1597655763da020420dd554d8', 100000, '', 0, ''),
(137, 1, '0b7e5077d0f557886ab8cfe07545a5c1', 100000, '', 0, ''),
(138, 1, 'b53243024e4fd4640bc0cdda3904d711', 100000, '', 0, ''),
(139, 1, '5e1969b2a93b4058236f693c0c232601', 100000, '', 0, ''),
(140, 1, '61fad8501f3c734a10322fba938a934b', 100000, '', 0, ''),
(141, 1, '24560bd3d148a0759508aad55c93c754', 100000, '', 0, ''),
(142, 1, '963e5a98d784dec41a0de14eabe6a05b', 100000, '', 0, ''),
(143, 1, '148e1a5a4f421590ea1ae7b4fe7516b5', 100000, '', 0, ''),
(144, 1, '77dba201765f16290346d99bffcd6be2', 100000, '', 0, ''),
(145, 1, 'f871fd4976beb6d4856b7397d02cb0df', 100000, '', 0, ''),
(146, 1, '6ac7ff46cf1f890904cd4cd779eba18f', 100000, '', 0, ''),
(147, 1, 'a8f20cbf0809c0306faf7896bad05317', 100000, '', 0, ''),
(148, 1, 'fa1830e6bef0be94e72c568fa302b518', 100000, '', 0, ''),
(149, 1, '1a3fcafefe97a75254ea2d5000744954', 100000, '', 0, ''),
(150, 1, 'd161726e6f954b69ed8abea6a08fc80e', 100000, '', 0, ''),
(151, 1, '9e07c4a1c4e8bb38bc42a77bb6470122', 100000, '', 0, ''),
(152, 1, '6e3790232070165da182d0d2e6dcbd42', 100000, '', 0, ''),
(153, 1, 'e7dc9df36f924dddb7f075e7a3e7084c', 100000, '', 0, ''),
(154, 1, 'be1fa7a95ae0dd9f720138d852a81109', 100000, '', 0, ''),
(155, 1, 'cdef58af0f0af3d21e00a961fd8ee3cd', 100000, '', 0, ''),
(156, 1, 'd3ae9b239630f2d02c4df28b213a1595', 100000, '', 0, ''),
(157, 1, '95e8c6b02a2e69b3c66dda8d5dd3f860', 100000, '', 0, ''),
(158, 1, 'e1655c844c6f1591b561ff9c29eaf04c', 100000, '', 0, ''),
(159, 1, '9f8fd203a799e41403f5c8051cd5f602', 100000, '', 0, ''),
(160, 1, '35a387dfdbd72930998f1e44a8b75508', 100000, '', 0, ''),
(161, 1, '90857630588c0401c54fbd6427701f3a', 100000, '', 0, ''),
(162, 1, '04fed834b2e5d5660d4bbaae2fce1370', 100000, '', 0, ''),
(163, 1, '4d520d016c226a3eb24f2ee816af715d', 100000, '', 0, ''),
(164, 1, '38dcbf9e9798b93cdc83347f266f1fc8', 100000, '', 0, ''),
(165, 1, 'bb94f2bc03c989c9c11949fb872eb3e4', 100000, '', 0, ''),
(166, 1, '5f04c3c8e9e48debe8122b8e19fdf861', 100000, '', 0, ''),
(167, 1, '2c8da3f9c3750537bf75659f081ed806', 100000, '', 0, ''),
(168, 1, '07cebee1844891135303b427a6335029', 100000, '', 0, ''),
(169, 1, '63cb4cd8eaa9b4a3e0a12e9416636728', 100000, '', 0, ''),
(170, 1, 'f8f714cd74f9edd3170c3c345cdc64aa', 100000, '', 0, ''),
(171, 1, '6a7779eb859f360bfc8bb2cc27676f7e', 100000, '', 0, ''),
(172, 1, 'b44fa997eb4d693c3a8add6c29639412', 100000, '', 0, ''),
(173, 1, '719cd2054cb9454dbc076cec6e5cf01e', 100000, '', 0, ''),
(174, 1, 'd7c20644e40b0896bf6263c974e5ba40', 100000, '', 0, ''),
(175, 1, '6a7ece0957148fa0975db3b466bab4bb', 100000, '', 0, ''),
(176, 1, '90da0f3b93d90b693e2e74a1c791da2e', 100000, '', 0, ''),
(177, 1, 'ce412a80043bacb5bddf9b9e3ba9fdfd', 100000, '', 0, ''),
(178, 1, '4b40c2b0d32ba015f97057229fdba45c', 100000, '', 0, ''),
(179, 1, '3237429497983cab40d532d7c1d0723b', 100000, '', 0, ''),
(180, 1, '98e76c8bcf245734648189a65f0f2ed1', 100000, '', 0, ''),
(181, 1, '60c759eb96c1de0113bb605faca48385', 100000, '', 0, ''),
(182, 1, '19e9bace36824d5325e129d3ae9a8bb3', 100000, '', 0, ''),
(183, 1, '3c9cbb742c87051d8a4b32624519951b', 100000, '', 0, ''),
(184, 1, '965aa28377ef2c82e923447f664e6ef1', 100000, '', 0, ''),
(185, 1, '95471746fd7b85ea5b0adc5ed72e4d9f', 100000, '', 0, ''),
(186, 1, '233e1d22623c3eae7ba1e4feee4bd54d', 100000, '', 0, ''),
(187, 1, '9956564089448b6a84ae094c5bff110d', 100000, '', 0, ''),
(188, 1, '8a9db479ab5f4b4566dc62821815950a', 100000, '', 0, ''),
(189, 1, '812a2208121c3f472c88fdb213051024', 100000, '', 0, ''),
(190, 1, '4970a267e619f5d1f6f3eb08b8b26b7c', 100000, '', 0, ''),
(191, 1, '0555e475f7486582e68c1194bf1ece03', 100000, '', 0, ''),
(192, 1, '081bdf175507134fd31165c324375a42', 100000, '', 0, ''),
(193, 1, '68763461474802a8a5e9675f3ec1f3d9', 100000, '', 0, ''),
(194, 1, 'eb2b4c1f3bc2c58e7b170ec987343057', 100000, '', 0, ''),
(195, 1, '2eb66e29a6c87a629111db890234c93a', 100000, '', 0, ''),
(196, 1, '61277f5d5f71825114fc6a40b11b94d4', 100000, '', 0, ''),
(197, 1, '6775ed3a656581b6eef002b6957c7590', 100000, '', 0, ''),
(198, 1, '9c11afd831b535a8eeeda1cedec20485', 100000, '', 0, ''),
(199, 1, '6d9fbc20b7b5d2d95026c0286c0fb254', 100000, '', 0, ''),
(200, 1, '0d3923febf8d2fdf56c5431942f96258', 100000, '', 0, ''),
(201, 1, '1473c1c1fe7a01f3f96dd096793df250', 100000, '', 0, ''),
(202, 1, '96949a36b12e0fd4ed9d70588a4aa702', 100000, '', 0, ''),
(203, 1, 'effa802c7ae3fbfdccf5e8297a062fde', 100000, '', 0, ''),
(204, 1, '737848678aebe8adff7b4fa4cb020efe', 100000, '', 0, ''),
(205, 1, '9fa8580b9cb16c0a8219bb1e2abeebb6', 100000, '', 0, ''),
(206, 1, '32cf9ba6e3ffecf34dd23e0ca2dce879', 100000, '', 0, ''),
(207, 1, 'af3f3d35eb6eaa30d8f2e9ee4f7057d0', 100000, '', 0, ''),
(208, 1, 'd05272c5465f55282796753af6f23322', 100000, '', 0, ''),
(209, 1, '8a64171d52cbd87cd018947f6ab42410', 100000, '', 0, ''),
(210, 1, 'e7258c3ab3f7e6ce4e0dbd3b90bf8591', 100000, '', 0, ''),
(211, 1, 'b043b6ff11b5c65c69c7f89df8d1ea48', 100000, '', 0, ''),
(212, 1, '7294224dfb22c30a0ca938749e50879c', 100000, '', 0, ''),
(213, 1, 'f5c65e3cb1c3ad1265168e0339fbcaeb', 100000, '', 0, ''),
(214, 1, '6bd1cb334d25a026e0418a3ebd0783a0', 100000, '', 0, ''),
(215, 1, '13abd21ce74f4c8ff20207f4b435521f', 100000, '', 0, ''),
(216, 1, 'd7fc5e66a4ad2288a3d0cb10076bdcbf', 100000, '', 0, ''),
(217, 1, '4e33c0a486b4090edee35d56b1edd3c7', 100000, '', 0, ''),
(218, 1, 'a57b0d4b8fd0ff733468c831e1c25d06', 100000, '', 0, ''),
(219, 1, '1e21a033ed2436ad1c94c63cf6135d02', 100000, '', 0, ''),
(220, 1, '3efd3da95d2d63d099a29932a7a82372', 100000, '', 0, ''),
(221, 1, 'd55e3bb0a3200e0d719ebaa4b5427c43', 100000, '', 0, ''),
(222, 1, 'e6b73dc4d05ea214a053861e8b8d39cd', 100000, '', 0, ''),
(223, 1, '18d99b2caec59268097af7308dd42173', 100000, '', 0, ''),
(224, 1, '25ee610e4aa20d675ada51a7a791c040', 100000, '', 0, ''),
(225, 1, '67994f8aeeddbcc5041ee76a4f8f1abf', 100000, '', 0, ''),
(226, 1, 'bec0a984df14184bc63a7958db320e17', 100000, '', 0, ''),
(227, 1, 'd52205f13a1cba904a71188253af20b4', 100000, '', 0, ''),
(228, 1, 'f8397a2164d458acde48df10b1f9f2a8', 100000, '', 0, ''),
(229, 1, '171ed30cd7d90017aacc81df87bc150e', 100000, '', 0, ''),
(230, 1, '2c8acb191322a6f61eb6b307ddcefd82', 100000, '', 0, ''),
(231, 1, '4fa662b9e62621076c2c0e66320d3eda', 100000, '', 0, ''),
(232, 1, '70f0e5ac536bc6b08d0d957e58584a28', 100000, '', 0, ''),
(233, 1, '0102f52116eeecdc413834439556e8e4', 100000, '', 0, ''),
(234, 1, 'abf4cc6e29f63bfc1043b749ddb41dc5', 100000, '', 0, ''),
(235, 1, 'a80484d75517f4338d3e2f5fcd9ab791', 100000, '', 0, ''),
(236, 1, 'bf5d85445276e2d05fabfef4edbbce1b', 100000, '', 0, ''),
(237, 1, 'c772fafc680b5142b75c43a1add298bb', 100000, '', 0, ''),
(238, 1, 'c0e3eedfb199164eee721eaf0368a28e', 100000, '', 0, ''),
(239, 1, 'cd8b58acabfa8552c00af70e55591010', 100000, '', 0, ''),
(240, 1, 'ac1e481bc0b316cff616ddb0a176af55', 100000, '', 0, ''),
(241, 1, 'f825760c5c4937f42470c1e84d91c4d5', 100000, '', 0, ''),
(242, 1, 'fb17d9b6cf382e45ef5272f8acb81314', 100000, '', 0, ''),
(243, 1, '15a9fb26195be25e64be4e860d780a18', 100000, '', 0, ''),
(244, 1, '972e366fb6b93364cb3fba8cf9d19612', 100000, '', 0, ''),
(245, 1, '27fa68b3fd06ae6ba21475d91fb5f31a', 100000, '', 0, ''),
(246, 1, 'ebdd23b7415ae757acd6cf27167b2952', 100000, '', 0, ''),
(247, 1, '68e2033ac4d976b2dac0e15372adc9c9', 100000, '', 0, ''),
(248, 1, 'fb925e0f2059964965de915b43d0e6c3', 100000, '', 0, ''),
(249, 1, 'a386817438d2420fbd5e0d84d917059a', 100000, '', 0, ''),
(250, 1, '75757fc5fcb57cdbe0193820ed929d51', 100000, '', 0, ''),
(251, 1, '35c72f197743085c860f14fd84bde035', 100000, '', 0, ''),
(252, 1, '3e9e012946c91e61f5cfca0710f807c9', 100000, '', 0, ''),
(253, 1, '4965cc8485940335e27309baeba66dff', 100000, '', 0, ''),
(254, 1, 'ebc0847ec0ad1cba3483e9ca947a66ff', 100000, '', 0, ''),
(255, 1, 'a7b005c1ce173c8f89c7a46d88c3909e', 100000, '', 0, ''),
(256, 1, '105c83528aa28347b18eb36d643276d0', 100000, '', 0, ''),
(257, 1, 'a95ffe4bec32935cd7c35570989009f7', 100000, '', 0, ''),
(258, 1, '58596cefcbc5155bf09c7da3a0d04293', 100000, '', 0, ''),
(259, 1, '393bed1e6f70a0bb559a1cc2af65aea6', 100000, '', 0, ''),
(260, 1, '8f60d43c07d9254e9abf34e0f08e34be', 100000, '', 0, ''),
(261, 1, '988dcbafafb5ff765b025f1e56fc1463', 100000, '', 0, ''),
(262, 1, 'aa5ef3d3d6bd9cfac950f27888e2a182', 100000, '', 0, ''),
(263, 1, 'e19ec7dd05774a1787eead2f6ca65017', 100000, '', 0, ''),
(264, 1, '0185f9a0a378b3053c61058db9933d42', 100000, '', 0, ''),
(265, 1, '4d1d09dd40696e7ea7f4cf15cd269677', 100000, '', 0, ''),
(266, 1, 'c98c8b3e381dd798f1deca0e65ad6023', 100000, '', 0, ''),
(267, 1, 'a3865b87c6856f667e074ed33bf6881b', 100000, '', 0, ''),
(268, 1, '3158e8c30e88b436cb531971c3a4446c', 100000, '', 0, ''),
(269, 1, 'cedbc93cd389afb86f91c0a9bed03269', 100000, '', 0, ''),
(270, 1, '78f990e7fdca4b8530ce2dad561d1342', 100000, '', 0, ''),
(271, 1, '646595b0b47c851475cd33bf69b3d541', 100000, '', 0, ''),
(272, 1, '6547cc237af840c17b999ea377bec72d', 100000, '', 0, ''),
(273, 1, '16650f3994d57dec35c3c3a56321dd9f', 100000, '', 0, ''),
(274, 1, '888f32d722ac2831e9567d242f0d09e9', 100000, '', 0, ''),
(275, 1, '488e47baa7ae88d73c74c9cf7dc237ba', 100000, '', 0, ''),
(276, 1, 'fcfcc3c533164061e6771c19a1118e57', 100000, '', 0, ''),
(277, 1, '31ed45453e5a721800e4155786d984cc', 100000, '', 0, ''),
(278, 1, '37521a09fe9ab29727a57d3e56c24543', 100000, '', 0, ''),
(279, 1, '76a6b1c5b5ddd3ca3b2e5db0cd58bdbf', 100000, '', 0, ''),
(280, 1, '8d8b1b5ee9c5aa85de9c308d0fd11b43', 100000, '', 0, ''),
(281, 1, 'e69d46cd9d92db51034c00d993e3895f', 100000, '', 0, ''),
(282, 1, '8bf14411f03305663daad09d785f51c2', 100000, '', 0, ''),
(283, 1, '94f0957d2dc6990cdbed54d748896c2d', 100000, '', 0, ''),
(284, 1, '99a9b238a18b7a7ef82f010011d48ce3', 100000, '', 0, ''),
(285, 1, '51dd5babff5d16a76bffa69b9b84c05e', 100000, '', 0, ''),
(286, 1, '0299112f530cbcfb38a591441b260a37', 100000, '', 0, ''),
(287, 1, '661ab1a9d98c014399cca7d76ead4c79', 100000, '', 0, ''),
(288, 1, 'fc141c7009ce5096058d8eccb9670991', 100000, '', 0, ''),
(289, 1, '164a3748518c00a0d25e40f231e87102', 100000, '', 0, ''),
(290, 1, '3d6f9aa87b9bac2c268a63a4ae5f9ac8', 100000, '', 0, ''),
(291, 1, '9329767a17643baf4190516c06dd9305', 100000, '', 0, ''),
(292, 1, '5ed1bd83bf6a49be45d52b22010d5449', 100000, '', 0, ''),
(293, 1, '2d5bfe0ff566f7f27371eff32e1ec7aa', 100000, '', 0, ''),
(294, 1, 'cf86191fc33e71b39bce5fb5d84e912f', 100000, '', 0, ''),
(295, 1, '457dd2243abaa864d191ae84c55326b8', 100000, '', 0, ''),
(296, 1, '190bdb058a521cc8498334e54aa3f7be', 100000, '', 0, ''),
(297, 1, 'c9f854504a4a8b7d56e1b05ebe16cc05', 100000, '', 0, ''),
(298, 1, '797928058d7e7a9505cd609e253fef5a', 100000, '', 0, ''),
(299, 1, '230838b72556f7765780717ac00a9d88', 100000, '', 0, ''),
(300, 1, 'dfdb93eda22c9762f65354cda985600e', 100000, '', 0, ''),
(301, 1, 'acce0a57534cf6381fc06a4c7a86f339', 100000, '', 0, ''),
(302, 1, 'a7e8712163789cdebd4af28676ab6e19', 100000, '', 0, ''),
(303, 1, 'fea3812d619ea8a0c16edfd5352226e0', 100000, '', 0, ''),
(304, 1, '47ea6ea0a13e0b64f906554eb04ac791', 100000, '', 0, ''),
(305, 1, '275c1ce5fd09f03a154325fa07d9a0d3', 100000, '', 0, ''),
(306, 1, '2c21564aaa1a46375315045710b4d307', 100000, '', 0, ''),
(307, 1, '0029670496746d6eb5fd017bed1fd674', 100000, '', 0, ''),
(308, 1, 'edef6a20a6cfa894e7995be59c1d81ca', 100000, '', 0, ''),
(309, 1, 'de9656860d93bc2e6e4a2c9639a11933', 100000, '', 0, ''),
(310, 1, 'f4ed03d68bee91b1b05d9746412aec2e', 100000, '', 0, ''),
(311, 1, 'b40e452cbb01cdb250e2fba69c6be489', 100000, '', 0, ''),
(312, 1, 'b8cf9cf5ae44732460b641397540dd8f', 100000, '', 0, ''),
(313, 1, '080c6f059752539a0dc5734afbe3f539', 100000, '', 0, ''),
(314, 1, 'b267bfeab86e142893a4efbc2d764d17', 100000, '', 0, ''),
(315, 1, '9516fd26f201c1b19b10beb557777cf3', 100000, '', 0, ''),
(316, 1, '44380435f3f31381cb04ad263f4376b5', 100000, '', 0, ''),
(317, 1, '17e5d912cbe82e972661e4a1da999187', 100000, '', 0, ''),
(318, 1, 'bf5f816819fec2c09b92cf5d40e66515', 100000, '', 0, ''),
(319, 1, 'e94c2c37e47aaafc31553156cff22951', 100000, '', 0, ''),
(320, 1, '2020c5c0bacd80ffcac4f3a1a7725708', 100000, '', 0, ''),
(321, 1, '20cd0f35c5a28ddb75258215a8868243', 100000, '', 0, ''),
(322, 1, '35910ea7c7193e149c42eda0474715b5', 100000, '', 0, ''),
(323, 1, '1b864cc82335d72216d9c72fb239d94a', 100000, '', 0, ''),
(324, 1, 'ed496bb1880380ecb3b9a0a1b97e8b91', 100000, '', 0, ''),
(325, 1, '769faeb975736a5b0ecbeb6412a0061c', 100000, '', 0, ''),
(326, 1, '16e2beb7208c5b81e388aca495b4cd44', 100000, '', 0, ''),
(327, 1, '189be13762fa9da77aa4f842557ff649', 100000, '', 0, ''),
(328, 1, '045af9ce4562794cf3b488ebb900de95', 100000, '', 0, ''),
(329, 1, 'cb8b46f8fdba9b4181458fa4008e38a5', 100000, '', 0, ''),
(330, 1, '901f16c3fda017573e5506dd1079018b', 100000, '', 0, ''),
(331, 1, '852ef5c0b94e0f7386b2f8c75bca03b4', 100000, '', 0, ''),
(332, 1, 'ff0dea382df2f5219b44f1e5d86c4815', 100000, '', 0, ''),
(333, 1, 'd98f5cf79b0c6e9f081f775ee0e5bf77', 100000, '', 0, ''),
(334, 1, 'ace18517842cd79630c77fda626f1ccb', 100000, '', 0, ''),
(335, 1, '919b17533e68b06baf41887f9603be73', 100000, '', 0, ''),
(336, 1, '826af9872b8168c0f4ac21497cb4f6e7', 100000, '', 0, ''),
(337, 1, '89336bef27cd07b828a2c69174dd6f23', 100000, '', 0, ''),
(338, 1, 'b75c796b49bc3a764708230adbdc921c', 100000, '', 0, ''),
(339, 1, '42604f636238eea0e39529d62eb85fce', 100000, '', 0, ''),
(340, 1, 'b248ecc1f01d80543846f4ffe64640a2', 100000, '', 0, ''),
(341, 1, 'fcf2000f94c3bc42fc8e821d30b46f0d', 100000, '', 0, ''),
(342, 1, '7df93fe435da3e0a2c13ebade7fc9e1d', 100000, '', 0, ''),
(343, 1, '45fe997b6079f3190545e2885217854b', 100000, '', 0, ''),
(344, 1, 'd460a120d3ea2a07fb410253ae05f01e', 100000, '', 0, ''),
(345, 1, 'e6da1c8be5a274c81cbe2c9c2112fb7f', 100000, '', 0, ''),
(346, 1, '4ecd2bbdd8bc38931b2061d76c16df7a', 100000, '', 0, ''),
(347, 1, 'c081bd90272d35e53e680ab206f6ead7', 100000, '', 0, ''),
(348, 1, 'd93a8490b3a0482988260535fd98bc14', 100000, '', 0, ''),
(349, 1, 'b84f17d9bd995f75832db98a8522d66b', 100000, '', 0, ''),
(350, 1, 'cee8a7c1a9d25af320180686599b94bb', 100000, '', 0, ''),
(351, 1, '4f5a87b45354fa1ff2645521763680ab', 100000, '', 0, ''),
(352, 1, 'bc3a02ac45b30b1cedd9f93b2d1ee01a', 100000, '', 0, ''),
(353, 1, '461bc88fb7a6f16a2f66dc479a2f0fd6', 100000, '', 0, ''),
(354, 1, '6fcdc499b3d2fcb76398dc7e253f5f9b', 100000, '', 0, ''),
(355, 1, '623576dc013a1ce9029d582be5805805', 100000, '', 0, ''),
(356, 1, '26297e259757d1c7a42060250a562ff4', 100000, '', 0, ''),
(357, 1, '643ddfe46a445d3b667d1b2dadad37bc', 100000, '', 0, ''),
(358, 1, '8dd2a5787e2b572c70ed1d9c14efb7ec', 100000, '', 0, ''),
(359, 1, '37c67667a9f9d7c6bc1f30a65b16d001', 100000, '', 0, ''),
(360, 1, 'f59fa39da1b47a89ff9d87b227727e7e', 100000, '', 0, ''),
(361, 1, 'adf0c4947f0f931819059f817b335d7f', 100000, '', 0, ''),
(362, 1, '57c31f7b0d9db64f990730369734cf13', 100000, '', 0, ''),
(363, 1, '7442d0f0e30792508cd8568b718c143f', 100000, '', 0, ''),
(364, 1, '8e794ff6fbfc69896a2cd812e0b6f3bc', 100000, '', 0, ''),
(365, 1, '213bef52c6b98335dd6045f302d3c966', 100000, '', 0, ''),
(366, 1, 'eb42b7942ccea6005fa48de5007e1e79', 100000, '', 0, ''),
(367, 1, 'a6b56915123614eae80d6a63c99a1bdb', 100000, '', 0, ''),
(368, 1, '033b42f672dc17d4eace3d7d8d7acff8', 100000, '', 0, ''),
(369, 1, 'bb55c2147c8d9dc4f463a117c225f533', 100000, '', 0, ''),
(370, 1, '2963e2bbd67a5089de481a8ee2c6c1b2', 100000, '', 0, ''),
(371, 1, '4519e3be42518367d56f0c51aed0cedb', 100000, '', 0, ''),
(372, 1, 'e7e1af739cc5a6471b5e7fa8ef6f909f', 100000, '', 0, ''),
(373, 1, 'c4dc2a1db03ff1fcab0efbd07b24303b', 100000, '', 0, ''),
(374, 1, 'ece73ef0f116aa8aacde4dbb1516e9e7', 100000, '', 0, ''),
(375, 1, '991331d64eb85c6500cc7ca5f0181809', 100000, '', 0, ''),
(376, 1, '0d7982a124b94ba199b6c6850f70c3af', 100000, '', 0, ''),
(377, 1, '10ef5f687ef30a589ecd6395de8a5e91', 100000, '', 0, ''),
(378, 1, 'cd172a817392a0249cb211e1757e6e54', 100000, '', 0, ''),
(379, 1, '594786660e19a1c187d7848b4ab7d902', 100000, '', 0, ''),
(380, 1, 'f64fe99835a24b791580c5bfd75fbb88', 100000, '', 0, ''),
(381, 1, 'cd6b9c99f5c5cb900b17ec36710df536', 100000, '', 0, ''),
(382, 1, 'c800e39b351ef83f2233958d4ccec2f0', 100000, '', 0, ''),
(383, 1, '4aa153f0f75740b47591777506821828', 100000, '', 0, ''),
(384, 1, '724c3b99bc5fddd47530ff1f8efb592b', 100000, '', 0, ''),
(385, 1, '65f53bdef3df7e6a29297c3764e72cb9', 100000, '', 0, ''),
(386, 1, 'be54669427df0a5241652e0e8496729e', 100000, '', 0, ''),
(387, 1, 'dbd74b4c02d12ba02f97c1b3e269843e', 100000, '', 0, ''),
(388, 1, 'ee94bc23297f0a1bf96a0d68d475d571', 100000, '', 0, ''),
(389, 1, '8252df9305c593bd1e91bf3b185f8f75', 100000, '', 0, ''),
(390, 1, '09e77f75046fbc7c1c794a2d1522231e', 100000, '', 0, ''),
(391, 1, '80e6adc96d0802642ee31fc3d61d21aa', 100000, '', 0, ''),
(392, 1, '854cc5848f9631917bdc4e2e1f9afbd4', 100000, '', 0, ''),
(393, 1, '54e020f321b82e33991135d7f14218cd', 100000, '', 0, ''),
(394, 1, '9ba884acac23db7bd9b6d40795d4fe25', 100000, '', 0, ''),
(395, 1, 'b4ecb8ee2bacdfb59ee4cb3161d7139b', 100000, '', 0, ''),
(396, 1, 'e3fb985a1a50166cd811702b52e74a4f', 100000, '', 0, ''),
(397, 1, 'b91f40526f22a1092d420ac0deac43bb', 100000, '', 0, ''),
(398, 1, '8e95fa5337ae089c3abb40d16567e456', 100000, '', 0, ''),
(399, 1, '744429903b1735ab707f3284656b9c0f', 100000, '', 0, ''),
(400, 1, 'c8e5837a9a549d81c923e47027103dc5', 100000, '', 0, ''),
(401, 1, 'ac5319c7888fbbbbcafb73e88ca35ca0', 100000, '', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(15) NOT NULL,
  `password` varchar(32) NOT NULL,
  `userPermission` int(11) NOT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `username`, `password`, `userPermission`) VALUES
(1, 'will', '3ded688ce5d0fe1ab7272d69730ffec4', 1),
(2, 'lala', '', 0),
(3, 'lili', '', 0),
(4, 'lulu', '', 0),
(5, 'lele', '', 0),
(6, 'lolo', '', 0),
(7, 'haha', '', 0),
(8, 'hihi', '', 0),
(9, 'huhu', '', 0),
(10, 'hehe', '', 0);