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

use Vainyl\Core\AbstractIdentifiable;
use Vainyl\Core\Application\EnvironmentInterface;
use Vainyl\Di\Factory\ContainerFactoryInterface;

/**
 * Class AbstractContainerFactoryDecorator
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
abstract class AbstractContainerFactoryDecorator extends AbstractIdentifiable implements ContainerFactoryInterface
{
    private $containerFactory;

    /**
     * AbstractContainerFactoryDecorator constructor.
     *
     * @param ContainerFactoryInterface $containerFactory
     */
    public function __construct(ContainerFactoryInterface $containerFactory)
    {
        $this->containerFactory = $containerFactory;
    }

    /**
     * @inheritDoc
     */
    public function createContainer(EnvironmentInterface $environment)
    {
        return $this->containerFactory->createContainer($environment);
    }
}