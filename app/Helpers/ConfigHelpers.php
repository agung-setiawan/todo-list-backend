<?php

namespace App\Helpers;

use Response;

class ConfigHelpers {

    public static function ack($params, $status = 200)
    {
        if (isset($params['data'])) {
            return response()->json([
                'success'   => $params['success'],
                'message'   => $params['message'],
                'data'      => $params['data'],
                'date'      => date('Y-m-d H:i:s')
            ], $status);
        } else {
            return response()->json([
                'success'   => $params['success'],
                'message'   => $params['message'],
                'date'      => date('Y-m-d H:i:s')
            ], $status);
        }
    }

    public static function render_message($message)
	{
		$errMsg = "<ul>";
		foreach (json_decode($message, true) as $key => $val)
		{
			$errMsg .= "<li>{$key} : {$val[0]}</li>";
		}
		$errMsg .= "</ul>";
		return $errMsg;
	}
}
