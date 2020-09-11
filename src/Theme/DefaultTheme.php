<?php

    namespace LaminasMvcThemer\Theme;

    /**
     * Default theme
     */
    class DefaultTheme implements ThemeInterface {

        /**
         * @inheritdoc
         */
        public function getVariables() : array {
            return [];
        }

        /**
         * @inheritdoc
         */
        public function getStylesheets() : array {
            return [];
        }

        /**
         * @inheritdoc
         */
        public function getMetaTags() : array {
            return [];
        }

        /**
         * @inheritdoc
         */
        public function getScripts() : array {
            return [];
        }

        /**
         * @inheritdoc
         */
        public function getName() : string {
            return 'default';
        }

    }
