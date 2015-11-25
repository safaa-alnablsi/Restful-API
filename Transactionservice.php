<?php

/**
 * This class holds the service endpoints
 *
 * @author Safaa AlNabulsi
 */
class Transactionservice
{

    /**
     * Add New Transaction
     *
     * Add New Transaction to cache memory
     *
     * @param string $transaction_id is a long specifying a new transaction
     * @param string $amount is a double specifying the amount{@from body}
     * @param string $type is a string specifying a type of the transaction.{@from body}
     * @param string $parent_id is an optional long that may specify the parent transaction of this transaction.{@from body}
     *
     * @url PUT /transaction/{transaction_id}
     */
    function addTransaction($transaction_id, $amount, $type, $parent_id)
    {
        $trans = new Transaction($transaction_id, $amount, $type, $parent_id);
        if ($trans != null) {
            return array('status' => 'ok');
        }

        return array('status' => 'fail');
    }

    /**
     * Get  Transaction
     *
     * Get Transaction By Id from cache memory
     *
     * @param string $transaction_id is a long specifying a transaction
     *
     * @url GET /transaction/{transaction_id}
     */
    function getTransaction($transaction_id)
    {
        $trans = new Transaction();
        $trans = $trans->getById($transaction_id);
        if ($trans != null) {
            return $trans;
        }

        return array('status' => 'fail');
    }


    /**
     * Get all Transactions ids with same type
     *
     * Get a json list of all transaction ids that share the same given type
     *
     * @param string $type is a string specifying a type of the transaction.
     *
     * @url GET /types/{type}
     */
    function getTypes($type)
    {
        $trans = new Transaction();
        $trans = $trans->getAllByType($type);
        if ($trans != null) {
            return $trans;
        }

        return array('status' => 'fail');
    }

    /**
     * Sum all Child Transactions
     *
     * Sum all Child Transactions related to one parent
     *
     * @param string $transaction_id is a long specifying a transaction
     *
     * @url GET /sum/{transaction_id}
     */
    function getSum($transaction_id)
    {
        $trans = new Transaction();
        $sum = $trans->getSumOfChildren($transaction_id);
        if ($sum != 0) {
            return $sum;
        }

        return array('status' => 'fail');
    }
}

