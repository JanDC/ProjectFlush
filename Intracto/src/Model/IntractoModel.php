<?php
/**
 * Created by PhpStorm.
 * User: jan.decavele
 * Date: 4/11/14
 * Time: 2:06 PM
 */

namespace Intracto\Model;

/**
 * Class IntractoModel
 *
 * The intractomodel implements various elements to make data persistance by @IntractoRepository easier:
 *  - getModelName(): this is the unique identifier of the entity, also the table name
 *  - contructor: constructs an object using an associative array (=hydration)
 *  - toArray(): this function reverts the construct process, returning an array containing the enity's properties (=dehydration)
 *  - getFields() : defines the fields to be persisted by @IntractoRepository, also used by toArray().
 *  - getForeignKeys() : defines the foreign keys to be executed on the entity's table
 *
 * @package Intracto\Model
 */
abstract class IntractoModel
{
    public function __construct(array $dataArray = array())
    {

        foreach ($dataArray as $dataArrayKey => $dataArrayLine) {
            $setterString = 'set' . $this->camelcase($dataArrayKey);
            if (method_exists($this, $setterString)) {
                $this->$setterString($dataArrayLine);
            } else {
                //nothing to do
            }
        }
    }

    public function toArray($stripFields = false)
    {
        $array = array();
        $fields = $this::getFields();
        $fields[] = array('`id`', 'id');
        foreach ($fields as $field) {
            $fieldName = current($field);
            if ($stripFields) {
                $fieldName = trim($fieldName, '`');
            }
            $fieldNameCCased = $this->camelcase($fieldName);
            $getterString = 'get' . $fieldNameCCased;
            if (method_exists($this, $getterString)) {
                if (is_object($this->$getterString()) && get_class($this->$getterString()) == "DateTime") {
                    $array[$fieldName] = $this->$getterString()->format("Y-m-d H:i:s");
                } else {
                    $array[$fieldName] = $this->$getterString();
                }
            } else {
                //   $array[$fieldName] = '';
            }
        }

        return $array;
    }

    /**
     * Helperfunction to convert fields to functions
     *
     * @param $string
     * @return mixed|string
     */
    private function camelcase($string)
    {
        $string = trim($string, '`');

        $firstChar = substr($string, 0, 1);
        $string = strtoupper($firstChar) . substr($string, 1);
        while (strpos($string, '_') > 0) {
            $usPos = strpos($string, '_');
            $nextChar = substr($string, $usPos + 1, 1);
            $string = str_replace('_' . $nextChar, strtoupper($nextChar), $string);
        }

        return $string;
    }

    static function getForeignKeys()
    {
    }

    static function getFields()
    {
    }

    static function getModelName()
    {
    }
}