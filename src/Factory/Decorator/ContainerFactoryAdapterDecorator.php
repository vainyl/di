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
use Vainyl\Di\SymfonyContainerAdapter;

/**
 * Class ContainerFactoryAdapterDecorator
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class ContainerFactoryAdapterDecorator extends AbstractContainerFactoryDecorator
{
    /**
     * @inheritDoc
     */
    public function createContainer(EnvironmentInterface $environment)
    {
        $adapter = new SymfonyContainerAdapter(parent::createContainer($environment));
        $adapter->set('app.di', $adapter);

        return $adapter;
    }
}