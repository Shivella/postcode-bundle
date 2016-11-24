<?php
/*
* (c) Wessel Strengholt <wessel.strengholt@gmail.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Usoft\PostcodeBundle\Services;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;
use Symfony\Component\HttpFoundation\Response;
use Usoft\PostcodeBundle\Exceptions\InvalidApiResponseException;
use Usoft\PostcodeBundle\Exceptions\InvalidPostcodeException;
use Usoft\PostcodeBundle\Model\Address;

/**
 * Class AddressClient
 *
 * @author Wessel Strengholt <wessel.strengholt@gmail.com>
 */
class AddressClient
{
    /** @var ClientInterface */
    private $client;

    /** @var string */
    private $apiKey;

    /**
     * @param ClientInterface $client
     * @param string          $apiKey
     */
    public function __construct(ClientInterface $client, $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    /**
     * @param string  $postcode
     * @param integer $houseNumber
     *
     * @throws InvalidPostcodeException
     * @throws InvalidApiResponseException
     *
     * @return Address
     */
    public function getAddress($postcode, $houseNumber)
    {
        if (0 === preg_match('/^[1-9]{1}[0-9]{3}[\s]{0,1}[a-z]{2}$/i', $postcode)) {
            throw new InvalidPostcodeException('Given postcode incorrect');
        }

        $header = ['X-Api-Key' => $this->apiKey];
        $url = sprintf('https://postcode-api.apiwise.nl/v2/addresses/?postcode=%s&number=%d', $postcode, (int) $houseNumber);
        $request = new Request('GET', $url, $header);

        try {
            $response = $this->client->send($request);

            if ($response->getStatusCode() !== Response::HTTP_OK) {
                throw new InvalidApiResponseException('The API does not return a 200 status-code');
            }

            $data = json_decode($response->getBody()->getContents(), true);

            if (false === isset($data['_embedded']['addresses'][0])) {
                throw new InvalidApiResponseException('Address cannot be set from API data');
            }

            $address = $data['_embedded']['addresses'][0];

            $city = $address['city']['label'];
            $street = $address['street'];
            $province = $address['province']['label'];

            $geoLocation = [
                'longitude'  => isset($address['geo']['center']['wgs84']['coordinates'][1]) ? $address['geo']['center']['wgs84']['coordinates'][0] : null,
                'latitude' => isset($address['geo']['center']['wgs84']['coordinates'][0]) ? $address['geo']['center']['wgs84']['coordinates'][1] : null,
            ];

            $address = new Address($street, $postcode, $city, $houseNumber, $province);
            $address->setGeoLocation($geoLocation);

            return $address;

        } catch (\Exception $exception) {
            throw new InvalidApiResponseException($exception->getMessage());
        }
    }
}
