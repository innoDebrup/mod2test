<?php
require_once __DIR__ . '/CreateQuery.php';
require_once __DIR__ . '/ReadQuery.php';
require_once __DIR__ . '/UpdateQuery.php';
require_once __DIR__ . '/DeleteQuery.php';

$create = new CreateQuery();
$read = new ReadQuery();
$update = new UpdateQuery();
$delete = new DeleteQuery();
