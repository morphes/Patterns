<?php

abstract class Unit {

    function addUnit(Unit $unit) {
        throw new UnitException(get_class($this). 'относится к листьям');
    }

    function removeUnit(Unit $unit) {
        throw new UnitException(get_class($this). 'относится к листьям');
    }

    abstract function bombardStrength();
}

class Army extends Unit {
    private $units = array();

    function addUnit(Unit $unit) {
        if(in_array($unit, $this->units, true)) {
            return;
        }
        $this->units[] = $unit;
    }

    function removeUnit(Unit $unit) {
        $this->units = array_udiff($this->units, array($unit), function ($a, $b) {
            return ($a === $b) ? 0 : 1;
        });
    }

    function bombardStrength() {
        $ret = 0;
        foreach($this->units as $unit) {
            $ret += $unit->bombardStrength();
        }
        return $ret;
    }
}

class UnitException extends Exception {

}

class Archer extends Unit {

    function bombardStrength() {
        return 4;
    }

}

class LaserCannonUnit extends Unit {

    function bombardStrength() {
        return 8;
    }

}

$mainArmy = new Army();

$mainArmy->addUnit(new Archer());
$mainArmy->addUnit(new LaserCannonUnit());

$subArmy = new Army();

$subArmy->addUnit(new Archer());
$subArmy->addUnit(new Archer());
$subArmy->addUnit(new Archer());

$mainArmy->addUnit($subArmy);

print "Атакующая сила -  ".$mainArmy->bombardStrength();

