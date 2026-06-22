-- --------------------------------------------------------
-- Anfitrião:                   vsgate-s1.dei.isep.ipp.pt
-- Versão do servidor:          8.0.45 - MySQL Community Server - GPL
-- SO do servidor:               Linux
-- HeidiSQL Versão:             12.17.1.1
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- A despejar dados para tabela db1240811.categoria_grupo: ~7 rows (aproximadamente)
INSERT INTO `categoria_grupo` (`id`, `categoria_grupo`) VALUES
	(1, 'Monitorização'),
	(2, 'Suporte de Vida'),
	(3, 'Terapia'),
	(4, 'Diagnóstico'),
	(5, 'Laboratório'),
	(6, 'Esterilização'),
	(7, 'Reabilitação');

-- A despejar dados para tabela db1240811.criticidade: ~4 rows (aproximadamente)
INSERT INTO `criticidade` (`id`, `criticidade`) VALUES
	(1, 'Baixa'),
	(2, 'Média'),
	(3, 'Alta'),
	(4, 'Suporte de Vida');

-- A despejar dados para tabela db1240811.documentos: ~41 rows (aproximadamente)
INSERT INTO `documentos` (`id`, `equipamento_id`, `fornecedor_id`, `tipo_doc_id`, `nome_doc`, `data_doc`, `data_validade`, `ficheiro`) VALUES
	(1, 1, 1, 1, 'Manual de Utilização Philips IntelliVue MX450', '2023-01-15', NULL, 'manual_philips_intellivue_mx450.pdf'),
	(2, 1, NULL, 3, 'Certificado de Calibração Philips IntelliVue MX450', '2024-01-10', '2025-01-10', 'certificado_calibracao_philips_intellivue_mx450.pdf'),
	(3, 2, 2, 1, 'Manual de Utilização Dräger Evita V500', '2023-02-10', NULL, 'manual_drager_evita_v500.pdf'),
	(4, 2, 2, 4, 'Contrato de Manutenção Dräger Evita V500', '2023-02-10', '2025-02-10', 'contrato_manutencao_drager_evita_v500.pdf'),
	(5, 2, NULL, 7, 'Relatório Técnico Dräger Evita V500', '2024-05-12', NULL, 'relatorio_tecnico_drager_evita_v500.pdf'),
	(6, 3, 3, 1, 'Manual de Utilização B. Braun Infusomat Space', '2023-03-12', NULL, 'manual_bbraun_infusomat_space.pdf'),
	(7, 4, 4, 1, 'Manual de Utilização Siemens Acuson Freestyle', '2023-04-05', NULL, 'manual_siemens_acuson_freestyle.pdf'),
	(8, 4, NULL, 6, 'Declaração de Conformidade Siemens Acuson Freestyle', '2023-04-05', NULL, 'declaracao_conformidade_siemens_acuson_freestyle.pdf'),
	(9, 5, 5, 1, 'Manual de Utilização GE Definium 656', '2023-05-20', NULL, 'manual_ge_definium_656.pdf'),
	(10, 5, NULL, 3, 'Certificado de Calibração GE Definium 656', '2024-05-15', '2025-05-15', 'certificado_calibracao_ge_definium_656.pdf'),
	(11, 5, 5, 5, 'Fatura de Aquisição GE Definium 656', '2023-05-20', NULL, 'fatura_ge_definium_656.pdf'),
	(12, 6, 6, 1, 'Manual de Utilização Medtronic Lifepak 20e', '2023-06-08', NULL, 'manual_medtronic_lifepak_20e.pdf'),
	(13, 7, NULL, 1, 'Manual de Utilização Mindray VS900', '2023-07-14', NULL, 'manual_mindray_vs900.pdf'),
	(14, 8, 8, 1, 'Manual de Utilização Fresenius 5008S CorDiax', '2023-08-01', NULL, 'manual_fresenius_5008s_cordiax.pdf'),
	(15, 8, 8, 4, 'Contrato de Manutenção Fresenius 5008S CorDiax', '2023-08-01', '2025-08-01', 'contrato_fresenius_5008s_cordiax.pdf'),
	(16, 9, 9, 1, 'Manual de Utilização Olympus EVIS EXERA III', '2023-09-18', NULL, 'manual_olympus_evis_exera_iii.pdf'),
	(17, 10, 10, 1, 'Manual de Utilização Canon Aquilion Prime', '2023-10-22', NULL, 'manual_canon_aquilion_prime.pdf'),
	(18, 10, NULL, 7, 'Relatório Técnico Canon Aquilion Prime', '2024-08-12', NULL, 'relatorio_tecnico_canon_aquilion_prime.pdf'),
	(19, 11, 11, 1, 'Manual de Utilização Distrimed Stericlav 80', '2023-11-09', NULL, 'manual_distrimed_stericlav_80.pdf'),
	(20, 12, 12, 1, 'Manual de Utilização TecnoSaúde TS-Cirurgic 3000', '2023-12-03', NULL, 'manual_tecnosaude_ts_cirurgic_3000.pdf'),
	(21, 12, NULL, 6, 'Declaração de Conformidade TecnoSaúde TS-Cirurgic 3000', '2023-12-03', NULL, 'declaracao_conformidade_ts_cirurgic_3000.pdf'),
	(22, 13, 1, 1, 'Manual de Utilização Philips PulseOx 2500', '2024-01-11', NULL, 'manual_philips_pulseox_2500.pdf'),
	(23, 14, 2, 1, 'Manual de Utilização Dräger Isolette 8000', '2024-02-07', NULL, 'manual_drager_isolette_8000.pdf'),
	(24, 14, NULL, 3, 'Certificado de Calibração Dräger Isolette 8000', '2024-02-15', '2025-02-15', 'certificado_calibracao_drager_isolette_8000.pdf'),
	(25, 15, 3, 1, 'Manual de Utilização B. Braun Perfusor Space', '2024-03-19', NULL, 'manual_bbraun_perfusor_space.pdf'),
	(26, 16, 4, 1, 'Manual de Utilização Siemens MAGNETOM Sola', '2024-04-02', NULL, 'manual_siemens_magnetom_sola.pdf'),
	(27, 16, 4, 5, 'Fatura de Aquisição Siemens MAGNETOM Sola', '2024-04-02', NULL, 'fatura_siemens_magnetom_sola.pdf'),
	(28, 16, NULL, 7, 'Relatório Técnico Siemens MAGNETOM Sola', '2024-09-20', NULL, 'relatorio_tecnico_siemens_magnetom_sola.pdf'),
	(29, 17, 5, 1, 'Manual de Utilização GE MAC 2000', '2024-05-13', NULL, 'manual_ge_mac_2000.pdf'),
	(30, 18, NULL, 1, 'Manual de Utilização Medtronic NIM Vital', '2024-06-27', NULL, 'manual_medtronic_nim_vital.pdf'),
	(31, 19, 7, 1, 'Manual de Utilização Mindray SV300', '2024-07-08', NULL, 'manual_mindray_sv300.pdf'),
	(32, 19, 7, 3, 'Certificado de Calibração Mindray SV300', '2024-07-20', '2025-07-20', 'certificado_calibracao_mindray_sv300.pdf'),
	(33, 20, 8, 1, 'Manual de Utilização Fresenius AquaUNO', '2024-08-16', NULL, 'manual_fresenius_aquauno.pdf'),
	(34, 21, 9, 1, 'Manual de Utilização Olympus Airway Scope', '2024-09-05', NULL, 'manual_olympus_airway_scope.pdf'),
	(35, 22, 10, 1, 'Manual de Utilização Canon CXDI-Elite', '2024-10-21', NULL, 'manual_canon_cxdi_elite.pdf'),
	(36, 22, NULL, 6, 'Declaração de Conformidade Canon CXDI-Elite', '2024-10-21', NULL, 'declaracao_conformidade_canon_cxdi_elite.pdf'),
	(37, 23, 11, 1, 'Manual de Utilização Distrimed LabSpin 400', '2024-11-14', NULL, 'manual_distrimed_labspin_400.pdf'),
	(38, 24, NULL, 1, 'Manual de Utilização TecnoSaúde ComfortCare 500', '2024-12-06', NULL, 'manual_tecnosaude_comfortcare_500.pdf'),
	(39, 25, 1, 1, 'Manual de Utilização Philips IntelliVue X3', '2025-01-09', NULL, 'manual_philips_intellivue_x3.pdf'),
	(40, 25, NULL, 3, 'Certificado de Calibração Philips IntelliVue X3', '2025-01-15', '2026-01-15', 'certificado_calibracao_philips_intellivue_x3.pdf'),
	(41, 36, 1, 3, 'Certificado calib-table 2.0', '2026-06-11', '2027-06-17', 'doc_6a2f1bb2b0a91.pdf'),
	(42, 37, 5, 3, 'Certificado calib-intelli', '2026-06-14', NULL, 'doc_6a386d62d9480.pdf'),
	(43, 38, 6, 7, 'Relatório técnico-intellivue mx450', '2025-06-09', NULL, 'doc_6a3980d0f15d3.pdf'),
	(44, 39, 6, 2, 'Manual de serviço - desfibrilhador zetec', '2026-06-22', NULL, 'doc_6a398a171bb50.pdf');

-- A despejar dados para tabela db1240811.equipamentos: ~26 rows (aproximadamente)
INSERT INTO `equipamentos` (`id`, `codigo_inventario`, `designacao_equipamento`, `marca`, `modelo`, `numero_serie`, `fabricante`, `data_aquisicao`, `ano_fabrico`, `custo_aquisicao`, `observacoes`, `categoria_grupo_id`, `estado_id`, `criticidade_id`, `tipo_entrada_id`, `localizacao_id`, `garantia_contrato_id`, `ativo`) VALUES
	(1, 'EQ0001', 'Monitor Multiparamétrico', 'Philips', 'Intellivue Mx450', 'PH-MX450-002', 'Philips Healthcare Portugal', '2023-01-15', 2021, 8500.00, 'Equipamento em utilização regular na UCI.', 1, 1, 1, 1, 3, 1, 1),
	(2, 'EQ0002', 'Ventilador pulmonar', 'Dräger', 'Evita V500', 'DR-EV500-002', 'Dräger', '2023-02-10', 2022, 18500.00, 'Equipamento crítico para suporte ventilatório.', 2, 2, 4, 1, 3, 2, 1),
	(3, 'EQ0003', 'Bomba Infusora', 'B. Braun', 'Infusomat Space', 'BB-IS-004', 'B. Braun', '2023-03-12', 2021, 3200.00, '', 3, 1, 4, 1, 11, 3, 1),
	(4, 'EQ0004', 'Ecógrafo Portátil', 'Siemens', 'Acuson Freestyle', 'SI-AF-004', 'Siemens Healthineers', '2023-04-05', 2022, 24500.00, 'Usado em exames rápidos junto ao doente.', 4, 1, 3, 1, 10, 4, 1),
	(5, 'EQ0005', 'Aparelho de raio-X digital', 'GE HealthCare', 'Definium 656', 'GE-D656-005', 'GE HealthCare', '2023-05-20', 2021, 78000.00, NULL, 4, 1, 3, 1, 4, 5, 1),
	(6, 'EQ0006', 'Desfibrilhador', 'Medtronic', 'Lifepak 20e', 'MD-LP20-006', 'Medtronic', '2023-06-08', 2022, 6900.00, 'Equipamento disponível na urgência.', 2, 3, 4, 1, 1, 6, 1),
	(7, 'EQ0007', 'Monitor de sinais vitais', 'Mindray', 'VS 900', 'MI-VS900-007', 'Mindray', '2023-07-14', 2022, 2400.00, NULL, 1, 3, 1, 1, 10, 7, 1),
	(8, 'EQ0008', 'Máquina de hemodiálise', 'Fresenius', '5008S CorDiax', 'FR-5008S-008', 'Fresenius Medical Care', '2023-08-01', 2021, 22000.00, 'Equipamento usado em tratamentos regulares.', 3, 6, 3, 1, 11, 8, 0),
	(9, 'EQ0009', 'Endoscópio flexível', 'Olympus', 'EVIS EXERA III', 'OL-EVIS-009', 'Olympus', '2023-09-18', 2022, 31500.00, NULL, 4, 2, 3, 1, 10, 9, 1),
	(10, 'EQ0010', 'Tomógrafo computorizado', 'Canon', 'Aquilion Prime', 'CA-AP-010', 'Canon Medical Systems', '2023-10-22', 2020, 145000.00, 'Equipamento de imagiologia de grande porte.', 4, 4, 3, 1, 4, 10, 1),
	(11, 'EQ0011', 'Autoclave hospitalar', 'Distrimed', 'Stericlav 80', 'DI-ST80-011', 'Distrimed Equipamentos Médicos', '2023-11-09', 2021, 12800.00, NULL, 6, 1, 2, 1, 8, 11, 1),
	(12, 'EQ0012', 'Mesa cirúrgica elétrica', 'TecnoSaúde', 'TS-Cirurgic 3000', 'TS-C3000-012', 'TecnoSaúde Equipamentos Hospitalares', '2023-12-03', 2022, 16400.00, 'Mesa principal do bloco operatório.', 3, 4, 1, 1, 2, 12, 1),
	(13, 'EQ0013', 'Oxímetro de pulso', 'Philips', 'PulseOx 2500', 'PH-PO2500-013', 'Philips Healthcare Portugal', '2024-01-11', 2023, 950.00, NULL, 1, 1, 2, 1, 1, 13, 1),
	(14, 'EQ0014', 'Incubadora neonatal', 'Dräger', 'Isolette 8000', 'DR-ISO8000-014', 'Dräger', '2024-02-07', 2023, 17500.00, 'Equipamento afeto ao serviço de pediatria.', 2, 3, 4, 1, 12, 14, 1),
	(15, 'EQ0015', 'Bomba de seringa', 'B. Braun', 'Perfusor Space', 'BB-PS-015', 'B. Braun', '2024-03-19', 2023, 2800.00, NULL, 3, 1, 2, 1, 3, 15, 1),
	(16, 'EQ0016', 'Ressonância magnética', 'Siemens', 'MAGNETOM Sola', 'SI-MS-016', 'Siemens Healthineers', '2024-04-02', 2021, 230000.00, 'Equipamento de elevada complexidade técnica.', 4, 5, 3, 1, 4, 16, 1),
	(17, 'EQ0017', 'Eletrocardiógrafo', 'GE HealthCare', 'MAC 2000', 'GE-MAC2000-017', 'GE HealthCare', '2024-05-13', 2023, 4100.00, NULL, 4, 6, 2, 1, 5, 17, 0),
	(18, 'EQ0018', 'Neuroestimulador', 'Medtronic', 'NIM Vital', 'MD-NIM-018', 'Medtronic', '2024-06-27', 2022, 13600.00, NULL, 3, 4, 3, 1, 2, 18, 1),
	(19, 'EQ0019', 'Ventilador de transporte', 'Mindray', 'SV300', 'MI-SV300-019', 'Mindray', '2024-07-08', 2023, 9800.00, 'Usado em transporte intra-hospitalar.', 2, 1, 4, 1, 1, 19, 1),
	(20, 'EQ0020', 'Sistema de diálise portátil', 'Fresenius', 'AquaUNO', 'FR-AQUNO-020', 'Fresenius Medical Care', '2024-08-16', 2022, 18750.00, NULL, 3, 5, 3, 1, 11, 20, 1),
	(21, 'EQ0021', 'Videolaringoscópio', 'Olympus', 'Airway Scope', 'OL-AS-021', 'Olympus', '2024-09-05', 2023, 5600.00, 'Equipamento usado em procedimentos de via aérea difícil.', 4, 1, 3, 1, 2, 21, 1),
	(22, 'EQ0022', 'Arco cirúrgico móvel', 'Canon', 'CXDI-Elite', 'CA-CXDI-022', 'Canon Medical Systems', '2024-10-21', 2021, 89000.00, NULL, 4, 1, 3, 1, 2, 22, 1),
	(23, 'EQ0023', 'Centrífuga laboratorial', 'Distrimed', 'LabSpin 400', 'DI-LS400-023', 'Distrimed Equipamentos Médicos', '2024-11-14', 2023, 3700.00, NULL, 5, 5, 1, 1, 7, 23, 1),
	(24, 'EQ0024', 'Cama hospitalar articulada', 'TecnoSaúde', 'ComfortCare 500', 'TS-CC500-024', 'TecnoSaúde Equipamentos Hospitalares', '2024-12-06', 2023, 2900.00, NULL, 3, 1, 1, 1, 11, 24, 1),
	(25, 'EQ0025', 'Monitor cardíaco portátil', 'Philips', 'IntelliVue X3', 'PH-X3-025', 'Philips Healthcare Portugal', '2025-01-09', 2024, 6200.00, 'Equipamento portátil para monitorização contínua.', 1, 1, 3, 1, 5, 25, 1),
	(36, 'EQ0026', 'Mesa Cirúrgica', 'Zoll', 'Table 2.0', 'ZL-7681', 'Philips Healthcare', '2026-06-04', 2024, 50000.00, NULL, 3, 1, 1, 1, 2, 37, 1),
	(37, 'EQ0027', 'Medidor De Tensão Arterial', 'Omron', 'Intelli Medi', 'INT-536-091', 'Philips Healthcare', '2026-06-04', 2019, 300.00, NULL, 1, 1, 3, 1, 5, 38, 1),
	(38, 'EQ0028', 'Monitor De Sinais Vitais', 'Philips', 'Intellivue Mx450', 'PH-MX450-008', 'Philips Healthcare', '2025-06-11', 2022, 203933.00, NULL, 1, 4, 2, 3, 2, 44, 1),
	(39, 'EQ0029', 'Desfibrilhador Automático', 'Zetec', 'Aed Plus', 'ZT-5464', 'Zoll Medical', '2026-06-22', 2025, 32000.00, NULL, 2, 4, 4, 3, 3, 47, 1);

-- A despejar dados para tabela db1240811.equipamento_fornecedor: ~36 rows (aproximadamente)
INSERT INTO `equipamento_fornecedor` (`equipamento_id`, `fornecedor_id`) VALUES
	(1, 1),
	(1, 11),
	(2, 2),
	(2, 12),
	(3, 3),
	(3, 11),
	(4, 4),
	(5, 5),
	(5, 11),
	(6, 6),
	(7, 7),
	(7, 12),
	(8, 8),
	(9, 9),
	(10, 10),
	(10, 12),
	(11, 11),
	(12, 12),
	(13, 1),
	(13, 7),
	(14, 2),
	(15, 3),
	(16, 4),
	(16, 10),
	(17, 5),
	(18, 6),
	(19, 7),
	(20, 8),
	(21, 9),
	(21, 12),
	(22, 10),
	(23, 11),
	(24, 12),
	(25, 1),
	(25, 11),
	(36, 1),
	(37, 7),
	(38, 7),
	(38, 12),
	(39, 6);

-- A despejar dados para tabela db1240811.estado: ~6 rows (aproximadamente)
INSERT INTO `estado` (`id`, `estado`) VALUES
	(1, 'Ativo'),
	(2, 'Inativo'),
	(3, 'Em Manutenção'),
	(4, 'Em Calibração'),
	(5, 'Em Quarentena'),
	(6, 'Abatido');

-- A despejar dados para tabela db1240811.fornecedores: ~13 rows (aproximadamente)
INSERT INTO `fornecedores` (`id`, `nome_empresa`, `nif`, `morada`, `numero_telefonico`, `email`, `website`, `pessoa_contacto`, `tel_pessoa_contacto`, `observacoes`, `tipo_fornecedor_id`, `ativo`) VALUES
	(1, 'Philips Healthcare Portugal', '507384921', 'Avenida da República 90, Lisboa', '213846275', 'geral@philipshealthcare.pt', 'https://www.philips.pt/healthcare', 'Ana Costa', '912458736', NULL, 3, 1),
	(2, 'Dräger', '509671438', 'Rua José Ferreira Dias 728, Porto', '229783614', 'contacto@draeger.pt', 'https://www.draeger.com', 'João Martins', '934672542', 'Fornecedor principal de equipamentos de monitorização e imagiologia.', 1, 1),
	(3, 'B. Braun', '506928174', 'Rua António Morgado 80, Leiria', '214356982', 'suporte@bbraun.pt', 'https://www.bbraun.pt', 'Marta Silva', '968214753', 'Responsável pelo fornecimento de bombas infusoras e consumíveis clínicos.', 2, 1),
	(4, 'Siemens Healthineers', '508137296', 'Lagoas Park, Edifício 10, Porto Salvo', '214239870', 'info@siemens-healthineers.pt', 'https://www.siemens-healthineers.com', 'Carlos Rocha', '917836452', NULL, 3, 1),
	(5, 'GE HealthCare', '505749382', 'Rua Castilho 39, Lisboa', '213927584', 'geral@gehealthcare.pt', 'https://www.gehealthcare.com', 'Rita Almeida', '961728394', NULL, 1, 1),
	(6, 'Medtronic', '510284763', 'Avenida José Malhoa 16, Lisboa', '217462938', 'apoio@medtronic.pt', 'https://www.medtronic.com', 'Pedro Sousa', '935817246', NULL, 1, 1),
	(7, 'Mindray', '508692417', 'Rua do Campo Alegre 1024, Porto', '226374819', 'comercial@mindray.pt', 'https://www.mindray.com', 'Sofia Ribeiro', '913685742', NULL, 2, 1),
	(8, 'Fresenius Medical Care', '504873691', 'Avenida D. João II 35, Lisboa', '218736245', 'contacto@fresenius.pt', 'https://www.freseniusmedicalcare.com', 'Tiago Lopes', '967342815', 'Fornecedor especializado em equipamentos para diálise.', 1, 0),
	(9, 'Olympus', '507916284', 'Rua Alfredo da Silva 14, Amadora', '214928376', 'info@olympus.pt', 'https://www.olympus.pt', 'Cláudia Ferreira', '932681475', NULL, 2, 1),
	(10, 'Canon Medical Systems', '509348617', 'Avenida da Boavista 165, Porto', '226918457', 'geral@canonmedical.pt', 'https://global.medical.canon', 'Luís Gomes', '919472638', NULL, 1, 1),
	(11, 'Distrimed Equipamentos Médicos', '506417829', 'Rua Dr. Mário Sacramento 101, Aveiro', '234682971', 'vendas@distrimed.pt', 'https://www.distrimed.pt', 'Patrícia Santos', '963814257', NULL, 2, 1),
	(12, 'TecnoSaúde Equipamentos Hospitalares', '510736294', 'Avenida Luísa Todi 327, Setúbal', '265918473', 'info@tecnosaude.pt', 'https://www.tecnosaude.pt', 'Miguel Correia', '936275814', 'Empresa contratada para assistência técbica e manutenção especializada.', 4, 1),
	(13, 'Siemens Healthineers', '503812947', 'Avenida da liberdade 110, lisboa', '213456789', 'contacto@siemens-healthineers.pt', 'www.siemens-healthineers.com', 'Ana Costa', '912345678', 'Fornecedor de equipamentos de diagnóstico por imagem.', 1, 1),
	(14, 'Portucalitech', '512345678', 'Rua António Leitão, Albufeira', '210123456', 'info@portucalitech.pt', 'www.portucalitech.pt', 'Carlos Mendes', '916918029', NULL, 4, 1);

-- A despejar dados para tabela db1240811.funcionalidades: ~8 rows (aproximadamente)
INSERT INTO `funcionalidades` (`id`, `gestao_funcionalidades_id`, `icone`, `titulo_funcionalidade`, `descricao`) VALUES
	(1, 1, 'fa-solid fa-laptop', 'Gestão de equipamentos', 'Registo, edição e consulta detalhada de equipamentos médicos, incluindo estado e criticidade.'),
	(2, 1, 'fa-solid fa-location-dot', 'Gestão de localizações', 'Organização por edifício, serviço e sala, permitindo localizar rapidamente cada equipamento.'),
	(3, 1, 'fa-solid fa-building', 'Gestão de fornecedores', 'Associação de fabricantes, distribuidores e empresas de assistência técnica aos equipamentos.'),
	(4, 1, 'fa-solid fa-folder-open', 'Documentação', 'Upload e organização de manuais, certificados, contratos e relatórios técnicos.'),
	(5, 1, 'fa-solid fa-file-signature', 'Garantias e Contratos', 'Controlo de garantias, contratos de manutenção e datas importantes associadas aos equipamentos.'),
	(6, 1, 'fa-solid fa-magnifying-glass', 'Pesquisa inteligente', 'Pesquisa rápida por código, marca, modelo, serviço, estado ou criticidade.'),
	(7, 1, 'fa-solid fa-chart-column', 'Dashboard', 'Indicadores em tempo real sobre equipamentos ativos, manutenção, garantias e estatísticas hospitalares.'),
	(8, 1, 'fa-solid fa-shield-halved', 'Segurança', 'Sistema de autenticação e controlo de acesso para proteção dos dados hospitalares.');

-- A despejar dados para tabela db1240811.garantias_contratos: ~28 rows (aproximadamente)
INSERT INTO `garantias_contratos` (`id`, `data_inicio`, `data_fim`, `contrato_manutencao`, `tipo_contrato_id`, `periodicidade_id`, `entidade_responsavel`, `observacoes_garant`) VALUES
	(1, '2023-01-15', '2026-01-15', 1, 3, 4, 'Philips Healthcare Portugal', 'Contrato completo com manutenção anual.'),
	(2, '2023-02-10', '2025-02-10', 1, 1, 3, 'Dräger', 'Manutenção preventiva semestral.'),
	(3, '2023-03-12', '2026-03-12', 0, NULL, NULL, 'B. Braun', 'Garantia standard do fabricante.'),
	(4, '2023-04-05', '2029-06-22', 1, 3, 2, 'Siemens Healthineers', 'Cobertura integral do equipamento.'),
	(5, '2023-05-20', '2025-05-20', 1, 1, 1, 'GE HealthCare', 'Inspeções mensais programadas.'),
	(6, '2023-06-08', '2026-06-08', 0, NULL, NULL, 'Medtronic', 'Garantia de fábrica.'),
	(7, '2023-07-14', '2026-07-14', 1, 1, 3, 'Mindray', 'Plano preventivo semestral.'),
	(8, '2023-08-01', '2025-08-01', 1, 2, 4, 'Fresenius Medical Care', 'Assistência corretiva quando necessário.'),
	(9, '2023-09-18', '2026-09-18', 1, 3, 4, 'Olympus', 'Contrato de manutenção completo.'),
	(10, '2023-10-22', '2025-10-22', 0, NULL, NULL, 'Canon Medical Systems', 'Garantia base do fabricante.'),
	(11, '2023-11-09', '2026-11-09', 1, 1, 2, 'Distrimed Equipamentos Médicos', 'Manutenção preventiva trimestral.'),
	(12, '2023-12-03', '2027-12-03', 1, 3, 4, 'TecnoSaúde Equipamentos Hospitalares', 'Assistência técnica permanente.'),
	(13, '2024-01-11', '2027-01-11', 1, 1, 3, 'Philips Healthcare Portugal', 'Plano de manutenção preventiva.'),
	(14, '2024-02-07', '2026-02-07', 0, NULL, NULL, 'Dräger', 'Garantia comercial standard.'),
	(15, '2024-03-19', '2027-03-19', 1, 3, 4, 'B. Braun', 'Cobertura integral do equipamento.'),
	(16, '2024-04-02', '2026-04-02', 1, 2, 4, 'Siemens Healthineers', 'Suporte corretivo especializado.'),
	(17, '2024-05-13', '2027-05-13', 1, 1, 2, 'GE HealthCare', 'Plano trimestral de inspeção.'),
	(18, '2024-06-27', '2026-06-27', 0, NULL, NULL, 'Medtronic', 'Garantia do fabricante.'),
	(19, '2024-07-08', '2027-07-08', 1, 3, 4, 'Mindray', 'Contrato de manutenção completa.'),
	(20, '2024-08-16', '2026-08-16', 1, 1, 3, 'Fresenius Medical Care', 'Manutenção preventiva semestral.'),
	(21, '2024-09-05', '2027-09-05', 1, 3, 4, 'Olympus', 'Cobertura integral e suporte técnico.'),
	(22, '2024-10-21', '2026-10-21', 0, NULL, NULL, 'Canon Medical Systems', 'Garantia comercial.'),
	(23, '2024-11-14', '2027-11-14', 1, 1, 1, 'Distrimed Equipamentos Médicos', 'Visitas mensais de manutenção.'),
	(24, '2024-12-06', '2027-12-06', 1, 3, 4, 'TecnoSaúde Equipamentos Hospitalares', 'Manutenção completa com substituição de peças.'),
	(25, '2025-01-09', '2028-01-09', 1, 1, 3, 'Philips Healthcare Portugal', 'Plano preventivo semestral.'),
	(37, '2026-06-10', '2029-06-14', 0, NULL, NULL, 'Philips', NULL),
	(38, '2026-06-14', '2030-06-19', 0, NULL, NULL, 'Philips Healthcare Portugal', NULL),
	(44, '2024-06-03', '2028-06-22', 1, NULL, NULL, 'Philips Healthcare Portugal', NULL),
	(47, '2026-06-22', '2030-06-22', 1, 2, 4, 'B. Braun', NULL);

-- A despejar dados para tabela db1240811.gestao_contacto: ~0 rows (aproximadamente)
INSERT INTO `gestao_contacto` (`id`, `menu_contacto`, `titulo`, `texto_introdutorio`, `etiqueta1`, `etiqueta2`, `etiqueta3`, `texto_botao`, `data_criacao`, `data_ultima_alteracao`) VALUES
	(1, 'Contacto', 'Contacto', 'Entre em contacto conosco para tirar todas as suas dúvidas ou obter mais informações sobre a nossa plataforma.', 'Nome', 'Email', 'Mensagem', 'Enviar Mensagem', '2026-06-21 16:02:06', '2026-06-21 16:02:06');

-- A despejar dados para tabela db1240811.gestao_funcionalidades: ~0 rows (aproximadamente)
INSERT INTO `gestao_funcionalidades` (`id`, `menu_funcionalidades`, `titulo`, `texto_introdutorio`, `data_criacao`, `data_ultima_alteracao`) VALUES
	(1, 'Funcionalidades', 'Funcionalidades', 'Aqui encontram-se as funcionalidades da nossa página.', '2026-06-21 16:02:06', '2026-06-21 16:02:06');

-- A despejar dados para tabela db1240811.gestao_problema_solucao: ~0 rows (aproximadamente)
INSERT INTO `gestao_problema_solucao` (`id`, `menu_problema_solucao`, `titulo1`, `paragrafo1`, `paragrafo2`, `paragrafo3`, `titulo2`, `paragrafo1_vant`, `paragrafo2_vant`, `paragrafo3_vant`, `data_criacao`, `data_ultima_alteracao`) VALUES
	(1, 'Problema e Solução', 'O Problema', 'Em muitas unidades hospitalares, a gestão do inventário de equipamentos médicos é realizada de forma fragmentada, recorrendo a folhas de Excel, documentos isolados, registos em papel e várias bases de dados sem integração.', 'Esta abordagem dificulta a organização da informação, a localização dos equipamentos e o rápido acesso à documentação técnica.', 'Como consequência, surgem problemas como a duplicação de dados, falta de controlo do estado dos equipamentos e dificuldades na gestão de garantias, contratos e fornecedores.', 'A Nossa Solução', 'A nossa empresa foi desenvolvida com o objetivo de centralizar e organizar toda a informação relativa aos equipamentos médicos, promovendo assim uma gestão mais eficiente e estruturada do inventário hospitalar.', 'Através de uma plataforma web intuitiva, é possível registar, consultar e atualizar dados em tempo real, garantindo um maior controlo sobre a localização, estado e documentação associada a cada equipamento.', 'O sistema permite ainda melhorar a rastreabilidade dos dispositivos médicos e apoiar a tomada de decisões técnicas e administrativas.', '2026-06-21 16:02:04', '2026-06-22 19:29:10');

-- A despejar dados para tabela db1240811.gestao_rodape: ~0 rows (aproximadamente)
INSERT INTO `gestao_rodape` (`id`, `localizacao`, `morada`, `horario`, `horas`, `contactos`, `email`, `telefone`, `data_criacao`, `data_ultima_alteracao`) VALUES
	(1, 'LOCALIZAÇÃO', 'Rua da Inovação, 42\n4690-945, Viseu\nPortugal', 'HORÁRIO', '2ª a 6ª Feira: 8h - 18h\nSábado e Feriados: 9h - 13h\nDomingo: Encerrado\nAtendimento online: 24/7', 'CONTACTOS', 'Email: suporte@MEDInvenTEC.pt', '+351 210 759 811', '2026-06-21 16:05:00', '2026-06-21 16:05:00');

-- A despejar dados para tabela db1240811.gestao_sobre_nos: ~0 rows (aproximadamente)
INSERT INTO `gestao_sobre_nos` (`id`, `menu_sobre_nos`, `titulo`, `conteudo`, `texto_botao`, `data_criacao`, `data_ultima_alteracao`) VALUES
	(1, 'Sobre nós', 'Gestão Inteligente de Equipamentos Médicos', 'Organize, controle e otimize o seu inventário hospitalar.', 'Fale connosco!', '2026-06-21 16:02:04', '2026-06-21 16:35:30');

-- A despejar dados para tabela db1240811.gestao_vantagens: ~0 rows (aproximadamente)
INSERT INTO `gestao_vantagens` (`id`, `menu_vantagens`, `titulo`, `data_criacao`, `data_ultima_alteracao`) VALUES
	(1, 'Vantagens', 'Vantagens', '2026-06-21 16:02:05', '2026-06-21 16:02:05');

-- A despejar dados para tabela db1240811.historico_movimentacoes: ~0 rows (aproximadamente)
INSERT INTO `historico_movimentacoes` (`id`, `equipamento_id`, `utilizador_id`, `tipo_alteracao`, `valor_anterior`, `valor_novo`, `data_alteracao`) VALUES
	(1, 17, 1, 'Estado', 'Ativo', 'Abatido', '2026-06-22 00:20:45'),
	(2, 3, 1, 'Criticidade', 'Média', 'Suporte de Vida', '2026-06-22 00:49:17'),
	(3, 4, 1, 'Designação', 'Ecógrafo portátil', 'Ecógrafo Portátil', '2026-06-22 02:28:37'),
	(4, 4, 1, 'Ano de fabrico', '2022', '2021', '2026-06-22 02:28:37'),
	(5, 4, 1, 'Fim de Garantia', '2027-04-05', '2029-06-22', '2026-06-22 02:28:37'),
	(6, 4, 1, 'Ano de fabrico', '2021', '2022', '2026-06-22 19:20:10');

-- A despejar dados para tabela db1240811.localizacoes: ~13 rows (aproximadamente)
INSERT INTO `localizacoes` (`id`, `edificio`, `piso`, `servico_depart`, `sala_gabinete`, `ativo`) VALUES
	(1, 'Edifício Central Hospitalar', '0', 'Urgência', 'URG02', 1),
	(2, 'Edifício Central Hospitalar', '3', 'Bloco Operatório', 'OP05', 1),
	(3, 'Edifício Central Hospitalar', '2', 'Unidade de Cuidados Intensivos', 'UCI01', 1),
	(4, 'Edifício de Diagnóstico e Imagem', '1', 'Radiologia', 'RX03', 1),
	(5, 'Edifício de Diagnóstico e Imagem', '2', 'Cardiologia', 'CAR01', 1),
	(6, 'Edifício de Diagnóstico e Imagem', '2', 'Pneumologia', 'PNE02', 1),
	(7, 'Edifício Laboratorial', '0', 'Laboratório Clínico', 'LAB01', 1),
	(8, 'Edifício Laboratorial', '2', 'Análises Especializadas', 'ANL04', 1),
	(9, 'Edifício de Consultas externas', '1', 'Fisioterapia', 'FIS01', 1),
	(10, 'Edifício de Consultas externas', '0', 'Consulta Externa', 'CE01', 1),
	(11, 'Edifício de Consultas externas', '0', 'Consulta Externa', 'CE12', 1),
	(12, 'Edifício de Consultas externas', '2', 'Pediatria', 'PED01', 1),
	(13, 'Edifício Central Hospitalar', '2', 'Cardiologia', 'CAR04', 0),
	(14, 'Edifício De Reabilitação', '6', 'Neurologia', 'NEU03', 1);

-- A despejar dados para tabela db1240811.mensagens_contacto: ~2 rows (aproximadamente)
INSERT INTO `mensagens_contacto` (`id`, `nome`, `email`, `mensagem`, `data_envio`, `lida`) VALUES
	(1, 'Pedro Cardoso', 'pedro.car91763553@gmail.com', 'Como funcionaria a logística deste inventário?', '2026-06-21 20:58:35', 1),
	(2, 'Catarina Pereira', 'cata_peres@gmail.com', 'Queria contratar a empresa para fazer o inventário', '2026-06-21 21:03:26', 0);

-- A despejar dados para tabela db1240811.perfil: ~3 rows (aproximadamente)
INSERT INTO `perfil` (`id`, `perfil`) VALUES
	(1, 'administrador'),
	(2, 'tecnico'),
	(3, 'profissional_saude');

-- A despejar dados para tabela db1240811.periodicidade: ~4 rows (aproximadamente)
INSERT INTO `periodicidade` (`id`, `periodicidade`) VALUES
	(1, 'Mensal'),
	(2, 'Trimestral'),
	(3, 'Semestral'),
	(4, 'Anual');

-- A despejar dados para tabela db1240811.tipo_contrato: ~3 rows (aproximadamente)
INSERT INTO `tipo_contrato` (`id`, `tipo_contrato`) VALUES
	(1, 'Preventivo'),
	(2, 'Corretivo'),
	(3, 'Completo');

-- A despejar dados para tabela db1240811.tipo_doc: ~7 rows (aproximadamente)
INSERT INTO `tipo_doc` (`id`, `tipo_doc`) VALUES
	(1, 'Manual de utilizador'),
	(2, 'Manual de serviço'),
	(3, 'Certificado de calibração'),
	(4, 'Contrato de manutenção'),
	(5, 'Fatura / Guia de aquisição'),
	(6, 'Declaração de conformidade'),
	(7, 'Relatório técnico');

-- A despejar dados para tabela db1240811.tipo_entrada: ~4 rows (aproximadamente)
INSERT INTO `tipo_entrada` (`id`, `tipo_entrada`) VALUES
	(1, 'Compra'),
	(2, 'Doação'),
	(3, 'Aluguer'),
	(4, 'Empréstimo');

-- A despejar dados para tabela db1240811.tipo_fornecedor: ~4 rows (aproximadamente)
INSERT INTO `tipo_fornecedor` (`id`, `tipo_fornecedor`) VALUES
	(1, 'Fabricante'),
	(2, 'Distribuidor'),
	(3, 'Fabricante e Distribuidor'),
	(4, 'Prestador de Serviços');

-- A despejar dados para tabela db1240811.utilizador: ~3 rows (aproximadamente)
INSERT INTO `utilizador` (`id`, `nome`, `email`, `password`, `perfil_id`, `ativo`, `last_login`, `created_at`) VALUES
	(1, 'Ana Vieira', 'admin@medinventec.pt', '$2y$10$wVf0HGRWiZkDqv69j4NvFOcV8Fzqd648CJhQlXVYpLw4D5E8B3HzC', 1, 1, '2026-06-22 20:54:02', '2026-06-20 23:07:33'),
	(2, 'José Rocha', 'tecnico@medinventec.pt', '$2y$10$QlOhTk6G66aa0Wfu78yuiefMXKQlolUjv3ZNzMl4BJF49UW/NmB4O', 2, 1, '2026-06-22 20:45:34', '2026-06-20 23:07:33'),
	(3, 'Jerusa Vinagre', 'saude@medinventec.pt', '$2y$10$OBB/DJvBU68ohfUzbCm6WOLu0J9HhRPph3L0NX97kWqPUdffWPMu2', 3, 1, '2026-06-22 20:45:51', '2026-06-20 23:07:33');

-- A despejar dados para tabela db1240811.vantagens: ~7 rows (aproximadamente)
INSERT INTO `vantagens` (`id`, `gestao_vantagens_id`, `vantagem`) VALUES
	(1, 1, 'Centralização de toda a informação num único sistema, evitando dispersão de dados'),
	(2, 1, 'Acesso rápido e em tempo real à informação dos equipamentos médicos'),
	(3, 1, 'Melhoria no controlo do estado, localização e histórico de cada equipamento'),
	(4, 1, 'Facilidade na gestão de garantias, contratos e fornecedores'),
	(5, 1, 'Melhor rastreabilidade dos dispositivos médicos'),
	(6, 1, 'Apoio à tomada de decisões técnicas e administrativas com base em dados atualizados'),
	(7, 1, 'Interface intuitiva que facilita a utilização por diferentes profissionais');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
