<?php

define ('HMAC_SHA256', 'sha256');
define ('SECRET_KEY', '05cdadc8d9324af9aca8d9e852e011eebded8dd50bf74752950f8c9f9cca2c25e395c60658264708b8bdef8282351b02f9bc2015d75c4903a6a16f616fb190eab0d1bd2617f84a62856e057852dc130b6db2ac7b15e04403aeaa9e924a1cf6e05dbf8c019e914fec8135a8362f6afda9350eb98b41294a0bb244ffdfdc7bf992');

function sign ($params) {
  return signData(buildDataToSign($params), SECRET_KEY);
}

function signData($data, $secretKey) {
    return base64_encode(hash_hmac('sha256', $data, $secretKey, true));
}

function buildDataToSign($params) {
        $signedFieldNames = explode(",",$params["signed_field_names"]);
        foreach ($signedFieldNames as $field) {
           $dataToSign[] = $field . "=" . $params[$field];
        }
        return commaSeparate($dataToSign);
}

function commaSeparate ($dataToSign) {
    return implode(",",$dataToSign);
}

?>
