<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\ForecastRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\WeatherUtil;

final class WeatherController extends AbstractController
{
    #[Route('/weather/{city}/{country}', name: 'app_weather', requirements: ['city' => '[^/]+', 'country' => '[A-Z]{2}'])]
    #[Route('/weather/{city}', name: 'app_weather_city_only', requirements: ['city' => '[^/]+'])]
    public function city(
        #[MapEntity(mapping: ['city' => 'city', 'country' => 'country'], stripNull: true)]
        Location $location,
        WeatherUtil $util,
    ): Response {
        $forecasts = $util->getWeatherForLocation($location);

        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'forecasts' => $forecasts,
        ]);

}
}
//ai pomoglo przy tym: 'city' => '[^/]+', 'country' => '[A-Z]{2}']
