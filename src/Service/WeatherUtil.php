<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Forecast;
use App\Entity\Location;
use App\Repository\ForecastRepository;
use App\Repository\LocationRepository;
class WeatherUtil
{
    private ForecastRepository $forecastRepository;
    private LocationRepository $locationRepository;

    public function __construct(ForecastRepository $forecastRepository,LocationRepository $locationRepository)
    {
        $this->forecastRepository = $forecastRepository;
        $this->locationRepository = $locationRepository;
    }
    /**
     * @return Forecast[]
     */
    public function getWeatherForLocation(Location $location): array
    {
        return $this->forecastRepository->findBy(['location' => $location]);
    }

    /**
     * @return Forecast[]
     */
    public function getWeatherForCountryAndCity(string $countryCode, string $city): array
    {
        $location = $this->locationRepository->findOneBy(['country' => $countryCode, 'city' => $city,]);

        return $this->getWeatherForLocation($location);
    }
}
