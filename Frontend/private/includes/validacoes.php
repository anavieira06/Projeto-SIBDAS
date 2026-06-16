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