<?php
if (!function_exists('responseGenerate')) {
    function responseGenerate($type, $message)
    {
        $result = [
            'type' => $type,
            'message' => $message,
        ];
        echo json_encode($result);
        exit();
    }
}

if (!function_exists('getUniqueEstimateID')) {
    function getUniqueEstimateID()
    {
        #Store Unique Transaction Number
        $unique_no = DB::table('quotes')->orderBy('id', 'DESC')->pluck('id')->first();
        // return $unique_no;
        if ($unique_no == null || $unique_no == "") {
            $unique_no = 1;
        } else {
            $unique_no = $unique_no + 1;
        }
        $unique_no = Str::upper('EST') . "-" . str_pad($unique_no, 6, "0", STR_PAD_LEFT);
        return $unique_no;
    }
}
