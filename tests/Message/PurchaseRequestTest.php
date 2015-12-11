<?php
namespace Omnipay\WebMoney\Message;

use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    private $request;

    public function setUp()
    {
        parent::setUp();

        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(array(
            'merchantPurse' => 'Z123428476799',
            'secretKey' => '226778888',
            'returnUrl' => 'https://www.foodstore.com/success',
            'cancelUrl' => 'https://www.foodstore.com/failure',
            'notifyUrl' => 'https://www.foodstore.com/notify',
            'returnMethod' => 'POST',
            'cancelMethod' => 'link',
            'description' => 'Test Transaction',
            'transactionId' => '1234567890',
            'amount' => '14.65',
            'currency' => 'USD',
            'testMode' => true
        ));
    }

    public function testException()
    {
        $this->request->setCurrency('EUR');

        try {
            $this->request->getData();
        } catch (\Exception $e) {
            $this->assertEquals('Omnipay\Common\Exception\InvalidRequestException', get_class($e));
        }
    }

    public function testGetData()
    {
        $data = $this->request->getData();

        $this->assertSame('Z123428476799', $data['LMI_PAYEE_PURSE']);
        $this->assertSame('14.65', $data['LMI_PAYMENT_AMOUNT']);
        $this->assertSame('1234567890', $data['LMI_PAYMENT_NO']);
        $this->assertSame('VGVzdCBUcmFuc2FjdGlvbg==', $data['LMI_PAYMENT_DESC_BASE64']);
        $this->assertSame('2', $data['LMI_SIM_MODE']);
        $this->assertSame('https://www.foodstore.com/notify', $data['LMI_RESULT_URL']);
        $this->assertSame('https://www.foodstore.com/success', $data['LMI_SUCCESS_URL']);
        $this->assertSame('1', $data['LMI_SUCCESS_METHOD']);
        $this->assertSame('https://www.foodstore.com/failure', $data['LMI_FAIL_URL']);
        $this->assertSame('2', $data['LMI_FAIL_METHOD']);
    }

    public function testSendData()
    {
        $data = $this->request->getData();
        $response = $this->request->sendData($data);
        $this->assertSame('Omnipay\WebMoney\Message\PurchaseResponse', get_class($response));
    }

    public function testGetCurrencyByPurse()
    {
        $this->assertSame('USD', $this->request->getCurrencyByPurse('Z123428476799'));
        $this->assertSame('RUB', $this->request->getCurrencyByPurse('R123428476799'));
        $this->assertSame('EUR', $this->request->getCurrencyByPurse('E123428476799'));
        $this->assertSame('UAH', $this->request->getCurrencyByPurse('U123428476799'));
        $this->assertSame('KZT', $this->request->getCurrencyByPurse('K123428476799'));
        $this->assertSame('UZS', $this->request->getCurrencyByPurse('Y123428476799'));
        $this->assertSame('BYR', $this->request->getCurrencyByPurse('B123428476799'));
        $this->assertSame('BTC', $this->request->getCurrencyByPurse('X123428476799'));
        $this->assertNull($this->request->getCurrencyByPurse('A123428476799'));
    }
}
