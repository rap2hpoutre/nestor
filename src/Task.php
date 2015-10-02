<?php

namespace Nestor;

/**
 * Up and Down Task for Nestor.
 *
 * @package Nestor
 */
class Task
{

    /**
     * @var callable
     */
    public $down;

    /**
     * @var callable
     */
    public $up;

    /**
     * Register up method
     *
     * @param callable $callback
     * @return $this
     */
    public function up($callback)
    {
        $this->up = $callback;
        return $this;
    }

    /**
     * Register down method
     *
     * @param callable $callback
     * @return $this
     */
    public function down($callback)
    {
        $this->down = $callback;
        return $this;
    }

    /**
     * @param string $message
     * @throws TaskException
     */
    public function fail($message = '')
    {
        throw new TaskException($message);
    }
}
