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
 * Class ContainerFactoryEnvironmentDecorator
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class ContainerFactoryEnvironmentDecorator extends AbstractContainerFactoryDecorator
{
    /**
     * @inheritDoc
     */
    public function createContainer(EnvironmentInterface $environment)
    {
        $containerBuilder = parent::createContainer($environment);
        $containerBuilder->set('app.environment', $environment);

        return $containerBuilder;
    }
}