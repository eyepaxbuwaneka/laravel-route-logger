<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class TrnRouteLog extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up() {
            Schema::create(config('routelog.table_name'), function (Blueprint $table) {
                $table->increments('id');
                if (config('routelog.columns.ip')) {
                    $table->string('ip');
                }
                if (config('routelog.columns.url')) {
                    $table->mediumText('url');
                }
                if (config('routelog.columns.method')) {
                    $table->string('method');
                }
                if (config('routelog.columns.agent')) {
                    $table->string('user_agent');
                }
                if (config('routelog.columns.query')) {
                    $table->mediumText('query_values');
                }
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down() {
            Schema::drop(config('routelog.table_name'));
        }
    }
