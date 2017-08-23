<?php

    namespace Eyepax\RouteLogger;

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Support\Facades\DB;
    use Carbon\Carbon;
    use Closure;
    use Log;

    /**author: Buwaneka Kalansuriya
     * Class RequestResponseLogger
     *
     * @package Eyepax\RouteLogger
     */
    class RequestResponseLogger {

        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request $request
         * @param  \Closure $next
         * @return mixed
         */
        public function handle($request, Closure $next) {

            return $next($request);
        }

        /**
         * handle responses to a request
         *
         * @param $request
         * @param $response
         */
        public function terminate($request, $response) {
            $isIp = config('routelog.columns.ip');
            $isURL = config('routelog.columns.url');
            $isAgent = config('routelog.columns.agent');
            $isMethod = config('routelog.columns.method');
            $isQuery = config('routelog.columns.query');
            $timeZone = config('routelog.timezone');
            $tableName = config('routelog.table_name');

            $values[] = $this->getData($request, $isIp, $isURL, $isAgent, $isMethod, $isQuery, $timeZone);
            $this->log($values, $tableName);
        }

        /**
         * get the required data from the request object
         *
         * @param $request
         * @param $isIp
         * @param $isURL
         * @param $isAgent
         * @param $isMethod
         * @param $isQuery
         * @param $timeZone
         * @return array
         */
        public function getData($request, $isIp, $isURL, $isAgent, $isMethod, $isQuery, $timeZone) {

            $date = Carbon::now()
                ->toDateTimeString($timeZone);
            $values = [
                "created_at" => $date,
                "updated_at" => $date,
            ];
            if ($request != null) {
                if ($isIp == 1) {
                    $values["ip"] = $request->getClientIp();
                }
                if ($isURL == 1) {
                    $values["url"] = $request->url();
                }
                if ($isAgent == 1) {
                    $values["user_agent"] = serialize($request->server('HTTP_USER_AGENT'));
                }
                if ($isMethod == 1) {
                    $values["method"] = $request->getMethod();
                }
                if ($isQuery == 1) {
                    $values["query_values"] = serialize($request->query());
                }
            } else {
                $values["ip"] = "no value";
                $values["url"] = "no value";
                $values["user_agent"] = "{value: no value}";
                $values["method"] = "no value";
                $values["query_values"] = "{value: no value}";
            }

            return $values;

        }

        /**
         * Insert data into the database
         *
         * @param $values : array of values to be inserted into the database
         * @param $tableName
         * @return bool
         */
        public function log($values, $tableName) {
            if ($values != null) {
                if (Schema::hasTable($tableName)) {
                    DB::table($tableName)->insert(
                        $values
                    );

                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

    }
