<?php

function validar_equipamento(array $dados): array {
    $erros = [];

    // Código
    if (empty($dados['codigo'])) {
        $erros[] = "O código de inventário é obrigatório.";
    } elseif (!preg_match('/^EQ\d+$/', $dados['codigo'])) {
        $erros[] = "O código de inventário deve começar por 'EQ' seguido de números (ex: EQ0001).";
    }

    // Categoria
    if (empty($dados['categoria'])) $erros[] = "A categoria / grupo é obrigatória.";

    // Designação
    if (empty($dados['designacao'])) $erros[] = "A designação do equipamento é obrigatória.";

    // Marca
    if (empty($dados['marca'])) $erros[] = "A marca é obrigatória.";

    // Modelo
    if (empty($dados['modelo'])) $erros[] = "O modelo é obrigatório.";

    // Nº série
    if (empty($dados['numero_serie'])) {
        $erros[] = "O número de série é obrigatório.";
    } elseif (!preg_match('/^[A-Za-z0-9\-]+$/', $dados['numero_serie'])) {
        $erros[] = "O número de série apenas pode conter letras, números e hífens.";
    }

    // Fabricante
    if (empty($dados['fabricante'])) $erros[] = "O fabricante é obrigatório.";

    // Data de aquisição
    if (empty($dados['data_aquisicao'])) {
        $erros[] = "A data de aquisição é obrigatória.";
    } else {
        $p = explode('-', $dados['data_aquisicao']);
        if (!checkdate((int)$p[1], (int)$p[2], (int)$p[0])) {
            $erros[] = "A data de aquisição é inválida.";
        } elseif ($dados['data_aquisicao'] > date('Y-m-d')) {
            $erros[] = "A data de aquisição não pode ser superior à data atual.";
        }
    }

    // Ano de fabrico
    if (empty($dados['ano_fabrico'])) {
        $erros[] = "O ano de fabrico é obrigatório.";
    } elseif (!is_numeric($dados['ano_fabrico']) || $dados['ano_fabrico'] < 1980 || $dados['ano_fabrico'] > 2026) {
        $erros[] = "O ano de fabrico deve ser um valor entre 1980 e 2026.";
    }

    // Custo
    if (empty($dados['custo_aquisicao'])) {
        $erros[] = "O custo de aquisição é obrigatório.";
    } elseif (!is_numeric($dados['custo_aquisicao']) || $dados['custo_aquisicao'] < 0) {
        $erros[] = "O custo de aquisição deve ser um valor numérico positivo.";
    }

    // Tipo entrada
    if (empty($dados['tipo_entrada'])) $erros[] = "O tipo de entrada é obrigatório.";

    // Estado
    if (empty($dados['estado'])) $erros[] = "O estado atual é obrigatório.";

    // Criticidade
    if (empty($dados['criticidade'])) $erros[] = "A criticidade é obrigatória.";

    // Fornecedor
    if (empty($dados['fornecedor'])) $erros[] = "É necessário associar pelo menos um fornecedor.";

    // Localização
    if (empty($dados['localizacao'])) $erros[] = "A localização é obrigatória.";

    return $erros;
}

function validar_fornecedor(array $dados): array {
    $erros = [];

    $nome_empresa        = $dados['nome_empresa']        ?? '';
    $nif                 = $dados['nif']                 ?? '';
    $morada              = $dados['morada']              ?? '';
    $tipo_fornecedor     = $dados['tipo_fornecedor']     ?? '';
    $numero_telefonico   = $dados['numero_telefonico']   ?? '';
    $email               = $dados['email']               ?? '';
    $website             = $dados['website']             ?? '';
    $pessoa_contacto     = $dados['pessoa_contacto']     ?? '';
    $tel_pessoa_contacto = $dados['tel_pessoa_contacto'] ?? '';
    
    if (empty($nome_empresa)) {
        $erros[] = "O nome da empresa é obrigatório.";
    }
 
    if (empty($nif)) {
        $erros[] = "O NIF é obrigatório.";
    } elseif (!preg_match('/^\d{9}$/', $nif)) {
        $erros[] = "O NIF deve ter exatamente 9 dígitos.";
    }
 
    if (empty($morada)) {
        $erros[] = "A morada é obrigatória.";
    }
 
    if (empty($tipo_fornecedor)) {
        $erros[] = "O tipo de fornecedor é obrigatório.";
    }
 
    if (empty($numero_telefonico)) {
        $erros[] = "O número telefónico é obrigatório.";
    }
 
    if (empty($email)) {
        $erros[] = "O email é obrigatório.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros[] = "O email introduzido não é válido (ex: nome@empresa.pt).";
    } elseif (!preg_match('/^[^@]+@[^@]+\.[a-zA-Z]{2,}$/', $email)) {
        $erros[] = "O email deve ter o formato texto@dominio.extensão.";
    }
 
    if (empty($website)) {
        $erros[] = "O website é obrigatório.";
    } elseif (!preg_match('/^(https?:\/\/|www\.)[^\s]{2,}$/i', $website)) {
        $erros[] = "O website deve começar por 'www.' ou 'https://' (ex: www.empresa.pt ou https://empresa.pt).";
    }
 
    if (empty($pessoa_contacto)) {
        $erros[] = "A pessoa de contacto é obrigatória.";
    }
 
    if (empty($tel_pessoa_contacto)) {
        $erros[] = "O telefone da pessoa de contacto é obrigatório.";
    }

    return $erros;
}