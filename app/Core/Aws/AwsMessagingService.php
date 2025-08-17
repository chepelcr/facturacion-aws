<?php

namespace Core\Aws;

use Aws\Sdk;
use Aws\Sqs\SqsClient;
use Aws\Sns\SnsClient;
use Aws\Exception\AwsException;

class AwsMessagingService {
    /** @var Sdk **/
    private $sdk;

    /**
     * @param string|null $profile  Nombre del perfil en ~/.aws/credentials
     */
    public function __construct() {
        $this->sdk = new Sdk([
            'region'  => getEnt('aws.region'),
            'version' => 'latest',
            'profile' => 'J-CAMPOS'
        ]);
    }

    /**
     * @return SqsClient
     */
    private function getSqsClient(): SqsClient {
        return $this->sdk->createSqs();
    }

    /**
     * @return SnsClient
     */
    private function getSnsClient(): SnsClient {
        return $this->sdk->createSns();
    }

    public function sendMessageToQueue(
        string $queueUrl,
        string $messageBody,
        array $messageAttributes = [],
        int $delaySeconds = 0
    ): array {
        try {
            $params = [
                'QueueUrl'    => $queueUrl,
                'MessageBody' => $messageBody,
            ];
            if ($messageAttributes) {
                $params['MessageAttributes'] = $messageAttributes;
            }
            if ($delaySeconds > 0) {
                $params['DelaySeconds'] = $delaySeconds;
            }
            $result = $this->getSqsClient()->sendMessage($params);
            return $result->toArray();
        } catch (AwsException $e) {
            throw new \Exception("Error enviando mensaje a SQS: " . $e->getMessage());
        }
    }

    public function publishToTopic(
        string $topicArn,
        string $message,
        array $messageAttributes = []
    ): array {
        try {
            $params = [
                'TopicArn' => $topicArn,
                'Message'  => $message,
            ];
            if ($messageAttributes) {
                $params['MessageAttributes'] = $messageAttributes;
            }
            $result = $this->getSnsClient()->publish($params);
            return $result->toArray();
        } catch (AwsException $e) {
            throw new \Exception("Error publicando en SNS: " . $e->getMessage());
        }
    }
}
