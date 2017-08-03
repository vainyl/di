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

use Vainyl\Core\Exception\AbstractCoreException;
use Vainyl\Di\Factory\ContainerFactoryInterface;

/**
 * Class AbstractContainerFactoryException
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
abstract class AbstractContainerFactoryException extends AbstractCoreException implements
    ContainerFactoryExceptionInterface
{
    private $containerFactory;

    /**
     * AbstractContainerFactoryException constructor.
     *
     * @param ContainerFactoryInterface $containerFactory
     * @param string                    $message
     * @param int                       $code
     * @param \Exception|null           $previous
     */
    public function __construct(
        ContainerFactoryInterface $containerFactory,
        string $message,
        int $code = 500,
        \Exception $previous = null
    ) {
        $this->containerFactory = $containerFactory;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @inheritDoc
     */
    public function getContainerFactory(): ContainerFactoryInterface
    {
        return $this->containerFactory;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_merge(['container_factory' => $this->containerFactory->getId()], parent::toArray());
    }
}