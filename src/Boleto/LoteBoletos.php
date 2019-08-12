<?php

namespace PJBank\Boleto;



/**
 * Boleto Registrado
 * @author Matheus Fidelis
 * @email matheus.fidelis@superlogica.com
 */
class LoteBoletos implements \Iterator, \Countable
{
    /**
     * Credencial da conta de boleto
     * @var string
     */
    private $credencial;

    /**
     * Chave da conta de boleto
     * @var string
     */
    private $chave;

    /**
     * Array de Boleto
     * @var array
     */
    private $boletos;

    public function __construct(string $credencial, string $chave)
    {
        $this->credencialBoleto = $credencial;
        $this->chave = $chave;
    }

    function rewind()
    {
        return reset($this->boletos);
    }

    function current()
    {
        return current($this->boletos);
    }

    function key()
    {
        return key($this->boletos);
    }

    function next()
    {
        return next($this->boletos);
    }

    function valid()
    {
        return key($this->boletos) !== null;
    }

    public function count() {
        return count($this->boletos);
    }

    public function addBoleto(Boleto $boleto)
    {
        $this->boletos[] = $boleto;
        return $this;
    }

    public function getCredencial(): string
    {
        return $this->credencial;
    }

    public function getChave(): string
    {
        return $this->chave;
    }

    public function gerar()
    {
        $emissor = new Emissor($this);
        $boletoGerado = $emissor->emitir();

        $this->nosso_numero = $boletoGerado->nossonumero;
        $this->id_unico = $boletoGerado->id_unico;
        $this->linha_digitavel = $boletoGerado->linhaDigitavel;
        $this->link = $boletoGerado->linkBoleto;
    }


}
