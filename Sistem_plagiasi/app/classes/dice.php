<?php

namespace App\classes;
use App\classes\Winnowing;

Class dice {

    private $nGramValue = 5;
    private $nWindowValue = 5;
    private $primeNumber = 2;
    private $round = 2;

    public function hasil(){
        return $this->nilai;
    }

    public function compare(string $comparatorText, string $sourceText)
    {
        $source = Winnowing::create($sourceText)->calculate($this->nGramValue, $this->primeNumber, $this->nWindowValue);
        $comparator = Winnowing::create($comparatorText)->calculate($this->nGramValue, $this->primeNumber, $this->nWindowValue);
        $coefficient = $this->diceCoeficient($source->getFingerprints(), $comparator->getFingerprints());
        return $this->hasil;
    }

    public function diceCoeficient(array $fingerprint1, array $fingerprint2)
    {
        $intersection = array_intersect($fingerprint1, $fingerprint2);// irisan 
        $unions = array_merge($fingerprint1, $fingerprint2);//gabungan/yg sama

        $intersectionCount = count($intersection);// finger sama
        $unionsCount = count($unions);// finger input (x) + finger banding (y) - finger sama

        $divisor = $unionsCount;//dice
        $coefficient = $divisor > 0 ? $intersectionCount*2 / $divisor : 0;//dice

        // $divisor = $unionsCount - $intersectionCount;
        // $coefficient = $divisor > 0 ? $intersectionCount / $divisor : 0;

        $this->hasil = round($coefficient *100,'2');

        return $this;
    }
}


?>