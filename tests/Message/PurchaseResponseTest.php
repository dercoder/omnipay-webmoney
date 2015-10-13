<?php
namespace Omnipay\WebMoney\Message;

use Omnipay\Tests\TestCase;

class PurchaseResponseTest extends TestCase
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
            'description' => 'Test Transaction',
            'transactionId' => '1234567890',
            'amount' => '14.65',
            'currency' => 'USD',
            'testMode' => true
        ));
    }

    public function testSuccess()
    {
        $response = $this->request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertNull($response->getCode());
        $this->assertNull($response->getMessage());
        $this->assertSame('POST', $response->getRedirectMethod());
        $this->assertSame('https://merchant.wmtransfer.com/lmi/payment.asp', $response->getRedirectUrl());
        $this->assertSame(array(
            'LMI_PAYEE_PURSE' => 'Z123428476799',
            'LMI_PAYMENT_AMOUNT' => '14.65',
            'LMI_PAYMENT_NO' => '1234567890',
            'LMI_PAYMENT_DESC_BASE64' => 'VGVzdCBUcmFuc2FjdGlvbg==',
            'LMI_SIM_MODE' => '2',
            'LMI_RESULT_URL' => 'https://www.foodstore.com/notify',
            'LMI_SUCCESS_URL' => 'https://www.foodstore.com/success',
            'LMI_SUCCESS_METHOD' => '0',
            'LMI_FAIL_URL' => 'https://www.foodstore.com/failure',
            'LMI_FAIL_METHOD' => '0'
        ), $response->getRedirectData());
    }
}
