<?php
/*
* (c) Wessel Strengholt <wessel.strengholt@gmail.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Usoft\PostcodeBundle\Tests\Services;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Usoft\PostcodeBundle\Model\Address;
use Usoft\PostcodeBundle\Services\AddressClient;

/**
 * Class AddressClientTest
 *
 * @author Wessel Strengholt <wessel.strengholt@gmail.com>
 */
class AddressClientTest extends \PHPUnit_Framework_TestCase
{
    /** @var AddressClient */
    private $addressClient;

    /** @var \PHPUnit_Framework_MockObject_MockObject|ClientInterface */
    private $guzzle;

    /** @var \PHPUnit_Framework_MockObject_MockObject|RequestInterface */
    private $response;

    /** @var \PHPUnit_Framework_MockObject_MockObject|StreamInterface */
    private $stream;

    public function setUp()
    {
        $this->guzzle = $this->createClientInterfaceMock();
        $this->response = $this->createResponseInterfaceMock();
        $this->stream = $this->createStreamInterfaceMock();

        $this->addressClient = new AddressClient($this->guzzle, 'secret-key');
    }

    public function testGetAddress()
    {
        $this->guzzle->expects($this->once())
            ->method('send')
            ->willReturn($this->response);

        $this->response->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(200);

        $this->response->expects($this->once())
            ->method('getBody')
            ->willReturn($this->stream);

        $this->stream->expects($this->once())
            ->method('getContents')
            ->willReturn(file_get_contents(__DIR__ . '/response.json'));

        $this->assertInstanceOf(Address::class, $this->addressClient->getAddress('1010AB', 18));
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ClientInterface
     */
    private function createClientInterfaceMock()
    {
        return $this->getMock(ClientInterface::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ResponseInterface
     */
    private function createResponseInterfaceMock()
    {
        return $this->getMock(ResponseInterface::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|StreamInterface
     */
    private function createStreamInterfaceMock()
    {
        return $this->getMock(StreamInterface::class);
    }
}
