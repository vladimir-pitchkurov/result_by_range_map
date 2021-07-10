<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PlacesByRangeRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Place;
use App\Services\PlacesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class PlacesController
 * @package App\Http\Controllers\Api
 */
class PlacesController extends Controller
{
    /**
     * @var PlacesService
     */
    private PlacesService $placesService;

    /**
     * PlacesController constructor.
     * @param PlacesService $placesService
     */
    public function __construct(PlacesService $placesService)
    {
        $this->placesService = $placesService;
    }

    /**
     * @param PlacesByRangeRequest $request
     * @return JsonResponse
     */
    public function placesListByRange(PlacesByRangeRequest $request): JsonResponse
    {
        $list = $this->placesService->placesListByCords($request);

        return new ApiResponse(compact('list'));
    }

    /**
     * @return JsonResponse
     */
    public function all(): JsonResponse
    {
        /**
         *   Here we can to use Cache but i don't now, How often places
         *   list will be refreshed
         **/
        $list = Place::all();

        return new ApiResponse(compact('list'));
    }


}
