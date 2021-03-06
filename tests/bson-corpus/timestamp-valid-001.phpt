--TEST--
Timestamp type: Timestamp: (123456789, 42)
--DESCRIPTION--
Generated by scripts/convert-bson-corpus-tests.php

DO NOT EDIT THIS FILE
--FILE--
<?php

require_once __DIR__ . '/../utils/tools.php';

$bson = hex2bin('100000001161002A00000015CD5B0700');

// BSON to Canonical BSON
echo bin2hex(fromPHP(toPHP($bson))), "\n";

// BSON to Canonical extJSON
echo json_canonicalize(toJSON($bson)), "\n";

$json = '{"a" : {"$timestamp" : {"t" : 123456789, "i" : 42}}}';

// extJSON to Canonical extJSON
echo json_canonicalize(toJSON(fromJSON($json))), "\n";

// extJSON to Canonical BSON
echo bin2hex(fromJSON($json)), "\n";

?>
===DONE===
<?php exit(0); ?>
--EXPECT--
100000001161002a00000015cd5b0700
{"a":{"$timestamp":{"t":123456789,"i":42}}}
{"a":{"$timestamp":{"t":123456789,"i":42}}}
100000001161002a00000015cd5b0700
===DONE===