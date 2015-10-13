<?php
namespace Omnipay\WebMoney\Message;

use Omnipay\Tests\TestCase;

class FetchTransactionRequestTest extends TestCase
{
    private $request;

    public function setUp()
    {
        parent::setUp();

        $mockPlugin = new \Guzzle\Plugin\Mock\MockPlugin();
        $mockPlugin->addResponse($this->getMockHttpResponse('FetchTransactionSuccess.txt'));

        $httpClient = $this->getHttpClient();
        $httpClient->addSubscriber($mockPlugin);

        $this->request = new FetchTransactionRequest($httpClient, $this->getHttpRequest());
        $this->request->initialize(array(
            'webMoneyId' => '811333344777',
            'merchantPurse' => 'Z123428476799',
            'secretKey' => '226778888',
            'transactionId' => '1444212666'
        ));
    }

    public function testGetData()
    {
        $data = $this->request->getData();
        $request = new \SimpleXMLElement($data);

        $this->assertSame('811333344777', (string) $request->wmid);
        $this->assertSame('Z123428476799', (string) $request->lmi_payee_purse);
        $this->assertSame('1444212666', (string) $request->lmi_payment_no);
        $this->assertSame('0b1fbe2eaccf29e86e144c486b2ccf258b56fb54c295f195af7a749f6f5c79d4', (string) $request->sha256);
        $this->assertSame('edd00dcbfed2c3846393e9ce315b3af2', (string) $request->md5);
    }

    public function testSendData()
    {
        $data = $this->request->getData();
        $response = $this->request->sendData($data);
        $this->assertSame('Omnipay\WebMoney\Message\FetchTransactionResponse', get_class($response));
    }
}
