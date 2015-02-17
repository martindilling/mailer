<?php
require __DIR__ . '/../vendor/autoload.php';

$app = new \Slim\Slim();
$app->config('debug', true);


$app->post('/send', function () use ($app) {
    $json = $app->request->getBody();
    $data = json_decode($json, true);

    $validationErrors = getValidationErrors($data);

    if (!empty($validationErrors)) {
        $statusCode = 422;
        $body = [
            'status' => 'Validation failed',
            'errors' => $validationErrors
        ];
    } else {
        $statusCode = 200;
        $body = [
            'status' => 'The mail was send'
        ];
    }

    $app->response->headers->set('Content-Type', 'application/json');
    $app->response->setStatus($statusCode);
    $app->response->setBody(json_encode($body));
});



function getValidationErrors($data)
{
    $validationErrors = [];

    if (empty($data['name'])) {
        $validationErrors['name'][] = 'Name is required.';
    }

    if (!isStringLengthBetween(3, 30, $data['name'])) {
        $validationErrors['name'][] = 'Name must be between 3 and 30 characters.';
    }

    if (empty($data['email'])) {
        $validationErrors['email'][] = 'Email is required.';
    }

    if (!isEmailValid($data['email'])) {
        $validationErrors['email'][] = 'Email must be valid.';
    }

    if (empty($data['message'])) {
        $validationErrors['message'][] = 'Name is required.';
    }

    if (!isStringLengthBetween(50, 2000, $data['message'])) {
        $validationErrors['message'][] = 'Message must be between 50 and 2000 characters.';

        return $validationErrors;
    }

    return $validationErrors;
}

function isEmailValid($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    return true;
}

function isStringLengthBetween($min, $max, $string)
{
    $length = mb_strlen($string);

    if (!is_null($min) && $min > $length) {
        return false;
    }

    if (!is_null($max) && $max < $length) {
        return false;
    }

    return true;
}














$app->run();
