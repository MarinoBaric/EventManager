<?php

/**
 * Description of Session responsible for session management.
 *
 * Starts the session, checks whether it has expired based on the user's last
 * activity time, and destroys it together with the session file and the
 * session cookie.
 */
final class Session {

    /**
     * Starts a new session or resumes the existing one.
     *
     * @return void
     */
    public static function start(): void {
        session_start();
    }

    /**
     * Destroys the session, its file and the session cookie, then redirects
     * the user to the login page.
     *
     * @return void
     */
    public static function destroy(): void{
        session_unset();
        session_destroy();
        setcookie(session_name(), '', time() - 1, '/');
        header('location: ' . PROJECT_URL);
        exit();
    }

    /**
     * Checks whether the session has expired. If it has not, the last activity
     * time is refreshed.
     *
     * @return bool True if the session expired, false otherwise.
     */
    public static function isExpired(): bool {
        $timeout = CONFIG_DATA['session']['session_timeout'];
        if(isset($_SESSION['last_activity_time']) && (time() - $_SESSION['last_activity_time']) > $timeout){
            return true;
        }

        $_SESSION['last_activity_time'] = time();
        return false;
    }

}
