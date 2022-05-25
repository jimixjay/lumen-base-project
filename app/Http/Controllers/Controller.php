<?php

namespace App\Http\Controllers;

use App\Repositories\ActivationStatus\PSQLActivationStatusRepository;
use App\Repositories\MobileActivationStatuses\PSQLMobileActivationStatusesRepository;
use App\Repositories\OrderBroadband\PSQLOrderBroadbandRepository;
use App\Repositories\OrderMobile\PSQLOrderMobileRepository;
use App\Repositories\OrderStatus\PSQLOrderStatusRepository;
use App\Repositories\PSQLStatusRepository;
use App\Services\LoggerService;
use App\Services\Order\Status\Activation\BroadbandActivationDateGetter;
use App\Services\Order\Status\Activation\BroadbandActivationStatusGetter;
use App\Services\Order\Status\Activation\MobileActivationStatusGetter;
use App\Services\Order\Status\Msisdn\BroadbandMsisdnGetter;
use App\Services\Order\Status\Msisdn\MobileMsisdnGetter;
use App\Services\Order\Status\OrderUpdate;
use App\Services\Soap\Helpers\SoapRequestManager;
use App\Services\Soap\Request\QueryOrderInfoRequester;
use App\Services\Soap\Request\QuerySIMInfoRequester;
use App\Services\Soap\Request\QuerySubscriberInfoRequester;
use App\Services\Status\StatusCheckConditions;
use JsonException;
use Laravel\Lumen\Routing\Controller as BaseController;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Controller extends BaseController
{
    protected function exceptionErrorResponse($e, $httpStatus = 500, $responseMessage = null)
    {
        LoggerService::log('error', 'error', $e->getMessage());
        LoggerService::log('error', 'error', $e->getTraceAsString());

        if ($e instanceof JsonException) {
            $responseMessage = 'JSON input error: ' . $e->getMessage();
        }

        if ($e instanceof HttpException) {
            $httpStatus      = $e->getStatusCode();
            $responseMessage = $e->getMessage();
        }

        $responseMessage = $responseMessage ?? $e->getMessage();

        $exceptionCode = $e->getCode();

        return responseError($exceptionCode, $responseMessage, $e, $httpStatus);
    }

}
