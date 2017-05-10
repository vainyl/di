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
use Vainyl\Core\Application\EnvironmentInterface;
use Vainyl\Core\IdentifiableInterface;

/**
 * Interface ContainerFactoryInterface
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
interface ContainerFactoryInterface extends IdentifiableInterface
{
    /**
     * @param EnvironmentInterface $environment
     *
     * @return ContainerInterface
     */
    public function createContainer(EnvironmentInterface $environment): ContainerInterface;
}