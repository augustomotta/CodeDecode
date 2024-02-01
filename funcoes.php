<?php

$msg = "Mensagem leígvel" . "<br/>";


echo "Mensagem a ser criptografada: " . $msg . "<br /><br />";

$crp = e($msg);
$drp = d($crp);

echo "Criptografado: " . $crp . "<br/>";
echo "Descriptografado: " . $drp;

function e($e)
{
    // Gera um vetor de inicialização (IV) aleatório
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-256-CBC'));

    // Criptografa a string usando AES-256-CBC com uma palavra chave e IV aleatório
    $encrypted_string = openssl_encrypt($e, 'AES-256-CBC', 'palavrasecreta', 0, $iv);

    // Combina o IV com a string criptografada e codifica para base64
    $result = base64_encode($iv . $encrypted_string);

    // Retorna o resultado
    return $result;
}

function d($d)
{
    // Decodifica a string em base64 para obter a representação binária original
    $data = base64_decode($d);

    // Extrai o IV do início da string
    $ivSize = openssl_cipher_iv_length('AES-256-CBC');
    $iv = substr($data, 0, $ivSize);

    // Extrai a parte criptografada
    $encrypted_string = substr($data, $ivSize);

    // Descriptografa usando AES-256-CBC com uma palavra secreta e o IV extraído
    $decrypted_string = openssl_decrypt($encrypted_string, 'AES-256-CBC', 'palavrasecreta', 0, $iv);

    // Retorna a string descriptografada
    return $decrypted_string;
}
