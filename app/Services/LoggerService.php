<?php

namespace App\Services;


use Illuminate\Support\Facades\Log;

class LoggerService
{

    const INFO = 'info';
    const EMERGENCY = 'emergency';
    const ALERT = 'alert';
    const CRITICAL = 'critical';
    const ERROR = 'error';
    const WARNING = 'warning';
    const NOTICE = 'notice';
    const DEBUG = 'debug';

    public static function log($channels, $type, $data)
    {
        $requestId = 'NOSESSIONVAR';
        if (isset($_SESSION['request_id'])) {
            $requestId = $_SESSION['request_id'];
        }

        $data = 'REQUEST ID: ' . $requestId . '

        ' . $data;

        if (!is_array($channels)) {
            $channels = [$channels];
        }

        foreach ($channels as $channel) {
            Log::channel($channel)->{$type}($data);
        }
    }

    public function addLogEntry($channels, $type, $data)
    {
        $requestId = 'NOSESSIONVAR';
        if (isset($_SESSION['request_id'])) {
            $requestId = $_SESSION['request_id'];
        }

        $data = 'REQUEST ID: ' . $requestId . '

        ' . $data;

        if (!is_array($channels)) {
            $channels = [$channels];
        }

        foreach ($channels as $channel) {
            Log::channel($channel)->{$type}($data);
        }
    }

}
