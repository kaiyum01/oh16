-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 18, 2017 at 07:47 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `oh16`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_user_create`
--

CREATE TABLE `admin_user_create` (
  `id` int(11) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `pass_word` varchar(20) NOT NULL,
  `user_email` varchar(30) NOT NULL,
  `user_type` int(2) NOT NULL,
  `is_deleted` int(1) NOT NULL DEFAULT '0',
  `status_active` int(1) NOT NULL,
  `update_date` datetime NOT NULL,
  `updated_by` int(3) NOT NULL,
  `insert_date` datetime NOT NULL,
  `inserted_by` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_user_create`
--

INSERT INTO `admin_user_create` (`id`, `user_name`, `pass_word`, `user_email`, `user_type`, `is_deleted`, `status_active`, `update_date`, `updated_by`, `insert_date`, `inserted_by`) VALUES
(77, 'kaiyummn', '12', 'kaiiyum@gmail.com', 1, 0, 1, '2016-08-27 20:36:19', 79, '2016-08-24 20:55:27', 0),
(78, 'sf', 's', 'ssss', 1, 1, 0, '2016-08-24 20:56:22', 0, '2016-08-24 20:56:11', 0),
(79, 'admin', 'admin', 'admin@gmail.com', 1, 0, 1, '2016-08-28 19:02:39', 79, '2016-08-25 17:22:59', 0),
(80, 'rion', 'rion', 'rion@gmail.com', 1, 1, 0, '2016-08-26 12:11:29', 79, '2016-08-26 10:49:14', 0),
(81, 'riad', 'riad', 'riad@gmail.com', 1, 1, 0, '2016-08-26 12:03:34', 79, '2016-08-26 10:51:20', 79);

-- --------------------------------------------------------

--
-- Table structure for table `com_create_bill_mst`
--

CREATE TABLE `com_create_bill_mst` (
  `id` int(11) NOT NULL,
  `quotation_mst_id` int(11) NOT NULL,
  `order_mst_id` int(100) NOT NULL,
  `bill_number_generate` varchar(100) NOT NULL,
  `bill_subject` varchar(300) NOT NULL,
  `bill_date` date NOT NULL,
  `is_deleted` int(1) NOT NULL,
  `status_active` int(1) NOT NULL,
  `insert_date` datetime NOT NULL,
  `inserted_by` int(1) NOT NULL,
  `update_date` datetime NOT NULL,
  `updated_by` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `com_create_bill_mst`
--

INSERT INTO `com_create_bill_mst` (`id`, `quotation_mst_id`, `order_mst_id`, `bill_number_generate`, `bill_subject`, `bill_date`, `is_deleted`, `status_active`, `insert_date`, `inserted_by`, `update_date`, `updated_by`) VALUES
(1, 92, 4, 'OH-Bill-1-07-10-16', 'quotation for largest banner', '2016-10-07', 0, 0, '2016-10-07 11:37:07', 79, '0000-00-00 00:00:00', 0),
(2, 93, 2, 'OH-Bill-2-07-10-16', 'biggi banner for fashion house', '2016-10-07', 0, 0, '2016-10-07 11:39:49', 79, '0000-00-00 00:00:00', 0),
(3, 94, 1, 'OH-Bill-3-07-10-16', 'largest banner for bill board', '2016-10-07', 0, 0, '2016-10-07 11:47:51', 79, '0000-00-00 00:00:00', 0),
(4, 93, 2, 'OH-Bill-4-07-10-16', 'bill bill', '2016-10-07', 0, 0, '2016-10-07 12:46:20', 79, '2016-10-07 19:40:19', 79),
(5, 98, 6, 'OH-LSW-Bill-5-27-12-16', 'gggggg', '2016-12-27', 0, 0, '2016-12-27 16:40:53', 79, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `com_create_challan_dtls`
--

CREATE TABLE `com_create_challan_dtls` (
  `id` int(11) NOT NULL,
  `mst_id` int(11) NOT NULL,
  `challan_particular_name` varchar(150) NOT NULL,
  `challan_wft` varchar(5) NOT NULL,
  `challan_winch` varchar(5) NOT NULL,
  `challan_hft` varchar(5) NOT NULL,
  `challan_hinch` varchar(5) NOT NULL,
  `challan_total_sqft` varchar(11) NOT NULL,
  `is_deleted` int(1) NOT NULL DEFAULT '0',
  `status_active` int(1) NOT NULL DEFAULT '1',
  `update_date` datetime NOT NULL,
  `updated_by` int(3) NOT NULL,
  `insert_date` datetime NOT NULL,
  `inserted_by` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `com_create_challan_mst`
--

CREATE TABLE `com_create_challan_mst` (
  `id` int(11) NOT NULL,
  `quotation_mst_id` int(11) NOT NULL,
  `order_mst_id` int(100) NOT NULL,
  `challan_number_generate` varchar(100) NOT NULL,
  `challan_subject` varchar(300) NOT NULL,
  `challan_date` date NOT NULL,
  `is_deleted` int(1) NOT NULL DEFAULT '0',
  `status_active` int(1) NOT NULL DEFAULT '1',
  `insert_date` datetime NOT NULL,
  `inserted_by` int(3) NOT NULL,
  `update_date` datetime NOT NULL,
  `updated_by` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `com_create_challan_mst`
--

INSERT INTO `com_create_challan_mst` (`id`, `quotation_mst_id`, `order_mst_id`, `challan_number_generate`, `challan_subject`, `challan_date`, `is_deleted`, `status_active`, `insert_date`, `inserted_by`, `update_date`, `updated_by`) VALUES
(3, 92, 4, 'OH-CHL-1-08-10-16', 'quotation for largest banner', '2016-10-08', 0, 1, '2016-10-08 19:30:34', 79, '0000-00-00 00:00:00', 0),
(4, 93, 2, 'OH-CHL-4-08-10-16', 'challannnnnnn', '2016-10-08', 0, 1, '2016-10-08 19:31:13', 79, '2016-10-08 20:33:16', 79),
(5, 98, 9, 'OH-LSW-CHL-5-27-12-16', 'gggggg', '2016-12-27', 0, 1, '2016-12-27 16:52:22', 79, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `com_create_quotation_dtls`
--

CREATE TABLE `com_create_quotation_dtls` (
  `id` int(50) NOT NULL,
  `mst_id` int(11) NOT NULL,
  `item_name` varchar(150) NOT NULL,
  `width_feet` int(5) NOT NULL,
  `width_inch` int(5) NOT NULL,
  `height_feet` int(5) NOT NULL,
  `height_inch` int(5) NOT NULL,
  `total_sqft` varchar(50) NOT NULL,
  `price_per_unit` varchar(50) NOT NULL,
  `amount` varchar(50) NOT NULL,
  `is_deleted` int(1) NOT NULL DEFAULT '0',
  `status_active` int(1) NOT NULL DEFAULT '1',
  `update_date` datetime NOT NULL,
  `updated_by` int(3) NOT NULL,
  `inserted_by` int(3) NOT NULL,
  `insert_date` datetime NOT NULL,
  `q_qty` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `com_create_quotation_dtls`
--

INSERT INTO `com_create_quotation_dtls` (`id`, `mst_id`, `item_name`, `width_feet`, `width_inch`, `height_feet`, `height_inch`, `total_sqft`, `price_per_unit`, `amount`, `is_deleted`, `status_active`, `update_date`, `updated_by`, `inserted_by`, `insert_date`, `q_qty`) VALUES
(56, 89, 'plastic banner', 3, 3, 3, 3, '10.56', '123', '1,299.19', 1, 0, '0000-00-00 00:00:00', 0, 79, '2016-10-01 17:07:16', 0),
(57, 90, 'largest plastic paper', 12, 5, 26, 4, '326.97', '250', '81,743.06', 0, 1, '0000-00-00 00:00:00', 0, 79, '2016-10-01 17:12:53', 0),
(58, 91, 'water proof plastic banner', 12, 4, 34, 4, '423.44', '450', '190,550.00', 0, 1, '0000-00-00 00:00:00', 0, 79, '2016-10-01 17:15:57', 0),
(59, 91, 'small playcard banner', 5, 5, 4, 5, '23.92', '67', '1,602.88', 0, 1, '0000-00-00 00:00:00', 0, 79, '2016-10-01 17:15:57', 0),
(60, 92, 'plastic paper white', 55, 4, 45, 4, '2,508.44', '60', '150,506.67', 0, 1, '0000-00-00 00:00:00', 0, 79, '2016-10-01 19:48:11', 0),
(61, 92, 'hardboard plastic paper', 3, 4, 4, 5, '14.72', '30', '441.67', 0, 1, '0000-00-00 00:00:00', 0, 79, '2016-10-01 19:48:11', 0),
(70, 93, 'plastic', 5, 6, 6, 6, '35.75', '6', '214.50', 0, 1, '0000-00-00 00:00:00', 0, 79, '2016-10-12 18:06:29', 0),
(71, 93, 'paper', 4, 5, 5, 5, '23.92', '5', '119.62', 0, 1, '0000-00-00 00:00:00', 0, 79, '2016-10-12 18:06:29', 0),
(74, 94, 'bigger plastic updatee', 5, 3, 4, 5, '23.19', '5', '115.94', 0, 1, '0000-00-00 00:00:00', 0, 79, '2016-12-16 19:08:43', 0),
(75, 94, 'water proof plastic updatee', 4, 5, 4, 5, '19.51', '4', '78.03', 0, 1, '0000-00-00 00:00:00', 0, 79, '2016-12-16 19:08:43', 0),
(78, 98, 'gg', 5, 4, 4, 4, '23.11', '4', '462.22', 0, 1, '0000-00-00 00:00:00', 0, 79, '2016-12-17 19:24:21', 5),
(79, 99, 'x', 4, 2, 4, 2, '17.36', '2', '69.44', 0, 1, '0000-00-00 00:00:00', 0, 79, '2016-12-17 19:25:19', 2),
(84, 100, 'o', 2, 1, 1, 12, '4.17', '1', '4.17', 0, 1, '0000-00-00 00:00:00', 0, 79, '2016-12-18 17:56:23', 1),
(85, 100, 'yy', 2, 2, 2, 1, '4.51', '2', '9.03', 0, 1, '0000-00-00 00:00:00', 0, 79, '2016-12-18 17:56:23', 1),
(108, 101, 'Glass Sticker', 4, 5, 5, 4, '23.56', '4', '565.33', 0, 1, '0000-00-00 00:00:00', 0, 79, '2016-12-20 18:44:03', 6),
(109, 101, 'Glass Sticker', 4, 4, 4, 4, '18.78', '4', '3,304.89', 0, 1, '0000-00-00 00:00:00', 0, 79, '2016-12-20 18:44:03', 44),
(112, 102, 'sandwich board', 4, 4, 2, 4, '10.11', '4', '849.33', 0, 1, '0000-00-00 00:00:00', 0, 79, '2016-12-26 19:04:48', 21),
(113, 102, 'Glass Sticker', 55, 3, 5, 5, '299.27', '5', '7,481.77', 0, 1, '0000-00-00 00:00:00', 0, 79, '2016-12-26 19:04:48', 5);

-- --------------------------------------------------------

--
-- Table structure for table `com_create_quotation_mst`
--

CREATE TABLE `com_create_quotation_mst` (
  `id` int(11) NOT NULL,
  `to_name` varchar(30) NOT NULL,
  `to_designation` varchar(30) NOT NULL,
  `to_company` int(11) NOT NULL,
  `to_address` text NOT NULL,
  `to_quotation_subject` varchar(300) NOT NULL,
  `total_amount` varchar(50) NOT NULL,
  `vat` varchar(5) NOT NULL,
  `total_amount_with_vat` varchar(50) NOT NULL,
  `quotation_date` date NOT NULL,
  `total_amount_in_word` varchar(250) NOT NULL,
  `quotation_number_generate` varchar(100) NOT NULL,
  `is_deleted` int(1) NOT NULL DEFAULT '0',
  `status_active` int(1) NOT NULL DEFAULT '1',
  `updated_by` int(3) NOT NULL,
  `update_date` datetime NOT NULL,
  `insert_date` datetime NOT NULL,
  `inserted_by` int(3) NOT NULL,
  `ait` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `com_create_quotation_mst`
--

INSERT INTO `com_create_quotation_mst` (`id`, `to_name`, `to_designation`, `to_company`, `to_address`, `to_quotation_subject`, `total_amount`, `vat`, `total_amount_with_vat`, `quotation_date`, `total_amount_in_word`, `quotation_number_generate`, `is_deleted`, `status_active`, `updated_by`, `update_date`, `insert_date`, `inserted_by`, `ait`) VALUES
(89, 'test', 'testing position', 2, 'dhaka', 'test purpose', '1,299.19', '3', '1,338', '2016-10-01', 'One Thousand Three Hundred and Thirty Eight Taka Only', '', 1, 0, 0, '0000-00-00 00:00:00', '2016-10-01 17:07:16', 79, 0),
(90, 'Kaiyum', 'CTO', 5, 'Banani,Dhaka', 'Quotaton for bigger bill board banner', '81,743.06', '15', '94,005', '2016-10-01', 'Ninety Four Thousand and Five Taka Only', '', 0, 1, 0, '0000-00-00 00:00:00', '2016-10-01 17:12:53', 79, 0),
(91, 'Mehedi', 'CEO', 2, 'Dhanmondi,Dhaka', 'quotaion for digital banner', '192,152.88', '10', '211,368', '2016-10-01', 'Two Lakh Eleven Thousand Three Hundred and Sixty Eight Taka Only', '', 0, 1, 0, '0000-00-00 00:00:00', '2016-10-01 17:15:57', 79, 0),
(92, 'abdul kaiyum', 'jr.programmer', 10, 'chittagong', 'quotation for largest banner', '150,948.33', '5', '158,496', '2016-10-01', 'One Lakh Fifty Eight Thousand Four Hundred and Ninety Six Taka Only', 'OH-Q-92-01-10-16', 0, 1, 0, '0000-00-00 00:00:00', '2016-10-01 19:48:11', 79, 0),
(93, 'Nadia', 'Fashion Designer', 3, 'chittagong', 'biggi banner for fashion house', '334.12', '6', '354', '2016-10-12', 'Three Hundred and Fifty Four Taka Only', 'OH-Q-93-01-10-16', 0, 1, 79, '2016-10-12 18:06:29', '2016-10-01 20:28:21', 79, 0),
(94, 'sheikh samir', 'sr.executive', 6, 'sylhet', 'largest banner for bill board updateee', '193.97', '', '194', '2016-12-16', 'One Hundred and Ninety Four Taka Only', 'OH-Q-94-01-10-16', 0, 1, 79, '2016-12-16 19:08:43', '2016-10-01 20:38:54', 79, 0),
(98, 'ggggggggggg', 'gggg', 11, 'Banani,Dhaka,1212', 'gggggg', '462.22', '5', '485', '2016-12-17', 'Four Hundred and Eighty Five Taka Only', 'OH-Q-95-17-12-16', 0, 1, 0, '0000-00-00 00:00:00', '2016-12-17 19:24:21', 79, 0),
(99, 'xxxxxx', 'xx', 10, 'asdf', 'xxxxxxx', '69.44', '2', '71', '2016-12-17', 'Seventy One Taka Only', 'OH-Q-99-17-12-16', 0, 1, 0, '0000-00-00 00:00:00', '2016-12-17 19:25:19', 79, 0),
(100, 'ooooooooooo', 'oooo', 5, 'sdafdsf', 'oooooooooo', '13.19', '2', '13', '2016-12-18', 'Thirteen Taka Only', 'OH-Q-100-18-12-16', 0, 1, 79, '2016-12-18 17:56:23', '2016-12-18 17:50:01', 79, 0),
(101, 'fdasfdfs', 'sdfsdf', 5, 'sdafdsf', 'sadfdfsdf', '3,870.22', '5', '4,296', '2016-12-20', 'Four Thousand Two Hundred and Ninety Six Taka Only', 'OH-Q-101-18-12-16', 0, 1, 79, '2016-12-20 18:44:03', '2016-12-18 18:58:42', 79, 6),
(102, 'ffffffffff', 'dsgdfgfdgsdfg', 11, 'Banani,Dhaka,1212', 'dsgdfgdfgdfsg', '8,331.10', '5', '8,748', '2016-12-26', 'Eight Thousand Seven Hundred and Forty Eight Taka Only', 'OH-LSW-Q-102-26-12-16', 0, 1, 79, '2016-12-26 19:04:48', '2016-12-26 19:04:36', 79, 0);

-- --------------------------------------------------------

--
-- Table structure for table `com_order_entry`
--

CREATE TABLE `com_order_entry` (
  `id` int(11) NOT NULL,
  `order_number_generate` varchar(100) NOT NULL,
  `order_date` date NOT NULL,
  `client_name` int(11) NOT NULL,
  `task_name` int(11) NOT NULL,
  `quotation_no` int(11) NOT NULL,
  `quotation_date` date NOT NULL,
  `job_number_generate` varchar(100) NOT NULL,
  `production_status` int(5) NOT NULL,
  `delivery_date` date NOT NULL,
  `challan_no` varchar(15) NOT NULL,
  `bill_no` varchar(15) NOT NULL,
  `bill_status` int(5) NOT NULL,
  `is_deleted` int(1) NOT NULL DEFAULT '0',
  `status_active` int(1) NOT NULL DEFAULT '1',
  `insert_date` datetime NOT NULL,
  `inserted_by` int(11) NOT NULL,
  `update_date` datetime NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `com_order_entry`
--

INSERT INTO `com_order_entry` (`id`, `order_number_generate`, `order_date`, `client_name`, `task_name`, `quotation_no`, `quotation_date`, `job_number_generate`, `production_status`, `delivery_date`, `challan_no`, `bill_no`, `bill_status`, `is_deleted`, `status_active`, `insert_date`, `inserted_by`, `update_date`, `updated_by`) VALUES
(1, 'O4562', '2016-05-10', 6, 2, 94, '2016-10-01', 'j150', 1, '2016-10-10', 'c4565', 'b4562', 1, 0, 1, '2016-10-02 18:14:39', 79, '0000-00-00 00:00:00', 0),
(2, 'OH-ORD-2-02-10-', '2016-08-20', 5, 1, 93, '2016-08-09', 'j456', 2, '2016-09-06', 'c1112', 'b24352', 1, 0, 1, '2016-10-02 20:17:58', 79, '0000-00-00 00:00:00', 0),
(4, 'OH-ORD-3-02-10-16', '2016-05-02', 10, 1, 92, '2016-05-01', 'OH-JOB-3-02-10-16', 1, '2016-06-02', 'undefined', 'undefined', 1, 0, 1, '2016-10-02 20:45:24', 79, '2016-10-09 20:26:49', 79),
(5, 'OH-ORD-5-15-10-16', '2016-10-04', 6, 1, 94, '2016-10-12', 'OH-JOB-5-15-10-16', 1, '2016-10-12', '', '', 2, 0, 1, '2016-10-15 19:33:54', 79, '2016-10-16 21:32:10', 79),
(6, 'OH-ORD-6-27-12-16', '2016-12-14', 11, 1, 98, '2016-12-17', 'OH-LSWJOB-6-27-12-16', 1, '2016-12-28', '', '', 1, 0, 1, '2016-12-27 16:17:25', 79, '0000-00-00 00:00:00', 0),
(7, 'OH-dsfa-ORD-7-27-12-16', '2016-12-31', 10, 1, 99, '2016-12-17', 'OH-dsfa-JOB-7-27-12-16', 1, '2016-12-06', '', '', 1, 0, 1, '2016-12-27 16:19:26', 79, '0000-00-00 00:00:00', 0),
(8, 'OH-LSW-ORD-8-27-12-16', '2016-12-20', 11, 0, 98, '2016-12-17', 'OH-LSW-JOB-8-27-12-16', 0, '2016-12-29', '', '', 0, 1, 0, '2016-12-27 16:19:46', 79, '2016-12-27 16:20:46', 79),
(9, 'OH-LSW-ORD-9-27-12-16', '2016-12-13', 11, 1, 98, '2016-12-17', 'OH-LSW-JOB-9-27-12-16', 1, '2016-12-27', '', '', 1, 0, 1, '2016-12-27 16:21:14', 79, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `lib_client_entry`
--

CREATE TABLE `lib_client_entry` (
  `id` int(11) NOT NULL,
  `company_code` varchar(20) NOT NULL,
  `contact_person_name` varchar(30) NOT NULL,
  `division` int(1) NOT NULL,
  `address` text NOT NULL,
  `company_name` varchar(30) NOT NULL,
  `person_phone` varchar(20) NOT NULL,
  `area` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `company_phone` varchar(20) NOT NULL,
  `short_name` varchar(20) NOT NULL,
  `person_desig` varchar(25) NOT NULL,
  `tin` varchar(50) NOT NULL,
  `website` varchar(50) NOT NULL,
  `faxno` varchar(30) NOT NULL,
  `status_active` int(1) NOT NULL DEFAULT '1',
  `is_deleted` int(1) NOT NULL DEFAULT '0',
  `update_date` datetime NOT NULL,
  `updated_by` int(3) NOT NULL,
  `insert_date` datetime NOT NULL,
  `inserted_by` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lib_client_entry`
--

INSERT INTO `lib_client_entry` (`id`, `company_code`, `contact_person_name`, `division`, `address`, `company_name`, `person_phone`, `area`, `email`, `company_phone`, `short_name`, `person_desig`, `tin`, `website`, `faxno`, `status_active`, `is_deleted`, `update_date`, `updated_by`, `insert_date`, `inserted_by`) VALUES
(2, 'B0045665', 'Kaiyum', 2, 'Khulshi,ctg', 'DesignerCastle', '01815526607', 'kkhulshi', 'dc@gmail.com', '0124853335', 'DC-45254', 'CEO', 'GH5645', 'www.designercastle.com', 'GETS-5432', 1, 0, '2016-09-01 20:57:57', 79, '2016-08-31 21:59:50', 79),
(3, 'h15645', 'rion', 1, 'dhanmondi', 'out of home (oh)', '0125451', 'shamoli', 'oh@gmail.com', '011651', 'sadf2132', 'CEO', '3534sdf', 'www.oh.com', 'sdfa152', 1, 0, '0000-00-00 00:00:00', 0, '2016-09-01 20:39:21', 79),
(5, 'dsdf', 'dsafsdfsd', 4, 'sdafdsf', 'Brac Bank', 'asdf', 'dfa', 'dsfa', 'adfd', 'sdfa', 'sf', 'sdaf', 'dasf', 'dfdfa', 1, 0, '2016-09-01 20:59:42', 79, '2016-09-01 20:46:42', 79),
(6, 'ssssssssss', 'ssdfdf', 8, 'asdfdsf', 'AB Bank', 'dsaf', 'asdf', 'sad', 'fsdafdsf', 'sdaf', 'asdf', 'asdf', 'sdf', 'asdf', 1, 0, '2016-12-16 17:49:51', 79, '2016-09-01 20:51:39', 79),
(10, 'safsdf', 'sadf', 1, 'asdf', 'Islamic Bank', 'asdf', 'sdf', 'sdaf', 'ds', 'dsfa', 'dsaf', 'dsf', 'dsaf', 'dsf', 1, 0, '2016-12-16 17:50:12', 79, '2016-09-01 20:41:58', 79),
(11, '', 'Mehedi', 1, 'Banani,Dhaka,1212', 'Logic Software bd', '01815526607', '', 'kaiyum@logicsoft.com', '', 'LSW', 'Software Engineer', '', '', '', 1, 0, '2016-12-17 17:27:39', 79, '2016-12-17 17:27:18', 79);

-- --------------------------------------------------------

--
-- Table structure for table `lib_task_entry`
--

CREATE TABLE `lib_task_entry` (
  `id` int(11) NOT NULL,
  `task_name` varchar(40) NOT NULL,
  `status_active` int(1) NOT NULL DEFAULT '1',
  `is_deleted` int(1) NOT NULL DEFAULT '0',
  `update_date` datetime NOT NULL,
  `updated_by` int(3) NOT NULL,
  `insert_date` datetime NOT NULL,
  `inserted_by` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lib_task_entry`
--

INSERT INTO `lib_task_entry` (`id`, `task_name`, `status_active`, `is_deleted`, `update_date`, `updated_by`, `insert_date`, `inserted_by`) VALUES
(1, 'Glass Sticker', 1, 0, '2016-09-10 09:28:26', 79, '2016-08-29 20:11:44', 79),
(2, 'sandwich board', 1, 0, '0000-00-00 00:00:00', 0, '2016-08-29 20:17:40', 79),
(3, 'zCzxcxzc', 0, 1, '2016-08-29 20:21:52', 79, '2016-08-29 20:21:42', 79),
(4, 'sandwich board', 0, 1, '2016-09-29 16:54:27', 79, '2016-09-29 16:53:43', 79),
(5, 'sandwich board', 0, 1, '2016-09-29 16:54:23', 79, '2016-09-29 16:53:44', 79),
(6, 'sandwich board', 0, 1, '2016-09-29 16:54:15', 79, '2016-09-29 16:53:44', 79);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_user_create`
--
ALTER TABLE `admin_user_create`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `com_create_bill_mst`
--
ALTER TABLE `com_create_bill_mst`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `com_create_challan_dtls`
--
ALTER TABLE `com_create_challan_dtls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `com_create_challan_mst`
--
ALTER TABLE `com_create_challan_mst`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `com_create_quotation_dtls`
--
ALTER TABLE `com_create_quotation_dtls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `com_create_quotation_mst`
--
ALTER TABLE `com_create_quotation_mst`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `com_order_entry`
--
ALTER TABLE `com_order_entry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lib_client_entry`
--
ALTER TABLE `lib_client_entry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lib_task_entry`
--
ALTER TABLE `lib_task_entry`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_user_create`
--
ALTER TABLE `admin_user_create`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;
--
-- AUTO_INCREMENT for table `com_create_bill_mst`
--
ALTER TABLE `com_create_bill_mst`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `com_create_challan_dtls`
--
ALTER TABLE `com_create_challan_dtls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `com_create_challan_mst`
--
ALTER TABLE `com_create_challan_mst`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `com_create_quotation_dtls`
--
ALTER TABLE `com_create_quotation_dtls`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;
--
-- AUTO_INCREMENT for table `com_create_quotation_mst`
--
ALTER TABLE `com_create_quotation_mst`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;
--
-- AUTO_INCREMENT for table `com_order_entry`
--
ALTER TABLE `com_order_entry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `lib_client_entry`
--
ALTER TABLE `lib_client_entry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `lib_task_entry`
--
ALTER TABLE `lib_task_entry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
