-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 06-10-2023 a las 23:58:05
-- Versión del servidor: 8.0.31
-- Versión de PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `id21358205_controlescolar`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logs_pm`
--

DROP TABLE IF EXISTS `logs_pm`;
CREATE TABLE IF NOT EXISTS `logs_pm` (
  `id_Log` int NOT NULL AUTO_INCREMENT,
  `descrip_Log` varchar(250) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `user_action_Log` int NOT NULL,
  `date_create_Log` datetime NOT NULL,
  `instruccion_Log` longtext COLLATE utf8mb4_spanish2_ci NOT NULL,
  PRIMARY KEY (`id_Log`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modules_pm`
--

DROP TABLE IF EXISTS `modules_pm`;
CREATE TABLE IF NOT EXISTS `modules_pm` (
  `id_Module` int NOT NULL AUTO_INCREMENT,
  `name_Module` varchar(255) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `status_Module` int DEFAULT NULL,
  `icon_Module` varchar(50) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `menu_Module` int DEFAULT NULL,
  `is_submenu_Module` tinyint(1) NOT NULL DEFAULT '0',
  `link_Module` varchar(50) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `date_start_Module` datetime NOT NULL,
  `date_edit_Module` datetime DEFAULT NULL,
  `user_start_Module` varchar(50) COLLATE utf8mb3_spanish_ci NOT NULL,
  `user_edit_Module` int NOT NULL,
  PRIMARY KEY (`id_Module`),
  KEY `fk_modules_user` (`user_start_Module`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `modules_pm`
--

INSERT INTO `modules_pm` (`id_Module`, `name_Module`, `status_Module`, `icon_Module`, `menu_Module`, `is_submenu_Module`, `link_Module`, `date_start_Module`, `date_edit_Module`, `user_start_Module`, `user_edit_Module`) VALUES
(1, 'Alta de Alumnos', 1, 'group_add', 0, 1, '', '2023-09-29 15:17:40', NULL, '1', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permission_pm`
--

DROP TABLE IF EXISTS `permission_pm`;
CREATE TABLE IF NOT EXISTS `permission_pm` (
  `id_Permission` int NOT NULL AUTO_INCREMENT,
  `usr_id_User` int DEFAULT NULL,
  `module_Permission` int DEFAULT NULL,
  `action_Permission` varchar(50) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `permits_Permission` tinyint(1) DEFAULT NULL,
  `date_start_Permission` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `date_edit_Permission` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_Permission`),
  KEY `usr_id_User` (`usr_id_User`),
  KEY `fk_permission_modules` (`module_Permission`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `permission_pm`
--

INSERT INTO `permission_pm` (`id_Permission`, `usr_id_User`, `module_Permission`, `action_Permission`, `permits_Permission`, `date_start_Permission`, `date_edit_Permission`) VALUES
(1, 1, 1, 'All', 1, '2023-09-30 04:58:35', '2023-09-30 04:58:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_pm`
--

DROP TABLE IF EXISTS `role_pm`;
CREATE TABLE IF NOT EXISTS `role_pm` (
  `id_Role` int NOT NULL AUTO_INCREMENT,
  `description_Role` varchar(255) COLLATE utf8mb3_spanish_ci NOT NULL,
  `status_Role` int NOT NULL,
  `start_date_Role` datetime NOT NULL,
  `date_edition_Role` datetime NOT NULL,
  `usr_start_Role` int DEFAULT NULL,
  `usr_edit_Role` int DEFAULT NULL,
  PRIMARY KEY (`id_Role`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `role_pm`
--

INSERT INTO `role_pm` (`id_Role`, `description_Role`, `status_Role`, `start_date_Role`, `date_edition_Role`, `usr_start_Role`, `usr_edit_Role`) VALUES
(1, 'Administrador del Sistema', 1, '2023-09-29 13:51:42', '0000-00-00 00:00:00', 1, NULL),
(2, 'Director Escolar', 1, '2023-09-29 13:54:01', '0000-00-00 00:00:00', 1, NULL),
(3, 'Director Académico', 1, '2023-09-29 13:54:01', '0000-00-00 00:00:00', 1, NULL),
(4, 'Docente o Profesor', 1, '2023-09-29 13:54:01', '0000-00-00 00:00:00', 1, NULL),
(5, 'Estudiante', 1, '2023-09-29 13:54:01', '0000-00-00 00:00:00', 1, NULL),
(6, 'Padre o Tutor', 1, '2023-09-29 13:54:01', '0000-00-00 00:00:00', 1, NULL),
(7, 'Personal Administrativo', 1, '2023-09-29 13:54:01', '0000-00-00 00:00:00', 1, NULL),
(8, 'Consejero Escolar', 1, '2023-09-29 13:54:01', '0000-00-00 00:00:00', 1, NULL),
(9, 'Bibliotecario', 1, '2023-09-29 13:54:01', '0000-00-00 00:00:00', 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `students_pm`
--

DROP TABLE IF EXISTS `students_pm`;
CREATE TABLE IF NOT EXISTS `students_pm` (
  `id_Students` int NOT NULL AUTO_INCREMENT,
  `name_Student` varchar(50) COLLATE utf8mb3_spanish_ci NOT NULL,
  `paternal_surname_Student` varchar(50) COLLATE utf8mb3_spanish_ci NOT NULL,
  `mother_surname_Student` varchar(50) COLLATE utf8mb3_spanish_ci NOT NULL,
  `curp_Student` varchar(18) COLLATE utf8mb3_spanish_ci NOT NULL,
  `sex_Student` varchar(25) COLLATE utf8mb3_spanish_ci NOT NULL,
  `birth_date_Student` date DEFAULT NULL,
  `adress_Student` varchar(100) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `phone_Student` varchar(15) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `email_Student` varchar(100) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `status_Student` int NOT NULL,
  `date_create_Student` datetime NOT NULL,
  `user_create_Student` int NOT NULL,
  `date_edit_Student` datetime DEFAULT NULL,
  `user_edit_Student` int DEFAULT NULL,
  PRIMARY KEY (`id_Students`),
  UNIQUE KEY `email_Student` (`email_Student`),
  KEY `fk_student_users` (`user_create_Student`),
  KEY `fk_student_user_edit` (`user_edit_Student`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `students_pm`
--

INSERT INTO `students_pm` (`id_Students`, `name_Student`, `paternal_surname_Student`, `mother_surname_Student`, `curp_Student`, `sex_Student`, `birth_date_Student`, `adress_Student`, `phone_Student`, `email_Student`, `status_Student`, `date_create_Student`, `user_create_Student`, `date_edit_Student`, `user_edit_Student`) VALUES
(1, 'ANA PAULA', 'ROJAS', 'SANTIAGO', 'ROSA080719MMCJNNA7', 'FEMENINO', NULL, NULL, NULL, NULL, 1, '2023-10-06 17:49:31', 2, NULL, NULL),
(2, 'ALBERTO', 'MEJIA', 'ORTEGA', 'MEOA080810HMCJRLA2', 'MASCULINO', NULL, NULL, NULL, NULL, 1, '2023-10-06 17:54:14', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `student_certificates_pm`
--

DROP TABLE IF EXISTS `student_certificates_pm`;
CREATE TABLE IF NOT EXISTS `student_certificates_pm` (
  `id_Certificates` int NOT NULL AUTO_INCREMENT,
  `autoridad_certificado_Certificates` varchar(250) COLLATE utf8mb3_spanish_ci NOT NULL,
  `ciclo_escolar_Certificates` varchar(20) COLLATE utf8mb3_spanish_ci NOT NULL,
  `nivel_educativo_Certificates` varchar(250) COLLATE utf8mb3_spanish_ci NOT NULL,
  `id_Student_Certificates` int DEFAULT NULL,
  `cct_Certificates` varchar(20) COLLATE utf8mb3_spanish_ci NOT NULL,
  `turno_Certificates` varchar(20) COLLATE utf8mb3_spanish_ci NOT NULL,
  `promedio_final_Certificates` varchar(5) COLLATE utf8mb3_spanish_ci NOT NULL,
  `nombre_escuela_Certificates` varchar(250) COLLATE utf8mb3_spanish_ci NOT NULL,
  `domicilio_Certificates` varchar(250) COLLATE utf8mb3_spanish_ci NOT NULL,
  `municipio_Certificates` varchar(250) COLLATE utf8mb3_spanish_ci NOT NULL,
  `localidad_Certificates` varchar(250) COLLATE utf8mb3_spanish_ci NOT NULL,
  `numero_folio_Certificates` varchar(250) COLLATE utf8mb3_spanish_ci NOT NULL,
  `numero_certificado_Certificates` varchar(250) COLLATE utf8mb3_spanish_ci NOT NULL,
  PRIMARY KEY (`id_Certificates`),
  KEY `fk_student_certificate` (`id_Student_Certificates`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `student_certificates_pm`
--

INSERT INTO `student_certificates_pm` (`id_Certificates`, `autoridad_certificado_Certificates`, `ciclo_escolar_Certificates`, `nivel_educativo_Certificates`, `id_Student_Certificates`, `cct_Certificates`, `turno_Certificates`, `promedio_final_Certificates`, `nombre_escuela_Certificates`, `domicilio_Certificates`, `municipio_Certificates`, `localidad_Certificates`, `numero_folio_Certificates`, `numero_certificado_Certificates`) VALUES
(1, 'SECRETARÍA DE EDUCACIÓN DEL ESTADO DE MÉXICO', '2022-2023', 'SECUNDARIA', 1, '15EES1161K', 'VESPERTINO', '9.5', 'OFIC NO 0587 \"EMILIANO ZAPATA\"', 'SUR 6 ESQUINA PONIENTE 16 S/N', 'VALLE DE CHALCO SOLIDARIDAD', 'XICO', '', 'bc0f424b-7756-49f0-adf3-19852485f003'),
(2, 'SECRETARÍA DE EDUCACIÓN DEL ESTADO DE MÉXICO', '2022-2023', 'SECUNDARIA', 2, '15EES1161K', 'VESPERTINO', '8.5', 'OFIC NO 0587 \"EMILIANO ZAPATA\"', 'SUR 6 ESQUINA PONIENTE 16 S/N', 'VALLE DE CHALCO SOLIDARIDAD', 'XICO', '', 'e1745450-3bac-4e32-85c3-99970b91fa72');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_pm`
--

DROP TABLE IF EXISTS `users_pm`;
CREATE TABLE IF NOT EXISTS `users_pm` (
  `id_User` int NOT NULL AUTO_INCREMENT,
  `name_User` varchar(250) COLLATE utf8mb3_spanish_ci NOT NULL,
  `last_name_User` varchar(250) COLLATE utf8mb3_spanish_ci NOT NULL,
  `email_User` varchar(250) COLLATE utf8mb3_spanish_ci NOT NULL,
  `usr_User` varchar(100) COLLATE utf8mb3_spanish_ci NOT NULL,
  `psw_User` varchar(100) COLLATE utf8mb3_spanish_ci NOT NULL,
  `phone_User` varchar(15) COLLATE utf8mb3_spanish_ci NOT NULL,
  `status_User` int NOT NULL,
  `img_User` varchar(100) COLLATE utf8mb3_spanish_ci NOT NULL,
  `role_User` int NOT NULL,
  `create_date_User` datetime NOT NULL,
  `position_User` int NOT NULL,
  PRIMARY KEY (`id_User`),
  KEY `fk_users_rol_pm` (`role_User`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `users_pm`
--

INSERT INTO `users_pm` (`id_User`, `name_User`, `last_name_User`, `email_User`, `usr_User`, `psw_User`, `phone_User`, `status_User`, `img_User`, `role_User`, `create_date_User`, `position_User`) VALUES
(1, 'Daniel', 'Romero', 'danielrg841@gmail.com', 'drg22', 'mypass', '', 1, 'default.jpg', 1, '2023-09-29 13:56:28', 0),
(2, 'Irene', 'Mejia', '', 'IreneMejia', 'unidadeducativa', '', 1, 'default.png', 2, '2023-10-03 15:27:42', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
