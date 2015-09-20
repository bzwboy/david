<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 foldmethod=marker: */

/**
 * eYou PHP Code
 * 
 * @copyright  Copyright (C) 2008-2015 Minnesota David
 * @author     libo <libo@eyou.net>
 * @package    Product
 * @see http://www.im286.net/thread-15335287-1-1.html
 */

super_var_init();
multi_process(2, 0);

$pid = getmypid();
while(TRUE){
    super_var_lock('var_name');
    #echo "pid $pid got lock!\n";
    $val = super_var_get('var_name');
    #echo "pid $pid var_name current value: $val\n";
    super_var_set('var_name', $val+1);
    #echo "pid $pid release lock!\n";
    super_var_unlock('var_name');
    sleep(rand(1, 5));
}

function super_var_lock($name)
{
    $fp = fopen(super_var_path($name), 'r+');
    if(flock($fp, LOCK_EX)){
        return TRUE;
    }
}

function super_var_unlock($name)
{
    $fp = fopen(super_var_path($name), 'r+');
    fflush($fp);
    flock($fp, LOCK_UN);
    fclose($fp);
}

function super_var_get($name)
{
    return file_get_contents(super_var_path($name));
}

function super_var_set($name, $content)
{
    file_put_contents(super_var_path($name), $content);
}

function super_var_init()
{
    $files = glob("/dev/shm/super_var_".md5(__FILE__)."*");
    foreach($files as $file){
        unlink($file);
    }
}

function super_var_path($name)
{
    $path = "/dev/shm/super_var_".md5(__FILE__).$name;
    if(!file_exists($path)){
        touch($path);
    }
    return $path;
}

function multi_process($num, $permanent = true)
{
    if ($permanent) {
        $child = 0;
        while(1){
            $pid = pcntl_fork();
            /*59*/echo '+++line:', __LINE__, ':fork-pid:', $pid, "\n";
            $child ++ ;
            if($pid) {
                if($child >=$num){
                    /*63*/echo 'line:', __LINE__, ':child:', $child, ':pid:', getmypid(), "\n";
                    pcntl_wait($status);
                    $child--;
                } else {
                    /*67*/echo 'line:', __LINE__, ':child:', $child, ':pid:', getmypid(), "\n";
                    usleep(100000);
                }
            } else {
                /*71*/echo 'line:', __LINE__, ':child:', $child, ':pid:', getmypid(), "\n";
                break;
            }
        }
    } else {
        $pids = array();
        for($i = 0; $i < $num; $i++) {
            $pids[$i] = pcntl_fork();
            if($pids[$i]){
                usleep(100000);
            } else {
                return;
            }
        }
        print_r($pids);
        echo "\n";
        foreach($pids as $i => $pid) {
            /*85*/echo 'line:', __LINE__, ':pid:', $pid, ':current:', getmypid(), "\n";
            var_dump(pcntl_waitpid($pid, $status));
            /*87*/echo 'line:', __LINE__, "\n";
        }
        exit();
    }
}

