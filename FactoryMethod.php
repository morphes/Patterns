<?php

abstract class ApptEncoder {

    abstract function encode();

}

class BloggsApptEncoder extends ApptEncoder {

    function encode() {
        return "Данные о встрече закодированы в формате BloggsCal";
    }

}

abstract class CommsManager {

    abstract function getHeaderText();
    abstract function getApptEncoder();
    abstract function getFooterText();

}

class BloggsCommsManager extends CommsManager {

    function getHeaderText() {
        return "BloggsCal верхний колонтитул";
    }

    function getApptEncoder() {
        return new BloggsApptEncoder();
    }

    function getFooterText() {
        return "BloggsCal нижний колонтитул";
    }

}

$mgr = new BloggsCommsManager;
print $mgr->getHeaderText();
print $mgr->getApptEncoder()->encode();
print $mgr->getFooterText();
