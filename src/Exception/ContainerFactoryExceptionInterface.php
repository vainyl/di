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

namespace Vainyl\Di\Exception;

use Vainyl\Core\ArrayInterface;
use Vainyl\Di\Factory\ContainerFactoryInterface;

/**
 * Interface ContainerFactoryExceptionInterface
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
interface ContainerFactoryExceptionInterface extends ArrayInterface, \Throwable
{
    /**
     * @return ContainerFactoryInterface
     */
    public function getContainerFactory() : ContainerFactoryInterface;
}