<?php

namespace PJBankTests\Recebimento\Boletos;

use PJBank\Recebimento;
use PJBank\Boleto\Boleto;
use PJBank\Boleto\LoteBoletos;

class BoletosTest extends \PHPUnit\Framework\TestCase
{
    public function testEmitirBoleto()
    {
        $credencial = "263d55fcb972981967a15d1347cec8e53f7d43a8";
        $chave = "5794a4746807244d01590c2d417138d9d1b4c3dd";

        $PJBankRecebimentos = new Recebimento($credencial, $chave);
        $boleto = $PJBankRecebimentos->Boletos->NovoBoleto();

        $boleto
            ->setNomeCliente("Matheus Fidelis")
            ->setCpfCliente("29454730000144")
            ->setValor(10.50)
            ->setVencimento("09/01/2017")
            ->setPedidoNumero(rand(0, 999))
            ->gerar();

        $this->assertObjectHasAttribute('vencimento', $boleto);
        $this->assertObjectHasAttribute('valor', $boleto);
        $this->assertObjectHasAttribute('juros', $boleto);
        $this->assertObjectHasAttribute('multa', $boleto);
        $this->assertObjectHasAttribute('desconto', $boleto);
        $this->assertObjectHasAttribute('nome_cliente', $boleto);
        $this->assertObjectHasAttribute('cpf_cliente', $boleto);
        $this->assertObjectHasAttribute('endereco_cliente', $boleto);
        $this->assertObjectHasAttribute('numero_cliente', $boleto);
        $this->assertObjectHasAttribute('complemento_cliente', $boleto);
        $this->assertObjectHasAttribute('bairro_cliente', $boleto);
        $this->assertObjectHasAttribute('cidade_cliente', $boleto);
        $this->assertObjectHasAttribute('numero_cliente', $boleto);
        $this->assertObjectHasAttribute('texto', $boleto);
        $this->assertObjectHasAttribute('logo_url', $boleto);
        $this->assertObjectHasAttribute('grupo', $boleto);
        $this->assertObjectHasAttribute('link', $boleto);
        $this->assertObjectHasAttribute('linha_digitavel', $boleto);
        $this->assertObjectHasAttribute('id_unico', $boleto);
    }

    public function testEmitirLoteBoleto()
    {
        $credencial = "263d55fcb972981967a15d1347cec8e53f7d43a8";
        $chave = "5794a4746807244d01590c2d417138d9d1b4c3dd";

        $loteBoleto = new LoteBoletos(
            $credencial,
            $chave,
            [
                (new Boleto($credencial, $chave))
                    ->setNomeCliente("Tosetti")
                    ->setCpfCliente("29454730000144")
                    ->setValor(10.50)
                    ->setVencimento("09/01/2017")
                    ->setPedidoNumero(rand(0, 999)),
                (new Boleto($credencial, $chave))
                    ->setNomeCliente("Matheus Fidelis")
                    ->setCpfCliente("29454730000144")
                    ->setValor(10.50)
                    ->setVencimento("09/01/2017")
                    ->setPedidoNumero(rand(0, 999)),
            ]
        );

        $loteBoleto->gerar();

        foreach ($loteBoleto as $boleto) {
            $this->assertObjectHasAttribute('vencimento', $boleto);
            $this->assertObjectHasAttribute('valor', $boleto);
            $this->assertObjectHasAttribute('juros', $boleto);
            $this->assertObjectHasAttribute('multa', $boleto);
            $this->assertObjectHasAttribute('desconto', $boleto);
            $this->assertObjectHasAttribute('nome_cliente', $boleto);
            $this->assertObjectHasAttribute('cpf_cliente', $boleto);
            $this->assertObjectHasAttribute('endereco_cliente', $boleto);
            $this->assertObjectHasAttribute('numero_cliente', $boleto);
            $this->assertObjectHasAttribute('complemento_cliente', $boleto);
            $this->assertObjectHasAttribute('bairro_cliente', $boleto);
            $this->assertObjectHasAttribute('cidade_cliente', $boleto);
            $this->assertObjectHasAttribute('numero_cliente', $boleto);
            $this->assertObjectHasAttribute('texto', $boleto);
            $this->assertObjectHasAttribute('logo_url', $boleto);
            $this->assertObjectHasAttribute('grupo', $boleto);
            $this->assertObjectHasAttribute('link', $boleto);
            $this->assertObjectHasAttribute('linha_digitavel', $boleto);
            $this->assertObjectHasAttribute('id_unico', $boleto);
        }
    }
}
