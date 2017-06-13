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

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Vainyl\Core\AbstractIdentifiable;
use Vainyl\Core\Application\EnvironmentInterface;

/**
 * Class SymfonyContainerFactory
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class SymfonyContainerFactory extends AbstractIdentifiable implements ContainerFactoryInterface
{
    private $containerBuilder;

    /**
     * SymfonyContainerFactory constructor.
     *
     * @param ContainerBuilder $containerBuilder
     */
    public function __construct(ContainerBuilder $containerBuilder)
    {
        $this->containerBuilder = $containerBuilder;
    }

    /**
     * @inheritDoc
     */
    public function createContainer(EnvironmentInterface $environment)
    {
        $loader = new YamlFileLoader($this->containerBuilder, new FileLocator($environment->getConfigDirectory()));
        $loader->load($environment->getContainerConfig());

        foreach ($environment->getExtensions() as $extension) {
            $extension->load([], $this->containerBuilder, $environment);
        }

        return $this->containerBuilder;
    }
}