<?php

    namespace LaminasMvcThemer\Theme\Factory;

    use LaminasMvcThemer\Theme\ThemePluginManager;
    use Laminas\Mvc\Service\AbstractPluginManagerFactory;

    class ThemePluginManagerFactory extends AbstractPluginManagerFactory {

        const PLUGIN_MANAGER_CLASS = ThemePluginManager::class;

    }
