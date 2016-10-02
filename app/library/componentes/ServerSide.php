<?php

/**
 * Created by PhpStorm.
 * User: dmunioz
 * Date: 07/09/2016
 * Time: 11:55
 */
class ServerSide
{
    /**
     * @param $request datos enviado por POST
     * @param $modelsManager para crear un Builder
     * @param $select String de las columnas a seleccionar
     * @param $from array
     * @param $where
     * @param $order_default
     * @param $columnas_dt
     * @return array
     */
    public static function simpleQuery($request, $modelsManager,$select, $from, $where, $order_default, $columnas_dt)
    {
        $limite = ServerSide::limite($request);
        $order = ServerSide::orden($request->getPost(),$columnas_dt,$order_default);
        if(trim($order)=="")
            $order = $order_default;
        else
            $order = $order." , ".$order_default;
        $bindings = array();
       $where_plus = ServerSide::filtro( $request, $columnas_dt, $bindings );
       if((isset($where) && trim($where)!='')) {

           if ((isset($where_plus) && trim($where_plus) != ''))
               $where = $where . " AND " . $where_plus;
       }
       else
            $where = $where_plus;
        //Para ver la query
        $q = $modelsManager->createBuilder()
            ->columns($select)
            ->from($from)
            ->where($where)//FIXME: falla si el usuario no especifica where
            ->limit($limite[0],$limite[1])//2 parametros: Cantidad y registro inicial
            ->orderBy($order)//FIXME: falla si el usuario no especifica el orden
            ->getPhql();
        $retorno = $modelsManager->createBuilder()
            ->columns($select)
            ->from($from)
            ->where($where)//FIXME: falla si el usuario no especifica where
            ->limit($limite[0],$limite[1])//2 parametros: Cantidad y registro inicial
            ->orderBy($order)//FIXME: falla si el usuario no especifica el orden
            ->getQuery()
            ->execute();
        $total = count($modelsManager->createBuilder()
            ->columns($select)
            ->from($from)
            ->where($where)
            ->getQuery()
            ->execute());
        /*
		 * Salida
		 */
        return array(
            "draw" => intval($request->getPost('draw')),
            "recordsTotal" => $total,
            "q" =>$q,
            "recordsFiltered" => $total,
            "data" => $retorno->toArray()
        );
    }
    public static function limite($request)
    {
        $limit = array(10,0);//Default
        $start = $request->getPost('start');
        $length = $request->getPost('length');
        if (isset($start) && $length != -1) {
            $limit =array(intval($length), intval($start));
        }
        return $limit;
    }

    static function orden( $request, $columns,$order_default )
    {

        $order = '';
        if ( isset($request['order']) && count($request['order']) ) {
            $orderBy = array();
            $dtColumns = ServerSide::pluck( $columns, 'dt' );
            for ( $i=0, $ien=count($request['order']) ; $i<$ien ; $i++ ) {
                // Convert the column index into the column data property
                $columnIdx = intval($request['order'][$i]['column']);
                $requestColumn = $request['columns'][$columnIdx];
                $columnIdx = array_search( $requestColumn['data'], $dtColumns );
                $column = $columns[ $columnIdx ];
                if ( $requestColumn['orderable'] == 'true' ) {
                    $dir = $request['order'][$i]['dir'] === 'asc' ?
                        'ASC' :
                        'DESC';
                    $orderBy[] = ' '.$column['db'].' '.$dir;
                }
            }
            $order = ' '.implode(', ', $orderBy);
        }
        return $order;
    }


    public static function filtro($request, $columns, $bindings, $w = "")
    {
        $globalSearch = array();
        $columnSearch = array();
        //$columns = ServerSide::convertirColumnas($columns);

        $dtColumns = ServerSide::pluck( $columns, 'data' );
        $s = $request->getPost('search');
        if ( isset($s) && $s['value'] != '' ) {
            $str = $s['value'];
            for ( $i=0, $ien=count($request->getPost('columns')) ; $i<$ien ; $i++ ) {

                $requestColumn = $request->getPost('columns')[$i];
                //echo json_encode(array("requestColumn"=>$requestColumn['data'],'dtColumns'=>$dtColumns));
                $columnIdx = array_search( $requestColumn['data'], $dtColumns );
                $column = $columns[ $columnIdx ];
                if ( $requestColumn['searchable'] == 'true' ) {
                    //$binding = ServerSide::bind( $bindings, '%'.$str.'%', PDO::PARAM_STR );
                    $globalSearch[] = " ".$column['db']."  LIKE ". '\'%'.strtoupper($str).'%\'';
                }

            }

        }


        // Individual column filtering
        for ( $i=0, $ien=count($request->getPost('columns')) ; $i<$ien ; $i++ ) {
            $requestColumn = $request->getPost('columns')[$i];

            $columnIdx = array_search( $requestColumn['data'], $dtColumns );
            $column = $columns[ $columnIdx ];
            $str = $requestColumn['search']['value'];
            if ( $requestColumn['searchable'] == 'true' &&
                $str != '' ) {
                $binding = ServerSide::bind( $bindings, '%'.$str.'%', PDO::PARAM_STR );
                $columnSearch[] = " ".$column['db']."  LIKE ". '\'%'.$str.'%\'';

            }
        }
        // Combine the filters into a single string
        $where = '';
        if ( count( $globalSearch ) ) {
            $where = '('.implode(' OR ', $globalSearch).')';
        }
        if ( count( $columnSearch ) ) {
            $where = $where === '' ?
                implode(' AND ', $columnSearch) :
                $where .' AND '. implode(' AND ', $columnSearch);
        }
        return $where;
    }



    /*==============================================================================**/
    /*                              MET CON QUERY                                */
    /*==============================================================================**/
    public static function simplePhql($request, $modelsManager,$select, $from, $where, $order_default, $columnas_dt)
    {
        $bindings   = array();
        $where_plus = ServerSide::filtroSql( $request, $columnas_dt, $bindings,$where );

        if((!isset($where) || trim($where)==''))
            $where = $where_plus;
        else
        {
            if((isset($where_plus) && trim($where_plus)!=''))
            {
                $where = $where ." AND ".$where_plus;
            }
        }
        $limite     =   "";
        //$limite     =   ServerSide::limiteSql($request);
        $order      =   "";
        //  $order      = ServerSide::ordenSql($request,$columnas_dt,$order_default);

        $query = $modelsManager->createQuery("$select FROM $where $limite $order");
        $instancia = $query->execute();

        $query = $modelsManager->createQuery("SELECT COUNT(DISTINCT id_documento) from  table_name");
        $totals = $query->execute();
        /*
		 * Output
		 */
        return array(
            "draw" => intval($request->getPost('draw')),
            "recordsTotal" => $totals,
            "recordsFiltered" => $totals,
            "data" => $instancia->toArray()
        );
    }
    public static function filtroSql($request, $columns, $bindings)
    {
        $globalSearch = array();
        $columnSearch = array();
        $columns = ServerSide::convertirColumnas($columns);
        $dtColumns = ServerSide::pluck( $columns, 'dt' );
        $s = $request->getPost('search');
        if ( isset($s) && $s['value'] != '' ) {
            $str = $s['value'];
            for ( $i=0, $ien=count($request->getPost('columns')) ; $i<$ien ; $i++ ) {
                $requestColumn = $request->getPost('columns')[$i];
                $columnIdx = array_search( $requestColumn['data'], $dtColumns );
                $column = $columns[ $columnIdx ];
                if ( $requestColumn['searchable'] == 'true' ) {
                    $binding = ServerSide::bind( $bindings, '%'.$str.'%', PDO::PARAM_STR );
                    $globalSearch[] = "`".$column['db']."` LIKE ".$binding;
                }
            }
        }
        // Individual column filtering
        for ( $i=0, $ien=count($request->getPost('columns')) ; $i<$ien ; $i++ ) {
            $requestColumn = $request->getPost('columns')[$i];
            $columnIdx = array_search( $requestColumn['data'], $dtColumns );
            $column = $columns[ $columnIdx ];
            $str = $requestColumn['search']['value'];
            if ( $requestColumn['searchable'] == 'true' &&
                $str != '' ) {
                $binding = ServerSide::bind( $bindings, '%'.$str.'%', PDO::PARAM_STR );
                $columnSearch[] = "`".$column['db']."` LIKE ".$binding;
            }
        }
        // Combine the filters into a single string
        $where = '';
        if ( count( $globalSearch ) ) {
            $where = '('.implode(' OR ', $globalSearch).')';
        }
        if ( count( $columnSearch ) ) {
            $where = $where === '' ?
                implode(' AND ', $columnSearch) :
                $where .' AND '. implode(' AND ', $columnSearch);
        }


        if ( $where !== '' ) {
            $where = 'WHERE '.$where;
        }

        return $where;
    }

    public static function limiteSql($request)
    {
        $limit = '';
        $start = $request->getPost('start');
        $length = $request->getPost('length');
        if ( isset($start) && $length != -1 ) {
            $limit = "LIMIT ".intval($start).", ".intval($length);
        }
        return $limit;
    }

    public static function ordenSql($request, $columns,$order_default="")
    {
        $orden = $request->getPost('order');
        $order = $order_default;
        if (isset($orden) && count($orden)) {
            $columns = ServerSide::convertirColumnas($columns);
            $orderBy = array();
            $dtColumns = ServerSide::pluck($columns, 'dt');
            for ($i = 0, $ien = count($orden); $i < $ien; $i++) {
                // Convert the column index into the column data property
                $columnIdx = intval($orden[$i]['column']);
                $requestColumn = $request->getPost('columns')[$columnIdx];
                $columnIdx = array_search($requestColumn['data'], $dtColumns);
                $column = $columns[$columnIdx];
                if ($requestColumn['orderable'] == 'true') {
                    $dir = $orden[$i]['dir'] === 'asc' ?
                        'ASC' :
                        'DESC';
                    $orderBy[] = '' . $column['db'] . ' ' . $dir;
                }
            }
            //$order = 'ORDER BY '.implode(', ', $orderBy);
            if((count($order)==0) &&(!isset($order_default) || trim($order_default)=='') )
            {
                $order = "";
            }
            else
            {
                $orderBy[] = $order_default;
                $order = 'ORDER BY '.implode(', ', $orderBy);
            }

        }
        return $order;
    }


    /*==============================================================================**/
    /*                              METODOS INTERNOS                                */
    /*==============================================================================**/
    /**
     * Pull a particular property from each assoc. array in a numeric array,
     * returning and array of the property values from each item.
     *
     * @param  array $a Array to get data from
     * @param  string $prop Property to read
     * @return array        Array of property values
     */
    static function pluck($a, $prop)
    {
        $out = array();
        for ( $i=0, $len=count($a) ; $i<$len ; $i++ ) {
            $out[] = $a[$i][$prop];
        }
        return $out;
    }

    static function convertirColumnas($columnas)
    {
        $retorno = array();
        foreach ($columnas as $col) {
            $item = array();
            $i=0;
            $item['db'] = $col;
            $item['dt'] = $i;
            $retorno[]=$item;
        }
        return $retorno;
    }

    static function bind ( &$a, $val, $type )
    {
        $key = ':binding_'.count( $a ).':';
        $a[] = array(
            'key' => $key,
            'val' => $val,
            'type' => $type
        );
        return $key;
    }


}