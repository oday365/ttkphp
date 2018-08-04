<?php
namespace TTkPHP;
class TTkPHP {
	static public function boot() {
        register_shutdown_function('TTkPHP\TTkPHP::fatalError');
        set_error_handler('TTkPHP\TTkPHP::appError');
        set_exception_handler('TTkPHP\TTkPHP::appException');
	}

    // �������󲶻�
    static public function fatalError() {
        if ($e = error_get_last()) {
            switch($e['type']){
                case E_ERROR:
                case E_PARSE:
                case E_CORE_ERROR:
                case E_COMPILE_ERROR:
                case E_USER_ERROR:
                    Log::write('FATAL ERROR');
                    ob_end_clean();
                    self::halt($e);
                    break;
            }
        }
    }

    /**
     * �������
     * @param mixed $error ����
     * @return void
     */
    static public function halt($error) {
        $e = array();
        if (APP_DEBUG) {
            //����ģʽ�����������Ϣ
            if (!is_array($error)) {
                $trace          = debug_backtrace();
                $e['message']   = $error;
                $e['file']      = $trace[0]['file'];
                $e['line']      = $trace[0]['line'];
                ob_start();
                debug_print_backtrace();
                $e['trace']     = ob_get_clean();
            } else {
                $e              = $error;
            }
            exit($e['message'].PHP_EOL.'FILE: '.$e['file'].'('.$e['line'].')'.PHP_EOL.$e['trace']);
        }
	}

    /**
     * �Զ��������
     * @access public
     * @param int $errno ��������
     * @param string $errstr ������Ϣ
     * @param string $errfile �����ļ�
     * @param int $errline ��������
     * @return void
     */
    static public function appError($errno, $errstr, $errfile, $errline) {
      switch ($errno) {
          case E_ERROR:
          case E_PARSE:
          case E_CORE_ERROR:
          case E_COMPILE_ERROR:
          case E_USER_ERROR:
            ob_end_clean();
            $errorStr = "$errstr ".$errfile." �� $errline ��.";
            Log::write("[$errno] ".$errorStr);
            self::halt($errorStr);
            break;
          default:
            break;
      }
    }

    /**
     * �Զ����쳣����
     * @access public
     * @param mixed $e �쳣����
     */
    static public function appException($e) {
        $error = array();
        $error['message']   =   $e->getMessage();
        $trace              =   $e->getTrace();
        if('E'==$trace[0]['function']) {
            $error['file']  =   $trace[0]['file'];
            $error['line']  =   $trace[0]['line'];
        }else{
            $error['file']  =   $e->getFile();
            $error['line']  =   $e->getLine();
        }
        $error['trace']     =   $e->getTraceAsString();
        // ����404��Ϣ
        //header('HTTP/1.1 404 Not Found');
        //header('Status:404 Not Found');
        self::halt($error);
    }

}