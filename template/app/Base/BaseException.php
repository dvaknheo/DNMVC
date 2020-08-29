<?php declare(strict_types=1);
/**
 * DuckPhp
 * From this time, you never be alone~
 */

namespace LazyToChange\Base;

use DuckPhp\Core\ThrowOn;

class BaseException
{
    use ThrowOn;
    
    public function display($ex)
    {
        App::OnDefaultException($ex);
    }
}
