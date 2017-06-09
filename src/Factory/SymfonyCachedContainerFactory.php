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

namespace Vainyl\Di\Factory;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Vainyl\Core\AbstractIdentifiable;
use Vainyl\Core\Application\EnvironmentInterface;
use Vainyl\Di\Factory\Decorator\ContainerFactoryAdapterDecorator;
use Vainyl\Di\Factory\Decorator\ContainerFactoryCacheDecorator;
use Vainyl\Di\Factory\Decorator\ContainerFactoryCompilerDecorator;
use Vainyl\Di\Factory\Decorator\ContainerFactoryDumperDecorator;

/**
 * Class SymfonyCachedContainerFactory
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class SymfonyCachedContainerFactory extends AbstractIdentifiable implements ContainerFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function createContainer(EnvironmentInterface $environment)
    {
        return (new ContainerFactoryAdapterDecorator(
            new ContainerFactoryCacheDecorator(
                new ContainerFactoryDumperDecorator(
                    new ContainerFactoryCompilerDecorator(new SymfonyContainerFactory(new ContainerBuilder()))
                )
            )
        ))->createContainer($environment);
    }
}