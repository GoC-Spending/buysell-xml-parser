<?php

require_once dirname(__FILE__) . '/vendor/autoload.php';

use XPathSelector\Selector;
use League\Csv\Writer;

outputCsv(parseContracts(loadContracts()));

function loadContracts() {
    $data = file_get_contents(dirname(__FILE__) . '/data.xml');

    return Selector::loadXML($data);
}

function parseContracts($xs) {
    return $xs->findAll('//item')->map(function($contract) {
        return array_merge([
            'title' => trim($contract->find('title')->extract()),
            'url' => trim($contract->find('link')->extract()),
            'department' => trim($contract->find('dc:creator')->extract()),
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
            $descriptionKeys[] = trim($row->extract());
        } else {
            $descriptionValues[] = trim($row->extract());
        }

        $i++;
    }

    return array_combine($descriptionKeys, $descriptionValues);
}

function outputCsv($contracts) {
    $writer = Writer::createFromPath(new SplFileObject(dirname(__FILE__) . '/contracts.csv', 'a+'), 'w');

    // headers
    $writer->insertOne(array_keys($contracts[0]));

    // rows
    foreach ($contracts as $contract) {
        $writer->insertOne(array_values($contract));
    }
}
