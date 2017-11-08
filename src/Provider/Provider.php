<?php
/**
 * SQL database management to be used by several providers at the same time.
 *
 * @author    Josantonius <hello@josantonius.com>
 * @copyright 2017 (c) Josantonius - PHP-Database
 * @license   https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link      https://github.com/Josantonius/PHP-Database
 * @since     1.0.0
 */
namespace Josantonius\Database\Provider;

/**
 * Provider handler.
 *
 * @since 1.0.0
 */
abstract class Provider
{
    /**
     * Internally store the connection object.
     *
     * @since 1.0.0
     *
     * @var object
     */
    protected $conn;

    /**
     * Error messages.
     *
     * @since 1.0.0
     *
     * @var string
     */
    protected $error = '';

    /**
     * Database connection.
     *
     * @since 1.0.0
     */
    abstract public function connect($host, $dbUser, $dbName, $pass, $settings = []);

    /**
     * Run database queries.
     *
     * @since 1.0.0
     */
    abstract public function query($query, $type);

    /**
     * Execute prepared queries.
     *
     * @since 1.0.0
     */
    abstract public function statements($query, $statements);

    /**
     * Create table statement.
     *
     * @since 1.0.0
     */
    abstract public function create($table, $data, $foreing, $reference, $on, $actions, $engine, $charset);

    /**
     * Select into statement.
     *
     * @since 1.0.0
     */
    abstract public function select($columns, $from, $where, $order, $limit, $statements);

    /**
     * Insert into statement.
     *
     * @since 1.0.0
     */
    abstract public function insert($table, $data, $statements);

    /**
     * Update statement.
     *
     * @since 1.0.0
     */
    abstract public function update($table, $data, $statements, $where);

    /**
     * Delete statement.
     *
     * @since 1.0.0
     */
    abstract public function delete($table, $statements, $where);

    /**
     * Truncate table statement.
     *
     * @since 1.0.0
     */
    abstract public function truncate($table);

    /**
     * Drop table statement.
     *
     * @since 1.0.0
     */
    abstract public function drop($table);

    /**
     * Process query as object or numeric or associative array.
     *
     * @since 1.0.0
     */
    abstract public function fetchResponse($response, $result);

    /**
     * Get the last id of the query object.
     *
     * @since 1.0.0
     */
    abstract public function lastInsertId();

    /**
     * Get rows number.
     *
     * @since 1.0.0
     */
    abstract public function rowCount($response);

    /**
     * Get errors.
     *
     * @since 1.0.0
     */
    abstract public function getError();

    /**
     * Check database connection state.
     *
     * @since 1.0.0
     */
    abstract public function isConnected();

    /**
     * Close/delete database connection.
     *
     * @since 1.0.0
     */
    abstract public function kill();
}
