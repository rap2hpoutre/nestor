<?php
namespace Nestor\Test;

use Nestor\Servant;
use Nestor\Task;

/**
 * Class NestorTest
 * @package Nestor\Test
 */
class NestorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Just one task. This task works
     */
    public function testSuccessTask()
    {
        $test_stack = [];
        $servant = new Servant;

        $servant->task()
            ->up(function() use (&$test_stack) {
                $test_stack[] = 1;
            })
            ->down(function() use (&$test_stack) {
                $test_stack[] = 2;
            });

        $servant->run();

        $this->assertCount(1, $test_stack);
        $this->assertEquals(1, $test_stack[0]);
    }

    /**
     * Just one task. This task fails
     */
    public function testFailTask()
    {
        $test_stack = [];
        $servant = new Servant;

        $servant->task()
            ->up(function(Servant $servant) use (&$test_stack) {
                $test_stack[] = 1;
                $servant->fail();
            })
            ->down(function() use (&$test_stack) {
                $test_stack[] = 2;
            });

        $servant->run();
        $this->assertCount(2, $test_stack);
        $this->assertEquals(1, $test_stack[0]);
        $this->assertEquals(2, $test_stack[1]);
    }

    /**
     * Two working tasks
     */
    public function testSuccess2Tasks()
    {
        $test_stack = [];
        $servant = new Servant;

        $servant->task()
            ->up(function() use (&$test_stack) {
                $test_stack[] = 1;
            })
            ->down(function() use (&$test_stack) {
                $test_stack[] = 4;
            });

        $servant->task()
            ->up(function() use (&$test_stack) {
                $test_stack[] = 2;
            })
            ->down(function() use (&$test_stack) {
                $test_stack[] = 3;
            });

        $servant->run();

        $this->assertCount(2, $test_stack);
        $this->assertEquals(1, $test_stack[0]);
        $this->assertEquals(2, $test_stack[1]);
    }


    /**
     * On task pass, one fails
     */
    public function testFail2Tasks()
    {
        $test_stack = [];
        $servant = new Servant;

        $servant->task()
            ->up(function() use (&$test_stack) {
                $test_stack[] = 1;
            })
            ->down(function() use (&$test_stack) {
                $test_stack[] = 4;
            });

        $servant->task()
            ->up(function(Servant $servant) use (&$test_stack) {
                $test_stack[] = 2;
                $servant->fail();
            })
            ->down(function() use (&$test_stack) {
                $test_stack[] = 3;
            });

        $servant->run();

        $this->assertCount(4, $test_stack);
        $this->assertEquals(1, $test_stack[0]);
        $this->assertEquals(2, $test_stack[1]);
        $this->assertEquals(3, $test_stack[2]);
        $this->assertEquals(4, $test_stack[3]);
    }

    public function testGetterSetter()
    {
        $servant = new Servant;
        $servant->put('test_stack', []);

        $servant->task()
            ->up(function(Servant $servant) {
                $servant->push('test_stack', 1);
            })
            ->down(function(Servant $servant) {
                $servant->push('test_stack', 4);
            });

        $servant->task()
            ->up(function(Servant $servant) {
                $servant->push('test_stack', 2);
                $servant->fail();
            })
            ->down(function(Servant $servant) {
                $servant->push('test_stack', 3);
            });

        $servant->run();

        $this->assertCount(4, $servant->get('test_stack'));
        $this->assertEquals(1, $servant->get('test_stack')[0]);
        $this->assertEquals(2, $servant->get('test_stack')[1]);
        $this->assertEquals(3, $servant->get('test_stack')[2]);
        $this->assertEquals(4, $servant->get('test_stack')[3]);
    }
}