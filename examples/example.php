<?php
require __DIR__ . '/../vendor/autoload.php';

/*
 * A simple usage example.
 *
 * Use the trace reader to read a xdebug trace file.
 * Most examples I could find on the web would create a huge array. I don't like this approach. The goal of this package is too implement a simple trace file reader capable
 * of processing large files. For each line the reader will instantiate an object. Perhaps the latter will add a little bit of overhead.
 * But the object contains some business logic that helps interpreting the content of the entry. Because we are processing the file line by line we enable PHP
 * to run the garbage collector in time. Perhaps
 */


use Leadtech\XDebugTraceReader\Reader\FilteredMethodTraceReader as EntryReader;
use Leadtech\XDebugTraceReader\Factory\EntryFactory;

// Create reader from file path
$reader = EntryReader::fromFile(new EntryFactory, __DIR__ . '/../assets/trace.out.xt');

/** @var \Leadtech\XDebugTraceReader\Trace\TraceEntryInterface $entry */
$depth = $previousLevel = 0;
while($entry = $reader->read()) {

    //
    // Format output
    //
    // Indent lines based on the depth value and print extra line break each time the level changes.
    //
    if($previousLevel) {
        if($entry->getEntryLevel() > $previousLevel) {
            ++$depth;
            print(PHP_EOL);
        } else if($entry->getEntryLevel() < $previousLevel) {
            --$depth;
            print(PHP_EOL);
        }
    }

    //
    // Dump all entries
    //
    // Print function call plus return type...
    //
    if($entry->isEntry()) {
        print(str_repeat('   ', $depth) . "#{$entry->getEntryLevel()} " . $entry->getFunctionName() . '(' . implode(', ', $entry->getParameters()) . ')'  . PHP_EOL);
    } else if($entry->isEntryReturn()) {
        print(str_repeat('   ', $depth) . 'Returns: ' .  $entry->getFunctionName() . PHP_EOL);
    }

    // Update previous level value
    $previousLevel = $entry->getEntryLevel();
}