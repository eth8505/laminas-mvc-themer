<?php

    namespace LaminasMvcThemer\ViewHelper;

    use LaminasMvcThemer\Theme\ThemeInterface;
    use Laminas\View\Helper\AbstractHelper;

    class ThemeHelper extends AbstractHelper {

        /**
         * @var ThemeInterface
         */
        private $theme;

        public function __construct(ThemeInterface $theme)
        {
            $this->theme = $theme;
        }


        public function __invoke()
        {
            return $this;
        }

        public function var(string $key) {

            $parts = explode('/', $key);
            $current = $this->theme->getVariables();

            do {

                $next_key = array_shift($parts);

                if (isset($current[$next_key ])) {
                    $current = &$current[$next_key ];
                } else {
                    return NULL;
                }

            } while (count($parts) > 0);

            return $current;

        }

        public function name() : string {
            return $this->theme->getName();
        }

    }
