<?php
# Carというクラスを作成する
class Car
{
    static $class_name = "Car";

    function init(){
        $this->name = "";
    }

    public function show() {
        echo ($this->name."\n");
    }
}
# Carクラスのインスタンスを作成する
$car = new Car();

# Carのインスタンス変数nameにセダンという文字列を格納する
$car->name = "セダン";

# Carのメソッドであるshow()を実行する
$car->show();
# ターミナルにはセダンと表示される

# Carクラス内にあるクラス変数$class_nameをターミナルに表示する
echo (Car::$class_name."\n");
# ターミナルにはCarと表示される
?>