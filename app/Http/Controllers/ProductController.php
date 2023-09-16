<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function search(Request $request): JsonResponse
    {
        $maxPrice = $request->input('maxPrice');
        $sortBy = $request->input('sortBy');
        $dir = $request->input('dir'); // the direction of sorting. can be 'asc' or 'desc'
        $q = $request->input('q');

        $searchService = Product::searchService();
        $searchService->filterWhen($request->has('maxPrice'),'price', '<', $maxPrice);
        $searchService->sortByWhen($request->has('sortBy'), $sortBy, $dir);
        $response = $searchService->searchWhen($request->has('q'), $q);
        return response()->json($response, Response::HTTP_OK);
    }


}
