<?php

class Modulos_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function existe_modulo($dato) {
        $qry = "select 1 from modulos where modulo = ?";
        $rst = $this->db->query($qry, array($dato));
        return !$rst->num_rows() == 0;
    }

    function existe_modulo_al_editar($dato, $modulo_id) {
        $qry = "select 1 from modulos where modulo = ? and id<>?";
        $rst = $this->db->query($qry, array($dato, $modulo_id));
        return !$rst->num_rows() == 0;
    }

    function existe_alias($dato) {
        $qry = "select 1 from modulos where alias = ?";
        $rst = $this->db->query($qry, array($dato));
        return !$rst->num_rows() == 0;
    }

    function existe_alias_al_editar($dato, $modulo_id) {
        $qry = "select 1 from modulos where alias = ? and id<>?";
        $rst = $this->db->query($qry, array($dato, $modulo_id));
        return !$rst->num_rows() == 0;
    }

    function insertar($data) {
        $this->db->trans_start();
        $qry = "insert into modulos(modulo,alias,descripcion) values(?,?,?)";
        $this->db->query($qry, array($data['modulo'], $data['alias'], $data['descripcion']));
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        }
        $this->db->trans_commit();
        $this->aud->set_operation('modulos', 'insertar', '{modulo:' . $data['modulo'] . ',alias:' . $data['alias'] . ',descripcion:' . $data['descripcion'] . '}');
        return TRUE;
    }

    function editar($data) {
        $this->db->trans_start();
        $qry = "update modulos set modulo=?, alias=?, descripcion=? where id=?";
        $this->db->query($qry, array($data['modulo'], $data['alias'], $data['descripcion'], $data['modulo_id']));
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        }
        $this->db->trans_commit();
        $this->aud->set_operation('modulos', 'editar', '{id:' . $data['modulo_id'] . ',modulo:' . $data['modulo'] . ',alias:' . $data['alias'] . ',descripcion:' . $data['descripcion'] . '}');
        return TRUE;
    }

    function data_paginado($pagina, $por_pagina) {

        $this->db->trans_start();
        $qry = "select * from modulos order by modulo";
        $rst = $this->db->query($qry);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        }
        $this->db->trans_commit();

        return $rst->result_array();
    }

    function paginado() {
        $qry = "select * from modulos where status='activo' order by modulo";
        $rst = $this->db->query($qry);
        $f = Array();
        if ($rst->num_rows() > 0) {
            foreach ($rst->result() as $row) {
                $gear = '<div class = "btn-group">';
                $gear.= '<span class = "btn btn-xs icon icon-gears dropdown-toggle" data-toggle = "dropdown"></span>';
                $gear.= '<ul class = "dropdown-menu pull-right" role = "menu">';
                $gear.= '<li>' . anchor('modulos/edit/' . $row->id, 'Editar') . '</li>';
                $gear.= '<li class = "divider"></li>';
                $gear.= '<li>' . anchor('modulos/del/' . $row->id, 'Eliminar') . '</li>';
                $gear.= '</ul>';
                $gear.= '</div>';
                $f[] = array(
                    $row->modulo,
                    $row->alias,
                    $gear
                );
            }
        }
        return Array('aaData' => $f);
    }

    function obtener_modulo_por_id($id) {
        $qry = "select * from modulos where id=$id and status='activo'";
        $rst = $this->db->query($qry);
        if ($rst->num_rows() == 1) {
            return $rst->row_array();
        }
        return NULL;
    }

    function lista_modulos() {
        $qry = "select * from modulos where status='activo' order by modulo";
        $rst = $this->db->query($qry);
        if ($rst->num_rows() > 0) {
            return $rst->result();
        }
        return NULL;
    }

}

?>