<?php 
 
 function obj_dump($var, $return_as_string = false, $full_trace = false) {

    if (function_exists('debug_backtrace')) {
      $Tmp1 = debug_backtrace();
    } else {
      $Tmp1 = array(
        'file' => 'UNKNOWN FILE',
        'line' => 'UNKNOWN LINE',
      );
    }
    $var_value = "";
    $output = "<FIELDSET STYLE=\"font:normal 12px helvetica,arial; margin:10px;\"><LEGEND STYLE=\"font:bold 14px helvetica,arial\">Dump - " . $Tmp1[0]['file'] . " : " . $Tmp1[0]['line'] . "</LEGEND><PRE>\n";
    if ($return_as_string) {
      $var_value .= "\nDump - " . $Tmp1[0]['file'] . " : " . $Tmp1[0]['line'] . "\n";
    }
    if ($full_trace) {
      if ($return_as_string) {
        $var_value .= "\n" . trace($Tmp1) . "\n";
      } else {
        $output .= "<LEGEND STYLE=\"font:bold 14px helvetica,arial\">" . trace($Tmp1) . "</LEGEND>";
      }
    }
    if (is_bool($var)) {
      $var_value .= '(bool) ' . ($var ? 'true' : 'false');
    } elseif (is_null($var)) {
      $var_value .= '(null)';
//    } elseif (is_array($var)) {
//      $var_value .= self::obj_dump($var, true);
    } else {
      $var_value .= htmlspecialchars(print_r($var, true));
    }
    $output .= $var_value . "</PRE></FIELDSET>\n\n";

    if ($return_as_string) {
      return $var_value;
    }
    echo $output;
  }

  /**
   * Returns a system backtrace result or a user defined backtrace as a string HTML-formatted
   * @param $tmp - array a user defined backtrace data (optional)
   * @return string - a debug backtrace string in HTML format
   */

  function trace($tmp = '') {
    if (!$tmp) {
      $tmp = debug_backtrace();
    }
    $trace_string = "Trace path:<br/>";
    for ($i = 1; $i < count($tmp); $i++) {
      $arr_error = $tmp[$i];
      $file = '`Can`t detect file`';
      if (isset($arr_error['file'])) {
        $file = $arr_error['file'];
      }
      $line = '`Can`t detect line`';
      if (isset($arr_error['line'])) {
        $line = $arr_error['line'];
      }
      $function = $arr_error['function'];
      $trace_string .= "<b>$file</b>, function <b>$function</b>, line <b>$line</b><br/>";
    }

    return $trace_string;
  }
