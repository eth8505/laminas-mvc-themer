<?php

    namespace LaminasMvcThemer\Factory;

    use Interop\Container\ContainerInterface;
    use LaminasMvcThemer\ThemeSelector;
    use Laminas\ServiceManager\Factory\FactoryInterface;

    class ThemeSelectorFactory implements FactoryInterface {

        /**
         * @inheritdoc
         */
        public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
        {

            $resolverService = $container->get('config')['laminas-mvc-themer']['resolver'] ?? NULL;

            if (empty($resolverService)) {
                throw new \UnexpectedValueException('No resolver configured in laminas-mvc-themer/resolver');
            }

            return new ThemeSelector(
                $container->get($resolverService)
            );
        }

    }
