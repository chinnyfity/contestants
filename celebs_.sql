-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2019 at 03:25 PM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 7.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `celebs`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_set_activity2`
--

CREATE TABLE `admin_set_activity2` (
  `id` int(11) NOT NULL,
  `approved` int(11) NOT NULL,
  `session1` int(11) NOT NULL,
  `timings` int(11) NOT NULL,
  `quiz_intro_id` int(11) DEFAULT NULL,
  `has_done` int(2) DEFAULT NULL,
  `for_days` varchar(3) NOT NULL,
  `day_instructns` varchar(200) NOT NULL,
  `time_duratn` int(3) NOT NULL,
  `starting_from` varchar(5) NOT NULL,
  `starting_from1` int(11) DEFAULT NULL,
  `titles` varchar(200) NOT NULL,
  `game_type` varchar(3) NOT NULL,
  `dates` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_set_activity2`
--

INSERT INTO `admin_set_activity2` (`id`, `approved`, `session1`, `timings`, `quiz_intro_id`, `has_done`, `for_days`, `day_instructns`, `time_duratn`, `starting_from`, `starting_from1`, `titles`, `game_type`, `dates`) VALUES
(1, 1, 1554976004, 0, 0, 1, 'fri', 'Upload pictures of you standing on a white background with a good smile, sitting down on a black background and any other picture all in your best ankara', 5, '5', 0, 'Picture show off', 'pic', '2019-04-15 5:18 pm'),
(3, 1, 1554976004, 0, 4, 1, 'mon', 'This is a fun trivia game, very simple and interesting, do your best and submit your answers.', 5, '7', 1555956000, 'Trivia Excellent show', 'qz', '2019-04-22 11:45 am'),
(37, 0, 1556580485, 0, 0, 1, 'tue', 'kkkkk', 5, '3', 0, 'ooooooo', 'pic', '2019-04-30 12:33 am'),
(40, 1, 1557938931, 0, 0, 1, 'fri', 'ffdfdfdfdf dfd fdf', 5, '5', 1557943200, 'ghghghghgh hghg', 'pic', '2019-05-15 5:49 pm'),
(41, 1, 1557938931, 0, 0, 1, 'sat', 'hdhffgfgfhff', 5, '4', 1558105200, 'this is an English wear game', 'pic', '2019-05-17 3:58 pm'),
(42, 1, 1560337370, 0, 14, 1, 'wed', 'You are to pertake in this, its simple but logical', 5, '3', 1560348000, 'Trivia games', 'qz', '1560347364'),
(43, 1, 1560337370, 0, 0, 1, 'mon', 'english wears', 10, '1', 1560772800, 'picture game', 'pic', '1560387364');

-- --------------------------------------------------------

--
-- Table structure for table `admin_tbls`
--

CREATE TABLE `admin_tbls` (
  `id` int(11) NOT NULL,
  `uname` varchar(10) NOT NULL,
  `pass1` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_tbls`
--

INSERT INTO `admin_tbls` (`id`, `uname`, `pass1`) VALUES
(1, 'admin1', 'd033e22ae348aeb5660fc2140aec35850c4da997');

-- --------------------------------------------------------

--
-- Table structure for table `all_votes`
--

CREATE TABLE `all_votes` (
  `id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `voters_email` varchar(40) NOT NULL,
  `ip_addrs` varchar(30) NOT NULL,
  `email_code` int(8) NOT NULL,
  `activated` int(2) NOT NULL,
  `paid` int(2) NOT NULL,
  `votes` int(11) NOT NULL,
  `contestant_id` int(11) NOT NULL,
  `acct_name` varchar(50) NOT NULL,
  `bank_name` varchar(50) NOT NULL,
  `phones` varchar(30) NOT NULL,
  `amt_paid` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `all_votes`
--

INSERT INTO `all_votes` (`id`, `activity_id`, `voters_email`, `ip_addrs`, `email_code`, `activated`, `paid`, `votes`, `contestant_id`, `acct_name`, `bank_name`, `phones`, `amt_paid`) VALUES
(6, 1, 'donchibobo@gmail.com', '364', 0, 1, 1, 1, 3, '', '', '', 0),
(7, 1, 'donchibobo1@gmail.com', '::1', 0, 1, 1, 1, 3, '', '', '', 0),
(9, 1, 'ghghgh@ssss.sss', '::1', 0, 1, 1, 1, 2, '', '', '', 0),
(13, 1, '', '::1', 0, 1, 1, 5, 2, 'fdfdfd dsfdsfs', 'Ecobank', '37373744', 50),
(19, 23, 'ffgfgf@nmnm.klkl', '::1', 0, 1, 0, 0, 1, 'nmmnmn nmnmn', 'Ecobank', '7676767676', 50),
(30, 23, 'sshsh@ssss.sss', '::1', 0, 1, 0, 0, 1, 'ddsdhhjsd', 'Diamond Bank', '282828282', 100),
(32, 23, 'sssss@ssss.sss', '::1', 0, 1, 1, 10, 1, 'nnnmn nmn', 'Diamond Bank', '38349943', 100),
(33, 23, 'pppp@pppp.ppp', '::1', 0, 1, 1, 5, 1, 'nnmnm nnmnmnnn', 'Firstbank', '3447847433', 50),
(34, 24, 'sssss@sss.kkk', '::1', 0, 1, 1, 1, 5, '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `bank_ussd`
--

CREATE TABLE `bank_ussd` (
  `id` int(11) NOT NULL,
  `banks` varchar(30) NOT NULL,
  `ussd2ussd` varchar(20) NOT NULL,
  `ussd2other` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bank_ussd`
--

INSERT INTO `bank_ussd` (`id`, `banks`, `ussd2ussd`, `ussd2other`) VALUES
(1, 'GTBank', '*737*1*', '*737*2*'),
(2, 'Fidelity Bank', '*770*', ''),
(3, 'Firstbank', '*894*', ''),
(4, 'Wema Bank', '*945*', ''),
(5, 'Skye Bank', '*833*', ''),
(6, 'Sterling Bank', '*822*4*', '*822*5*'),
(7, 'Diamond Bank', '*710*777*', '*710*710*'),
(8, 'Ecobank', '*326#', ''),
(9, 'Zenith Bank', '*966*', ''),
(10, 'FCMB', '*329*', ''),
(11, 'Unity Bank', '*7799*1*', '*7799*2*'),
(12, 'UBA Bank', '*919*3#', '*919*4#'),
(13, 'Union Bank', '*826*2*', '*826*1*'),
(14, 'Heritage Bank', '*322*030*', ''),
(15, 'Keystone Bank', '*7111*', ''),
(16, 'Access Bank', '*901*1*', '*901*2*'),
(17, 'Stanbic IBTC', '*909*11*', '*909*22*');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `names` varchar(40) NOT NULL,
  `emails` varchar(30) NOT NULL,
  `replies` text NOT NULL,
  `dates` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `event_id`, `names`, `emails`, `replies`, `dates`) VALUES
(1, 2, 'Sgdshgs Sghsgd Gsa', 'gsdgsh@ssss.sss', 'Dhjshdjsa hsjhd sja', '2019-04-24 6:18 pm'),
(2, 2, 'Antonia Okafor', 'antonia247@gmail.com', 'Please can you teach us how you made this dishes, i want to learn pls help, thanks', '2019-04-24 6:19 pm'),
(3, 2, 'Samantha Anthony', 'samatha222@gmail.com', 'This is a very nice platform, all thanks to OurFavCelebs for making this platform help us showcase our talents, business and other useful things. Once again thanks', '2019-04-24 6:21 pm');

-- --------------------------------------------------------

--
-- Table structure for table `contestants`
--

CREATE TABLE `contestants` (
  `id` int(11) NOT NULL,
  `approved` int(2) NOT NULL,
  `fname` varchar(30) NOT NULL,
  `lname` varchar(30) NOT NULL,
  `emails` varchar(30) NOT NULL,
  `phones` varchar(20) NOT NULL,
  `statee` varchar(20) DEFAULT NULL,
  `gender` varchar(3) DEFAULT NULL,
  `pass` varchar(50) DEFAULT NULL,
  `occupatn` varchar(200) DEFAULT NULL,
  `hear_about` text,
  `relationshp_status` varchar(5) DEFAULT NULL,
  `hobbies` text,
  `likes` text,
  `dislikes` text,
  `bios` text,
  `kind_of_partner` text,
  `pics` varchar(30) DEFAULT NULL,
  `paid` int(2) DEFAULT NULL,
  `sent_pay_mail` int(2) DEFAULT NULL,
  `dates` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contestants`
--

INSERT INTO `contestants` (`id`, `approved`, `fname`, `lname`, `emails`, `phones`, `statee`, `gender`, `pass`, `occupatn`, `hear_about`, `relationshp_status`, `hobbies`, `likes`, `dislikes`, `bios`, `kind_of_partner`, `pics`, `paid`, `sent_pay_mail`, `dates`) VALUES
(1, 1, 'Chinny', 'Anthony', 'donchibobo@gmail.com', '08035204317', 'Lagos', 'm', 'df51e37c269aa94d38f93e537bf6e2020b21406c', 'Programmer', '', 'e', 'Programming', 'Respect And Self Discipline', 'Pride And Lies', 'I am who i am, thanks', 'Faithful And Respectful', '1554903607.jpg', 1, 1, '2019-04-10 2:40 pm'),
(2, 1, 'Lydia', 'Abiodun', 'lydia247@gmail.com', '08037748332', 'Ogun', 'f', 'df51e37c269aa94d38f93e537bf6e2020b21406c', 'Business Woman, Selling Fabrics', '', 'm', 'snmsnmsnm', 'nmsnsmnsmn', 'mnsmnsmnmsn', 'nsmnsmns', 'mnsmnmsnm', '1554904956.jpg', 0, 0, '2019-04-10 3:02 pm'),
(3, 1, 'Tonia', 'Okafor', 'toniamodel@yahoo.com', '08060601090', 'Anambra', 'f', 'df51e37c269aa94d38f93e537bf6e2020b21406c', 'Modeling', '', 's', 'singing, dancing, cooking and reading novels', 'jovial, respect and caring', 'pride and lies', 'I am a model from Anambra state, i do it for a living since i finishied my school last year in unizik. I love been simple and i hate being around with fake guys, if u want to knw more about me, follow me here, thanks!', 'i need a slim guy, tall and God fearing', '1554905902.jpg', 0, 0, '2019-04-10 3:18 pm'),
(4, 1, 'fdfdsf', 'dsfdsf', 'dsdsd@ssss.sss', '3434323', 'Delta', 'f', 'df51e37c269aa94d38f93e537bf6e2020b21406c', 'dsdsd', 'sdsadsadsa', '', '', '', '', '', '', '1556837599.jpg', 0, 0, '2019-05-02 11:53 pm'),
(5, 1, 'Daniel', 'Abayomi', 'dans@yahoo.com', '08060668890', 'Ogun', 'm', 'df51e37c269aa94d38f93e537bf6e2020b21406c', 'Im Schooling', '', 'e', 'hghghsgshgshg', 'gshgss', 'ghsgshgsh', 'nbsnbsns', 'sbsnbnbznzb', '1560343038.jpg', 1, 1, '2019-06-12 1:37 pm');

-- --------------------------------------------------------

--
-- Table structure for table `donation`
--

CREATE TABLE `donation` (
  `id` int(11) NOT NULL,
  `names` varchar(30) NOT NULL,
  `phones` varchar(30) NOT NULL,
  `emails` varchar(30) NOT NULL,
  `states` varchar(20) NOT NULL,
  `amts` int(6) NOT NULL,
  `payment_type` varchar(5) NOT NULL,
  `dates` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `donation`
--

INSERT INTO `donation` (`id`, `names`, `phones`, `emails`, `states`, `amts`, `payment_type`, `dates`) VALUES
(1, 'chinny anthony', '08035204317', 'donchibobo@gmail.com', 'Borno', 0, 'mp', '2019-04-26 4:06 pm'),
(2, 'fsdfdf fdfdsfd', '3543543543', 'dsdasd@sss.kkk', 'Abia', 1000, 'mp', '2019-04-26 4:22 pm');

-- --------------------------------------------------------

--
-- Table structure for table `email_reminder_member`
--

CREATE TABLE `email_reminder_member` (
  `id` int(11) NOT NULL,
  `memid` int(11) NOT NULL,
  `main_act_id` int(11) NOT NULL,
  `daily_act_id` int(11) NOT NULL,
  `sent_mail` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `email_reminder_member`
--

INSERT INTO `email_reminder_member` (`id`, `memid`, `main_act_id`, `daily_act_id`, `sent_mail`) VALUES
(1, 1, 23, 40, 1),
(3, 1, 23, 40, 1),
(4, 1, 23, 40, 1);

-- --------------------------------------------------------

--
-- Table structure for table `email_verificatn`
--

CREATE TABLE `email_verificatn` (
  `id` int(11) NOT NULL,
  `emails` varchar(30) NOT NULL,
  `codes` int(7) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `email_verificatn`
--

INSERT INTO `email_verificatn` (`id`, `emails`, `codes`, `status`) VALUES
(2, 'dans@yahoo.com', 0, 1),
(1, 'dsdsd@ssss.sss', 0, 1),
(4, 'fdfd@sss.sss', 0, 1),
(5, 'sdsdsa@ddd.ddd', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `titles` varchar(200) NOT NULL,
  `descrip` text NOT NULL,
  `views` int(11) DEFAULT NULL,
  `dates` varchar(30) NOT NULL,
  `year` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `titles`, `descrip`, `views`, `dates`, `year`) VALUES
(1, '2017 PAGEANT HOST AND BRAVOTV STAR JENNI PULOS TALKS TO PARADE MAGAZINE ABOUT OURFAVCELEBS', 'In an industry where physical appearance is a constant concern, Jenni Pulos, executive assistant to interior designer Jeff Lewis on the reality TV show Flipping Out and mom of two daughters, is setting her sights on beauty that reaches far beyond what meets the eye—and sharing it with others.\r\n\r\nThe Emmy-nominated producer is returning as host of this year’s Miss You Can Do It Pageant, an annual event inviting girls with special needs to compete for the crown in a pageant that celebrates courage and turning disabilities into abilities. Founded in 2004 by Abbey Curran, Miss Iowa 2008, who has cerebral palsy and was the first-ever contestant with a physical disability to compete in the Miss USA pageant, the nonprofit is gearing up for its 14th annual pageant on July 22, 2017, in Davenport, Iowa. Contestants primp and prep for different stages of the competition, such as talent and evening gowns. But when the day is done, it’s all simply a celebration, Pulos says. “Every girl is a winner at this pageant.”\r\n\r\nAs a former judge and host, Pulos gave Parade the inside scoop on this year’s event and what these contestants are teaching her about living a joy-filled life.\r\n\r\n\r\nWhy do you feel strongly about supporting the cause?\r\n\r\nI met Abbey Curran in 2010 when she was being honored at the Susan G. Komen Women of the Year event at UCLA. She’s been such an inspiration to so many and she’s never let any obstacle define her or stop her from her dreams. That was the message in my book (Grin and Bear It, St. Martin’s Press, 2014): don’t let failure define you, rather stand up and make something lovely. And that’s what she’s done. She has cerebral palsy and she always wanted to win Miss USA and compete in a pageant, and many people said she’d never be able to that because she’s handicapped. After her journey, she started this pageant to show other girls with special needs that you can do anything.\r\n\r\nBut this cause also hits close to home for you?\r\n\r\nI have a nephew with special needs. He was diagnosed with a brain tumor at 18 months old. Doctors said he would probably never live past age 4, and now he’s 21. When he couldn’t work a regular job because of his seizures, he got into painting. He’s become an artist, and his career is taking off. He’s creating the most beautiful art. He can’t speak and has about 10 to 20 seizures every day, yet he found his voice through artwork. So many people could have given up on him, and my family didn’t. He knows he has a purpose. We can look at it as a burden, or we can look at it as a soul that has come to teach other people. We may think that they’re suffering, but they are experiencing so much that ‘normal’ people may never understand. And that’s this pageant, and that’s Abbey and her family.\r\n\r\nWhat keeps bringing you back?\r\n\r\nThe first year I judged, it moved me so deeply and in so many ways. Every year, my heart is filled. Whether I’m judging or hosting, I’m in tears of joy over how much we need all need to refocus the lens on what we worry about. These girls have so much joy. Selfishly, it gives me a recharge to understand we should all live in gratitude and joy. These girls inspire me to work harder and want to defy the odds even more.\r\n\r\nThere was one girl named Kathleen VandeMoortel, who won in 2007. And when she passed away, her parents reached out to me. At her funeral, her family was celebrating her life and a big part of her final years was this pageant. They even had her trophy there. It was so emotional for me because they’re reaching out at such tragic time, so the fact that they had that little bit of joy and light is a testament to Abbey Curran. You never know how much something can mean to someone. And it wasn’t about the competition–it was something special for her. The girls get all dressed up in their evening wear and a causal fashion look–it was all very exciting for Kathleen. It meant so much to them that she had that joy during her hardest years.\r\n\r\nAs a former judge, what are some keys things you would typically look for in contestants?\r\n\r\nIt’s more about celebrating the girl! We judged on their message. It was hard though! They are all so full of life. Everybody is celebrated, and everybody is enjoying it so much. It doesn’t come down to who wins because they’ve all made an impact on each other.', 37, '2019-04-15 5:18 pm', 2019),
(2, 'The Nutritional Vegetable', 'Vegetables are good for the body and get your body nourished. \n\nThis was what i did when OurFavCelebs asked us to prepare a nice vegetable dish and i won the best dish of the month. My name is Temitope Adenuga from Ondo state.\n\nI contested last month as the cook of the month and became the first winner, i followed their rules, instructions and timings of each day activity and became the first winner of the event.\n\nAll thanks to OurFavCelebs.', 234, '2019-04-21 9:18 am', 2019),
(3, 'My Interview With OurFavCelebs', 'Chi''D Sunshine, the founder of the OurFavCelebs, interviews Kate Anderson, on her show The Real Story, May 20, 2019. \n\nPlease watch the video and see the funny questions and interactions.', 238, '2019-03-10 5:18 pm', 2019),
(4, 'how we became popular queens on OurFavCelebs', 'Good evening guys i want to tell you guys a short story on how i became popular on OurFavCelebs and how they promoted me and my business. \r\n\r\nI registered on the platform on the 19th of May, 2019 and contested for Miss beauty, i got much votes, more picture likes and passed their games, i was among 67 other contestants and to God be the group, i became the second winner and was so surprised.\r\n\r\nThey gave me my prize and gifts and also promoted my business. All thanks to OurFavCelebs and their wonderful and unique coordination.', 247, '2019-04-15 5:18 pm', 2019);

-- --------------------------------------------------------

--
-- Table structure for table `events_media`
--

CREATE TABLE `events_media` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `files` varchar(20) NOT NULL,
  `myfolder` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events_media`
--

INSERT INTO `events_media` (`id`, `event_id`, `files`, `myfolder`) VALUES
(1, 1, '273_IMAGE.jpg', ''),
(2, 1, 'Banner.jpg', ''),
(3, 2, 'img76.jpg', ''),
(4, 2, 'img79.jpg', ''),
(6, 3, 'miss-nigeria.jpg', ''),
(7, 4, 'banners1.jpg', ''),
(8, 2, 'TA_Intro.mp4', ''),
(35, 40, '15574707111.jpg', ''),
(36, 40, '15574707112.jpg', '');

-- --------------------------------------------------------

--
-- Table structure for table `forums`
--

CREATE TABLE `forums` (
  `id` int(11) NOT NULL,
  `memid` int(11) NOT NULL,
  `topics` int(2) NOT NULL,
  `messages` text NOT NULL,
  `files` varchar(30) NOT NULL,
  `views` int(11) NOT NULL,
  `dates` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forums`
--

INSERT INTO `forums` (`id`, `memid`, `topics`, `messages`, `files`, `views`, `dates`) VALUES
(1, 1, 3, 'This is a raw talent show forum and i so much love it with passion, its one of the businesses i wanted to do before i got a job at the island in lagos \r\n\r\nThis is a raw talent show forum and i so much love it with passion, its one of the businesses i wanted to do before i got a job at the island in lagos ', '1557322899.jpg', 366, '2019-05-08 12:23 pm'),
(2, 2, 1, 'When it will be time to choose contestant, please let everyone be present as we choose randomly, thankss\r\nbnnbn\r\nshdjshdjs', '', 349, '2019-05-08 12:45 pm'),
(3, 1, 1, 'This is the real deal of fashion crazy. So chat me on web.whatsapp.com/sdhehanx\r\nAnd this is my website www.chinny.com or http://fffff.com', '', 190, '2019-05-08 12:49 pm'),
(6, 1, 3, 'sssdsnbds dsdsbbn dbsdbs', '', 33, '2019-05-14 12:33 pm'),
(7, 1, 2, 'this is what u do to make me happy', '', 21, '2019-06-07 8:16 am'),
(8, 1, 3, 'nmnmnmnm', '', 30, '2019-06-07 8:18 am'),
(15, 1, 2, 'dasdsadsa', '', 0, '2019-06-17 12:26 pm'),
(17, 1, 4, 'ddasdsad', '', 2, '2019-06-17 12:32 pm'),
(18, 1, 3, 'dsdsadsadas', '', 0, '2019-06-17 12:39 pm'),
(19, 1, 3, 'fsdfsdfsd', '', 0, '2019-06-17 12:40 pm'),
(20, 1, 1, 'fdsfdfds', '', 0, '2019-06-17 12:40 pm'),
(21, 1, 2, 'dasdsadsaddd', '', 0, '2019-06-17 12:41 pm'),
(22, 1, 2, 'dsdsdsadsdsa', '', 1, '2019-06-17 12:41 pm'),
(23, 1, 1, 'sdsdsad dsdsdsdad', '', 8, '2019-06-17 12:42 pm'),
(24, 1, 3, 'dxxzxzcxzcxzc', '', 56, '2019-06-17 12:42 pm');

-- --------------------------------------------------------

--
-- Table structure for table `forum_reply`
--

CREATE TABLE `forum_reply` (
  `id` int(11) NOT NULL,
  `memid` int(11) NOT NULL,
  `forum_id` int(11) NOT NULL,
  `replies` text NOT NULL,
  `files` varchar(30) NOT NULL,
  `dates` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forum_reply`
--

INSERT INTO `forum_reply` (`id`, `memid`, `forum_id`, `replies`, `files`, `dates`) VALUES
(3, 1, 1, 'this is just a test', '', '2019-05-14 9:36 am'),
(5, 1, 1, 'this is a content with pics, sorry its a reply with pics let me knw if the pics will upload to the database or not, if it doesnt i will correct it because i need to see it uploaded, thanks', '1557831813.jpg', '2019-05-14 12:03 pm'),
(6, 1, 2, 'yeah, this is good, i love it', '', '2019-06-07 9:20 am'),
(7, 1, 2, 'bnbnbnbn', '', '2019-06-07 9:21 am'),
(8, 1, 2, 'bnbnb', '', '2019-06-07 9:22 am'),
(9, 1, 2, 'dsdsds', '', '2019-06-07 9:30 am');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_vid`
--

CREATE TABLE `gallery_vid` (
  `id` int(11) NOT NULL,
  `titles` varchar(200) NOT NULL,
  `views` int(11) NOT NULL,
  `files` varchar(20) NOT NULL,
  `media_type` varchar(4) NOT NULL,
  `dates` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gallery_vid`
--

INSERT INTO `gallery_vid` (`id`, `titles`, `views`, `files`, `media_type`, `dates`) VALUES
(1, 'flexing with my ankara design sewn on my first activity on OurFavCelebs', 4, 'ggg.jpg', 'pic', '2019-03-10 5:18 pm'),
(2, 'The stage show of 2019 contest', 1, 'stage.jpg', 'pic', '2019-03-10 5:18 pm'),
(3, 'Mis Well Dressed Competition Of The Month', 5, '1557476549.jpg', 'pic', '2019-05-10 9:22 am'),
(4, 'Miss Nigeria Beauty Pageant 2016; Top 10 contestants', 4, 'h38RreInpXw', 'vid', '2019-03-10 5:18 pm'),
(5, 'This is anothe sample pics', 7, 'ggg.jpg', 'pic', '2019-03-10 5:18 pm'),
(7, 'Pageant 2017 Ends With Miss Adamawa As Winner', 2, 'cgGC_dv1uoQ', 'vid', '2019-03-10 5:18 pm'),
(8, 'Miss Nigeria Beauty Pageant 2016; raw talents on parade', 1, 'S-VlYOrq9Oc', 'vid', '2019-03-10 5:18 pm'),
(9, 'Miss Nigeria Independence Pageant 2017', 1, 'eFaQhApGhrs', 'vid', '2019-03-10 5:18 pm'),
(10, 'Models show off Talent at the Miss Beautiful Nigeria 2016 Ameborworld TV', 2, '1fmSlsh9_6E', 'vid', '2019-03-10 5:18 pm'),
(11, 'Adorable, Queen Chidinma Aaron From Enugu is Miss Nigeria 2018', 5, 'tqzDPzrsQXk', 'vid', '2019-03-10 5:18 pm'),
(19, 'This Is Another Sample Pics', 1, '1557476382.jpg', 'pic', '2019-05-10 9:19 am'),
(20, 'this is a test video', 9, 'yhdsjsjs', 'vid', '2019-05-10 7:32 am');

-- --------------------------------------------------------

--
-- Table structure for table `pageant_activities`
--

CREATE TABLE `pageant_activities` (
  `id` int(11) NOT NULL,
  `memid` int(11) NOT NULL,
  `activity_id` int(11) DEFAULT NULL,
  `expired` int(2) DEFAULT NULL,
  `what_day` varchar(3) DEFAULT NULL,
  `file1` varchar(20) NOT NULL,
  `file2` varchar(20) NOT NULL,
  `file3` varchar(20) NOT NULL,
  `title1` varchar(100) NOT NULL,
  `title2` varchar(100) NOT NULL,
  `title3` varchar(100) NOT NULL,
  `descrip1` text NOT NULL,
  `descrip2` text NOT NULL,
  `descrip3` text NOT NULL,
  `brief_expr` text,
  `scores` int(5) DEFAULT NULL,
  `scores2` int(5) DEFAULT NULL,
  `scores3` int(5) DEFAULT NULL,
  `winner_computed` int(2) NOT NULL,
  `dates` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pageant_activities`
--

INSERT INTO `pageant_activities` (`id`, `memid`, `activity_id`, `expired`, `what_day`, `file1`, `file2`, `file3`, `title1`, `title2`, `title3`, `descrip1`, `descrip2`, `descrip3`, `brief_expr`, `scores`, `scores2`, `scores3`, `winner_computed`, `dates`) VALUES
(1, 2, 1, 1, 'fri', 'aaaaa.jpg', 'bbbbb.jpg', 'cccc.jpg', 'I love to be real and nothing can stop me, thanks', 'Pics of me flexing my life', 'Another pics of me in my room', 'I love to be real and nothing can stop me, thanks', 'Pics of me flexing my life', 'Another pics of me in my room', 'No explanations, thanks', 50, 33, 80, 1, '2019-04-10 2:40 pm'),
(2, 3, 1, 1, 'fri', 'dddd.jpg', 'eeee.jpg', 'ffff.jpg', 'Im just sexy', 'My husband and children', 'caricature of me, lols', 'im just sexy, dont ask me why, its all God', 'I love my family so much', 'hahahha', 'nothing to write here', 85, 60, 60, 1, '2019-04-10 2:40 pm'),
(3, 2, 1, 1, 'tue', '2222.jpg', '3333.jpg', '4444.jpg', 'hsdhgdhsgsf dgfgd fgdh', 'dfdhfdgfd fgdfdfd', 'fdgfhgdfd fgdgfhgd', 'This will go a long while and in my crib, i dont care about anyone who hates me, so go to hell', 'ghsghdf df gdf dhgfhgdfdf dfgg \r\ndf dhfdfgfd fgdfdgfd\r\nf dfgdgfd gdfgdgfgd', 'ghsghdf df gdf dhgfhgdfdf dfgg \r\ndf dhfdfgfd fgdfdgfd\r\nf dfgdgfd gdfgdgfgd', 'This will go a long while and in my crib, i dont care about anyone who hates me, so go to hell', 70, 40, 40, 1, '2019-04-10 2:40 pm'),
(4, 1, 41, 0, 'sat', '1558106444.jpg', '1865690043.jpg', '2327224172.jpg', 'this is just my style', 'i love my self', 'i enjoy being alone', 'this is my style', 'i love my self again', 'i enjoy being alone oo', 'I cant write much here', 0, 0, 0, 0, '2019-05-17 4:20 pm'),
(8, 1, 43, 0, 'mon', '1560775249.jpg', '2003100450.jpg', '2345429957.jpg', 'this is just a tests', 'this is just a tests', 'this is just a tests', 'this is the description of a test', 'this is the description of a test this is the description of a testthis is the description', 'this is the description of a test this is the description of a test this is the description of a test', 'this is just a tests this is just a tests this is just a tests', 0, 0, 0, 0, '2019-06-17 1:40 pm'),
(9, 5, 43, 0, 'mon', '1560775448.jpg', '1895212135.jpg', '2181371143.jpg', 'this is daniel, im a model', 'this is daniel, im a model', 'this is daniel, im a model', 'this is daniel, im a model this is daniel, im a model this is daniel, im a model', 'this is daniel, im a model this is daniel, im a model', 'this is daniel, im a model\r\nthis is daniel, im a model\r\nthis is daniel, im a model', 'this is daniel, im a model', 0, 0, 0, 0, '2019-06-17 1:44 pm');

-- --------------------------------------------------------

--
-- Table structure for table `paid_users`
--

CREATE TABLE `paid_users` (
  `id` int(11) NOT NULL,
  `memid` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `dates` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `paid_users`
--

INSERT INTO `paid_users` (`id`, `memid`, `activity_id`, `dates`) VALUES
(2, 1, 24, '2019-06-12 1:34 pm'),
(4, 5, 24, '2019-06-12 2:15 pm');

-- --------------------------------------------------------

--
-- Table structure for table `picture_likes`
--

CREATE TABLE `picture_likes` (
  `id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `contestant_id` int(11) NOT NULL,
  `pics` varchar(20) NOT NULL,
  `ip_addrs` varchar(30) NOT NULL,
  `likes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `picture_likes`
--

INSERT INTO `picture_likes` (`id`, `activity_id`, `contestant_id`, `pics`, `ip_addrs`, `likes`) VALUES
(1, 1, 2, 'aaaaajpg', '464645', 1),
(2, 1, 2, 'bbbbbjpg', '::1', 2),
(3, 1, 3, 'ddddjpg', '::1', 1),
(4, 1, 2, 'aaaaajpg', '::1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `quizes`
--

CREATE TABLE `quizes` (
  `id` int(11) NOT NULL,
  `sessions1` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `questions` text NOT NULL,
  `files` varchar(100) DEFAULT NULL,
  `op1` varchar(100) NOT NULL,
  `op2` varchar(100) NOT NULL,
  `op3` varchar(100) DEFAULT NULL,
  `op4` varchar(100) DEFAULT NULL,
  `op5` varchar(100) DEFAULT NULL,
  `ans1` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quizes`
--

INSERT INTO `quizes` (`id`, `sessions1`, `activity_id`, `questions`, `files`, `op1`, `op2`, `op3`, `op4`, `op5`, `ans1`) VALUES
(1, 861805, 3, 'This is the first questionsss', '1556017537.jpg', 'this is option 1', 'fsdfdsfdsfd', 'ddddd', 'sssddddss', 'jjjkkkjjh', 'fsdfdsfdsfd'),
(2, 861805, 3, 'This dhsjh  dhjshds adjshds jdsh dsa dhsahds dsjad hsjd sdjahsdjhsa sajd jsahd sahjd', '1555862280.jpg', 'Dbs', 'Sgsgsd  Sgdhsdgs', 'Dhsdhjshsa', 'Hsdjhsjdhaj', 'Hdjshdjsa', 'Sgsgsd  Sgdhsdgs'),
(3, 582811, 3, 'hgggggggggg', NULL, 'bnbnbn', 'nnbbnb', 'hghghgh', 'ghghhbn', 'gtrtrtrt', 'ghghhbn'),
(4, 346071, 42, 'A rich man that lived in a beautiful house on Baker Street, Mr. Ronald Green, has just been kidnapped and Sherlock Holmes has been appointed to the case. He finds a note at the crime scene written by Mr. Green. It read:\r\n\r\n"First of January, Fourth of October, Fifth of March, Third of June."\r\n\r\nSherlock knew that somehow, the killer’s name was hidden in the note, who''s the killer?', '1560346739.jpg', 'Jack Green, the son and the heir of the property', 'John Jacobson, an employee of Mr. Green', 'June Green, Green’s wife', 'Sherlock Holmes, investigator', 'None', 'John Jacobson, an employee of Mr. Green'),
(5, 346071, 42, 'One snowy night, Sherlock Holmes was in his house sitting by the fire. All of a sudden a snowball came crashing through his window and broke it. Holmes got up and looked out the window just in time to see 3 neighborhood kids who were brothers run around a corner. Their names were John Crimson, Mark Crimson, and Paul Crimson. The next day Holmes got a note that read: "? Crimson. He broke your window."\r\n\r\nWhich of the 3 Crimson brothers should Sherlock Holmes question about the incident?', '1560346904.jpg', 'John Crimson', 'Mark Crimson', 'Paul Crimson', '', '', 'Mark Crimson'),
(6, 346071, 42, 'Look at this image and answer choose the correct answer', '1560347332.jpg', '3', '4', '6', '8', '10', '8'),
(9, 346071, 42, 'From the picture, how many people came to the picnic and how did they get there?', '1560527935.jpg', '4 people; came by leg', '4 people; came by boat', '3 people; came by leg', '3 people; came by car', '3 people; came by boat', '4 people; came by boat'),
(10, 346071, 42, 'I went to bed at 8 o clock in the evening and wound up my clock and set the alarm to sound at 9 o clock in the morning. How many hours sleep would i get before awoken by the alarm?', NULL, '13 hours', '12 hours', '1 hour', '2 hours', '6 hours', '1 hour');

-- --------------------------------------------------------

--
-- Table structure for table `quizes_intro`
--

CREATE TABLE `quizes_intro` (
  `id` int(11) NOT NULL,
  `sessions1` int(11) NOT NULL,
  `activity_id` int(11) DEFAULT NULL,
  `aprvd` int(11) DEFAULT NULL,
  `completeds` int(11) DEFAULT NULL,
  `set_time` int(11) NOT NULL,
  `timings` int(11) DEFAULT NULL,
  `dates` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quizes_intro`
--

INSERT INTO `quizes_intro` (`id`, `sessions1`, `activity_id`, `aprvd`, `completeds`, `set_time`, `timings`, `dates`) VALUES
(2, 863886, 3, 0, 0, 3, 0, '2019-04-21 5:24 pm'),
(4, 582811, 3, NULL, NULL, 8, NULL, '2019-04-30 1:06 am'),
(6, 346071, 3, 1, 1, 20, 0, '2019-06-12 2:27 pm'),
(14, 861805, 42, 0, 0, 33, 0, '2019-06-15 10:49 am');

-- --------------------------------------------------------

--
-- Table structure for table `set_weekly_activity`
--

CREATE TABLE `set_weekly_activity` (
  `id` int(11) NOT NULL,
  `approved` int(2) DEFAULT NULL,
  `session1` int(11) NOT NULL,
  `has_done` int(2) DEFAULT NULL,
  `one_week_timings` int(2) NOT NULL,
  `close_prev_contestant` int(11) DEFAULT NULL,
  `overall_title` varchar(100) NOT NULL,
  `banners` varchar(20) NOT NULL,
  `instructn` text NOT NULL,
  `disqualificatn` text NOT NULL,
  `prize1` int(8) NOT NULL,
  `prize2` int(8) NOT NULL,
  `prize3` int(8) NOT NULL,
  `gift1` varchar(20) NOT NULL,
  `gift2` varchar(20) NOT NULL,
  `gift3` varchar(20) NOT NULL,
  `enable_reg` int(11) NOT NULL,
  `disable_reg` int(11) NOT NULL,
  `dates` varchar(30) NOT NULL,
  `email_reminder` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `set_weekly_activity`
--

INSERT INTO `set_weekly_activity` (`id`, `approved`, `session1`, `has_done`, `one_week_timings`, `close_prev_contestant`, `overall_title`, `banners`, `instructn`, `disqualificatn`, `prize1`, `prize2`, `prize3`, `gift1`, `gift2`, `gift3`, `enable_reg`, `disable_reg`, `dates`, `email_reminder`) VALUES
(1, 1, 1554976004, 1, 0, 1, 'the best fashion killer of the month', 'Banner.jpg', 'This is a one-week activity and you are expected to follow the instructions given to you to earn more score.', 'No disqualifications!', 8000, 5000, 2500, 'watch.jpg', 'indomie.jpg', 'shirt.jpg', 0, 0, '1557834800', 0),
(23, 1, 1557938931, 1, 0, 1, 'this sdsjh shfjdf g dgfh g', '1930857845.jpg', 'Hgfhgfh gdhfd fhdgf hdgf', 'G shgfdfg dfggdfh sfs hf', 4653, 3744, 4568, '1557938931.jpg', '2316467687.jpg', '1786062875.jpg', 1557702000, 1557788400, '1557874800', 1),
(24, 1, 1560337370, 0, 1561892468, 0, 'Big June women''s Month of the year', '2222496350.jpg', 'Please follow the daily instructions as instructed', 'Failure to follow any instructions will be disqualified.', 10000, 15000, 20000, '1560337362.jpg', '1797896333.jpg', '2215270117.jpg', 1560294000, 1560380400, '1560466800', 1);

-- --------------------------------------------------------

--
-- Table structure for table `statess`
--

CREATE TABLE `statess` (
  `names` varchar(30) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `statess`
--

INSERT INTO `statess` (`names`) VALUES
('Abia'),
('Adamawa'),
('Akwa Ibom'),
('Anambra'),
('Bauchi'),
('Bayelsa'),
('Benue'),
('Borno'),
('Cross River'),
('Delta'),
('Ebonyi'),
('Edo'),
('Ekiti'),
('Enugu'),
('FCT Abuja'),
('Gombe'),
('Imo'),
('Jigawa'),
('Kaduna'),
('Kano'),
('Katsina'),
('Kebbi'),
('Kogi'),
('Kwara'),
('Lagos'),
('Nasarawa'),
('Niger'),
('Ogun'),
('Ondo'),
('Osun'),
('Oyo'),
('Plateau'),
('Rivers'),
('Sokoto'),
('Taraba'),
('Yobe'),
('Zamfara');

-- --------------------------------------------------------

--
-- Table structure for table `stud_ans`
--

CREATE TABLE `stud_ans` (
  `id` int(11) NOT NULL,
  `memid` int(11) NOT NULL,
  `gameid` int(11) NOT NULL,
  `sess1` int(11) NOT NULL,
  `answers` text NOT NULL,
  `ids` text NOT NULL,
  `time_finished` int(11) NOT NULL,
  `scores` varchar(30) NOT NULL,
  `timings` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stud_ans`
--

INSERT INTO `stud_ans` (`id`, `memid`, `gameid`, `sess1`, `answers`, `ids`, `time_finished`, `scores`, `timings`) VALUES
(9, 5, 12, 629854, 'Live and Let Die||programmers never sleeps||XL||3||Bambaranut||Maybe||0', '6,9,5,4,7,11,10', 0, '67', 1542889896),
(10, 19, 12, 629854, 'programers never sleep||2||No||61||Bambaranut||nill||C', '9,4,11,10,7,6,5', 0, '90', 1542889896),
(11, 2, 12, 629854, 'Yes||programmers never sleep||nill||3||Beans flour||nill||Octopussy', '11,9,5,4,7,10,6', 0, '440', 1542801844),
(12, 7, 12, 629854, 'programmers never sleeps||nill||nill||Bambaranut||18||Live and Let Die||nill', '9,4,5,7,10,6,11', 0, '84', 1542801844);

-- --------------------------------------------------------

--
-- Table structure for table `stud_start_test`
--

CREATE TABLE `stud_start_test` (
  `id` int(11) NOT NULL,
  `memid` int(11) NOT NULL,
  `quiz_intro_id` int(11) NOT NULL,
  `started_test` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `id` int(11) NOT NULL,
  `ipaddrs` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `visitors`
--

INSERT INTO `visitors` (`id`, `ipaddrs`) VALUES
(1, '::1'),
(2, '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `winneris`
--

CREATE TABLE `winneris` (
  `id` int(11) NOT NULL,
  `approved` int(1) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `memid` int(11) NOT NULL,
  `votes` int(8) NOT NULL,
  `likes` int(8) NOT NULL,
  `g_score` int(5) NOT NULL,
  `j_score` int(5) NOT NULL,
  `over_all` int(5) NOT NULL,
  `positns` int(11) NOT NULL,
  `dates` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `winneris`
--

INSERT INTO `winneris` (`id`, `approved`, `activity_id`, `memid`, `votes`, `likes`, `g_score`, `j_score`, `over_all`, `positns`, `dates`) VALUES
(1, 1, 1, 2, 6, 4, 0, 52, 58, 1, '2019-05-12 1:02 pm'),
(2, 1, 1, 3, 2, 1, 0, 34, 36, 2, '2019-05-12 1:02 pm');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_set_activity2`
--
ALTER TABLE `admin_set_activity2`
  ADD PRIMARY KEY (`id`),
  ADD KEY `titles` (`titles`),
  ADD KEY `day_instructns` (`day_instructns`),
  ADD KEY `game_type` (`game_type`),
  ADD KEY `for_days` (`for_days`),
  ADD KEY `quiz_intro_id` (`quiz_intro_id`);

--
-- Indexes for table `admin_tbls`
--
ALTER TABLE `admin_tbls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `all_votes`
--
ALTER TABLE `all_votes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_id` (`activity_id`),
  ADD KEY `contestant_id` (`contestant_id`),
  ADD KEY `voters_email` (`voters_email`),
  ADD KEY `email_code` (`email_code`);

--
-- Indexes for table `bank_ussd`
--
ALTER TABLE `bank_ussd`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contestants`
--
ALTER TABLE `contestants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fname` (`fname`),
  ADD KEY `lname` (`lname`),
  ADD KEY `emails` (`emails`),
  ADD KEY `emails_2` (`emails`),
  ADD KEY `emails_3` (`emails`),
  ADD KEY `statee` (`statee`),
  ADD KEY `paid` (`paid`),
  ADD KEY `relationshp_status` (`relationshp_status`),
  ADD KEY `pass` (`pass`);

--
-- Indexes for table `donation`
--
ALTER TABLE `donation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `names` (`names`),
  ADD KEY `states` (`states`),
  ADD KEY `amts` (`amts`),
  ADD KEY `payment_type` (`payment_type`);

--
-- Indexes for table `email_reminder_member`
--
ALTER TABLE `email_reminder_member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_verificatn`
--
ALTER TABLE `email_verificatn`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emails` (`emails`,`codes`,`status`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `titles` (`titles`,`dates`,`year`);

--
-- Indexes for table `events_media`
--
ALTER TABLE `events_media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`,`files`);

--
-- Indexes for table `forums`
--
ALTER TABLE `forums`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forum_reply`
--
ALTER TABLE `forum_reply`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery_vid`
--
ALTER TABLE `gallery_vid`
  ADD PRIMARY KEY (`id`),
  ADD KEY `titles` (`titles`,`views`,`files`,`media_type`);

--
-- Indexes for table `pageant_activities`
--
ALTER TABLE `pageant_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `memid` (`memid`,`activity_id`,`expired`,`what_day`,`scores`,`scores2`,`scores3`);

--
-- Indexes for table `paid_users`
--
ALTER TABLE `paid_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `picture_likes`
--
ALTER TABLE `picture_likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quizes`
--
ALTER TABLE `quizes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions1` (`sessions1`,`activity_id`,`op1`,`op2`,`op3`,`op4`,`op5`,`ans1`);

--
-- Indexes for table `quizes_intro`
--
ALTER TABLE `quizes_intro`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions1` (`sessions1`,`activity_id`,`aprvd`,`completeds`,`set_time`,`timings`);

--
-- Indexes for table `set_weekly_activity`
--
ALTER TABLE `set_weekly_activity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `one_week_timings` (`one_week_timings`),
  ADD KEY `overall_title` (`overall_title`),
  ADD KEY `approved` (`approved`,`session1`,`has_done`,`close_prev_contestant`);

--
-- Indexes for table `stud_ans`
--
ALTER TABLE `stud_ans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `memid` (`memid`,`gameid`,`sess1`,`time_finished`,`scores`);

--
-- Indexes for table `stud_start_test`
--
ALTER TABLE `stud_start_test`
  ADD PRIMARY KEY (`id`),
  ADD KEY `memid` (`memid`,`quiz_intro_id`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `winneris`
--
ALTER TABLE `winneris`
  ADD PRIMARY KEY (`id`),
  ADD KEY `approved` (`approved`,`activity_id`,`memid`,`votes`,`likes`,`g_score`,`j_score`,`over_all`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_set_activity2`
--
ALTER TABLE `admin_set_activity2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT for table `admin_tbls`
--
ALTER TABLE `admin_tbls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `all_votes`
--
ALTER TABLE `all_votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `bank_ussd`
--
ALTER TABLE `bank_ussd`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `contestants`
--
ALTER TABLE `contestants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `donation`
--
ALTER TABLE `donation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `email_reminder_member`
--
ALTER TABLE `email_reminder_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `email_verificatn`
--
ALTER TABLE `email_verificatn`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `events_media`
--
ALTER TABLE `events_media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `forums`
--
ALTER TABLE `forums`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `forum_reply`
--
ALTER TABLE `forum_reply`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `gallery_vid`
--
ALTER TABLE `gallery_vid`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `pageant_activities`
--
ALTER TABLE `pageant_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `paid_users`
--
ALTER TABLE `paid_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `picture_likes`
--
ALTER TABLE `picture_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `quizes`
--
ALTER TABLE `quizes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `quizes_intro`
--
ALTER TABLE `quizes_intro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `set_weekly_activity`
--
ALTER TABLE `set_weekly_activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `stud_ans`
--
ALTER TABLE `stud_ans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `stud_start_test`
--
ALTER TABLE `stud_start_test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `winneris`
--
ALTER TABLE `winneris`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
