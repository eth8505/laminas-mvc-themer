<?php

    namespace LaminasMvcThemer;

    use LaminasMvcThemer\Theme\DefaultTheme;
    use Psr\Container\ContainerInterface;
    use LaminasMvcThemer\Factory\InjectorFactory;
    use LaminasMvcThemer\Factory\ThemeSelectorFactory;
    use LaminasMvcThemer\Injector\MetaTagInjector;
    use LaminasMvcThemer\Injector\ScriptInjector;
    use LaminasMvcThemer\Injector\StylesheetInjector;
    use LaminasMvcThemer\Resolver\ConfigResolver;
    use LaminasMvcThemer\Resolver\Factory\ConfigResolverFactory;
    use LaminasMvcThemer\Theme\Factory\ThemePluginManagerFactory;
    use LaminasMvcThemer\Theme\ThemePluginManager;
    use LaminasMvcThemer\Theme\ThemeProviderInterface;
    use LaminasMvcThemer\ViewHelper\Factory\ThemeHelperFactory;
    use LaminasMvcThemer\ViewHelper\ThemeHelper;
    use Laminas\EventManager\EventInterface;
    use Laminas\ModuleManager\Feature\BootstrapListenerInterface;
    use Laminas\ModuleManager\Feature\ConfigProviderInterface;
    use Laminas\ModuleManager\Feature\InitProviderInterface;
    use Laminas\ModuleManager\Feature\ServiceProviderInterface;
    use Laminas\ModuleManager\Feature\ViewHelperProviderInterface;
    use Laminas\ModuleManager\Listener\ServiceListener;
    use Laminas\ModuleManager\ModuleManager;
    use Laminas\ModuleManager\ModuleManagerInterface;
    use Laminas\Mvc\MvcEvent;
    use Laminas\ServiceManager\Proxy\LazyServiceFactory;

    class Module implements ConfigProviderInterface, BootstrapListenerInterface, ServiceProviderInterface, ViewHelperProviderInterface, InitProviderInterface, ThemeProviderInterface {

        /**
         * @inheritdoc
         */
        public function getConfig()
        {
            return include __DIR__ . '/../config/module.config.php';
        }

        /**
         * @inheritdoc
         */
        public function init(ModuleManagerInterface $manager)
        {

            /** @var ModuleManager $manager */
            /** @var ContainerInterface $serviceManager */
            $serviceManager = $manager->getEvent()->getParam('ServiceManager');
            /** @var ServiceListener $serviceListener */
            $serviceListener = $serviceManager->get('ServiceListener');

            $serviceListener->addServiceManager(
                ThemePluginManager::class,
                'laminas-mvc-themes',
                ThemeProviderInterface::class,
                'getThemeConfig'
            );

        }

        /**
         * @inheritdoc
         */
        public function onBootstrap(EventInterface $e)
        {

            /** @var MvcEvent $e */

            $app = $e->getApplication();
            $serviceManager = $app->getServiceManager();
            $eventManager = $app->getEventManager();

            $serviceManager->get(ThemeSelector::class)
                ->attach($eventManager);

            $eventManager
                ->attach(
                    MvcEvent::EVENT_RENDER,
                    $serviceManager->get(StylesheetInjector::class)
                );

            $eventManager
                ->attach(
                    MvcEvent::EVENT_RENDER,
                    $serviceManager->get(ScriptInjector::class)
                );

            $eventManager
                ->attach(
                    MvcEvent::EVENT_RENDER,
                    $serviceManager->get(MetaTagInjector::class)
                );

        }

        /**
         * @inheritdoc
         */
        public function getServiceConfig()
        {

            return [
                'factories' => [
                    ThemeSelector::class => ThemeSelectorFactory::class,
                    ConfigResolver::class => ConfigResolverFactory::class,
                    ThemePluginManager::class => ThemePluginManagerFactory::class,
                    StylesheetInjector::class => InjectorFactory::class,
                    ScriptInjector::class => InjectorFactory::class,
                    MetaTagInjector::class => InjectorFactory::class
                ],
                'lazy_services' => [
                    'class_map' => [
                        StylesheetInjector::class => StylesheetInjector::class,
                        ScriptInjector::class => ScriptInjector::class,
                        MetaTagInjector::class => MetaTagInjector::class
                    ]
                ],
                'delegators' => [
                    StylesheetInjector::class => [
                        LazyServiceFactory::class
                    ],
                    ScriptInjector::class => [
                        LazyServiceFactory::class
                    ],
                    MetaTagInjector::class => [
                        LazyServiceFactory::class
                    ]
                ]
            ];

        }

        /**
         * @inheritdoc
         */
        public function getViewHelperConfig()
        {

            return [
                'aliases' => [
                    'theme' => ThemeHelper::class
                ],
                'factories' => [
                    ThemeHelper::class => ThemeHelperFactory::class
                ]
            ];

        }

        /**
         * @inheritdoc
         */
        public function getThemeConfig()
        {
            return [
                'invokables' => [
                    DefaultTheme::class
                ]
            ];
        }

    }
