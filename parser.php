<?php

require_once dirname(__FILE__) . '/vendor/autoload.php';

use XPathSelector\Selector;

$data = file_get_contents(dirname(__FILE__) . '/data.xml');

$xs = Selector::loadXML($data);

$contracts = $xs->findAll('//item');

foreach ($contracts as $contract) {
    $contractValues = [
        'title' => $contract->find('title')->extract(),
        'url' => $contract->find('link')->extract(),
        'department' => $contract->find('dc:creator')->extract(),
    ];

    var_dump($contractValues);
}
