        <!-- This code is taken from http://twitter.github.com/bootstrap/examples/hero.html -->

        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="#">Magazine Collection</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                          <?php
                            // Quick and dirty navigation.
                            $menu_item_default = 'index';
                              $menu_items = array(
                                  'Cart/Show' => array(
                                      'label' => 'Show Cart',
                                      'desc' => 'Show contents of cart',
                                  ),
                              );

                            // Determine the current menu item.
                            $menu_current = $menu_item_default;
                            // If there is a query for a specific menu item and that menu item exists...
                            if ($this->uri->segment(2) && array_key_exists($this->uri->segment(2), $menu_items)) {
                              $menu_current = $this->uri->segment(2);
                            }
                            foreach ($menu_items as $item => $item_data) {
                              echo '<li' . ($item == $menu_current ? ' class="active"' : '') . '>';
                                echo '<a href="' . base_url(). 'index.php/Home/' . $item . '" title="' . $item_data['desc'] . '">' . $item_data['label'] . '</a>';
                              echo '</li>';
                            }
                          ?>
                        </ul>                        
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>

        <div class="container">