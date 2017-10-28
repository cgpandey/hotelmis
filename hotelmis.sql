-- phpMyAdmin SQL Dump
-- version 2.8.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost:3306
-- Generation Time: Sep 05, 2006 at 04:27 PM
-- Server version: 5.0.15
-- PHP Version: 5.0.5
-- 
-- Database: `hotelmis`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `agents`
-- 

CREATE TABLE `agents` (
  `agentid` int(11) NOT NULL auto_increment,
  `agentname` varchar(65) NOT NULL,
  `agents_ac_no` char(6) NOT NULL,
  `contact_person` varchar(65) default NULL,
  `telephone` varchar(21) default NULL,
  `fax` varchar(21) default NULL,
  `email` varchar(50) default NULL,
  `billing_address` varchar(15) default NULL,
  `town` varchar(35) default NULL,
  `postal_code` int(10) default NULL,
  `road_street` varchar(65) default NULL,
  `building` varchar(65) default NULL,
  `ratesid` int(11) default NULL,
  PRIMARY KEY  (`agentid`),
  UNIQUE KEY `agentcode` (`agents_ac_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 120832 kB; InnoDB free: 120832 kB; InnoDB free:' AUTO_INCREMENT=12 ;

-- 
-- Dumping data for table `agents`
-- 

INSERT INTO `agents` (`agentid`, `agentname`, `agents_ac_no`, `contact_person`, `telephone`, `fax`, `email`, `billing_address`, `town`, `postal_code`, `road_street`, `building`, `ratesid`) VALUES (1, 'Kemri', 'K001', 'Hamida', '254-(0)41-522063', NULL, NULL, '230', 'Kilifi', 80108, NULL, NULL, 0),
(2, 'Plan', 'K002', 'Johnson', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(5, 'Kiteco', 'K003', 'Charo', '', '', '', NULL, '', NULL, '', '', 0),
(6, 'Kilifi District Hospital', 'K006', 'Saulo', '', '', '', NULL, '', NULL, NULL, 'NULL', 0),
(7, 'Mnarani', 'K009', 'Steve', '', '', '', NULL, '', NULL, NULL, 'NULL', 0),
(8, 'KDDP', 'K010', 'Kombe', '', '', '', NULL, '', NULL, NULL, 'NULL', 0),
(9, 'TTN', 'K015', 'Tony', '', '', '', NULL, '', NULL, NULL, 'NULL', 0),
(10, 'World Vision', 'K055', 'Terry', '500263', NULL, NULL, '748', 'Kilifi', NULL, NULL, NULL, 0),
(11, 'Wonder Nuts', 'KN008', 'Pandre', '522063', NULL, NULL, '389', 'Kilifi', 80108, NULL, NULL, NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `bills`
-- 

CREATE TABLE `bills` (
  `bill_id` int(11) NOT NULL auto_increment,
  `book_id` int(11) NOT NULL COMMENT 'booking/reservation id',
  `date_billed` datetime NOT NULL,
  `billno` int(11) NOT NULL default '0',
  `status` tinyint(4) default NULL,
  `date_checked` date default NULL,
  PRIMARY KEY  (`bill_id`,`billno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 120832 kB; InnoDB free: 120832 kB; InnoDB free:' AUTO_INCREMENT=5 ;

-- 
-- Dumping data for table `bills`
-- 

INSERT INTO `bills` (`bill_id`, `book_id`, `date_billed`, `billno`, `status`, `date_checked`) VALUES (1, 1, '2006-08-22 00:00:00', 1, NULL, NULL),
(2, 2, '2006-08-27 00:00:00', 2, NULL, NULL),
(3, 3, '2006-08-29 00:00:00', 3, NULL, NULL),
(4, 1, '2006-08-29 00:00:00', 1, NULL, NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `booking`
-- 

CREATE TABLE `booking` (
  `book_id` int(11) NOT NULL auto_increment,
  `guestid` varchar(40) NOT NULL,
  `booking_type` char(1) NOT NULL COMMENT 'direct/agent',
  `meal_plan` char(2) NOT NULL COMMENT 'bo/bb/hb/fb',
  `no_adults` tinyint(2) default NULL,
  `no_child` tinyint(2) default NULL,
  `checkin_date` date NOT NULL,
  `checkout_date` date NOT NULL,
  `residence_id` char(2) default NULL COMMENT 'country_code',
  `payment_mode` tinyint(2) default NULL,
  `agents_ac_no` char(6) default NULL,
  `roomid` int(11) NOT NULL,
  `checkedin_by` int(11) default NULL,
  `invoice_no` varchar(15) default NULL,
  `billed` tinyint(1) default NULL,
  `checkoutby` int(5) default NULL,
  `codatetime` datetime default NULL,
  PRIMARY KEY  (`book_id`),
  UNIQUE KEY `id` (`book_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 121856 kB; InnoDB free: 115712 kB; InnoDB free:' AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `booking`
-- 

INSERT INTO `booking` (`book_id`, `guestid`, `booking_type`, `meal_plan`, `no_adults`, `no_child`, `checkin_date`, `checkout_date`, `residence_id`, `payment_mode`, `agents_ac_no`, `roomid`, `checkedin_by`, `invoice_no`, `billed`, `checkoutby`, `codatetime`) VALUES (1, '1', 'D', 'BB', 1, NULL, '2006-08-22', '2006-08-25', 'KE', 1, NULL, 11, 1, NULL, 1, 2, '2006-08-22 16:02:08'),
(2, '2', 'A', 'BO', 1, NULL, '2006-08-27', '2006-08-29', 'KE', 1, NULL, 19, 1, NULL, 1, 2, '2006-08-25 14:52:01'),
(3, '2', 'D', 'BO', 1, NULL, '2006-08-29', '2006-08-31', 'KE', 1, NULL, 18, 1, NULL, 1, NULL, NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `countries`
-- 

CREATE TABLE `countries` (
  `countryid` smallint(6) NOT NULL auto_increment,
  `country` varchar(150) NOT NULL,
  `countrycode` char(10) NOT NULL,
  `subscriber` char(19) default NULL,
  `nationality` varchar(150) default NULL,
  `currency` varchar(45) default NULL,
  PRIMARY KEY  (`countryid`),
  UNIQUE KEY `countrycode` (`countrycode`),
  KEY `country` (`country`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 121856 kB; InnoDB free: 121856 kB; InnoDB free:' AUTO_INCREMENT=245 ;

-- 
-- Dumping data for table `countries`
-- 

INSERT INTO `countries` (`countryid`, `country`, `countrycode`, `subscriber`, `nationality`, `currency`) VALUES (1, 'ANDORRA, PRINCIPALITY OF                               ', 'AD', '', NULL, NULL),
(2, 'UNITED ARAB EMIRATES                                   ', 'AE', '971', NULL, NULL),
(3, 'AFGHANISTAN, ISLAMIC STATE OF                          ', 'AF', '', NULL, NULL),
(4, 'ANTIGUA AND BARBUDA                                    ', 'AG', '', NULL, NULL),
(5, 'ANGUILLA                                               ', 'AI', '+1-264*', NULL, NULL),
(6, 'ALBANIA                                                ', 'AL', '355', NULL, NULL),
(7, 'ARMENIA                                                ', 'AM', '374', NULL, NULL),
(8, 'NETHERLANDS ANTILLES                                   ', 'AN', '599', NULL, NULL),
(9, 'ANGOLA                                                 ', 'AO', '244', NULL, NULL),
(10, 'ANTARCTICA                                             ', 'AQ', '672', NULL, NULL),
(11, 'ARGENTINA                                              ', 'AR', '54', NULL, NULL),
(12, 'AMERICAN SAMOA                                         ', 'AS', '684', NULL, NULL),
(13, 'AUSTRIA                                                ', 'AT', '43', NULL, NULL),
(14, 'AUSTRALIA                                              ', 'AU', '61', NULL, NULL),
(15, 'ARUBA                                                  ', 'AW', '297', NULL, NULL),
(16, 'AZERBAIDJAN                                            ', 'AZ', '', NULL, NULL),
(17, 'BOSNIA-HERZEGOVINA                                     ', 'BA', '', NULL, NULL),
(18, 'BARBADOS                                               ', 'BB', '+1-246*', NULL, NULL),
(19, 'BANGLADESH                                             ', 'BD', '880', NULL, NULL),
(20, 'BELGIUM                                                ', 'BE', '32', NULL, NULL),
(21, 'BURKINA FASO                                           ', 'BF', '226', NULL, NULL),
(22, 'BULGARIA                                               ', 'BG', '359', NULL, NULL),
(23, 'BAHRAIN                                                ', 'BH', '973', NULL, NULL),
(24, 'BURUNDI                                                ', 'BI', '257', NULL, NULL),
(25, 'BENIN                                                  ', 'BJ', '229', NULL, NULL),
(26, 'BERMUDA                                                ', 'BM', '+1-441*', NULL, NULL),
(27, 'BRUNEI DARUSSALAM                                      ', 'BN', '673', NULL, NULL),
(28, 'BOLIVIA                                                ', 'BO', '591', NULL, NULL),
(29, 'BRAZIL                                                 ', 'BR', '55', NULL, NULL),
(30, 'BAHAMAS                                                ', 'BS', '+1-242*', NULL, NULL),
(31, 'BHUTAN                                                 ', 'BT', '975', NULL, NULL),
(32, 'BOUVET ISLAND                                          ', 'BV', '', NULL, NULL),
(33, 'BOTSWANA                                               ', 'BW', '267', NULL, NULL),
(34, 'BELARUS                                                ', 'BY', '375', NULL, NULL),
(35, 'BELIZE                                                 ', 'BZ', '501', NULL, NULL),
(36, 'CANADA                                                 ', 'CA', '1', NULL, NULL),
(37, 'COCOS (KEELING) ISLANDS                                ', 'CC', '', NULL, NULL),
(38, 'CENTRAL AFRICAN REPUBLIC                               ', 'CF', '236', NULL, NULL),
(39, 'CONGO, THE DEMOCRATIC REPUBLIC OF THE                  ', 'CD', '', NULL, NULL),
(40, 'CONGO                                                  ', 'CG', '242', NULL, NULL),
(41, 'SWITZERLAND                                            ', 'CH', '41', NULL, NULL),
(42, 'IVORY COAST (COTE D''IVOIRE)                            ', 'CI', '', NULL, NULL),
(43, 'COOK ISLANDS                                           ', 'CK', '682', NULL, NULL),
(44, 'CHILE                                                  ', 'CL', '56', NULL, NULL),
(45, 'CAMEROON                                               ', 'CM', '237', NULL, NULL),
(46, 'CHINA                                                  ', 'CN', '', NULL, NULL),
(47, 'COLOMBIA                                               ', 'CO', '57', NULL, NULL),
(48, 'COSTA RICA                                             ', 'CR', '506', NULL, NULL),
(49, 'FORMER CZECHOSLOVAKIA                                  ', 'CS', '', NULL, NULL),
(50, 'CUBA                                                   ', 'CU', '53', NULL, NULL),
(51, 'CAPE VERDE                                             ', 'CV', '', NULL, NULL),
(52, 'CHRISTMAS ISLAND                                       ', 'CX', '53', NULL, NULL),
(53, 'CYPRUS                                                 ', 'CY', '357', NULL, NULL),
(54, 'CZECH REPUBLIC                                         ', 'CZ', '420', NULL, NULL),
(55, 'GERMANY                                                ', 'DE', '49', NULL, NULL),
(56, 'DJIBOUTI                                               ', 'DJ', '253', NULL, NULL),
(57, 'DENMARK                                                ', 'DK', '45', NULL, NULL),
(58, 'DOMINICA                                               ', 'DM', '+1-767*', NULL, NULL),
(59, 'DOMINICAN REPUBLIC                                     ', 'DO', '+1-809*', NULL, NULL),
(60, 'ALGERIA                                                ', 'DZ', '213', NULL, NULL),
(61, 'ECUADOR                                                ', 'EC', '593', NULL, NULL),
(62, 'ESTONIA                                                ', 'EE', '372', NULL, NULL),
(63, 'EGYPT                                                  ', 'EG', '20', NULL, NULL),
(64, 'WESTERN SAHARA                                         ', 'EH', '', NULL, NULL),
(65, 'ERITREA                                                ', 'ER', '291', NULL, NULL),
(66, 'SPAIN                                                  ', 'ES', '34', NULL, NULL),
(67, 'ETHIOPIA                                               ', 'ET', '251', NULL, NULL),
(68, 'FINLAND                                                ', 'FI', '358', NULL, NULL),
(69, 'FIJI                                                   ', 'FJ', '', NULL, NULL),
(70, 'FALKLAND ISLANDS                                       ', 'FK', '', NULL, NULL),
(71, 'MICRONESIA                                             ', 'FM', '', NULL, NULL),
(72, 'FAROE ISLANDS                                          ', 'FO', '298', NULL, NULL),
(73, 'FRANCE                                                 ', 'FR', '33', NULL, NULL),
(74, 'FRANCE (EUROPEAN TERRITORY)                            ', 'FX', '', NULL, NULL),
(75, 'GABON                                                  ', 'GA', '', NULL, NULL),
(76, 'GREAT BRITAIN                                          ', 'GB', '', NULL, NULL),
(77, 'GRENADA                                                ', 'GD', '+1-473*', NULL, NULL),
(78, 'GEORGIA                                                ', 'GE', '995', NULL, NULL),
(79, 'FRENCH GUYANA                                          ', 'GF', '', NULL, NULL),
(80, 'GHANA                                                  ', 'GH', '233', NULL, NULL),
(81, 'GIBRALTAR                                              ', 'GI', '350', NULL, NULL),
(82, 'GREENLAND                                              ', 'GL', '299', NULL, NULL),
(83, 'GAMBIA                                                 ', 'GM', '220', NULL, NULL),
(84, 'GUINEA                                                 ', 'GN', '224', NULL, NULL),
(85, 'USA GOVERNMENT                                         ', 'GOV', '', NULL, NULL),
(86, 'GUADELOUPE (FRENCH)                                    ', 'GP', '', NULL, NULL),
(87, 'EQUATORIAL GUINEA                                      ', 'GQ', '240', NULL, NULL),
(88, 'GREECE                                                 ', 'GR', '30', NULL, NULL),
(89, 'S. GEORGIA & S. SANDWICH ISLS.                         ', 'GS', '', NULL, NULL),
(90, 'GUATEMALA                                              ', 'GT', '502', NULL, NULL),
(91, 'GUAM (USA)                                             ', 'GU', '', NULL, NULL),
(92, 'GUINEA BISSAU                                          ', 'GW', '', NULL, NULL),
(93, 'GUYANA                                                 ', 'GY', '592', NULL, NULL),
(94, 'HONG KONG                                              ', 'HK', '852', NULL, NULL),
(95, 'HEARD AND MCDONALD ISLANDS                             ', 'HM', '', NULL, NULL),
(96, 'HONDURAS                                               ', 'HN', '504', NULL, NULL),
(97, 'CROATIA                                                ', 'HR', '385', NULL, NULL),
(98, 'HAITI                                                  ', 'HT', '509', NULL, NULL),
(99, 'HUNGARY                                                ', 'HU', '36', NULL, NULL),
(100, 'INDONESIA                                              ', 'ID', '62', NULL, NULL),
(101, 'IRELAND                                                ', 'IE', '353', NULL, NULL),
(102, 'ISRAEL                                                 ', 'IL', '972', NULL, NULL),
(103, 'INDIA                                                  ', 'IN', '91', NULL, NULL),
(104, 'BRITISH INDIAN OCEAN TERRITORY                         ', 'IO', '', NULL, NULL),
(105, 'IRAQ                                                   ', 'IQ', '964', NULL, NULL),
(106, 'IRAN                                                   ', 'IR', '98', NULL, NULL),
(107, 'ICELAND                                                ', 'IS', '354', NULL, NULL),
(108, 'ITALY                                                  ', 'IT', '39', NULL, NULL),
(109, 'JAMAICA                                                ', 'JM', '+1-876*', NULL, NULL),
(110, 'JORDAN                                                 ', 'JO', '962', NULL, NULL),
(111, 'JAPAN                                                  ', 'JP', '81', NULL, NULL),
(112, 'KENYA                                                  ', 'KE', '254', NULL, NULL),
(113, 'KYRGYZ REPUBLIC (KYRGYZSTAN)                           ', 'KG', '', NULL, NULL),
(114, 'CAMBODIA, KINGDOM OF                                   ', 'KH', '', NULL, NULL),
(115, 'KIRIBATI                                               ', 'KI', '686', NULL, NULL),
(116, 'COMOROS                                                ', 'KM', '269', NULL, NULL),
(117, 'SAINT KITTS & NEVIS ANGUILLA                           ', 'KN', '', NULL, NULL),
(118, 'NORTH KOREA                                            ', 'KP', '', NULL, NULL),
(119, 'SOUTH KOREA                                            ', 'KR', '', NULL, NULL),
(120, 'KUWAIT                                                 ', 'KW', '965', NULL, NULL),
(121, 'CAYMAN ISLANDS                                         ', 'KY', '+1-345*', NULL, NULL),
(122, 'KAZAKHSTAN                                             ', 'KZ', '7', NULL, NULL),
(123, 'LAOS                                                   ', 'LA', '856', NULL, NULL),
(124, 'LEBANON                                                ', 'LB', '961', NULL, NULL),
(125, 'SAINT LUCIA                                            ', 'LC', '', NULL, NULL),
(126, 'LIECHTENSTEIN                                          ', 'LI', '423', NULL, NULL),
(127, 'SRI LANKA                                              ', 'LK', '94', NULL, NULL),
(128, 'LIBERIA                                                ', 'LR', '231', NULL, NULL),
(129, 'LESOTHO                                                ', 'LS', '266', NULL, NULL),
(130, 'LITHUANIA                                              ', 'LT', '370', NULL, NULL),
(131, 'LUXEMBOURG                                             ', 'LU', '352', NULL, NULL),
(132, 'LATVIA                                                 ', 'LV', '371', NULL, NULL),
(133, 'LIBYA                                                  ', 'LY', '218', NULL, NULL),
(134, 'MOROCCO                                                ', 'MA', '212', NULL, NULL),
(135, 'MONACO                                                 ', 'MC', '377', NULL, NULL),
(136, 'MOLDAVIA                                               ', 'MD', '', NULL, NULL),
(137, 'MADAGASCAR                                             ', 'MG', '261', NULL, NULL),
(138, 'MARSHALL ISLANDS                                       ', 'MH', '692', NULL, NULL),
(139, 'MACEDONIA                                              ', 'MK', '', NULL, NULL),
(140, 'MALI                                                   ', 'ML', '', NULL, NULL),
(141, 'MYANMAR                                                ', 'MM', '95', NULL, NULL),
(142, 'MONGOLIA                                               ', 'MN', '976', NULL, NULL),
(143, 'MACAU                                                  ', 'MO', '', NULL, NULL),
(144, 'NORTHERN MARIANA ISLANDS                               ', 'MP', '', NULL, NULL),
(145, 'MARTINIQUE (FRENCH)                                    ', 'MQ', '', NULL, NULL),
(146, 'MAURITANIA                                             ', 'MR', '222', NULL, NULL),
(147, 'MONTSERRAT                                             ', 'MS', '+1-664*', NULL, NULL),
(148, 'MALTA                                                  ', 'MT', '356', NULL, NULL),
(149, 'MAURITIUS                                              ', 'MU', '230', NULL, NULL),
(150, 'MALDIVES                                               ', 'MV', '960', NULL, NULL),
(151, 'MALAWI                                                 ', 'MW', '265', NULL, NULL),
(152, 'MEXICO                                                 ', 'MX', '52', NULL, NULL),
(153, 'MALAYSIA                                               ', 'MY', '60', NULL, NULL),
(154, 'MOZAMBIQUE                                             ', 'MZ', '258', NULL, NULL),
(155, 'NAMIBIA                                                ', 'NA', '264', NULL, NULL),
(156, 'NEW CALEDONIA (FRENCH)                                 ', 'NC', '', NULL, NULL),
(157, 'NIGER                                                  ', 'NE', '227', NULL, NULL),
(158, 'NORFOLK ISLAND                                         ', 'NF', '672', NULL, NULL),
(159, 'NIGERIA                                                ', 'NG', '234', NULL, NULL),
(160, 'NICARAGUA                                              ', 'NI', '505', NULL, NULL),
(161, 'NETHERLANDS                                            ', 'NL', '31', NULL, NULL),
(162, 'NORWAY                                                 ', 'NO', '47', NULL, NULL),
(163, 'NEPAL                                                  ', 'NP', '977', NULL, NULL),
(164, 'NAURU                                                  ', 'NR', '674', NULL, NULL),
(165, 'NIUE                                                   ', 'NU', '683', NULL, NULL),
(166, 'NEW ZEALAND                                            ', 'NZ', '64', NULL, NULL),
(167, 'OMAN                                                   ', 'OM', '968', NULL, NULL),
(168, 'PANAMA                                                 ', 'PA', '507', NULL, NULL),
(169, 'PERU                                                   ', 'PE', '51', NULL, NULL),
(170, 'POLYNESIA (FRENCH)                                     ', 'PF', '', NULL, NULL),
(171, 'PAPUA NEW GUINEA                                       ', 'PG', '675', NULL, NULL),
(172, 'PHILIPPINES                                            ', 'PH', '63', NULL, NULL),
(173, 'PAKISTAN                                               ', 'PK', '92', NULL, NULL),
(174, 'POLAND                                                 ', 'PL', '48', NULL, NULL),
(175, 'SAINT PIERRE AND MIQUELON                              ', 'PM', '', NULL, NULL),
(176, 'PITCAIRN ISLAND                                        ', 'PN', '', NULL, NULL),
(177, 'PUERTO RICO                                            ', 'PR', '+1-787* or +1-939*', NULL, NULL),
(178, 'PORTUGAL                                               ', 'PT', '351', NULL, NULL),
(179, 'PALAU                                                  ', 'PW', '680', NULL, NULL),
(180, 'PARAGUAY                                               ', 'PY', '595', NULL, NULL),
(181, 'QATAR                                                  ', 'QA', '974', NULL, NULL),
(182, 'REUNION (FRENCH)                                       ', 'RE', '', NULL, NULL),
(183, 'ROMANIA                                                ', 'RO', '40', NULL, NULL),
(184, 'RUSSIAN FEDERATION                                     ', 'RU', '', NULL, NULL),
(185, 'RWANDA                                                 ', 'RW', '', NULL, NULL),
(186, 'SAUDI ARABIA                                           ', 'SA', '966', NULL, NULL),
(187, 'SOLOMON ISLANDS                                        ', 'SB', '677', NULL, NULL),
(188, 'SEYCHELLES                                             ', 'SC', '', NULL, NULL),
(189, 'SUDAN                                                  ', 'SD', '249', NULL, NULL),
(190, 'SWEDEN                                                 ', 'SE', '46', NULL, NULL),
(191, 'SINGAPORE                                              ', 'SG', '65', NULL, NULL),
(192, 'SAINT HELENA                                           ', 'SH', '', NULL, NULL),
(193, 'SLOVENIA                                               ', 'SI', '386', NULL, NULL),
(194, 'SVALBARD AND JAN MAYEN ISLANDS                         ', 'SJ', '', NULL, NULL),
(195, 'SLOVAK REPUBLIC                                        ', 'SK', '421', NULL, NULL),
(196, 'SIERRA LEONE                                           ', 'SL', '232', NULL, NULL),
(197, 'SAN MARINO                                             ', 'SM', '378', NULL, NULL),
(198, 'SENEGAL                                                ', 'SN', '221', NULL, NULL),
(199, 'SOMALIA                                                ', 'SO', '', NULL, NULL),
(200, 'SURINAME                                               ', 'SR', '597', NULL, NULL),
(201, 'SAINT TOME (SAO TOME) AND PRINCIPE                     ', 'ST', '', NULL, NULL),
(202, 'FORMER USSR                                            ', 'SU', '', NULL, NULL),
(203, 'EL SALVADOR                                            ', 'SV', '503', NULL, NULL),
(204, 'SYRIA                                                  ', 'SY', '963', NULL, NULL),
(205, 'SWAZILAND                                              ', 'SZ', '268', NULL, NULL),
(206, 'TURKS AND CAICOS ISLANDS                               ', 'TC', '+1-649*', NULL, NULL),
(207, 'CHAD                                                   ', 'TD', '235', NULL, NULL),
(208, 'FRENCH SOUTHERN TERRITORIES                            ', 'TF', '', NULL, NULL),
(209, 'TOGO                                                   ', 'TG', '', NULL, NULL),
(210, 'THAILAND                                               ', 'TH', '66', NULL, NULL),
(211, 'TADJIKISTAN                                            ', 'TJ', '', NULL, NULL),
(212, 'TOKELAU                                                ', 'TK', '690', NULL, NULL),
(213, 'TURKMENISTAN                                           ', 'TM', '993', NULL, NULL),
(214, 'TUNISIA                                                ', 'TN', '216', NULL, NULL),
(215, 'TONGA                                                  ', 'TO', '', NULL, NULL),
(216, 'EAST TIMOR                                             ', 'TP', '670', NULL, NULL),
(217, 'TURKEY                                                 ', 'TR', '90', NULL, NULL),
(218, 'TRINIDAD AND TOBAGO                                    ', 'TT', '', NULL, NULL),
(219, 'TUVALU                                                 ', 'TV', '688', NULL, NULL),
(220, 'TAIWAN                                                 ', 'TW', '886', NULL, NULL),
(221, 'TANZANIA                                               ', 'TZ', '255', NULL, NULL),
(222, 'UKRAINE                                                ', 'UA', '380', NULL, NULL),
(223, 'UGANDA                                                 ', 'UG', '256', NULL, NULL),
(224, 'UNITED KINGDOM                                         ', 'UK', '44', NULL, NULL),
(225, 'USA MINOR OUTLYING ISLANDS                             ', 'UM', '', NULL, NULL),
(226, 'UNITED STATES                                          ', 'US', '', NULL, NULL),
(227, 'URUGUAY                                                ', 'UY', '598', NULL, NULL),
(228, 'UZBEKISTAN                                             ', 'UZ', '998', NULL, NULL),
(229, 'HOLY SEE (VATICAN CITY STATE)                          ', 'VA', '', NULL, NULL),
(230, 'SAINT VINCENT & GRENADINES                             ', 'VC', '', NULL, NULL),
(231, 'VENEZUELA                                              ', 'VE', '58', NULL, NULL),
(232, 'VIRGIN ISLANDS (BRITISH)                               ', 'VG', '', NULL, NULL),
(233, 'VIRGIN ISLANDS (USA)                                   ', 'VI', '', NULL, NULL),
(234, 'VIETNAM                                                ', 'VN', '84', NULL, NULL),
(235, 'VANUATU                                                ', 'VU', '678', NULL, NULL),
(236, 'WALLIS AND FUTUNA ISLANDS                              ', 'WF', '681', NULL, NULL),
(237, 'SAMOA                                                  ', 'WS', '', NULL, NULL),
(238, 'YEMEN                                                  ', 'YE', '967', NULL, NULL),
(239, 'MAYOTTE                                                ', 'YT', '', NULL, NULL),
(240, 'YUGOSLAVIA                                             ', 'YU', '', NULL, NULL),
(241, 'SOUTH AFRICA                                           ', 'ZA', '27', NULL, NULL),
(242, 'ZAMBIA                                                 ', 'ZM', '260', NULL, NULL),
(243, 'ZAIRE                                                  ', 'ZR', '', NULL, NULL),
(244, 'ZIMBABWE                                               ', 'ZW', '263', NULL, NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `details`
-- 

CREATE TABLE `details` (
  `itemid` int(11) NOT NULL auto_increment,
  `item` varchar(35) NOT NULL,
  `description` varchar(150) default NULL,
  `sale` tinyint(1) default NULL,
  `expense` tinyint(1) default NULL,
  PRIMARY KEY  (`itemid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 120832 kB; InnoDB free: 120832 kB; InnoDB free:' AUTO_INCREMENT=8 ;

-- 
-- Dumping data for table `details`
-- 

INSERT INTO `details` (`itemid`, `item`, `description`, `sale`, `expense`) VALUES (1, 'Accomodation', NULL, NULL, NULL),
(2, 'Bar', NULL, NULL, NULL),
(3, 'Conference', NULL, NULL, NULL),
(4, 'Restaurant', NULL, NULL, NULL),
(5, 'Laundry', NULL, NULL, NULL),
(6, 'Other', NULL, NULL, NULL),
(7, 'Trousers', 'Laundry', 1, NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `doctypes`
-- 

CREATE TABLE `doctypes` (
  `doc_id` int(11) NOT NULL auto_increment,
  `doc_code` varchar(5) NOT NULL,
  `doc_type` varchar(25) NOT NULL,
  `remarks` longtext,
  `accounts` tinyint(4) default NULL,
  `cooperative` tinyint(4) default NULL,
  `payroll` tinyint(4) default NULL,
  PRIMARY KEY  (`doc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 120832 kB; InnoDB free: 120832 kB; InnoDB free:' AUTO_INCREMENT=22 ;

-- 
-- Dumping data for table `doctypes`
-- 

INSERT INTO `doctypes` (`doc_id`, `doc_code`, `doc_type`, `remarks`, `accounts`, `cooperative`, `payroll`) VALUES (1, 'RECEI', 'RECEIPT                  ', NULL, 1, 1, NULL),
(2, 'INVOI', 'INVOICE                  ', NULL, 1, 1, NULL),
(3, 'ADVAN', 'ADVANCE                  ', NULL, 1, NULL, 1),
(4, 'SPADV', 'SPECIAL ADVANCE          ', NULL, 1, NULL, 1),
(5, 'LOANS', 'LOANS                    ', NULL, NULL, 1, 1),
(6, 'SHARE', 'SHARES                   ', NULL, NULL, 1, 1),
(7, 'OVEDE', 'OVER DEDUCTION           ', NULL, NULL, 1, 1),
(8, 'UNDED', 'UNDER DEDUCTION          ', NULL, 1, 1, 1),
(9, 'CSHPV', 'CASH PAYMENT VOUCHER     ', NULL, NULL, 1, NULL),
(10, 'CSHRV', 'CASH RECEIVED VOUCHER    ', NULL, NULL, 1, NULL),
(11, 'CHQRV', 'CHEQUE RECEIVED VOUCHER  ', NULL, NULL, 1, NULL),
(12, 'CRVCH', 'CREDIT VOUCHER           ', NULL, 1, 1, 1),
(13, 'DRVCH', 'DEBIT VOUCHER            ', NULL, 1, 1, 1),
(14, 'CDPVC', 'CASH DEPOSIT VOUCHER     ', NULL, NULL, NULL, NULL),
(15, 'CHDVC', 'CHEQUE DEPOSIT VOUCHER   ', NULL, 1, 1, NULL),
(16, 'PCSVC', 'PETTY CASH VOUCER        ', NULL, NULL, NULL, NULL),
(17, 'WTVCH', 'WITHDRAWAL VOUCHER       ', NULL, 1, 1, NULL),
(18, 'CRADV', 'CREDIT ADVICE            ', NULL, 1, 1, 0),
(19, 'DRADV', 'DEBIT ADVICE             ', NULL, 1, 1, NULL),
(20, 'IMPVC', 'IMPREST VOUCHER          ', NULL, 1, 1, NULL),
(21, 'chit', 'chits', 'for credit sales', 1, 1, 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `guestbook`
-- 

CREATE TABLE `guestbook` (
  `gb_index` int(11) NOT NULL auto_increment,
  `name` varchar(100) default NULL,
  `email` varchar(100) default NULL,
  `date` datetime default NULL,
  `message` mediumtext,
  `reply` mediumtext,
  PRIMARY KEY  (`gb_index`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- 
-- Dumping data for table `guestbook`
-- 

INSERT INTO `guestbook` (`gb_index`, `name`, `email`, `date`, `message`, `reply`) VALUES (1, 'Tony', 'tkazungu@kilifi.mimcom.net', '2006-03-29 16:46:39', 'good', NULL),
(2, 'Metrine', 'msaisi@lycos.com', '2006-03-29 16:56:01', 'wddw', NULL),
(3, 'Metrine', 'msaisi@lycos.com', '2006-03-30 08:49:59', 'Trial', NULL),
(4, 'Tony Iha Kazungu', 'tiha@taifaweb.net', '2006-04-02 09:39:56', 'Got to start from somewhere', NULL),
(5, 'Tony Iha Kazungu', 'tiha@taifaweb.net', '2006-04-02 09:43:16', 'Got to start from somewhere', NULL),
(6, 'Metrine Muhavi', 'msaisi@lycos.com', '2006-04-02 09:56:14', 'Well done hubby', NULL),
(7, 'fgfd', '@', '2006-04-02 10:02:25', 'ddd', NULL),
(8, 'dsd', '@', '2006-04-02 10:07:24', 'dfd', NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `guests`
-- 

CREATE TABLE `guests` (
  `guestid` int(11) NOT NULL auto_increment,
  `lastname` varchar(40) NOT NULL,
  `firstname` varchar(20) default NULL,
  `middlename` varchar(15) default NULL,
  `pp_no` varchar(15) default NULL,
  `idno` int(11) unsigned default NULL,
  `countrycode` char(2) NOT NULL,
  `pobox` varchar(10) default NULL,
  `town` varchar(30) default NULL,
  `postal_code` varchar(5) default NULL,
  `phone` varchar(15) default NULL,
  `email` varchar(50) default NULL,
  `mobilephone` varchar(15) default NULL,
  PRIMARY KEY  (`guestid`),
  UNIQUE KEY `id` (`guestid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 121856 kB; InnoDB free: 115712 kB; InnoDB free:' AUTO_INCREMENT=7 ;

-- 
-- Dumping data for table `guests`
-- 

INSERT INTO `guests` (`guestid`, `lastname`, `firstname`, `middlename`, `pp_no`, `idno`, `countrycode`, `pobox`, `town`, `postal_code`, `phone`, `email`, `mobilephone`) VALUES (1, 'Kazungu', 'Tony', 'Iha', NULL, 13487317, 'KE', '938', 'Kilifi', '80108', '041-522482', 'tiha@taifaweb.net', '0733-716747'),
(2, 'Mramba', 'Joseph', 'Kazungu', NULL, 13487316, 'KE', '389', 'Kilifi', '80108', '041-522482', 'jmramba@lycos.com', '0722-851632'),
(3, 'Emilly', 'Anne', 'Boodled', '03334071114', NULL, 'IO', '', '', '', '0044', '', '2089402800'),
(4, 'Engelsman', 'Floris', 'Alexander', '474187396', NULL, 'DE', '74523', 'SCHWAB.HALL', '', '', '', ''),
(5, 'Muiruri', 'Isabel', 'mugure', NULL, 11816707, 'KE', '', '', '', '0722277559', '', ''),
(6, 'Okombo', 'Okoth', '', NULL, 4827722, 'KE', '00508', 'Nairobi', '76420', '', '', '0721468696');

-- --------------------------------------------------------

-- 
-- Table structure for table `payment_mode`
-- 

CREATE TABLE `payment_mode` (
  `paymentid` int(11) NOT NULL auto_increment,
  `payment_option` varchar(30) NOT NULL,
  PRIMARY KEY  (`paymentid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 120832 kB' AUTO_INCREMENT=7 ;

-- 
-- Dumping data for table `payment_mode`
-- 

INSERT INTO `payment_mode` (`paymentid`, `payment_option`) VALUES (1, 'Cash'),
(2, 'Credit Card'),
(3, 'Cheque'),
(4, 'Company'),
(5, 'Money Order'),
(6, 'Western Union');

-- --------------------------------------------------------

-- 
-- Table structure for table `php_session`
-- 

CREATE TABLE `php_session` (
  `session_id` varchar(32) NOT NULL default '',
  `user_id` varchar(16) default NULL,
  `date_created` datetime NOT NULL default '0000-00-00 00:00:00',
  `last_updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `session_data` longtext,
  PRIMARY KEY  (`session_id`),
  KEY `last_updated` (`last_updated`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `php_session`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `rates`
-- 

CREATE TABLE `rates` (
  `ratesid` int(11) NOT NULL auto_increment,
  `bookingtype` char(1) NOT NULL COMMENT 'Direct/Agent',
  `occupancy` char(1) NOT NULL COMMENT 'single/double/family',
  `rate_type` char(1) NOT NULL COMMENT 'resident/non-resident',
  `bo` decimal(10,0) NOT NULL,
  `bb` decimal(10,0) NOT NULL,
  `hb` decimal(10,0) NOT NULL,
  `fb` decimal(10,0) NOT NULL,
  `currency` varchar(45) NOT NULL,
  `date_started` date NOT NULL,
  `date_stopped` date NOT NULL,
  PRIMARY KEY  (`ratesid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 120832 kB; InnoDB free: 120832 kB; InnoDB free:' AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `rates`
-- 

INSERT INTO `rates` (`ratesid`, `bookingtype`, `occupancy`, `rate_type`, `bo`, `bb`, `hb`, `fb`, `currency`, `date_started`, `date_stopped`) VALUES (1, 'D', 'S', 'R', '700', '950', '1550', '1950', 'Ksh.', '2006-07-01', '2006-07-09');

-- --------------------------------------------------------

-- 
-- Table structure for table `reservation`
-- 

CREATE TABLE `reservation` (
  `reservation_id` int(11) NOT NULL auto_increment,
  `reserved_through` varchar(15) NOT NULL,
  `guestid` varchar(40) NOT NULL,
  `reservation_by` varchar(35) default NULL,
  `reservation_by_phone` varchar(23) default NULL,
  `datereserved` date NOT NULL,
  `reserve_checkindate` date NOT NULL,
  `reserve_checkoutdate` date default NULL,
  `no_adults` tinyint(2) default NULL,
  `no_child0_5` tinyint(2) default NULL,
  `no_child6_12` tinyint(2) default NULL,
  `no_babies` tinyint(2) default NULL,
  `meal_plan` char(2) default NULL,
  `billing_instructions` text,
  `deposit` decimal(9,2) default NULL,
  `agents_ac_no` char(6) default NULL,
  `voucher_no` varchar(15) default NULL,
  `reserved_by` int(11) NOT NULL,
  `date_reserved` date default NULL,
  `confirmed_by` int(11) default NULL,
  `confirmed_date` date default NULL,
  `roomid` int(11) NOT NULL,
  `billed` int(11) default NULL,
  PRIMARY KEY  (`reservation_id`),
  UNIQUE KEY `id` (`reservation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 121856 kB; InnoDB free: 115712 kB; InnoDB free:' AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `reservation`
-- 

INSERT INTO `reservation` (`reservation_id`, `reserved_through`, `guestid`, `reservation_by`, `reservation_by_phone`, `datereserved`, `reserve_checkindate`, `reserve_checkoutdate`, `no_adults`, `no_child0_5`, `no_child6_12`, `no_babies`, `meal_plan`, `billing_instructions`, `deposit`, `agents_ac_no`, `voucher_no`, `reserved_by`, `date_reserved`, `confirmed_by`, `confirmed_date`, `roomid`, `billed`) VALUES (1, 'T', '3', NULL, NULL, '2006-08-29', '2006-08-31', '2006-09-04', 1, NULL, NULL, NULL, 'BB', NULL, '650.00', NULL, NULL, 2, NULL, NULL, NULL, 6, 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `rooms`
-- 

CREATE TABLE `rooms` (
  `roomid` int(11) NOT NULL auto_increment,
  `roomno` mediumint(3) NOT NULL default '0',
  `roomtypeid` int(11) default NULL,
  `roomname` varchar(35) default NULL,
  `noofrooms` tinyint(3) default NULL,
  `occupancy` tinyint(2) default NULL,
  `tv` char(1) default NULL,
  `aircondition` char(1) default NULL,
  `fun` char(1) default NULL,
  `safe` char(1) default NULL,
  `fridge` char(1) default NULL,
  `status` char(1) default NULL COMMENT '(V)acant/(R)eserverd/(B)ooked/(L)ocked',
  `photo` longblob,
  `filetype` varchar(50) default NULL,
  PRIMARY KEY  (`roomid`,`roomno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 119808 kB; InnoDB free: 119808 kB; InnoDB free:' AUTO_INCREMENT=35 ;

-- 
-- Dumping data for table `rooms`
-- 

INSERT INTO `rooms` (`roomid`, `roomno`, `roomtypeid`, `roomname`, `noofrooms`, `occupancy`, `tv`, `aircondition`, `fun`, `safe`, `fridge`, `status`, `photo`, `filetype`) VALUES (1, 102, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'V', NULL, NULL),
(2, 103, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'V', NULL, NULL),
(3, 104, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'V', NULL, NULL),
(4, 105, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'V', NULL, NULL),
(5, 106, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'V', NULL, NULL),
(6, 109, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'R', NULL, NULL),
(7, 110, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'V', NULL, NULL),
(8, 111, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'V', NULL, NULL),
(9, 112, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'V', NULL, NULL),
(10, 113, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'V', NULL, NULL),
(11, 114, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'V', NULL, NULL),
(12, 201, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'V', NULL, NULL),
(13, 202, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'V', NULL, NULL),
(14, 203, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'V', NULL, NULL),
(15, 204, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'V', NULL, NULL),
(16, 205, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'V', NULL, NULL),
(17, 206, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'V', NULL, NULL),
(18, 208, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'B', NULL, NULL),
(19, 209, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'V', NULL, NULL),
(20, 210, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'V', NULL, NULL),
(21, 211, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'V', NULL, NULL),
(22, 212, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'V', NULL, NULL),
(23, 213, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'V', NULL, NULL),
(24, 214, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'V', NULL, NULL),
(25, 301, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'V', NULL, NULL),
(26, 302, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'V', NULL, NULL),
(27, 303, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'V', NULL, NULL),
(28, 304, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'V', NULL, NULL),
(29, 305, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'V', NULL, NULL),
(30, 306, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'V', NULL, NULL),
(31, 307, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'V', NULL, NULL),
(32, 308, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'V', NULL, NULL),
(33, 309, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'V', NULL, NULL),
(34, 310, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'V', NULL, NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `roomtype`
-- 

CREATE TABLE `roomtype` (
  `roomtypeid` int(11) NOT NULL auto_increment,
  `roomtype` varchar(15) NOT NULL,
  `description` tinytext,
  PRIMARY KEY  (`roomtypeid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `roomtype`
-- 

INSERT INTO `roomtype` (`roomtypeid`, `roomtype`, `description`) VALUES (1, 'standard', NULL),
(2, 'family', NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `sessions`
-- 

CREATE TABLE `sessions` (
  `id_session` varchar(32) NOT NULL default '',
  `moment` bigint(20) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `data` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `sessions`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `transactions`
-- 

CREATE TABLE `transactions` (
  `transno` int(11) NOT NULL auto_increment,
  `billno` int(11) NOT NULL,
  `doc_type` char(15) NOT NULL COMMENT 'Receipt/Invoice/Chit/Bill',
  `doc_no` int(11) NOT NULL,
  `doc_date` date NOT NULL,
  `details` varchar(65) NOT NULL,
  `dr` decimal(10,2) default NULL,
  `cr` decimal(10,2) default NULL,
  `trans_date` timestamp NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`transno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Bill Postings; InnoDB free: 120832 kB; InnoDB free: 120832 k' AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `transactions`
-- 

INSERT INTO `transactions` (`transno`, `billno`, `doc_type`, `doc_no`, `doc_date`, `details`, `dr`, `cr`, `trans_date`) VALUES (1, 1, 'Reciept', 161, '2006-08-23', '1', NULL, '650.00', '2006-08-22 14:39:44');

-- --------------------------------------------------------

-- 
-- Table structure for table `transtype`
-- 

CREATE TABLE `transtype` (
  `trans_id` int(11) NOT NULL auto_increment,
  `trans_code` varchar(5) NOT NULL,
  `trans_type` varchar(25) NOT NULL,
  `remarks` longtext,
  `accounts` tinyint(4) default NULL,
  `cooperative` tinyint(4) default NULL,
  `payroll` tinyint(4) default NULL,
  PRIMARY KEY  (`trans_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 120832 kB; InnoDB free: 120832 kB; InnoDB free:' AUTO_INCREMENT=9 ;

-- 
-- Dumping data for table `transtype`
-- 

INSERT INTO `transtype` (`trans_id`, `trans_code`, `trans_type`, `remarks`, `accounts`, `cooperative`, `payroll`) VALUES (1, 'RECEI', 'RECEIPT                  ', NULL, 1, 1, NULL),
(2, 'PAYME', 'PAYMENTS                 ', NULL, 1, 1, NULL),
(3, 'RECOV', 'RECOVERY                 ', NULL, NULL, 1, 1),
(4, 'DEDUC', 'DEDUCTIONS               ', NULL, NULL, 1, 1),
(5, 'CONTR', 'CONTRIBUTIONS            ', NULL, NULL, 1, 1),
(6, 'ADJUS', 'ADJUSTMENTS              ', NULL, NULL, 1, 1),
(7, 'REFUN', 'REFUNDS                  ', NULL, NULL, 1, 1),
(8, 'TRANS', 'Transfers', 'Transfering funds', NULL, 1, NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `users`
-- 

CREATE TABLE `users` (
  `userid` smallint(6) NOT NULL auto_increment,
  `fname` varchar(25) NOT NULL,
  `sname` varchar(25) NOT NULL,
  `loginname` varchar(15) NOT NULL,
  `pass` varchar(32) NOT NULL,
  `phone` int(25) default NULL,
  `mobile` int(11) default NULL,
  `fax` int(11) default NULL,
  `email` varchar(65) default NULL,
  `dateregistered` date default NULL,
  `countrycode` smallint(6) default NULL,
  `admin` tinyint(1) NOT NULL default '0',
  `guest` tinyint(1) NOT NULL default '0',
  `reservation` tinyint(1) NOT NULL default '0',
  `booking` tinyint(1) NOT NULL default '0',
  `agents` tinyint(1) NOT NULL default '0',
  `rooms` tinyint(1) NOT NULL default '0',
  `billing` tinyint(1) NOT NULL default '0',
  `rates` tinyint(1) NOT NULL default '0',
  `lookup` tinyint(1) NOT NULL default '0',
  `reports` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`userid`),
  UNIQUE KEY `userid` (`userid`),
  UNIQUE KEY `loginname` (`loginname`),
  KEY `names` (`fname`,`sname`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 121856 kB; InnoDB free: 121856 kB; InnoDB free:' AUTO_INCREMENT=5 ;

-- 
-- Dumping data for table `users`
-- 

INSERT INTO `users` (`userid`, `fname`, `sname`, `loginname`, `pass`, `phone`, `mobile`, `fax`, `email`, `dateregistered`, `countrycode`, `admin`, `guest`, `reservation`, `booking`, `agents`, `rooms`, `billing`, `rates`, `lookup`, `reports`) VALUES (1, 'Tony', 'Kazungu', 'tiha', 'f9b96489e9fd87f2cac2addbe813b615', 735716747, 735716747, NULL, 'tkazungu@kilifi.mimcom.net', NULL, 112, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 'Tony', 'Iha', 'admin', '1b3231655cebb7a1f783eddf27d254ca', NULL, NULL, NULL, NULL, '2006-07-07', NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(3, 'Mohamed', 'Said', 'msaid', 'b7b791e873f143d5318310e59022175d', NULL, NULL, NULL, NULL, '2006-07-11', NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(4, 'Metrine', 'Saisi', 'msaisi', '3edfba58e66acf6f73742e7fbdb908c6', NULL, NULL, NULL, NULL, '2006-07-11', NULL, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `users_online`
-- 

CREATE TABLE `users_online` (
  `id` bigint(20) NOT NULL auto_increment,
  `timestamp` int(15) NOT NULL default '0',
  `ip` varchar(40) NOT NULL default '',
  `file` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `ip` (`ip`),
  KEY `file` (`file`),
  KEY `timestamp` (`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=602 ;

-- 
-- Dumping data for table `users_online`
-- 

INSERT INTO `users_online` (`id`, `timestamp`, `ip`, `file`) VALUES (591, 1143969163, '127.0.0.1', '/titanic/photogallery/photo.php'),
(592, 1143969164, '127.0.0.1', '/titanic/photogallery/photo.php'),
(593, 1143969166, '127.0.0.1', '/titanic/photogallery/photo.php'),
(594, 1143969168, '127.0.0.1', '/titanic/photogallery/photo.php'),
(595, 1143969169, '127.0.0.1', '/titanic/photogallery/photo.php'),
(596, 1143969171, '127.0.0.1', '/titanic/photogallery/photo.php'),
(597, 1143969177, '127.0.0.1', '/titanic/photogallery/photo.php'),
(598, 1143969179, '127.0.0.1', '/titanic/photogallery/photo.php'),
(599, 1143969450, '127.0.0.1', '/titanic/rooms.php'),
(600, 1143969457, '127.0.0.1', '/titanic/offers.php'),
(601, 1143969458, '127.0.0.1', '/titanic/location.php'),
(572, 1143969021, '127.0.0.1', '/titanic/index.php'),
(573, 1143969023, '127.0.0.1', '/titanic/ourservices.php'),
(574, 1143969023, '127.0.0.1', '/titanic/ourservices.php'),
(575, 1143969025, '127.0.0.1', '/titanic/rooms.php'),
(576, 1143969028, '127.0.0.1', '/titanic/menu.php'),
(577, 1143969034, '127.0.0.1', '/titanic/dailymenu.php'),
(578, 1143969034, '127.0.0.1', '/titanic/menu.php'),
(579, 1143969038, '127.0.0.1', '/titanic/offers.php'),
(580, 1143969039, '127.0.0.1', '/titanic/location.php'),
(581, 1143969046, '127.0.0.1', '/titanic/index.php'),
(582, 1143969051, '127.0.0.1', '/titanic/index.php'),
(583, 1143969062, '127.0.0.1', '/titanic/index.php'),
(584, 1143969073, '127.0.0.1', '/titanic/reservation.php'),
(585, 1143969075, '127.0.0.1', '/titanic/contactus.php'),
(586, 1143969078, '127.0.0.1', '/titanic/photogallery/photo.php'),
(587, 1143969152, '127.0.0.1', '/titanic/photogallery/photo.php'),
(588, 1143969155, '127.0.0.1', '/titanic/photogallery/photo.php'),
(589, 1143969157, '127.0.0.1', '/titanic/photogallery/photo.php'),
(590, 1143969159, '127.0.0.1', '/titanic/photogallery/photo.php'),
(571, 1143969018, '127.0.0.1', '/titanic/index.php');
