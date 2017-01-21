<?php
require("strategyExample.php");
class RegistrationMgr {

    function register(Lesson $lesson) {
        $notifier = Notifier::getNotifier();
        $notifier->inform("Новое занятие: стоимость - (".$lesson->cost().")");
    }

}

abstract class Notifier {

    static function getNotifier() {
        if(rand(1,2) === 1) {
            return new MailNotifier();
        }
        return new TextNotifier();
    }

    abstract function inform($message);

}

class MailNotifier extends Notifier {

    function inform($message) {
        echo "Уведомление по Email: ".$message;
    }
}

class TextNotifier extends Notifier {

    function inform($message) {
        echo "Текстовое уведомление: ".$message;
    }
}

$lessons1 = new Seminar(4, new TimedCostStrategy());
$lessons2 = new Lecture(4, new FixedCostStrategy());

$mgr = new RegistrationMgr();
$mgr->register($lessons1);
$mgr->register($lessons2);