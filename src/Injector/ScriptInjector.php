<?php

    namespace LaminasMvcThemer\Injector;

    use Laminas\Mvc\MvcEvent;
    use Laminas\View\Helper\BasePath;
    use Laminas\View\Helper\HeadScript;

    /**
     * Injector to inject script files from the theme
     */
    class ScriptInjector extends AbstractInjector {

        /**
         * @inheritdoc
         */
        public function __invoke(MvcEvent $e)
        {

            if (empty($scripts = $this->theme->getScripts())) {
                return;
            }

            $helperManager = $e->getApplication()
                ->getServiceManager()
                ->get('ViewHelperManager');

            /** @var HeadScript $headScript */
            $headScript = $helperManager->get(HeadScript::class);
            /** @var BasePath $basePath */
            $basePath = $helperManager->get(BasePath::class);

            foreach ($scripts AS $script) {
                $headScript->appendFile($basePath($script));
            }

        }

    }
