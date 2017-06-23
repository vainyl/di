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

use Vainyl\Core\Application\EnvironmentInterface;

/**
 * Class ContainerFactoryCacheDecorator
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class ContainerFactoryCacheDecorator extends AbstractContainerFactoryDecorator
{
    /**
     * @inheritDoc
     */
    public function createContainer(EnvironmentInterface $environment)
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


        return parent::createContainer($environment);
    }
}