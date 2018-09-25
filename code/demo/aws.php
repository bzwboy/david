<?php
require 'vendor/autoload.php';
//require '/User/ott002/git/david/code/php/helper/http.php';

use Aws\Sqs\SqsClient;
use Aws\Sns\SnsClient;

$credentials = array(
    'region' => 'us-east-2',
    'version' => '2012-11-05',
    'credentials' => array(
        'key'    => 'AKIAIUMZ6OZMZ24ILG7A',
        'secret' => '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',
    )
);
$client = new SqsClient($credentials);
$queueUrl = 'https://sqs.us-east-2.amazonaws.com/686252468268/libo-standard';
$queueUrlDead = 'https://sqs.us-east-2.amazonaws.com/686252468268/libo-standard-dead';

function getQueueArn() {
    global $client, $queueUrl;

    // string(48) "arn:aws:sqs:us-east-2:686252468268:libo-standard"
    print_r($client->getQueueArn($queueUrl));
}

function getQueueUrl() {
    global $client;

    $result = $client->getQueueUrl([
        'QueueName' => 'libo-standard', // REQUIRED
    ]);
    var_export($result);
}

function listQueue() {
    global $client;

    /*
    Array
    (
        [0] => https://sqs.us-east-2.amazonaws.com/686252468268/libo-standard
        [1] => https://sqs.us-east-2.amazonaws.com/686252468268/libo-standard-dead
        [2] => https://sqs.us-east-2.amazonaws.com/686252468268/libo.fifo
    )
    */
    $result = $client->listQueues();
    print_r($result->get('QueueUrls'));
}

function sendMessage() {
    global $client, $queueUrl;

    $args = [
        'QueueUrl' => $queueUrl,
        'MessageBody' => date('Y-m-d H:i:s') . ' ' . time(),
    ];
    $result = $client->sendMessage($args);
    print_r($result->toArray());
}

function receiveMessage($queue) {
    global $client;

    $args = [
        'QueueUrl' => $queue,
        'MaxNumberOfMessages' => 10,
        'VisibilityTimeout' => 0, // second
//        'WaitTimeSeconds' => 20, // long poll
        'AttributeNames' => ['All'],
    ];
    $ret = $client->receiveMessage($args);
    return $ret->toArray()['Messages'];
}

function deleteMessage($messageInfo) {
    global $client, $queueUrl;

    $args = [
        'QueueUrl' => $queueUrl,
        'ReceiptHandle' => $messageInfo[0]['ReceiptHandle']
    ];
    print_r($client->deleteMessage($args));
}

function createQueue() {
    global $client;

    $args = [
        'QueueName' => 'test_queue_1',
        'FifoQueue' => false,
    ];
    print_r($client->createQueue($args));
}

function deleteQueue() {
    global $client;

    $args = [
        'QueueUrl' => 'https://sqs.us-east-2.amazonaws.com/686252468268/test_queue_1',
    ];
    print_r($client->deleteQueue($args));
}



//listQueue();

//sendMessage();

$messageInfo = receiveMessage($queueUrl);
print_r($messageInfo);
deleteMessage($messageInfo);

//createQueue();
//deleteQueue();
