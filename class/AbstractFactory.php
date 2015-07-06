<?php

  /**
   * AbstractFactory.php
   *
   * @author Robert Bost <bostrt at tux dot appstate dot edu>
   */

abstract class AbstractFactory
{
    public abstract function getDirectory();
    public abstract function throwIllegal($name);
    public abstract function throwNotFound($name);

    public function get($name=Null)
    {
        if(is_null($name)){
            $name = 'Null';
        }

        $class = $this->init($name);

        $instance = new $class();
        return $instance;
    }

    private function init($name)
    {
        $dir = $this->getDirectory();

        if(preg_match('/\W/', $name)) {
            $this->throwIllegal($name);
        }

        PHPWS_Core::initModClass('nomination', "{$dir}/{$name}.php");

        return $name;
    }
}
