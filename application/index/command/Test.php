<?php


namespace app\index\command;


use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\Db;

class Test extends Command {
    protected function configure()
    {
        $this->setName('test')->setDescription('Here is the remark ');
    }

    protected function execute(Input $input, Output $output)
    {
//        $url=fopen(date('YmdHsi',time()).'.txt',"a");
//        $fileName=date('Y-m-d H-i');
//        fwrite($url,$fileName);
//        $url=date('YmdHsi',time()).'.txt';
//        $output->writeln(file_get_contents($url));
        $sql="show tables";
        $arr=Db::execute($sql);
        $output->writeln($arr);
    }
}
