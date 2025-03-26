<?php

namespace App\Http\Controllers;

use App\Helper\RBAC;
use App\Models\Mainvaluelist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class MainvaluelistController extends Controller
{
    public function index()
    {
        if (session()->has('AuthToken') == false) {
            return redirect('login');
        }

        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            //return redirect to authourized
            return View('social.unauthorized');
        }

        return View('Mainvaluelist.index');
    }

    #region MVL
    public function getMVLList()
    {
        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $mvl = DB::select("select
                            m.id,
                            m.abbreviation,
                            m.name_en,
                            m.name_kh,
                            m.\"type\",
                            m.value,
                            m.ordinal,
                            m.parent_mvl,
                            parent.name_en parent
                        from mainvaluelists m left join mainvaluelists parent
                        on m.parent_mvl=parent.id
                        where
                        m.deleted_at is null");
        return ['result' => 'success', 'msg' => '', 'data' => $mvl];
    }

    public function getMVLTypes()
    {
        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $list = DB::select(
            'SELECT "name_en" FROM mainvaluelists WHERE type=? AND deleted_at IS NULL',
            ['MVL']
        );

        return ['result' => 'success', 'msg' => '', 'data' => $list];
    }

    public function getParentMVL()
    {
        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $list = DB::select(
            'SELECT id,name_en FROM mainvaluelists WHERE type<>? AND deleted_at IS NULL',
            ['MVL']
        );

        return ['result' => 'success', 'msg' => '', 'data' => $list];
    }

    public function saveMVL(Request $request)
    {
        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $mvl = new Mainvaluelist();
        $mvl->abbreviation = $request->abbreviation;
        $mvl->name_en = $request->name_en;
        $mvl->name_kh = $request->name_kh;
        $mvl->type = $request->type;
        $mvl->parent_mvl = $request->parent_mvl;
        $mvl->value = $request->value == null ? '' : $request->value;
        $mvl->ordinal = $request->ordinal;
        $mvl->maker = session('userid');
        $mvl->save();

        $new_mvl = DB::select("select
            m.id,
            m.abbreviation,
            m.name_en,
            m.name_kh,
            m.\"type\",
            m.value,
            m.ordinal,
            m.parent_mvl,
            parent.name_en parent
        from mainvaluelists m left join mainvaluelists parent
        on m.parent_mvl=parent.id
        where
        m.deleted_at is null and m.id=$mvl->id")[0];

        return [
            'result' => 'success',
            'msg' => $request->type . ' : ' . $request->name_en . ' have been save',
            'data' => $new_mvl,
        ];
    }

    public function editMVL(Request $request)
    {
        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $mvl = Mainvaluelist::find($request->id);

        return ['result' => 'success', 'msg' => '', 'data' => $mvl];
    }

    public function updateMVL(Request $request)
    {
        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $mvl = Mainvaluelist::find($request->id);
        $mvl->abbreviation = $request->abbreviation;
        $mvl->name_en = $request->name_en;
        $mvl->name_kh = $request->name_kh;
        $mvl->type = $request->type;
        $mvl->parent_mvl = $request->parent_mvl;
        $mvl->value = $request->value == null ? '' : $request->value;
        $mvl->ordinal = $request->ordinal;
        $mvl->maker = session('userid');
        $mvl->save();

        $update_mvl = DB::select("select
            m.id,
            m.abbreviation,
            m.name_en,
            m.name_kh,
            m.\"type\",
            m.value,
            m.ordinal,
            m.parent_mvl,
            parent.name_en parent
        from mainvaluelists m left join mainvaluelists parent
        on m.parent_mvl=parent.id
        where
        m.deleted_at is null and m.id=$mvl->id")[0];

        return [
            'result' => 'success',
            'msg' => $request->type . ' : ' . $mvl->name_en . ' update completed ',
            'data' => $update_mvl,
        ];
    }

    public function deleteMVL(Request $request)
    {
        if (!RBAC::isAccessible(str_replace('Controller', '', class_basename(Route::current()->controller)) . '-' . Route::getCurrentRoute()->getActionMethod())) {
            return ['result' => 'error', 'msg' => 'Unauthorized Action', 'data' => ''];
        }

        $mvl = Mainvaluelist::find($request->id);
        $mvl->delby = session('userid');
        $mvl->save();
        $mvl->delete();

        return [
            'result' => 'success',
            'msg' => $mvl->type . ' : ' . $mvl->name_en . ' have been remove ',
            'data' => '',
        ];
    }
    #endregion
}
