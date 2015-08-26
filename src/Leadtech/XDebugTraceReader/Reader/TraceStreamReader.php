<?php

namespace Leadtech\XDebugTraceReader\Reader;

use Leadtech\XDebugTraceReader\Factory\EntryFactoryInterface;
use Leadtech\XDebugTraceReader\Trace\TraceEntryInterface;

/**
 * Class TraceReader
 * @package Leadtech\XDebugTraceReader\Reader
 */
class TraceStreamReader
{
    const DELIMITER = "\t";

    /** @var string */
    private $versionHeader = null;

    /** @var string */
    private $fileFormatHeader = null;

    /** @var TraceEntryInterface */
    public $current = null;

    /**
     * @param EntryFactoryInterface $entryFactory
     * @param resource $handle
     */
    public function __construct(EntryFactoryInterface $entryFactory, $handle)
    {
        if(is_resource($handle)) {

            // Set handle
            $this->handle = $handle;

            // Get headers
            $this->versionHeader     = fgets( $this->handle );
            $this->fileFormatHeader  = fgets( $this->handle );

            // Move file pointer one more line because of the unneeded column headers row.
            fgets($this->handle);

            // Set factory
            $this->factory = $entryFactory;

            // Initialize reader
            $this->initialize();

            return;
        }

        throw new \InvalidArgumentException("The handle must be a valid resource!");
    }

    /**
     * @param EntryFactoryInterface $entryFactory
     * @param $filepath
     * @return TraceStreamReader|false
     */
    public static function fromFile(EntryFactoryInterface $entryFactory,$filepath)
    {
        if(file_exists($filepath) && is_readable($filepath)) {
            if (($handle = fopen($filepath, 'r')) !== false) {
                return new self($entryFactory, $handle);
            }
        }

        return false;
    }

    /**
     * @return TraceEntryInterface|false
     */
    public function read()
    {
        $row = fgetcsv($this->handle, null, self::DELIMITER);
        if($row !== false) {
            $this->current = $this->factory->entry($row);

            return $this->current;
        }

        return false;
    }

    /**
     * Close the file handle
     */
    public function close()
    {
        if(is_resource($this->handle)) {
            fclose($this->handle);
        }
    }

    /**
     * @return bool
     */
    protected function initialize()
    {
        // Check if the factory supports the given trace format
        if (!$this->factory->isSupportedFileFormat($this->fileFormatHeader)) {
            throw new \RuntimeException("Invalid file format header! This file format is not supported.");
        }

        if (!$this->factory->isSupportedVersion($this->versionHeader)) {
            throw new \RuntimeException("Invalid version header! This trace file was generated using an unsupported xdebug version.");
        }

        return true;
    }

    /**
     * Destruct object
     */
    public function __destruct()
    {
        // Close resource in case it is not closed yet
        $this->close();
    }
}