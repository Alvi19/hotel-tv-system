<?php

namespace App\Services;

use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use Illuminate\Support\Facades\Log;

class MqttService
{
    protected $client;

    public function __construct()
    {
        $brokerUrl = env('MQTT_BROKER');
        $username  = env('MQTT_USERNAME');
        $password  = env('MQTT_PASSWORD');
        $clientId  = env('MQTT_CLIENT_ID', 'laravel_backend_' . uniqid());

        $parsed = parse_url($brokerUrl);
        $host   = $parsed['host'] ?? 'localhost';
        $port   = $parsed['port'] ?? 8883;

        $settings = (new ConnectionSettings)
            ->setUsername($username)
            ->setPassword($password)
            ->setUseTls(true)
            ->setTlsVerifyPeer(true)
            ->setTlsSelfSignedAllowed(false);

        try {
            $this->client = new MqttClient($host, $port, $clientId);
            $this->client->connect($settings, true);
            Log::info("✅ MQTT connected to {$host}:{$port} as {$clientId}");
        } catch (\Exception $e) {
            Log::error("❌ MQTT connection failed: " . $e->getMessage());
        }
    }

    public function publish(string $topic, array $payload)
    {
        try {
            $json = json_encode($payload);
            $this->client->publish($topic, $json, 0, false);
            Log::info("📤 MQTT published to {$topic}: {$json}");
        } catch (\Exception $e) {
            Log::error("❌ MQTT publish failed: " . $e->getMessage());
        } finally {
            $this->client->disconnect();
        }
    }
}
