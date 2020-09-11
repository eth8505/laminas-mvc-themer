<?php

    namespace LaminasMvcThemer\Injector;

    use LaminasMvcThemer\Theme\ThemeInterface;

    /**
     * Abstract base class for theme data injectors
     */
    abstract class AbstractInjector {

        /**
         * @var ThemeInterface
         */
        protected $theme;

        /**
         * Constructor
         *
         * @param ThemeInterface $theme
         */
        public function __construct(ThemeInterface $theme) {
            $this->theme = $theme;
        }

    }
