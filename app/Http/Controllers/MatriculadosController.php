<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class MatriculadosController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function list($diario) {
        // $rs = (object) ['professores' => null, 'alunos' => null];
        // $rs->alunos = app('db')->select("SELECT * FROM alunos t WHERE t.diario_id = '{$diario}'");
        // $rs->professores = app('db')->select("SELECT * FROM professores t WHERE t.diario_id = '{$diario}'");
        $results = app('db')->select("SELECT * FROM diarios t WHERE t.codigo = '{$diario}'");
        foreach ($results as $key => $value) {

            $rs = app('db')->select("SELECT * FROM turmas t WHERE t.id = {$value->id}");
            if (!empty($rs)) {
                $value->turma = $rs[0];
                
                $rss = app('db')->select("SELECT * FROM cursos t WHERE t.id = {$rs[0]->id}");
                if (!empty($rss)) {
                    $value->turma->curso = $rss[0];
                } else {
                    $value->turma->curso = '';
                }
            } else {
                $value->turma = '';
            }

            $rs = app('db')->select("SELECT * FROM componentes_curriculares t WHERE t.id = {$value->id}");
            if (!empty($rs)) {
                $value->componente_curricular = $rs[0];
            } else {
                $value->componente_curricular = null;
            }

            $rs = app('db')->select("SELECT * FROM campi t WHERE t.id = {$value->id}");
            if (!empty($rs)) {
                $value->campus = $rs[0];
            } else {
                $value->campus = '';
            }

            $rs = app('db')->select("SELECT * FROM professores t WHERE t.id = {$value->id}");
            if (!empty($rs)) {
                $value->professor = $rs;
            } else {
                $value->professor = '';
            }
        }
        print_r($results);
        return response()->json($results);
    }
}
