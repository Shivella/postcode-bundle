<?php
/*
* (c) Wessel Strengholt <wessel.strengholt@gmail.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Usoft\PostcodeBundle\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionConfigurationTestCase;
use Usoft\PostcodeBundle\DependencyInjection\Configuration;
use Usoft\PostcodeBundle\DependencyInjection\UsoftPostcodeExtension;

/**
 * Class ConfigurationTest
 *
 * @author Wessel Strengholt <wessel.strengholt@gmail.com>
 */
class ConfigurationTest extends AbstractExtensionConfigurationTestCase
{
    /**
     * @test
     */
    public function testIt_converts_extension_elements_to_extensions()
    {
        $expectedConfiguration = [
            'apiwise' => [
                'key' => 'secret-apiwise-key',
            ]
        ];

        $sources = [__DIR__ . '/Fixtures/config.yml'];

        $this->assertProcessedConfigurationEquals($expectedConfiguration, $sources);
    }

    /**
     * {@inheritdoc}
     */
    protected function getContainerExtension()
    {
        return new UsoftPostcodeExtension();
    }

    /**
     * {@inheritdoc}
     */
    protected function getConfiguration()
    {
        return new Configuration();
    }
}
