<?php if (has_nav_menu('footer-menu1')): ?>
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
                    <h3>
                        <?php
                        $menu_location = 'footer-menu1';
                        $menu_locations = get_nav_menu_locations();
                        $menu_object = (isset($menu_locations[$menu_location]) ? wp_get_nav_menu_object($menu_locations[$menu_location]) : null);
                        $menu_name = (isset($menu_object->name) ? $menu_object->name : '');

                        echo esc_html($menu_name);
                        ?>
                    </h3>
                    <ul class="footer-list">
                        <?php wp_nav_menu(array('theme_location' => 'footer-menu1', 'container' => '', 'items_wrap' => '%3$s')); ?>                        
                        <li><a href="<?php echo get_post_type_archive_link('download'); ?>"><?php pll_e('مركز المعلومات والملفات'); ?></a></li>
                    </ul>
                </div>
            <?php endif; ?>
