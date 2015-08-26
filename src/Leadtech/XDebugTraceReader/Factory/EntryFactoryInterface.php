<?php
namespace Leadtech\XDebugTraceReader\Factory;

use Leadtech\XDebugTraceReader\Trace\TraceEntryInterface;

/**
 * Interface TraceEntryFactoryInterface
 * @package Leadtech\XDebugTraceReader\Factory
 */
interface EntryFactoryInterface
{
    const COLUMN_ENTRY_LEVEL = 0;
    const COLUMN_FUNCTION_ID = 1;
    const COLUMN_ENTRY_TYPE = 2;
    const COLUMN_TIME_INDEX = 3;
    const COLUMN_MEMORY_USAGE = 4;
    const COLUMN_FUNCTION_NAME = 5;
    const COLUMN_USER_DEFINED = 6;
    const COLUMN_INCLUDED_FILENAME = 7;
    const COLUMN_FILENAME = 8;
    const COLUMN_LINE_NUMBER = 9;
    const COLUMN_PARAMETER_COUNT = 10;

    /**
     * Create entry from raw trace data.
     *
     * @param array $traceLine
     * @return TraceEntryInterface|false
     */
    public function entry(array $traceLine);

    /**
     * @param $versionHeader
     * @return bool
     */
    public function isSupportedVersion($versionHeader);

    /**
     * @param $fileFormatHeader
     * @return bool
     */
    public function isSupportedFileFormat($fileFormatHeader);
}