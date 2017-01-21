<?php
abstract class Lesson {

    private $duration;
    private $costStrategy;

    function __construct($duration, CostStrategy $strategy) {
        $this->duration = $duration;
        $this->costStrategy = $strategy;
    }

    function cost() {
        return $this->costStrategy->cost( $this );
    }

    function chargeType() {
        return $this->costStrategy->chargeType();
    }

    function getDuration() {
        return $this->duration;
    }
}

class Lecture extends Lesson {

}

class Seminar extends Lesson {

}

abstract class CostStrategy {
    abstract function cost(Lesson $lesson);
    abstract function chargeType();
}

class TimedCostStrategy extends CostStrategy {

    function cost(Lesson $lesson) {
        return ($lesson->getDuration() * 5);
    }

    function chargeType() {
        return "Почасовая оплата";
    }
}

class FixedCostStrategy extends CostStrategy {

    function cost(Lesson $lesson) {
        return 30;
    }

    function chargeType() {
        return "Почасовая ставка";
    }
}

$lessons[] = new Seminar(4, new TimedCostStrategy());
$lessons[] = new Lecture(4, new FixedCostStrategy());

foreach($lessons as $lesson) {
    print "Плата за занятие {$lesson->cost()}. ";
    print "Тип оплаты: {$lesson->chargeType()}\n";
}