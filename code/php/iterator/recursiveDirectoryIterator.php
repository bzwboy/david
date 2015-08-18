<?php
/*
目录路径：/home/libo/git/cli/src/implements
RecursiveIteratorIterator 四种常量搜索结果差异

<code>
    $base = '/home/libo/git/cli/src/implements'; 
    $const = RecursiveIteratorIterator::CATCH_GET_CHILD;
    $ritit = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($base), $const);
    foreach ($ritit as $splFileInfo) {
        var_dump($splFileInfo->getPathname());
    }
</code>

RecursiveIteratorIterator::LEAVES_ONLY
string(35) "/home/libo/git/cli/src/implements/."
string(36) "/home/libo/git/cli/src/implements/.."
string(75) "/home/libo/git/cli/src/implements/process/emimp_process_interface.class.php"
string(78) "/home/libo/git/cli/src/implements/process/emimp_process_agent_client.class.php"
string(83) "/home/libo/git/cli/src/implements/process/emimp_process_gmond_push_client.class.php"
string(75) "/home/libo/git/cli/src/implements/process/emimp_process_exception.class.php"
string(43) "/home/libo/git/cli/src/implements/process/."
string(74) "/home/libo/git/cli/src/implements/process/emimp_process_abstract.class.php"
string(44) "/home/libo/git/cli/src/implements/process/.."
string(54) "/home/libo/git/cli/src/implements/process/Makefile.ini"
string(78) "/home/libo/git/cli/src/implements/process/emimp_process_gmond_metric.class.php"
string(48) "/home/libo/git/cli/src/implements/process/test/."
string(88) "/home/libo/git/cli/src/implements/process/test/test_emimp_process_agent_client.class.php"
string(49) "/home/libo/git/cli/src/implements/process/test/.."
string(86) "/home/libo/git/cli/src/implements/process/test/test_emimp_process_notify_heartbeat.php"
string(62) "/home/libo/git/cli/src/implements/process/test/eminfo_json.php"
string(46) "/home/libo/git/cli/src/implements/Makefile.ini"

RecursiveIteratorIterator::SELF_FIRST
string(35) "/home/libo/git/cli/src/implements/."
string(36) "/home/libo/git/cli/src/implements/.."
string(41) "/home/libo/git/cli/src/implements/process"
string(75) "/home/libo/git/cli/src/implements/process/emimp_process_interface.class.php"
string(78) "/home/libo/git/cli/src/implements/process/emimp_process_agent_client.class.php"
string(83) "/home/libo/git/cli/src/implements/process/emimp_process_gmond_push_client.class.php"
string(75) "/home/libo/git/cli/src/implements/process/emimp_process_exception.class.php"
string(43) "/home/libo/git/cli/src/implements/process/."
string(74) "/home/libo/git/cli/src/implements/process/emimp_process_abstract.class.php"
string(44) "/home/libo/git/cli/src/implements/process/.."
string(54) "/home/libo/git/cli/src/implements/process/Makefile.ini"
string(78) "/home/libo/git/cli/src/implements/process/emimp_process_gmond_metric.class.php"
string(46) "/home/libo/git/cli/src/implements/process/test"
string(48) "/home/libo/git/cli/src/implements/process/test/."
string(88) "/home/libo/git/cli/src/implements/process/test/test_emimp_process_agent_client.class.php"
string(49) "/home/libo/git/cli/src/implements/process/test/.."
string(86) "/home/libo/git/cli/src/implements/process/test/test_emimp_process_notify_heartbeat.php"
string(62) "/home/libo/git/cli/src/implements/process/test/eminfo_json.php"
string(46) "/home/libo/git/cli/src/implements/Makefile.ini"

RecursiveIteratorIterator::CHILD_FIRST
string(35) "/home/libo/git/cli/src/implements/."
string(36) "/home/libo/git/cli/src/implements/.."
string(75) "/home/libo/git/cli/src/implements/process/emimp_process_interface.class.php"
string(78) "/home/libo/git/cli/src/implements/process/emimp_process_agent_client.class.php"
string(83) "/home/libo/git/cli/src/implements/process/emimp_process_gmond_push_client.class.php"
string(75) "/home/libo/git/cli/src/implements/process/emimp_process_exception.class.php"
string(43) "/home/libo/git/cli/src/implements/process/."
string(74) "/home/libo/git/cli/src/implements/process/emimp_process_abstract.class.php"
string(44) "/home/libo/git/cli/src/implements/process/.."
string(54) "/home/libo/git/cli/src/implements/process/Makefile.ini"
string(78) "/home/libo/git/cli/src/implements/process/emimp_process_gmond_metric.class.php"
string(48) "/home/libo/git/cli/src/implements/process/test/."
string(88) "/home/libo/git/cli/src/implements/process/test/test_emimp_process_agent_client.class.php"
string(49) "/home/libo/git/cli/src/implements/process/test/.."
string(86) "/home/libo/git/cli/src/implements/process/test/test_emimp_process_notify_heartbeat.php"
string(62) "/home/libo/git/cli/src/implements/process/test/eminfo_json.php"
string(46) "/home/libo/git/cli/src/implements/process/test"
string(41) "/home/libo/git/cli/src/implements/process"
string(46) "/home/libo/git/cli/src/implements/Makefile.ini"

RecursiveIteratorIterator::CATCH_GET_CHILD
string(46) "/home/libo/git/cli/src/implements/Makefile.ini"
string(35) "/home/libo/git/cli/src/implements/."
string(36) "/home/libo/git/cli/src/implements/.."
string(42) "/home/libo/git/cli/src/implements/Makefile"
string(41) "/home/libo/git/cli/src/implements/process"
 */

$base = '/home/libo/git/cli/src/implements'; 
$const = RecursiveIteratorIterator::CATCH_GET_CHILD;
$ritit = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($base), $const);
foreach ($ritit as $splFileInfo) {
    var_dump($splFileInfo->getPathname());
}

