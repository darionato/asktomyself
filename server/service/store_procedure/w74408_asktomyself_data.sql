SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

INSERT INTO `askme_users` (`name`, `pass`, `id_user`) VALUES
('admin', 'malfatti', 1);

INSERT INTO `askme_categories` (`id_category`, `desc`, `id_user`) VALUES
(1, 'Inglese - Italiano', 1),
(2, 'Italiano - Inglese', 1);


INSERT INTO `askme_key_settings` (`id_setting`, `desc`, `type_value`) VALUES
(1, 'time_out_ask', 1),
(2, 'last_category', 1),
(3, 'invert', 1),
(4, 'dowload_image', 1);


INSERT INTO `askme_log` (`id_user`, `date`, `id_log`) VALUES
(1, '2010-02-16 17:22:15', 1),
(1, '2010-02-16 17:40:15', 1),
(1, '2010-02-16 18:03:49', 1),
(1, '2010-02-16 21:21:52', 1),
(1, '2010-02-16 21:22:30', 1),
(1, '2010-02-17 08:42:25', 1),
(1, '2010-02-17 12:21:44', 1),
(1, '2010-02-17 12:22:35', 1),
(1, '2010-02-17 12:31:24', 1),
(1, '2010-02-17 15:46:23', 1),
(1, '2010-02-17 15:48:07', 1),
(1, '2010-02-17 17:44:59', 1),
(1, '2010-02-17 17:57:23', 1),
(1, '2010-02-18 22:37:12', 1),
(1, '2010-02-18 22:42:24', 1),
(1, '2010-02-19 21:09:04', 1),
(1, '2010-02-22 17:46:36', 1),
(1, '2010-02-22 17:51:47', 1),
(1, '2010-02-22 17:52:10', 1),
(1, '2010-02-22 17:57:34', 1),
(1, '2010-02-22 17:58:12', 1),
(1, '2010-02-23 09:08:45', 1),
(1, '2010-02-23 11:24:03', 1),
(1, '2010-02-23 16:55:36', 1),
(1, '2010-02-23 17:06:39', 1),
(1, '2010-02-23 17:08:15', 1),
(1, '2010-02-23 17:15:26', 1),
(1, '2010-02-23 17:58:46', 1),
(1, '2010-02-23 20:49:55', 1),
(1, '2010-02-23 23:05:10', 1),
(1, '2010-02-24 15:40:55', 1),
(1, '2010-02-24 17:03:08', 1),
(1, '2010-02-25 08:40:03', 1),
(1, '2010-02-25 09:10:03', 1),
(1, '2010-02-26 21:09:13', 1),
(1, '2010-03-01 17:46:18', 1),
(1, '2010-02-16 17:44:52', 2),
(1, '2010-02-16 17:49:03', 2),
(1, '2010-02-16 17:53:16', 2),
(1, '2010-02-16 17:57:59', 2),
(1, '2010-02-16 21:26:31', 2),
(1, '2010-02-16 21:30:52', 2),
(1, '2010-02-16 21:35:13', 2),
(1, '2010-02-16 21:39:30', 2),
(1, '2010-02-16 21:43:42', 2),
(1, '2010-02-16 21:47:52', 2),
(1, '2010-02-16 21:52:20', 2),
(1, '2010-02-16 21:56:35', 2),
(1, '2010-02-16 22:00:50', 2),
(1, '2010-02-16 22:05:10', 2),
(1, '2010-02-16 22:09:27', 2),
(1, '2010-02-16 22:13:51', 2),
(1, '2010-02-16 22:18:03', 2),
(1, '2010-02-16 22:22:15', 2),
(1, '2010-02-16 22:26:26', 2),
(1, '2010-02-16 22:30:37', 2),
(1, '2010-02-16 22:34:46', 2),
(1, '2010-02-16 22:38:58', 2),
(1, '2010-02-16 22:43:11', 2),
(1, '2010-02-16 22:47:21', 2),
(1, '2010-02-16 22:51:44', 2),
(1, '2010-02-16 22:56:00', 2),
(1, '2010-02-17 08:46:26', 2),
(1, '2010-02-17 08:50:41', 2),
(1, '2010-02-17 08:54:52', 2),
(1, '2010-02-17 08:59:03', 2),
(1, '2010-02-17 09:03:14', 2),
(1, '2010-02-17 09:07:24', 2),
(1, '2010-02-17 09:11:36', 2),
(1, '2010-02-17 09:15:49', 2),
(1, '2010-02-17 09:19:58', 2),
(1, '2010-02-17 09:24:06', 2),
(1, '2010-02-17 09:28:18', 2),
(1, '2010-02-17 09:32:26', 2),
(1, '2010-02-17 09:36:39', 2),
(1, '2010-02-17 09:41:18', 2),
(1, '2010-02-17 09:45:28', 2),
(1, '2010-02-17 09:49:35', 2),
(1, '2010-02-17 09:53:46', 2),
(1, '2010-02-17 09:57:57', 2),
(1, '2010-02-17 10:04:47', 2),
(1, '2010-02-17 10:08:57', 2),
(1, '2010-02-17 10:13:06', 2),
(1, '2010-02-17 10:17:36', 2),
(1, '2010-02-17 10:21:49', 2),
(1, '2010-02-17 10:25:57', 2),
(1, '2010-02-17 10:57:47', 2),
(1, '2010-02-17 11:01:58', 2),
(1, '2010-02-17 11:06:29', 2),
(1, '2010-02-17 11:10:42', 2),
(1, '2010-02-17 11:18:55', 2),
(1, '2010-02-17 11:23:04', 2),
(1, '2010-02-17 11:27:25', 2),
(1, '2010-02-17 11:31:33', 2),
(1, '2010-02-17 11:35:47', 2),
(1, '2010-02-17 11:40:13', 2),
(1, '2010-02-17 12:35:25', 2),
(1, '2010-02-17 12:40:08', 2),
(1, '2010-02-17 15:52:08', 2),
(1, '2010-02-17 15:56:45', 2),
(1, '2010-02-17 16:01:10', 2),
(1, '2010-02-17 16:05:23', 2),
(1, '2010-02-17 16:09:37', 2),
(1, '2010-02-17 16:33:13', 2),
(1, '2010-02-17 16:37:25', 2),
(1, '2010-02-17 16:41:39', 2),
(1, '2010-02-17 16:45:59', 2),
(1, '2010-02-17 16:50:25', 2),
(1, '2010-02-17 16:55:20', 2),
(1, '2010-02-17 17:29:32', 2),
(1, '2010-02-17 17:33:44', 2),
(1, '2010-02-17 17:37:57', 2),
(1, '2010-02-18 22:41:14', 2),
(1, '2010-02-18 22:46:25', 2),
(1, '2010-02-18 22:50:50', 2),
(1, '2010-02-18 22:55:08', 2),
(1, '2010-02-23 09:12:46', 2),
(1, '2010-02-23 09:17:03', 2),
(1, '2010-02-23 09:21:30', 2),
(1, '2010-02-23 09:25:38', 2),
(1, '2010-02-23 09:30:15', 2),
(1, '2010-02-23 09:34:22', 2),
(1, '2010-02-23 09:38:33', 2),
(1, '2010-02-23 09:42:42', 2),
(1, '2010-02-23 09:46:50', 2),
(1, '2010-02-23 09:51:04', 2),
(1, '2010-02-23 09:55:17', 2),
(1, '2010-02-23 11:28:04', 2),
(1, '2010-02-23 11:32:22', 2),
(1, '2010-02-23 11:36:39', 2),
(1, '2010-02-23 11:41:59', 2),
(1, '2010-02-23 11:46:26', 2),
(1, '2010-02-23 11:50:38', 2),
(1, '2010-02-23 11:54:46', 2),
(1, '2010-02-23 11:59:08', 2),
(1, '2010-02-23 12:03:18', 2),
(1, '2010-02-23 12:07:34', 2),
(1, '2010-02-23 12:11:42', 2),
(1, '2010-02-23 12:15:53', 2),
(1, '2010-02-23 12:20:00', 2),
(1, '2010-02-23 12:24:27', 2),
(1, '2010-02-23 12:28:36', 2),
(1, '2010-02-23 12:32:46', 2),
(1, '2010-02-23 14:08:41', 2),
(1, '2010-02-23 16:59:37', 2),
(1, '2010-02-23 17:19:26', 2),
(1, '2010-02-23 17:23:47', 2),
(1, '2010-02-23 17:28:03', 2),
(1, '2010-02-23 17:33:16', 2),
(1, '2010-02-23 17:37:27', 2),
(1, '2010-02-23 17:41:39', 2),
(1, '2010-02-23 17:45:58', 2),
(1, '2010-02-23 17:50:09', 2),
(1, '2010-02-23 17:54:23', 2),
(1, '2010-02-23 18:02:46', 2),
(1, '2010-02-23 20:53:56', 2),
(1, '2010-02-23 20:58:07', 2),
(1, '2010-02-23 21:02:28', 2),
(1, '2010-02-23 21:06:41', 2),
(1, '2010-02-23 21:10:50', 2),
(1, '2010-02-23 21:15:01', 2),
(1, '2010-02-23 21:19:17', 2),
(1, '2010-02-23 21:23:25', 2),
(1, '2010-02-23 21:27:34', 2),
(1, '2010-02-23 21:32:00', 2),
(1, '2010-02-23 21:36:11', 2),
(1, '2010-02-23 21:40:22', 2),
(1, '2010-02-23 21:44:37', 2),
(1, '2010-02-23 21:48:53', 2),
(1, '2010-02-23 21:53:16', 2),
(1, '2010-02-23 21:57:28', 2),
(1, '2010-02-23 22:01:45', 2),
(1, '2010-02-24 15:44:55', 2),
(1, '2010-02-24 15:49:26', 2),
(1, '2010-02-24 15:53:38', 2),
(1, '2010-02-24 15:57:44', 2),
(1, '2010-02-24 16:01:54', 2),
(1, '2010-02-24 16:06:02', 2),
(1, '2010-02-24 16:10:14', 2),
(1, '2010-02-24 16:14:26', 2),
(1, '2010-02-24 16:18:34', 2),
(1, '2010-02-24 17:07:26', 2),
(1, '2010-02-24 17:11:42', 2),
(1, '2010-02-24 17:15:55', 2),
(1, '2010-02-24 17:25:12', 2),
(1, '2010-02-24 17:29:20', 2),
(1, '2010-02-24 17:33:36', 2),
(1, '2010-02-24 17:37:49', 2),
(1, '2010-02-24 17:42:04', 2),
(1, '2010-02-24 17:46:14', 2),
(1, '2010-02-25 08:44:55', 2),
(1, '2010-02-25 08:49:09', 2),
(1, '2010-02-25 08:54:18', 2),
(1, '2010-02-25 09:14:05', 2),
(1, '2010-02-25 09:18:18', 2),
(1, '2010-02-25 09:23:07', 2),
(1, '2010-02-25 09:27:17', 2),
(1, '2010-02-25 09:31:49', 2),
(1, '2010-02-25 09:35:59', 2),
(1, '2010-02-25 09:40:11', 2),
(1, '2010-02-25 09:44:18', 2),
(1, '2010-02-25 09:48:27', 2),
(1, '2010-02-25 09:52:35', 2),
(1, '2010-02-25 09:56:47', 2),
(1, '2010-02-25 10:28:43', 2),
(1, '2010-02-25 10:33:00', 2),
(1, '2010-02-25 15:15:08', 2),
(1, '2010-02-25 15:19:35', 2),
(1, '2010-02-26 21:13:28', 2),
(1, '2010-02-26 21:17:37', 2),
(1, '2010-02-26 21:22:00', 2),
(1, '2010-02-26 21:26:20', 2),
(1, '2010-02-26 21:30:29', 2),
(1, '2010-03-01 17:50:37', 2),
(1, '2010-02-16 17:45:03', 3),
(1, '2010-02-16 17:49:16', 3),
(1, '2010-02-16 17:53:59', 3),
(1, '2010-02-16 17:58:12', 3),
(1, '2010-02-16 21:26:52', 3),
(1, '2010-02-16 21:31:13', 3),
(1, '2010-02-16 21:35:29', 3),
(1, '2010-02-16 21:39:43', 3),
(1, '2010-02-16 21:43:52', 3),
(1, '2010-02-16 21:48:20', 3),
(1, '2010-02-16 21:52:35', 3),
(1, '2010-02-16 21:56:50', 3),
(1, '2010-02-16 22:01:10', 3),
(1, '2010-02-16 22:05:27', 3),
(1, '2010-02-16 22:09:51', 3),
(1, '2010-02-16 22:14:03', 3),
(1, '2010-02-16 22:18:15', 3),
(1, '2010-02-16 22:22:26', 3),
(1, '2010-02-16 22:26:37', 3),
(1, '2010-02-16 22:30:46', 3),
(1, '2010-02-16 22:34:58', 3),
(1, '2010-02-16 22:39:11', 3),
(1, '2010-02-16 22:43:20', 3),
(1, '2010-02-16 22:47:44', 3),
(1, '2010-02-16 22:52:00', 3),
(1, '2010-02-16 22:56:08', 3),
(1, '2010-02-17 08:46:41', 3),
(1, '2010-02-17 08:50:52', 3),
(1, '2010-02-17 08:55:02', 3),
(1, '2010-02-17 08:59:14', 3),
(1, '2010-02-17 09:03:24', 3),
(1, '2010-02-17 09:07:36', 3),
(1, '2010-02-17 09:11:49', 3),
(1, '2010-02-17 09:15:58', 3),
(1, '2010-02-17 09:20:06', 3),
(1, '2010-02-17 09:24:18', 3),
(1, '2010-02-17 09:28:26', 3),
(1, '2010-02-17 09:32:39', 3),
(1, '2010-02-17 09:37:18', 3),
(1, '2010-02-17 09:41:28', 3),
(1, '2010-02-17 09:45:35', 3),
(1, '2010-02-17 09:49:46', 3),
(1, '2010-02-17 09:53:57', 3),
(1, '2010-02-17 10:00:47', 3),
(1, '2010-02-17 10:04:57', 3),
(1, '2010-02-17 10:09:06', 3),
(1, '2010-02-17 10:13:36', 3),
(1, '2010-02-17 10:17:49', 3),
(1, '2010-02-17 10:21:57', 3),
(1, '2010-02-17 10:26:08', 3),
(1, '2010-02-17 10:57:58', 3),
(1, '2010-02-17 11:02:29', 3),
(1, '2010-02-17 11:06:42', 3),
(1, '2010-02-17 11:10:58', 3),
(1, '2010-02-17 11:19:04', 3),
(1, '2010-02-17 11:23:25', 3),
(1, '2010-02-17 11:27:33', 3),
(1, '2010-02-17 11:31:47', 3),
(1, '2010-02-17 11:36:12', 3),
(1, '2010-02-17 11:40:21', 3),
(1, '2010-02-17 12:36:08', 3),
(1, '2010-02-17 15:52:45', 3),
(1, '2010-02-17 15:57:10', 3),
(1, '2010-02-17 16:01:23', 3),
(1, '2010-02-17 16:05:37', 3),
(1, '2010-02-17 16:29:13', 3),
(1, '2010-02-17 16:33:25', 3),
(1, '2010-02-17 16:37:39', 3),
(1, '2010-02-17 16:41:59', 3),
(1, '2010-02-17 16:46:25', 3),
(1, '2010-02-17 16:51:20', 3),
(1, '2010-02-17 16:55:28', 3),
(1, '2010-02-17 17:29:44', 3),
(1, '2010-02-17 17:33:54', 3),
(1, '2010-02-17 17:38:14', 3),
(1, '2010-02-18 22:41:34', 3),
(1, '2010-02-18 22:46:50', 3),
(1, '2010-02-18 22:51:08', 3),
(1, '2010-02-18 22:55:24', 3),
(1, '2010-02-23 09:13:03', 3),
(1, '2010-02-23 09:17:30', 3),
(1, '2010-02-23 09:21:38', 3),
(1, '2010-02-23 09:26:15', 3),
(1, '2010-02-23 09:30:22', 3),
(1, '2010-02-23 09:34:33', 3),
(1, '2010-02-23 09:38:42', 3),
(1, '2010-02-23 09:42:50', 3),
(1, '2010-02-23 09:47:03', 3),
(1, '2010-02-23 09:51:17', 3),
(1, '2010-02-23 09:55:29', 3),
(1, '2010-02-23 11:28:22', 3),
(1, '2010-02-23 11:32:40', 3),
(1, '2010-02-23 11:37:59', 3),
(1, '2010-02-23 11:42:26', 3),
(1, '2010-02-23 11:46:37', 3),
(1, '2010-02-23 11:50:46', 3),
(1, '2010-02-23 11:55:08', 3),
(1, '2010-02-23 11:59:18', 3),
(1, '2010-02-23 12:03:34', 3),
(1, '2010-02-23 12:07:42', 3),
(1, '2010-02-23 12:11:53', 3),
(1, '2010-02-23 12:16:00', 3),
(1, '2010-02-23 12:20:27', 3),
(1, '2010-02-23 12:24:36', 3),
(1, '2010-02-23 12:28:46', 3),
(1, '2010-02-23 12:32:54', 3),
(1, '2010-02-23 14:08:55', 3),
(1, '2010-02-23 17:00:03', 3),
(1, '2010-02-23 17:19:47', 3),
(1, '2010-02-23 17:24:03', 3),
(1, '2010-02-23 17:29:16', 3),
(1, '2010-02-23 17:33:27', 3),
(1, '2010-02-23 17:37:39', 3),
(1, '2010-02-23 17:41:59', 3),
(1, '2010-02-23 17:46:09', 3),
(1, '2010-02-23 17:50:23', 3),
(1, '2010-02-23 17:54:33', 3),
(1, '2010-02-23 18:02:57', 3),
(1, '2010-02-23 20:54:07', 3),
(1, '2010-02-23 20:58:27', 3),
(1, '2010-02-23 21:02:42', 3),
(1, '2010-02-23 21:06:50', 3),
(1, '2010-02-23 21:11:00', 3),
(1, '2010-02-23 21:15:17', 3),
(1, '2010-02-23 21:19:25', 3),
(1, '2010-02-23 21:23:34', 3),
(1, '2010-02-23 21:27:59', 3),
(1, '2010-02-23 21:32:11', 3),
(1, '2010-02-23 21:36:21', 3),
(1, '2010-02-23 21:40:37', 3),
(1, '2010-02-23 21:44:53', 3),
(1, '2010-02-23 21:49:16', 3),
(1, '2010-02-23 21:53:27', 3),
(1, '2010-02-23 21:57:45', 3),
(1, '2010-02-23 22:02:02', 3),
(1, '2010-02-24 15:45:20', 3),
(1, '2010-02-24 15:49:38', 3),
(1, '2010-02-24 15:53:44', 3),
(1, '2010-02-24 15:57:57', 3),
(1, '2010-02-24 16:02:02', 3),
(1, '2010-02-24 16:06:14', 3),
(1, '2010-02-24 16:10:26', 3),
(1, '2010-02-24 16:14:34', 3),
(1, '2010-02-24 16:18:41', 3),
(1, '2010-02-24 17:07:42', 3),
(1, '2010-02-24 17:11:56', 3),
(1, '2010-02-24 17:21:12', 3),
(1, '2010-02-24 17:25:20', 3),
(1, '2010-02-24 17:29:36', 3),
(1, '2010-02-24 17:33:48', 3),
(1, '2010-02-24 17:38:03', 3),
(1, '2010-02-24 17:42:14', 3),
(1, '2010-02-25 08:45:09', 3),
(1, '2010-02-25 08:50:18', 3),
(1, '2010-02-25 08:54:26', 3),
(1, '2010-02-25 09:14:18', 3),
(1, '2010-02-25 09:19:07', 3),
(1, '2010-02-25 09:23:18', 3),
(1, '2010-02-25 09:27:48', 3),
(1, '2010-02-25 09:31:59', 3),
(1, '2010-02-25 09:36:11', 3),
(1, '2010-02-25 09:40:18', 3),
(1, '2010-02-25 09:44:27', 3),
(1, '2010-02-25 09:48:35', 3),
(1, '2010-02-25 09:52:48', 3),
(1, '2010-02-25 09:56:57', 3),
(1, '2010-02-25 10:29:00', 3),
(1, '2010-02-25 10:36:31', 3),
(1, '2010-02-25 15:15:36', 3),
(1, '2010-02-25 15:19:48', 3),
(1, '2010-02-26 21:13:37', 3),
(1, '2010-02-26 21:18:01', 3),
(1, '2010-02-26 21:22:19', 3),
(1, '2010-02-26 21:26:29', 3),
(1, '2010-02-26 21:30:43', 3),
(1, '2010-03-01 17:50:56', 3),
(1, '2010-02-16 17:40:52', 4),
(1, '2010-02-17 11:14:55', 4),
(1, '2010-02-23 17:06:55', 4),
(1, '2010-02-23 23:05:23', 4),
(1, '2010-02-24 17:03:26', 4),
(1, '2010-02-25 08:40:53', 4),
(1, '2010-02-26 21:09:27', 4),
(1, '2010-03-01 17:46:37', 4);



INSERT INTO `askme_words` (`from`, `to`, `id_category`, `id_word`) VALUES
('cellar', 'cantina', 1, 1),
('attic', 'soffitta', 1, 2),
('curtain', 'tenda', 1, 3),
('carpet', 'tappeto', 1, 4),
('equipment', 'attrezzatura', 1, 5),
('instead', 'invece', 1, 6),
('put off', 'rimandare', 1, 7),
('attend', 'frequentare', 1, 8),
('warehouse', 'magazzino', 1, 9),
('complain', 'lamentarsi', 1, 10),
('polite', 'educato', 1, 11),
('impolite', 'maleducato', 1, 12),
('rude', 'scortese', 1, 13),
('tidy', 'ordinato', 1, 14),
('messy', 'disordinato', 1, 15),
('cleaning lady', 'donna delle pulizie', 1, 16),
('punctual', 'puntuale', 1, 17),
('late', 'tardi', 1, 18),
('employer', 'lavoratore', 1, 19),
('employed', 'impiegato', 1, 20),
('dead line', 'momento finale', 1, 21),
('strike', 'sciopero', 1, 22),
('bright', 'luminoso', 1, 23),
('airy', 'arieggiato', 1, 24),
('spacions', 'spazioso', 1, 25),
('refund', 'rimborso', 1, 26),
('worth', 'valore', 1, 27),
('equipment', 'attrezzatura', 1, 28),
('weak', 'debole', 1, 29),
('referee', 'arbitro', 1, 30),
('bat', 'mazza', 1, 31),
('motorway', 'strada principale', 1, 32),
('prediction', 'predizione', 1, 33),
('crowded', 'concentrato', 1, 34),
('commute', 'viaggio per andare a lavorare', 1, 35),
('engage', 'ingaggiare', 1, 36),
('even', 'anche', 1, 37),
('straightforward', 'semplice', 1, 38),
('burglar', 'ladro', 1, 39),
('nicked', 'intaccato', 1, 40),
('quid', 'sterlina', 1, 41),
('bunch', 'gruppo', 1, 42),
('ditch', 'fosso', 1, 43),
('nettles', 'ortica', 1, 44),
('nick', 'intaccare', 1, 45),
('pride', 'orgoglio', 1, 46),
('fart', 'scoreggiare', 1, 47),
('whiskers', 'baffi', 1, 48),
('reliable', 'attendibile', 1, 49),
('flood', 'alluvione', 1, 50),
('relief', 'soccorso', 1, 51),
('whatever', 'qualunque', 1, 52),
('grinza', 'wrinkle', 2, 54),
('patrol', 'pattuglia', 1, 55),
('purpose', 'obbiettivo', 1, 56),
('fire up', 'infiammare', 1, 57),
('treadmill', 'monotonia', 1, 58),
('proud', 'fiero', 1, 59),
('bear', 'sopportare', 1, 60),
('spit', 'sputare', 1, 61),
('aunt', 'zia', 1, 62),
('blame', 'colpa', 1, 63),
('plough', 'aratro', 1, 64),
('upset', 'sconvolgere', 1, 65),
('pollen', 'polline', 1, 66),
('further', 'ulteriore', 1, 67),
('lynx', 'lince', 1, 68),
('fellows', 'socio', 1, 69);

INSERT INTO `askme_questions` (`date`, `id_word`, `result`) VALUES
('2010-01-27 12:08:26', 10, 1),
('2010-01-27 12:09:39', 39, 2),
('2010-01-27 12:59:59', 51, 2),
('2010-01-27 13:02:27', 7, 2),
('2010-01-27 13:08:48', 49, 2),
('2010-01-27 13:13:18', 16, 1),
('2010-01-27 13:15:37', 39, 1),
('2010-01-27 13:17:09', 50, 2),
('2010-01-28 12:31:08', 32, 2),
('2010-01-28 12:32:50', 39, 1),
('2010-01-28 12:34:02', 41, 1),
('2010-01-28 12:36:57', 2, 1),
('2010-01-28 12:39:23', 49, 2),
('2010-01-28 12:40:33', 4, 1),
('2010-01-28 12:41:42', 38, 1),
('2010-01-28 12:42:56', 13, 2),
('2010-01-28 12:44:07', 37, 1),
('2010-01-28 12:45:21', 30, 2),
('2010-01-28 12:46:30', 33, 2),
('2010-01-28 12:47:39', 1, 1),
('2010-01-28 14:24:50', 22, 2),
('2010-01-28 14:26:21', 13, 2),
('2010-01-28 14:27:50', 21, 2),
('2010-01-28 14:29:10', 14, 2),
('2010-01-28 14:30:19', 51, 2),
('2010-01-28 14:31:47', 28, 2),
('2010-01-28 14:33:08', 35, 2),
('2010-01-28 14:34:22', 25, 1),
('2010-01-28 14:35:39', 33, 2),
('2010-01-28 14:36:57', 49, 2),
('2010-01-28 14:38:06', 1, 1),
('2010-01-28 14:39:37', 25, 1),
('2010-01-28 14:41:15', 51, 2),
('2010-01-28 15:53:06', 46, 1),
('2010-01-28 17:18:26', 11, 2),
('2010-01-28 17:59:21', 21, 2),
('2010-01-28 19:49:13', 11, 1),
('2010-01-28 19:51:47', 28, 1),
('2010-01-28 19:55:05', 13, 1),
('2010-01-28 19:56:19', 14, 2),
('2010-01-28 19:58:00', 8, 2),
('2010-01-29 09:10:11', 30, 1),
('2010-01-29 09:11:19', 42, 2),
('2010-01-29 09:12:26', 39, 1),
('2010-01-29 12:31:03', 54, 2),
('2010-01-29 12:32:16', 54, 2),
('2010-01-29 17:07:17', 49, 1),
('2010-01-29 17:08:38', 3, 2),
('2010-01-29 17:10:56', 49, 1),
('2010-01-29 17:12:03', 37, 1),
('2010-01-29 17:13:28', 25, 1),
('2010-01-29 17:14:33', 1, 1),
('2010-01-29 17:15:38', 4, 1),
('2010-01-29 17:16:44', 2, 1),
('2010-01-29 17:17:58', 48, 2),
('2010-01-29 17:19:06', 26, 2),
('2010-01-29 17:20:23', 34, 2),
('2010-01-29 17:21:28', 43, 1),
('2010-01-29 17:22:45', 49, 1),
('2010-01-29 17:23:59', 15, 2),
('2010-01-29 17:25:07', 13, 2),
('2010-01-29 17:26:15', 48, 1),
('2010-01-29 17:27:24', 24, 1),
('2010-01-29 17:28:32', 11, 1),
('2010-01-29 17:29:54', 35, 1),
('2010-01-29 17:35:55', 2, 1),
('2010-01-29 17:38:13', 24, 1),
('2010-01-29 17:44:28', 43, 1),
('2010-01-29 21:21:31', 33, 1),
('2010-01-29 21:23:25', 10, 2),
('2010-01-29 21:24:43', 49, 1),
('2010-01-29 21:26:05', 38, 1),
('2010-01-29 21:27:20', 31, 1),
('2010-01-29 21:28:28', 38, 1),
('2010-01-29 21:29:33', 25, 1),
('2010-01-29 21:30:49', 8, 2),
('2010-01-29 21:31:57', 18, 1),
('2010-01-29 21:33:03', 43, 1),
('2010-01-29 21:34:17', 3, 1),
('2010-01-29 21:35:26', 22, 2),
('2010-01-29 21:36:37', 45, 2),
('2010-01-29 21:37:43', 39, 1),
('2010-01-29 21:38:51', 34, 2),
('2010-01-29 21:40:35', 28, 1),
('2010-01-29 21:41:58', 54, 2),
('2010-01-29 21:43:17', 54, 2),
('2010-01-29 21:44:25', 54, 1),
('2010-01-29 21:45:35', 54, 1),
('2010-01-29 21:46:42', 43, 1),
('2010-01-29 21:47:49', 42, 2),
('2010-01-29 21:49:02', 49, 2),
('2010-01-29 21:50:23', 23, 1),
('2010-01-29 21:51:41', 24, 1),
('2010-01-30 17:41:03', 19, 2),
('2010-01-30 17:42:39', 40, 1),
('2010-01-30 17:46:44', 29, 1),
('2010-01-30 17:48:22', 52, 2),
('2010-01-30 17:49:28', 6, 1),
('2010-01-30 17:50:35', 9, 1),
('2010-01-30 17:51:47', 20, 1),
('2010-01-30 17:52:58', 5, 1),
('2010-01-30 17:54:09', 36, 2),
('2010-01-30 17:55:18', 44, 2),
('2010-01-30 17:56:28', 47, 1),
('2010-01-30 17:57:38', 27, 2),
('2010-01-30 17:59:05', 12, 2),
('2010-01-30 18:00:17', 54, 1),
('2010-01-30 18:01:26', 17, 1),
('2010-01-30 18:03:08', 35, 1),
('2010-01-30 18:04:28', 14, 2),
('2010-01-30 18:05:36', 22, 2),
('2010-01-30 18:06:44', 40, 1),
('2010-01-30 18:08:00', 36, 1),
('2010-01-30 18:09:08', 2, 1),
('2010-01-30 18:10:16', 51, 2),
('2010-01-30 18:11:24', 47, 1),
('2010-01-30 18:12:33', 22, 1),
('2010-01-30 18:16:18', 55, 1),
('2010-01-30 19:51:22', 1, 1),
('2010-01-30 19:52:33', 19, 1),
('2010-01-30 19:56:52', 9, 2),
('2010-01-31 14:10:01', 36, 1),
('2010-01-31 14:11:12', 27, 1),
('2010-01-31 14:12:36', 40, 1),
('2010-01-31 14:13:47', 48, 1),
('2010-01-31 14:14:58', 23, 1),
('2010-01-31 14:16:08', 44, 1),
('2010-01-31 14:17:19', 4, 1),
('2010-01-31 14:18:25', 39, 1),
('2010-01-31 14:19:45', 32, 2),
('2010-01-31 14:21:15', 26, 2),
('2010-01-31 14:22:38', 7, 2),
('2010-01-31 14:23:46', 17, 1),
('2010-02-01 08:49:47', 21, 2),
('2010-02-01 08:50:58', 51, 1),
('2010-02-01 08:52:58', 14, 1),
('2010-02-01 08:54:04', 3, 1),
('2010-02-01 08:55:17', 34, 2),
('2010-02-01 08:56:28', 46, 1),
('2010-02-01 08:58:03', 10, 2),
('2010-02-01 08:59:09', 3, 1),
('2010-02-01 09:00:17', 9, 1),
('2010-02-01 09:01:23', 41, 1),
('2010-02-01 09:04:37', 44, 1),
('2010-02-01 09:28:08', 56, 1),
('2010-02-01 09:29:22', 30, 1),
('2010-02-01 17:10:24', 57, 2),
('2010-02-01 17:55:48', 16, 2),
('2010-02-01 17:56:58', 22, 1),
('2010-02-01 22:15:46', 34, 2),
('2010-02-01 22:16:52', 17, 1),
('2010-02-03 17:33:49', 37, 5),
('2010-02-05 15:30:46', 48, 6),
('2010-02-05 15:32:14', 45, 5),
('2010-02-05 15:33:31', 6, 5),
('2010-02-05 15:34:42', 14, 6),
('2010-02-05 15:35:48', 9, 5),
('2010-02-05 15:36:55', 41, 5),
('2010-02-05 15:38:00', 2, 5),
('2010-02-05 15:39:14', 7, 6),
('2010-02-05 15:40:23', 5, 5),
('2010-02-05 15:42:31', 49, 6),
('2010-02-05 17:27:59', 7, 6),
('2010-02-05 17:29:11', 30, 6),
('2010-02-05 17:30:17', 55, 6),
('2010-02-05 17:32:04', 37, 6),
('2010-02-05 17:33:13', 19, 5),
('2010-02-06 16:11:08', 58, 1),
('2010-02-06 16:12:19', 15, 1),
('2010-02-06 16:13:26', 57, 2),
('2010-02-06 16:14:35', 36, 1),
('2010-02-06 16:15:45', 33, 1),
('2010-02-06 16:16:53', 44, 1),
('2010-02-06 16:18:01', 6, 5),
('2010-02-06 16:19:12', 44, 5),
('2010-02-06 16:20:18', 41, 5),
('2010-02-06 16:21:32', 30, 6),
('2010-02-06 16:22:42', 48, 6),
('2010-02-06 16:23:48', 44, 5),
('2010-02-06 16:25:05', 48, 6),
('2010-02-06 16:26:11', 37, 6),
('2010-02-06 16:27:21', 29, 5),
('2010-02-06 16:28:39', 5, 5),
('2010-02-06 16:29:49', 43, 5),
('2010-02-06 16:31:19', 51, 6),
('2010-02-06 16:32:28', 47, 6),
('2010-02-06 16:33:44', 13, 6),
('2010-02-06 16:34:52', 26, 6),
('2010-02-08 12:14:59', 23, 5),
('2010-02-08 12:16:08', 21, 5),
('2010-02-08 12:17:21', 51, 6),
('2010-02-08 12:18:32', 56, 6),
('2010-02-08 12:19:47', 58, 6),
('2010-02-08 12:21:44', 39, 5),
('2010-02-08 12:23:24', 48, 6),
('2010-02-08 12:24:43', 20, 5),
('2010-02-08 12:27:33', 10, 5),
('2010-02-08 12:28:39', 41, 5),
('2010-02-08 12:29:45', 35, 5),
('2010-02-08 12:31:01', 8, 6),
('2010-02-08 12:32:07', 5, 5),
('2010-02-08 12:33:13', 35, 5),
('2010-02-08 12:34:19', 15, 6),
('2010-02-08 12:36:55', 43, 5),
('2010-02-09 17:56:30', 20, 2),
('2010-02-09 17:57:35', 47, 1),
('2010-02-09 17:58:47', 14, 2),
('2010-02-09 17:59:53', 9, 1),
('2010-02-09 18:00:57', 4, 5),
('2010-02-09 18:02:06', 57, 5),
('2010-02-09 18:03:12', 12, 6),
('2010-02-10 09:15:32', 59, 1),
('2010-02-10 11:20:33', 39, 1),
('2010-02-10 11:26:46', 11, 1),
('2010-02-10 11:33:04', 58, 2),
('2010-02-10 11:42:35', 24, 1),
('2010-02-10 11:48:43', 33, 1),
('2010-02-10 16:03:42', 61, 1),
('2010-02-10 16:10:11', 60, 2),
('2010-02-10 16:16:32', 32, 1),
('2010-02-10 16:22:41', 33, 1),
('2010-02-10 16:28:50', 40, 1),
('2010-02-11 16:24:28', 10, 5),
('2010-02-12 17:38:43', 15, 1),
('2010-02-12 17:43:02', 7, 2),
('2010-02-12 17:44:18', 47, 1),
('2010-02-12 17:45:37', 9, 1),
('2010-02-15 15:47:59', 18, 2),
('2010-02-15 15:57:58', 13, 1),
('2010-02-15 16:23:02', 33, 1),
('2010-02-15 22:36:31', 2, 1),
('2010-02-15 22:43:23', 26, 1),
('2010-02-15 22:47:48', 49, 6),
('2010-02-15 22:51:56', 56, 6),
('2010-02-16 11:22:01', 17, 1),
('2010-02-16 11:26:27', 44, 2),
('2010-02-16 11:30:42', 41, 1),
('2010-02-16 11:35:04', 15, 1),
('2010-02-16 11:39:42', 17, 1),
('2010-02-16 11:44:00', 9, 1),
('2010-02-16 11:48:46', 8, 6),
('2010-02-16 11:53:05', 57, 5),
('2010-02-16 11:57:15', 42, 5),
('2010-02-16 12:01:47', 16, 5),
('2010-02-16 12:07:35', 21, 5),
('2010-02-16 12:12:12', 7, 6),
('2010-02-16 12:17:16', 61, 5),
('2010-02-16 12:21:50', 48, 6),
('2010-02-16 12:26:12', 16, 5),
('2010-02-16 12:30:35', 14, 5),
('2010-02-16 12:36:33', 36, 5),
('2010-02-16 12:41:10', 41, 5),
('2010-02-16 17:45:03', 62, 1),
('2010-02-16 17:49:16', 29, 1),
('2010-02-16 17:53:59', 35, 2),
('2010-02-16 17:58:12', 2, 1),
('2010-02-16 21:26:52', 43, 1),
('2010-02-16 21:31:13', 38, 5),
('2010-02-16 21:35:29', 32, 5),
('2010-02-16 21:39:43', 16, 5),
('2010-02-16 21:43:52', 2, 5),
('2010-02-16 21:48:20', 60, 6),
('2010-02-16 21:52:35', 17, 5),
('2010-02-16 21:56:50', 43, 5),
('2010-02-16 22:01:10', 38, 6),
('2010-02-16 22:05:27', 40, 5),
('2010-02-16 22:09:51', 25, 6),
('2010-02-16 22:14:03', 23, 5),
('2010-02-16 22:18:15', 60, 5),
('2010-02-16 22:22:26', 13, 5),
('2010-02-16 22:26:37', 41, 5),
('2010-02-16 22:30:46', 45, 5),
('2010-02-16 22:34:58', 17, 5),
('2010-02-16 22:39:11', 18, 5),
('2010-02-16 22:43:20', 22, 5),
('2010-02-16 22:47:44', 43, 5),
('2010-02-16 22:52:00', 30, 6),
('2010-02-16 22:56:08', 10, 5),
('2010-02-17 08:46:41', 3, 5),
('2010-02-17 08:50:52', 21, 5),
('2010-02-17 08:55:02', 47, 5),
('2010-02-17 08:59:14', 55, 5),
('2010-02-17 09:03:24', 21, 5),
('2010-02-17 09:07:36', 19, 5),
('2010-02-17 09:11:49', 9, 5),
('2010-02-17 09:15:58', 3, 5),
('2010-02-17 09:20:06', 18, 5),
('2010-02-17 09:24:18', 38, 5),
('2010-02-17 09:28:26', 60, 5),
('2010-02-17 09:32:39', 32, 5),
('2010-02-17 09:37:18', 12, 6),
('2010-02-17 09:41:28', 14, 5),
('2010-02-17 09:45:35', 43, 5),
('2010-02-17 09:49:46', 37, 5),
('2010-02-17 09:53:57', 19, 5),
('2010-02-17 10:00:47', 62, 5),
('2010-02-17 10:04:57', 19, 5),
('2010-02-17 10:09:06', 10, 5),
('2010-02-17 10:13:36', 48, 6),
('2010-02-17 10:17:49', 56, 6),
('2010-02-17 10:21:57', 23, 5),
('2010-02-17 10:26:08', 47, 5),
('2010-02-17 10:57:58', 3, 5),
('2010-02-17 11:02:29', 39, 6),
('2010-02-17 11:06:42', 24, 6),
('2010-02-17 11:10:58', 35, 5),
('2010-02-17 11:19:04', 63, 5),
('2010-02-17 11:23:25', 48, 6),
('2010-02-17 11:27:33', 46, 5),
('2010-02-17 11:31:47', 30, 6),
('2010-02-17 11:36:12', 48, 5),
('2010-02-17 11:40:21', 33, 1),
('2010-02-17 12:36:08', 17, 5),
('2010-02-17 15:52:45', 25, 6),
('2010-02-17 15:57:10', 25, 6),
('2010-02-17 16:01:23', 30, 5),
('2010-02-17 16:05:37', 59, 6),
('2010-02-17 16:29:13', 63, 5),
('2010-02-17 16:33:25', 30, 5),
('2010-02-17 16:37:39', 33, 5),
('2010-02-17 16:41:59', 33, 5),
('2010-02-17 16:46:25', 41, 5),
('2010-02-17 16:51:20', 12, 6),
('2010-02-17 16:55:28', 35, 5),
('2010-02-17 17:29:44', 24, 5),
('2010-02-17 17:33:54', 42, 5),
('2010-02-17 17:38:14', 4, 5),
('2010-02-18 22:41:34', 26, 5),
('2010-02-18 22:46:50', 6, 5),
('2010-02-18 22:51:08', 23, 5),
('2010-02-18 22:55:24', 24, 5),
('2010-02-23 09:13:03', 29, 5),
('2010-02-23 09:17:31', 34, 6),
('2010-02-23 09:21:38', 62, 5),
('2010-02-23 09:26:15', 31, 5),
('2010-02-23 09:30:22', 62, 5),
('2010-02-23 09:34:33', 43, 5),
('2010-02-23 09:38:42', 14, 5),
('2010-02-23 09:42:50', 41, 5),
('2010-02-23 09:47:04', 26, 5),
('2010-02-23 09:51:17', 4, 5),
('2010-02-23 09:55:29', 9, 5),
('2010-02-23 11:28:22', 52, 5),
('2010-02-23 11:32:40', 50, 5),
('2010-02-23 11:37:59', 52, 5),
('2010-02-23 11:42:26', 59, 6),
('2010-02-23 11:46:37', 50, 5),
('2010-02-23 11:50:46', 63, 5),
('2010-02-23 11:55:08', 31, 5),
('2010-02-23 11:59:18', 27, 5),
('2010-02-23 12:03:34', 61, 5),
('2010-02-23 12:07:42', 61, 5),
('2010-02-23 12:11:53', 50, 5),
('2010-02-23 12:16:00', 63, 5),
('2010-02-23 12:20:27', 28, 5),
('2010-02-23 12:24:36', 46, 5),
('2010-02-23 12:28:46', 45, 5),
('2010-02-23 12:32:54', 52, 5),
('2010-02-23 14:08:55', 31, 5),
('2010-02-23 17:00:03', 51, 6),
('2010-02-23 17:19:47', 64, 6),
('2010-02-23 17:24:03', 64, 5),
('2010-02-23 17:29:16', 64, 5),
('2010-02-23 17:33:27', 59, 5),
('2010-02-23 17:37:39', 55, 5),
('2010-02-23 17:41:59', 27, 5),
('2010-02-23 17:46:09', 20, 6),
('2010-02-23 17:50:24', 58, 6),
('2010-02-23 17:54:33', 64, 5),
('2010-02-23 18:02:57', 64, 5),
('2010-02-23 20:54:07', 60, 5),
('2010-02-23 20:58:27', 5, 5),
('2010-02-23 21:02:43', 27, 5),
('2010-02-23 21:06:50', 31, 5),
('2010-02-23 21:11:00', 63, 5),
('2010-02-23 21:15:17', 52, 5),
('2010-02-23 21:19:25', 62, 5),
('2010-02-23 21:23:34', 57, 5),
('2010-02-23 21:27:59', 6, 5),
('2010-02-23 21:32:11', 42, 5),
('2010-02-23 21:36:21', 12, 6),
('2010-02-23 21:40:37', 28, 5),
('2010-02-23 21:44:53', 50, 5),
('2010-02-23 21:49:16', 56, 6),
('2010-02-23 21:53:27', 1, 5),
('2010-02-23 21:57:46', 45, 5),
('2010-02-23 22:02:02', 18, 5),
('2010-02-24 15:45:20', 65, 6),
('2010-02-24 15:49:38', 65, 5),
('2010-02-24 15:53:44', 65, 5),
('2010-02-24 15:57:58', 65, 5),
('2010-02-24 16:02:02', 29, 5),
('2010-02-24 16:06:14', 20, 5),
('2010-02-24 16:10:27', 61, 5),
('2010-02-24 16:14:34', 46, 5),
('2010-02-24 16:18:42', 55, 5),
('2010-02-24 17:07:42', 66, 6),
('2010-02-24 17:11:56', 66, 6),
('2010-02-24 17:21:12', 66, 5),
('2010-02-24 17:25:20', 66, 5),
('2010-02-24 17:29:36', 11, 5),
('2010-02-24 17:33:48', 59, 5),
('2010-02-24 17:38:03', 58, 6),
('2010-02-24 17:42:14', 66, 5),
('2010-02-25 08:45:09', 67, 5),
('2010-02-25 08:50:18', 67, 5),
('2010-02-25 08:54:26', 67, 5),
('2010-02-25 09:14:18', 67, 5),
('2010-02-25 09:19:07', 8, 6),
('2010-02-25 09:23:18', 67, 5),
('2010-02-25 09:27:48', 65, 6),
('2010-02-25 09:31:59', 42, 5),
('2010-02-25 09:36:11', 60, 5),
('2010-02-25 09:40:18', 67, 5),
('2010-02-25 09:44:27', 36, 5),
('2010-02-25 09:48:35', 27, 5),
('2010-02-25 09:52:48', 52, 5),
('2010-02-25 09:56:57', 61, 5),
('2010-02-25 10:29:00', 65, 5),
('2010-02-25 10:36:31', 55, 5),
('2010-02-25 15:15:36', 46, 5),
('2010-02-25 15:19:48', 11, 5),
('2010-02-26 21:13:37', 68, 5),
('2010-02-26 21:18:01', 68, 6),
('2010-02-26 21:22:19', 68, 5),
('2010-02-26 21:26:29', 68, 5),
('2010-02-26 21:30:43', 68, 5),
('2010-03-01 17:50:56', 69, 6);


INSERT INTO `askme_settings` (`id_user`, `id_setting`, `numeric_value`, `text_value`) VALUES
(1, 1, 240, NULL),
(1, 2, 1, NULL),
(1, 3, 1, NULL),
(1, 4, 1, NULL);


INSERT INTO `askme_type_log` (`id_log`, `desc`) VALUES
(1, 'Login'),
(2, 'Word asked'),
(3, 'Got answer'),
(4, 'Add word'),
(5, 'Word asked'),
(6, 'Add word failed');


