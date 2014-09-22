<?php

/**
 * Class Logout
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class Logout extends Controller
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://www.friendstie.com/logout/index (which is the default page btw)
     */
    public function index()
    {
        // Initialize the session.
		// If you are using session_name("something"), don't forget it now!
		session_start();

		// Unset all of the session variables.
		$_SESSION = array();

		// If it's desired to kill the session, also delete the session cookie.
		// Note: This will destroy the session, and not just the session data!
		if (ini_get("session.use_cookies")) {
		    $params = session_get_cookie_params();
		    setcookie(session_name(), '', time() - 42000,
		        $params["path"], $params["domain"],
		        $params["secure"], $params["httponly"]
		    );
		}

		// Finally, destroy the session.
		session_destroy();
		setcookie('pc_user', null, time() - (86400 * 7)); //86400 == One Day -> that makes 7 days back
		header("Location:".URL."home");
    }
}