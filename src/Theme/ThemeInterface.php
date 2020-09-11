<?php

    namespace LaminasMvcThemer\Theme;

    /**
     * Interface for themes
     */
    interface ThemeInterface {

        /**
         * @return array
         */
        public function getVariables() : array;

        /**
         * @return array
         */
        public function getStylesheets() : array;

        /**
         * @return array
         */
        public function getMetaTags() : array;

        /**
         * @return array
         */
        public function getScripts() : array;

        /**
         * @return string
         */
        public function getName() : string;

    }
