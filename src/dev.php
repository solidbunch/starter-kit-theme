<?php

if (!function_exists('wlog')) {
    /**
     * Nice logging function
     *
     * @param  mixed   $var
     * @param  string  $desc
     * @param  string  $logFileDestination
     *
     * @return void
     */
    function wlog(mixed $var, string $desc = ' >> ', string $logFileDestination = ''): void
    {
        $messageType = 0;
        $lineEnd = '';
        if (!empty($logFileDestination)) {
            $messageType = 3;
            $lineEnd     = PHP_EOL;
        }
        error_log('[' . date('H:i:s') . ']' . '-------------------------' . $lineEnd, $messageType, $logFileDestination);
        error_log('[' . date('H:i:s') . '] ' . $desc . ' : ' . print_r($var, true) . $lineEnd, $messageType, $logFileDestination);
    }
}

if (!function_exists('ilog')) {
    /**
     * Write to info log
     * Wrapper for wlog() function with info log destination
     *
     * @param  mixed   $var
     * @param  string  $desc
     *
     * @return void
     */
    function ilog(mixed $var, string $desc = ' >> '): void
    {
        $logFileDestination = '';
        if (defined('APP_INFO_LOG') and !empty(APP_INFO_LOG)) {
            $logFileDestination = APP_INFO_LOG;
        }
        wlog($var, $desc, $logFileDestination);
    }
}

if (!function_exists('_var_dump')) {
    /**
     * Nice dump function
     *
     * @param  bool  $detailed
     * @param        ...$params
     *
     * @return void
     */
    function _var_dump(bool $detailed = false, ...$params): void
    {
        $func = $detailed ? 'var_dump' : 'var_export';

        foreach ($params as $param) {
            ob_start();
            $func($param);
            $data = ob_get_clean();

            echo '<pre class="_var_dump" style="text-align: left; font-family: \'Courier New\'; font-size: 12px;line-height: 20px;background: #efefef;border: 1px solid #777;border-radius: 5px;color: #333;padding: 10px;margin:0;overflow: auto;">';
            highlight_string("<?php" . $data . "?>");
            echo '</pre>';
        }
        echo '<script>
			;(function() {
				var var_dumps = document.querySelectorAll("._var_dump");
				for (var i = 0; i < var_dumps.length; i++) {
					var spans = var_dumps[i].querySelectorAll("code span span");
					spans[0].innerHTML = spans[0].innerHTML.replace("&lt;?php", "");
					spans[spans.length-1].innerHTML = spans[spans.length-1].innerHTML.replace("?&gt;", "");
				}
			})();
		</script>';
    }
}

if (!function_exists('wp_dump')) {
    function wp_dump(...$params): void
    {
        _var_dump(false, ...$params);
    }
}

if (!function_exists('wp_dump_ext')) {
    function wp_dump_ext(...$params): void
    {
        _var_dump(true, ...$params);
    }
}

if (!function_exists('wp_dd')) {
    function wp_dd(...$params): void
    {
        wp_dump(...$params);
        die();
    }
}

if (!function_exists('wp_dd_ext')) {
    function wp_dd_ext(...$params): void
    {
        wp_dump_ext(...$params);
        die();
    }
}

if (!function_exists('debug_backtrace_string')) {
    /**
     * Backtrace function
     * usage: wlog( debug_backtrace_string(), 'debug_backtrace >>' );
     *
     * @return string
     */
    function debug_backtrace_string(): string
    {
        $stack = '';
        $i     = 1;
        $trace = debug_backtrace();
        unset($trace[0]); //Remove call to this function from stack trace
        foreach ($trace as $node) {
            $file     = $node['file'] ?? '';
            $line     = $node['line'] ?? '';
            $class    = $node['class'] ?? '';
            $function = $node['function'] ?? '';

            if ($file) {
                $stack .= "#$i " . $file . "(" . $line . "): ";
            }
            if ($class) {
                $stack .= $class . "->";
            }
            if ($function) {
                $stack .= $function . "()" . PHP_EOL;
            }
            $i++;
        }

        return $stack;
    }
}

/**
 * Functions for collecting code execution statistic
 *
 * Usage:
 *
 * $begin_memory = stGetMemory();
 * $begin_time   = stGetTime();
 * some_func_to_test();
 *
 * $time_diff   = stTimeFormatted( stGetTime( $begin_time ) );
 * $memory_diff = stMemoryFormatted( stGetMemory( $begin_memory ) );
 */
if (!function_exists('stGetTime')) {
    /**
     * @param  bool  $time
     *
     * @return float
     */
    function stGetTime(bool $time = false): float
    {
        $timeResult = ($time === false) ? microtime(true) : (microtime(true) - $time);

        return $timeResult;
    }
}

if (!function_exists('stGetMemory')) {
    /**
     * @param  bool  $memory
     *
     * @return float
     */
    function stGetMemory(bool $memory = false): float
    {
        $memoryResult = ($memory === false) ? memory_get_usage() : (memory_get_usage() - $memory);

        return $memoryResult;
    }
}

if (!function_exists('stMemoryFormatted')) {
    /**
     * @param  float  $size
     *
     * @return string
     */
    function stMemoryFormatted(float $size): string
    {
        $unit = array('b', 'kb', 'mb', 'gb', 'tb', 'pb');

        return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
    }
}

if (!function_exists('stTimeFormatted')) {
    /**
     * @param  float  $size
     *
     * @return string
     */
    function stTimeFormatted(float $size): string
    {
        return 'Duration: ' . number_format($size, 3, '.', ' ') . ' sec';
    }
}
