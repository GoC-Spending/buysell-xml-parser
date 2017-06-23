<?php

require_once dirname(__FILE__) . '/vendor/autoload.php';

use XPathSelector\Selector;

$data = file_get_contents(dirname(__FILE__) . '/data.xml');

$xs = Selector::loadXML($data);

$contracts = $xs->findAll('//item')->map(function($contract) {
    return [
        'title' => $contract->find('title')->extract(),
        'url' => $contract->find('link')->extract(),
        'department' => $contract->find('dc:creator')->extract(),
        'description' => parseDescription($contract->find('description')->extract()),
    ];
});

var_dump($contracts);

function parseDescription($description) {
    $descriptionKeys = [];
    $descriptionValues = [];

    $xs = Selector::loadHTML($description);

    $descriptionRows = $xs->findAll('//td');


    // There's no signifier of heading vs value, so we walk the tree to find keys and values
    $i = 0;
    foreach ($descriptionRows as $row) {
        if ($i % 2 == 0) {
            $descriptionKeys[] = $row->extract();
        } else {
            $descriptionValues[] = $row->extract();
        }

        $i++;
    }

    return array_combine($descriptionKeys, $descriptionValues);;
}
