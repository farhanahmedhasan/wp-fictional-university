<!DOCTYPE html <?php language_attributes() ?>>
<head>
  <meta charset="<?php bloginfo('charset') ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head() ?>

    <style>
        @media (min-width: 960px) {
            .site-header__menu-trigger {
                display: none;
            }
        }
    </style>
</head>
<body <?php body_class() ?>>
    <header class="site-header">
      <div class="container"> 
        <h1 class="school-logo-text float-left">
          <a href=<?php echo site_url('/') ?>><strong>Fictional</strong> University</a>
        </h1>
        <a href="<?php echo esc_url(site_url('/search')) ?>" class="js-search-trigger site-header__search-trigger">
            <i class="fa fa-search" id="header-search" aria-hidden="true"></i>
        </a>
        <i class="site-header__menu-trigger fa fa-bars" aria-hidden="true"></i>
        <div class="site-header__menu group">
          <nav class="main-navigation">
          <?php 
              wp_nav_menu([
                'theme_location' => 'header_menu'
              ]);
            ?>
          </nav>
          <div class="site-header__util">
            <a href="#" class="btn btn--small btn--orange float-left push-right">Login</a>
            <a href="#" class="btn btn--small btn--dark-orange float-left">Sign Up</a>
            <a href="<?php echo esc_url(site_url('/search')) ?>" class="search-trigger js-search-trigger">
                <i class="fa fa-search" id="header-search" aria-hidden="true"></i>
            </a>
          </div>
        </div>
      </div>
    </header>
