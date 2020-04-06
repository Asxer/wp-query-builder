<?php

use TenQuality\WP\Database\QueryBuilder;
use PHPUnit\Framework\TestCase;

/**
 * Test.
 *
 * @author Local Vibes <https://localvibes.co/> Hyper Tribal
 * @author 10 Quality <info@10quality.com>
 * @license MIT
 * @package wp-query-builder
 * @version 1.0.8
 */
class QueryBuilderStatementsTest extends TestCase
{
    /**
     * Test query builder
     * @since 1.0.0
     * @group query
     * @group building
     */
    public function testSelectStatement()
    {
        // Preapre
        global $wpdb;
        $builder = QueryBuilder::create( 'test' );
        // Prepare
        $builder->select( 'test_field' )->get();
        // Assert
        $this->assertEquals(
            'SELECT test_field FROM ',
            $wpdb->get_query()
        );
    }
    /**
     * Test query builder
     * @since 1.0.0
     * @group query
     * @group building
     */
    public function testFromStatement()
    {
        // Preapre
        global $wpdb;
        $builder = QueryBuilder::create( 'test' );
        // Prepare
        $builder->select( 'test_field' )
            ->from( 'test_table' )->get();
        // Assert
        $this->assertEquals(
            'SELECT test_field FROM prefix_test_table',
            $wpdb->get_query()
        );
    }
    /**
     * Test query builder
     * @since 1.0.0
     * @group query
     * @group building
     */
    public function testFromNoPrefixStatement()
    {
        // Preapre
        global $wpdb;
        $builder = QueryBuilder::create( 'test' );
        // Prepare
        $builder->select( 'test_field' )
            ->from( 'test_table', false )->get();
        // Assert
        $this->assertEquals(
            'SELECT test_field FROM test_table',
            $wpdb->get_query()
        );
    }
    /**
     * Test query builder
     * @since 1.0.0
     * @group query
     * @group building
     */
    public function testWhereStatement()
    {
        // Preapre
        global $wpdb;
        $builder = QueryBuilder::create( 'test' );
        // Prepare
        $builder->select( '*' )
            ->from( 'test_table' )
            ->where([ 'test_field' => 1 ])
            ->get();
        // Assert
        $this->assertEquals(
            'SELECT * FROM prefix_test_table WHERE test_field = %d',
            $wpdb->get_query()
        );
    }
    /**
     * Test query builder
     * @since 1.0.0
     * @group query
     * @group building
     */
    public function testWhereNullStatement()
    {
        // Preapre
        global $wpdb;
        $builder = QueryBuilder::create( 'test' );
        // Prepare
        $builder->select( '*' )
            ->from( 'test_table' )
            ->where([ 'test_field' => null ])
            ->get();
        // Assert
        $this->assertEquals(
            'SELECT * FROM prefix_test_table WHERE test_field is null',
            $wpdb->get_query()
        );
    }
    /**
     * Test query builder
     * @since 1.0.0
     * @group query
     * @group building
     */
    public function testWhereOperatorStatement()
    {
        // Preapre
        global $wpdb;
        $builder = QueryBuilder::create( 'test' );
        // Prepare
        $builder->select( '*' )
            ->from( 'test_table' )
            ->where([ 'test_field' => ['operator' => '<>', 'value' => 1 ]])
            ->get();
        // Assert
        $this->assertEquals(
            'SELECT * FROM prefix_test_table WHERE test_field <> %d',
            $wpdb->get_query()
        );
    }
    /**
     * Test query builder
     * @since 1.0.0
     * @group query
     * @group building
     */
    public function testWhereNotNullStatement()
    {
        // Preapre
        global $wpdb;
        $builder = QueryBuilder::create( 'test' );
        // Prepare
        $builder->select( '*' )
            ->from( 'test_table' )
            ->where([ 'test_field' => ['operator' => 'IS NOT', 'value' => null ]])
            ->get();
        // Assert
        $this->assertEquals(
            'SELECT * FROM prefix_test_table WHERE test_field IS NOT null',
            $wpdb->get_query()
        );
    }
    /**
     * Test query builder
     * @since 1.0.0
     * @group query
     * @group building
     */
    public function testWhereMultipleStatement()
    {
        // Preapre
        global $wpdb;
        $builder = QueryBuilder::create( 'test' );
        // Prepare
        $builder->select( '*' )
            ->from( 'test_table' )
            ->where([ 'test_field' => 1, 'ID' => 99 ])
            ->get();
        // Assert
        $this->assertEquals(
            'SELECT * FROM prefix_test_table WHERE test_field = %d AND ID = %d',
            $wpdb->get_query()
        );
    }
    /**
     * Test query builder
     * @since 1.0.0
     * @group query
     * @group building
     */
    public function testWhereMultipleJointStatement()
    {
        // Preapre
        global $wpdb;
        $builder = QueryBuilder::create( 'test' );
        // Prepare
        $builder->select( '*' )
            ->from( 'test_table' )
            ->where([
                'test_field' => 1,
                'ID' => [ 'joint' => 'OR', 'value' => 99]
            ])
            ->get();
        // Assert
        $this->assertEquals(
            'SELECT * FROM prefix_test_table WHERE test_field = %d OR ID = %d',
            $wpdb->get_query()
        );
    }
    /**
     * Test query builder
     * @since 1.0.0
     * @group query
     * @group building
     */
    public function testWhereStringStatement()
    {
        // Preapre
        global $wpdb;
        $builder = QueryBuilder::create( 'test' );
        // Prepare
        $builder->select( '*' )
            ->from( 'test_table' )
            ->where(['test_field' => 'a'])
            ->get();
        // Assert
        $this->assertEquals(
            'SELECT * FROM prefix_test_table WHERE test_field = %s',
            $wpdb->get_query()
        );
    }
    /**
     * Test query builder
     * @since 1.0.0
     * @group query
     * @group building
     */
    public function testWhereArrayStatement()
    {
        // Preapre
        global $wpdb;
        $builder = QueryBuilder::create( 'test' );
        // Prepare
        $builder->select( '*' )
            ->from( 'test_table' )
            ->where(['test_field' => [1,2,3]])
            ->get();
        // Assert
        $this->assertEquals(
            'SELECT * FROM prefix_test_table WHERE test_field = (\'1\',\'2\',\'3\')',
            $wpdb->get_query()
        );
    }
    /**
     * Test query builder
     * @since 1.0.0
     * @group query
     * @group building
     * @group join
     */
    public function testJoinStatement()
    {
        // Preapre
        global $wpdb;
        $builder = QueryBuilder::create( 'test' );
        // Prepare
        $builder->select( '*' )
            ->from( 'test_table' )
            ->join( 'test_join', [ ['key' => 'test_field', 'value' => 1] ] )
            ->get();
        // Assert
        $this->assertEquals(
            'SELECT * FROM prefix_test_table JOIN prefix_test_join ON test_field = %d',
            $wpdb->get_query()
        );
    }
    /**
     * Test query builder
     * @since 1.0.0
     * @group query
     * @group building
     * @group join
     */
    public function testLeftJoinStatement()
    {
        // Preapre
        global $wpdb;
        $builder = QueryBuilder::create( 'test' );
        // Prepare
        $builder->select( '*' )
            ->from( 'test_table' )
            ->join( 'test_join', [ ['key' => 'test_field', 'value' => 1] ], true )
            ->get();
        // Assert
        $this->assertEquals(
            'SELECT * FROM prefix_test_table LEFT JOIN prefix_test_join ON test_field = %d',
            $wpdb->get_query()
        );
    }
    /**
     * Test query builder
     * @since 1.0.0
     * @group query
     * @group building
     * @group join
     */
    public function testJoinNoPrefixStatement()
    {
        // Preapre
        global $wpdb;
        $builder = QueryBuilder::create( 'test' );
        // Prepare
        $builder->select( '*' )
            ->from( 'test_table' )
            ->join( 'test_join', [ ['key' => 'test_field', 'value' => 1] ], false, false )
            ->get();
        // Assert
        $this->assertEquals(
            'SELECT * FROM prefix_test_table JOIN test_join ON test_field = %d',
            $wpdb->get_query()
        );
    }
    /**
     * Test query builder
     * @since 1.0.0
     * @group query
     * @group building
     * @group join
     */
    public function testJoinMultipleStatement()
    {
        // Preapre
        global $wpdb;
        $builder = QueryBuilder::create( 'test' );
        // Prepare
        $builder->select( '*' )
            ->from( 'test_table' )
            ->join( 'test_join', [
                ['key' => 'test_field', 'value' => 1],
                ['key_a' => 'test_field', 'key_b' => 'test_field_2'],
            ] )
            ->get();
        // Assert
        $this->assertEquals(
            'SELECT * FROM prefix_test_table JOIN prefix_test_join ON test_field = %d AND test_field = test_field_2',
            $wpdb->get_query()
        );
    }
    /**
     * Test query builder
     * @since 1.0.0
     * @group query
     * @group building
     * @group join
     */
    public function testJoinNullOperatorStatement()
    {
        // Preapre
        global $wpdb;
        $builder = QueryBuilder::create( 'test' );
        // Prepare
        $builder->select( '*' )
            ->from( 'test_table' )
            ->join( 'test_join', [
                ['key' => 'field_a', 'value' => null],
                ['key' => 'field_b', 'value' => null, 'operator' => 'is not'],
            ] )
            ->get();
        // Assert
        $this->assertEquals(
            'SELECT * FROM prefix_test_table JOIN prefix_test_join ON field_a is null AND field_b IS NOT null',
            $wpdb->get_query()
        );
    }
    /**
     * Test query builder
     * @since 1.0.0
     * @group query
     * @group building
     * @group join
     */
    public function testJoinStringJointArrayOperatorStatement()
    {
        // Preapre
        global $wpdb;
        $builder = QueryBuilder::create( 'test' );
        // Prepare
        $builder->select( '*' )
            ->from( 'test_table' )
            ->join( 'test_join', [
                ['key' => 'field_a', 'value' => 'a'],
                ['key' => 'field_b', 'value' => [1,2], 'operator' => 'IN', 'joint' => 'OR'],
            ] )
            ->get();
        // Assert
        $this->assertEquals(
            'SELECT * FROM prefix_test_table JOIN prefix_test_join ON field_a = %s OR field_b IN (\'1\',\'2\')',
            $wpdb->get_query()
        );
    }
    /**
     * Test query builder
     * @since 1.0.0
     * @group query
     * @group building
     */
    public function testLimitStatement()
    {
        // Preapre
        global $wpdb;
        $builder = QueryBuilder::create( 'test' );
        // Prepare
        $builder->select( '*' )
            ->from( 'test_table' )
            ->limit( 2 )
            ->get();
        // Assert
        $this->assertEquals(
            'SELECT * FROM prefix_test_table LIMIT %d',
            $wpdb->get_query()
        );
    }
    /**
     * Test query builder
     * @since 1.0.0
     * @group query
     * @group building
     */
    public function testOffsetStatement()
    {
        // Preapre
        global $wpdb;
        $builder = QueryBuilder::create( 'test' );
        // Prepare
        $builder->select( '*' )
            ->from( 'test_table' )
            ->offset( 2 )
            ->get();
        // Assert
        $this->assertEquals(
            'SELECT * FROM prefix_test_table OFFSET %d',
            $wpdb->get_query()
        );
    }
    /**
     * Test query builder
     * @since 1.0.0
     * @group query
     * @group building
     */
    public function testLimitOffsetStatement()
    {
        // Preapre
        global $wpdb;
        $builder = QueryBuilder::create( 'test' );
        // Prepare
        $builder->select( '*' )
            ->from( 'test_table' )
            ->limit( 2 )
            ->offset( 2 )
            ->get();
        // Assert
        $this->assertEquals(
            'SELECT * FROM prefix_test_table LIMIT %d OFFSET %d',
            $wpdb->get_query()
        );
    }
    /**
     * Test query builder
     * @since 1.0.0
     * @group query
     * @group building
     */
    public function testGroupByStatement()
    {
        // Preapre
        global $wpdb;
        $builder = QueryBuilder::create( 'test' );
        // Prepare
        $builder->select( '*' )
            ->from( 'test_table' )
            ->group_by( 'test_field' )
            ->get();
        // Assert
        $this->assertEquals(
            'SELECT * FROM prefix_test_table GROUP BY test_field',
            $wpdb->get_query()
        );
    }
    /**
     * Test query builder
     * @since 1.0.0
     * @group query
     * @group building
     */
    public function testGroupByMultipleStatement()
    {
        // Preapre
        global $wpdb;
        $builder = QueryBuilder::create( 'test' );
        // Prepare
        $builder->select( '*' )
            ->from( 'test_table' )
            ->group_by( 'field_a' )
            ->group_by( 'field_b' )
            ->get();
        // Assert
        $this->assertEquals(
            'SELECT * FROM prefix_test_table GROUP BY field_a,field_b',
            $wpdb->get_query()
        );
    }
    /**
     * Test query builder
     * @since 1.0.0
     * @group query
     * @group building
     */
    public function testOrderByStatement()
    {
        // Preapre
        global $wpdb;
        $builder = QueryBuilder::create( 'test' );
        // Prepare
        $builder->select( '*' )
            ->from( 'test_table' )
            ->order_by( 'test_field' )
            ->get();
        // Assert
        $this->assertEquals(
            'SELECT * FROM prefix_test_table ORDER BY test_field ASC',
            $wpdb->get_query()
        );
    }
    /**
     * Test query builder
     * @since 1.0.0
     * @group query
     * @group building
     */
    public function testOrderByMultipleDescStatement()
    {
        // Preapre
        global $wpdb;
        $builder = QueryBuilder::create( 'test' );
        // Prepare
        $builder->select( '*' )
            ->from( 'test_table' )
            ->order_by( 'test_a', 'desc' )
            ->order_by( 'test_b' )
            ->get();
        // Assert
        $this->assertEquals(
            'SELECT * FROM prefix_test_table ORDER BY test_a DESC,test_b ASC',
            $wpdb->get_query()
        );
    }
    /**
     * Test query builder
     * @since 1.0.0
     * @group query
     * @group building
     */
    public function testHavingStatement()
    {
        // Preapre
        global $wpdb;
        $builder = QueryBuilder::create( 'test' );
        // Prepare
        $builder->select( '*' )
            ->from( 'test_table' )
            ->having( 'count(1) > 0' )
            ->get();
        // Assert
        $this->assertEquals(
            'SELECT * FROM prefix_test_table HAVING count(1) > 0',
            $wpdb->get_query()
        );
    }
    /**
     * Test query builder
     * @since 1.0.0
     * @group query
     * @group building
     */
    public function testKeywordsStatement()
    {
        // Preapre
        global $wpdb;
        $builder = QueryBuilder::create( 'test' );
        // Prepare
        $builder->select( '*' )
            ->from( 'test_table' )
            ->keywords( 'word', ['field_a','field_b'] )
            ->get();
        // Assert
        $this->assertEquals(
            'SELECT * FROM prefix_test_table WHERE (field_a LIKE %s OR field_b LIKE %s)',
            $wpdb->get_query()
        );
    }
    /**
     * Test query builder
     * @since 1.0.0
     * @group query
     * @group building
     */
    public function testKeywordsMultipleStatement()
    {
        // Preapre
        global $wpdb;
        $builder = QueryBuilder::create( 'test' );
        // Prepare
        $builder->select( '*' )
            ->from( 'test_table' )
            ->keywords( 'two words', ['field_a','field_b'] )
            ->get();
        // Assert
        $this->assertEquals(
            'SELECT * FROM prefix_test_table WHERE (field_a LIKE %s OR field_b LIKE %s) AND (field_a LIKE %s OR field_b LIKE %s)',
            $wpdb->get_query()
        );
    }
    /**
     * Test query builder
     * @since 1.0.0
     * @group query
     * @group building
     */
    public function testKeywordsSeparatorStatement()
    {
        // Preapre
        global $wpdb;
        $builder = QueryBuilder::create( 'test' );
        // Prepare
        $builder->select( '*' )
            ->from( 'test_table' )
            ->keywords( 'two words', ['field_a','field_b'], ',' )
            ->get();
        // Assert
        $this->assertEquals(
            'SELECT * FROM prefix_test_table WHERE (field_a LIKE %s OR field_b LIKE %s)',
            $wpdb->get_query()
        );
    }
    /**
     * Test query builder
     * @since 1.0.0
     * @group query
     * @group building
     */
    public function testKeywordsSeparatorMultipleStatement()
    {
        // Preapre
        global $wpdb;
        $builder = QueryBuilder::create( 'test' );
        // Prepare
        $builder->select( '*' )
            ->from( 'test_table' )
            ->keywords( 'two,words', ['field_a','field_b'], ',' )
            ->get();
        // Assert
        $this->assertEquals(
            'SELECT * FROM prefix_test_table WHERE (field_a LIKE %s OR field_b LIKE %s) AND (field_a LIKE %s OR field_b LIKE %s)',
            $wpdb->get_query()
        );
    }
    /**
     * Test query builder
     * @since 1.0.0
     * @group query
     * @group building
     */
    public function testAllStatements()
    {
        // Preapre
        global $wpdb;
        $builder = QueryBuilder::create( 'test' );
        // Prepare
        $builder->select( 'count(1) AS xx' )
            ->from( 'a' )
            ->join( 'b', [['key_a' => 'b.y', 'key_b' => 'a.y']] )
            ->where( ['a.x' => 2] )
            ->group_by('a.x')
            ->order_by('xx')
            ->having( 'count(1) > 0' )
            ->limit(1)
            ->offset(1)
            ->get();
        // Assert
        $this->assertEquals(
            'SELECT count(1) AS xx FROM prefix_a JOIN prefix_b ON b.y = a.y WHERE a.x = %d '
                .'GROUP BY a.x HAVING count(1) > 0 ORDER BY xx ASC LIMIT %d OFFSET %d',
            $wpdb->get_query()
        );
    }
    /**
     * Test query builder
     * @since 1.0.3
     * @group query
     * @group building
     */
    public function testWhereRawStatement()
    {
        // Preapre
        global $wpdb;
        $builder = QueryBuilder::create( 'test' );
        // Prepare
        $builder->select( '*' )
            ->from( 'test_table' )
            ->where([
                'test_field'    => 1,
                'raw'           => [
                    'value' => 'a = b',
                    'sanitize_callback' => false,
                ],
            ])
            ->get();
        // Assert
        $this->assertEquals(
            'SELECT * FROM prefix_test_table WHERE test_field = %d AND a = b',
            $wpdb->get_query()
        );
    }
    /**
     * Test query builder
     * @since 1.0.3
     * @group query
     * @group building
     */
    public function testJoinRawStatement()
    {
        // Preapre
        global $wpdb;
        $builder = QueryBuilder::create( 'test' );
        // Prepare
        $builder->select( '*' )
            ->from( 'test_table' )
            ->join( 'test_join', [ ['raw' => 'a = b'], ['key' => 'field_a', 'value' => 4] ] )
            ->get();
        // Assert
        $this->assertEquals(
            'SELECT * FROM prefix_test_table JOIN prefix_test_join ON a = b AND field_a = %d',
            $wpdb->get_query()
        );
    }
    /**
     * Test query builder
     * @since 1.0.6
     * @group query
     * @group building
     */
    public function testSelectCalcRowsStatement()
    {
        // Preapre
        global $wpdb;
        $builder = QueryBuilder::create( 'test' );
        // Prepare
        $builder->select( 'test_field' )->get( OBJECT, null, true );
        // Assert
        $this->assertEquals(
            'SELECT SQL_CALC_FOUND_ROWS test_field FROM ',
            $wpdb->get_query()
        );
    }
    /**
     * Test query builder
     * @since 1.0.6
     * @group query
     * @group building
     */
    public function testColCalcRowsStatement()
    {
        // Preapre
        global $wpdb;
        $builder = QueryBuilder::create( 'test' );
        // Prepare
        $builder->select( 'test_field' )->col( 0, true );
        // Assert
        $this->assertEquals(
            'SELECT SQL_CALC_FOUND_ROWS test_field FROM ',
            $wpdb->get_query()
        );
    }
    /**
     * Test query builder
     * @since 1.0.6
     * @group query
     * @group building
     */
    public function testRowsFoundStatement()
    {
        // Preapre
        global $wpdb;
        $builder = QueryBuilder::create( 'test' );
        // Prepare
        $builder->select( 'test_field' )->rows_found();
        // Assert
        $this->assertEquals('SELECT FOUND_ROWS()', $wpdb->get_query());
    }
    /**
     * Test query builder
     * @since 1.0.8
     * @group query
     * @group building
     * @group join
     * @dataProvider providerJoinTypesStatement
     * 
     * @param string $type          Join type.
     * @param string $expected_join Expected built join.
     */
    public function testJoinTypesStatement( $type, $expected_join )
    {
        // Preapre
        global $wpdb;
        $builder = QueryBuilder::create( 'test' );
        // Prepare
        $builder->select( '*' )
            ->from( 'table' )
            ->join( 'join', [ ['key' => 'field', 'value' => 1] ], $type )
            ->get();
        // Assert
        $this->assertEquals(
            'SELECT * FROM prefix_table ' . $expected_join . ' prefix_join ON field = %d',
            $wpdb->get_query()
        );
    }
    /**
     * Test query builder
     * @since 1.0.8
     * @group query
     * @group building
     * @group join
     * @expectedException Exception
     * @expectedExceptionMessage Invalid join type.
     */
    public function testJoinStatementException()
    {
        // Preapre
        global $wpdb;
        $builder = QueryBuilder::create( 'test' );
        // Prepare
        $builder->select( '*' )
            ->from( 'table' )
            ->join( 'join', [ ['key' => 'field', 'value' => 1] ], 'Yolo' );
    }
    /**
     * Test query builder
     * @since 1.0.8
     * @group query
     * @group building
     * @group select
     */
    public function testSelectWildcardStatement()
    {
        // Preapre
        global $wpdb;
        $builder = QueryBuilder::create( 'test' );
        // Prepare
        $builder->from( 'table' )->get();
        // Assert
        $this->assertEquals(
            'SELECT * FROM prefix_table',
            $wpdb->get_query()
        );
    }
    /**
     * Returns testing data sets.
     * @since 1.0.8
     * 
     * @see self::testJoinTypesStatement
     */
    public function providerJoinTypesStatement()
    {
        return [
            ['right', 'RIGHT JOIN'],
            ['right OUTeR', 'RIGHT OUTER JOIN'],
            ['CROSS', 'CROSS JOIN'],
            ['left', 'LEFT JOIN'],
            ['left outer', 'LEFT OUTER JOIN'],
            ['Inner', 'INNER JOIN'],
            [' ', 'JOIN'],
            ['', 'JOIN'],
        ];
    }
}