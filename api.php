<?php
/**
 * A little script to accept and verify user auth details.
 * Return error with msg if incorrect or msg of success!
 *
 */

// make sure this is requested via ajax and all that jazz
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $return['error'] = false;
    
    if ( empty($_POST['username']) ) {
        $return['error'] = true;
        $return['msg'] = 'You didn\'t enter a username.';
    }
    elseif ( empty($_POST['password']) ) {
        $return['error'] = true;
        $return['msg'] = 'You didn\'t enter a password.';
    }
    elseif ( !$return['error'] && 
                $_POST['username'] == 'user' && 
                $_POST['password'] == 'paswd' ) {

        setcookie('mockauth', 'username');
        $return['error'] = false;
        $return['msg'] = 'You have logged in successfully!';
    }
    else {
        $return['error'] = true;
        $return['msg'] = 'Either your username or password was inncorrect.';
    }
    echo json_encode($return);

} else {
    header("Location: http://localhost/demo/php/mock_login/");
    die('direct access is forbidden');
}
?>