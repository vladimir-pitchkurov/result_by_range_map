<?php


namespace App\Services;


use App\Http\Requests\Api\PlacesByRangeRequest;
use App\Models\Place;

/**
 * Class PlacesService
 * @package App\Services
 */
class PlacesService
{
    /**
     * @param PlacesByRangeRequest $request
     * @return array
     */
    public function placesListByCords(PlacesByRangeRequest $request): array
    {
        $range = $request->get('range', 0);
        $target_place_id = $request->get('target_id');

        $target_place = Place::firstWhere('id', $target_place_id);
        $cords_range = $this->calculateSqlCordsRange($target_place, $range);

        $primary_results = Place::where('lat', '>=', $cords_range['lat_min'])
            ->where('lat', '<=', $cords_range['lat_max'])
            ->where('lng', '>=', $cords_range['lng_min'])
            ->where('lng', '<=', $cords_range['lng_max'])
            ->where('id', '!=', $target_place_id)
            ->get()
            ->toArray();

        return $this->filterByRealDistance($target_place, $primary_results, $range);
    }

    private function filterByRealDistance(Place $target, array $full_list, int $range): array
    {
        $list = $this->addDistanceToList($target, $full_list);

        $filtered = collect($list)->filter(function ($item) use ($target, $range) {
            return $item['distance'] <= $range;
        });

        return $filtered->toArray();
    }

    private function addDistanceToList(Place $target, array $list): array
    {
        $list = collect($list)->map(function ($item) use ($target) {
            $item['distance'] = $this->calculateDistance($target['lat'], $target['lng'], $item['lat'], $item['lng']);
            return $item;
        });

        $sorted = $list->sortBy('distance');

        return $sorted->values()->all();
    }

    /**
     * @param Place $target_model
     * @param int $range
     * @return array
     */
    private function calculateSqlCordsRange(Place $target_model, int $range): array
    {
        $gradus_km = $this->kmInCordsGradus();
        return [
            'lat_min' => ($target_model['lat'] - $range / $gradus_km),
            'lat_max' => ($target_model['lat'] + $range / $gradus_km),
            'lng_min' => ($target_model['lng'] - $range / $gradus_km),
            'lng_max' => ($target_model['lng'] + $range / $gradus_km),
        ];
    }

    /**
     * @return int
     */
    private function kmInCordsGradus(): int
    {
        return 110;
    }

    private function calculateDistance(float $lat1, float $lon1, float $lat2, float $lon2, $unit = "K")
    {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        }
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;

        return $miles * 1.609344;
    }
}
