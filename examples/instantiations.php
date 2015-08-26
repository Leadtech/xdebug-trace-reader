<?php
require '../vendor/autoload.php';
$bench = new Ubench;
$bench->start();

$factory = new \Leadtech\XDebugTraceReader\Factory\EntryFactory();
for($i=0;$i<=100000000;$i++){
    $factory->entry([
       $i,
       123,
       1,
       123,
       123,
       123,
       123,
       123,
       123,
       123,
       123,
       123,
       123,
       123,
    ]);
}


$bench->end();

echo $bench->getTime();