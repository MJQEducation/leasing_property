<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GetExitClearanceApproveDataFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("DROP FUNCTION IF EXISTS get_exit_clearance_approve_data");

        Schema::createFunction(
            name: 'get_exit_clearance_approve_data',
            parameters: ["var_exit_id" => "bigint", "var_user_id" => "bigint"],
            return :"table(check_list json)",
            language: "plpgsql",
            body: "	declare
            _bulletins record;
            _temp_check_list jsonb;
            _temp_bulletin jsonb;
            _form_data jsonb;
        begin
            drop table if exists temp_check_list;
            create temporary table temp_check_list (_check_list json);

            for _bulletins in
            select
                distinct eccl.bulletin_id id
            from exit_clearance_check_lists eccl inner join exit_clearance_bulletins ecb on eccl.bulletin_id=ecb.id
            where eccl.checked_id=var_user_id and is_checked='Unchecked' and ecb.exit_id=var_exit_id and eccl.deleted_at is null
            loop
                _temp_bulletin := ( 	select
                                json_build_object
                                    (
                                        'id',ecb.id,
                                        'exit_id',ecb.exit_id,
                                        'num',m.value,
                                        'name_en',m.name_en,
                                        'name_kh',m.name_kh,
                                        'ordinal',ecb.ordinal
                                    )
                                from exit_clearance_bulletins ecb inner join mainvaluelists m
                                on ecb.questionnaire=m.id  where ecb.id=_bulletins.id and ecb.deleted_at is null
                                order by m.value asc
                        );

                _temp_check_list :=(
                        select
                        json_agg
                        (
                            json_build_object
                            (
                                'id',eccl.id,
                                'checked_id',eccl.checked_id,
                                'checked_code',eccl.checked_code,
                                'position',eccl.position,
                                'name_en',m.name_en,
                                'name_kh',m.name_kh,
                                'ordinal',eccl.ordinal,
                                'is_checked',eccl.is_checked,
                                'emp_name',eccl.emp_name,
                                'is_allow_check',case when eccl.checked_id=var_user_id then true else false end
                            )
                        )
                        from exit_clearance_check_lists eccl inner join mainvaluelists m on eccl.questionnaire=m.id
                        where eccl.bulletin_id=_bulletins.id and eccl.deleted_at is null
                );

                _form_data := (select _temp_bulletin || jsonb_build_object('check_list',_temp_check_list));


                insert into temp_check_list values(_form_data);
            end loop;


            return query select * from temp_check_list;
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
        DB::statement("DROP FUNCTION IF EXISTS get_exit_clearance_approve_data");
    }
}
