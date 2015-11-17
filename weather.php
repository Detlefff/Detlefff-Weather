<?php
use Cmfcmf\OpenWeatherMap;
use Cmfcmf\OpenWeatherMap\Exception as OWMException;

// Must point to composer's autoload file.
require('vendor/autoload.php');

class weather extends Script
{
	private $apiKey = '';

	public function run() {
		$owm = new OpenWeatherMap();

		try {
		    $weatherNow = $owm->getWeather($this->matches[1], 'metric', 'en', $this->apiKey);
		} catch(\Exception $e) {
		    return $this->send('Failed to fetch weather data');
		}

		$message = "Currently " . $weatherNow->temperature->getFormatted() . " in " . $weatherNow->city->name;
		$message .= "\nHumidity: " . $weatherNow->humidity->getFormatted();
		$message .= "\nPressure: " . $weatherNow->pressure->getFormatted();
		$message .= "\nWind: " . $weatherNow->wind->speed->getDescription() . " from " . $weatherNow->wind->direction->getDescription() . " (" . $weatherNow->wind->speed->getFormatted() . ")";
		$message .= "\nPrecipation: " .  $weatherNow->precipitation->getDescription() . " (" . $weatherNow->precipitation . ")";
		$message .= "\nClouds: " . $weatherNow->clouds->getDescription();

		return $this->send($message);
	}
}
