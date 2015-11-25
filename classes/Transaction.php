<?php
require_once 'Memory.php';

/**
 * This class handles the main operations of the service
 *
 * @author Safaa AlNabulsi
 */
class Transaction
{

    /**
     * @var douple
     * a double specifying the amount
     */
    public $id;

    /**
     * @var douple
     * a double specifying the amount
     */
    public $amount;

    /**
     * @var string
     * a string specifying a type of the transaction
     */
    public $type;

    /**
     * @var long
     * an optional long that may specify the parent transaction of this transaction
     */
    public $parent_id;

    /**
     * @var Memory
     * object from class memory to save all values inside
     */
    private $memory;

    /**
     * Construct adds New Transaction to memory
     *
     * @param string $id is a long specifying a new transaction
     * @param string $amount is a double specifying the amount{@from body}
     * @param string $type is a string specifying a type of the transaction.{@from body}
     * @param string $parent_id is an optional long that may specify the parent transaction of this transaction.{@from body}
     *
     */
    function __construct($id = null, $amount = null, $type = null, $parent_id = null)
    {
        $this->id = $id;
        $this->amount = $amount;
        $this->type = $type;
        $this->parent_id = $parent_id;
        $this->memory = new Memory('Transactions');
        if ($this->id != null) {
            $this->memory->save($id, $this);
        }
    }

    /**
     * Get Transaction By Id from cache memory
     *
     * @param string $id is a long specifying a new transaction
     *
     * @return Transaction object
     */
    public function getById($id)
    {
        return $this->memory->fetch($id);
    }

    /**
     * Get a json list of all transaction ids that share the same given type
     *
     * @param string $id is a long specifying a new transaction
     *
     * @return array
     */
    public function getAllByType($type)
    {
        return $this->memory->fetchAllByAttribute('type', $type, 'id');
    }

    /**
     * Sum all Child Transactions related to one parent
     *
     * @param string $id is a long specifying a new transaction
     *
     * @return double sum value
     */
    public function getSumOfChildren($id)
    {
        $transactions = $this->memory->fetchAllByAttribute('parent_id', $id, 'amount');
        return array_sum($transactions);
    }

}