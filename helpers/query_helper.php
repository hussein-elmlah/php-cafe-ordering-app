<?php

function handle_query_params($query, $params, $search_fields) {
    $max_limit = 50;

    // var_dump($params);

    $page = isset($params['page']) ? intval($params['page']) : 1;
    $limit = isset($params['limit']) ? intval($params['limit']) : 10;
    $order_by = isset($params['order']) ? $params['order'] : null;
    $search = isset($params['search']) ? $params['search'] : null;

    $filters = array_diff_key($params, array_flip(['page', 'limit', 'order', 'search']));

    if ($page < 1 || $limit < 1 || $limit > $max_limit) {
        // Handle invalid pagination parameters
        throw new Exception('Invalid pagination parameters');
    }

    $filter_conditions = [];

    if ($search && $search_fields) {
        foreach ($search_fields as $field) {
            $filter_conditions[] = "$field LIKE '%" . $search . "%'";
        }
    }

    if ($search && !$search_fields) {
        // Handle invalid search parameters
        throw new Exception('Invalid search parameters');
    }

    foreach ($filters as $key => $value) {
        $filter_conditions[] = "$key = '$value'";
    }

    if (!empty($filter_conditions)) {
        $query .= " WHERE " . implode(' AND ', $filter_conditions);
    }

    if ($order_by) {
        $query .= " ORDER BY $order_by";
    }

    // Add limit and offset for pagination
    $offset = ($page - 1) * $limit;
    $query .= " LIMIT $limit OFFSET $offset";

    return $query;
}

?>
