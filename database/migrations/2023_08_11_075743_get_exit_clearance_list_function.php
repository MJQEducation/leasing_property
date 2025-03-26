<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GetExitClearanceListFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("DROP FUNCTION IF EXISTS get_exit_clearance_list");

        Schema::createFunction(
            name: 'get_exit_clearance_list',
            parameters: ["var_search_value" => "varchar(250)", "var_order_by" => "varchar(50)", "var_ordinal" => "varchar(50)", "start_from" => "bigint", "limits" => "int", "user_id" => "int"],
            return :"TABLE(re_id bigint,
            re_card_id citext,
            re_name citext,
            re_position citext,
            re_department citext,
            re_line_management citext,
            re_email citext,
            re_phone citext,
            re_hired_date timestamp(0),
            re_last_working_date timestamp(0),
            re_status varchar(15),
            total_record int,
            filter_record int)",
            language: "plpgsql",
            body: "declare
            _total_record bigint;
            _filter_record bigint;
            _sql varchar(5000);
        begin

            _total_record:=(select count(*) from exit_clearances where deleted_at is null);

           _sql:='select
                    id,
                    card_id,
                    \"name\",
                    \"position\",
                    department,
                    line_management,
                    email,
                    phone,
                    hired_date,
                    last_working_date,
                    status,
                    %s total_record,
                    %s filter_record
                from exit_clearances
                where deleted_at is null and maker=%s';

           if var_search_value is null or var_search_value='' then
              _filter_record:=_total_record;
              RETURN QUERY EXECUTE FORMAT(_sql || ' order by %s %s limit %s offset %s',_total_record,_filter_record,user_id,var_order_by,var_ordinal,limits,start_from);
           else
              _filter_record:=(select count(id) from exit_clearances
                                    where deleted_at is null and maker=user_id and
                                    (
                                        card_id like '%' || var_search_value || '%'
                                        or
                                        \"name\" like '%' || var_search_value || '%'
                                        or
                                        \"position\" like '%' || var_search_value || '%'
                                        or
                                        department like '%' || var_search_value || '%'
                                        or
                                        line_management like '%' || var_search_value || '%'
                                        or
                                        phone like '%' || var_search_value || '%'
                                        or
                                        status like '%' || var_search_value || '%'
                                    )
                                );

               RETURN QUERY EXECUTE FORMAT(_sql
                                    || ' and '
                                    || '
                                        (
                                            card_id like ''%%%s%%''
                                            or
                                            \"name\" like ''%%%s%%''
                                            or
                                            \"position\" like ''%%%s%%''
                                            or
                                            department like ''%%%s%%''
                                            or
                                            line_management like ''%%%s%%''
                                            or
                                            phone like ''%%%s%%''
                                            or
                                            status like ''%%%s%%''
                                        )
                                        '
                                    || ' order by %s %s limit %s offset %s',
                                _total_record,
                                _filter_record,
                                user_id,
                                var_search_value,
                                var_search_value,
                                var_search_value,
                                var_search_value,
                                var_search_value,
                                var_search_value,
                                var_search_value,
                                var_order_by,
                                var_ordinal,
                                limits,
                                start_from
                                );

           end if;
        end;"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP FUNCTION IF EXISTS get_exit_clearance_list");
    }
}
