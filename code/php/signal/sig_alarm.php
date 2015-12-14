<?php
declare(ticks=1);

pcntl_signal(SIGALRM, 'sig_alarm');
function sig_alarm()
{
    echo '---', microtime(true), PHP_EOL;
    pcntl_alarm(2);
}

while(1) {
    echo '===', __LINE__, PHP_EOL;
    pcntl_alarm(2);
    echo '===', __LINE__, PHP_EOL;
    sleep(3);
}
