-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 03, 2020 at 04:08 PM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ajuwaya`
--

-- --------------------------------------------------------

--
-- Table structure for table `advertisments`
--

CREATE TABLE `advertisments` (
  `a_id` int(11) NOT NULL,
  `a_title` varchar(200) DEFAULT NULL,
  `a_desc` varchar(300) DEFAULT NULL,
  `a_url` text,
  `a_img` varchar(100) DEFAULT NULL,
  `status` enum('0','1','2') DEFAULT '1',
  `ad_type` enum('0','1') DEFAULT '0',
  `ad_code` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- --------------------------------------------------------

--
-- Table structure for table `configurations`
--

CREATE TABLE `configurations` (
  `con_id` int(11) NOT NULL,
  `newsfeedPerPage` int(3) DEFAULT NULL,
  `friendsPerPage` int(3) DEFAULT NULL,
  `photosPerPage` int(3) DEFAULT NULL,
  `groupsPerPage` int(3) DEFAULT NULL,
  `adminPerPage` int(3) DEFAULT NULL,
  `uploadImage` int(11) DEFAULT NULL,
  `bannerWidth` int(11) DEFAULT NULL,
  `profileWidth` int(11) DEFAULT NULL,
  `notificationPerPage` int(3) DEFAULT NULL,
  `friendsWidgetPerPage` int(4) DEFAULT NULL,
  `gravatar` enum('0','1') DEFAULT NULL,
  `forgot` varchar(30) DEFAULT NULL,
  `applicationName` varchar(100) NOT NULL,
  `applicationDesc` text NOT NULL,
  `language_labels` enum('0','1') DEFAULT '0',
  `upload` int(11) DEFAULT NULL,
  `applicationToken` varchar(30) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `configurations`
--

INSERT INTO `configurations` (`con_id`, `newsfeedPerPage`, `friendsPerPage`, `photosPerPage`, `groupsPerPage`, `adminPerPage`, `uploadImage`, `bannerWidth`, `profileWidth`, `notificationPerPage`, `friendsWidgetPerPage`, `gravatar`, `forgot`, `applicationName`, `applicationDesc`, `language_labels`, `upload`, `applicationToken`) VALUES
(1, 30, 20, 30, 10, 25, 4096, 900, 250, 30, 8, '0', 'forgotkey', 'Ajuwaya Connect', 'Nigeria Social Network', '0', 1000, 'MySecretToken');

-- --------------------------------------------------------

--
-- Table structure for table `confirm_user`
--

CREATE TABLE `confirm_user` (
  `id` int(11) NOT NULL,
  `email` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pin` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `confirm_user`
--

INSERT INTO `confirm_user` (`id`, `email`, `pin`) VALUES
(1, 'ajuwaya1@ajuwaya.com', '4564'),
(2, 'ajuwaya2@ajuwaya.com', '1376'),
(3, 'ajuwaya3@ajuwaya.com', '0964');

-- --------------------------------------------------------

--
-- Table structure for table `conversation`
--

CREATE TABLE `conversation` (
  `c_id` int(11) NOT NULL,
  `user_one` int(11) NOT NULL,
  `user_two` int(11) NOT NULL,
  `ip` varchar(30) DEFAULT NULL,
  `time` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `conversation`
--

INSERT INTO `conversation` (`c_id`, `user_one`, `user_two`, `ip`, `time`) VALUES
(1, 2, 3, '::1', 1580742305),
(2, 3, 1, '::1', 1580739260);

-- --------------------------------------------------------

--
-- Table structure for table `conversation_reply`
--

CREATE TABLE `conversation_reply` (
  `cr_id` int(11) NOT NULL,
  `reply` text,
  `user_id_fk` int(11) NOT NULL,
  `ip` varchar(30) NOT NULL,
  `time` int(11) NOT NULL,
  `c_id_fk` int(11) NOT NULL,
  `read_status` int(11) NOT NULL DEFAULT '1',
  `lat` varchar(30) DEFAULT NULL,
  `lang` varchar(30) DEFAULT NULL,
  `uploads` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

--
-- Dumping data for table `conversation_reply`
--

INSERT INTO `conversation_reply` (`cr_id`, `reply`, `user_id_fk`, `ip`, `time`, `c_id_fk`, `read_status`, `lat`, `lang`, `uploads`) VALUES
(1, 'hello', 3, '::1', 1580739260, 2, 1, '', '', NULL),
(2, 'hello', 2, '::1', 1580739340, 1, 0, '', '', NULL),
(3, 'what is that?', 2, '::1', 1580739817, 1, 0, '', '', NULL),
(4, 'This is another test', 3, '::1', 1580739837, 1, 0, '', '', NULL),
(5, 'hmmm', 3, '::1', 1580739870, 1, 0, '', '', NULL),
(6, 'hello', 2, '::1', 1580742236, 1, 0, '', '', NULL),
(7, 'what', 2, '::1', 1580742305, 1, 0, '', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `follows`
--

CREATE TABLE `follows` (
  `follows_id` int(11) NOT NULL,
  `follow_one` int(11) NOT NULL,
  `follow_two` int(11) NOT NULL,
  `role` varchar(200) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `friend_id` int(11) NOT NULL,
  `friend_one` int(11) DEFAULT NULL,
  `friend_two` int(11) DEFAULT NULL,
  `role` varchar(5) DEFAULT NULL,
  `created` int(13) DEFAULT '1411570461'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`friend_id`, `friend_one`, `friend_two`, `role`, `created`) VALUES
(1, 1, 1, 'me', 1580729609),
(2, 2, 2, 'me', 1580729826),
(3, 3, 3, 'me', 1580729974),
(4, 3, 2, 'fri', 1580730046),
(5, 3, 1, 'fri', 1580730048),
(6, 2, 1, 'fri', 1580737995);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(200) NOT NULL,
  `group_desc` text NOT NULL,
  `uid_fk` int(11) NOT NULL,
  `type` varchar(200) NOT NULL,
  `group_created` int(11) NOT NULL,
  `group_pic` varchar(100) DEFAULT NULL,
  `group_bg` varchar(100) DEFAULT NULL,
  `group_ip` varchar(30) DEFAULT NULL,
  `status` enum('0','1','2') DEFAULT '1',
  `group_count` int(11) DEFAULT '0',
  `group_updates` int(11) DEFAULT '0',
  `group_bg_position` varchar(20) DEFAULT '0',
  `verified` enum('0','1') DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- --------------------------------------------------------

--
-- Table structure for table `group_users`
--

CREATE TABLE `group_users` (
  `group_user_id` int(11) NOT NULL,
  `group_id_fk` int(11) NOT NULL DEFAULT '0',
  `uid_fk` int(11) NOT NULL DEFAULT '0',
  `status` enum('0','1') DEFAULT '1',
  `created` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- --------------------------------------------------------

--
-- Table structure for table `istyping`
--

CREATE TABLE `istyping` (
  `id` int(11) NOT NULL,
  `user_one` int(11) NOT NULL,
  `user_two` int(11) NOT NULL,
  `istyping` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `istyping`
--

INSERT INTO `istyping` (`id`, `user_one`, `user_two`, `istyping`) VALUES
(1, 3, 1, '0'),
(2, 2, 3, '0'),
(3, 3, 2, '0');

-- --------------------------------------------------------

--
-- Table structure for table `language_labels`
--

CREATE TABLE `language_labels` (
  `labelID` int(11) NOT NULL,
  `commonFriends` varchar(100) DEFAULT NULL,
  `commonGroups` varchar(100) DEFAULT NULL,
  `commonPhotos` varchar(100) DEFAULT NULL,
  `commonCreateGroup` varchar(100) DEFAULT NULL,
  `topMenuHome` varchar(100) DEFAULT NULL,
  `topMenuMessages` varchar(100) DEFAULT NULL,
  `topMenuNotifications` varchar(100) DEFAULT NULL,
  `topMenuSeeAll` varchar(100) DEFAULT NULL,
  `topMenuSettings` varchar(100) DEFAULT NULL,
  `topMenuLogout` varchar(100) DEFAULT NULL,
  `topMenuLogin` varchar(100) DEFAULT NULL,
  `topMenuJoin` varchar(100) DEFAULT NULL,
  `commonAbout` varchar(100) DEFAULT NULL,
  `commonRecentVisitors` varchar(100) DEFAULT NULL,
  `yourPhotos` varchar(100) DEFAULT NULL,
  `photosOfYours` varchar(100) DEFAULT NULL,
  `commonFollowers` varchar(100) DEFAULT NULL,
  `boxName` varchar(100) DEFAULT NULL,
  `boxUpdates` varchar(100) DEFAULT NULL,
  `boxWebcam` varchar(100) DEFAULT NULL,
  `boxLocation` varchar(100) DEFAULT NULL,
  `buttonUpdate` varchar(100) DEFAULT NULL,
  `buttonComment` varchar(100) DEFAULT NULL,
  `buttonFollow` varchar(100) DEFAULT NULL,
  `buttonFollowing` varchar(100) DEFAULT NULL,
  `buttonMessage` varchar(100) DEFAULT NULL,
  `buttonJoinGroup` varchar(100) DEFAULT NULL,
  `buttonUnfollowGroup` varchar(100) DEFAULT NULL,
  `buttonEditGroup` varchar(100) DEFAULT NULL,
  `buttonSaveSettings` varchar(100) DEFAULT NULL,
  `buttonSocialSave` varchar(100) DEFAULT NULL,
  `buttonLogin` varchar(100) DEFAULT NULL,
  `buttonSignUp` varchar(100) DEFAULT NULL,
  `buttonForgotButton` varchar(100) DEFAULT NULL,
  `buttonSetNewPassword` varchar(100) DEFAULT NULL,
  `buttonFacebook` varchar(100) DEFAULT NULL,
  `buttonGoogle` varchar(100) DEFAULT NULL,
  `buttonMicrosoft` varchar(100) DEFAULT NULL,
  `buttonLinkedin` varchar(100) DEFAULT NULL,
  `feedLike` varchar(100) DEFAULT NULL,
  `feedUnLike` varchar(100) DEFAULT NULL,
  `feedLikeThis` varchar(100) DEFAULT NULL,
  `feedShare` varchar(100) DEFAULT NULL,
  `feedUnshare` varchar(100) DEFAULT NULL,
  `feedShareThis` varchar(100) DEFAULT NULL,
  `feedComment` varchar(100) DEFAULT NULL,
  `feedDeleteUpdate` varchar(100) DEFAULT NULL,
  `feedPosted` varchar(100) DEFAULT NULL,
  `settingsTitle` varchar(100) DEFAULT NULL,
  `settingsUsername` varchar(100) DEFAULT NULL,
  `settingsEmail` varchar(100) DEFAULT NULL,
  `settingsName` varchar(100) DEFAULT NULL,
  `settingsPassword` varchar(100) DEFAULT NULL,
  `settingsChangePassword` varchar(100) DEFAULT NULL,
  `settingsOldPassword` varchar(100) DEFAULT NULL,
  `settingsNewPassword` varchar(100) DEFAULT NULL,
  `settingsConfirmPassword` varchar(100) DEFAULT NULL,
  `settingsGroup` varchar(100) DEFAULT NULL,
  `settingsGender` varchar(100) DEFAULT NULL,
  `settingsAboutMe` varchar(100) DEFAULT NULL,
  `settingsEmailAlerts` varchar(100) DEFAULT NULL,
  `socialTitle` varchar(100) DEFAULT NULL,
  `socialFacebook` varchar(100) DEFAULT NULL,
  `socialTwitter` varchar(100) DEFAULT NULL,
  `socialGoogle` varchar(100) DEFAULT NULL,
  `socialInstagram` varchar(100) DEFAULT NULL,
  `placeSearch` varchar(100) DEFAULT NULL,
  `placeComment` varchar(100) DEFAULT NULL,
  `placeUpdate` varchar(100) DEFAULT NULL,
  `placeEmailUsername` varchar(100) DEFAULT NULL,
  `placePassword` varchar(100) DEFAULT NULL,
  `placeEmail` varchar(100) DEFAULT NULL,
  `placeUsername` varchar(100) DEFAULT NULL,
  `loginTitle` varchar(100) DEFAULT NULL,
  `emailUsername` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `forgotPassword` varchar(100) DEFAULT NULL,
  `registrationTitle` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `agreeMessage` varchar(300) DEFAULT NULL,
  `resetPassword` varchar(300) DEFAULT NULL,
  `thankYou` varchar(100) DEFAULT NULL,
  `thankYouMessage` varchar(300) DEFAULT NULL,
  `buttonYou` varchar(100) DEFAULT NULL,
  `commonViewAll` varchar(30) DEFAULT NULL,
  `placeSendMessage` varchar(100) DEFAULT NULL,
  `notiFollowingYou` varchar(100) DEFAULT NULL,
  `notiLiked` varchar(30) DEFAULT NULL,
  `notiShared` varchar(30) DEFAULT NULL,
  `notiStatus` varchar(30) DEFAULT NULL,
  `msgDeleteConversation` varchar(30) DEFAULT NULL,
  `msgConversation` varchar(100) DEFAULT NULL,
  `msgStartConversation` varchar(100) DEFAULT NULL,
  `msgNoUpdates` varchar(100) DEFAULT NULL,
  `msgNoMoreUpdates` varchar(100) DEFAULT NULL,
  `msgNoFriends` varchar(100) DEFAULT NULL,
  `msgNoMoreFriends` varchar(100) DEFAULT NULL,
  `msgNoPhotos` varchar(100) DEFAULT NULL,
  `msgNoMorePhotos` varchar(100) DEFAULT NULL,
  `msgNoViews` varchar(100) DEFAULT NULL,
  `msgNoMoreViews` varchar(100) DEFAULT NULL,
  `msgNoGroups` varchar(100) DEFAULT NULL,
  `msgNoMoreGroups` varchar(100) DEFAULT NULL,
  `commonMembers` varchar(30) DEFAULT NULL,
  `msgNoMembers` varchar(100) DEFAULT NULL,
  `msgNoMoreMembers` varchar(100) DEFAULT NULL,
  `msgNoConversations` varchar(100) DEFAULT NULL,
  `terms` varchar(30) DEFAULT NULL,
  `notiIsFollowingGroup` varchar(100) DEFAULT NULL,
  `notiCommented` varchar(30) DEFAULT NULL,
  `msgNoFollowers` varchar(100) DEFAULT NULL,
  `msgNoMoreFollowers` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

--
-- Dumping data for table `language_labels`
--

INSERT INTO `language_labels` (`labelID`, `commonFriends`, `commonGroups`, `commonPhotos`, `commonCreateGroup`, `topMenuHome`, `topMenuMessages`, `topMenuNotifications`, `topMenuSeeAll`, `topMenuSettings`, `topMenuLogout`, `topMenuLogin`, `topMenuJoin`, `commonAbout`, `commonRecentVisitors`, `yourPhotos`, `photosOfYours`, `commonFollowers`, `boxName`, `boxUpdates`, `boxWebcam`, `boxLocation`, `buttonUpdate`, `buttonComment`, `buttonFollow`, `buttonFollowing`, `buttonMessage`, `buttonJoinGroup`, `buttonUnfollowGroup`, `buttonEditGroup`, `buttonSaveSettings`, `buttonSocialSave`, `buttonLogin`, `buttonSignUp`, `buttonForgotButton`, `buttonSetNewPassword`, `buttonFacebook`, `buttonGoogle`, `buttonMicrosoft`, `buttonLinkedin`, `feedLike`, `feedUnLike`, `feedLikeThis`, `feedShare`, `feedUnshare`, `feedShareThis`, `feedComment`, `feedDeleteUpdate`, `feedPosted`, `settingsTitle`, `settingsUsername`, `settingsEmail`, `settingsName`, `settingsPassword`, `settingsChangePassword`, `settingsOldPassword`, `settingsNewPassword`, `settingsConfirmPassword`, `settingsGroup`, `settingsGender`, `settingsAboutMe`, `settingsEmailAlerts`, `socialTitle`, `socialFacebook`, `socialTwitter`, `socialGoogle`, `socialInstagram`, `placeSearch`, `placeComment`, `placeUpdate`, `placeEmailUsername`, `placePassword`, `placeEmail`, `placeUsername`, `loginTitle`, `emailUsername`, `password`, `forgotPassword`, `registrationTitle`, `email`, `username`, `agreeMessage`, `resetPassword`, `thankYou`, `thankYouMessage`, `buttonYou`, `commonViewAll`, `placeSendMessage`, `notiFollowingYou`, `notiLiked`, `notiShared`, `notiStatus`, `msgDeleteConversation`, `msgConversation`, `msgStartConversation`, `msgNoUpdates`, `msgNoMoreUpdates`, `msgNoFriends`, `msgNoMoreFriends`, `msgNoPhotos`, `msgNoMorePhotos`, `msgNoViews`, `msgNoMoreViews`, `msgNoGroups`, `msgNoMoreGroups`, `commonMembers`, `msgNoMembers`, `msgNoMoreMembers`, `msgNoConversations`, `terms`, `notiIsFollowingGroup`, `notiCommented`, `msgNoFollowers`, `msgNoMoreFollowers`) VALUES
(1, 'друзья', 'группы', 'Фото', 'Создать группу', 'Главная', 'Сообщения', 'Уведомления', 'Увидеть все', 'настройки', 'Выйти', 'Авторизоваться', 'Присоединиться', 'Около', 'Последние посетители', 'Профиль фотографии', 'Фотографии', 'Последователи', 'Что происходит', 'Обновления', 'Веб-камера', 'Место нахождения', 'Обновить', 'Комментарий', 'следить', 'Следующий', 'Сообщение', 'Вступить в группу', 'Отписаться Группа', 'Изменить группу', 'Сохранить настройки', 'Социальная Сохранить', 'Авторизоваться', 'Зарегистрироваться', 'Забыли пароль', 'Установить новый пароль - сброс', 'Войти с Facebook', 'Вход с Google', 'Вход с Microsoft', 'Вход с LinkedIn', 'подобно', 'В отличие от', 'как это', 'Поделиться', 'из открытого списка', 'поделились этой', 'Комментарий', 'Удалить обновление', 'Опубликовано в', 'Настройки Название', 'имя пользователя', 'Эл. адрес', 'имя', 'пароль', 'Изменить пароль', 'Старый пароль', 'новый пароль', 'Подтвердите Пароль', 'группа', 'Пол', 'Обо мне', 'Уведомления по электронной почте', 'Социальная Заголовок', 'Социальные сети Facebook', 'Социальная Twitter', 'Социальная Google', 'Социальная Instagram', 'Поиск людей', 'Написать комментарий', 'Написать обновление.', 'Электронная почта или имя пользователя.', 'Введите пароль', 'Введите адрес электронной почты', 'Введите имя пользователя', 'Войти Название', 'Электронная почта или имя пользователя', 'пароль', 'Забыли пароль', 'Регистрация Название', 'Эл. адрес ', 'Электронная почта или имя пользователя', 'Регистрация Согласитесь сообщение', 'Сброс пароля', 'Спасибо!', 'Пожалуйста conirm сообщение', 'Вы', 'Посмотреть все', 'Отправить сообщение', 'после вас', 'понравилось', 'общий', 'положение дел', 'Удалить беседу', 'разговор', 'Начало разговора', 'Нет обновлений', 'Нет больше обновлений', 'Нет друзей', 'Нет больше друзей', 'Нет фото', 'Нет больше фотографий', 'Нет просмотров', 'Нет больше просмотров', 'Нет групп', 'Нет больше групп', 'члены', 'Нет участников', 'Нет больше членов', 'Нет цепочек', 'сроки', 'следующая группа', 'прокомментировал', 'Нет последователи', 'Нет больше последователей');

-- --------------------------------------------------------

--
-- Table structure for table `last_seen`
--

CREATE TABLE `last_seen` (
  `id` int(11) NOT NULL,
  `uid_fk` int(11) NOT NULL,
  `last_update_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_seen` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `last_seen`
--

INSERT INTO `last_seen` (`id`, `uid_fk`, `last_update_timestamp`, `last_seen`) VALUES
(1, 475, '2020-02-03 11:31:30', '1580729490'),
(2, 1, '2020-02-03 11:35:18', '1580729718'),
(3, 2, '2020-02-03 15:08:39', '1580742519'),
(4, 3, '2020-02-03 15:08:29', '1580742509');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `msg_id` int(11) NOT NULL,
  `message` text CHARACTER SET utf8mb4,
  `uid_fk` int(11) DEFAULT NULL,
  `ip` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created` int(11) DEFAULT '1269249260',
  `uploads` mediumtext COLLATE utf8mb4_unicode_ci,
  `links` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `like_count` int(11) DEFAULT '0',
  `comment_count` int(11) DEFAULT '0',
  `share_count` int(11) DEFAULT '0',
  `group_id_fk` int(11) DEFAULT '0',
  `lat` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lang` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `url_title` text COLLATE utf8mb4_unicode_ci,
  `url_source` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_decription` text COLLATE utf8mb4_unicode_ci,
  `url_images` text COLLATE utf8mb4_unicode_ci,
  `url_fetch_src` text COLLATE utf8mb4_unicode_ci,
  `article_title` text COLLATE utf8mb4_unicode_ci,
  `article_description` text COLLATE utf8mb4_unicode_ci,
  `article_content` mediumtext COLLATE utf8mb4_unicode_ci,
  `post_type` enum('story','status') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'status'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=FIXED;

-- --------------------------------------------------------

--
-- Table structure for table `message_like`
--

CREATE TABLE `message_like` (
  `like_id` int(11) NOT NULL,
  `msg_id_fk` int(11) NOT NULL,
  `uid_fk` int(11) NOT NULL,
  `ouid_fk` int(11) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `reactionType` int(2) DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- --------------------------------------------------------

--
-- Table structure for table `message_share`
--

CREATE TABLE `message_share` (
  `share_id` int(11) NOT NULL,
  `msg_id_fk` int(11) NOT NULL,
  `uid_fk` int(11) NOT NULL,
  `ouid_fk` int(11) DEFAULT NULL,
  `created` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- --------------------------------------------------------

--
-- Table structure for table `profile_views`
--

CREATE TABLE `profile_views` (
  `uid_fk` int(11) NOT NULL DEFAULT '0',
  `view_uid_fk` int(11) NOT NULL DEFAULT '0',
  `created` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `profile_pic` varchar(200) DEFAULT NULL,
  `friend_count` int(11) DEFAULT '0',
  `status` int(1) DEFAULT '1',
  `mariage_status` varchar(40) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `profile_pic_status` int(1) DEFAULT '0',
  `conversation_count` int(11) DEFAULT '0',
  `updates_count` int(11) DEFAULT '0',
  `first_name` varchar(200) DEFAULT NULL,
  `last_name` varchar(200) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `birthday` varchar(20) DEFAULT NULL,
  `location` varchar(200) DEFAULT NULL,
  `hometown` varchar(200) DEFAULT NULL,
  `about` text NOT NULL,
  `bio` text,
  `relationship` varchar(30) DEFAULT NULL,
  `timezone` varchar(10) DEFAULT NULL,
  `provider` varchar(10) DEFAULT NULL,
  `provider_id` varchar(200) DEFAULT NULL,
  `profile_bg` varchar(200) DEFAULT NULL,
  `group_count` int(11) DEFAULT '0',
  `channel_count` int(11) DEFAULT '0',
  `last_login` int(13) DEFAULT NULL,
  `profile_bg_position` varchar(20) DEFAULT '0',
  `verified` enum('0','1') DEFAULT '0',
  `notification_created` int(11) DEFAULT NULL,
  `forgot_code` text,
  `photos_count` int(11) DEFAULT '0',
  `tour` enum('0','1') DEFAULT '0',
  `address` varchar(500) NOT NULL,
  `phone_number` varchar(200) NOT NULL,
  `facebookProfile` varchar(200) DEFAULT NULL,
  `twitterProfile` varchar(200) DEFAULT NULL,
  `googleProfile` varchar(200) DEFAULT NULL,
  `instagramProfile` varchar(200) DEFAULT NULL,
  `linkedin` varchar(200) NOT NULL,
  `whatsapp` varchar(200) NOT NULL,
  `website` varchar(200) NOT NULL,
  `emailNotifications` enum('0','1') DEFAULT '1',
  `email_activation` varchar(300) DEFAULT NULL,
  `institution` varchar(200) NOT NULL,
  `faculty` varchar(200) NOT NULL,
  `department` varchar(200) NOT NULL,
  `course` varchar(200) NOT NULL,
  `set_year` varchar(200) NOT NULL,
  `serve_state` varchar(200) NOT NULL,
  `serve_lga` varchar(200) NOT NULL,
  `serve_year` varchar(200) NOT NULL,
  `from_state` varchar(400) NOT NULL,
  `from_lga` varchar(400) NOT NULL,
  `present_state` varchar(200) NOT NULL,
  `present_lga` varchar(200) NOT NULL,
  `occupation` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `username`, `password`, `email`, `profile_pic`, `friend_count`, `status`, `mariage_status`, `name`, `profile_pic_status`, `conversation_count`, `updates_count`, `first_name`, `last_name`, `gender`, `birthday`, `location`, `hometown`, `about`, `bio`, `relationship`, `timezone`, `provider`, `provider_id`, `profile_bg`, `group_count`, `channel_count`, `last_login`, `profile_bg_position`, `verified`, `notification_created`, `forgot_code`, `photos_count`, `tour`, `address`, `phone_number`, `facebookProfile`, `twitterProfile`, `googleProfile`, `instagramProfile`, `linkedin`, `whatsapp`, `website`, `emailNotifications`, `email_activation`, `institution`, `faculty`, `department`, `course`, `set_year`, `serve_state`, `serve_lga`, `serve_year`, `from_state`, `from_lga`, `present_state`, `present_lga`, `occupation`) VALUES
(1, 'ajuwaya1', '5ae0d285d83dee69bd4a55b4990338f4', 'ajuwaya1@ajuwaya.com', NULL, 0, 1, '', 'Ajuwaya One', 0, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1580729609, '0', '0', NULL, NULL, 0, '0', '', '', NULL, NULL, NULL, NULL, '', '', '', '1', 'a60996219a325a44dccd6448524253ce', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(2, 'ajuwaya2', '5ae0d285d83dee69bd4a55b4990338f4', 'ajuwaya2@ajuwaya.com', NULL, 1, 1, '', 'Ajuwaya Two', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1580737988, '0', '0', 1580737988, NULL, 0, '0', '', '', NULL, NULL, NULL, NULL, '', '', '', '1', '55a1d87fafc2ad2dd99d27d9a433ce1f', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3, 'ajuwaya3', '5ae0d285d83dee69bd4a55b4990338f4', 'ajuwaya3@ajuwaya.com', NULL, 2, 1, '', 'Ajuwaya Three', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1580729974, '0', '0', NULL, NULL, 0, '0', '', '', NULL, NULL, NULL, NULL, '', '', '', '1', '95a189d84d4f247e5867d42cb1d82ea2', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_uploads`
--

CREATE TABLE `user_uploads` (
  `id` int(11) NOT NULL,
  `image_path` varchar(200) DEFAULT NULL,
  `uid_fk` int(11) DEFAULT NULL,
  `group_id_fk` int(11) DEFAULT '0',
  `image_type` enum('0','1','2') DEFAULT '0',
  `upload_types` varchar(30) NOT NULL,
  `created` varchar(60) NOT NULL,
  `time` varchar(60) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `advertisments`
--
ALTER TABLE `advertisments`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `configurations`
--
ALTER TABLE `configurations`
  ADD PRIMARY KEY (`con_id`);

--
-- Indexes for table `confirm_user`
--
ALTER TABLE `confirm_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conversation`
--
ALTER TABLE `conversation`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `user_one` (`user_one`),
  ADD KEY `user_two` (`user_two`);

--
-- Indexes for table `conversation_reply`
--
ALTER TABLE `conversation_reply`
  ADD PRIMARY KEY (`cr_id`),
  ADD KEY `user_id_fk` (`user_id_fk`),
  ADD KEY `c_id_fk` (`c_id_fk`);

--
-- Indexes for table `follows`
--
ALTER TABLE `follows`
  ADD PRIMARY KEY (`follows_id`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`friend_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `group_users`
--
ALTER TABLE `group_users`
  ADD PRIMARY KEY (`group_id_fk`,`uid_fk`),
  ADD UNIQUE KEY `group_user_id` (`group_user_id`);

--
-- Indexes for table `istyping`
--
ALTER TABLE `istyping`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `language_labels`
--
ALTER TABLE `language_labels`
  ADD PRIMARY KEY (`labelID`);

--
-- Indexes for table `last_seen`
--
ALTER TABLE `last_seen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`msg_id`),
  ADD KEY `uid_fk` (`uid_fk`);

--
-- Indexes for table `message_like`
--
ALTER TABLE `message_like`
  ADD PRIMARY KEY (`like_id`),
  ADD KEY `uid_fk` (`uid_fk`),
  ADD KEY `msg_id_fk` (`msg_id_fk`);

--
-- Indexes for table `message_share`
--
ALTER TABLE `message_share`
  ADD PRIMARY KEY (`share_id`),
  ADD KEY `uid_fk` (`uid_fk`),
  ADD KEY `msg_id_fk` (`msg_id_fk`);

--
-- Indexes for table `profile_views`
--
ALTER TABLE `profile_views`
  ADD PRIMARY KEY (`uid_fk`,`view_uid_fk`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `user_uploads`
--
ALTER TABLE `user_uploads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid_fk` (`uid_fk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `advertisments`
--
ALTER TABLE `advertisments`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `configurations`
--
ALTER TABLE `configurations`
  MODIFY `con_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `confirm_user`
--
ALTER TABLE `confirm_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `conversation`
--
ALTER TABLE `conversation`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `conversation_reply`
--
ALTER TABLE `conversation_reply`
  MODIFY `cr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `follows`
--
ALTER TABLE `follows`
  MODIFY `follows_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `friend_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_users`
--
ALTER TABLE `group_users`
  MODIFY `group_user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `istyping`
--
ALTER TABLE `istyping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `language_labels`
--
ALTER TABLE `language_labels`
  MODIFY `labelID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `last_seen`
--
ALTER TABLE `last_seen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message_like`
--
ALTER TABLE `message_like`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message_share`
--
ALTER TABLE `message_share`
  MODIFY `share_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_uploads`
--
ALTER TABLE `user_uploads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
