<?php

$router->get('/', function () use ($router) {

    echo config('app.name') . ' v' . composerAppVersion();
});
