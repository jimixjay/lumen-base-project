<?php

namespace App\Http\Middleware;

use App\Services\RequestData;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Jimixjay\DateHelper\Date;

class ApiCompleteLogger
{
    private $logDir;

    public function __construct()
    {
        $this->logDir = storage_path(config('app.api_complete_log_dir'));

        if (!file_exists($this->logDir)) {
            try {
                mkdir($this->logDir, 0755);
            } catch (\Exception $e) {
                Log::channel('error')->error('error creating folder for logs');
            }
        }
    }

    private function logOutput($filename, $dataToLog, Request $request)
    {
        if (env('LOG_OUTPUT') != 'file') {

            $logContext = [
                'RequestId' => $this->getRequestId($request),
                'URL'       => $request->fullUrl(),
                'Method'    => $request->method(),
            ];

            Log::channel(config('app.api_log_channel'))->info($dataToLog, $logContext);

        } else {
            File::append($this->logDir . $filename, $dataToLog);
        }
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$this->loggableRequest($request)) {
            return $next($request);
        }

        $requestId = $this->getRequestId($request);

        $response = $next($request);

        $dataToLog = 'RequestId: ' . $requestId . "\n";
        $dataToLog .= 'Time: ' . LUMEN_START_DATE . "\n";
        $dataToLog .= "IP Address: -\n";
        $dataToLog .= 'URL: ' . $request->fullUrl() . "\n";
        $dataToLog .= 'Method: ' . $request->method() . "\n";
        $dataToLog .= "JWT: -\n";
        $dataToLog .= 'Content-Length: ' . $request->header('Content-Length') . "\n";
        $dataToLog .= 'Input: ' . $request->getContent() . "\n";
        $dataToLog = str_repeat("=", 36) . 'REQUEST' . str_repeat("=", 37) . "\n\n" . $dataToLog;
        $endTime   = microtime(true);
        $duration  = number_format($endTime - LUMEN_START, 3);
        $dataToLog .= str_repeat("=", 36) . 'RESPONSE' . str_repeat("=", 36) . "\n\n";
        $dataToLog .= 'RequestId: ' . $requestId . "\n";
        $dataToLog .= 'Time: ' . gmdate(Date::TIMESTAMP) . "\n";
        $dataToLog .= 'Duration: ' . $duration . "s\n";
        $dataToLog .= 'Output: ' . $response->getContent() . "\n";
        $dataToLog .= "\n" . str_repeat("-", 80) . "\n";

        $filename = $this->getLogFilename();

        $this->logOutput($filename, $dataToLog, $request);

        return $response;
    }

    private function loggableRequest(Request $request)
    {
        return (!empty($request->header('Authorization') || !empty($request->header('x-api-key'))));
    }

    private function getRequestId(Request $request)
    {
        $chain = '';
        $chain .= $request->header('Authorization');
        $chain .= $request->fullUrl();
        $chain .= $request->getContent();
        $chain .= $request->server->get('REQUEST_TIME');

        $requestId = md5($chain);

        $_SESSION['request_id'] = $requestId;

        return $requestId;
    }

    private function getLogFilename()
    {
        return date('Y-m-d_H') . '.log';
    }

}
