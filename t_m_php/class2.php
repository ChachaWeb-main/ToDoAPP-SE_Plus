<?php
class Human
{
    static $class_name = "Human";

    function init(){
        $this->name = "大泉";
    }

    public function show() {
        echo ($this->name."\n");
    }
    
}
    echo (Human::$class_name."\n");
?>