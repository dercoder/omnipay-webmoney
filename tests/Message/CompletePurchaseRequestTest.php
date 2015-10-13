<?php
namespace Omnipay\WebMoney\Message;

use Omnipay\Tests\TestCase;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class CompletePurchaseRequestTest extends TestCase
{
    private $request;

    public function setUp()
    {
        parent::setUp();

        $httpRequest = new HttpRequest(array(), array (
            'LMI_MODE' => '1',
            'LMI_PAYMENT_AMOUNT' => '14.65',
            'LMI_PAYEE_PURSE' => 'Z123428476799',
            'LMI_PAYMENT_NO' => '1444212666',
            'LMI_PAYER_WM' => '404521188333',
            'LMI_PAYER_PURSE' => 'Z366393600555',
            'LMI_PAYER_COUNTRYID' => 'AZ',
            'LMI_PAYER_IP' => '127.0.0.1',
            'LMI_SYS_INVS_NO' => '897',
            'LMI_SYS_TRANS_NO' => '892',
            'LMI_SYS_TRANS_DATE' => '20151007 13:07:36',
            'LMI_HASH' => '0B12E75431284D6FCC05D8AF02B90AC28A0788FB95C9FF6B655344022F0746E5',
            'LMI_PAYMENT_DESC' => 'Test',
            'LMI_LANG' => 'en-US',
            'LMI_DBLCHK' => 'SMS'
        ));

        $this->request = new CompletePurchaseRequest($this->getHttpClient(), $httpRequest);
        $this->request->initialize(array(
            'merchantPurse' => 'Z123428476799',
            'secretKey' => '226778888',
            'testMode' => true
        ));
    }

    public function testGetData()
    {
        $data = $this->request->getData();

        $this->assertSame('Z123428476799', $data['LMI_PAYEE_PURSE']);
        $this->assertSame('14.65', $data['LMI_PAYMENT_AMOUNT']);
        $this->assertSame('1444212666', $data['LMI_PAYMENT_NO']);
        $this->assertSame('1', $data['LMI_MODE']);
        $this->assertSame('897', $data['LMI_SYS_INVS_NO']);
        $this->assertSame('892', $data['LMI_SYS_TRANS_NO']);
        $this->assertSame('20151007 13:07:36', $data['LMI_SYS_TRANS_DATE']);
        $this->assertSame('Z366393600555', $data['LMI_PAYER_PURSE']);
        $this->assertSame('404521188333', $data['LMI_PAYER_WM']);
        $this->assertSame('AZ', $data['LMI_PAYER_COUNTRYID']);
        $this->assertSame('127.0.0.1', $data['LMI_PAYER_IP']);
        $this->assertSame('0B12E75431284D6FCC05D8AF02B90AC28A0788FB95C9FF6B655344022F0746E5', $data['LMI_HASH']);
        $this->assertSame('Test', $data['LMI_PAYMENT_DESC']);
        $this->assertSame('en-US', $data['LMI_LANG']);
        $this->assertSame('SMS', $data['LMI_DBLCHK']);
    }

    public function testSendData()
    {
        $data = $this->request->getData();
        $response = $this->request->sendData($data);
        $this->assertSame('Omnipay\WebMoney\Message\CompletePurchaseResponse', get_class($response));
    }
}
