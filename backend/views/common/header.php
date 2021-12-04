<?php

use yii\helpers\Html;
use yii\helpers\Url;

$user = Yii::$app->user->identity;

?>

<header class="main-header">
    <!-- Logo -->
    <a href="<?=Yii::$app->homeUrl ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>T</b>T</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">Admin</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

        </ul>
      </div>
    </nav>
  </header>