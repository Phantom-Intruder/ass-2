<?php
// Quick and dirty navigation.
$menu_item_default = 'index';
$menu_items = array(
  'index' => array(
    'label' => 'Home',
    'desc' => 'View the wish list',
  ),
  'logout' => array(
    'label' => 'Logout',
    'desc' => 'Unset user',
  ),
  'register' => array(
    'label' => 'Register',
    'desc' => 'Registration page',
  ),
);

// Determine the current menu item.
$menu_current = $menu_item_default;
// If there is a query for a specific menu item and that menu item exists...
if (@array_key_exists($this->uri->segment(2), $menu_items)) {
  $menu_current = $this->uri->segment(2);
}
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Wish List</title>
        <meta name="description" content="<?php html_escape($menu_items[$menu_current]['desc']); ?>">
        <meta name="viewport" content="width=device-width">

        <?= link_tag(base_url().'css/bootstrap.min.css'); ?>
        <?= link_tag(base_url().'css/bootstrap-responsive.min.css'); ?>
        <?= link_tag(base_url().'css/main.css'); ?>

        <style>
            body {
                padding-top: 60px;
                padding-bottom: 40px;
            }
        </style>

        <script src=<?= base_url()."js/vendor/modernizr-2.6.2.min.js"?>></script>
        <script src=<?= base_url()."js/vendor/jquery-1.9.1.min.js"?>></script>
        <script src=<?= base_url()."js/vendor/underscore-min.js"?>></script>
        <script src=<?= base_url()."js/vendor/backbone-min.js"?>></script>
        <script src=<?= base_url()."js/vendor/backbone-forms.js"?>></script>
        <script src=<?= base_url()."js/vendor/list.js"?>></script>
        <script src=<?= base_url()."js/vendor/backbone.bootstrap-modal.min.js"?>></script>
        <script src=<?= base_url()."js/vendor/bootstrap.min.js"?>></script>
    </head>
    <body>
        <!-- This code is taken from http://twitter.github.com/bootstrap/examples/hero.html -->

        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="brand" href="#">Wish List</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                          <?php
                            foreach ($menu_items as $item => $item_data) {
                                if ($item_data['label'] == 'Logout'){
                                    if (isset($this->session->wishListId)){
                                        echo '<li>';
                                        echo '<a style="margin-left: 750px" href="' . base_url() . 'index.php/Home/' . $item . '" title="' . $item_data['desc'] . '">' . $item_data['label'] . '</a>';
                                        echo '</li>';
                                    }
                                }else if($item_data['label'] == 'Register'){
                                    if (!isset($this->session->wishListId)) {
                                        echo '<li>';
                                        echo '<a style="margin-left: 750px" href="' . base_url() . 'index.php/Home/' . $item . '" title="' . $item_data['desc'] . '">' . $item_data['label'] . '</a>';
                                        echo '</li>';
                                    }
                                }else{
                                    echo '<li>';
                                    echo '<a href="' . base_url() . 'index.php/Home/' . $item . '" title="' . $item_data['desc'] . '">' . $item_data['label'] . '</a>';
                                    echo '</li>';

                                }
                            }
                          ?>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>

        <div class="container">