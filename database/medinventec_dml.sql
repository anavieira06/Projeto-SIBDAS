/* =========================================
   TABELAS CONSTANTES
========================================= */

INSERT INTO categoria_grupo (categoria_grupo) VALUES
('Monitorização'),
('Suporte de Vida'),
('Terapia'),
('Diagnóstico'),
('Laboratório'),
('Esterilização'),
('Reabilitação');

INSERT INTO tipo_entrada (tipo_entrada) VALUES
('Compra'),
('Doação'),
('Aluguer'),
('Empréstimo');

INSERT INTO estado (estado) VALUES
('Ativo'),
('Inativo'),
('Em Manutenção'),
('Em Calibração'),
('Em Quarentena'),
('Abatido');

INSERT INTO criticidade (criticidade) VALUES
('Baixa'),
('Média'),
('Alta'),
('Suporte de vida');

INSERT INTO tipo_fornecedor (tipo_fornecedor) VALUES
('Fabricante'),
('Distribuidor'),
('Fabricante e Distribuidor'),
('Prestador de Serviços');

INSERT INTO tipo_doc (tipo_doc) VALUES
('Manual de utilizador'),
('Manual de serviço'),
('Certificado de calibração'),
('Contrato de manutenção'),
('Fatura / Guia de aquisição'),
('Declaração de conformidade'),
('Relatório técnico');

INSERT INTO tipo_contrato (tipo_contrato) VALUES
('Preventivo'),
('Corretivo'),
('Completo');

INSERT INTO periodicidade (periodicidade) VALUES
('Mensal'),
('Trimestral'),
('Semestral'),
('Anual');


/* =========================================
   LOCALIZAÇÕES
========================================= */

INSERT INTO localizacoes
(edificio, piso, servico_depart, sala_gabinete)
VALUES
('Edifício Central Hospitalar', '0', 'Urgência', 'URG01'),
('Edifício Central Hospitalar', '3', 'Bloco Operatório', 'OP05'),
('Edifício Central Hospitalar', '2', 'Unidade de Cuidados Intensivos', 'UCI01'),
('Edifício de Diagnóstico e Imagem', '1', 'Radiologia', 'RX03'),
('Edifício de Diagnóstico e Imagem', '2', 'Cardiologia', 'CAR01'),
('Edifício de Diagnóstico e Imagem', '2', 'Pneumologia', 'PNE02'),
('Edifício Laboratorial', '0', 'Laboratório Clínico', 'LAB01'),
('Edifício Laboratorial', '2', 'Análises Especializadas', 'ANL04'),
('Edifício de Consultas externas', '1', 'Fisioterapia', 'FIS01'),
('Edifício de Consultas externas', '0', 'Consulta Externa', 'CE01'),
('Edifício de Consultas externas', '0', 'Consulta Externa', 'CE12'),
('Edifício de Consultas externas', '2', 'Pediatria', 'PED01');


/* =========================================
   FORNECEDORES
========================================= */

INSERT INTO fornecedores
(nome_empresa, nif, morada, numero_telefonico, email, website,
 pessoa_contacto, tel_pessoa_contacto, observacoes, tipo_fornecedor_id)
VALUES
('Philips Healthcare Portugal',
 '507384921',
 'Avenida da República 90, Lisboa',
 '213846275',
 'geral@philipshealthcare.pt',
 'https://www.philips.pt/healthcare',
 'Ana Costa',
 '912458736',
 NULL,
 3),

('Dräger',
 '509671438',
 'Rua José Ferreira Dias 728, Porto',
 '229783614',
 'contacto@draeger.pt',
 'https://www.draeger.com',
 'João Martins',
 '934672581',
 'Fornecedor principal de equipamentos de monitorização e imagiologia.',
 1),

('B. Braun',
 '506928174',
 'Rua António Morgado 80, Queluz',
 '214356982',
 'suporte@bbraun.pt',
 'https://www.bbraun.pt',
 'Marta Silva',
 '968214753',
 'Responsável pelo fornecimento de bombas infusoras e consumíveis clínicos.',
 2),

('Siemens Healthineers',
 '508137296',
 'Lagoas Park, Edifício 10, Porto Salvo',
 '214239870',
 'info@siemens-healthineers.pt',
 'https://www.siemens-healthineers.com',
 'Carlos Rocha',
 '917836452',
 NULL,
 3),

('GE HealthCare',
 '505749382',
 'Rua Castilho 39, Lisboa',
 '213927584',
 'geral@gehealthcare.pt',
 'https://www.gehealthcare.com',
 'Rita Almeida',
 '961728394',
 NULL,
 1),

('Medtronic',
 '510284763',
 'Avenida José Malhoa 16, Lisboa',
 '217462938',
 'apoio@medtronic.pt',
 'https://www.medtronic.com',
 'Pedro Sousa',
 '935817246',
 NULL,
 1),

('Mindray',
 '508692417',
 'Rua do Campo Alegre 1024, Porto',
 '226374819',
 'comercial@mindray.pt',
 'https://www.mindray.com',
 'Sofia Ribeiro',
 '913685742',
 NULL,
 2),

('Fresenius Medical Care',
 '504873691',
 'Avenida D. João II 35, Lisboa',
 '218736245',
 'contacto@fresenius.pt',
 'https://www.freseniusmedicalcare.com',
 'Tiago Lopes',
 '967342815',
 'Fornecedor especializado em equipamentos para diálise.',
 1),

('Olympus',
 '507916284',
 'Rua Alfredo da Silva 14, Amadora',
 '214928376',
 'info@olympus.pt',
 'https://www.olympus.pt',
 'Cláudia Ferreira',
 '932681475',
 NULL,
 2),

('Canon Medical Systems',
 '509348617',
 'Avenida da Boavista 165, Porto',
 '226918457',
 'geral@canonmedical.pt',
 'https://global.medical.canon',
 'Luís Gomes',
 '919472638',
 NULL,
 1),

('Distrimed Equipamentos Médicos',
 '506417829',
 'Rua Dr. Mário Sacramento 101, Aveiro',
 '234682971',
 'vendas@distrimed.pt',
 'https://www.distrimed.pt',
 'Patrícia Santos',
 '963814257',
 NULL,
 2),

('TecnoSaúde Equipamentos Hospitalares',
 '510736294',
 'Avenida Luísa Todi 327, Setúbal',
 '265918473',
 'info@tecnosaude.pt',
 'https://www.tecnosaude.pt',
 'Miguel Correia',
 '936275814',
 'Empresa contratada para assistência técbica e manutenção especializada.',
 4);

/* =========================================
   GARANTIAS E CONTRATOS
========================================= */

INSERT INTO garantias_contratos
(data_inicio, data_fim, contrato_manutencao, tipo_contrato_id,
 periodicidade_id, entidade_responsavel, observacoes_garant)
VALUES

('2023-01-15','2026-01-15',1,3,4,'Philips Healthcare Portugal',
'Contrato completo com manutenção anual.'),

('2023-02-10','2025-02-10',1,1,3,'Dräger',
'Manutenção preventiva semestral.'),

('2023-03-12','2026-03-12',0,NULL,NULL,'B. Braun',
'Garantia standard do fabricante.'),

('2023-04-05','2027-04-05',1,3,2,'Siemens Healthineers',
'Cobertura integral do equipamento.'),

('2023-05-20','2025-05-20',1,1,1,'GE HealthCare',
'Inspeções mensais programadas.'),

('2023-06-08','2026-06-08',0,NULL,NULL,'Medtronic',
'Garantia de fábrica.'),

('2023-07-14','2026-07-14',1,1,3,'Mindray',
'Plano preventivo semestral.'),

('2023-08-01','2025-08-01',1,2,4,'Fresenius Medical Care',
'Assistência corretiva quando necessário.'),

('2023-09-18','2026-09-18',1,3,4,'Olympus',
'Contrato de manutenção completo.'),

('2023-10-22','2025-10-22',0,NULL,NULL,'Canon Medical Systems',
'Garantia base do fabricante.'),

('2023-11-09','2026-11-09',1,1,2,'Distrimed Equipamentos Médicos',
'Manutenção preventiva trimestral.'),

('2023-12-03','2027-12-03',1,3,4,'TecnoSaúde Equipamentos Hospitalares',
'Assistência técnica permanente.'),

('2024-01-11','2027-01-11',1,1,3,'Philips Healthcare Portugal',
'Plano de manutenção preventiva.'),

('2024-02-07','2026-02-07',0,NULL,NULL,'Dräger',
'Garantia comercial standard.'),

('2024-03-19','2027-03-19',1,3,4,'B. Braun',
'Cobertura integral do equipamento.'),

('2024-04-02','2026-04-02',1,2,4,'Siemens Healthineers',
'Suporte corretivo especializado.'),

('2024-05-13','2027-05-13',1,1,2,'GE HealthCare',
'Plano trimestral de inspeção.'),

('2024-06-27','2026-06-27',0,NULL,NULL,'Medtronic',
'Garantia do fabricante.'),

('2024-07-08','2027-07-08',1,3,4,'Mindray',
'Contrato de manutenção completa.'),

('2024-08-16','2026-08-16',1,1,3,'Fresenius Medical Care',
'Manutenção preventiva semestral.'),

('2024-09-05','2027-09-05',1,3,4,'Olympus',
'Cobertura integral e suporte técnico.'),

('2024-10-21','2026-10-21',0,NULL,NULL,'Canon Medical Systems',
'Garantia comercial.'),

('2024-11-14','2027-11-14',1,1,1,'Distrimed Equipamentos Médicos',
'Visitas mensais de manutenção.'),

('2024-12-06','2027-12-06',1,3,4,'TecnoSaúde Equipamentos Hospitalares',
'Manutenção completa com substituição de peças.'),

('2025-01-09','2028-01-09',1,1,3,'Philips Healthcare Portugal',
'Plano preventivo semestral.');


/* =========================================
   EQUIPAMENTOS
========================================= */

INSERT INTO equipamentos
(codigo_inventario, designacao_equipamento, marca, modelo, numero_serie, fabricante,
 data_aquisicao, ano_fabrico, custo_aquisicao, observacoes,
 categoria_grupo_id, estado_id, criticidade_id, tipo_entrada_id,
 localizacao_id, garantia_contrato_id)
VALUES
('EQ0001','Monitor multiparamétrico','Philips','IntelliVue MX450','PH-MX450-001','Philips Healthcare Portugal','2023-01-15',2022,8500.00,'Equipamento em utilização regular na UCI.',1,1,1,1,3,1),

('EQ0002','Ventilador pulmonar','Dräger','Evita V500','DR-EV500-002','Dräger','2023-02-10',2022,18500.00,'Equipamento crítico para suporte ventilatório.',2,2,4,1,3,2),

('EQ0003','Bomba infusora','B. Braun','Infusomat Space','BB-IS-003','B. Braun','2023-03-12',2021,3200.00,NULL,3,2,2,1,11,3),

('EQ0004','Ecógrafo portátil','Siemens','Acuson Freestyle','SI-AF-004','Siemens Healthineers','2023-04-05',2022,24500.00,'Usado em exames rápidos junto ao doente.',4,1,3,1,10,4),

('EQ0005','Aparelho de raio-X digital','GE HealthCare','Definium 656','GE-D656-005','GE HealthCare','2023-05-20',2021,78000.00,NULL,4,1,3,1,4,5),

('EQ0006','Desfibrilhador','Medtronic','Lifepak 20e','MD-LP20-006','Medtronic','2023-06-08',2022,6900.00,'Equipamento disponível na urgência.',2,3,4,1,1,6),

('EQ0007','Monitor de sinais vitais','Mindray','VS 900','MI-VS900-007','Mindray','2023-07-14',2022,2400.00,NULL,1,3,2,1,10,7),

('EQ0008','Máquina de hemodiálise','Fresenius','5008S CorDiax','FR-5008S-008','Fresenius Medical Care','2023-08-01',2021,22000.00,'Equipamento usado em tratamentos regulares.',3,1,3,1,11,8),

('EQ0009','Endoscópio flexível','Olympus','EVIS EXERA III','OL-EVIS-009','Olympus','2023-09-18',2022,31500.00,NULL,4,2,3,1,10,9),

('EQ0010','Tomógrafo computorizado','Canon','Aquilion Prime','CA-AP-010','Canon Medical Systems','2023-10-22',2020,145000.00,'Equipamento de imagiologia de grande porte.',4,4,3,1,4,10),

('EQ0011','Autoclave hospitalar','Distrimed','Stericlav 80','DI-ST80-011','Distrimed Equipamentos Médicos','2023-11-09',2021,12800.00,NULL,6,1,2,1,8,11),

('EQ0012','Mesa cirúrgica elétrica','TecnoSaúde','TS-Cirurgic 3000','TS-C3000-012','TecnoSaúde Equipamentos Hospitalares','2023-12-03',2022,16400.00,'Mesa principal do bloco operatório.',3,4,3,1,2,12),

('EQ0013','Oxímetro de pulso','Philips','PulseOx 2500','PH-PO2500-013','Philips Healthcare Portugal','2024-01-11',2023,950.00,NULL,1,1,2,1,1,13),

('EQ0014','Incubadora neonatal','Dräger','Isolette 8000','DR-ISO8000-014','Dräger','2024-02-07',2023,17500.00,'Equipamento afeto ao serviço de pediatria.',2,3,4,1,12,14),

('EQ0015','Bomba de seringa','B. Braun','Perfusor Space','BB-PS-015','B. Braun','2024-03-19',2023,2800.00,NULL,3,1,2,1,3,15),

('EQ0016','Ressonância magnética','Siemens','MAGNETOM Sola','SI-MS-016','Siemens Healthineers','2024-04-02',2021,230000.00,'Equipamento de elevada complexidade técnica.',4,5,3,1,4,16),

('EQ0017','Eletrocardiógrafo','GE HealthCare','MAC 2000','GE-MAC2000-017','GE HealthCare','2024-05-13',2023,4100.00,NULL,4,1,2,1,5,17),

('EQ0018','Neuroestimulador','Medtronic','NIM Vital','MD-NIM-018','Medtronic','2024-06-27',2022,13600.00,NULL,3,4,3,1,2,18),

('EQ0019','Ventilador de transporte','Mindray','SV300','MI-SV300-019','Mindray','2024-07-08',2023,9800.00,'Usado em transporte intra-hospitalar.',2,1,4,1,1,19),

('EQ0020','Sistema de diálise portátil','Fresenius','AquaUNO','FR-AQUNO-020','Fresenius Medical Care','2024-08-16',2022,18750.00,NULL,3,5,3,1,11,20),

('EQ0021','Videolaringoscópio','Olympus','Airway Scope','OL-AS-021','Olympus','2024-09-05',2023,5600.00,'Equipamento usado em procedimentos de via aérea difícil.',4,1,3,1,2,21),

('EQ0022','Arco cirúrgico móvel','Canon','CXDI-Elite','CA-CXDI-022','Canon Medical Systems','2024-10-21',2021,89000.00,NULL,4,1,3,1,2,22),

('EQ0023','Centrífuga laboratorial','Distrimed','LabSpin 400','DI-LS400-023','Distrimed Equipamentos Médicos','2024-11-14',2023,3700.00,NULL,5,5,2,1,7,23),

('EQ0024','Cama hospitalar articulada','TecnoSaúde','ComfortCare 500','TS-CC500-024','TecnoSaúde Equipamentos Hospitalares','2024-12-06',2023,2900.00,NULL,3,1,2,1,11,24),

('EQ0025','Monitor cardíaco portátil','Philips','IntelliVue X3','PH-X3-025','Philips Healthcare Portugal','2025-01-09',2024,6200.00,'Equipamento portátil para monitorização contínua.',1,1,3,1,5,25);


/* =========================================
   EQUIPAMENTO - FORNECEDOR
========================================= */

INSERT INTO equipamento_fornecedor
(equipamento_id, fornecedor_id)
VALUES
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
(25, 11);


/* =========================================
   DOCUMENTOS
========================================= */

INSERT INTO documentos
(equipamento_id, fornecedor_id, tipo_doc_id, nome_doc, data_doc, data_validade, ficheiro)
VALUES

-- Equipamento 1 - Philips IntelliVue MX450
(1, 1, 1, 'Manual de Utilização Philips IntelliVue MX450', '2023-01-15', NULL, 'manual_philips_intellivue_mx450.pdf'),
(1, NULL, 3, 'Certificado de Calibração Philips IntelliVue MX450', '2024-01-10', '2025-01-10', 'certificado_calibracao_philips_intellivue_mx450.pdf'),

-- Equipamento 2 - Dräger Evita V500
(2, 2, 1, 'Manual de Utilização Dräger Evita V500', '2023-02-10', NULL, 'manual_drager_evita_v500.pdf'),
(2, 2, 4, 'Contrato de Manutenção Dräger Evita V500', '2023-02-10', '2025-02-10', 'contrato_manutencao_drager_evita_v500.pdf'),
(2, NULL, 7, 'Relatório Técnico Dräger Evita V500', '2024-05-12', NULL, 'relatorio_tecnico_drager_evita_v500.pdf'),

-- Equipamento 3 - B. Braun Infusomat Space
(3, 3, 1, 'Manual de Utilização B. Braun Infusomat Space', '2023-03-12', NULL, 'manual_bbraun_infusomat_space.pdf'),

-- Equipamento 4 - Siemens Acuson Freestyle
(4, 4, 1, 'Manual de Utilização Siemens Acuson Freestyle', '2023-04-05', NULL, 'manual_siemens_acuson_freestyle.pdf'),
(4, NULL, 6, 'Declaração de Conformidade Siemens Acuson Freestyle', '2023-04-05', NULL, 'declaracao_conformidade_siemens_acuson_freestyle.pdf'),

-- Equipamento 5 - GE Definium 656
(5, 5, 1, 'Manual de Utilização GE Definium 656', '2023-05-20', NULL, 'manual_ge_definium_656.pdf'),
(5, NULL, 3, 'Certificado de Calibração GE Definium 656', '2024-05-15', '2025-05-15', 'certificado_calibracao_ge_definium_656.pdf'),
(5, 5, 5, 'Fatura de Aquisição GE Definium 656', '2023-05-20', NULL, 'fatura_ge_definium_656.pdf'),

-- Equipamento 6 - Medtronic Lifepak 20e
(6, 6, 1, 'Manual de Utilização Medtronic Lifepak 20e', '2023-06-08', NULL, 'manual_medtronic_lifepak_20e.pdf'),

-- Equipamento 7 - Mindray VS900
(7, NULL, 1, 'Manual de Utilização Mindray VS900', '2023-07-14', NULL, 'manual_mindray_vs900.pdf'),

-- Equipamento 8 - Fresenius 5008S CorDiax
(8, 8, 1, 'Manual de Utilização Fresenius 5008S CorDiax', '2023-08-01', NULL, 'manual_fresenius_5008s_cordiax.pdf'),
(8, 8, 4, 'Contrato de Manutenção Fresenius 5008S CorDiax', '2023-08-01', '2025-08-01', 'contrato_fresenius_5008s_cordiax.pdf'),

-- Equipamento 9 - Olympus EVIS EXERA III
(9, 9, 1, 'Manual de Utilização Olympus EVIS EXERA III', '2023-09-18', NULL, 'manual_olympus_evis_exera_iii.pdf'),

-- Equipamento 10 - Canon Aquilion Prime
(10, 10, 1, 'Manual de Utilização Canon Aquilion Prime', '2023-10-22', NULL, 'manual_canon_aquilion_prime.pdf'),
(10, NULL, 7, 'Relatório Técnico Canon Aquilion Prime', '2024-08-12', NULL, 'relatorio_tecnico_canon_aquilion_prime.pdf'),

-- Equipamento 11 - Distrimed Stericlav 80
(11, 11, 1, 'Manual de Utilização Distrimed Stericlav 80', '2023-11-09', NULL, 'manual_distrimed_stericlav_80.pdf'),

-- Equipamento 12 - TecnoSaúde TS-Cirurgic 3000
(12, 12, 1, 'Manual de Utilização TecnoSaúde TS-Cirurgic 3000', '2023-12-03', NULL, 'manual_tecnosaude_ts_cirurgic_3000.pdf'),
(12, NULL, 6, 'Declaração de Conformidade TecnoSaúde TS-Cirurgic 3000', '2023-12-03', NULL, 'declaracao_conformidade_ts_cirurgic_3000.pdf'),

-- Equipamento 13 - Philips PulseOx 2500
(13, 1, 1, 'Manual de Utilização Philips PulseOx 2500', '2024-01-11', NULL, 'manual_philips_pulseox_2500.pdf'),

-- Equipamento 14 - Dräger Isolette 8000
(14, 2, 1, 'Manual de Utilização Dräger Isolette 8000', '2024-02-07', NULL, 'manual_drager_isolette_8000.pdf'),
(14, NULL, 3, 'Certificado de Calibração Dräger Isolette 8000', '2024-02-15', '2025-02-15', 'certificado_calibracao_drager_isolette_8000.pdf'),

-- Equipamento 15 - B. Braun Perfusor Space
(15, 3, 1, 'Manual de Utilização B. Braun Perfusor Space', '2024-03-19', NULL, 'manual_bbraun_perfusor_space.pdf'),

-- Equipamento 16 - Siemens MAGNETOM Sola
(16, 4, 1, 'Manual de Utilização Siemens MAGNETOM Sola', '2024-04-02', NULL, 'manual_siemens_magnetom_sola.pdf'),
(16, 4, 5, 'Fatura de Aquisição Siemens MAGNETOM Sola', '2024-04-02', NULL, 'fatura_siemens_magnetom_sola.pdf'),
(16, NULL, 7, 'Relatório Técnico Siemens MAGNETOM Sola', '2024-09-20', NULL, 'relatorio_tecnico_siemens_magnetom_sola.pdf'),

-- Equipamento 17 - GE MAC 2000
(17, 5, 1, 'Manual de Utilização GE MAC 2000', '2024-05-13', NULL, 'manual_ge_mac_2000.pdf'),

-- Equipamento 18 - Medtronic NIM Vital
(18, NULL, 1, 'Manual de Utilização Medtronic NIM Vital', '2024-06-27', NULL, 'manual_medtronic_nim_vital.pdf'),

-- Equipamento 19 - Mindray SV300
(19, 7, 1, 'Manual de Utilização Mindray SV300', '2024-07-08', NULL, 'manual_mindray_sv300.pdf'),
(19, 7, 3, 'Certificado de Calibração Mindray SV300', '2024-07-20', '2025-07-20', 'certificado_calibracao_mindray_sv300.pdf'),

-- Equipamento 20 - Fresenius AquaUNO
(20, 8, 1, 'Manual de Utilização Fresenius AquaUNO', '2024-08-16', NULL, 'manual_fresenius_aquauno.pdf'),

-- Equipamento 21 - Olympus Airway Scope
(21, 9, 1, 'Manual de Utilização Olympus Airway Scope', '2024-09-05', NULL, 'manual_olympus_airway_scope.pdf'),

-- Equipamento 22 - Canon CXDI-Elite
(22, 10, 1, 'Manual de Utilização Canon CXDI-Elite', '2024-10-21', NULL, 'manual_canon_cxdi_elite.pdf'),
(22, NULL, 6, 'Declaração de Conformidade Canon CXDI-Elite', '2024-10-21', NULL, 'declaracao_conformidade_canon_cxdi_elite.pdf'),

-- Equipamento 23 - Distrimed LabSpin 400
(23, 11, 1, 'Manual de Utilização Distrimed LabSpin 400', '2024-11-14', NULL, 'manual_distrimed_labspin_400.pdf'),

-- Equipamento 24 - TecnoSaúde ComfortCare 500
(24, NULL, 1, 'Manual de Utilização TecnoSaúde ComfortCare 500', '2024-12-06', NULL, 'manual_tecnosaude_comfortcare_500.pdf'),

-- Equipamento 25 - Philips IntelliVue X3
(25, 1, 1, 'Manual de Utilização Philips IntelliVue X3', '2025-01-09', NULL, 'manual_philips_intellivue_x3.pdf'),
(25, NULL, 3, 'Certificado de Calibração Philips IntelliVue X3', '2025-01-15', '2026-01-15', 'certificado_calibracao_philips_intellivue_x3.pdf');


/* =========================================
   UTILIZADORES
========================================= */

INSERT INTO perfil (perfil) VALUES ('administrador'), ('tecnico'), ('profissional_saude');


INSERT INTO utilizador (nome, email, password, perfil_id, created_at) VALUES
('Ana Vieira', 'admin@medinventec.pt', '$2y$10$wVf0HGRWiZkDqv69j4NvFOcV8Fzqd648CJhQlXVYpLw4D5E8B3HzC', 1, NOW()),
('José Rocha', 'tecnico@medinventec.pt', '$2y$10$QlOhTk6G66aa0Wfu78yuiefMXKQlolUjv3ZNzMl4BJF49UW/NmB4O', 2, NOW()),
('Jerusa Vinagre', 'saude@medinventec.pt', '$2y$10$v6ToZARQjHtsLMYdxBUKme6POdWbfY7tM44mnaYL8ZNO.KzxZ2Q1C', 3, NOW());


* =========================================
  GESTÃO DE CONTEÚDOS
========================================= */

INSERT INTO gestao_sobre_nos (menu_sobre_nos, titulo, conteudo, texto_botao, data_criacao, data_ultima_alteracao) VALUES
('Sobre nós', 'Gestão Inteligente de Equipamentos Médicos', 'Organize, controle e otimize o seu inventário hospitalar.', 'Fale connosco!', NOW(), NOW());
 
INSERT INTO gestao_problema_solucao (menu_problema_solucao, titulo1, paragrafo1, paragrafo2, paragrafo3, titulo2, paragrafo1_vant, paragrafo2_vant, paragrafo3_vant, data_criacao, data_ultima_alteracao) VALUES
('Problema e Solução',
'O Problema',
'Em muitas unidades hospitalares, a gestão do inventário de equipamentos médicos é realizada de forma fragmentada, recorrendo a folhas de Excel, documentos isolados, registos em papel e várias bases de dados sem integração.',
'Esta abordagem dificulta a organização da informação, a localização dos equipamentos e o rápido acesso à documentação técnica.',
'Como consequência, surgem problemas como a duplicação de dados, falta de controlo do estado dos equipamentos e dificuldades na gestão de garantias, contratos e fornecedores.',
'A Nossa Solução',
'A nossa empresa foi desenvolvida com o objetivo de centralizar e organizar toda a informação relativa aos equipamentos médicos, promovendo uma gestão mais eficiente e estruturada do inventário hospitalar.',
'Através de uma plataforma web intuitiva, é possível registar, consultar e atualizar dados em tempo real, garantindo um maior controlo sobre a localização, estado e documentação associada a cada equipamento.',
'O sistema permite ainda melhorar a rastreabilidade dos dispositivos médicos e apoiar a tomada de decisões técnicas e administrativas.',
NOW(), NOW());
 
INSERT INTO gestao_vantagens (menu_vantagens, titulo, data_criacao, data_ultima_alteracao) VALUES
('Vantagens', 'Vantagens', NOW(), NOW());
 
INSERT INTO vantagens (gestao_vantagens_id, vantagem) VALUES
(1, 'Centralização de toda a informação num único sistema, evitando dispersão de dados'),
(1, 'Acesso rápido e em tempo real à informação dos equipamentos médicos'),
(1, 'Melhoria no controlo do estado, localização e histórico de cada equipamento'),
(1, 'Facilidade na gestão de garantias, contratos e fornecedores'),
(1, 'Melhor rastreabilidade dos dispositivos médicos'),
(1, 'Apoio à tomada de decisões técnicas e administrativas com base em dados atualizados'),
(1, 'Interface intuitiva que facilita a utilização por diferentes profissionais');
 
INSERT INTO gestao_funcionalidades (menu_funcionalidades, titulo, texto_introdutorio, data_criacao, data_ultima_alteracao) VALUES
('Funcionalidades', 'Funcionalidades', 'Aqui encontram-se as funcionalidades da nossa página.', NOW(), NOW());
 
INSERT INTO funcionalidades (gestao_funcionalidades_id, icone, titulo_funcionalidade, descricao) VALUES
(1, 'fa-solid fa-laptop', 'Gestão de equipamentos', 'Registo, edição e consulta detalhada de equipamentos médicos, incluindo estado e criticidade.'),
(1, 'fa-solid fa-location-dot', 'Gestão de localizações', 'Organização por edifício, serviço e sala, permitindo localizar rapidamente cada equipamento.'),
(1, 'fa-solid fa-building', 'Gestão de fornecedores', 'Associação de fabricantes, distribuidores e empresas de assistência técnica aos equipamentos.'),
(1, 'fa-solid fa-folder-open', 'Documentação', 'Upload e organização de manuais, certificados, contratos e relatórios técnicos.'),
(1, 'fa-solid fa-file-signature', 'Garantias e Contratos', 'Controlo de garantias, contratos de manutenção e datas importantes associadas aos equipamentos.'),
(1, 'fa-solid fa-magnifying-glass', 'Pesquisa inteligente', 'Pesquisa rápida por código, marca, modelo, serviço, estado ou criticidade.'),
(1, 'fa-solid fa-chart-column', 'Dashboard', 'Indicadores em tempo real sobre equipamentos ativos, manutenção, garantias e estatísticas hospitalares.'),
(1, 'fa-solid fa-shield-halved', 'Segurança', 'Sistema de autenticação e controlo de acesso para proteção dos dados hospitalares.');
 
INSERT INTO gestao_contacto (menu_contacto, titulo, texto_introdutorio, etiqueta1, etiqueta2, etiqueta3, texto_botao, data_criacao, data_ultima_alteracao) VALUES
('Contacto', 'Contacto', 'Entre em contacto conosco para tirar todas as suas dúvidas ou obter mais informações sobre a nossa plataforma.', 'Nome', 'Email', 'Mensagem', 'Enviar Mensagem', NOW(), NOW());
 
INSERT INTO gestao_rodape (localizacao, morada, horario, horas, contactos, email, telefone, data_criacao, data_ultima_alteracao) VALUES
('LOCALIZAÇÃO', 'Rua da Inovação, 42\n4690-945, Viseu\nPortugal', 'HORÁRIO', '2ª a 6ª Feira: 8h - 18h\nSábado e Feriados: 9h - 13h\nDomingo: Encerrado\nAtendimento online: 24/7', 'CONTACTOS', 'Email: suporte@MEDInvenTEC.pt', '+351 210 759 811', NOW(), NOW());