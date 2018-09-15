<?php

namespace App\Helpers;

use Illuminate\View\Compilers\BladeCompiler;

class BladeParser extends BladeCompiler
{

    public function __construct()
    {

    }

    /**
     * Compile blade template with passing arguments.
     *
     * @param  [type] $value [description]
     * @param  array $args [description]
     * @return [type]        [description]
     */
    public function parse($value, array $args = array())
    {
        $generated = parent::compileString($value);

        ob_start() and extract($args, EXTR_SKIP);

        // We'll include the view contents for parsing within a catcher
        // so we can avoid any WSOD errors. If an exception occurs we
        // will throw it out to the exception handler.
        try {
            eval('?>' . $generated);
        }

            // If we caught an exception, we'll silently flush the output
            // buffer so that no partially rendered views get thrown out
            // to the client and confuse the user with junk.
        catch (\Exception $e) {
            ob_get_clean();
            throw $e;
        }

        $content = ob_get_clean();

        return $content;
    }

}
