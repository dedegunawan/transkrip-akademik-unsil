<?php
/**
 * Created by PhpStorm.
 * User: tik_squad
 * Date: 10/8/19
 * Time: 9:26 AM
 */

require_once '../../vendor/autoload.php';

try {

    \DedeGunawan\TranskripAkademikUnsil\Entities\Tanggal::setLocaleIndonesia();

    $transkrip_akademik = \DedeGunawan\TranskripAkademikUnsil\TranskripAkademikUnsil::getInstance();

    $transkrip_akademik->setNpm("137006107");

    $transkrip_akademik->setTemplate(new \DedeGunawan\TranskripAkademikUnsil\Templates\BaseTemplate());

    $mysqli = new \DedeGunawan\TranskripAkademikUnsil\Databases\Builder\MysqliBuilder();
    $mysqli->setHost('');
    $mysqli->setUsername('');
    $mysqli->setDbname('');
    $mysqli->setPasswd('');
    $mysqli->setPort('');
    $mysqli->connect();

    \DedeGunawan\TranskripAkademikUnsil\Databases\ConnectionManager::getInstance()
        ->setConnection('unsil', $mysqli);

    $transkrip_akademik->setConnectionManager(\DedeGunawan\TranskripAkademikUnsil\Databases\ConnectionManager::getInstance());

    $hook = new \DedeGunawan\TranskripAkademikUnsil\Services\Hook\ValidatorHook();
    $transkrip_akademik->addHook($hook);

    $transkrip_akademik->setResolver(new \DedeGunawan\TranskripAkademikUnsil\Services\Resolver\MysqliResolver());
    $transkrip_akademik->resolve();

    $transkrip_akademik->getTemplate()->render();
} catch (Exception $exception) {
    echo $exception->getMessage()." at file ".$exception->getFile()." line ".$exception->getLine()."\n";
}