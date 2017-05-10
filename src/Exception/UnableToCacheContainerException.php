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

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Vainyl\Core\Application\EnvironmentInterface;
use Vainyl\Di\Factory\ContainerFactoryInterface;

/**
 * Class UnableToCacheContainerException
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class UnableToCacheContainerException extends AbstractContainerFactoryException
{
    private $container;

    private $environment;

    private $path;

    /**
     * UnableToCacheContainerException constructor.
     *
     * @param ContainerFactoryInterface $containerFactory
     * @param ContainerBuilder          $container
     * @param EnvironmentInterface      $environment
     * @param string                    $path
     */
    public function __construct(
        ContainerFactoryInterface $containerFactory,
        ContainerBuilder $container,
        EnvironmentInterface $environment,
        string $path
    ) {
        $this->container = $container;
        $this->environment = $environment;
        $this->path = $path;
        parent::__construct($containerFactory, sprintf('Unable to cache container %d', spl_object_hash($container)));
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_merge(
            [
                'container' => spl_object_hash($this->container),
                'environment' => $this->environment->toArray(),
                'path' => $this->path,
            ],
            parent::toArray()
        );
    }
}