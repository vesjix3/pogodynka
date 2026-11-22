<?php

namespace App\Controller;

use App\Entity\Forecast;
use Symfony\Component\HttpFoundation\Response;
use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

final class WeatherApiController extends AbstractController
{
    #[Route('/api/v1/weather', name: 'app_weather_api', methods: ['GET'])]

    public function index(
        WeatherUtil $util,
        #[MapQueryParameter] string $country,
        #[MapQueryParameter] string $city,
        #[MapQueryParameter] string $format = 'json',
        #[MapQueryParameter('twig')] bool $twig = false,
    ):

    Response
    {

        $forecasts = $util->getWeatherForCountryAndCity($country, $city);

        if ($twig) {
            return $this->render('weather_api/index.' . $format . '.twig', [
                'city' => $city,
                'country' => $country,
                'measurements' => $forecasts,
            ]);
        }

        if ($format === 'csv') {
            $csv = "city,country,date,celsius,fahrenheit\n";
            foreach ($forecasts as $f) {
                $csv .= "$city,$country," . $f->getDate()->format('Y-m-d') . ',' . $f->getTemperature() . ',' . $f->getFahrenheit() . "\n";
            }

            return new Response($csv);
        }

        return $this->json([
            'city' => $city,
            'country' => $country,
            'measurements' => array_map(fn(Forecast $f) => [
                'date' => $f->getDate()->format('Y-m-d'),
                'celsius' => $f->getTemperature(),
                'fahrenheit' => $f->getFahrenheit(),
            ], $forecasts),
        ]);
    }
}
