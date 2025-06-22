<?php

namespace StarterKit\Handlers\Mail;

use PHPMailer\PHPMailer\PHPMailer;
use StarterKit\Error\ErrorHandler;

defined('ABSPATH') || exit;

/**
 * Mail SMTP handler
 *
 * @package    Starter Kit
 */
class SMTP
{
    /**
     * Initialize SMTP settings if they are set in the environment
     * if not set, the default mail settings will be used
     *
     * @param PHPMailer $phpmailer
     *
     * @return void
     */
    public static function phpmailerSmtpInit(PHPMailer $phpmailer): void
    {
        if (empty(SMTP_HOST) || empty(SMTP_PORT)) {
            return;
        }

        $phpmailer->isSMTP();
        $phpmailer->Host = SMTP_HOST;
        $phpmailer->Port = SMTP_PORT;

        if (!empty(SMTP_USER) && !empty(SMTP_PASS)) {
            $phpmailer->SMTPAuth = true;
            $phpmailer->Username = SMTP_USER;
            $phpmailer->Password = SMTP_PASS;
        } else {
            $phpmailer->SMTPAuth = false;
        }

        //$phpmailer->From       = SMTP_FROM;
        //$phpmailer->FromName   = SMTP_NAME;

        $phpmailer->SMTPSecure = SMTP_SECURE ?? '';

        // 0 No debug output, default
        // 1 Client commands
        // 2 Client commands and server responses
        // 3 As 2 plus connection status
        // 4 Low-level data output, all messages.
        $phpmailer->SMTPDebug = SMTP_DEBUG;

        $phpmailer->Debugoutput = function ($str, $level) {
            error_log("debug level $level; message: $str");
        };
    }

    public static function mailFailedHandler($WPError): void
    {
        ErrorHandler::handleWPError($WPError);
    }
}
