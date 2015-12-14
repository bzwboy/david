<?php
// 停止 sig_1 进程
echo "Stop sig_1 procss...\n";
posix_kill(file_get_contents('t.pid'), SIGUSR1);
echo "Done\n";


