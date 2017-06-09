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
use Symfony\Component\DependencyInjection\ContainerInterface as SymfonyContainerInterface;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Vainyl\Core\AbstractIdentifiable;
use Vainyl\Core\Application\EnvironmentInterface;
use Vainyl\Di\Exception\UnableToCacheContainerException;

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
     * @param EnvironmentInterface $environment
     *
     * @return ContainerBuilder
     */
    public function initContainer(EnvironmentInterface $environment): ContainerBuilder
    {
        $this->containerBuilder->set('app.environment', $environment);
        $loader = new YamlFileLoader($this->containerBuilder, new FileLocator($environment->getConfigDirectory()));
        $loader->load($environment->getContainerConfig());

        foreach ($environment->getExtensions() as $extension) {
            $extension->load([], $this->containerBuilder, $environment);
        }

        $this->containerBuilder->compile();

        return $this->containerBuilder;
    }

    /**
     * @param EnvironmentInterface $environment
     *
     * @return SymfonyContainerInterface
     */
    public function getCachedContainer(EnvironmentInterface $environment): SymfonyContainerInterface
    {
        $containerPath = sprintf(
            '%s/container/%s.php',
            $environment->getCacheDirectory(),
            sha1($environment->__toString())
        );

        if (file_exists($containerPath)) {
            require_once $containerPath;

            return new \CompiledContainer();
        }

        $container = $this->initContainer($environment);
        if (false === file_exists(dirname($containerPath))) {
            mkdir(dirname($containerPath), 0755, true);
        }
        $dumper = new PhpDumper($container);
        if (false === file_put_contents($containerPath, $dumper->dump(['class' => 'CompiledContainer']))) {
            throw new UnableToCacheContainerException($this, $container, $environment, $containerPath);
        }

        return $container;
    }

    /**
     * @inheritDoc
     */
    public function createContainer(EnvironmentInterface $environment)
    {
        $this->containerBuilder->set('app.environment', $environment);
        $loader = new YamlFileLoader($this->containerBuilder, new FileLocator($environment->getConfigDirectory()));
        $loader->load($environment->getContainerConfig());

        foreach ($environment->getExtensions() as $extension) {
            $extension->load([], $this->containerBuilder, $environment);
        }

        return $this->containerBuilder;
    }
}