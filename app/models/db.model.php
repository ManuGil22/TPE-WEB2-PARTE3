<?php
    require_once "config.php";
    class dbModel {
        protected $db;

        function __construct() {
            $this->db = new PDO('mysql:host=' . MYSQL_HOST . ';dbname=' . MYSQL_DB . ';charset=utf8', MYSQL_USER, MYSQL_PASS);
            $this->deploy();
        }

        function deploy() {
            $query = $this->db->query('SHOW TABLES');
            $tables = $query->fetchAll();
            if (count($tables) == 0) {
                $sql = <<<END
                CREATE DATABASE IF NOT EXISTS `red_social_de_viajeros`;
                USE `red_social_de_viajeros`;

                -- phpMyAdmin SQL Dump
                -- version 5.2.1
                -- https://www.phpmyadmin.net/
                --
                -- Host: 127.0.0.1
                -- Generation Time: Oct 11, 2024 at 01:12 AM
                -- Server version: 10.4.32-MariaDB
                -- PHP Version: 8.2.12

                SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
                START TRANSACTION;
                SET time_zone = "+00:00";


                /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
                /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
                /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
                /*!40101 SET NAMES utf8mb4 */;

                --
                -- Database: `red_social_de_viajeros`
                --

                -- --------------------------------------------------------

                --
                -- Table structure for table `acceso_usuarios`
                --

                CREATE TABLE `acceso_usuarios` (
                `id` int(11) NOT NULL,
                `username` varchar(100) NOT NULL,
                `password` varchar(100) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

                --
                -- Dumping data for table `acceso_usuarios`
                --

                INSERT INTO `acceso_usuarios` (`id`, `username`, `password`) VALUES
                (1, 'webadmin', '$2y$10$9fqd5sor8VXPj/yqdXyJWuJQqhETtzcvld.7VPX8D8QUwbTFpVeoa'),
                (2, 'manuel', '$2y$10$vqhwtO6uauEBhv68iTyLuOTMeGVJY1PwOtd8zbPvQuxa0ean8yriS'),
                (13, 'webadmin2', '$2y$10$cvTE7KKDukKPOI0HUuLUtujgkbTYwnrWKtSgAcIRuId6PqH4WhJgy');

                -- --------------------------------------------------------

                --
                -- Table structure for table `usuarios`
                --

                CREATE TABLE `usuarios` (
                `id` int(11) NOT NULL,
                `nombre` varchar(50) NOT NULL,
                `apellido` varchar(50) NOT NULL,
                `correo` varchar(100) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

                --
                -- Dumping data for table `usuarios`
                --

                INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `correo`) VALUES
                (1, 'facundo', 'alejo', 'alejo_facundo@yahoo.com'),
                (2, 'elcapiode', 'tremendo', 'elmaspichula@gmail.com'),
                (3, 'Sofía', 'Martínez', 'sofia_martinez@gmail.com'),
                (4, 'Juan', 'Pérez', 'juan_perez@hotmail.com'),
                (5, 'Laura', 'Gómez', 'laura_gomez@yahoo.com');

                -- --------------------------------------------------------

                --
                -- Table structure for table `viajes`
                --

                CREATE TABLE `viajes` (
                `id` int(11) NOT NULL,
                `pais` varchar(100) NOT NULL,
                `pais_destino` varchar(100) NOT NULL,
                `ciudad` varchar(100) NOT NULL,
                `ciudad_destino` varchar(100) NOT NULL,
                `fecha_ini` date NOT NULL,
                `fecha_fin` date NOT NULL,
                `user_id` int(11) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

                --
                -- Dumping data for table `viajes`
                --

                INSERT INTO `viajes` (`id`, `pais`, `pais_destino`, `ciudad`, `ciudad_destino`, `fecha_ini`, `fecha_fin`, `user_id`) VALUES
                (2, 'Francia', 'Argentina', 'París', 'Buenos Aires', '2024-10-01', '2024-10-05', 1),
                (3, 'España', 'España', 'Madrid', 'Barcelona', '2024-11-15', '2024-11-20', 2),
                (4, 'Italia', 'Alemania', 'Roma', 'Berlin', '2024-08-22', '2024-08-26', 1),
                (5, 'Brasil', 'Argentina', 'Río de Janeiro', 'Cordoba', '2024-12-05', '2024-12-10', 2),
                (6, 'Japón', 'Grecia', 'Tokio', 'Atenas', '2024-09-12', '2024-09-20', 1),
                (8, 'Argentina', 'Chile', 'Buenos Aires', 'Santiago', '0000-00-00', '0000-00-00', 4);

                --
                -- Indexes for dumped tables
                --

                --
                -- Indexes for table `acceso_usuarios`
                --
                ALTER TABLE `acceso_usuarios`
                ADD PRIMARY KEY (`id`),
                ADD UNIQUE KEY `username` (`username`);

                --
                -- Indexes for table `usuarios`
                --
                ALTER TABLE `usuarios`
                ADD PRIMARY KEY (`id`);

                --
                -- Indexes for table `viajes`
                --
                ALTER TABLE `viajes`
                ADD PRIMARY KEY (`id`),
                ADD KEY `user_id` (`user_id`);

                --
                -- AUTO_INCREMENT for dumped tables
                --

                --
                -- AUTO_INCREMENT for table `acceso_usuarios`
                --
                ALTER TABLE `acceso_usuarios`
                MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

                --
                -- AUTO_INCREMENT for table `usuarios`
                --
                ALTER TABLE `usuarios`
                MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

                --
                -- AUTO_INCREMENT for table `viajes`
                --
                ALTER TABLE `viajes`
                MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

                --
                -- Constraints for dumped tables
                --

                --
                -- Constraints for table `viajes`
                --
                ALTER TABLE `viajes`
                ADD CONSTRAINT `viajes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`);
                COMMIT;

                /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
                /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
                /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
                END;
                $this->db->query($sql);
            }
        }
}