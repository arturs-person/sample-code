<?php

namespace App\Services;

use App\API\Client;
use App\Entities\Transaction;
use App\Exceptions\CsvFileNotValidException;
use DateTime;
use DateTimeZone;
use Doctrine\Common\Collections\ArrayCollection;
use League\Csv\Reader;

use App\API\MapOnApi;

/**
 * Pre defined Headers
 */
const CSV_KEY_DATE = 'Date';
const CSV_KEY_TIME = 'Time';
const CSV_KEY_CARD_NR = 'Card Nr.';
const CSV_KEY_VEHICLE_NR = 'Vehicle Nr.';
const CSV_KEY_PRODUCT = 'Product';
const CSV_KEY_AMOUNT = 'Amount';
const CSV_KEY_TOTAL_SUM = 'Total sum';
const CSV_KEY_CURRENCY = 'Currency';
const CSV_KEY_COUNTRY = 'Country';
const CSV_KEY_COUNTRY_ISO = 'Country ISO';
const CSV_KEY_FUEL_STATION = 'Fuel station';

const EXPECTED_HEADERS = [
    CSV_KEY_DATE,
    CSV_KEY_TIME,
    CSV_KEY_CARD_NR,
    CSV_KEY_VEHICLE_NR,
    CSV_KEY_PRODUCT,
    CSV_KEY_AMOUNT,
    CSV_KEY_TOTAL_SUM,
    CSV_KEY_CURRENCY,
    CSV_KEY_COUNTRY,
    CSV_KEY_COUNTRY_ISO,
    CSV_KEY_FUEL_STATION
];

const FUEL_CATEGORIES = [
    'Diesel' => [
        'diesel',
        'd miles'
    ],
    'Gasoline, 95' => [
        'gasoline',
        '95'
    ],
    'Gasoline, 98' => [
        'gasoline',
        '98'
    ],
    'Electricity' => [
        'electricity',
        'charge station',
        'charging'
    ],
    'CNG (Compressed natural gas)' => [
        'CNG'
    ]
];

class TransactionFileService
{
    public function process(string $filename): array
    {
        $path = STORAGE_PATH . '/' . $filename;
        $csvReader = Reader::createFromPath($path, 'r');
        $csvReader->setHeaderOffset(0);
        $this->validateHeaders($csvReader->getHeader());

        $data = [];
        $records = $csvReader->getRecords();
        foreach ($records as $index => $item) {
            array_push($data, $item);
        }

        return $data;
    }

    public function prepareTransactionsCollection(array $data): ArrayCollection
    {
        $collection = new ArrayCollection();
        if ($data) {
            foreach ($data as $item) {
                $transaction = (new Transaction())
                    ->setAmount(floatval($item[CSV_KEY_AMOUNT]))
                    ->setCardNumber($item[CSV_KEY_AMOUNT])
                    ->setCurrency($item[CSV_KEY_CURRENCY])
                    ->setFuelStation($item[CSV_KEY_FUEL_STATION])
                    ->setProduct($item[CSV_KEY_PRODUCT])
                    ->setTotal(floatval($item[CSV_KEY_TOTAL_SUM]))
                    ->setVehicleNumber($item[CSV_KEY_VEHICLE_NR])
                    ->setCountry($item[CSV_KEY_COUNTRY])
                    ->setCountryIso($item[CSV_KEY_COUNTRY_ISO])
                    ->setProductCategory($item['productCategory']);
                $combinedDateString = $item[CSV_KEY_DATE] . ' ' . $item[CSV_KEY_TIME];

                $timeZones = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $item[CSV_KEY_COUNTRY_ISO]);
                // Mentioned in the task to use any Time Date Region from country
                $date = new DateTime($combinedDateString, new DateTimeZone($timeZones[0]));

                $transaction->setDate($date);
                $collection->add($transaction);
            }
        }

        return $this->prepareApiData($collection);
    }

    public function getDataFromTransactionFile(string $filename): array
    {
        $rawTransactions = $this->process($filename);
        $prepared = [];

        foreach($rawTransactions as $rawTransaction) {
            $result = $this->validateTransaction($rawTransaction);
            if ($result) {
                array_push($prepared, $result);
            }
        }

        return $prepared;
    }

    protected function prepareApiData(ArrayCollection $transactions)
    {
        $httpClient = new Client();
        $apiClient = new ApiClient($httpClient);
        $vehicleNumbers = [];
        foreach ($transactions as $transaction) {
            array_push($vehicleNumbers, $transaction->getVehicleNumber());
        }
        $unitsData = $apiClient->getUnits($vehicleNumbers);

        $map = [];
        foreach ($unitsData['data']['units'] as $unit) {
            $map[$unit['number']] = ['unit_id' => $unit['unit_id'], 'last_update' => $unit['last_update']];
        }

        foreach ($map as $carNumber => $unitId) {
            $transaction = $transactions->filter(function (Transaction $transaction) use($carNumber) {
                return ($transaction->getVehicleNumber() === $carNumber);
            });
        }

    }

    protected function validateHeaders(array $headers): bool
    {

        if (count($headers) > count(EXPECTED_HEADERS)) {
            throw new CsvFileNotValidException('Csv file not valid.');
        }
        foreach ($headers as $index => $header) {
            if ($header !== EXPECTED_HEADERS[$index]) {
                throw new CsvFileNotValidException('Csv file not valid.');
            }
        }

        return true;
    }

    public function validateTransaction($rawTransaction): array|bool
    {
        // Validate by product type
        $productType = $rawTransaction[CSV_KEY_PRODUCT];
        $productCategory = '';
        foreach (FUEL_CATEGORIES as $category => $keywords) {
            $matched = false;
            foreach ($keywords as $keyword) {
                if (preg_match('/' . $keyword .'/i', $productType)) {
                    $matched = true;
                    break;
                }
            }

            if ($matched) {
                $productCategory = $category;
                break;
            }
        }

        return $productCategory
            ? [...$rawTransaction, 'productCategory' => $productCategory]
            : false;
    }
}