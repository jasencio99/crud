<?php

function get_alumnos()
{

    $CI =& get_instance();
    return $CI->db->get('alumnos_api')->result();
}

function post_alumnos($data)
{
    $CI =& get_instance();
    $CI->db->insert('alumnos_api', $data);
}