<?php
namespace Nestor;

class Servant {

    private $tasks = [];

    public function task() {
        $task = new Task;
        $this->tasks[] = $task;
        return 
    }
    
    pulic function run() {
        try {
            foreach($this->tasks as $key => $task) {
                $task->runUp();
            }
        } catch(TaskException) {
            while($key >= 0) {
                $this->tasks[$key]->runDown();
                $key--;
            }
        }
    }

}
