-- phpMyAdmin SQL Dump
-- version 2.11.2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 01, 2020 at 07:29 AM
-- Server version: 5.0.45
-- PHP Version: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `uploaddb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(9) NOT NULL,
  `firstname` varchar(40) NOT NULL,
  `lastname` varchar(40) NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--


-- --------------------------------------------------------

--
-- Table structure for table `upload`
--

CREATE TABLE `upload` (
  `id` int(9) NOT NULL auto_increment,
  `name` varchar(40) NOT NULL,
  `file` varchar(40) NOT NULL,
  `descript` varchar(40) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `upload`
--

INSERT INTO `upload` (`id`, `name`, `file`, `descript`) VALUES
(1, 'c.PNG', '', 'snapshot'),
(3, 'Narendhar.doc', '', 'document'),
(4, 'doc1.rtf.pdf', '', 'snapshot'),
(6, 'Narendhar.doc', '', ''),
(7, 'Narendhar.doc', '', ''),
(9, '3.jpg', '', 'cars');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(9) NOT NULL,
  `firstname` varchar(40) NOT NULL,
  `lastname` varchar(40) NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `password`) VALUES
(1, 'olu', 'sammy', 'sammy', '12345'),
(0, 'mike', 'tyson', 'mikety', '678900'),
(0, 'mike', 'tyson', 'mikety', '99070'),
(0, 'olu', 'sam', 'sammyoo', '12345');
