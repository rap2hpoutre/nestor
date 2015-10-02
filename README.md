# Nestor Task Servant
Do task, rollback if something goes wrong. Just like database transactions.

## Installation
```
composer require rap2hpoutre/similar-text-finder
```
## Usage
Run some tasks. The second task fails, it will be rolled back.
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
