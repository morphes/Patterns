<?php

interface Observable {
    function attach(Observer $observer);
    function detach(Observer $observer);
    function notify();
}

class Login implements Observable {
    private $observers = array();
    private $storage;

    const LOGIN_USER_UNKNOWN = 1;
    const LOGIN_WRONG_PASS = 2;
    const LOGIN_ACCESS = 3;

    private $status = array();

    function __construct() {
        $this->observers = array();
    }

    function handleLogin($user, $pass, $ip) {
        $isvalid = false;
        switch(rand(1,3)) {
            case 1:
                $this->setStatus(self::LOGIN_ACCESS, $user, $ip);
                $isvalid = true;
            case 2:
                $this->setStatus(self::LOGIN_WRONG_PASS, $user, $ip);
                $isvalid = false;
            case 3:
                $this->setStatus(self::LOGIN_USER_UNKNOWN, $user, $ip);
                $isvalid = false;
        }
        $this->notify();
        return $isvalid;

    }

    private function setStatus($status, $user, $ip) {
        $this->status = array($status, $user, $ip);
    }

    function getStatus() {
        return $this->status;
    }

    function attach(Observer $observer) {
        $this->observers[] = $observer;
    }

    function detach(Observer $observer) {
        $this->observers = array_filter($this->observers, function($a) use ($observer) {
            return (!($a === $observer));
        });
    }

    function notify() {
        foreach($this->observers as $obs) {
            $obs->update($this);
        }
    }
}

interface Observer {
    function update(Observable $observable);
}

class SecurityMonitor implements Observer {
    function update(Observable $observable) {
        $status = $observable->getStatus();
        var_dump($status);
        if($status[0] == Login::LOGIN_WRONG_PASS) {
            print __CLASS__ . "Отправка почты системному администратору";
        }
    }
}

class GeneralLogger implements Observer {
    function update(Observable $observable) {
        $status = $observable->getStatus();
        if($status[0] == Login::LOGIN_USER_UNKNOWN) {
            print __CLASS__ . "Регистрация в системном журнале";
        }
    }
}

$login = new Login();
$login->handleLogin('dmitry', 'everest', '10.0.209.40');
$login->attach(new SecurityMonitor());
$login->attach(new GeneralLogger());
$login->notify();