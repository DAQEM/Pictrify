<?php

namespace Pictrify;

abstract class BaseService
{
    public function createdResponse(bool $success, array $array, string $reason = "Unknown"): array
    {
        if ($success)
            return array('message' => 'Created successfully', 'data' => $array);
        else
            return array(
                'error' => 'Creation Failed',
                'reason' => $reason,
                'data' => $array
            );
    }

    public function updatedResponse(bool $success, array $array, string $reason = "Unknown"): array
    {
        if ($success)
            return array('message' => 'Updated successfully', 'data' => $array);
        else
            return array(
                'error' => 'Update Failed',
                'reason' => $reason,
                'data' => $array
            );
    }

    public function deletedResponse(bool $success, array $array, string $reason = "Unknown"): array
    {
        if ($success)
            return array('message' => 'Deleted successfully', 'data' => $array);
        else
            return array(
                'error' => 'Deletion Failed',
                'reason' => $reason,
                'data' => $array
            );
    }
}