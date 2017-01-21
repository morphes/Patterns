<?php
abstract class Lesson {

    protected $duration;
    const FIXED = 1;
    const TIMED = 2;
    private $costtype;

    function __construct($duration, $costtype = 1) {
        $this->duration = $duration;
        $this->costtype = $costtype;
    }

    function cost() {
        switch($this->costtype) {
            CASE self::TIMED :
                return (5 * $this->duration);
                break;
            CASE self::FIXED :
                return 30;
                break;
            default:
                $this->costtype = self::FIXED;
                return 30;
        }
    }

    function chargeType() {
        switch($this->costtype) {
            CASE self::TIMED :
                return "Почасовая оплата";
            CASE self::FIXED :
                return "Фиксированная оплата";
            default:
                $this->costtype = self::FIXED;
                return "Фиксированная ставка";
        }
    }
}

class Lecture extends Lesson {

}

class Seminar extends Lesson {

}

$lecture = new Lecture(5, Lesson::FIXED);
$seminar = new Seminar(3, Lesson::TIMED);

print "{$lecture->cost()} ({$lecture->chargeType()})\n";
print "{$seminar->cost()} ({$seminar->chargeType()})\n";





