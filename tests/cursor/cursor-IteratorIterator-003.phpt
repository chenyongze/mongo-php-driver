--TEST--
MongoDB\Driver\Cursor iteration beyond last document (find command)
--SKIPIF--
<?php require __DIR__ . "/../utils/basic-skipif.inc"; CLEANUP(STANDALONE) ?>
--FILE--
<?php
require_once __DIR__ . "/../utils/basic.inc";

$manager = new MongoDB\Driver\Manager(STANDALONE);

$bulk = new MongoDB\Driver\BulkWrite();
$bulk->insert(['_id' => 1]);
$manager->executeBulkWrite(NS, $bulk);

$cursor = $manager->executeQuery(NS, new MongoDB\Driver\Query([]));

$iterator = new IteratorIterator($cursor);
$iterator->rewind();
var_dump($iterator->current());
$iterator->next();
var_dump($iterator->current());

// libmongoc throws on superfluous iteration of find command cursor (CDRIVER-1234)
echo throws(function() use ($iterator) {
    $iterator->next();
}, 'MongoDB\Driver\Exception\RuntimeException'), "\n";

?>
===DONE===
<?php exit(0); ?>
--EXPECTF--
object(stdClass)#%d (%d) {
  ["_id"]=>
  int(1)
}
NULL
OK: Got MongoDB\Driver\Exception\RuntimeException
Cannot advance a completed or failed cursor.
===DONE===
