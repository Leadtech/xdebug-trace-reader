<?php
namespace Leadtech\XDebugTraceReader\Trace;

/**
 * Class TraceEntry
 * @package Leadtech\XDebugTraceReader\Trace
 */
class TraceEntry implements TraceEntryInterface
{
    /** @var  int */
    protected $entryLevel;

    /** @var  int  A reference to a function somewhere in the trace file.*/
    protected $functionId;

    /** @var  string  ( 0 = entry, 1 = entry exit, R = entry return) */
    protected $type;

    /** @var  float  e.g. 0.001282 */
    protected $timeIndex;

    /** @var  int    e.g. 351368  */
    protected $memoryUsage;

    /** @var  string e.g. file_exists, FilesystemIterator->current or SomeFactory::getLoader*/
    protected $functionName;

    /** @var  bool */
    protected $userDefined = true;

    /** @var  string */
    protected $includedFilename;

    /** @var  string e.g. /var/www/someproject/src/blaat/file.php */
    protected $filename;

    /** @var int */
    protected $lineNumber;

    /** @var int */
    protected $parameterCount;

    /** @var string[]  e.g. [string(56), string(2), bool] */
    protected $parameters = [];

    /**
     * @return bool
     */
    public function isFunctionCall()
    {
        return !preg_match('/.*((->)|(::)).*/', $this->functionName);
    }

    /**
     * @return bool
     */
    public function isMethodCall()
    {
        return (bool) preg_match('/.*->.*/', $this->functionName);
    }

    /**
     * @return bool
     */
    public function isStaticMethodCall()
    {
        return (bool) preg_match('/.*::.*/', $this->functionName);
    }

    /**
     * Get the invoked method name. (only for (static-) method calls)
     */
    public function getInvokedMethodName()
    {
        if($methodNameParts = $this->getMethodNameParts()) {
            return array_pop($methodNameParts);
        }

        return false;
    }

    /**
     * Get the invoked class name. (only for (static-) method calls)
     *
     * @return string|false
     */
    public function getClassName()
    {
        if($methodNameParts = $this->getMethodNameParts()) {
            return array_shift($methodNameParts);
        }

        return false;
    }

    /**
     * @return bool|array
     */
    protected function getMethodNameParts()
    {
        if( !$this->isFunctionCall()) {
            $operator = ($this->isStaticMethodCall()) ? '::' : '->';
            return explode(
                $operator,
                $this->getFunctionName()
            );
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isEntry()
    {
        return $this->type === '0';
    }

    /**
     * @return bool
     */
    public function isEntryReturn()
    {
        return $this->type === 'R';
    }

    /**
     * @return bool
     */
    public function isEntryExit()
    {
        return $this->type === '1';
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        // Any valid entry will have a type of either 0, 1 or R.
        return in_array($this->type, [0, 1, 'R']);
    }

    /**
     * @return int
     */
    public function getEntryLevel()
    {
        return $this->entryLevel;
    }

    /**
     * @return int
     */
    public function getFunctionId()
    {
        return $this->functionId;
    }

    /**
     * @return float
     */
    public function getTimeIndex()
    {
        return $this->timeIndex;
    }

    /**
     * @return int
     */
    public function getMemoryUsage()
    {
        return $this->memoryUsage;
    }

    /**
     * @return string
     */
    public function getFunctionName()
    {
        return $this->functionName;
    }

    /**
     * @return boolean
     */
    public function isUserDefined()
    {
        return $this->userDefined;
    }

    /**
     * @return string
     */
    public function getIncludedFilename()
    {
        return $this->includedFilename;
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @return int
     */
    public function getLineNumber()
    {
        return $this->lineNumber;
    }

    /**
     * @return int
     */
    public function getParameterCount()
    {
        return $this->parameterCount;
    }

    /**
     * @return \string[]
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param int $entryLevel
     */
    public function setEntryLevel($entryLevel)
    {
        $this->entryLevel = $entryLevel;
    }

    /**
     * @param int $functionId
     */
    public function setFunctionId($functionId)
    {
        $this->functionId = $functionId;
    }

    /**
     * @param float $timeIndex
     */
    public function setTimeIndex($timeIndex)
    {
        $this->timeIndex = $timeIndex;
    }

    /**
     * @param int $memoryUsage
     */
    public function setMemoryUsage($memoryUsage)
    {
        $this->memoryUsage = $memoryUsage;
    }

    /**
     * @param string $functionName
     */
    public function setFunctionName($functionName)
    {
        $this->functionName = $functionName;
    }

    /**
     * @param boolean $userDefined
     */
    public function setUserDefined($userDefined)
    {
        $this->userDefined = $userDefined;
    }

    /**
     * @param string $includedFilename
     */
    public function setIncludedFilename($includedFilename)
    {
        $this->includedFilename = $includedFilename;
    }

    /**
     * @param string $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @param int $lineNumber
     */
    public function setLineNumber($lineNumber)
    {
        $this->lineNumber = $lineNumber;
    }

    /**
     * @param int $parameterCount
     */
    public function setParameterCount($parameterCount)
    {
        $this->parameterCount = $parameterCount;
    }

    /**
     * @param string[] $parameters
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * @param $parameter
     */
    public function addParameter($parameter)
    {
        $this->parameters[] = $parameter;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

}