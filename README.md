# Nestor Task Servant

[![Latest Version](https://img.shields.io/github/release/rap2hpoutre/nestor.svg?style=flat-square)](https://github.com/rap2hpoutre/nestor/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/scrutinizer/build/g/rap2hpoutre/nestor.svg?style=flat-square)](https://travis-ci.org/rap2hpoutre/nestor)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/rap2hpoutre/nestor.svg?style=flat-square)](https://scrutinizer-ci.com/g/rap2hpoutre/nestor/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/rap2hpoutre/nestor.svg?style=flat-square)](https://scrutinizer-ci.com/g/rap2hpoutre/nestor)

## Installation
```
composer require rap2hpoutre/nestor
```
## Usage
Run some tasks. In this example, the second task fails, everything will be rolled back.
```php
$nestor = new Nestor\Servant;

// Create 1st task
$nestor->task()
    ->up(function (){
        echo "task 1 done\n";
    })
    ->down(function () {
        echo "task 1 cancelled\n";
    });
    
// Create 2nd task (this tasks will fail)
$nestor->task()
    ->up(function ($task) {
        $task->fail();
        echo "task 2 done\n";
    })
    ->down(function () {
        echo "task 2 cancelled\n";
    });
    
// Run all tasks, rollback on fail (LIFO stack)
$nestor->run();
```
You should see:
```
task 1 done
task 2 cancelled
task 1 cancelled
```

## Why?
Todo: Explain why.

## About
Thanks to [DonoSybrix](https://github.com/DonoSybrix). Feel free to contribute.
