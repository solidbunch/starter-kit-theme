<?php

namespace StarterKit\Handlers\Errors;

defined('ABSPATH') || exit;

use Whoops\Exception\Formatter;
use Whoops\Handler\Handler;
use Whoops\Handler\JsonResponseHandler;
use Whoops\Util\Misc;

/**
 * WordPress-specific version of Json handler.
 */
class AjaxHandler extends JsonResponseHandler
{

    private function isAjaxRequest(): bool
    {
        return defined('DOING_AJAX') && DOING_AJAX;
    }


    public function handle(): int
    {
        if ( ! $this->isAjaxRequest()) {
            return Handler::DONE;
        }

        $response = [
            'success' => false,
            'data'    => Formatter::formatExceptionAsDataArray($this->getInspector(), $this->addTraceToOutput()),
        ];

        if (Misc::canSendHeaders()) {
            header('Content-Type: application/json; charset=' . get_option('blog_charset'));
        }

        echo wp_json_encode($response, JSON_PRETTY_PRINT);

        return Handler::QUIT;
    }
}
