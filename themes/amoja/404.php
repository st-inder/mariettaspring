<?php
get_header(); ?>
    <div id="primary" class="content">
        <main id="main" class="site-main">
            <div class="error-404 not-found">
                <div class="page-content">
                    <div class="error-heading"><?php esc_html_e('404', 'amoja'); ?></div>
                    <h2 class="error-title"><?php esc_html_e('We can’t find the page your are looking for', 'amoja'); ?></h2>
                    <div class="error-button">
                        <a href="javascript: history.go(-1)" class="elementor-button">
                            <span class="elementor-button-content-wrapper">
                                <span class="elementor-button-text"><?php esc_html_e('back to home', 'amoja');?></span>
                                <span class="elementor-button-icon"><i class="amoja-icon-arrow-right"></i></span>
                            </span>
                        </a>
                    </div>
                </div><!-- .page-content -->
            </div><!-- .error-404 -->
        </main><!-- #main -->
    </div><!-- #primary -->
<?php
get_footer();
