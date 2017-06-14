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

namespace Vainyl\Di\Extension;

use Vainyl\Core\Extension\AbstractExtension;

/**
 * Class DiExtension
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class DiExtension extends AbstractExtension
{
    /**
     * @inheritDoc
     */
    public function getCompilerPasses(): array
    {
        return [];
    }
}