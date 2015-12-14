<?php
//使用ticks需要PHP 4.3.0以上版本
declare(ticks = 1);

function sig_usr1($signo)
{
    echo "Caught SIGUSR1...\n";
    posix_kill(0, SIGTERM); // 消灭当前进程组
    #posix_kill(-1, SIGTERM); // 毁灭全部,包括1进程
    #posix_kill(getmypid(), SIGTERM);
}

function sig_chld($signo)
{
    echo "Caught SIGCHLD...\n";

    /*
    foreach ($pids as $p) {
        posix_kill($p, SIGTERM);
    }

    posix_kill($ppid, SIGTERM);
     */
}

echo "recorder pid file...\n";
$ppid = posix_getpid();
echo "parent-pid:$ppid\n\n";
$pids = array();
$isInit = false;

// 方案三
// 一主 & 多子 
$i = 0;
$max = 4;
while (1) {
    $pid = pcntl_fork();
    if ($pid) {
        echo "child-pid:$pid\n";
        $pids[] = $pid;

        if (!$isInit) {
            file_put_contents('t.pid', $pid);
        } else {
            $isInit = true;
        }

        if (++$i < $max) {
            continue;
        }

        pcntl_wait($status);
        $i--;
        $isInit = false;
    } else {
        pcntl_signal(SIGTERM, SIG_DFL);
        pcntl_signal(SIGUSR1, 'sig_usr1');

        #echo "\nloop process...\n";
        $i = 0;
        while (1) {
            xl('--- ' . microtime(true));
            sleep(1);
            if (++$i > 2) {
                return;
            }
        }
    }
}


/*
// 方案一
// 单进程信号处理
while (1) {
    printf("\r%d", microtime(true));
    sleep(2);
}
*/


/*
// 方案二
// 多进程信号处理
// 一主 & 一子 
// 当存在子进程时候，单独给主进程发送信号
// 信号会被阻塞，必须发给子进程，才能收到信号
$pid = pcntl_fork();
if ($pid) {
    pcntl_signal(SIGCHLD, 'sig_chld');
    if (!$recPid) {
        file_put_contents('t.pid', $pid);
        $recPid = true;
    } else {
        $pids[] = $pid;
    }

    echo "\nchild-pid:$pid\n";
    pcntl_wait($status);
} else {
    pcntl_signal(SIGUSR1, 'sig_usr1');
    echo "\nloop process...\n";
    while (1) {
        printf("\r%d", microtime(true));
        sleep(1);
    }
}
 */

