<?php

class Margerita extends Pizza implements PizzaInterface
{
    use PromocyjneTrait;

    protected $nazwa = 'margerita';
    public $skladniki = ['ser', 'kukurydza', 'czosnek', 'bazylia'];

    public function pobierzPrzepis() : string
    {
        return 'Przepis na Mergerite';
    }

    public function pobierzKlasePizzy() : Pizza
    {
        return $this;
    }
}

class Habanero extends Pizza implements PizzaInterface
{
    use PromocyjneTrait;

    protected $nazwa = 'habanero';
    public $skladniki = ['ser', 'szynka', 'papryka ostra', 'cebula'];

    public function pobierzPrzepis() : string
    {
        return 'Przepis na Habanero';
    }

    public function pobierzKlasePizzy() : Pizza
    {
        return $this;
    }
}

trait PromocyjneTrait
{
    public function dodajPromocje()
    {
        $promocja = new Promocja;
        $promocja->pizza = $this->nazwa;
        $pomocja->pomocja = 0.8;
        $promocja->save();
    }

    public function usunPromocje()
    {
        Promocja::where('pizza', $this->nazwa)->delete();
    }
}

class Promocja
{
    public $pizza;
    public $pomocja;
}

abstract class Pizza
{
    /** @var string $nazwa */
    protected $nazwa;

    /** @var array $skladniki */
    protected $skladniki;

    public function wyswietlListeSkladnikow()
    {
        return $this->skladniki;
    }
}


interface PizzaInterface
{
    public function pobierzPrzepis() : string;
    // public function pobierzKwote() : int float string array ;

    public function pobierzKlasePizzy() : Pizza;
}

$margerita = new Margerita;
$test = $margerita->pobierzKlasePizzy();

$habanero = new Habanero;
$t = $habanero->pobierzKlasePizzy();
var_dump($t);
die();