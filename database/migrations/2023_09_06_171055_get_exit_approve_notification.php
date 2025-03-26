<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GetExitApproveNotification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("DROP FUNCTION IF EXISTS get_exit_approve_notification");

        Schema::createFunction(
            name: 'get_exit_approve_notification',
            parameters: ["var_user_id" => "bigint"],
            return :"table(
                re_signature_id bigint,
                re_exit_id integer,
                re_action text,
                re_exit_name citext,
                re_status varchar(50),
                re_emp_id integer,
                re_card_id citext,
                re_ordinal integer,
                last_working_date timestamp
                )",
            language: "plpgsql",
            body: "declare
            rec record;
            pre_rec record;
            _signature_id varchar(5000);
            _sql varchar(5000);
          begin
              DROP TABLE IF EXISTS _temp;
              create TEMPORARY TABLE _temp (
                   signature_id bigint,
                   exit_id integer,
                   \"action\" text,
                   exit_name citext,
                   status varchar(50),
                   emp_id integer,
                   card_id citext,
                   ordinal integer,
                   last_working_date timestamp
                );

               _signature_id:=(select STRING_AGG(id::character varying,',') id  from exit_clearance_signatures ecs where ecs.signed_id=var_user_id and ecs.deleted_at is null and ecs.is_signed=false);
               _signature_id:='(' || _signature_id || ')';

              if _signature_id is null then
                  return query select * from _temp;
              else
                   _sql:='select
                       ecs.id,
                       ecs.exit_id,
                       case sign_title
                       when ''Personnel Officer'' then ''Prepared''
                       when ''Line Manager'' then ''Checked''
                       when ''Employee'' then ''Accepted''
                       when ''HOD''  then ''Approved''
					   when ''CD''  then ''Approved''
					   when ''Principal''  then ''Approved''
                       when ''HR Dept'' then ''Acknowledged'' end actions,
                       ec.\"name\" exit_name,
                       ec.status,
                       ec.emp_id,
                       ec.card_id,
                       ecs.ordinal,
                       ec.last_working_date
                      from exit_clearance_signatures ecs inner join exit_clearances ec
                      on ecs.exit_id=ec.id
                      where ecs.deleted_at is null and ec.deleted_at is null and ec.status!=''Completed'' and ec.is_checked_completed=true
                      and ecs.id in %s order by ecs.ordinal';

                   for rec in EXECUTE FORMAT(_sql,_signature_id)
                   loop
                       if rec.ordinal=1 then
                          insert into _temp(signature_id,exit_id,\"action\",exit_name,status,emp_id,card_id,ordinal,last_working_date)
                          values(rec.id,rec.exit_id,rec.actions,rec.exit_name,rec.status,rec.emp_id,rec.card_id,rec.ordinal,rec.last_working_date);
                      else
                          select * into pre_rec from exit_clearance_signatures where ordinal=(rec.ordinal-1) and exit_id=rec.exit_id and deleted_at is null;
                          if pre_rec.is_signed=true then
                              insert into _temp(signature_id,exit_id,\"action\",exit_name,status,emp_id,card_id,ordinal,last_working_date)
                              values(rec.id,rec.exit_id,rec.actions,rec.exit_name,rec.status,rec.emp_id,rec.card_id,rec.ordinal,rec.last_working_date);
                          end if;
                      end if;
                   end loop;

               return query select * from _temp;

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
        DB::statement("DROP FUNCTION IF EXISTS get_exit_approve_notification");
    }
}
