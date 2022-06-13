<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    wp_head();
    ?>
</head>

<body <?php body_class(); ?>>
    <header>
        <div class="container">
            <div class="logo">
                <a href="<?php echo get_home_url(); ?>"><img src="<?php echo bloginfo("template_url"); ?>/img/logo.png" alt="Добро пожаловать в онлайн-магазин TestWork 548"></a>
                <h1>Добро пожаловать в онлайн-магазин TestWork 548</h1>
            </div>
        </div>
    </header>

    <nav class="head-menu">
        <div class="container">
            <?php
            wp_nav_menu([
                'theme_location' => 'header-menu',
                'container' => false,
            ]);
            ?>
        </div>
    </nav>