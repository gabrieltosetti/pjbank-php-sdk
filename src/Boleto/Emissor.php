<?php

namespace PJBank\Boleto;

use PJBank\Api\PJBankClient;

use GuzzleHttp\Exception\ClientException;

/**
 * Class Emissor de Boletos no PJBank
 * @author Matheus Fidelis <matheus.fidelis@superlogica.com>
 * @package PJBank\Boleto
 */
class Emissor
{
    /**
     * @var Boleto
     */
    private $boleto;

    /**
     * @var LoteBoletos
     */
    private $loteBoletos;

    /**
     * Emissor constructor.
     * @param Boleto|LoteBoletos $boleto Informar um Boleto ou LoteBoletos.
     */
    public function __construct($boleto)
    {
        if ($boleto instanceof Boleto) {
            $this->boleto = $boleto;
        } elseif ($boleto instanceof LoteBoletos) {
            $this->loteBoletos = $boleto;
        } else {
            throw new \Exception("Informar apenas um Boleto ou Lote de boletos.", 500);
        }
    }

    /**
     * Emite um boleto ou Lote de boletos via API
     * @return array
     */
    public function emitir(): array
    {
        return !empty($this->boleto) ? $this->enviarBoleto() : $this->enviarLoteBoleto();
    }

    private function enviarBoleto(): array
    {
        return $this->enviarRequest(
            $this->boleto->getValues(),
            $this->boleto->getCredencialBoleto(),
            $this->boleto->getChaveBoleto()
        );
    }

    private function enviarLoteBoleto(): array
    {
        $bodyRequest = [
            'cobrancas' => $this->loteBoletos->toArray(),
        ];

        return $this->enviarRequest(
            $bodyRequest,
            $this->loteBoletos->getCredencial(),
            $this->loteBoletos->getChave()
        );
    }

    private function enviarRequest(array $body, string $credencial, string $chave): array
    {
        $client = (new PJBankClient())->getClient();

        try {
            $res = $client->request(
                'POST',
                "recebimentos/{$credencial}/transacoes",
                [
                    'json' => json_encode($body),
                    'headers' => [
                        'Content-Type' => 'Application/json',
                        'X-CHAVE' => $chave,
                    ],
                ]
            );

            return json_decode((string) $res->getBody());
        } catch (ClientException $e) {
            $responseBody = json_decode($e->getResponse()->getBody());
            throw new \Exception($responseBody->msg, $responseBody->status);
        }
    }
}
