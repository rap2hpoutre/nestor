<?php
namespace Nestor;

interface Rollbackable {

    public function up($callback);
    
    public function runUp();
    
    public function down($callback);
    
    public function runDown();
}
