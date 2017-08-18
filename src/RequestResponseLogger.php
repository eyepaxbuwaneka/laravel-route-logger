<?php

namespace Eyepax\RouteLogger;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Closure;
use Log;

class RequestResponseLogger
{
    private $start = 0;
    private $end = 0;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->start = microtime(true);

        return $next($request);
    }

    public function terminate($request, $response)
    {
        $this->end = microtime(true);

        $this->log($request);
    }

    protected function log($request)
    {
        $ip = $request->getClientIp();
        $url = $request->url();
        $method = $request->getMethod();
        $agent = $request->server('HTTP_USER_AGENT');
        $agentSerialized = serialize($agent);
        $query = $request->query();
        $time = Carbon::now()->toDateTimeString();

        if (Schema::hasTable('trn_route_log')) {
            DB::table('trn_route_log')->insert(
                ["ip" => $ip, "url" => $url, "user_agent" => $agentSerialized, "method" => $method, "query_values" => serialize($query), "created_at" => $time, "updated_at" => $time]
            );
        }
    }

}