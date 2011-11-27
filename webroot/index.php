<?php
require_once dirname(__DIR__) . '/bootstrap.php';
require_once PATH_VENDOR_ROOT . '/Slim/Slim.php';

$app = new Slim();
$app->config('templates.path', dirname(__DIR__) . '/templates');

$app->get('/', function() use ($app) {
    $app->render('index.html', array());
});

$app->get('/mecab', function() use ($app) {
    $sentence = $app->request()->get('s');

    $cl = new ClassLoader();
    $ret = $cl->load('Mecab');
    $mecab = new Mecab();

    $mecab_options = array(
        '-u' => PATH_RESOURCE_ROOT . '/word.dic',
    );

    $ret = $mecab->parseToNode($sentence, $mecab_options);

    $app->response()->header('Content-Type', 'application/json; charset=utf-8');
    $app->response()->body(json_encode($ret));
});

$app->get('/mecab/wakati', function() use ($app) {
    $sentence = $app->request()->get('s');
});

$app->run();

