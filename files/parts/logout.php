<?php
session_start();
unset($_SESSION['login']);
unset($_SESSION['Nombre']);
unset($_SESSION['Apellidos']);
unset($_SESSION['Departamento']);
unset($_SESSION['Categoria']);
session_destroy();
header('Location: inicio');
