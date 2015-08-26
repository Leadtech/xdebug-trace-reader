<?php
namespace Leadtech\XDebugTraceReader\Trace;

/**
 * Interface TraceEntryInterface
 * @package Leadtech\XDebugTraceReader\Trace
 */
interface TraceEntryInterface
{
    /**
     * @return bool
     */
    public function isValid();

    /**
     * @return bool
     */
    public function isFunctionCall();

    /**
     * @return bool
     */
    public function isMethodCall();

    /**
     * @return bool
     */
    public function isStaticMethodCall();

    /**
     * Get the invoked method name. (only for (static-) method calls)
     */
    public function getInvokedMethodName();

    /**
     * Get the invoked class name. (only for (static-) method calls)
     *
     * @return string|false
     */
    public function getClassName();

    /**
     * @return bool
     */
    public function isEntry();

    /**
     * @return bool
     */
    public function isEntryReturn();

    /**
     * @return bool
     */
    public function isEntryExit();

    /**
     * @return int
     */
    public function getEntryLevel();

    /**
     * @return int
     */
    public function getFunctionId();

    /**
     * @return float
     */
    public function getTimeIndex();

    /**
     * @return int
     */
    public function getMemoryUsage();

    /**
     * @return string
     */
    public function getFunctionName();

    /**
     * @return boolean
     */
    public function isUserDefined();

    /**
     * @return string
     */
    public function getIncludedFilename();

    /**
     * @return string
     */
    public function getFilename();

    /**
     * @return int
     */
    public function getLineNumber();

    /**
     * @return int
     */
    public function getParameterCount();

    /**
     * @return \string[]
     */
    public function getParameters();

    /**
     * @return string
     */
    public function getType();

    /**
     * @param int $entryLevel
     */
    public function setEntryLevel($entryLevel);

    /**
     * @param int $functionId
     */
    public function setFunctionId($functionId);

    /**
     * @param float $timeIndex
     */
    public function setTimeIndex($timeIndex);

    /**
     * @param int $memoryUsage
     */
    public function setMemoryUsage($memoryUsage);

    /**
     * @param string $functionName
     */
    public function setFunctionName($functionName);

    /**
     * @param boolean $userDefined
     */
    public function setUserDefined($userDefined);

    /**
     * @param string $includedFilename
     */
    public function setIncludedFilename($includedFilename);

    /**
     * @param string $filename
     */
    public function setFilename($filename);

    /**
     * @param int $lineNumber
     */
    public function setLineNumber($lineNumber);

    /**
     * @param int $parameterCount
     */
    public function setParameterCount($parameterCount);

    /**
     * @param string[] $parameters
     */
    public function setParameters(array $parameters);

    /**
     * @param string $parameter
     */
    public function addParameter($parameter);

    /**
     * @param string $type
     */
    public function setType($type);

}