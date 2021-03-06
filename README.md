# XDebug Trace Reader

The goal of this package is to help you read large trace files and and to offer build in features to make it easier to to interpret each entry.
Most examples I could find on the web would simply create a huge array. I don't like this approach. The goal of this package is to implement a basic reader capable
of processing large files. For each line the reader will instantiate an object. The latter will add a little bit of overhead.
I think this is acceptable since we are processing only one object per iteration.

## What this package is not
This package does not analyze the contents of the trace file. The aim is to help users develop their own interpreter without having to worry about the actual reading.


## Creating the reader

`For more examples go to the examples folder.`

```
// Create reader from file path
$reader = EntryReader::fromFile(new EntryFactory, __DIR__ . '/../assets/trace.out.xt');

// Or create reader from a pointer
$fp = fopen(__DIR__ . '/../assets/trace.out.xt');
$reader = new EntryReader(new EntryFactory, $fp);
```


## Reading the file
```
/** @var \Leadtech\XDebugTraceReader\Trace\TraceEntryInterface $entry */
while($entry = $reader->read()) {
    var_dump($entry);
}
```
