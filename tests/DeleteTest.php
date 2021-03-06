<?php
/**
 * SQL database management to be used by several providers at the same time.
 *
 * @author    Josantonius <hello@josantonius.com>
 * @copyright 2017 - 2018 (c) Josantonius - PHP-Database
 * @license   https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link      https://github.com/Josantonius/PHP-Database
 * @since     1.1.6
 */
namespace Josantonius\Database;

use PHPUnit\Framework\TestCase;

/**
 * Test class for "DELETE" query.
 */
final class DeleteTest extends TestCase
{
    /**
     * Database instance.
     *
     * @since 1.1.7
     *
     * @var object
     */
    private $db;

    /**
     * Setup.
     *
     * @since 1.1.7
     */
    public function setUp()
    {
        parent::setUp();

        $this->db = Database::getConnection(
            'identifier',
            'PDOprovider',
            $GLOBALS['DB_HOST'],
            $GLOBALS['DB_USER'],
            $GLOBALS['DB_NAME'],
            $GLOBALS['DB_PASSWORD'],
            ['charset' => 'utf8']
        );
    }

    /**
     * [QUERY] [WHERE SIMPLE] [ROWS AFFECTED NUMBER]
     */
    public function testQueryReturnRows()
    {
        $result = $this->db->query(
            'DELETE
             FROM  test_table
             WHERE id = 1'
        );

        $this->assertSame(1, $result);
    }

    /**
     * [QUERY] [STATEMENTS] [WHERE SIMPLE] [ROWS AFFECTED NUMBER]
     */
    public function testQueryStatementsWhereReturnRows()
    {
        $statements[] = [':id', 2];

        $result = $this->db->query(
            'DELETE
             FROM  test_table
             WHERE id = :id',
            $statements
        );

        $this->assertSame(1, $result);
    }

    /**
     * [QUERY] [STATEMENTS] [WHERE MULTIPLE] [ROWS AFFECTED NUMBER]
     */
    public function testQueryStatementsWhereMultipleReturnRows()
    {
        $statements[] = [':id', 3];
        $statements[] = [':name', 'isis'];

        $result = $this->db->query(
            'DELETE
             FROM  test_table
             WHERE id = :id AND name = :name',
            $statements
        );

        $this->assertSame(1, $result);
    }

    /**
     * [QUERY] [MARKS STATEMENTS] [WHERE SIMPLE] [ROWS AFFECTED]
     */
    public function testQueryMarksStatementsWhereReturnRows()
    {
        $statements[] = [1, 3008];
        $statements[] = [2, 'isis'];

        $result = $this->db->query(
            'DELETE
             FROM  test_table
             WHERE id = ? AND name = ?',
            $statements
        );

        $this->assertSame(1, $result);
    }

    /**
     * [QUERY] [MARKS STATEMENTS] [WHERE SIMPLE] [DATA TYPE] [ROWS]
     */
    public function testQueryMarksStatementsWhereDataTypeReturnRows()
    {
        $statements[] = [1, 3009, 'int'];
        $statements[] = [2, 'isis', 'str'];

        $result = $this->db->query(
            'DELETE
             FROM  test_table
             WHERE id = ? AND name = ?',
            $statements
        );

        $this->assertSame(1, $result);
    }

    /**
     * [QUERY] [EXCEPTION]
     *
     * @expectedException \Josantonius\Database\Exception\DBException
     *
     * @expectedExceptionMessageRegExp (table|view|not|found|exist|Table)
     */
    public function testQueryTableNameErrorException()
    {
        $result = $this->db->query('DELETE FROM xxxx');
    }

    /**
     * [QUERY] [EXCEPTION]
     *
     * @expectedException \Josantonius\Database\Exception\DBException
     *
     * @expectedExceptionMessageRegExp (Column|not|found|Unknown|column)
     */
    public function testQueryColumnNameErrorException()
    {
        $result = $this->db->query(
            'DELETE
             FROM  test_table
             WHERE xxx = 1'
        );
    }

    /**
     * [METHOD] [WHERE SIMPLE] [ROWS AFFECTED NUMBER]
     */
    public function testMethodWhereReturnRows()
    {
        $query = $this->db->delete()
                          ->from('test_table')
                          ->where('id = 4883');

        $result = $query->execute();

        $this->assertSame(1, $result);
    }

    /**
     * [METHOD] [WHERE MULTIPLE] [ROWS AFFECTED NUMBER]
     */
    public function testMethodWhereReturnsRows()
    {
        $clauses = [
            'id = 4884',
            'name  = "isis"',
            'email = "isis@email.com"',
        ];

        $query = $this->db->delete()
                          ->from('test_table')
                          ->where($clauses);

        $result = $query->execute();

        $this->assertSame(1, $result);
    }

    /**
     * [METHOD] [STATEMENTS] [WHERE ADVANCED] [ROWS AFFECTED NUMBER]
     */
    public function testMethodStatementsWhereAdvancedReturnRows()
    {
        $clauses = 'id = :id AND name = :name1 OR name = :name2';

        $statements[] = [':id', 4885];
        $statements[] = [':name1', 'Isis'];
        $statements[] = [':name2', 'Manny'];

        $query = $this->db->delete()
                          ->from('test_table')
                          ->where($clauses, $statements);

        $result = $query->execute();

        $this->assertSame(1, $result);
    }

    /**
     * [METHOD] [STATEMENTS] [DATA-TYPE] [WHERE ADVANCED] [ROWS]
     */
    public function testMethodStatementsDataTypeWhereAdvancedRows()
    {
        $clauses = 'id = :id AND name = :name1 OR name = :name2';

        $statements[] = [':id', 4886, 'int'];
        $statements[] = [':name1', 'Isis', 'src'];
        $statements[] = [':name2', 'Manny', 'src'];

        $query = $this->db->delete()
                          ->from('test_table')
                          ->where($clauses, $statements);

        $result = $query->execute();

        $this->assertSame(1, $result);
    }

    /**
     * [METHOD] [MARKS STATEMENTS] [WHERE ADVANCED] [ROWS AFFECTED]
     */
    public function testMethodMarksStatementsWhereAdvancedReturnRows()
    {
        $clauses = 'id = ? AND name = ? OR name = ?';

        $statements[] = [1, 4887];
        $statements[] = [2, 'Isis'];
        $statements[] = [3, 'Manny'];

        $query = $this->db->delete()
                          ->from('test_table')
                          ->where($clauses, $statements);

        $result = $query->execute();

        $this->assertSame(1, $result);
    }

    /**
     * [METHOD] [MARKS STATEMENTS] [DATA-TYPE] [WHERE ADVANCED] [ROWS]
     */
    public function testMethodMarksStatementsDataTypeWhereAdvanced()
    {
        $clauses = 'id = ? AND name = ? OR name = ?';

        $statements[] = [1, 4888, 'int'];
        $statements[] = [2, 'Isis', 'str'];
        $statements[] = [3, 'Manny', 'str'];

        $query = $this->db->delete()
                          ->from('test_table')
                          ->where($clauses, $statements);

        $result = $query->execute();

        $this->assertSame(1, $result);
    }

    /**
     * [METHOD] [EXCEPTION]
     *
     * @expectedException \Josantonius\Database\Exception\DBException
     *
     * @expectedExceptionMessageRegExp (table|view|not|found|exist|Table)
     */
    public function testMethodTableNameErrorException()
    {
        $query = $this->db->delete()
                          ->from('xxxx');

        $result = $query->execute();
    }

    /**
     * [METHOD] [EXCEPTION]
     *
     * @expectedException \Josantonius\Database\Exception\DBException
     *
     * @expectedExceptionMessageRegExp (Column|not|found|Unknown|column)
     */
    public function testMethodColumnNameErrorException()
    {
        $query = $this->db->delete()
                          ->from('test_table')
                          ->where('xxx = 1');

        $result = $query->execute();
    }

    /**
     * [METHOD] [ALL ROWS] [ROWS AFFECTED NUMBER]
     */
    public function testDeleteAllMethodReturnRows()
    {
        $query = $this->db->delete()
                          ->from('test_table');

        $result = $query->execute();

        $this->assertSame(2, $result);
    }

    /**
     * [QUERY] [ALL ROWS] [ROWS AFFECTED NUMBER]
     */
    public function testDeleteAllQueryReturnRows()
    {
        $result = $this->db->query('DELETE FROM test_table');

        $this->assertSame(0, $result);
    }
}
