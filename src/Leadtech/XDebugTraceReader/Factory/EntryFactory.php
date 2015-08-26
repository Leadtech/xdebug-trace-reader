<?php
namespace Leadtech\XDebugTraceReader\Factory;

use Leadtech\XDebugTraceReader\Trace\TraceEntry;
use Leadtech\XDebugTraceReader\Trace\TraceEntryInterface;
use Leadtech\XDebugTraceReader\Trace\TraceExitEntry;
use Leadtech\XDebugTraceReader\Trace\TraceReturnEntry;

/**
 * Class TraceEntryFactory
 * @package Leadtech\XDebugTraceReader\Factory
 */
class EntryFactory implements EntryFactoryInterface
{
    /**
     * Create trace object.
     *
     * Below is the generic data structure of each line in the xdebug trace file:
     *
     * --------------------------------------------------------------------------
     * ColumnIdx  |   Description:
     * -----------|--------------------------------------------------------------
     * #0            Entry level
     * #1            Function ID  (Function ID per trace file. If the same function reoccurs than the ID is reused.)
     * #2            Type (0 = entry, 1 = exit entry, R = return entry)
     * #3            Time index
     * #4            Memory usage
     * #5            Function name
     * #6            User-defined (1) or internal (0)
     * #7            Name of the included file
     * #8            Filename
     * #9            Line number
     * #10           Number of parameters
     * #11           parameter x (as many as defined in number of parameters)
     * #12           parameter x (as many as defined in number of parameters)
     *
     * @param array $traceLine
     * @return TraceEntryInterface
     */
    public function entry(array $traceLine)
    {
        // Create object
        if($entry = new TraceEntry($traceLine)) {

            // Iterate raw columns
            foreach($traceLine as $columnIdx => $value) {

                // Set properties from raw column values
                switch($columnIdx) {

                    case self::COLUMN_ENTRY_LEVEL:        $entry->setEntryLevel((int) $value);           break;
                    case self::COLUMN_FUNCTION_ID:        $entry->setFunctionId((int) $value);           break;
                    case self::COLUMN_ENTRY_TYPE:         $entry->setType((string)$value);               break;
                    case self::COLUMN_TIME_INDEX:         $entry->setTimeIndex((float) $value);          break;
                    case self::COLUMN_MEMORY_USAGE:       $entry->setMemoryUsage((int) $value);          break;
                    case self::COLUMN_FUNCTION_NAME:      $entry->setFunctionName((string) $value);      break;
                    case self::COLUMN_USER_DEFINED:       $entry->setUserDefined((bool) $value);         break;
                    case self::COLUMN_INCLUDED_FILENAME:  $entry->setIncludedFilename((string) $value);  break;
                    case self::COLUMN_FILENAME:           $entry->setFilename((string) $value);          break;
                    case self::COLUMN_LINE_NUMBER:        $entry->setLineNumber((int) $value);           break;
                    case self::COLUMN_PARAMETER_COUNT:    $entry->setParameterCount((int) $value);       break;

                    default:

                        // Additional entries are any number of parameters as defined in in the parameter count column.
                        // The value of each parameter will be its type e.g.  string(23)
                        $entry->addParameter($value);

                }

            }

            // Return entry
            return $entry;
        }

        return false;
    }

    /**
     * @param $versionHeader
     * @return bool
     */
    public function isSupportedVersion($versionHeader)
    {
        return (bool) preg_match('/Version: 2.*/', $versionHeader);
    }

    /**
     * @param $fileFormatHeader
     * @return bool
     */
    public function isSupportedFileFormat($fileFormatHeader)
    {
        return (bool) preg_match('/File format: [2-4]/', $fileFormatHeader);
    }

}