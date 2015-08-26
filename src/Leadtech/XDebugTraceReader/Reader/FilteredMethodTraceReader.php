<?php

namespace Leadtech\XDebugTraceReader\Reader;

use Leadtech\XDebugTraceReader\Trace\TraceEntryInterface;

/**
 * Class FilteredMethodTraceReader
 * @package Leadtech\XDebugTraceReader\Reader
 */
class FilteredMethodTraceReader extends AbstractFilteredTraceStreamReader
{

    /**
     * @param TraceEntryInterface $entry
     * @return bool
     */
    public function acceptLevel(TraceEntryInterface $entry)
    {
        // Accept only user defined functions or methods (both user defined and internal)
        return $entry->isUserDefined() || !$entry->isFunctionCall();
    }
}