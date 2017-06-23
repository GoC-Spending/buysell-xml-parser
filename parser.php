<?php

require_once dirname(__FILE__) . '/vendor/autoload.php';

use XPathSelector\Selector;

$data = file_get_contents(dirname(__FILE__) . '/data.xml');

$xs = Selector::loadXML($data);


