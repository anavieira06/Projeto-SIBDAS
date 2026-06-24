====================================================
MEDInvenTEC
Gestão Inteligente de Equipamentos Médicos
Unidade Curricular- Sistemas de Informação e Bases de Dados Aplicados à Saúde
====================================================

Nome do Estudante: Ana Margarida Vieira
Número de Estudante: 1240811

====================================================

projeto-sibdas/
│
├── README.txt
├── commits.txt
│
├── database/
│   ├── medinventec_ddl.sql
│   ├── medinventec.dml.sql
│   ├── modelo.dbml
│   └── modelo_relacional.pdf
│
└── medinventec/
    │
    ├── config/
    │   └── config.php
    │
    ├── public/
    │   ├── index.php
    │   ├── login.php
    │   ├── logout.php
    │   └── processar_contacto.php
    │
    ├── private/
    │   ├── home.php
    │   ├── processa_login.php
    │   ├── alterar_password.php
    │   │
    │   ├── includes/
    │   ├── views/
    │   └── uploads/
    │
    ├── assets/
    │   ├── bootstrap/
    │   ├── chart/
    │   ├── css/
    │   ├── datatables/
    │   ├── flatpickr/
    │   ├── fontawesome/
    │   ├── img/
    │   ├── jQuery/
    │   └── js/
    │
    └── logs/
        └── eventos.log

====================================================
1. DESCRIÇÃO DO PROJETO
====================================================

O MEDInvenTEC é uma aplicação web desenvolvida para apoiar a
gestão do inventário de equipamentos médicos em contexto
hospitalar.

A aplicação centraliza a informação relativa a equipamentos,
fornecedores, localizações, documentação, garantias
e contratos, permitindo uma gestão mais eficiente,
organizada e segura.

O sistema encontra-se dividido em duas áreas:

ÁREA PÚBLICA (sem autenticação)
- Sobre Nós
- Problema e Solução
- Vantagens
- Funcionalidades
- Contacto

ÁREA PRIVADA (com autenticação)
- Dashboard
- Gestão de Equipamentos
- Gestão de Fornecedores
- Gestão de Localizações
- Gestão de Documentação
- Gestão de Garantias e Contratos
- Gestão de Conteúdos Públicos
- Gestão de Mensagens de Contacto

====================================================
2. TECNOLOGIAS UTILIZADAS
====================================================

Front-End:
- HTML5
- CSS3
- Bootstrap 5
- JavaScript
- jQuery

Back-End:
- PHP

Base de Dados:
- MySQL

Bibliotecas:
- Chart.js
- DataTables
- Flatpickr
- Font Awesome

====================================================
3. INSTALAÇÃO E EXECUÇÃO DA APLICAÇÃO
====================================================

Pré-requisitos:
- MAMP (Apache, PHP e MySQL)
  ou ambiente equivalente (ex:Laragon)

Passo 1:
Copiar a pasta do projeto para:

MAMP/htdocs/

Passo 2:
Iniciar os serviços Apache e MySQL através do MAMP.

Passo 3:
Abrir o Heidi e criar uma base de dados com o nome: db1240811

Passo 4:
Criação do diagrama no dbdiagram.io

Passo 5:
Importar o ficheiro SQL exportado a partir do dbdiagram.io

Passo 6:
Verificar os dados de ligação à base de dados no
ficheiro de configuração da aplicação.

====================================================
4. INSTRUÇÕES PARA TESTES
====================================================

4.1 AUTENTICAÇÃO

- Efetuar login com credenciais válidas.
- Verificar acesso à área privada.
- Efetuar logout.
- Testar alteração de palavra-passe.
- Verificar comportamento com credenciais inválidas.

----------------------------------------------------

4.2 GESTÃO DE EQUIPAMENTOS

Verificar:

- Inserção de equipamentos.
- Consulta de equipamentos.
- Edição de equipamentos.
- Desativação de equipamentos.
- Pesquisa por código, designação, marca e modelo.
- Filtragem por categoria, estado, criticidade,
  fornecedor e serviço.
- Paginação dos resultados.
- Exportação para CSV, JSON e PDF.
- Consulta do histórico de movimentações.

----------------------------------------------------

4.3 GESTÃO DE FORNECEDORES

Verificar:

- Inserção de fornecedores.
- Consulta de fornecedores.
- Edição de fornecedores.
- Desativação de fornecedores.
- Reativação de fornecedores.

----------------------------------------------------

4.4 GESTÃO DE LOCALIZAÇÕES

Verificar:

- Inserção de localizações.
- Consulta de localizações.
- Edição de localizações.
- Desativação de localizações.
- Reativação de localizações.

----------------------------------------------------

4.5 GESTÃO DE DOCUMENTAÇÃO

Verificar:

- Upload de documentos.
- Associação de documentos a equipamentos.
- Associação de documentos a fornecedores.
- Consulta de documentos.
- Atualização de documentos.

----------------------------------------------------

4.6 GESTÃO DE GARANTIAS E CONTRATOS

Verificar:

- Inserção de garantias.
- Inserção de contratos de manutenção.
- Consulta de garantias.
- Atualização de dados.

----------------------------------------------------

4.7 DASHBOARD

Verificar:

- Indicadores estatísticos.
- Gráficos de distribuição.
- Alertas automáticos.
- Atualização dos dados após inserções.

----------------------------------------------------

4.8 GESTÃO DE CONTEÚDOS PÚBLICOS

Verificar:

- Alteração dos conteúdos da página pública.
- Atualização da secção Sobre Nós.
- Atualização da secção Problema e Solução.
- Atualização da secção Vantagens.
- Atualização da secção Funcionalidades.
- Atualização da secção Contacto.
- Atualização do Rodapé.

====================================================
5. CREDENCIAIS DE ACESSO
====================================================

ADMINISTRADOR

Email:
admin@medinventec.pt

Password:
Adm!2025#Med

Permissões:
- Acesso total à aplicação.

----------------------------------------------------

TÉCNICO

Email:
tecnico@medinventec.pt

Password:
Tec!2025#Hosp

Permissões:
- Gestão de equipamentos.
- Gestão de fornecedores.
- Gestão de localizações.
- Gestão de documentos.
- Gestão de garantias e contratos.
- Dashboard.

----------------------------------------------------

PROFISSIONAL DE SAÚDE

Email:
saude@medinventec.pt

Password:
PfSau!2025#Hosp

Permissões:
- Consulta de equipamentos.
- Dashboard

====================================================
6. INFORMAÇÕES ADICIONAIS
====================================================

- A aplicação utiliza autenticação baseada em perfis
  de utilizador.

- Os equipamentos, fornecedores e localizações utilizam soft delete, preservando os dados na listagem

- Todas as alterações efetuadas aos equipamentos são
  registadas no histórico de movimentações.


