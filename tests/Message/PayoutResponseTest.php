<?php
namespace Omnipay\WebMoney\Message;

use Omnipay\Tests\TestCase;

class PayoutResponseTest extends TestCase
{

    private $request;

    public function setUp()
    {
        parent::setUp();

        $class = new \ReflectionObject($this);
        $directory = dirname($class->getFileName());
        $sslFile = realpath($directory . '/../Certificate/webmoney.pem');
        $sslKey = realpath($directory . '/../Certificate/webmoney.key');

        $this->request = new PayoutRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(array(
            'webMoneyId' => '811333344777',
            'merchantPurse' => 'Z123428476799',
            'secretKey' => '226778888',
            'sslFile' => $sslFile,
            'sslKey' => $sslKey,
            'transactionId' => '1444111666',
            'requestNumber' => '111222333',
            'customerPurse' => 'Z123428476700',
            'protectionPeriod' => '60',
            'protectionCode' => 'xyZ123',
            'invoiceId' => '12345678',
            'onlyAuth' => false,
            'description' => 'Payout',
            'amount' => '12.46'
        ));
    }

    public function testFailure()
    {
        $httpResponse = $this->getMockHttpResponse('PayoutFailure.txt');
        $response = new PayoutResponse($this->request, $httpResponse->xml());

        $this->assertFalse($response->isSuccessful());
        $this->assertSame(17, $response->getCode());
        $this->assertSame('create error step=13', $response->getMessage());
        $this->assertNull($response->getTransactionId());
        $this->assertNull($response->getTransactionReference());
        $this->assertNull($response->getDescription());
        $this->assertNull($response->getAmount());
    }

    public function testSuccess()
    {
        $httpResponse = $this->getMockHttpResponse('PayoutSuccess.txt');
        $response = new PayoutResponse($this->request, $httpResponse->xml());

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(0, $response->getCode());
        $this->assertNull($response->getMessage());
        $this->assertSame('1444111666', $response->getTransactionId());
        $this->assertSame('1242314716', $response->getTransactionReference());
        $this->assertSame('Payout', $response->getDescription());
        $this->assertSame('12.46', $response->getAmount());
    }

}
