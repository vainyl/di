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

namespace Vainyl\Di;

use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface as SymfonyContainerInterface;

/**
 * Class SymfonyContainerAdapter
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class SymfonyContainerAdapter implements ContainerInterface
{
    private $container;

    /**
     * SymfonyContainerAdapter constructor.
     *
     * @param SymfonyContainerInterface $container
     */
    public function __construct(SymfonyContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @inheritDoc
     */
    public function get($id)
    {
        return $this->container->get($id);
    }

    /**
     * @inheritDoc
     */
    public function has($id)
    {
        return $this->container->has($id);
    }
}