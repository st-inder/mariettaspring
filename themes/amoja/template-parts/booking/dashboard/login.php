<?php
/**
 * BA Login
 *
 * Override BABE_My_account::get_login_form()
 * @version 1.0.0
 */

if (is_user_logged_in()) {
    return;
}

$action = '';

if (isset($_GET['action'])) $action = $_GET['action'];
?>

<div id="login_form">
    <h3 class="amoja-login-title"><?php esc_html_e('Login', 'amoja'); ?></h3>
    <form name="babe_login" id="babe_login" action="<?php echo esc_attr(BABE_Settings::get_my_account_page_url(array('action' => 'login'))) ?>" method="post">
        <?php apply_filters('babe_login_form_before_fields', ''); ?>
        <div class="login_username">
            <label for="login_username"><?php esc_html_e('Username or email', 'amoja') ?></label>
            <input type="text" name="login_username" id="login_username" class="input" value="" size="20" required="required">
        </div>
        <div class="login_pw">
            <label for="login_pw"><?php esc_html_e('Password', 'amoja') ?></label>
            <input type="password" name="login_pw" id="login_pw" class="input" value="" size="20" required="required">
        </div>
        <div class="login_submit">
            <input type="submit" name="login_submit" id="login_submit" class="button button-primary" value="<?php echo esc_attr__('Sign in', 'amoja') ?>">
        </div>
        <?php
        if (isset($action) && $action == 'login_error') {
            echo '<div><div id="login_error"><strong>' . esc_html__('ERROR: Invalid username or password.', 'amoja') . '</strong> <a href="' . esc_url(BABE_Settings::get_my_account_page_url(array('action' => 'lostpassword'))) . '">' . esc_html__('Forgot your password?', 'amoja') . '</a></div></div>';
        }

        if (isset($action) && $action == 'password_reseted') {
            echo '<div><div id="password_reseted">' . esc_html__('Check your email address for you new password.', 'amoja') . '</div></div>';
        }

        if (isset($_GET['status']) && $_GET['status'] == 'new_user_registered') { ?>
            <div class="modal fade" id="user_registered_modal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLabel"><?php esc_html_e('Thank you for registration! Check email for your password.', 'amoja') ?></h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="<?php esc_attr_e('Close', 'amoja') ?>">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="button" class="btn btn-primary" data-dismiss="modal"><?php esc_html_e('Close', 'amoja') ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }

        if (!isset($action)) {
            echo '<div id="forgot_url"><a href="' . esc_url(BABE_Settings::get_my_account_page_url(array('action' => 'lostpassword'))) . '">' . esc_html__('Forgot password?', 'amoja') . '</a></div>';
        }
        ?>
    </form>
    <?php if ( get_option( 'users_can_register' ) ) : ?>
        <div class="login_registration">
            <h3><?php esc_html_e('Do not have an account?', 'amoja'); ?></h3>
            <div class="registration_link">
                <a href="#registration" data-toggle="modal" data-target="#registration"><?php esc_html_e('Register', 'amoja'); ?></a>
            </div>
        </div>

    <?php endif; ?>
</div>
