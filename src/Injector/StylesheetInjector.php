<?php

    namespace LaminasMvcThemer\Injector;

    use Laminas\Mvc\MvcEvent;
    use Laminas\View\Helper\BasePath;
    use Laminas\View\Helper\HeadLink;

    /**
     * Injector to inject stylesheet files from the theme
     */
    class StylesheetInjector extends AbstractInjector {

        /**
         * @inheritdoc
         */
        public function __invoke(MvcEvent $e)
        {

            if (empty($stylesheets = $this->theme->getStylesheets())) {
                return;
            }

            $helperManager = $e->getApplication()
                ->getServiceManager()
                ->get('ViewHelperManager');

            /** @var HeadLink $headLink */
            $headLink = $helperManager->get(HeadLink::class);
            /** @var BasePath $basePath */
            $basePath = $helperManager->get(BasePath::class);

            foreach ($stylesheets AS $stylesheet) {
                $headLink->appendStylesheet($basePath($stylesheet));
            }

        }

    }
