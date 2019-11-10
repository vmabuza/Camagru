<?php
class UserSessions extends Model {
    public function __construct() {
        $table = 'user_sessions';
        parent::__construct($table);
    }

    public static function getFromCookie() {
        if (Cookie::get(REMEMBER_ME_COOKIE_NAME)) {
            $userSession = new UserSessions();
            $userSession = $userSession->findFirst([
                'conditions' => "user_agent = ? AND session = ?",
                'bind' => [Session::uagent_no_version(), Cookie::get(REMEMBER_ME_COOKIE_NAME)]
            ]);
        }
        if (!isset($userSession)) {
            return false;
        }
        return $userSession;
    }
}