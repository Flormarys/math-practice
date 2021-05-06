<?php
/**
 * @author  Flormarys Diaz <flormarysdiaz@gmail.com>
 * @license GPLv3 (or any later version)
 * PHP 7.4.16
 */

namespace MathPractice;

class Variable
{

    const TIME_TYPE = 'Time';
    const MINUTES_TYPE = 'Minutes';
    private $value;

    public function __construct(int $value)
    {
        $this->value = intval($value / 60);
    }

    public function getValue(string $string = '')
    {
        if($string == self::TIME_TYPE) {
            $stringValue = date("g:i A", ($this->value * 60));
            return $stringValue;
        }
        return $this->value;
    }

    public function addition(self $variable) : self
    {
        $toAdd = date('i', $variable->getValue() * 60);
        $resultToReturn = $this->value + intval($toAdd);
        return new self($resultToReturn * 60);
    }

    public function substraction(self $variable, string $valueType) : self
    {
        if($valueType == self::TIME_TYPE) {
            $toAdd = date('i', $this->value * 60);
            $resultToReturn = $variable->getValue() - intval($toAdd);
        } else {
            $resultToReturn = $this->value - $variable->getValue();
        }
        return new self($resultToReturn * 60);
    }

}

?>
