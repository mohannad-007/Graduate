<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait RespondsWithHttpStatus
{
    protected function validationErrorResponse($errors): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => 'Validation Request Fields errors',
            'errors' => $errors
        ], 400);
    }

    protected function successResponse($data, $message = 'Success'): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], 200);
    }

    protected function unauthorizedResponse($message = 'Unauthorized'): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message
        ], 401);
    }

    protected function internalErrorResponse($message = 'Internal Server Error'): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message
        ], 500);
    }

    protected function forbiddenResponse($message = 'Forbidden'): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message
        ], 403);
    }

    protected function notFoundResponse($message = 'Not Found'): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message
        ], 404);
    }

    protected function resourceCreatedResponse($data=[],$message = 'Resource Created'): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data'=>$data
        ], 201);
    }

    protected function resourceUpdatedResponse($data=[],$message = 'Resource Updated'): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data'=>$data,
        ], 200);
    }

    protected function resourceDeletedResponse($message = 'Resource Deleted'): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message
        ], 200);
    }

    protected function resourceFoundResponse($data=[],$message = 'Resource Found'): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
        ], 200);
    }
}
