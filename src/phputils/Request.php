<?php

class Request
{

    static $detectors = array(
        'get'     => array('env' => 'REQUEST_METHOD', 'value' => 'GET'),
        'post'    => array('env' => 'REQUEST_METHOD', 'value' => 'POST'),
        'put'     => array('env' => 'REQUEST_METHOD', 'value' => 'PUT'),
        'delete'  => array('env' => 'REQUEST_METHOD', 'value' => 'DELETE'),
        'head'    => array('env' => 'REQUEST_METHOD', 'value' => 'HEAD'),
        'options' => array('env' => 'REQUEST_METHOD', 'value' => 'OPTIONS'),
        'ssl'     => array('env' => 'HTTPS', 'value' => 1),
        'ajax'    => array('env' => 'HTTP_X_REQUESTED_WITH', 'value' => 'XMLHttpRequest'),
        'flash'   => array('env' => 'HTTP_USER_AGENT', 'pattern' => '/^(Shockwave|Adobe) Flash/'),
        'mobile'  => array('env' => 'HTTP_USER_AGENT', 'options' => array(
            'Android', 'AvantGo', 'BlackBerry', 'DoCoMo', 'Fennec', 'iPod', 'iPhone', 'iPad',
            'J2ME', 'MIDP', 'NetFront', 'Nokia', 'Opera Mini', 'Opera Mobi', 'PalmOS', 'PalmSource',
            'portalmmm', 'Plucker', 'ReqwirelessWeb', 'SonyEricsson', 'Symbian', 'UP\\.Browser',
            'webOS', 'Windows CE', 'Windows Phone OS', 'Xiino'
        )),
        'requested' => array('param' => 'requested', 'value' => 1)
    );


    public static function get($var = null)
    {
        $data = stripslashes_deep($_GET);

        if (!empty($var))
        {
            return DotSet::get($data, $var);
        }

        return $data;
    }

    public static function post($var = null)
    {
        $data = stripslashes_deep($_POST);

        if (!empty($var))
        {
            return DotSet::get($data, $var);
        }

        return $data;
    }

    static public function ip($safe = true)
    {
        if (!$safe && env('HTTP_X_FORWARDED_FOR') != null)
        {
            $ipaddr = preg_replace('/(?:,.*)/', '', env('HTTP_X_FORWARDED_FOR'));
        }
        else
        {
            if (env('HTTP_CLIENT_IP') != null)
            {
                $ipaddr = env('HTTP_CLIENT_IP');
            }
            else
            {
                $ipaddr = env('REMOTE_ADDR');
            }
        }

        if (env('HTTP_CLIENTADDRESS') != null)
        {
            $tmpipaddr = env('HTTP_CLIENTADDRESS');

            if (!empty($tmpipaddr))
            {
                $ipaddr = preg_replace('/(?:,.*)/', '', $tmpipaddr);
            }
        }

        return trim($ipaddr);
    }


    public static function is($type) {
        $type = strtolower($type);
        if (!isset(self::$detectors[$type])) {
            return false;
        }
        $detect = self::$detectors[$type];
        if (isset($detect['env'])) {
            if (isset($detect['value'])) {
                return env($detect['env']) == $detect['value'];
            }
            if (isset($detect['pattern'])) {
                return (bool)preg_match($detect['pattern'], env($detect['env']));
            }
            if (isset($detect['options'])) {
                $pattern = '/' . implode('|', $detect['options']) . '/i';
                return (bool)preg_match($pattern, env($detect['env']));
            }
        }
        if (isset($detect['param'])) {
            $key = $detect['param'];
            $value = $detect['value'];
            return isset($this->params[$key]) ? $this->params[$key] == $value : false;
        }
        if (isset($detect['callback']) && is_callable($detect['callback'])) {
            return call_user_func($detect['callback'], $this);
        }
        return false;
    }

    public static function current()
    {
        return 'http' . (env('HTTPS')?'s':'') . '://' . env('HTTP_HOST') . $_SERVER['REQUEST_URI'];
    }
    // /* ==================================================
    //  ACTIONS
    //    ================================================== */

    public static function redirect($url, $code = 302)
    {
        Response::code($code);
        self::location($url);
    }

    public static function refresh()
    {
        self::location(self::current());
    }

    public static function location($url)
    {
        header('Location: ' . $url);
        die;
    }
}
