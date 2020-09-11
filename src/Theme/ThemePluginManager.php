<?php

    namespace LaminasMvcThemer\Theme;

    use Laminas\ServiceManager\AbstractPluginManager;

    class ThemePluginManager extends AbstractPluginManager {

        /**
         * @var string
         */
        protected $instanceOf = ThemeInterface::class;

    }
