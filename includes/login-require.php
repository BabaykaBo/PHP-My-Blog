<?php 
if (!Auth::isLoggedIn()) {
    Url::redirect('/login.php');
}