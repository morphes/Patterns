<?php

class RequestHelper {

}

abstract class ProcessRequest {

    abstract function process(RequestHelper $req);

}

class MainProcess extends ProcessRequest {

    function process(RequestHelper $req) {
        print __CLASS__ . "выполнение запроса";
    }

}

abstract class DecorateProcess extends ProcessRequest {

    protected $processRequest;

    function __construct(ProcessRequest $pr) {
        $this->processRequest = $pr;
    }
}

class LogRequest extends DecorateProcess {

    function process(RequestHelper $req) {
        print __CLASS__ . "регистрация запроса";
        $this->processRequest->process($req);
    }

}

class AuthenticateRequest extends DecorateProcess {

    function process(RequestHelper $req) {
        print __CLASS__ . "регистрация запроса";
        $this->processRequest->process($req);
    }

}

class StructureRequest extends DecorateProcess {

    function process(RequestHelper $req) {
        print __CLASS__ . "регистрация запроса";
        $this->processRequest->process($req);
    }

}

$process = new AuthenticateRequest(
    new StructureRequest(
        new LogRequest(
            new MainProcess()
        )
    )
);
$process->process(new RequestHelper());


