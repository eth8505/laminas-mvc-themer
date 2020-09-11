<?php

    namespace LaminasMvcThemer\ViewHelper\Factory;

    use Interop\Container\ContainerInterface;
    use LaminasMvcThemer\ViewHelper\ThemeHelper;
    use Laminas\ServiceManager\Factory\FactoryInterface;

    class ThemeHelperFactory implements FactoryInterface {

        /**
         * @inheritdoc
         */
        public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
        {
            return new ThemeHelper($container->get('theme'));
        }

    }
