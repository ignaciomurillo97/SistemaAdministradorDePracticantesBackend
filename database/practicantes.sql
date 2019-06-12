-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-06-2019 a las 20:31:53
-- Versión del servidor: 10.1.35-MariaDB
-- Versión de PHP: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `practicantes`
--
CREATE DATABASE IF NOT EXISTS `practicantes` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `practicantes`;

--
-- Volcado de datos para la tabla `companies`
--

delete from coordinators where person_id < 27;
delete from people where id < 27;
delete from users where person_id < 27;
delete from students where person_id < 27;
delete from companies where person_id < 27;

INSERT INTO `companies` (`name`, `legal_id`, `address`, `person_id`, `created_at`, `updated_at`) VALUES
('HPE (Hewlett Packard Enterprise)', 1, '', 13, '2019-06-11 18:27:33', '2019-06-11 18:27:33'),
('Mobilize. NET', 2, '', 14, '2019-06-11 18:27:33', '2019-06-11 18:27:33'),
('Grupo Asesor', 3, '', 15, '2019-06-11 18:27:33', '2019-06-11 18:27:33'),
('ESD Consultores', 4, '', 16, '2019-06-11 18:27:33', '2019-06-11 18:27:33'),
('Possible', 5, '', 17, '2019-06-11 18:27:33', '2019-06-11 18:27:33'),
('Mobilize', 6, '', 18, '2019-06-11 18:27:33', '2019-06-11 18:27:33'),
('FairPlay Labs', 7, '', 19, '2019-06-11 18:27:33', '2019-06-11 18:27:33'),
('Mobilize.Net', 8, '', 20, '2019-06-11 18:27:33', '2019-06-11 18:27:33'),
('MKonrad Group', 9, '', 21, '2019-06-11 18:27:33', '2019-06-11 18:27:33'),
('Desarrollo Interactivo TRI S.A. (Tree Interactive)', 10, '', 22, '2019-06-11 18:27:33', '2019-06-11 18:27:33');

--
-- Volcado de datos para la tabla `people`
--

INSERT INTO `people` (`id`, `name`, `lastName`, `secondLastName`, `gender_id`, `created_at`, `updated_at`, `telephone`, `birthday`) VALUES
(0, 'Ruth', 'Ulloa', '', 2, '2019-06-11 18:19:58', '2019-06-11 18:19:58', 86068714, '1996-05-05'),
(1, 'Bryan', 'Jiménez', 'Chacón', 1, '2019-06-11 18:19:58', '2019-06-11 18:19:58', 71141512, '1996-05-05'),
(2, 'Jason', 'Barrantes', 'Arce', 1, '2019-06-11 18:19:58', '2019-06-11 18:19:58', 84675951, '1996-05-05'),
(3, 'Manrique', 'Durán', 'Vásquez', 1, '2019-06-11 18:19:58', '2019-06-11 18:19:58', 87010867, '1996-05-05'),
(4, 'Randy', 'Morales', '', 1, '2019-06-11 18:19:58', '2019-06-11 18:19:58', 89091222, '1996-05-05'),
(5, 'Melissa', 'Molina', '', 2, '2019-06-11 18:19:58', '2019-06-11 18:19:58', 83410868, '1996-05-05'),
(6, 'Roy', 'Barnes', 'Pérez', 1, '2019-06-11 18:19:58', '2019-06-11 18:19:58', 86615243, '1996-05-05'),
(7, 'Edwin', 'Cen', '', 1, '2019-06-11 18:19:58', '2019-06-11 18:19:58', 70694714, '1996-05-05'),
(8, 'Steven', 'Bonilla', '', 1, '2019-06-11 18:19:58', '2019-06-11 18:19:58', 88377518, '1996-05-05'),
(9, 'Jorge', 'Gonzáles', 'Rodríguez', 1, '2019-06-11 18:19:58', '2019-06-11 18:19:58', 88845209, '1996-05-05'),
(10, 'Carlos', 'Villalobos', '', 1, '2019-06-11 18:19:58', '2019-06-11 18:19:58', 83892153, '1996-05-05'),
(11, 'Issac', 'Campos', '', 1, '2019-06-11 18:19:58', '2019-06-11 18:19:58', 62869347, '1996-05-05'),
(12, 'Jeffrey', 'Alvarado', '', 1, '2019-06-11 18:19:58', '2019-06-11 18:19:58', 86959260, '1996-05-05'),
(13, 'Leonidas', 'Arburola', '', 1, '2019-06-11 18:19:58', '2019-06-11 18:19:58', 0, '1996-05-05'),
(14, 'William', 'Quesada', '', 1, '2019-06-11 18:19:58', '2019-06-11 18:19:58', 0, '1996-05-05'),
(15, 'Cecilia', 'Boza', 'Mendoza', 2, '2019-06-11 18:19:58', '2019-06-11 18:19:58', 0, '1996-05-05'),
(16, 'Francisco', 'Arias', '', 1, '2019-06-11 18:19:58', '2019-06-11 18:19:58', 0, '1996-05-05'),
(17, 'Diego', 'Loaiza', 'Julio del Valle', 1, '2019-06-11 18:19:58', '2019-06-11 18:19:58', 22890606, '1996-05-05'),
(18, 'Carolina', 'Madrigal', '', 2, '2019-06-11 18:19:58', '2019-06-11 18:19:58', 40001630, '1996-05-05'),
(19, 'Claudio', 'Pinto', '', 1, '2019-06-11 18:19:58', '2019-06-11 18:19:58', 22261250, '1996-05-05'),
(20, 'Carlos', 'Bastos', '', 1, '2019-06-11 18:19:58', '2019-06-11 18:19:58', 0, '1996-05-05'),
(21, 'Damaris', 'Cáceres', '', 2, '2019-06-11 18:19:58', '2019-06-11 18:19:58', 0, '1996-05-05'),
(22, 'Alberto', 'Cartín', 'Arteaga', 1, '2019-06-11 18:19:58', '2019-06-11 18:19:58', 85270000, '1996-05-05'),
(23, 'Luis', 'Montoya', '', 1, '2019-06-11 18:19:58', '2019-06-11 18:19:58', 88424750, '1996-05-05'),
(24, 'Jose', 'Castro', '', 1, '2019-06-11 18:19:58', '2019-06-11 18:19:58', 60431335, '1996-05-05'),
(25, 'Eduardo', 'Canessa', '', 1, '2019-06-11 18:19:58', '2019-06-11 18:19:58', 83958348, '1996-05-05'),
(26, 'Adriana', 'Álvares', 'Figueroa', 1, '2019-06-11 18:19:58', '2019-06-11 18:19:58', 89950596, '1996-05-05');

--
-- Volcado de datos para la tabla `students`
--

INSERT INTO `students` (`id`, `person_id`, `career_id`, `site_id`, `professorAssigned`, `status`, `semester_id`, `created_at`, `updated_at`, `image`) VALUES
(2013006074, 5, 1, 1, 23, 'Aprobado', 1, '2019-06-11 18:24:39', '2019-06-11 18:24:39', '/image/tmp.jpg'),
(2014004626, 11, 1, 1, 23, 'Aprobado', 1, '2019-06-11 18:24:39', '2019-06-11 18:24:39', '/image/tmp.jpg'),
(2014055617, 7, 1, 1, 23, 'Aprobado', 1, '2019-06-11 18:24:39', '2019-06-11 18:24:39', '/image/tmp.jpg'),
(2014082532, 10, 1, 1, 26, 'Aprobado', 1, '2019-06-11 18:24:39', '2019-06-11 18:24:39', '/image/tmp.jpg'),
(2014083794, 6, 1, 1, 25, 'Aprobado', 1, '2019-06-11 18:24:39', '2019-06-11 18:24:39', '/image/tmp.jpg'),
(2014114175, 1, 1, 1, 24, 'Aprobado', 1, '2019-06-11 18:24:39', '2019-06-11 18:24:39', '/image/tmp.jpg'),
(2014120210, 12, 1, 1, 26, 'Aprobado', 1, '2019-06-11 18:24:39', '2019-06-11 18:24:39', '/image/tmp.jpg'),
(2015048456, 2, 1, 1, 24, 'Aprobado', 1, '2019-06-11 18:24:39', '2019-06-11 18:24:39', '/image/tmp.jpg'),
(2015056296, 8, 1, 1, 24, 'Aprobado', 1, '2019-06-11 18:24:39', '2019-06-11 18:24:39', '/image/tmp.jpg'),
(2015083567, 9, 1, 1, 25, 'Aprobado', 1, '2019-06-11 18:24:39', '2019-06-11 18:24:39', '/image/tmp.jpg'),
(2015085446, 4, 1, 1, 23, 'Aprobado', 1, '2019-06-11 18:24:39', '2019-06-11 18:24:39', '/image/tmp.jpg'),
(2015130790, 3, 1, 1, 23, 'Aprobado', 1, '2019-06-11 18:24:39', '2019-06-11 18:24:39', '/image/tmp.jpg'),
(2015145716, 0, 1, 1, 23, 'Aprobado', 1, '2019-06-11 18:24:39', '2019-06-11 18:24:39', '/image/tmp.jpg');

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`email`, `password`, `person_id`, `scope_id`, `remember_token`, `created_at`, `updated_at`) VALUES
('ruthmub06@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 0, 3, NULL, '2019-06-11 18:20:17', '2019-06-11 18:20:17'),
('bsjc96@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, 3, NULL, '2019-06-11 18:20:17', '2019-06-11 18:20:17'),
('starclip3297@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2, 3, NULL, '2019-06-11 18:20:17', '2019-06-11 18:20:17'),
('manriquedv@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 3, 3, NULL, '2019-06-11 18:20:17', '2019-06-11 18:20:17'),
('randymoralesg@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 4, 3, NULL, '2019-06-11 18:20:17', '2019-06-11 18:20:17'),
('melimolinacorrales@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 5, 3, NULL, '2019-06-11 18:20:17', '2019-06-11 18:20:17'),
('rebp96@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 6, 3, NULL, '2019-06-11 18:20:17', '2019-06-11 18:20:17'),
('edwincx15@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 7, 3, NULL, '2019-06-11 18:20:17', '2019-06-11 18:20:17'),
('stbz1996@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 8, 3, NULL, '2019-06-11 18:20:17', '2019-06-11 18:20:17'),
('jorgegr1707@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 9, 3, NULL, '2019-06-11 18:20:17', '2019-06-11 18:20:17'),
('charlie.tec.vm@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 10, 3, NULL, '2019-06-11 18:20:17', '2019-06-11 18:20:17'),
('kakoo26i@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 11, 3, NULL, '2019-06-11 18:20:17', '2019-06-11 18:20:17'),
('jefalva10296@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 12, 3, NULL, '2019-06-11 18:20:17', '2019-06-11 18:20:17'),
('larburola@hpe.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 13, 4, NULL, '2019-06-11 18:20:17', '2019-06-11 18:20:17'),
('william.quesada@mobilize.net', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 14, 4, NULL, '2019-06-11 18:20:17', '2019-06-11 18:20:17'),
('cboza@grupoasesor.net', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 15, 4, NULL, '2019-06-11 18:20:17', '2019-06-11 18:20:17'),
('farias@esdconsultores.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 16, 4, NULL, '2019-06-11 18:20:17', '2019-06-11 18:20:17'),
('diego.loaiza@possible.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 17, 4, NULL, '2019-06-11 18:20:17', '2019-06-11 18:20:17'),
('cmadrigal@mobilize.net', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 18, 4, NULL, '2019-06-11 18:20:17', '2019-06-11 18:20:17'),
('claudio.pinto@fairplaylabs.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 19, 4, NULL, '2019-06-11 18:20:17', '2019-06-11 18:20:17'),
('Carlos.Bastos@mobilize.net', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 20, 4, NULL, '2019-06-11 18:20:17', '2019-06-11 18:20:17'),
('dcaceres@konradgroup.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 21, 4, NULL, '2019-06-11 18:20:17', '2019-06-11 18:20:17'),
('alberto@treeinteractivecr.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 22, 4, NULL, '2019-06-11 18:20:17', '2019-06-11 18:20:17'),
('lmontoya@itcr.ac.cr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 23, 5, NULL, '2019-06-11 18:20:17', '2019-06-11 18:20:17'),
('jose.r.castro@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 24, 5, NULL, '2019-06-11 18:20:17', '2019-06-11 18:20:17'),
('edcanessa@itcr.ac.cr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 25, 5, NULL, '2019-06-11 18:20:17', '2019-06-11 18:20:17'),
('adriana.alvarezf@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 26, 5, NULL, '2019-06-11 18:20:17', '2019-06-11 18:20:17');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
