<?php

require_once dirname(__FILE__) . '/vendor/autoload.php';

use XPathSelector\Selector;

var_dump(parseContracts(loadContracts()));

function loadContracts() {
    $data = file_get_contents(dirname(__FILE__) . '/data.xml');

    return Selector::loadXML($data);
}

function parseContracts($xs) {
    return $xs->findAll('//item')->map(function($contract) {
        return array_merge([
            'title' => $contract->find('title')->extract(),
            'url' => $contract->find('link')->extract(),
            'department' => $contract->find('dc:creator')->extract(),
        ], parseDescription($contract->find('description')->extract()));
    });
}

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
