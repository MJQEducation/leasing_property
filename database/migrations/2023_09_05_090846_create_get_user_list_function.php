<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateGetUserListFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("DROP FUNCTION IF EXISTS get_employee_list");

        Schema::createFunction(
            name: 'get_employee_list',
            parameters: ["var_search_value" => "varchar(250)", "var_order_by" => "varchar(50)", "var_ordinal" => "varchar(50)", "start_from" => "bigint", "limits" => "int"],
            return :"TABLE(
                re_id bigint,
                re_card_id varchar(50),
                re_name citext,
                re_position citext,
                re_total_record integer,
                re_filter_record integer
            )",
            language: "plpgsql",
            body: "declare
            _total_record bigint;
            _filter_record bigint;
            _sql varchar(5000);
         begin
             --select * from get_employee_list(null,'id','asc',0,10);
             --drop function get_employee_list;
             _total_record:=(select count(*) from users where deleted_at is null);

             _sql:='select
                             id,card_id,\"name\",\"position\",
                             %s total_record,
                             %s filter_record
                         from users
                         where deleted_at is null';

             if var_search_value is null or var_search_value='' then
                _filter_record:=_total_record;
                RETURN QUERY EXECUTE FORMAT(_sql || ' order by %s %s limit %s offset %s',_total_record,_filter_record,var_order_by,var_ordinal,limits,start_from);
             else
                _filter_record:=(select count(id) from users
                                             where deleted_at is null and
                                             (
                                                 card_id like '%' || var_search_value || '%'
                                                 or
                                                 \"name\" like '%' || var_search_value || '%'
                                                 or
                                                 \"position\" like '%' || var_search_value || '%'
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
                                                 )
                                                 '
                                             || ' order by %s %s limit %s offset %s',
                                         _total_record,
                                         _filter_record,
                                         var_search_value,
                                         var_search_value,
                                         var_search_value,
                                         var_order_by,
                                         var_ordinal,
                                         limits,
                                         start_from
                                         );

                    end if;
         end; "
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('get_user_list_function');
    }
}
