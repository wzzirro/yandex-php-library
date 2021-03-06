<?php
/**
 * Yandex PHP Library
 *
 * @copyright NIX Solutions Ltd.
 * @link https://github.com/nixsolutions/yandex-php-library
 */

/**
 * @namespace
 */
namespace Yandex\Market\Partner;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Message\RequestInterface;
use Yandex\Common\AbstractServiceClient;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Request;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Exception\ClientException;
use Yandex\Common\Exception\ForbiddenException;
use Yandex\Common\Exception\UnauthorizedException;
use Yandex\Market\Partner\Exception\PartnerRequestException;
use Yandex\Market\Models;

/**
 * Class PartnerClient
 *
 * @category Yandex
 * @package Market
 *
 * @author   Alexander Khaylo <naxel@land.ru>
 * @created  04.11.13 12:48
 */
class PartnerClient extends AbstractServiceClient
{

    /**
     * Order is being processed
     */
    const ORDER_STATUS_PROCESSING = 'PROCESSING';

    /**
     * Order submitted to the delivery
     */
    const ORDER_STATUS_DELIVERY = 'DELIVERY';

    /**
     *  Order delivered to the point of self-delivery
     */
    const ORDER_STATUS_PICKUP = 'PICKUP';

    /**
     * The order is received by the buyer
     */
    const ORDER_STATUS_DELIVERED = 'DELIVERED';

    /**
     * Order canceled.
     */
    const ORDER_STATUS_CANCELLED = 'CANCELLED';

    //Sub-statuses for status CANCELLED
    // - the buyer is not finalized the reserved order on time
    const ORDER_SUBSTATUS_RESERVATION_EXPIRED = 'RESERVATION_EXPIRED';
    // - the buyer did not pay for the order ( for the type of payment PREPAID)
    const ORDER_SUBSTATUS_USER_NOT_PAID = 'USER_NOT_PAID';
    // - failed to communicate with the buyer
    const ORDER_SUBSTATUS_USER_UNREACHABLE = 'USER_UNREACHABLE';
    // - buyer canceled the order for cause
    const ORDER_SUBSTATUS_USER_CHANGED_MIND = 'USER_CHANGED_MIND';
    // - the buyer is not satisfied with the terms of delivery
    const ORDER_SUBSTATUS_USER_REFUSED_DELIVERY = 'USER_REFUSED_DELIVERY';
    // - the buyer did not fit the goods
    const ORDER_SUBSTATUS_USER_REFUSED_PRODUCT = 'USER_REFUSED_PRODUCT';
    // - shop can not fulfill the order
    const ORDER_SUBSTATUS_SHOP_FAILED = 'SHOP_FAILED';
    // - the buyer is not satisfied with the quality of the goods
    const ORDER_SUBSTATUS_USER_REFUSED_QUALITY = 'USER_REFUSED_QUALITY';
    // - buyer changes the composition of the order
    const ORDER_SUBSTATUS_REPLACING_ORDER = 'REPLACING_ORDER';
    //- store does not process orders on time
    const ORDER_SUBSTATUS_PROCESSING_EXPIRED = 'PROCESSING_EXPIRED';

    //???????????? ???????????? ????????????
    //???????????????????? ?????????? ????????????;
    const PAYMENT_METHOD_YANDEX = 'YANDEX';
    //???????????????????? ???????????????? ????????????????,
    //???? ???????????????????????? ???????????????????? ?????????? ????????????.
    const PAYMENT_METHOD_SHOP_PREPAID = 'SHOP_PREPAID';
    // ???????????????? ???????????? ?????? ?????????????????? ????????????;
    const PAYMENT_METHOD_CASH_ON_DELIVERY = 'CASH_ON_DELIVERY';
    // ???????????? ???????????????????? ???????????? ?????? ?????????????????? ????????????.
    const PAYMENT_METHOD_CARD_ON_DELIVERY = 'CARD_ON_DELIVERY';

    //???????? ????????????????
    //???????????????????? ????????????????
    const DELIVERY_TYPE_DELIVERY = 'DELIVERY';
    //??????????????????
    const DELIVERY_TYPE_PICKUP = 'PICKUP';
    //??????????
    const DELIVERY_TYPE_POST = 'POST';

    const ORDER_DECLINE_REASON_OUT_OF_DATE= 'OUT_OF_DATE';

    /**
     * Requested version of API
     * @var string
     */
    private $version = 'v2';

    /**
     * Application id
     *
     * @var string
     */
    protected $clientId;

    /**
     * User login
     *
     * @var string
     */
    protected $login;

    /**
     * Campaign Id
     *
     * @var string
     */
    protected $campaignId;

    /**
     * API domain
     *
     * @var string
     */
    protected $serviceDomain = 'api.partner.market.yandex.ru';

    /**
     * Get url to service resource with parameters
     *
     * @param string $resource
     * @see http://api.yandex.ru/market/partner/doc/dg/concepts/method-call.xml
     * @return string
     */
    public function getServiceUrl($resource = '')
    {
        return $this->serviceScheme . '://' . $this->serviceDomain . '/'
        . $this->version . '/' . $resource;
    }

    /**
     * @param string $token access token
     */
    public function __construct($token = '')
    {
        $this->setAccessToken($token);
    }

    /**
     * @param string $clientId
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     * @param string $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @param string $campaignId
     */
    public function setCampaignId($campaignId)
    {
        $this->campaignId = $campaignId;
    }

    /**
     * @return string
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Sends a request
     *
     * @param ClientInterface $client
     * @param RequestInterface $request
     * @return Response
     * @throws ForbiddenException
     * @throws UnauthorizedException
     * @throws PartnerRequestException
     */
    protected function sendRequest(ClientInterface $client, RequestInterface $request)
    {
        try {

            $request = $this->prepareRequest($request);
            $response = $client->send($request);

        } catch (ClientException $ex) {

            $result = $ex->getResponse();
            $code = $result->getStatusCode();
            $message = $result->getReasonPhrase();

            $body = $result->getBody();
            if ($body) {
                $jsonBody = json_decode($body);
                if ($jsonBody && isset($jsonBody->error) && isset($jsonBody->error->message)) {
                    $message = $jsonBody->error->message;
                }
            }

            if ($code === 403) {
                throw new ForbiddenException($message);
            }

            if ($code === 401) {
                throw new UnauthorizedException($message);
            }

            throw new PartnerRequestException(
                'Service responded with error code: "' . $code . '" and message: "' . $message . '"'
            );
        }

        return $response;
    }

    /**
     * Get OAuth data for header request
     *
     * @see http://api.yandex.ru/market/partner/doc/dg/concepts/authorization.xml
     *
     * @return string
     */
    public function getAccessToken()
    {
        return 'oauth_token=' . parent::getAccessToken() . ', oauth_client_id=' . $this->getClientId()
        . ', oauth_login=' . $this->getLogin();
    }

    /**
     * Get User Campaigns
     *
     * Returns the user to the list of campaigns Yandex.market.
     * The list coincides with the list of campaigns
     * that are displayed in the partner interface Yandex.Market on page "My shops."
     *
     * @see http://api.yandex.ru/market/partner/doc/dg/reference/get-campaigns.xml
     *
     * @return Models\Campaigns
     */
    public function getCampaigns()
    {
        $resource = 'campaigns.json';

        $client = $this->getClient();
        $request = $client->createRequest('GET', $this->getServiceUrl($resource));
        $response = $this->sendRequest($client, $request)->json();
        $getCampaignsResponse = new Models\GetCampaignsResponse($response);
        return $getCampaignsResponse->getCampaigns();
    }


    /**
     * Get information about orders by campaign id
     *
     * @param array $params
     *
     * Returns information on the requested orders.
     * Available filtering by date ordering and order status.
     * The maximum range of dates in a single request for a resource - 30 days.
     *
     * @see http://api.yandex.ru/market/partner/doc/dg/reference/get-campaigns-id-orders.xml
     *
     * @return Models\GetOrdersResponse
     */
    public function getOrdersResponse($params = array())
    {
        $resource = 'campaigns/' . $this->campaignId . '/orders.json';
        $resource .= '?' . http_build_query($params);

        $client = $this->getClient();
        $request = $client->createRequest('GET', $this->getServiceUrl($resource));

        $response = $this->sendRequest($client, $request)->json();
        return new Models\GetOrdersResponse($response);
    }


    /**
     * Get only orders data without pagination
     *
     * @param array $params
     * @return null|Models\Orders
     */
    public function getOrders($params = array())
    {
        return $this->getOrdersResponse($params)->getOrders();
    }


    /**
     * Get order info
     *
     * @param int $orderId
     * @return Models\Order
     *
     * @link http://api.yandex.ru/market/partner/doc/dg/reference/get-campaigns-id-orders-id.xml
     */
    public function getOrder($orderId)
    {
        $resource = 'campaigns/' . $this->campaignId . '/orders/' . $orderId . '.json';

        $client = $this->getClient();
        $request = $client->createRequest('GET', $this->getServiceUrl($resource));

        $response = $this->sendRequest($client, $request)->json();
        $getOrderResponse = new Models\GetOrderResponse($response);
        return $getOrderResponse->getOrder();
    }


    /**
     * Send changed status to Yandex.Market
     *
     * @param int $orderId
     * @param string $status
     * @param null|string $subStatus
     * @return Models\Order
     *
     * @link http://api.yandex.ru/market/partner/doc/dg/reference/put-campaigns-id-orders-id-status.xml
     */
    public function setOrderStatus($orderId, $status, $subStatus = null)
    {
        $resource = 'campaigns/' . $this->campaignId . '/orders/' . $orderId . '/status.json';

        $data = array(
            "order" => array(
                "status" => $status
            )
        );
        if ($subStatus) {
            $data['order']['substatus'] = $subStatus;
        }

        $data = json_encode($data);

        $client = $this->getClient();
        $request = $client->createRequest(
            'PUT',
            $this->getServiceUrl($resource),
            [
                'body' => $data
            ]
        );
        $request->setHeader('Content-type', 'application/json');

        $response = $this->sendRequest($client, $request)->json();
        $updateOrderStatusResponse = new Models\UpdateOrderStatusResponse($response);
        return $updateOrderStatusResponse->getOrder();
    }


    /**
     * Update changed delivery parameters
     *
     * @param int $orderId
     * @param Models\Delivery $delivery
     * @return Models\Order
     *
     * Example:
     * PUT /v2/campaigns/10003/order/12345/delivery.json HTTP/1.1
     *
     * @link http://api.yandex.ru/market/partner/doc/dg/reference/put-campaigns-id-orders-id-delivery.xml
     */
    public function updateDelivery($orderId, Models\Delivery $delivery)
    {
        $resource = 'campaigns/' . $this->campaignId . '/orders/' . $orderId . '/delivery.json';
        $data = json_encode($delivery->toArray());
        $client = $this->getClient();
        $request = $client->createRequest(
            'PUT',
            $this->getServiceUrl($resource),
            [
                'body' => $data
            ]
        );
        $request->setHeader('Content-type', 'application/json');

        $response = $this->sendRequest($client, $request)->json();
        $updateOrderDeliveryResponse = new Models\UpdateOrderDeliveryResponse($response);
        return $updateOrderDeliveryResponse->getOrder();
    }
}
