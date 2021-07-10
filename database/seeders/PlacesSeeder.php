<?php

namespace Database\Seeders;

use App\Models\Place;
use Illuminate\Database\Seeder;

/**
 * Class PlacesSeeder
 * @package Database\Seeders
 */
class PlacesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        $array_from_csv = $this->csvToArray(storage_path('files/places.csv'));
        $array_for_seed = $this->prepareDataToSeed($array_from_csv);

        foreach ($array_for_seed as $data) {
            $model = new Place();
            $model->fill($data);
            $model->save();
        }
    }

    /**
     * @param array $array
     * @return array
     */
    private function prepareDataToSeed(array $array): array
    {
        $data = collect($array)->map(function ($item) {
            $coordinates = $item['coordinates'] ?? ',';
            [$lat, $lng] = explode(',', $coordinates);
            $title = $item['name'] ?? '';
            return compact('title', 'lat', 'lng');
        });

        return $data->toArray();
    }

    /**
     * @param string $filename
     * @param string $delimiter
     * @return array
     * @throws \Exception
     */
    private function csvToArray(string $filename = '', string $delimiter = ','): array
    {
        if (!file_exists($filename) || !is_readable($filename)) {
            throw new \Exception("File {$filename} is not exists.");
        }
        $header = null;
        $data = [];
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $data;
    }
}
