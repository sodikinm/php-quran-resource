<?php

namespace Laraiba\Resource\Setup;

use Pimple\ServiceProviderInterface;
use Pimple\Container;

class DefaultServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['laraiba.ayat_repository_factory'] = function () {
            return new \Laraiba\Resource\Ayat\Repository\AyatRepositoryFactory();
        };

        $pimple['laraiba.ayat_repository'] = function ($c) {
            return $c['laraiba.ayat_repository_factory']->createAyatRepository();
        };

        $pimple['laraiba.surat_repository_factory'] = function () {
            return new \Laraiba\Resource\Surat\Repository\SuratRepositoryFactory();
        };

        $pimple->extend('laraiba.surat_repository_factory', function ($suratRepositoryFactory, $c) {
            $ayatRepository = $c['laraiba.ayat_repository'];

            $ayatListInitializer = new \Laraiba\Resource\Surat\Initializer\AyatListInitializer($ayatRepository);
            $suratRepositoryFactory->addInitializer($ayatListInitializer);

            return $suratRepositoryFactory;
        });

        $pimple['laraiba.surat_repository'] = function ($c) {
            return $c['laraiba.surat_repository_factory']->createSuratRepository();
        };

        $pimple['laraiba.translation_manager'] = function () {
            return new \Laraiba\Resource\Translation\TranslationManager();
        };

    }
}
