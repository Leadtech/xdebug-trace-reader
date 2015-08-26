<?php

namespace Leadtech\XDebugTraceReader\Reader;

use Leadtech\XDebugTraceReader\Trace\TraceEntryInterface;

/**
 * Class AbstractFilteredTraceReader
 * @package Leadtech\XDebugTraceReader\Reader
 */
abstract class AbstractFilteredTraceStreamReader extends TraceStreamReader
{
    /** @var int */
    protected $previousLevel = null;

    /** @var bool  */
    protected $exitEntriesSkipped = false;

    /**
     * @param TraceEntryInterface $entry
     * @return bool
     */
    abstract public function acceptLevel(TraceEntryInterface $entry);

    /**
     * @return bool
     */
    public function read()
    {

        // Read next line
        if ($entry = parent::read()) {

            if($entry->isValid()) {

                // Skip so called "exit" entries.
                while ($entry->isEntryExit() && $this->isExitEntriesSkipped()) {
                    $entry = parent::read();
                }

                // Check if the level changed
                $levelChanged = $this->previousLevel !== $entry->getEntryLevel();

                // Check if the entry is accepted
                if ($levelChanged && !$this->acceptLevel($entry)) {

                    // Entry not accepted. We can skip all underlying function calls
                    if($levelChanged && $this->previousLevel < $entry->getEntryLevel()) {

                        // Skip all lines until we're back on the the "previous" level
                        $entry = $this->skipLevelUntil($this->previousLevel);

                    }

                }

                // Check if we have a valid entry
                if($entry) {

                    // Update previous level
                    $this->previousLevel = $entry->getEntryLevel();

                    return $entry;

                }

            }

        }

        return false;
    }

    /**
     * @param int $entryLevel
     *
     * @return TraceEntryInterface|false
     */
    protected function skipLevelUntil($entryLevel)
    {
        while ($entry = parent::read()) {
            if($entry->getEntryLevel() === $entryLevel) {
                return $entry;
            }
        }

        return false;
    }

    /**
     * @return boolean
     */
    public function isExitEntriesSkipped()
    {
        return $this->exitEntriesSkipped;
    }

    /**
     * @param boolean $exitEntriesSkipped
     */
    public function setExitEntriesSkipped($exitEntriesSkipped)
    {
        $this->exitEntriesSkipped = $exitEntriesSkipped;
    }


}