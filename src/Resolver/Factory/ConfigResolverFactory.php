<?php

    namespace LaminasMvcThemer\Resolver\Factory;

    use Interop\Container\ContainerInterface;
    use LaminasMvcThemer\Resolver\ConfigResolver;
    use LaminasMvcThemer\Theme\ThemePluginManager;
    use Laminas\ServiceManager\Factory\FactoryInterface;

    class ConfigResolverFactory implements FactoryInterface {

        /**
         * @inheritdoc
         */
        public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
        {

            $theme = $container->get('config')['laminas-mvc-themer']['theme'] ?? NULL;

            if (empty($theme)) {
                throw new \UnexpectedValueException('No theme configured in laminas-mvc-themer/theme');
            }

            return new ConfigResolver(
                $theme,
                $container->get(ThemePluginManager::class)
            );

        }

    }
