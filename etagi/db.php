<?php
// Подключаем библиотеку RedBeanPHP
require "libs/rb-mysql.php";

// Подключаемся к БД
R::setup( 'mysql:host=eu-cdbr-west-03.cleardb.net;dbname=heroku_8bcc022f59a9e52', 'b55848166756f5', '016d3c67' );
// Проверка подключения к БД
if(!R::testConnection()) die('No DB connection!');
session_start(); //Создаем сессию для авторизации
?>