<?php

class ClassLoader
{
    public function load($class_name)
    {
        // 既にクラスが存在する場合はfalseを返す
        $r = version_compare(phpversion(), "5.0.0", ">=")
            ? class_exists($class_name, $autoload = false)
            : class_exists($class_name);
        if ($r == true) {
            return false;
        }

        $prefix = '';
        $path = sprintf('%s/%s.php', PATH_CLASS_ROOT, str_replace('_', '/', $class_name));
        if (file_exists($path) === false) {
            return false;
        }

        include $path;

        $r = version_compare(phpversion(), "5.0.0", ">=")
            ? class_exists($class_name, $autoload = false)
            : class_exists($class_name);
        if ($r == true) {
            return true;
        } else {
            return false;
        }
    }
}

