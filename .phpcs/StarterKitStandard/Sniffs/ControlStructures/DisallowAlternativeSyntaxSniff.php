<?php

namespace StarterKitStandard\Sniffs\ControlStructures;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Disallows alternative (colon) control-structure syntax.
 *
 * PHP only emits T_ENDIF/T_ENDFOREACH/T_ENDWHILE/T_ENDFOR/T_ENDSWITCH tokens when the
 * alternative `if (...) : ... endif;` syntax is used, so matching directly on those end
 * tokens is sufficient - no need to inspect scope openers/closers.
 */
final class DisallowAlternativeSyntaxSniff implements Sniff
{
    /**
     * @return array<int, int>
     */
    public function register()
    {
        return [
            T_ENDIF,
            T_ENDFOREACH,
            T_ENDWHILE,
            T_ENDFOR,
            T_ENDSWITCH,
        ];
    }

    /**
     * @param File $phpcsFile
     * @param int  $stackPtr
     *
     * @return void
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $keyword = $tokens[$stackPtr]['content'];

        $phpcsFile->addError(
            'Alternative control-structure syntax ("%s") is not allowed; use brace syntax instead.',
            $stackPtr,
            'Found',
            [$keyword]
        );
    }
}
