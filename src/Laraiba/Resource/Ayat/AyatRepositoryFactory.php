<?php

namespace Laraiba\Resource\Ayat;

class AyatRepositoryFactory
{
    public function createAyatRepository()
    {
        $data = include __DIR__ . '/../../../../data/quran-uthmani.php';
        $ayatData = array();

        foreach ($data as $suratNumber => $ayatList) {
            foreach ($ayatList as $ayatNumber => $ayatText) {
                $ayat = new Ayat(new AyatId($suratNumber . ':' . $ayatNumber));
                $ayat->setText($ayatText);

                $ayatData[$suratNumber][$ayatNumber] = $ayat;
            }
        }

        return new ArrayAyatRepository($ayatData);
    }
}
