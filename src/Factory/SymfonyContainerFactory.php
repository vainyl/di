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

use Psr\Container\ContainerInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface as SymfonyContainerInterface;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Vainyl\Core\AbstractIdentifiable;
use Vainyl\Core\Application\EnvironmentInterface;
use Vainyl\Di\Exception\UnableToCacheContainerException;
use Vainyl\Di\SymfonyContainerAdapter;

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
        foreach ($environment->toArray() as $parameter => $value) {
            $this->containerBuilder->setParameter($parameter, $value);
        }

        $loader = new YamlFileLoader($this->containerBuilder, new FileLocator($environment->getApplicationDirectory()));
        $loader->load(sprintf('%s/di.yml', $environment->__toString()));

        /**
         * @var Extension[] $extensions
         * @var CompilerPassInterface[] $compilerPasses
         */
        $diExtensions = require sprintf('%s/di.php', $environment->__toString());
        $extensions = $diExtensions['extensions'];
        foreach ($extensions as $extension) {
            $extension->load([], $this->containerBuilder, $environment);
        }
        $compilerPasses = $diExtensions['compiler_passes'];
        foreach ($compilerPasses as $compilerPass) {
            $this->containerBuilder->addCompilerPass($compilerPass);
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

            return new \CachedSymfonyContainer();
        }

        $container = $this->initContainer($environment);
        if (false === file_exists(dirname($containerPath))) {
            mkdir(dirname($containerPath), 0755, true);
        }
        $dumper = new PhpDumper($container);
        if (false === file_put_contents($containerPath, $dumper->dump(['class' => 'CachedSymfonyContainer']))) {
            throw new UnableToCacheContainerException($this, $container, $environment, $containerPath);
        }

        return $container;
    }

    /**
     * @inheritDoc
     */
    public function createContainer(EnvironmentInterface $environment): ContainerInterface
    {
        if ($environment->isCachingEnabled()) {
            $container = $this->getCachedContainer($environment);
        } else {
            $container = $this->initContainer($environment);
        }

        return new SymfonyContainerAdapter($container);
    }
}