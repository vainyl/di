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
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Vainyl\Core\Application\EnvironmentInterface;
use Vainyl\Di\Exception\UnableToCacheContainerException;

/**
 * Class ContainerFactoryDumperDecorator
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class ContainerFactoryDumperDecorator extends AbstractContainerFactoryDecorator
{
    /**
     * @inheritDoc
     */
    public function createContainer(EnvironmentInterface $environment)
    {
        /**
         * @var ContainerBuilder $container
         */
        $container = parent::createContainer($environment);

        $containerPath = sprintf(
            '%s/container/%s.php',
            $environment->getCacheDirectory(),
            sha1($environment->__toString())
        );

        if (false === file_exists(dirname($containerPath))) {
            mkdir(dirname($containerPath), 0755, true);
        }
        $dumper = new PhpDumper($container);
        if (false === file_put_contents($containerPath, $dumper->dump(['class' => 'CompiledContainer']))) {
            throw new UnableToCacheContainerException($this, $container, $environment, $containerPath);
        }

        return $container;
    }
}