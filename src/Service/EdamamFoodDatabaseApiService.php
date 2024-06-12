<?php

// Servicio para interactuar con la API de la base de datos de alimentos de Edamam
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class EdamamFoodDatabaseApiService
{
    private $client;
    private $baseUrl;
    private $apiKey;

    public function __construct(HttpClientInterface $client, string $baseUrl, string $apiKey)
    {
        $this->client = $client;
        $this->baseUrl = $baseUrl;
        $this->apiKey = $apiKey;
    }

    // Método para buscar información sobre un alimento mediante una palabra clave
    public function buscarAlimentoPorPalabraClave(string $palabraClave): array
    {
        $url = $this->baseUrl . '/api/food-database/v2/parser';
        
        $query = [
            'app_id' => '1fa1656f', 
            'app_key' => $this->apiKey,
            'ingr' => $palabraClave
        ];

        $response = $this->client->request('GET', $url, ['query' => $query]);

        return $response->toArray();
    }

    // Método para consultar las calorías de un alimento en función de una cantidad específica
    public function consultarCalorias(string $alimento, float $cantidadGramos): int
    {
        // Busca el alimento en la base de datos
        $response = $this->buscarAlimentoPorPalabraClave($alimento);

        // Verifica si se encontraron los datos de nutrientes para el alimento
        if (isset($response['parsed'][0]['food']['nutrients']['ENERC_KCAL'])) {
            $caloriasPor100Gramos = $response['parsed'][0]['food']['nutrients']['ENERC_KCAL'];
            $caloriasTotales = ($cantidadGramos / 100) * $caloriasPor100Gramos;

            return round($caloriasTotales);
        } else {
            // Lanza una excepción si el alimento no se encontró en la base de datos
            throw new \Exception('El alimento no se encontró en la base de datos.');
        }
    }
}

