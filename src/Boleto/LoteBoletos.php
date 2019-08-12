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

    /**
     * @param string $credencial Credencial da conta de boleto
     * @param string $chave      Chave da conta de boleto
     * @param array  $boletos    Array de Boleto
     */
    public function __construct(string $credencial, string $chave, array $boletos = null)
    {
        $this->credencial = $credencial;
        $this->chave = $chave;

        if (!empty($boletos)) {
            $this->boletos = $boletos;
        }
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

    public function count()
    {
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

    public function toArray(): array
    {
        if (!$this->boletos) {
            return [];
        }

        $boletos = [];

        foreach ($this->boletos as $boleto) {
            $boletos[] = $boleto->getValues();
        }

        return $boletos;
    }

    public function gerar()
    {
        $boletosGerados = (new Emissor($this))->emitir();

        foreach ($boletosGerados as $key => $boleto) {
            $this->boletos[$key]
                ->setNossoNumero($boleto['nossonumero'])
                ->setIdUnico((int) $boleto['id_unico'])
                ->setLinhaDigitavel($boleto['linhaDigitavel'])
                ->setLink($boleto['linkBoleto']);
        }
    }
}
