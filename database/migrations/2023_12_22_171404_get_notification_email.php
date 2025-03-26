<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GetNotificationEmail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("DROP FUNCTION IF EXISTS get_notification_email");

        Schema::createFunction(
            name: 'get_notification_email',
            parameters: ["var_exit_id" => "bigint"],
            return :"TABLE(re_user_name varchar(100), re_user_cardid varchar(100), re_email varchar(100), re_checker_name varchar(100))",
            language: "plpgsql",
            body: "begin
                            DROP TABLE IF EXISTS _temp;
                            create TEMPORARY TABLE _temp (
                        exit_user_name varchar(100),
                        exit_user_cardid varchar(100),
                        email varchar(100),
                        checker_name varchar(100)
                            );

                        insert into _temp
                    select distinct
                    ec.\"name\",
                    ec.card_id,
                    u.email,
                    u.name as checker_name
                    from exit_clearance_check_lists eccl
                    inner join exit_clearance_bulletins ecb on eccl.bulletin_id=ecb.id
                    inner join users u on eccl.checked_id=u.id
                    inner join exit_clearances ec on ec.id=ecb.exit_id
                    where ecb.exit_id = var_exit_id and not (u.email is null or u.email='');

                return query select * from _temp;
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
        DB::statement("DROP FUNCTION IF EXISTS get_notification_email");
    }
}
