<?php
/**
 * Vainyl
 *
 * PHP Version 7
 *
 * @package   Di
 * @license   https://opensource.org/licenses/MIT MIT License
 * @link      https://vainyl.com
 */
declare(strict_types=1);

namespace Vainyl\Di\Factory\Decorator;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Vainyl\Core\Application\EnvironmentInterface;

/**
 * Class ContainerFactoryExtensionDecorator
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class ContainerFactoryExtensionDecorator extends AbstractContainerFactoryDecorator
{
    /**
     * @inheritDoc
     */
    public function createContainer(EnvironmentInterface $environment)
    {
        /**
         * @var ContainerBuilder $containerBuilder
         */
        $containerBuilder = parent::createContainer($environment);

        foreach ($environment->getExtensions() as $extension) {
            $extension->load([], $containerBuilder, $environment);
        }

        return $containerBuilder;
    }
}