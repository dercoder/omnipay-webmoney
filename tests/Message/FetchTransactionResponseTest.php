<?php
namespace Omnipay\WebMoney\Message;

use Omnipay\Tests\TestCase;

class FetchTransactionResponseTest extends TestCase
{

    private $request;

    public function setUp()
    {
        parent::setUp();

        $this->request = new FetchTransactionRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(array(
            'webMoneyId' => '811333344777',
            'merchantPurse' => 'Z123428476799',
            'secretKey' => '226778888',
            'transactionId' => '1444212666'
        ));
    }

    public function testFailure()
    {
        $httpResponse = $this->getMockHttpResponse('FetchTransactionFailure.txt');
        $response = new FetchTransactionResponse($this->request, $httpResponse->xml());

        $this->assertFalse($response->isSuccessful());
        $this->assertSame(7, $response->getCode());
        $this->assertSame('Payment with lmi_payment_no number not found for this merchant purse:7 step=50', $response->getMessage());
        $this->assertNull($response->getTransactionReference());
        $this->assertNull($response->getDescription());
        $this->assertNull($response->getAmount());
        $this->assertNull($response->getClientIp());
    }

    public function testSuccess()
    {
        $httpResponse = $this->getMockHttpResponse('FetchTransactionSuccess.txt');
        $response = new FetchTransactionResponse($this->request, $httpResponse->xml());

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(0, $response->getCode());
        $this->assertNull($response->getMessage());
        $this->assertSame('1234566789', $response->getTransactionReference());
        $this->assertSame('Transaction Description', $response->getDescription());
        $this->assertSame('12.46', $response->getAmount());
        $this->assertSame('127.0.0.1', $response->getClientIp());
    }

}
