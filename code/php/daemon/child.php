<?php
while (1) {
    file_put_contents('tmp/daemon', posix_getppid() . '--' . posix_getpid() . '--' . date('Y-m-d H:i:s') . PHP_EOL, FILE_APPEND);
    sleep(1);
}

