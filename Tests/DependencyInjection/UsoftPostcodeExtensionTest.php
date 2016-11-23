<?php
/*
* (c) Wessel Strengholt <wessel.strengholt@gmail.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Usoft\PostcodeBundle\Tests\DependencyInjection;

use Usoft\PostcodeBundle\DependencyInjection\UsoftPostcodeExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

/**
 * Class UsoftPostcodeExtensionTest
 *
 * @author Wessel Strengholt <wessel.strengholt@gmail.com>
 */
class UsoftPostcodeExtensionTest extends AbstractExtensionTestCase
{
    public function testAfterLoadingTheCorrectParameterHasBeenSet()
    {
        $this->load(array('apiwise' => array('key' => 'secret-key')));

        $this->assertContainerBuilderHasParameter('postcode_api_key', 'secret-key');
    }

    /**
     * {@inheritdoc}
     */
    protected function getContainerExtensions()
    {
        return [
            new UsoftPostcodeExtension(),
        ];
    }
}
