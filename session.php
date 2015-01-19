<?php
session_start();

function is_login()
{
    return (isset($_SESSION['login']) && $_SESSION['login'] == true);
}

function is_admin()
{
    return ($_SESSION['username'] == 'admin');
}

function redirect($url = '../index.php')
{
    header('Location:'.$url);
    die();
}