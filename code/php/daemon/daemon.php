<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 foldmethod=marker: */

error_reporting(E_ALL);

declare(ticks = 1);

/**
 * Daemon 
 * 
 * @author David
 *
 * Example:
 *   $daemon = new Daemon;
 *   $daemon->set_options(
 *      [
 *          'func' => 'get_queue',
 *          'fork_num' => 10,
 *      ]
 *   );
 *   $daemon->proc_fork();
 *
 *   $daemon->proc_kill();
 *
 */
class Daemon
{
    // {{{ members

    /**
     * 子进程执行行数 
     * 
     * @var string
     */
    private $_func = './child.php';

    /**
     * 子进程个数 
     * 
     * @var float
     */
    private $_forkNum = 5;

    /**
     * pid 文件路径 
     * 
     * @var string
     */
    private $_pidFile = '/tmp/proc.pid';

    /**
     * 进程 id
     *
     */
    private $_pids = array();

    /**
     * 共享内存配置
     *
     */
    private $_shmConf = array(
        'mode' => 0644,
        'size' => 200,
    );

    /**
     * 子进程 redis key 前缀
     *
     */
    private static $_subStatPre = 'sub_proc_';

    // }}}
    // {{{ functions
    // {{{ public function __construct()

    /**
     * __construct 
     * 
     * @param array $args 
     *  [
     *      'func' => 'abc',
     *      'forNum' => 5,
     *      'pid_file' => '/tmp/proc.pid',
     *  ]
     * @return void
     */
    public function __construct()
    {
        $conf = parse_ini_file('./daemon.ini');
        $this->set_options($conf);

        if (is_dir($_SERVER['HOME'])) {
            $this->_pidFile = $_SERVER['HOME'] . '/tmp/proc.pid';
        }
    }

    // }}}
    // {{{ public function set_options()

    /**
     * 设置配置参数 
     * 
     * @param array $args 
     *  [
     *      'func' => '',
     *      'num' => 5,
     *      'pid' => '/tmp/proc.pid',
     *  ]
     * @return void
     */
    public function set_options($args)
    {
        if (isset($args['func'])) {
            $this->_func = $args['func'];
        }

        if (isset($args['num'])) {
            $this->_forkNum = $args['num'];
        }

        if (isset($args['pid'])) {
            $this->_pidFile = $args['pid'];
        }
    }

    // }}}
    // {{{ public function proc_fork()

    /**
     * 创建多进程 
     * 
     * @return void
     */
    public function proc_fork()
    {
        if ($this->_chk_run()) {
            echo "+Ok, daemon is processing.\n";
            exit(0);
        }

        // 忽略终端 I/O信号,STOP信号
        pcntl_signal(SIGTTOU, SIG_IGN);
        pcntl_signal(SIGTTIN, SIG_IGN);
        pcntl_signal(SIGTSTP, SIG_IGN);
        pcntl_signal(SIGHUP, SIG_IGN);
       
        // 父进程退出,程序进入后台运行
        $pid = pcntl_fork();
        if (0 > $pid) {
            self::lg('fork fail', __LINE__);
            exit(1);
        } elseif ($pid) {
            exit(0);
        }

        // 设置子进程为会话组长
        if (0 > posix_setsid()) {
            self::lg('set session leader fail', __LINE__);
            exit(2);
        }

        // 子进程退出, 孙进程没有控制终端了
        $pid = pcntl_fork();
        if (0 > $pid) {
            self::lg('fork fail', __LINE__);
            exit(1);
        } elseif ($pid) {
            exit(0);
        }

        chdir($_SERVER['HOME']);
        umask(0);

        self::lg('start fork process', __LINE__, 'succ');
        try {
            $this->_fork_child();
        } catch (Exception $e) {
            exit(5);
        }
    }

    // }}}
    // {{{ private function _get_sub_pid()

    /**
     * 获取子进程 pid
     *
     * @return int
     */
    private function _get_sub_pid()
    {
        return file_get_contents($this->_pidFile);
    }

    // }}}
    // {{{ private function _chk_run()

    /**
     * 检查 daemon 是否在运行
     *
     * @return bool
     */
    private function _chk_run()
    {
        $pid = $this->_get_sub_pid();
        return (!empty($pid)) ? true : false;
    }

    // }}}
    // {{{ private function _fork_child()

    /**
     * 创建子进程 
     * 
     * @param int $num 子进程个数
     * @return void
     */
    private function _fork_child()
    {
        $this->_write_shm(posix_getpid());

        $i = 0;
        $isInit = false;
        while (1) {
            $pid = pcntl_fork();

            $i++;
            if (-1 === $pid) { // error
                self::lg('fork fail', __LINE__);
                exit(1);
            } elseif ($pid) { // parent
                $this->_write_shm($pid);

                if ($i >= $this->_forkNum) {
                    pcntl_wait($proc_status);
                    --$i;
                    $isInit = false;
                }

                if (!$isInit) {
                    $this->_write_pid($pid);
                    $isInit = true;
                }
                usleep(100000);
            } else { // child
                pcntl_signal(SIGTERM, SIG_DFL);
                // 中断进程组
                pcntl_signal(SIGUSR1, array($this, 'handler_sigusr1'));
                // 获取进程状态
                pcntl_signal(SIGUSR2, array($this, 'handler_sigusr2'));

                include $this->_func;
                break;
            }
        }
    }

    // }}}
    // {{{ public function handler_sigusr1()

    /**
     * 用户自定义信号处理
     *
     * @return void
     */
    public function handler_sigusr1($signo)
    {
        if (posix_kill(0, SIGTERM)) {
            self::lg("-Err, 关闭 daemon 进程失败", __LINE__);
            exit(1);
        }
    }

    // }}}
    // {{{ public function handler_sigusr2()

    /**
     * 用户自定义信号处理
     *
     * @return void
     */
    public function handler_sigusr2($signo)
    {
        $this->_read_shm();
    }

    // }}}
    // {{{ private function _read_shm()

    /**
     * 读共享内存
     *
     * @return void
     */
    private function _read_shm()
    {
        $shm_key = ftok(__FILE__, 't');
        $shm_id = shmop_open($shm_key, 'a', $this->_shmConf['mode'], $this->_shmConf['size']);
        if (!$shm_id) {
            echo "-Err, 获取进程信息失败\n";
            exit(1);
        }

        $shm_data = shmop_read($shm_id, 0, 200);
        $data = unserialize($shm_data);
        print_r($data);
        shmop_close($shm_id);
    }

    // }}}
    // {{{ private function _write_shm()

    /**
     * 写入共享内存
     *
     * @return void
     */
    private function _write_shm($pid)
    {
        $shm_key = ftok(__FILE__, 't');
        $shm_id = shmop_open($shm_key, 'c', $this->_shmConf['mode'], $this->_shmConf['size']);

        $shm_data = trim(shmop_read($shm_id, 0, 200));
        $data = array();
        if (!empty($shm_data)) {
            $data = unserialize($shm_data);
        }
        $data[] = $pid;
        $str = serialize($data);

        if (!shmop_write($shm_id, $str, 0)) {
            echo "写入共享内存失败\n";
            exit(1);
        }
        shmop_close($shm_id);
    }

    // }}}
    // {{{ private function _write_pid()

    /**
     * 写入 pid 文件 
     * 
     * @return void
     */
    private function _write_pid($pid)
    {
        if (false === file_put_contents($this->_pidFile, $pid)) {
            self::lg('insert pid into file fail', __LINE__);
            exit(1);
        }
    }

    // }}}
    // {{{ public static function lg()

    /**
     * 日志记录
     *
     * @params string $msg
     * @params int $line
     * @params string $stat 'fail'|'succ'
     * @return void
     */
    public static function lg($msg, $line = 0, $stat = 'fail')
    {
        $logFile = '/tmp/daemon.log';
        if (is_dir($_SERVER['HOME'])) {
            $logFile = $_SERVER['HOME'] . '/tmp/daemon.log';
        }

        $date = date('c');
        $stat = strtoupper($stat);
        $msg = "{$date} [{$line}] [{$stat}] {$msg}";

        file_put_contents($logFile, $msg . PHP_EOL, FILE_APPEND);
    }

    // }}}
    // {{{ public function proc_kill()

    /**
     * 停止进程 
     * 
     * @return void
     */
    public function proc_kill()
    {
        $pid = $this->_get_sub_pid();
        if (empty($pid)) {
            echo "+Ok, daemon has shutdown.\n";
            return;
        }

        if (!posix_kill($pid, SIGUSR1)) {
            echo "-Err, 停止进程失败\n";
            exit(1);
        }

        // 清空
        file_put_contents($this->_pidFile, '');
        $this->_clear_shm();
    }

    // }}}
    // {{{ private function _clear_shm()

    /**
     * 清空共享内存
     *
     * @return void
     */
    private function _clear_shm()
    {
        $shm_key = ftok(__FILE__, 't');
        $shm_id = shmop_open($shm_key, 'a', $this->_shmConf['mode'], $this->_shmConf['size']);
        if (!shmop_delete($shm_id)) {
            self::lg('删除共享内存失败', __LINE__, 'fail');
        }
    }

    // }}}
    // {{{ public function proc_status()

    /**
     * 进程状态 
     * 
     * @return void
     */
    public function proc_status()
    {
        $pid = $this->_get_sub_pid();
        if (empty($pid)) {
            echo "+Ok, daemon has shutdown.\n";
            return;
        }

        if (!posix_kill($pid, SIGUSR2)) {
            echo "获取进程状态信息失败\n";
            exit(1);
        }
    }

    // }}}
    // {{{ private function redis_conn()

    /**
     * 建立 redis 连接
     *
     * @return Redis
     */
    private function redis_conn()
    {
        $redis = new Redis;
        $redis->connect('localhost', 6379);
        return $redis;
    }

    // }}}
    // }}}
}

function help() {
    $cmd = basename(__FILE__);
    echo <<<H
./$cmd [-f <php-file>|k|s]
    -f php-file     子进程逻辑
    -k              停止守护进程
    -s              查看进程状态

H;
}

$opt = getopt('i:f:ks');
if (empty($opt)) {
    help();
    exit(1);
}

$daemon = new Daemon;
if (isset($opt['f']) && file_exists($opt['f'])) {
    $daemon->set_options(array( 'func' => $opt['f'] ));
    $daemon->proc_fork();
} elseif (isset($opt['k'])) {
    $daemon->proc_kill();
} elseif (isset($opt['s'])) {
    $daemon->proc_status();
} else {
    help();
}

