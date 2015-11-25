<?php

/**
 * This class handles memory operations
 *
 * @author Safaa AlNabulsi
 */
class Memory
{

    /**
     * @var string
     * holds the name of the array we want to store in session
     */
    private $arrayName;
    /**
     * @var $_SESSION
     * holds the session variable
     */
    private $session;

    function __construct($arrayName)
    {        
        $this->arrayName = $arrayName;
        if (session_id() == '') {
            session_start();
            if (!isset($_SESSION[$this->arrayName])) {
                $_SESSION[$this->arrayName] = array();
            }
            $this->session = $_SESSION[$this->arrayName];
        }
    }   

    /**
     * Save value By key in memory
     *
     * @param string $key is a key we get the value with
     * @param string $obj value we want to save
     *
     */
    public function save($key, $obj)
    {
        array_push($this->session, array( 'key' => $key,'value' => serialize($obj)));
        $_SESSION[$this->arrayName] = $this->session;
    }

    /**
     * delete value By key from memory
     *
     * @param string $key is a key we get the value with
     *
     */
    public function delete($key)
    {
        unset($this->session[$key]);
    }

    /**
     * Get value By key from memory
     *
     * @param string $key is a key we get the value with
     *
     * @return value
     */
    public function fetch($key)
    {
        return $this->fetchByAttribute($key);
    }

    /**
     * Get all values from memory
     *
     * @return array of values
     */
    public function fetchAll()
    {
        return $this->session;
    }

    /**
     * Get array of retrieved attributes from memory by attribute from memory
     *
     * @param string $attrName is a attribute name
     * @param string $attrValue is a attribute value
     * @param string $retrievedAttr is a retrieved attribute Name
     *
     * @return array of retrieved attributes from all object
     */
    public function fetchAllByAttribute($attrName, $attrValue, $retrievedAttr)
    {
        $result = array();
        foreach ($this->session as $hash => $obj) {
            $key = $obj['key'];
            $value = unserialize($obj['value']);
            if ($value->$attrName == $attrValue) {
                $result[] = $value->$retrievedAttr;
            }
        }

        return $result;
    }

    /**
     * Get object from memory by key from memory
     *
     * @param string $attrKey the key we want to retrieve its object
     *
     * @return object
     */
    private function fetchByAttribute($attrKey)
    {
        $result = null;
        foreach ($this->session as $hash => $obj) {
            $key = $obj['key'];
            $value = unserialize($obj['value']);
            if ($attrKey == $key) {
                $result = $value;
            }
        }

        return $result;
    }

}