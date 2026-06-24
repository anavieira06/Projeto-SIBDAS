CREATE TABLE `equipamentos` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `codigo_inventario` varchar(20) UNIQUE NOT NULL,
  `designacao_equipamento` varchar(100) NOT NULL,
  `marca` varchar(100) NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `numero_serie` varchar(100) UNIQUE NOT NULL,
  `fabricante` varchar(100) NOT NULL,
  `data_aquisicao` date NOT NULL,
  `ano_fabrico` int NOT NULL,
  `custo_aquisicao` decimal(10,2) NOT NULL,
  `observacoes` text DEFAULT NULL,
  `ativo` TINYINT(1) NOT NULL DEFAULT 1,
  `categoria_grupo_id` int NOT NULL,
  `estado_id` int NOT NULL,
  `criticidade_id` int NOT NULL,
  `tipo_entrada_id` int NOT NULL,
  `localizacao_id` int NOT NULL,
  `garantia_contrato_id` int UNIQUE
);

CREATE TABLE `categoria_grupo` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `categoria_grupo` varchar(50) NOT NULL
);

CREATE TABLE `estado` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `estado` varchar(50) NOT NULL
);

CREATE TABLE `criticidade` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `criticidade` varchar(50) NOT NULL
);

CREATE TABLE `tipo_entrada` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `tipo_entrada` varchar(50) NOT NULL
);

CREATE TABLE `fornecedores` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nome_empresa` varchar(100) NOT NULL,
  `nif` varchar(9) UNIQUE NOT NULL,
  `morada` varchar(255) NOT NULL,
  `numero_telefonico` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `pessoa_contacto` varchar(100) NOT NULL,
  `tel_pessoa_contacto` varchar(20) NOT NULL,
  `ativo` TINYINT(1) NOT NULL DEFAULT 1,
  `tipo_fornecedor_id` int NOT NULL
);

CREATE TABLE `tipo_fornecedor` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `tipo_fornecedor` varchar(100) NOT NULL
);

CREATE TABLE `equipamento_fornecedor` (
  `equipamento_id` int NOT NULL,
  `fornecedor_id` int NOT NULL,
  PRIMARY KEY (`equipamento_id`, `fornecedor_id`)
);

CREATE TABLE `localizacoes` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `edificio` varchar(100) NOT NULL,
  `piso` varchar(20) NOT NULL,
  `servico_depart` varchar(100) NOT NULL,
  `sala_gabinete` varchar(50) NOT NULL,
  `ativo` TINYINT(1) NOT NULL DEFAULT 1
);

CREATE TABLE `documentos` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `equipamento_id` int NOT NULL,
  `fornecedor_id` int DEFAULT NULL,
  `tipo_doc_id` int NOT NULL,
  `nome_doc` varchar(255) NOT NULL,
  `data_doc` date NOT NULL,
  `data_validade` date DEFAULT NULL,
  `ficheiro` varchar(255) DEFAULT NULL
);

CREATE TABLE `tipo_doc` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `tipo_doc` varchar(100) NOT NULL
);

CREATE TABLE `garantias_contratos` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `data_inicio` date NOT NULL,
  `data_fim` date NOT NULL,
  `contrato_manutencao` boolean NOT NULL,
  `tipo_contrato_id` int DEFAULT NULL,
  `periodicidade_id` int DEFAULT NULL,
  `entidade_responsavel` varchar(100) NOT NULL,
  `observacoes_garant` text DEFAULT NULL
);

CREATE TABLE `tipo_contrato` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `tipo_contrato` varchar(100) NOT NULL
);

CREATE TABLE `periodicidade` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `periodicidade` varchar(50) NOT NULL
);

CREATE TABLE `gestao_sobre_nos` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `menu_sobre_nos` varchar(100),
  `titulo` varchar(255),
  `conteudo` text,
  `texto_botao` varchar(100),
  `data_criacao` datetime,
  `data_ultima_alteracao` datetime
);

CREATE TABLE `gestao_problema_solucao` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `menu_problema_solucao` varchar(100),
  `titulo1` varchar(255),
  `paragrafo1` text,
  `paragrafo2` text,
  `paragrafo3` text,
  `titulo2` varchar(255),
  `paragrafo1_vant` text,
  `paragrafo2_vant` text,
  `paragrafo3_vant` text,
  `data_criacao` datetime,
  `data_ultima_alteracao` datetime
);

CREATE TABLE `gestao_vantagens` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `menu_vantagens` varchar(100),
  `titulo` varchar(255),
  `data_criacao` datetime,
  `data_ultima_alteracao` datetime
);

CREATE TABLE `vantagens` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `gestao_vantagens_id` int NOT NULL,
  `vantagem` text
);

CREATE TABLE `gestao_funcionalidades` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `menu_funcionalidades` varchar(100),
  `titulo` varchar(255),
  `texto_introdutorio` text,
  `data_criacao` datetime,
  `data_ultima_alteracao` datetime
);

CREATE TABLE `funcionalidades` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `gestao_funcionalidades_id` int NOT NULL,
  `icone` varchar(100),
  `titulo_funcionalidade` varchar(255),
  `descricao` text
);

CREATE TABLE `gestao_contacto` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `menu_contacto` varchar(100),
  `titulo` varchar(255),
  `texto_introdutorio` text,
  `etiqueta1` varchar(100),
  `etiqueta2` varchar(100),
  `etiqueta3` varchar(100),
  `texto_botao` varchar(100),
  `data_criacao` datetime,
  `data_ultima_alteracao` datetime
);

CREATE TABLE `gestao_rodape` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `localizacao` varchar(100),
  `morada` text,
  `horario` varchar(100),
  `horas` text,
  `contactos` text,
  `email` varchar(255),
  `telefone` varchar(20),
  `data_criacao` datetime,
  `data_ultima_alteracao` datetime
);

CREATE TABLE `perfil` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `perfil` varchar(50) NOT NULL
);

CREATE TABLE `utilizador` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(50) UNIQUE NOT NULL,
  `password` varchar(255) NOT NULL,
  `perfil_id` int NOT NULL,
  `ativo` TINYINT(1) NOT NULL DEFAULT 1,
  `last_login` datetime,
  `created_at` datetime 
);

CREATE TABLE `mensagens_contacto` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mensagem` text NOT NULL,
  `data_envio` datetime,
  `lida` TINYINT(1) NOT NULL DEFAULT 0
);

CREATE TABLE `historico_movimentacoes` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `equipamento_id` int NOT NULL,
  `utilizador_id` int NOT NULL,
  `tipo_alteracao` varchar(100) NOT NULL,
  `valor_anterior` varchar(255),
  `valor_novo` varchar(255),
  `data_alteracao` datetime 
);

ALTER TABLE `historico_movimentacoes` ADD FOREIGN KEY (`equipamento_id`) REFERENCES `equipamentos` (`id`);
ALTER TABLE `historico_movimentacoes` ADD FOREIGN KEY (`utilizador_id`) REFERENCES `utilizador` (`id`);

ALTER TABLE `equipamentos` ADD FOREIGN KEY (`localizacao_id`) REFERENCES `localizacoes` (`id`);

ALTER TABLE `equipamentos` ADD FOREIGN KEY (`garantia_contrato_id`) REFERENCES `garantias_contratos` (`id`);

ALTER TABLE `equipamentos` ADD FOREIGN KEY (`categoria_grupo_id`) REFERENCES `categoria_grupo` (`id`);

ALTER TABLE `equipamentos` ADD FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`);

ALTER TABLE `equipamentos` ADD FOREIGN KEY (`criticidade_id`) REFERENCES `criticidade` (`id`);

ALTER TABLE `equipamentos` ADD FOREIGN KEY (`tipo_entrada_id`) REFERENCES `tipo_entrada` (`id`);

ALTER TABLE `fornecedores` ADD FOREIGN KEY (`tipo_fornecedor_id`) REFERENCES `tipo_fornecedor` (`id`);

ALTER TABLE `documentos` ADD FOREIGN KEY (`equipamento_id`) REFERENCES `equipamentos` (`id`);

ALTER TABLE `documentos` ADD FOREIGN KEY (`fornecedor_id`) REFERENCES `fornecedores` (`id`);

ALTER TABLE `documentos` ADD FOREIGN KEY (`tipo_doc_id`) REFERENCES `tipo_doc` (`id`);

ALTER TABLE `equipamento_fornecedor` ADD FOREIGN KEY (`equipamento_id`) REFERENCES `equipamentos` (`id`);

ALTER TABLE `equipamento_fornecedor` ADD FOREIGN KEY (`fornecedor_id`) REFERENCES `fornecedores` (`id`);

ALTER TABLE `garantias_contratos` ADD FOREIGN KEY (`tipo_contrato_id`) REFERENCES `tipo_contrato` (`id`);

ALTER TABLE `garantias_contratos` ADD FOREIGN KEY (`periodicidade_id`) REFERENCES `periodicidade` (`id`);

ALTER TABLE `vantagens` ADD FOREIGN KEY (`gestao_vantagens_id`) REFERENCES `gestao_vantagens` (`id`);

ALTER TABLE `funcionalidades` ADD FOREIGN KEY (`gestao_funcionalidades_id`) REFERENCES `gestao_funcionalidades` (`id`);

ALTER TABLE `utilizador` ADD FOREIGN KEY (`perfil_id`) REFERENCES `perfil` (`id`);

