<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class HealthController extends Controller
{
    /**
     * Health check endpoint.
     *
     * @return JsonResponse
     */
    public function check(): JsonResponse
    {
        $status = [
            'status' => 'healthy',
            'timestamp' => now()->toIso8601String(),
            'service' => 'Expense Manager API',
            'version' => '1.0.0',
        ];

        // Check database connection
        try {
            DB::connection()->getPdo();
            $status['database'] = 'connected';
        } catch (\Exception $e) {
            $status['database'] = 'disconnected';
            $status['status'] = 'unhealthy';
        }

        // Check cache connection (if Redis is configured)
        try {
            if (config('cache.default') === 'redis') {
                Redis::connection()->ping();
                $status['cache'] = 'connected';
            } else {
                $status['cache'] = 'not configured';
            }
        } catch (\Exception $e) {
            $status['cache'] = 'disconnected';
        }

        $httpCode = $status['status'] === 'healthy' ? 200 : 503;

        return $this->successResponse($status, 'Health check completed', $httpCode);
    }
}

