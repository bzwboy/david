<?php
/**
 * 发送邮件 Demo
 *
 * 监控batch表
 * 发放数量与redis不一致的数据
 * 使用时间小于发放时间的数据
 * 使用规则
 * @todo 销售型抵用券不在订单表中
 * 
 * @author yechen01
 */
Bd_Init::init();

$batchService = new Service_Data_Batch_Batch();
$restrictionService = new Service_Data_Restriction_Restriction();
$batchList = $batchService->getInCreateBatch();

$db = Bd_Db_ConnMgr::getConn('ClusterOne');
$out = array();
$dataSendNum = array();
$dataTimeErr = array();
$dataRestrictionArray = array();
$tempSaveRestriction = array();
$numDiffArray = array();
$time = time();
$allData = array();
foreach ($batchList as $batch) {
	//没发布的就不管了
	if ($batch['status'] != 1) {
		continue;
	}
	//发放数量数据
	$key = 'giftCardTotal'.$batch['id'];
	$sendNum = $batch['send_num'];

	$redisNum = $batchService->getCache($key);

	if ($redisNum && abs(($sendNum-$redisNum))>100) {
		//备库延时导致数据库数量比redis少，所以增加以下逻辑
		//如果超发不大于200张，且可发数量还大于5万不报警
		//或者剩余张数大于50万张不报警
		if (((abs(($sendNum-$redisNum)) < 200) && (($batch['issue_num'] - $batch['send_num']) > 50000)) ||
		(($batch['issue_num'] - $batch['send_num']) > 500000)) {
			;
		} else {
			$dataSendNum[$batch['id']] = array(
				'id' => $batch['id'],
				'db_send_num' => $sendNum,
				'db_issue_num' => $batch['issue_num'],
				'redis' => $redisNum,
			);
		}
	}
	$allData[$batch['id']] = array(
		'id' => $batch['id'],
		'db_send_num' => $sendNum,
		'db_issue_num' => $batch['issue_num'],
		'redis' => $redisNum,
		'money' => $batch['money'],
	);

	
	if (($batch['send_num'] > $batch['issue_num']) && 
	(!in_array($batch['id'], array(6527,6454,6453,6346,6782,7070,7087,7088,7085,8983,8176)))
		&& ($batch['id']>6300)) {
		$numDiffArray[$batch['id']] = array($batch['send_num'], $batch['issue_num']);
	}
	
	//使用时间小于发放时间
	$restriction = $restrictionService->getByBatchId($batch['id']);
	$tempSaveRestriction[$batch['id']] = $restriction;
	if ((!$restriction['dynamic_period']) && ($restriction['end_time'] < $batch['issue_end_time']) &&
		!in_array($batch['id'], array(4569,4664,5502,5517,5413,3704,4328,9729,10172,10319,10401,10543,10576,10681,10793))) {
		$dataTimeErr[] = $batch['id'];
	}
	unset($redisNum);
	
	$batchKey = "batch".$batch['id'];
	$batchRedisInfo = unserialize($batchService->getCache($batchKey));
	if (count($batchRedisInfo['verchannel_md5']) > 0) {
		foreach ($batchRedisInfo['verchannel_md5'] as $md5 => $verChannel) {
			$realMd5 = md5($batch['id'].'_'.$verChannel);
			if ($md5 != $realMd5) {
				$dataRestrictionArray[] = 
				array(
					'id' => $batch['id'],
					'diff' => "md5应该是".$realMd5."但是redis里是".$md5,
				);
			}
		}
	}
}


//监控使用规则
$inUseBatchList = $db->query("
	select gb.id as track_id,gr.* from gift_batch gb inner join gift_restriction gr 
	on 
		gb.id=gr.batch_id
	where gr.end_time>= ".$time."
	");
foreach ($inUseBatchList as $sInUseBatch) {
	//使用规则数据库与缓存不一致
	$restrictionDB = $sInUseBatch;
	unset($restrictionDB['track_id'],$restrictionDB['deal_num']);
	$restriction = $tempSaveRestriction[$sInUseBatch['track_id']];
	if (!$restriction) {
		$restriction = $restrictionService->getByBatchId($sInUseBatch['track_id']);
	}
	unset($restriction['deal_num']);
	unset($restriction['id'],$restrictionDB['id']);
	if ($restriction != $restrictionDB && count(array_diff_assoc($restriction,$restrictionDB))>0) {
		$dataRestrictionArray[] = 
			array(
				'id' => $sInUseBatch['track_id'],
				'diff' => json_encode(array_diff_assoc($restriction,$restrictionDB)),
			);
	}
}
if ((count($dataSendNum) == 0) && (count($dataTimeErr) == 0) && (count($dataRestrictionArray) == 0) && (count($numDiffArray) == 0)) {
	die();
}

$errMessage = '抵用券有异常（若批次数量缓存不一致、超发，下小时不报可不用处理）.';
// 当发送 HTML 电子邮件时，请始终设置 content-type
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=utf8" . "\r\n";
$to = "yechen01@baidu.com,yangpingping01@baidu.com,qiulikai@baidu.com";
//$to = "yechen01@baidu.com";
$subject = "抵用券监控";
$subject = "=?UTF-8?B?" . base64_encode($subject) . "?=";
$message = "统计时间".date('Y-m-d H:i:s',time())."<br>";
$message .= "发券数量数据库与redis不一致监控<br>";
$message .= "<table border='2'>
			<tr>
			<th>批次id
			<th>金额
			<th>门槛
			<th>数据库已发数量
			<th>数据库可发数量
			<th>redis数量(校验用)
			<th>redis数量(统计用)
			</tr>";
foreach ($dataSendNum as $sk => $sr) {
	$errMessage .= $sr['id']."批次缓存不一致,可发".$sr['db_issue_num'].",已发".$sr['db_send_num'].".";
	$message .= '<tr><td>'.$sr['id'].'</td><td>'.($allData[$sk]['money']/1000).'</td><td>'.($tempSaveRestriction[$sk]['threshold']/1000).'</td><td>'.$sr['db_send_num'].'</td><td>'.$sr['db_issue_num'].'</td><td>'.($sr['redis']).'</td><td>不统计</td></tr>';
}

foreach ($numDiffArray as $sk => $sr) {
	$errMessage .= $sr['id']."数据超发,可发".$sr['db_issue_num'].",已发".$sr['db_send_num'].".";
	$message .= '<tr><td>'.$sk.'</td><td>'.($allData[$sk]['money']/1000).'</td><td>'.($tempSaveRestriction[$sk]['threshold']/1000).'</td><td>'.$allData[$sk]['db_send_num'].'</td><td>'.$allData[$sk]['db_issue_num'].'</td><td>'.($allData[$sk]['redis']).'</td>
				<td>'.$sr[0].'</td></tr>';
}
$message .= "</table>";

$message .= "批次可用时间小于发券时间异常监控<br>";
$message .= "<table border='2'>
			<tr>
			<th>批次id
			</tr>";
foreach ($dataTimeErr as $sr) {
	$errMessage .= $sr."批次可用时间小于发券时间.";
	$message .= '<tr><td>'.$sr.'</td></tr>';
}
$message .= "</table>";



$message .= "使用规则redis与数据库不一致<br>";
$message .= "<table border='2'>
			<tr>
			<th>批次id
			<th>差异项
			</tr>";
foreach ($dataRestrictionArray as $sr) {
	$errMessage .= $sr['id']."使用规则redis与数据库不一致.";
	$message .= '<tr><td>'.$sr['id'].'</td><td>'.$sr['diff'].'</td></tr>';
}
$message .= "</table>";


// 更多报头
$headers .= 'From: <giftcard-server@baidu.com>' . "\r\n";
//$headers .= 'Cc: yechen01@baidu.com' . "\r\n";

$smsMsg = $errMessage;
$smsMsg = iconv("utf-8", "gb2312", $smsMsg);

mail($to,$subject,$message,$headers);
$xq = date("w");
if ($xq == 0 || $xq == 6) {
	//叶琛
	exec('gsmsend -s emp01.baidu.com:15003 15321720739@"'.$smsMsg.'"');
}
echo "Mail Sent.";
